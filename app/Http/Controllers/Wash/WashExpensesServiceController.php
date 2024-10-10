<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;
use App\Models\WashExpensesService;

class WashExpensesServiceController extends Controller
{
    public function index()
    {
        $washExpensesService = WashExpensesService::all();

        return view('wash.expenses.services.index', compact('washExpensesService'));
    }

    public function create()
    {
        return view('wash.expenses.services.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'description' => 'required|max:500',
            'date' => 'required|date_format:d-m-Y',
            'price' => 'required',
        ]);

        $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
        $validateData['price'] = substr(str_replace('.', '', $request->price), 3);
        WashExpensesService::create($validateData);

        return redirect()->route('wash-expense-service.index')
            ->with('success', 'Wash Expense Service Spending created successfully.');
    }

}
