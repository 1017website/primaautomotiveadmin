<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreProduct;
use App\Models\StoreTypeProduct;
use App\Models\StoreInventoryProduct;
use App\Models\StoreInventoryProductHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use File;

class StoreProductController extends Controller {

    public function index() {
        $storeProduct = StoreProduct::all();
        return view('store.product.index', compact('storeProduct'));
    }

    public function create() {
        $typeProducts = StoreTypeProduct::all();
        return view('store.product.create', compact('typeProducts'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        if (empty($request->barcode)) {
            $request->barcode = time();
        }

		
        $validateData = $request->validate([
            'name' => 'required|max:255|unique:store_products,name,NULL,id,deleted_at,NULL',
            'barcode' => 'required|unique:store_products,barcode,NULL,id,deleted_at,NULL',
            'type_product_id' => 'required',
            'image' => 'image|file|max:2048',
            'document' => 'file|mimes:zip,rar,pdf,doc,docx,xls,xlsx|max:5120',
            'um' => 'required|max:255',
			'berat_jenis'=>'nullable','berat_kemasan'=>'nullable','berat_timbang'=>'nullable'
        ]);

        try {
            DB::beginTransaction();
            if ($request->file('image')) {
                $uploadImage = Controller::uploadImage($request->file('image'), 'images/store-product-images/', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
                $validateData['image'] = $uploadImage['imgName'];
                $validateData['image_url'] = $uploadImage['imgUrl'];
            }
            if ($request->file('document')) {
                $uploadFile = Controller::uploadImage($request->file('document'), 'images/store-product-files/', date('YmdHis') . '.' . $request->file('document')->getClientOriginalExtension());
                $validateData['document'] = $uploadFile['imgName'];
                $validateData['document_url'] = $uploadFile['imgUrl'];
            }
            $validateData['hpp'] = substr(str_replace('.', '', $request->hpp), 3);
            $validateData['price'] = substr(str_replace('.', '', $request->price), 3);
            $validateData['margin_profit'] = str_replace(',', '.', $request->margin_profit);

			$validateData['berat_jenis'] = str_replace(',','.',str_replace('.', '', $request->berat_jenis));
			$validateData['berat_kemasan'] = str_replace(',','.',str_replace('.', '', $request->berat_kemasan));
			$validateData['berat_timbang'] = str_replace(',','.',str_replace('.', '', $request->berat_timbang));
			
            $storeProduct = StoreProduct::create($validateData);
            $qty = str_replace(',', '.', $request->qty);
            if ($qty > 0) {
                $inventoryHistory = new StoreInventoryProductHistory();
                $inventoryHistory->product_id = $storeProduct->id;
                $inventoryHistory->type_product_id = $storeProduct->type_product_id;
                $inventoryHistory->price = $storeProduct->price;
                $inventoryHistory->description = 'Create Product';
                $inventoryHistory->qty_in = $qty;
                $inventoryHistory->qty_out = 0;
                $saved = $inventoryHistory->save();
                if (!$saved) {
                    $success = false;
                    $message = 'Failed save store inventory product history';
                }

                $inventory = StoreInventoryProduct::where(['product_id' => $storeProduct->id, 'price' => $storeProduct->price])->first();
                if (!isset($inventory)) {
                    $inventory = new StoreInventoryProduct();
                    $inventory->product_id = $storeProduct->id;
                    $inventory->type_product_id = $storeProduct->type_product_id;
                    $inventory->price = $storeProduct->price;
                    $inventory->qty = $qty;
                } else {
                    $inventory->qty = $inventory->qty + $qty;
                }
                $saved = $inventory->save();
                if (!$saved) {
                    $success = false;
                    $message = 'Failed save store inventory product';
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

        return redirect()->route('store-product.index')
                        ->with('success', 'Product created successfully.');
    }

    public function show(StoreProduct $storeProduct) {
        return view('store.product.show', compact('storeProduct'));
    }

    public function edit(StoreProduct $storeProduct) {
        $typeProducts = StoreTypeProduct::all();
        return view('store.product.edit', compact('storeProduct', 'typeProducts'));
    }

    public function update(Request $request, StoreProduct $storeProduct) {
        $validateData = $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $storeProduct->id . ',id,deleted_at,NULL',
            'type_product_id' => 'required',
            'image' => 'image|file|max:2048',
            'um' => 'required|max:255',
        ]);

        if ($request->file('image') && request('image') != '') {
            if (!empty($storeProduct->image)) {
                if (File::exists('images/store-customer-images/' . $storeProduct->image)) {
                    File::delete('images/store-customer-images/' . $storeProduct->image);
                }
            }
            $uploadImage = Controller::uploadImage($request->file('image'), 'images/store-product-images/', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
            $validateData['image'] = $uploadImage['imgName'];
            $validateData['image_url'] = $uploadImage['imgUrl'];
        }

        if ($request->file('document') && request('document') != '') {
            if (!empty($storeProduct->document)) {
                if (File::exists('images/store-product-files/' . $storeProduct->document)) {
                    File::delete('images/store-product-files/' . $storeProduct->document);
                }
            }
            $uploadFile = Controller::uploadImage($request->file('document'), 'images/store-product-files/', date('YmdHis') . '.' . $request->file('document')->getClientOriginalExtension());
            $validateData['document'] = $uploadFile['imgName'];
            $validateData['document_url'] = $uploadFile['imgUrl'];
        }

        $validateData['hpp'] = substr(str_replace('.', '', $request->hpp), 3);
        $validateData['price'] = substr(str_replace('.', '', $request->price), 3);
        $validateData['margin_profit'] = str_replace(',', '.', $request->margin_profit);

        $storeProduct->update($validateData);

        return redirect()->route('store-product.index')
                        ->with('success', 'Product updated successfully');
    }

    public function destroy(StoreProduct $storeProduct) {
        $storeProduct->delete();

        return redirect()->route('store-product.index')
                        ->with('success', 'Product <b>' . $storeProduct->name . '</b> deleted successfully');
    }

    public function print($id) {
        $storeProduct = StoreProduct::findorfail($id);
        return view('store.product.print', compact('storeProduct'));
    }

}
