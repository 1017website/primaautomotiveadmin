<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreTypeProduct;
use Illuminate\Http\Request;

class StoreTypeProductController extends Controller {

    public function index() {
        $storeTypeProduct = StoreTypeProduct::all();
        return view('store.type_product.index', compact('storeTypeProduct'));
    }

    public function create() {
        return view('store.type_product.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:store_type_products,name,NULL,id,deleted_at,NULL',
        ]);

        StoreTypeProduct::create($request->all());

        return redirect()->route('store-type-product.index')
                        ->with('success', 'Type Product created successfully.');
    }

    public function show(StoreTypeProduct $storeTypeProduct) {
        return view('store.type_product.show', compact('storeTypeProduct'));
    }

    public function edit(StoreTypeProduct $storeTypeProduct) {
        return view('store.type_product.edit', compact('storeTypeProduct'));
    }

    public function update(Request $request, TypeProduct $storeTypeProduct) {
        $request->validate([
            'name' => 'required|max:255|unique:type_products,name,' . $storeTypeProduct->id . ',id,deleted_at,NULL',
        ]);

        $storeTypeProduct->update($request->all());

        return redirect()->route('store-type-product.index')
                        ->with('success', 'Type Product updated successfully');
    }

    public function destroy(StoreTypeProduct $storeTypeProduct) {
        $storeTypeProduct->delete();

        return redirect()->route('store-type-product.index')
                        ->with('success', 'Store Type Product <b>' . $storeTypeProduct->name . '</b> deleted successfully');
    }

}
