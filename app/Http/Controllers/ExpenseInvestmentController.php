<?php

namespace App\Http\Controllers;

use App\Models\ExpenseInvestment;
use App\Models\ExpenseSpending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseInvestmentController extends Controller {

    public function index() {
        $expenseInvestment = ExpenseInvestment::all();
        return view('expense.investment.index', compact('expenseInvestment'));
    }

    public function create() {
        return view('expense.investment.create');
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'description' => 'required|max:500',
            'date' => 'required|date_format:d-m-Y',
            'cost' => 'required',
            'shrink' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
            $validateData['cost'] = substr(str_replace('.', '', $request->cost), 3);
            $investment = ExpenseInvestment::create($validateData);

            if ($investment) {
                $credit = round($investment->cost / $investment->shrink);
                for ($x = 1; $x <= $investment->shrink; $x++) {
                    $spending = new ExpenseSpending();
                    $spending->investment_id = $investment->id;
                    $spending->description = $investment->description;
                    $spending->date = date('Y-m-d', strtotime("+" . $x . " months", strtotime($investment->date)));
                    $spending->cost = $credit;
                    $saved = $spending->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save spending';
                    }
                }
            }

            if ($success) {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('expense-investment.index')
                        ->with('success', 'Investment created successfully.');
    }

    public function show(ExpenseInvestment $expenseInvestment) {
        
    }

    public function edit(ExpenseInvestment $expenseInvestment) {
        
    }

    public function update(Request $request, ExpenseInvestment $expenseInvestment) {
        
    }

    public function destroy(ExpenseInvestment $expenseInvestment) {
        
    }

}
