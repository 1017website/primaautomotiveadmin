<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailTemp;
use App\Models\Service;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {

    public function index() {
        $order = Order::all();
        return view('order.index', compact('order'));
    }

    public function create() {
        $service = Service::all();
        return view('order.create', compact('service'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required|date_format:d-m-Y',
            'description' => 'max:500', 'cust_address' => 'max:500',
            'cust_name' => 'required|max:255', 'cust_id_card' => 'max:255', 'vehicle_name' => 'required|max:255', 'vehicle_type' => 'required|max:255',
            'vehicle_brand' => 'required|max:255', 'vehicle_year' => 'max:255', 'vehicle_color' => 'max:255', 'vehicle_plate' => 'required|max:255',
            'cust_phone' => 'required|max:50',
            'vehicle_document' => 'file|mimes:zip,rar,jpg,png,jpeg,pdf,doc,docx|max:5120'
        ]);

        $temp = OrderDetailTemp::where('user_id', Auth::id())->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'Service not found']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                if ($request->file('vehicle_document')) {
                    $validateData['vehicle_document'] = $request->file('vehicle_document')->storeAs('order', date('YmdHis') . '.' . $request->file('vehicle_document')->getClientOriginalExtension());
                }
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $validateData['code'] = $this->generateCode(date('Ymd'));
                $order = Order::create($validateData);

                foreach ($temp as $row) {
                    //detail
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->service_id = $row->service_id;
                    $orderDetail->service_name = $row->service_name;
                    $orderDetail->service_price = $row->service_price;
                    $saved = $orderDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save order detail';
                    }
                }

                $deleted = OrderDetailTemp::where('user_id', Auth::id())->delete();
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
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('order.index')->with('success', 'Order added successfully.');
    }

    public function show($id) {
        $order = Order::findorfail($id);
        $total = OrderDetail::where('order_id', $id)->sum('service_price');
        return view('order.show', compact('order', 'total'));
    }

    public function destroy(Order $order) {
        $order->status = '0';
        $order->save();

        return redirect()->route('order.index')
                        ->with('success', 'Order <b>' . $order->code . '</b> deleted successfully');
    }

    public function detailOrder() {
        $detailOrder = OrderDetailTemp::where('user_id', Auth::id())->get();
        return view('order.detail', compact('detailOrder'));
    }

    public function addOrder() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = OrderDetailTemp::where([
                        'user_id' => Auth::id(),
                        'service_id' => $request['service_id'],
                    ])->first();
            if (!isset($temp)) {
                $temp = new OrderDetailTemp();
                $temp->user_id = Auth::id();
                $temp->service_id = $request['service_id'];
                $service = Service::findOrFail($request['service_id']);
                $temp->service_name = $service->name;
                $temp->service_price = $service->estimated_costs;
                $temp->save();
            } else {
                $success = false;
                $message = 'Service already added';
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function deleteOrder() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = OrderDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function addInvoice() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $order = Order::findorfail($request['order_id']);
            $order->status = '2';
            $order->save();

            $invoice = new Invoice();
            $invoice->code = $this->generateCodeInv(date('Ymd'));
            $invoice->date = (!empty($request['date']) ? date('Y-m-d', strtotime($request['date'])) : NULL);
            $invoice->order_id = $request['order_id'];
            $invoice->total = substr(str_replace('.', '', $request['total']), 3);
            $invoice->dp = 0;
            $invoice->status = '1';
            $invoice->status_payment = '0';
            $invoice->save();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $message = $invoice->id;
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public static function generateCode($date) {
        $count = Order::where('code', 'LIKE', '%ORD' . $date . '%')->count();
        $n = 0;
        if ($count > 0) {
            $order = Order::where('code', 'LIKE', '%ORD' . $date . '%')->orderBy('code', 'DESC')->first();
            $n = (int) substr($order->code, -4);
        }
        return (string) 'ORD' . $date . sprintf('%04s', ($n + 1));
    }

    public static function generateCodeInv($date) {
        $count = Invoice::where('code', 'LIKE', '%INV' . $date . '%')->count();
        $n = 0;
        if ($count > 0) {
            $inv = Invoice::where('code', 'LIKE', '%INV' . $date . '%')->orderBy('code', 'DESC')->first();
            $n = (int) substr($inv->code, -4);
        }
        return (string) 'INV' . $date . sprintf('%04s', ($n + 1));
    }

}
