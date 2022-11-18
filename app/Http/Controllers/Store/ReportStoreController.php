<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreInventoryProduct;
use App\Models\StoreInventoryProductHistory;
use App\Models\StoreTypeProduct;
use App\Models\StoreChasier;
use App\Models\StoreSpending;

class ReportStoreController extends Controller {

    public function currentStock() {
        $typeProducts = StoreTypeProduct::all();

        return view('store.report.current_stock.index', compact('typeProducts'));
    }

    public function currentStockView() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $model = StoreInventoryProduct::where('status', '1');
        if (isset($request['type_product_id']) && $request['type_product_id'] != 'ALL') {
            $model = $model->where('type_product_id', $request['type_product_id']);
        }
        $models = $model->get();

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('store.report.current_stock.view', compact('models'))->render()
        ];

        return json_encode($data);
    }

    public function historyStock() {
        $typeProducts = StoreTypeProduct::all();

        return view('store.report.history_stock.index', compact('typeProducts'));
    }

    public function historyStockView() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $model = StoreInventoryProductHistory::where('status', '1');
        if (isset($request['type_product_id']) && $request['type_product_id'] != 'ALL') {
            $model = $model->where('type_product_id', $request['type_product_id']);
        }
        if (isset($request['date_1']) && strlen($request['date_1']) > 0) {
            $model = $model->where('created_at', '>=', date('Y-m-d', strtotime($request['date_1'])));
        }
        if (isset($request['date_2']) && strlen($request['date_2']) > 0) {
            $model = $model->where('created_at', '<=', date('Y-m-d', strtotime($request['date_2'])));
        }
        $models = $model->get();

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('store.report.history_stock.view', compact('models'))->render()
        ];

        return json_encode($data);
    }

    public function revenue() {

        return view('store.report.revenue.index');
    }

    public function revenueView() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $model = StoreChasier::whereIn('status', ['1', '2', '3']);
        if (isset($request['date_1']) && strlen($request['date_1']) > 0) {
            $model = $model->where('date', '>=', date('Y-m-d', strtotime($request['date_1'])));
        }
        if (isset($request['date_2']) && strlen($request['date_2']) > 0) {
            $model = $model->where('date', '<=', date('Y-m-d', strtotime($request['date_2'])));
        }
        if (isset($request['type']) && $request['type'] != 'ALL') {
            $model = $model->where('type', '=', $request['type']);
        }
        $models = $model->get();

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('store.report.revenue.view', compact('models'))->render()
        ];

        return json_encode($data);
    }

    public function expense() {

        return view('store.report.expense.index');
    }

    public function expenseView() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $model = StoreSpending::whereIn('status', ['1']);
        if (isset($request['date_1']) && strlen($request['date_1']) > 0) {
            $model = $model->where('date', '>=', date('Y-m-d', strtotime($request['date_1'])));
        }
        if (isset($request['date_2']) && strlen($request['date_2']) > 0) {
            $model = $model->where('date', '<=', date('Y-m-d', strtotime($request['date_2'])));
        }
        $models = $model->get();

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('store.report.expense.view', compact('models'))->render()
        ];

        return json_encode($data);
    }

}
