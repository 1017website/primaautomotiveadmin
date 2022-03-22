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

class StockController extends Controller {

    public function index() {
        $inventoryStock = InventoryStock::all();
        return view('inventory.stock.index', compact('inventoryStock'));
    }

    public function create() {
        $items = Product::all();
        return view('inventory.stock.create', compact('items'));
    }

    public function store(Request $request) {
        $request->validate([
            'date' => 'required',
            'description' => 'required',
            'Type' => 'required',
        ]);

        InventoryStock::create($request->all());

        return redirect()->route('stock.index')
                        ->with('success', 'Stock added successfully.');
    }

    public function show(InventoryStock $inventoryStock) {
        return view('inventory.stock.show', compact('inventoryStock'));
    }

    public function edit(InventoryStock $inventoryStock) {
        
    }

    public function update(Request $request, InventoryStock $inventoryStock) {
        
    }

    public function destroy(InventoryStock $inventoryStock) {
        
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
            $temp = new InventoryStockDetailTemp();
            $temp->user_id = Auth::id();
            $temp->type = $request['type'];
            $temp->product_id = $request['product_id'];
            $product = Product::findOrFail($request['product_id']);
            $temp->type_product_id = $product->type_product_id;
            $temp->qty = str_replace(',', '.', $request['qty']);
            $temp->price = substr(str_replace('.', '', $request['price']), 3);
            $temp->save();
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
