<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use App\Models\InventoryProduct;
use App\Models\InventoryProductHistory;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller {

    public function index() {
        $product = Product::all();
        return view('master.product.index', compact('product'));
    }

    public function create() {
        $typeProducts = TypeProduct::all();
        return view('master.product.create', compact('typeProducts'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'name' => 'required|max:255|unique:products,name,NULL,id,deleted_at,NULL',
            'type_product_id' => 'required',
            'image' => 'image|file|max:2048',
            'document' => 'file|mimes:zip,rar,pdf,doc,docx,xls,xlsx|max:5120',
            'um' => 'required|max:255',
        ]);

        try {
            DB::beginTransaction();
            if ($request->file('image')) {
                $validateData['image'] = $request->file('image')->storeAs('product-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
            }
            $validateData['hpp'] = (float) substr(str_replace('.', '', $request->hpp), 3);
            $validateData['price'] = (float) substr(str_replace('.', '', $request->price), 3);

            $product = Product::create($validateData);
            $qty = str_replace(',', '.', $request->qty);
            if ($qty > 0) {
                $inventoryHistory = new InventoryProductHistory();
                $inventoryHistory->product_id = $product->id;
                $inventoryHistory->type_product_id = $product->type_product_id;
                $inventoryHistory->price = $product->price;
                $inventoryHistory->description = 'Create Product';
                $inventoryHistory->qty_in = $qty;
                $inventoryHistory->qty_out = 0;
                $saved = $inventoryHistory->save();
                if (!$saved) {
                    $success = false;
                    $message = 'Failed save inventory product history';
                }

                $inventory = InventoryProduct::where(['product_id' => $product->id, 'price' => $product->price])->first();
                if (!isset($inventory)) {
                    $inventory = new InventoryProduct();
                    $inventory->product_id = $product->id;
                    $inventory->type_product_id = $product->type_product_id;
                    $inventory->price = $product->price;
                    $inventory->qty = $qty;
                } else {
                    $inventory->qty = $inventory->qty + $qty;
                }
                $saved = $inventory->save();
                if (!$saved) {
                    $success = false;
                    $message = 'Failed save inventory product';
                }
            }
            if ($success) {
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('product.index')
                        ->with('success', 'Product created successfully.');
    }
	
    public function show(Product $product) {
        return view('master.product.show', compact('product'));
    }

    public function edit(Product $product) {
        $typeProducts = TypeProduct::all();
        return view('master.product.edit', compact('product', 'typeProducts'));
    }

    public function update(Request $request, Product $product) {
        $validateData = $request->validate([
            //'name' => 'required|max:255|unique:products,name,' . $product->id . ',id,deleted_at,NULL',
            'name' => 'required|max:255',
            'type_product_id' => 'required',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image') && request('image') != '') {
            if (!empty($product->image)) {
                if (Storage::exists($product->image)) {
                    Storage::delete($product->image);
                }
            }
            $validateData['image'] = $request->file('image')->storeAs('product-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }
        $validateData['hpp'] = substr(str_replace('.', '', $request->hpp), 3);
        $validateData['price'] = substr(str_replace('.', '', $request->price), 3);

        $product->update($validateData);

        return redirect()->route('product.index')
                        ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product) {
        if (strlen($product->image) > 0) {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
        }
        $product->delete();

        return redirect()->route('product.index')
                        ->with('success', 'Product <b>' . $product->name . '</b> deleted successfully');
    }

}
