<?php

namespace App\Http\Controllers;

use App\Models\StoreInvestment;
use App\Models\StoreSpending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreInvestmentController extends Controller {

    public function index() {
        $storeInvestment = StoreInvestment::all();
        return view('store.investment.index', compact('storeInvestment'));
    }

    public function create() {
        return view('store.investment.create');
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
            $investment = StoreInvestment::create($validateData);

            if ($investment) {
                $credit = round($investment->cost / $investment->shrink);
                for ($x = 1; $x <= $investment->shrink; $x++) {
                    $spending = new StoreSpending();
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

        return redirect()->route('store-investment.index')
                        ->with('success', 'Store Investment created successfully.');
    }

    public function show(StoreInvestment $storeInvestment) {
        
    }

    public function edit(StoreInvestment $storeInvestment) {
        
    }

    public function update(Request $request, StoreInvestment $storeInvestment) {
        
    }

    public function destroy(StoreInvestment $storeInvestment) {
        
    }

}
