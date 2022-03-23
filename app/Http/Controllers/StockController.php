<?php

namespace App\Http\Controllers;

use App\Models\InventoryStock;
use App\Models\InventoryStockDetail;
use App\Models\InventoryStockDetailTemp;
use App\Models\InventoryProduct;
use App\Models\InventoryProductHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class StockController extends Controller {

    public function index() {
        $inventoryStock = InventoryStock::all();
        return view('inventory.stock.index', compact('inventoryStock'));
    }

    public function create() {
        $items = Product::all();
        //$temp = InventoryStockDetailTemp::where('user_id', Auth::id())->delete();
        return view('inventory.stock.create', compact('items'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required',
            'description' => 'required',
        ]);

        $temp = InventoryStockDetailTemp::where('user_id', Auth::id())->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'List item not found']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $stock = InventoryStock::create($validateData);

                //get temp
                foreach ($temp as $row) {
                    //detail
                    $stockDetail = new InventoryStockDetail();
                    $stockDetail->inventory_stock_id = $stock->id;
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
                    $inventoryHistory = new InventoryProductHistory();
                    $inventoryHistory->product_id = $row->product_id;
                    $inventoryHistory->type_product_id = $row->type_product_id;
                    $inventoryHistory->price = $row->price;
                    $inventoryHistory->description = $stock->description;
                    if ($row->type == 'in') {
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
                    $inventory = InventoryProduct::where(['product_id' => $row->product_id, 'price' => $row->price])->first();
                    if (!isset($inventory)) {
                        $inventory = new InventoryProduct();
                        $inventory->product_id = $row->product_id;
                        $inventory->type_product_id = $row->type_product_id;
                        $inventory->price = $row->price;
                        $inventory->qty = $row->qty;
                    } else {
                        if ($row->type == 'in') {
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
                }

                $deleted = InventoryStockDetailTemp::where('user_id', Auth::id())->delete();
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

        return redirect()->route('stock.index')->with('success', 'Stock added successfully.');
    }

    public function show($id) {
        $inventoryStock = InventoryStock::findorfail($id);
        return view('inventory.stock.show', compact('inventoryStock'));
    }

    public function detailItem() {
        $detailItem = InventoryStockDetailTemp::where('user_id', Auth::id())->get();
        return view('inventory.stock.detail', compact('detailItem'));
    }

    public function addItem() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = InventoryStockDetailTemp::where([
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
                $temp = new InventoryStockDetailTemp();
                $temp->user_id = Auth::id();
                $temp->type = $request['type'];
                $temp->product_id = $request['product_id'];
                $product = Product::findOrFail($request['product_id']);
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

    public function deleteItem() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = InventoryStockDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

}
