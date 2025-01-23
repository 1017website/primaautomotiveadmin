<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Models\MaterialUsageHistory;
use App\Models\MaterialUsage;
use App\Models\StoreTypeProduct;

class MaterialUsageHistoryController extends Controller
{
    public function index()
    {
        $materialUsage = MaterialUsage::all();
        $typeProducts = StoreTypeProduct::all();

        return view('store.material-usage-history.index', compact('materialUsage', 'typeProducts'));
    }

    public function historyMaterialUsage()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $model = MaterialUsage::withTrashed()->get();
        if (isset($request['id_type_product']) && $request['id_type_product'] != 'ALL') {
            $model = $model->where('id_type_product', $request['id_type_product']);
        }
        if (isset($request['date_1']) && strlen($request['date_1']) > 0) {
            $model = $model->where('created_at', '>=', date('Y-m-d', strtotime($request['date_1'])));
        }
        if (isset($request['date_2']) && strlen($request['date_2']) > 0) {
            $model = $model->where('created_at', '<=', date('Y-m-d', strtotime($request['date_2'])));
        }
        $models = $model;

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('store.material-usage-history.view', compact('models'))->render()
        ];

        return json_encode($data);
    }
}
