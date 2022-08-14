<?php

namespace App\Http\Controllers;

use App\Models\StoreChasier;
use App\Models\StoreProduct;
use App\Models\StoreCustomer;
use App\Models\StoreChasierDetail;
use App\Models\StoreChasierDetailTemp;
use App\Models\StoreInventoryProduct;
use App\Models\StoreInventoryProductHistory;
use App\Models\InventoryProduct;
use App\Models\InventoryProductHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use PDF;

class StoreChasierController extends Controller {

    public function index() {
        $invoice = StoreChasier::all();
        return view('store.chasier.index', compact('invoice'));
    }

    public function create() {
        $product = StoreInventoryProduct::all();
        $customer = StoreCustomer::all();
        return view('store.chasier.create', compact('product', 'customer'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required|date_format:d-m-Y',
            'description' => 'max:500',
            'cust_phone' => '',
            'dp' => 'required'
        ]);

        $temp = StoreChasierDetailTemp::where('user_id', Auth::id())->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'Product Empty'])->withInput();
        }
        $validateData['total'] = 0;
        foreach ($temp as $row) {
            $validateData['total'] += ($row->qty * $row->product_price);
        }
        if ($request->dp < $validateData['total']) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'Payment must greater or equal to sub Total'])->withInput();
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $validateData['code'] = $this->generateCode(date('Ymd'));
                $validateData['status'] = 1;
                $validateData['status_payment'] = 2;
                $validateData['dp'] = substr(str_replace('.', '', $request->dp), 3);

                if (strlen($validateData['cust_phone']) > 0) {
                    $cust = StoreCustomer::where('phone', $validateData['cust_phone'])->first();
                    if (empty($cust)) {
                        $custData = new StoreCustomer();
                        $custData->name = $request->cust_name;
                        $custData->phone = $request->cust_phone;
                        $custData->id_card = $request->cust_id_card;
                        $custData->address = $request->cust_address;
                        $custData->save();
                        $custId = $custData->id;
                    } else {
                        $custId = $cust->id;
                    }
                    $validateData['cust_id'] = $custId;
                }

                $order = StoreChasier::create($validateData);
                //save header

                foreach ($temp as $row) {
                    //detail
                    $orderDetail = new StoreChasierDetail();
                    $orderDetail->header_id = $order->id;
                    $orderDetail->stock_id = $row->stock_id;
                    $orderDetail->product_id = $row->product_id;
                    $orderDetail->type_product_id = $row->type_product_id;
                    $orderDetail->product_name = $row->product_name;
                    $orderDetail->product_price = $row->product_price;
                    $orderDetail->qty = $row->qty;
                    $saved = $orderDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save detail';
                    }

                    //history
                    $inventoryHistory = new StoreInventoryProductHistory();
                    $inventoryHistory->product_id = $row->product_id;
                    $inventoryHistory->type_product_id = $row->type_product_id;
                    $inventoryHistory->price = $row->product_price;
                    $inventoryHistory->description = 'Chasier ' . $order->code;
                    $inventoryHistory->qty_out = $row->qty;
                    $inventoryHistory->qty_in = 0;
                    $saved = $inventoryHistory->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save inventory product history';
                    }

                    //stock
                    $inventoryStore = StoreInventoryProduct::where(['id' => $row->stock_id])->first();
                    if (isset($inventoryStore)) {
                        $inventoryStore->qty = $inventoryStore->qty - $row->qty;
                        $saved = $inventoryStore->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save inventory product';
                        }
                    }

                    //insert ke stock bengkel
                    if ($request->type == 'internal') {
                        //history
                        $inventoryWorkshop = new InventoryProductHistory();
                        $inventoryWorkshop->product_id = $row->product_id;
                        $inventoryWorkshop->type_product_id = $row->type_product_id;
                        $inventoryWorkshop->price = $row->product_price;
                        $inventoryWorkshop->description = 'Cashier ' . $order->code;
                        $inventoryWorkshop->qty_out = 0;
                        $inventoryWorkshop->qty_in = $row->qty;
                        $saved = $inventoryWorkshop->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save inventory product history';
                        }

                        //stock
                        $inventory = InventoryProduct::where(['product_id' => $row->product_id, 'price' => $row->product_price])->first();
                        if (!isset($inventory)) {
                            $inventory = new InventoryProduct();
                            $inventory->product_id = $row->product_id;
                            $inventory->type_product_id = $row->type_product_id;
                            $inventory->price = $row->product_price;
                            $inventory->qty = $row->qty;
                        } else {
                            $inventory->qty = $inventory->qty + $row->qty;
                        }
                        $saved = $inventory->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save inventory product';
                        }
                    }
                }

                $deleted = StoreChasierDetailTemp::where('user_id', Auth::id())->delete();
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

        return redirect()->route('store-chasier.show', $order->id)->with('success', 'Chasier added successfully.');
    }

    public function show($id) {
        $invoice = StoreChasier::findorfail($id);
        $sisa = 0;
        $date = date('d-m-Y');
        if ($invoice->status_payment == 0) {
            $sisa = $invoice->total;
        } elseif ($invoice->status_payment == 1) {
            $sisa = $invoice->total - $invoice->dp;
        }
        return view('store.chasier.show', compact('invoice', 'sisa', 'date'));
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
            $invoice = StoreChasier::findorfail($request['invoice_id']);
            $dp = substr(str_replace('.', '', $request['dp']), 3);
            if (!empty($invoice->dp)) {
                $dp += $invoice->dp;
            }
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

    public function print($id) {
        $invoice = StoreChasier::findorfail($id);
        return view('store.chasier.print', compact('invoice'));

        $pdf = PDF::loadview('invoice.print', ['invoice' => $invoice]);
        $pdf->setPaper('A5', 'landscape');
        $pdf->render();
        return $pdf->stream();

        //return $pdf->download('Print-'.$invoice->code.'.pdf');
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

    public function detail() {
        $detailItem = StoreChasierDetailTemp::where('user_id', Auth::id())->get();
        return view('store.chasier.detail', compact('detailItem'));
    }

    public function deleteProduct() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = StoreChasierDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function price() {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if (isset($request)) {
            $storeProduct = StoreInventoryProduct::findOrFail($request['product_id']);
            $price = $storeProduct->product->price;
        }

        return json_encode(['price' => $price]);
    }

    public function customer() {
        $request = array_merge($_POST, $_GET);
        $phone = '';
        $address = '';
        $card = '';

        $cust = DB::table('store_customer as a')
                ->selectRaw("
					a.phone as id, a.name as label, a.phone, a.id_card, a.address
				")
                ->whereRaw("a.name like '%" . $request['term'] . "%'")
                ->get();

        return json_encode($cust);
    }

    public function add() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $stock = StoreInventoryProduct::findOrFail($request['stock_id']);
            if ($stock->qty < str_replace(',', '.', $request['qty'])) {
                $success = false;
                $message = 'Insufficient Stock.';
            } else {
                $temp = StoreChasierDetailTemp::where([
                            'user_id' => Auth::id(),
                            'stock_id' => $request['stock_id'],
                            'product_price' => substr(str_replace('.', '', $request['price']), 3)
                        ])->first();
                if (isset($temp)) {
                    $temp->qty = $temp->qty + str_replace(',', '.', $request['qty']);
                    if ($stock->qty < $temp->qty) {
                        $success = false;
                        $message = 'Insufficient Stock.';
                    } else {
                        $temp->save();
                    }
                } else {
                    $temp = new StoreChasierDetailTemp();
                    $temp->stock_id = $request['stock_id'];
                    $product = $stock->product;
                    $temp->user_id = Auth::id();
                    $temp->product_id = $product->id;

                    $temp->type_product_id = $product->type_product_id;
                    $temp->product_name = $product->name;
                    $temp->qty = str_replace(',', '.', $request['qty']);
                    $temp->product_price = substr(str_replace('.', '', $request['price']), 3);
                    $temp->save();
                }
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function barcode() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $product = StoreProduct::where('barcode', $request['barcode'])->first();
        if (isset($product)) {
            $stock = StoreInventoryProduct::where(['product_id' => $product->id])->first();
            if (isset($stock)) {
                try {
                    $temp = StoreChasierDetailTemp::where([
                                'user_id' => Auth::id(),
                                'stock_id' => $stock->id,
                                'product_price' => $stock->price,
                            ])->first();
                    if (isset($temp)) {
                        $temp->qty = $temp->qty + 1;
                        $temp->save();
                    } else {
                        $temp = new StoreChasierDetailTemp();
                        $temp->stock_id = $stock->id;
                        $inv = StoreInventoryProduct::findOrFail($stock->id);
                        $product = $inv->product;
                        $temp->user_id = Auth::id();
                        $temp->product_id = $product->id;

                        $temp->type_product_id = $product->type_product_id;
                        $temp->product_name = $product->name;
                        $temp->qty = 1;
                        $temp->product_price = $stock->price;
                        $temp->save();
                    }
                } catch (\Exception $e) {
                    $success = false;
                    $message = $e->getMessage();
                }
            } else {
                $success = false;
                $message = 'Stock Product Tidak Ada !';
            }
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public static function generateCode($date) {
        $count = StoreChasier::where('code', 'LIKE', '%STR' . $date . '%')->count();
        $n = 0;
        if ($count > 0) {
            $invoice = StoreChasier::where('code', 'LIKE', '%STR' . $date . '%')->orderBy('code', 'DESC')->first();
            $n = (int) substr($invoice->code, -4);
        }
        return (string) 'STR' . $date . sprintf('%04s', ($n + 1));
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

}
