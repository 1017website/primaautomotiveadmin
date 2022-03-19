<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockInDetail;
use Illuminate\Http\Request;

class StockInController extends Controller {

    public function index() {
        $stockIn = StockIn::all();
        return view('master.stock_in.index', compact('stockIn'));
    }

    public function create() {
        return view('master.stock_in.create');
    }

    public function store(Request $request) {
        $request->validate([
            'date' => 'required',
            'description' => 'required',
        ]);

        StockIn::create($request->all());

        return redirect()->route('type-product.index')
                        ->with('success', 'Stock In added successfully.');
    }

    public function show(TypeProduct $stockIn) {
        return view('master.stock_in.show', compact('stockIn'));
    }

    public function edit(TypeProduct $stockIn) {
        
    }

    public function update(Request $request, TypeProduct $stockIn) {
        
    }

    public function destroy(TypeProduct $stockIn) {

    }

}
