<?php

namespace App\Http\Controllers;

use App\Models\ExpenseSpending;
use Illuminate\Http\Request;

class ExpenseSpendingController extends Controller {

    public function index() {
        $expenseSpending = ExpenseSpending::orderBy('date')->get();
        return view('expense.spending.index', compact('expenseSpending'));
    }

    public function create() {
        return view('expense.spending.create');
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'description' => 'required|max:500',
            'date' => 'required|date_format:d-m-Y',
            'cost' => 'required',
        ]);
        $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
        $validateData['cost'] = substr(str_replace('.', '', $request->cost), 3);
        ExpenseSpending::create($validateData);

        return redirect()->route('expense-spending.index')
                        ->with('success', 'Spending created successfully.');
    }

    public function show(ExpenseSpending $expenseSpending) {
        
    }

    public function edit(ExpenseSpending $expenseSpending) {
        
    }

    public function update(Request $request, ExpenseSpending $expenseSpending) {
        
    }

    public function destroy(ExpenseSpending $expenseSpending) {
        
    }

}
