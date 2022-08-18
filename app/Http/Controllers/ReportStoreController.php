<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportStoreController extends Controller {

    public function currentStock() {

        return view('store.report.current_stock.index');
    }

    public function currentStockView() {

        return view('store.report.current_stock.view');
    }

    public function historyStock() {

        return view('store.report.current_stock.index');
    }

    public function historyStockView() {

        return view('store.report.current_stock.view');
    }

    public function revenue() {

        return view('store.report.revenue.index');
    }

    public function revenueView() {

        return view('store.report.revenue.view');
    }

    public function expense() {

        return view('store.report.expense.index');
    }

    public function expenseView() {

        return view('store.report.expense.view');
    }

}
