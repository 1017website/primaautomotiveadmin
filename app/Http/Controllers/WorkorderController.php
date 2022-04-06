<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Mechanic;
use App\Models\Workorder;
use App\Models\WorkorderDetail;
use App\Models\InventoryProduct;
use App\Models\WorkorderDetailTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class WorkorderController extends Controller {

    public function index() {
        $workorder = Workorder::all();
        return view('workorder.index', compact('workorder'));
    }

    public function create() {
        $service = Invoice::all();
        $mechanic = Mechanic::all();

        return view('workorder.create', compact('service', 'mechanic'));
    }

    public function show($id) {
        $workorder = Workorder::findorfail($id);
        return view('workorder.show', compact('workorder'));
    }

    public function edit(Workorder $workorder) {
        $items = InventoryProduct::all();

        return view('workorder.edit', compact('workorder', 'items'));
    }

    public function detailWork() {
        $detailItem = WorkorderDetailTemp::where('user_id', Auth::id())->get();
        return view('workorder.detail', compact('detailItem'));
    }

    public function deleteWork() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = WorkorderDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function getStock() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $stock = InventoryProduct::findorfail($request['stock_id']);
        $qty = $stock->qty;

        return json_encode(['success' => $success, 'message' => $message, 'qty' => $qty]);
    }

}
