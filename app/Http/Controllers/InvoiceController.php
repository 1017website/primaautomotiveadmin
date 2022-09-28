<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Mechanic;
use App\Models\Workorder;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;

class InvoiceController extends Controller {

    public function index() {
        $invoice = Invoice::all();
        return view('invoice.index', compact('invoice'));
    }

    public function create() {
        $order = Order::where('status', '=', '1')->get();
        return view('invoice.create', compact('order'));
    }

    public function store(Request $request) {
        
    }

    public function show($id) {
        $mechanic = Mechanic::all();
        $invoice = Invoice::findorfail($id);
        $sisa = 0;
        $date = date('d-m-Y');
        if ($invoice->status_payment == 0) {
            $sisa = $invoice->total * (30 / 100);
        } elseif ($invoice->status_payment == 1) {
            $sisa = $invoice->total - $invoice->dp;
        }

        $setting = Setting::where('id', '1')->first();
        return view('invoice.show', compact('invoice', 'sisa', 'date', 'mechanic', 'setting'));
    }

    public function destroy(Invoice $invoice) {
        $invoice->status = '0';
        $invoice->save();

        return redirect()->route('invoice.index')
                        ->with('success', 'Order <b>' . $invoice->code . '</b> deleted successfully');
    }

    public function payInvoice() {
        $success = true;
        $message = '';

        $request = array_merge($_POST, $_GET);
        try {
            $invoice = Invoice::findorfail($request['invoice_id']);
            $dp = substr(str_replace('.', '', $request['dp']), 3);
            $dp = $invoice->dp + $dp;
            if ($dp > $invoice->total) {
                $success = false;
                $message = "Payment does not match";
            } elseif ($dp == $invoice->total) {
                $invoice->status_payment = '2';
                $invoice->dp = $dp;
            } else {
                $invoice->status_payment = '1';
                $invoice->dp = $dp;
            }

            if ($success) {
                $invoice->date_dp = (!empty($request['date']) ? date('Y-m-d', strtotime($request['date'])) : NULL);
                $invoice->save();
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function workOrder() {
        $success = true;
        $message = '';

        $request = array_merge($_POST, $_GET);
        try {
            $invoice = Invoice::findorfail($request['invoice_id']);
            $invoice->status = '2';
            $invoice->save();

            $workOrder = new Workorder();
            $workOrder->code = $this->generateCodeWo(date('Ymd'));
            $workOrder->invoice_id = $invoice->id;
            $workOrder->order_id = $invoice->order_id;
            $workOrder->mechanic_id = $request['mechanic_id'];
            $workOrder->date = (!empty($request['date']) ? date('Y-m-d', strtotime($request['date'])) : NULL);
            $workOrder->status = '1';
            $workOrder->save();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $message = $workOrder->id;
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function print($id) {
        $invoice = Invoice::findorfail($id);
        $setting = Setting::where('id', '1')->first();
        return view('invoice.print', compact('invoice', 'setting'));

        $pdf = PDF::loadview('invoice.print', ['invoice' => $invoice]);
        $pdf->setPaper('A5', 'landscape');
        $pdf->render();
        return $pdf->stream();

        //return $pdf->download('Print-'.$invoice->code.'.pdf');
    }

    public function detailInvoice() {
        $request = array_merge($_GET, $_POST);
        $order = Order::findorfail($request['id']);
        return view('invoice.detail', compact('order'));
    }

    public static function generateCode($date) {
        $count = Invoice::where('code', 'LIKE', '%INV' . $date . '%')->count();
        $n = 0;
        if ($count > 0) {
            $invoice = Invoice::where('code', 'LIKE', '%INV' . $date . '%')->orderBy('code', 'DESC')->first();
            $n = (int) substr($invoice->code, -4);
        }
        return (string) 'INV' . $date . sprintf('%04s', ($n + 1));
    }

    public static function generateCodeWo($date) {
        $count = Workorder::where('code', 'LIKE', '%WRK' . $date . '%')->count();
        $n = 0;
        if ($count > 0) {
            $wo = Workorder::where('code', 'LIKE', '%WRK' . $date . '%')->orderBy('code', 'DESC')->first();
            $n = (int) substr($wo->code, -4);
        }
        return (string) 'WRK' . $date . sprintf('%04s', ($n + 1));
    }

    public function voidInvoice() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $user = User::where('is_owner', '1')->first();
        if (!Hash::check($request['password'], $user->password)) {
            $success = false;
            $message = 'Wrong Password !';
        }

        if ($success) {
            DB::beginTransaction();
            try {
                $invoice = Invoice::findorfail($request['invoice_id']);
                $order = Order::findorfail($invoice->order_id);
                OrderDetail::where('order_id', '=', $invoice->order_id)->forcedelete();
                $order->forcedelete();
                $invoice->forcedelete();
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                $success = false;
                $message = $e->getMessage();
            }
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

}
