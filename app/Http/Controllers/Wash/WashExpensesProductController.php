<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;
use App\Models\WashExpensesProduct;

class WashExpensesProductController extends Controller
{
    public function index()
    {
        $washExpensesProduct = WashExpensesProduct::all();

        return view('wash.expenses.products.index', compact('washExpensesProduct'));
    }

    public function create()
    {
        return view('wash.expenses.products.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'date' => 'required|date_format:d-m-Y',
            'price' => 'required',
            'stock' => 'required',
            'total' => 'required'
        ]);

        $lastRecord = WashExpensesProduct::orderBy('id', 'desc')->first(); // Replace `YourModel` with your actual model

        if ($lastRecord) {
            $lastCodeNumber = intval(substr($lastRecord->code, -3));
            $newCodeNumber = $lastCodeNumber + 1;
        } else {
            $newCodeNumber = 1;
        }

        $formattedCodeNumber = str_pad($newCodeNumber, 3, '0', STR_PAD_LEFT);

        $validateData['code'] = 'PEM-' . $formattedCodeNumber;
        $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
        $validateData['price'] = substr(str_replace('.', '', $request->price), 3);
        $validateData['total'] = substr(str_replace('.', '', $request->total), 3);
        WashExpensesProduct::create($validateData);

        return redirect()->route('wash-expense-product.index')
            ->with('success', 'Wash Expense Product Spending created successfully.');
    }

}
