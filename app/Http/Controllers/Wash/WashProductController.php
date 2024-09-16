<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;
use App\Models\WashProduct;

class WashProductController extends Controller
{
    public function index()
    {
        $products = WashProduct::all();
        return view('wash.products.index', compact('products'));
    }

    public function create()
    {
        return view('wash.products.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'selling_price' => 'required',
                'buying_price' => 'required',
                'stock' => 'required'
            ]
        );

        WashProduct::create($request->all());

        return redirect()->route('wash-product.index')->with('success', 'Product created Successfully');
    }

    public function edit(WashProduct $washProduct)
    {
        return view('wash.products.edit', compact('washProduct'));
    }

    public function update(Request $request, WashProduct $washProduct)
    {
        $request->validate([
            'name' => 'required|max:255',
            'selling_price' => 'required',
            'buying_price' => 'required',
            'stock' => 'required'
        ]);

        $washProduct->update($request->all());

        return redirect()->route('wash-product.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(WashProduct $washProduct)
    {
        $washProduct->delete();

        return redirect()->route('wash-product.index')->with('success', 'Product <b>' . $washProduct->name . '</b> deleted successfully');

    }
}
