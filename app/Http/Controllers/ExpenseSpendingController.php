<?php

namespace App\Http\Controllers;

use App\Models\ExpenseSpending;
use Illuminate\Http\Request;

class ExpenseSpendingController extends Controller {

    public function index() {
        $expenseSpending = ExpenseSpending::all();
        return view('expense.spending.index', compact('expenseSpending'));
    }

    public function create() {
        return view('expense.spending.create');
    }

    public function store(Request $request) {
        $request->validate([
            'description' => 'required|max:500',
            'date' => 'required|date_format:d-m-Y',
        ]);

        ExpenseSpending::create($request->all());

        return redirect()->route('expense-spending.index')
                        ->with('success', 'Spending created successfully.');
    }

    public function show(ExpenseSpending $expenseSpending) {
        return view('expense.spending.show', compact('expenseSpending'));
    }

    public function edit(ExpenseSpending $expenseSpending) {
        
    }

    public function update(Request $request, ExpenseSpending $expenseSpending) {

    }

    public function destroy(ExpenseSpending $expenseSpending) {

    }

}
