<?php

namespace App\Http\Controllers;

use App\Models\InventoryProduct;
use App\Models\StoreTypeProduct;

class ReportController extends Controller {

    public function currentStock() {
        $typeProducts = StoreTypeProduct::all();
        
        return view('report.current_stock.index', compact('typeProducts'));
    }

    public function currentStockView() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);
        
        $model = InventoryProduct::where('status', '1');        
        if(isset($request['type_product_id']) && $request['type_product_id'] != 'ALL'){
            $model = $model->where('type_product_id', $request['type_product_id']);
        }        
        $models = $model->get();
        
        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('report.current_stock.view', compact('models'))->render()
        ];
        
        return json_encode($data);
    }

    public function historyStock() {

        return view('report.current_stock.index');
    }

    public function historyStockView() {

        return view('report.current_stock.view');
    }

    public function revenue() {

        return view('report.revenue.index');
    }

    public function revenueView() {

        return view('report.revenue.view');
    }

    public function expense() {

        return view('report.expense.index');
    }

    public function expenseView() {

        return view('report.expense.view');
    }

}
