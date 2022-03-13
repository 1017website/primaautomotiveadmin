<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validateData = $request->validate([
            'name' => 'required|max:255|unique:products,name,NULL,id,deleted_at,NULL',
            'type_product_id' => 'required',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->storeAs('product-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }

        Product::create($validateData);

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
            'name' => 'required|max:255|unique:products,name,' . $product->id . ',id,deleted_at,NULL',
            'type_product_id' => 'required',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image') && request('image') != '') {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $validateData['image'] = $request->file('image')->storeAs('product-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $product->update($validateData);

        return redirect()->route('product.index')
                        ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product) {
        $product->delete();
        if (Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        return redirect()->route('product.index')
                        ->with('success', 'Product <b>' . $product->name . '</b> deleted successfully');
    }

}
