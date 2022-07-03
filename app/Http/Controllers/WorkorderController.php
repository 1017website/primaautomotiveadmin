<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Mechanic;
use App\Models\Workorder;
use App\Models\WorkorderDetail;
use App\Models\StoreInventoryProduct;
use App\Models\StoreInventoryProductHistory;
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
        $items = StoreInventoryProduct::all();

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

        $stock = StoreInventoryProduct::findorfail($request['stock_id']);
        $qty = $stock->qty;

        return json_encode(['success' => $success, 'message' => $message, 'qty' => $qty]);
    }

    public function addWork() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = WorkorderDetailTemp::where([
                        'user_id' => Auth::id(),
                        'stock_id' => $request['stock_id'],
                    ])->first();
            if (isset($temp)) {
                $success = false;
                $message = 'Item already exists';
            } else {
                $temp = new WorkorderDetailTemp();
                $temp->user_id = Auth::id();
                $temp->stock_id = $request['stock_id'];
                $stock = StoreInventoryProduct::findOrFail($request['stock_id']);
                $temp->product_id = $stock->product_id;
                $temp->type_product_id = $stock->type_product_id;
                $temp->product_name = $stock->product->name;
                $temp->product_price = $stock->price;
                $temp->qty = $request['qty'];
                $temp->save();
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function update(Request $request, Workorder $workorder) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date_done' => 'required',
            'description' => 'max:500',
            'document' => 'file|mimes:zip,rar,jpg,png,jpeg,pdf,doc,docx|max:5120'
        ]);

        $temp = WorkorderDetailTemp::where('user_id', Auth::id())->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'List item not found']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                if ($request->file('document')) {
                    $validateData['document'] = $request->file('document')->storeAs('workorder', date('YmdHis') . '.' . $request->file('document')->getClientOriginalExtension());
                }
                $validateData['date_done'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $validateData['status'] = '2';
                $workorder->update($validateData);

                $invoice = Invoice::findorfail($workorder->invoice_id);
                $invoice->status = '3';
                $invoice->save();

                $order = Order::findorfail($workorder->order_id);
                $order->status = '4';
                $order->save();

                foreach ($temp as $row) {
                    //detail
                    $orderDetail = new WorkorderDetail();
                    $orderDetail->workorder_id = $workorder->id;
                    $orderDetail->stock_id = $row->stock_id;
                    $orderDetail->product_id = $row->product_id;
                    $orderDetail->type_product_id = $row->type_product_id;
                    $orderDetail->product_name = $row->product_name;
                    $orderDetail->product_price = $row->product_price;
                    $orderDetail->qty = $row->qty;
                    $saved = $orderDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save workorder detail';
                    }

                    //history
                    $inventoryHistory = new StoreInventoryProductHistory();
                    $inventoryHistory->product_id = $row->product_id;
                    $inventoryHistory->type_product_id = $row->type_product_id;
                    $inventoryHistory->price = $row->product_price;
                    $inventoryHistory->description = 'Work Order ' . $workorder->code;
                    $inventoryHistory->qty_out = $row->qty;
                    $inventoryHistory->qty_in = 0;
                    $saved = $inventoryHistory->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save inventory product history';
                    }

                    //stock
                    $inventory = StoreInventoryProduct::where(['product_id' => $row->product_id, 'price' => $row->product_price])->first();
                    if (isset($inventory)) {
                        $inventory->qty = $inventory->qty - $row->qty;
                        $saved = $inventory->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save inventory product';
                        }
                    }
                }

                $deleted = WorkorderDetailTemp::where('user_id', Auth::id())->delete();
                if (!$deleted) {
                    $success = false;
                    $message = 'Failed delete temp';
                }

                if ($success) {
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
                $success = false;
                $message = $e->getMessage();
            }
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('workorder.index')->with('success', 'Work Order successfully done.');
    }

}
