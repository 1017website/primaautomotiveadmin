<?php

namespace App\Http\Controllers;

use App\Models\InventoryProduct;
use Illuminate\Http\Request;

class InventoryProductController extends Controller {

    public function index() {
        $inventoryProduct = InventoryProduct::all();
        return view('master.inventory_product.index', compact('inventoryProduct'));
    }

    public function create() {
        return view('master.inventory_product.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:type_products,name,NULL,id,deleted_at,NULL',
        ]);

        TypeProduct::create($request->all());

        return redirect()->route('type-product.index')
                        ->with('success', 'Type Product created successfully.');
    }

    public function show(TypeProduct $typeProduct) {
        return view('master.type_product.show', compact('typeProduct'));
    }

    public function edit(TypeProduct $typeProduct) {
        return view('master.type_product.edit', compact('typeProduct'));
    }

    public function update(Request $request, TypeProduct $typeProduct) {
        $request->validate([
            'name' => 'required|max:255|unique:type_products,name,' . $typeProduct->id . ',id,deleted_at,NULL',
        ]);

        $typeProduct->update($request->all());

        return redirect()->route('type-product.index')
                        ->with('success', 'Type Product updated successfully');
    }

    public function destroy(TypeProduct $typeProduct) {
        $typeProduct->delete();

        return redirect()->route('type-product.index')
                        ->with('success', 'Type Product <b>' . $typeProduct->name . '</b> deleted successfully');
    }

}
