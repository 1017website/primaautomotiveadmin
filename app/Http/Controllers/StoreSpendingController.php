<?php

namespace App\Http\Controllers;

use App\Models\StoreSpending;
use Illuminate\Http\Request;

class StoreSpendingController extends Controller {

    public function index() {
        $storeSpending = StoreSpending::orderBy('date')->get();
        return view('store.spending.index', compact('storeSpending'));
    }

    public function create() {
        return view('store.spending.create');
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'description' => 'required|max:500',
            'date' => 'required|date_format:d-m-Y',
            'cost' => 'required',
        ]);
        $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
        $validateData['cost'] = substr(str_replace('.', '', $request->cost), 3);
        StoreSpending::create($validateData);

        return redirect()->route('store-spending.index')
                        ->with('success', 'Spending created successfully.');
    }

    public function show(StoreSpending $storeSpending) {
        
    }

    public function edit(StoreSpending $storeSpending) {
        
    }

    public function update(Request $request, StoreSpending $storeSpending) {
        
    }

    public function destroy(StoreSpending $storeSpending) {
        
    }

}
