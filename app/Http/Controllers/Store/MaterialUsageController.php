<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Models\MaterialUsage;
use App\Models\Mechanic;
use App\Models\StoreInventoryProduct;
use App\Models\StoreInventoryProductHistory;
use App\Models\StoreProduct;
use App\Models\StoreTypeProduct;
use App\Models\TypeProduct;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class MaterialUsageController extends Controller
{
    public function index()
    {
        $materialUsage = MaterialUsage::all();
        $mechanic = Mechanic::all();

        return view('store.material-usage.index', compact('materialUsage', 'mechanic'));
    }

    public function create()
    {
        $storeProduct = StoreInventoryProduct::whereHas('product', function ($query) {
            $query->whereNull('deleted_at');
        })->get();
        $mechanic = Mechanic::all();
        $typeProduct = StoreTypeProduct::all();

        return view('store.material-usage.create', compact('storeProduct', 'mechanic', 'typeProduct'));
    }

    public function store(Request $request)
    {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'id_product' => 'required',
            'id_mechanic' => 'required',
            'description' => 'nullable|max:500',
            'date' => 'required|date_format:d-m-Y',
            'qty' => 'required|integer',
            'price' => 'required',
            'total' => 'required'
        ]);
        $product_id = $validateData['id_product'];
        $productType = StoreInventoryProduct::findOrFail($product_id);

        try {
            $stock = StoreInventoryProduct::findOrFail($request['id_product']);
            // dd($stock);


            if ($stock->qty < (float) str_replace(',', '.', $request['qty'])) {
                $success = false;
                $message = 'Insufficient Stock.';
            } else {
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $validateData['id_type_product'] = $productType->product->type_product_id;

                // yg aku edit
                $validateData['id_product'] = $stock->product->id;
                $validateData['price'] = substr(str_replace('.', '', $request['price']), 3);
                $validateData['total'] = substr(str_replace('.', '', $request['total']), 3);
                $material_usage = MaterialUsage::create($validateData);

                //history
                $inventoryHistory = new StoreInventoryProductHistory();
                $inventoryHistory->product_id = $validateData['id_product'];
                // dd($material_usage->product->type_product_id);
                $inventoryHistory->type_product_id = $material_usage->product->type_product_id;
                $inventoryHistory->price = $material_usage->price;
                $inventoryHistory->description = 'Material Usage for Mechanic ' . $material_usage->mechanic->name;
                $inventoryHistory->qty_out = $request['qty'];
                $inventoryHistory->qty_in = 0;
                $saved = $inventoryHistory->save();
                if (!$saved) {
                    $success = false;
                    $message = 'Failed save inventory product history';
                }

                //stock
                $inventoryStore = StoreInventoryProduct::where(['id' => $request['id_product']])->first();
                if (isset($inventoryStore)) {
                    $inventoryStore->qty = $inventoryStore->qty - $request['qty'];
                    $saved = $inventoryStore->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save inventory product';
                    }
                }
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('material-usage.index')->with('success', 'Material Usage created successfully.');
    }

    public function price()
    {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if (isset($request)) {
            $storeProduct = StoreInventoryProduct::findOrFail($request['id_product']);
            $price = $storeProduct->price;
        }

        return json_encode(['price' => $price]);
    }

    public function total()
    {
        $request = array_merge($_POST, $_GET);
        $total = 0;

        if (isset($request)) {
            $storeProduct = StoreInventoryProduct::findOrFail($request['id_product']);
            $price = $storeProduct->price;
            $formatPrice = (float) $price;
            $quantity = (int) $request['qty'];
            $total = $formatPrice * $quantity;
        }

        return json_encode(['total' => $total]);
    }
}
