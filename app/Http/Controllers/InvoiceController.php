<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
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
        $invoice = Invoice::findorfail($id);
        return view('invoice.show', compact('invoice'));
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
                $invoice->status = '2';
                $invoice->save();
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function print($id) {
        $invoice = Invoice::findorfail($id);
        return view('invoice.print', compact('invoice'));

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

}
