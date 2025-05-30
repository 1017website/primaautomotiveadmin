<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreStock;
use App\Models\StoreStockDetail;
use App\Models\MixingRack;
use App\Models\StoreStockDetailTemp;
use App\Models\StoreInventoryProduct;
use App\Models\StoreInventoryProductHistory;
use App\Models\InventoryRackPaint;
use App\Models\InventoryRackPaintHistory;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class StoreStockController extends Controller {

    public function index() {
        $storeStock = StoreStock::all();
        return view('store.stock.index', compact('storeStock'));
    }

    public function create() {
        $product = StoreProduct::all();
		$mixingRack = MixingRack::all();
        return view('store.stock.create', compact('product','mixingRack'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required',
            'description' => 'required',
			'type' => 'integer'
        ]);

		
        $temp = StoreStockDetailTemp::where('user_id', Auth::id())->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'List item not found']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $stock = StoreStock::create($validateData);

                //get temp
                foreach ($temp as $row) {
                    //detail
                    $stockDetail = new StoreStockDetail();
                    $stockDetail->store_stock_id = $stock->id;
                    $stockDetail->type = $row->type;
                    $stockDetail->product_id = $row->product_id;
                    $stockDetail->type_product_id = $row->type_product_id;
                    $stockDetail->qty = $row->qty;
                    $stockDetail->price = $row->price;
                    $saved = $stockDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save inventory stock detail';
                    }

                    //history
                    $inventoryHistory = new StoreInventoryProductHistory();
                    $inventoryHistory->product_id = $row->product_id;
                    $inventoryHistory->type_product_id = $row->type_product_id;
                    $inventoryHistory->price = $row->price;
                    $inventoryHistory->description = $stock->description;
                    if ($row->type == 'in' && $stock->type == 0) {
                        $inventoryHistory->qty_in = $row->qty;
                        $inventoryHistory->qty_out = 0;
                    } else {
                        $inventoryHistory->qty_out = $row->qty;
                        $inventoryHistory->qty_in = 0;
                    }
                    $saved = $inventoryHistory->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save inventory product history';
                    }

                    //stock
                    $inventory = StoreInventoryProduct::where(['product_id' => $row->product_id, 'price' => $row->price])->first();
                    if (!isset($inventory)) {
                        $inventory = new StoreInventoryProduct();
                        $inventory->product_id = $row->product_id;
                        $inventory->type_product_id = $row->type_product_id;
                        $inventory->price = $row->price;
                        $inventory->qty = $row->qty;
                    } else {
                        if ($row->type == 'in' && $stock->type == 0) {
                            $inventory->qty = $inventory->qty + $row->qty;
                        } else {
                            $inventory->qty = $inventory->qty - $row->qty;
                        }
                    }
                    $saved = $inventory->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save inventory product';
                    }
					
					if($stock->type != 0){
						//history
						$product = StoreProduct::where(['id' => $row->product_id])->first();
						$inventoryHistory = new InventoryRackPaintHistory();
						$inventoryHistory->product_id = $row->product_id;
						$inventoryHistory->rack_id = $stock->type;
						$inventoryHistory->doc_id = $stock->id;
						$inventoryHistory->weight_in = ($product->berat_jenis * $row->qty);
						$inventoryHistory->weight_out = 0;
						
						$saved = $inventoryHistory->save();
						if (!$saved) {
							$success = false;
							$message = 'Failed save history';
						}

						//stock
						$inventory = InventoryRackPaint::where(['product_id' => $row->product_id, 'rack_id' => $stock->type])->first();
						if (!isset($inventory)) {
							$inventory = new InventoryRackPaint();
							$inventory->product_id = $row->product_id;
							$inventory->rack_id = $stock->type;
						}
						$inventory->weight = ($product->berat_jenis * $row->qty);
						$saved = $inventory->save();
						if (!$saved) {
							$success = false;
							$message = 'Failed save stock';
						}
					}
                }

                $deleted = StoreStockDetailTemp::where('user_id', Auth::id())->delete();
                if (!$deleted) {
                    $success = false;
                    $message = 'Failed delete temp';
                }

                if ($success) {
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
                $success = false;
                $message = $e->getMessage();
            }
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('store-stock.index')->with('success', 'Stock added successfully.');
    }

    public function show($id) {
        $storeStock = StoreStock::findorfail($id);
        return view('store.stock.show', compact('storeStock'));
    }

    public function detail() {
        $detailItem = StoreStockDetailTemp::where('user_id', Auth::id())->get();
        return view('store.stock.detail', compact('detailItem'));
    }

    public function add() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = StoreStockDetailTemp::where([
                        'user_id' => Auth::id(),
                        'product_id' => $request['product_id'],
                        'price' => substr(str_replace('.', '', $request['price']), 3)
                    ])->first();
            if (isset($temp)) {
                if ($request['type'] == 'in') {
                    $temp->qty = $temp->qty + str_replace(',', '.', $request['qty']);
                } else {
                    $temp->qty = $temp->qty - str_replace(',', '.', $request['qty']);
                }
                $temp->save();
            } else {
                $temp = new StoreStockDetailTemp();
                $temp->user_id = Auth::id();
                $temp->type = $request['type'];
                $temp->product_id = $request['product_id'];
                $product = StoreProduct::findOrFail($request['product_id']);
                $temp->type_product_id = $product->type_product_id;
                $temp->qty = str_replace(',', '.', $request['qty']);
                $temp->price = substr(str_replace('.', '', $request['price']), 3);
                $temp->save();
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function price() {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if(isset($request)){
           $storeProduct = StoreProduct::findOrFail($request['product_id']);
           $price = $storeProduct->price;
        }
        
        return json_encode(['price' => $price]);
        
    }

    public function delete() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = StoreStockDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

}
