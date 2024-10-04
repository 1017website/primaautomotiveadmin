<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;
use App\Models\WashSale;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use App\Models\WashService;
use App\Models\WashProduct;
use App\Models\WashSaleDetail;
use App\Models\WashSaleDetailTemp;
use App\Models\WashSaleProductTemp;
use App\Models\CustomerDetail;
use App\Models\Customer;
use App\Models\WashSaleProduct;
use App\Models\CarProfile;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class WashSalesController extends Controller
{
    public function index()
    {
        $product = WashProduct::all();
        $service = WashService::all();

        $washSale = WashSale::orderBy('code', 'DESC')->get();
        return view('wash.sales.index', compact('washSale', 'product', 'service'));
    }

    public function create()
    {
        $service = WashService::all();
        $car = Car::all();
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        $product = WashProduct::all();
        return view('wash.sales.create', compact('service', 'car', 'product', 'carBrand', 'carType'));
    }

    public function store(Request $request)
    {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required|date_format:d-m-Y',
            'description' => 'max:500',
            'cust_address' => 'required|max:500',
            'cust_name' => 'required|max:255',
            'cars_id' => 'required',
            'vehicle_year' => 'max:255',
            'vehicle_color' => 'max:255',
            'vehicle_plate' => 'required|max:255',
            'cust_phone' => 'required|max:50',
            'vehicle_document' => 'file|mimes:zip,rar,jpg,png,jpeg,pdf,doc,docx|max:5120'
        ]);

        $temp = WashSaleDetailTemp::where('user_id', Auth::id())->get();
        $tempProduct = WashSaleProductTemp::where('user_id', Auth::id())->get();
        $validateData['total'] = 0;
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'Service not found']);
        } else {
            foreach ($temp as $row) {
                $validateData['total'] += (($row->service_qty * $row->service_price) - $row->service_disc);
            }
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                if ($request->file('vehicle_document')) {
                    $uploadImage = Controller::uploadImage($request->file('vehicle_document'), 'images/vehicle_document/', date('YmdHis') . '.' . $request->file('vehicle_document')->getClientOriginalExtension());
                    $validateData['vehicle_document'] = $uploadImage['imgName'];
                    $validateData['vehicle_document_url'] = $uploadImage['imgUrl'];
                }
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $validateData['code'] = $this->generateCode(date('Ymd'));
                $car = Car::findOrFail($request['cars_id']);
                $validateData['vehicle_name'] = $car->name;
                $validateData['vehicle_brand'] = $car->brand->name;
                $validateData['vehicle_type'] = $car->type->name;
                $disc_header = (float) str_replace(',', '.', $request->disc_persen_header) * $validateData['total'] / 100;
                $validateData['disc_persen_header'] = (float) str_replace(',', '.', $request->disc_persen_header);
                $validateData['ppn_persen_header'] = (float) str_replace(',', '.', $request->ppn_persen_header);
                $validateData['total'] -= $disc_header;
                $validateData['disc_header'] = $disc_header;
                $ppn_header = (float) str_replace(',', '.', $request->ppn_persen_header) * $validateData['total'] / 100;
                $validateData['total'] += $ppn_header;
                $validateData['ppn_header'] = $ppn_header;

                $order = WashSale::create($validateData);

                //save customer if not exist
                if ($order) {
                    $checkCar = CustomerDetail::where([
                        'cars_id' => $order->cars_id,
                        'car_plate' => $this->clean($order->vehicle_plate)
                    ])
                        ->first();

                    if (!isset($checkCar)) {
                        $checkCustomer = Customer::where(['phone' => $order->cust_phone])->first();
                        if (!isset($checkCustomer)) {
                            $checkCustomer = new Customer();
                            $checkCustomer->name = $order->cust_name;
                            $checkCustomer->id_card = $order->cust_id_card;
                            $checkCustomer->phone = $order->cust_phone;
                            $checkCustomer->address = $order->cust_address;
                            $checkCustomer->status = '1';
                            $saved = $checkCustomer->save();
                            if (!$saved) {
                                $success = false;
                                $message = 'Failed save customer';
                            }
                        }
                        $checkCar = new CustomerDetail();
                        $checkCar->cars_id = $order->cars_id;
                        $checkCar->customer_id = $checkCustomer->id;
                        $checkCar->car_year = $order->vehicle_year;
                        $checkCar->car_color = $order->vehicle_color;
                        $checkCar->car_plate = $this->clean($order->vehicle_plate);
                        $saved = $checkCar->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save cars';
                        }
                    }
                }

                foreach ($temp as $row) {
                    //detail
                    $orderDetail = new WashSaleDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->service_id = $row->service_id;
                    $orderDetail->service_name = $row->service_name;
                    $orderDetail->service_price = $row->service_price;
                    $orderDetail->service_qty = $row->service_qty;
                    $orderDetail->service_disc = $row->service_disc;
                    $orderDetail->disc_persen = $row->disc_persen;
                    $orderDetail->service_total = $row->service_total;
                    $service = WashService::where('id', $row->service_id)->first();
                    // $orderDetail->panel = isset($service) ? $service->panel : 0;

                    $saved = $orderDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save order detail';
                    } else {
                        $sql = "
                            Replace into car_profile (car_id, service_id)
                            select " . $order->cars_id . ", '" . $row->service_id . "'
                        ";
                        DB::statement($sql);
                    }
                }

                foreach ($tempProduct as $row) {
                    //detail
                    $orderProduct = new WashSaleProduct();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $row->product_id;
                    $orderProduct->product_name = $row->product_name;
                    $orderProduct->product_price = $row->product_price;
                    $orderProduct->product_qty = $row->product_qty;
                    $orderProduct->disc = $row->disc;
                    $orderProduct->disc_persen = $row->disc_persen;
                    $orderProduct->total = $row->total;
                    $saved = $orderProduct->save();

                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save product detail';
                    }
                }

                WashSaleDetailTemp::where('user_id', Auth::id())->delete();
                WashSaleProductTemp::where('user_id', Auth::id())->delete();

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

        return redirect()->route('wash-sale.index')->with('success', 'Order added successfully.');
    }

    public function updateOrder() {
        $success = true;
        $message = "";

        $model = WashSale::where('id', $_POST['id'])->first(); // Order -> Wash Sale
        $temp = WashSaleDetailTemp::where('user_id', Auth::id())->get(); // Order Detail Temp -> Wash Sale Detail Temp
        $tempProduct = WashSaleProductTemp::where('user_id', Auth::id())->get(); // Order Product Temp -> Wash Sale Product Temp
        $model->total = 0;
        if (count($temp) == 0) {
            return json_encode(['success' => false, 'message' => 'Service not found']);
        } else {
            foreach ($temp as $row) {
                $model->total += (($row->service_qty * $row->service_price) - $row->service_disc);
            }
            foreach ($tempProduct as $row) {
                $model->total += (($row->product_qty * $row->product_price) - $row->disc);
            }
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                $model->disc_persen_header = (float) str_replace(',', '.', $_POST['disc_persen_header']);
                $model->disc_header = $model->disc_persen_header * $model->total / 100;
                $model->total -= $model->disc_header;
                $model->ppn_persen_header = (float) str_replace(',', '.', $_POST['ppn_persen_header']);
                $model->ppn_header = $model->ppn_persen_header * $model->total / 100;
                $model->total += $model->ppn_header;

                if ($model->save()) {
                    WashSaleDetail::where('order_id', $model->id)->delete(); // Order Detail -> WashSaleDetail
                    foreach ($temp as $row) {
                        //detail
                        $orderDetail = new WashSaleDetail(); // OrderDetail -> WashSaleDetail
                        $orderDetail->order_id = $model->id;
                        $orderDetail->service_id = $row->service_id;
                        $orderDetail->service_name = $row->service_name;
                        $orderDetail->service_price = $row->service_price;
                        $orderDetail->service_qty = $row->service_qty;
                        $orderDetail->service_disc = $row->service_disc;
                        $orderDetail->disc_persen = $row->disc_persen;
                        $orderDetail->service_total = $row->service_total;
                        // $service = Service::where('id', $row->service_id)->first();
                        // $orderDetail->panel = isset($service) ? $service->panel : 0;

                        $saved = $orderDetail->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save order detail';
                        } else {
                            $sql = "
                                Replace into car_profile (car_id, service_id)
                                select " . $model->cars_id . ", '" . $row->service_id . "'
                            ";
                            DB::statement($sql);
                        }
                    }

                    WashSaleProduct::where('order_id', $model->id)->delete(); // Order Product -> Wash Sale Product
                    foreach ($tempProduct as $row) {
                        //detail
                        $orderProduct = new WashSaleProduct(); // Order Product -> Wash Sale Product
                        $orderProduct->order_id = $model->id;
                        $orderProduct->product_id = $row->product_id;
                        $orderProduct->product_name = $row->product_name;
                        $orderProduct->product_price = $row->product_price;
                        $orderProduct->product_qty = $row->product_qty;
                        $orderProduct->disc = $row->disc;
                        $orderProduct->disc_persen = $row->disc_persen;
                        $orderProduct->total = $row->total;
                        $saved = $orderProduct->save();

                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save product detail';
                        }
                    }
                    WashSaleDetailTemp::where('user_id', Auth::id())->delete(); // Order Detail Temp -> Wash Sale Detail Temp
                    WashSaleProductTemp::where('user_id', Auth::id())->delete(); // Order Product Temp -> Wash Sale Product Temp
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
            return json_encode(['success' => false, 'message' => $message]);
        }
        return json_encode(['success' => true, 'message' => 'Order updated successfully.']);
    }

    public function show($id)
    {
        $order = WashSale::findorfail($id);
        $total = WashSaleDetail::where('order_id', $id)->sum('service_total');
        return view('wash.sales.show', compact('order', 'total'));
    }

    public function profile()
    {
        $request = array_merge($_POST, $_GET);
        $detail = CarProfile::where('car_id', $request['car_id'])->get();

        return view('wash.sales.profile', compact('detail'));
    }

    public function destroy(WashSale $washSale)
    {
        $washSale->status = '0';
        $washSale->save();

        return redirect()->route('wash-sale.index')
            ->with('success', 'Order <b>' . $washSale->code . '</b> deleted successfully');
    }

    public function detailSales()
    {
        $detailSales = WashSaleDetailTemp::where('user_id', Auth::id())->get();

        return view('wash.sales.detail', compact('detailSales'));
    }

    public function detailProduct()
    {
        $detailOrder = WashSaleProductTemp::where('user_id', Auth::id())->get();
        return view('wash.sales.detailProduct', compact('detailOrder'));
    }

    public function addOrderProduct()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);
        $product = WashProduct::find($request['product_id']);

        if (isset($product)) {
            try {

                $temp = WashSaleProductTemp::where([
                    'user_id' => Auth::id(),
                    'product_id' => $request['product_id'],
                ])->first();
                if (!isset($temp)) {
                    $temp = new WashSaleProductTemp();
                    $temp->user_id = Auth::id();
                    $temp->product_id = $request['product_id'];
                    $product = WashProduct::findOrFail($request['product_id']);
                    $temp->product_name = $product->name;
                    $temp->product_price = $product->selling_price;
                    $temp->product_qty = (float) str_replace('.', '', $request['product_qty']);
                    if (strlen($request['disc_persen_product']) > 0) {
                        $temp->disc = round(($product->selling_price * $temp->product_qty) * (float) str_replace(',', '.', $request['disc_persen_product']) / 100);
                        $temp->disc_persen = (float) str_replace(',', '.', $request['disc_persen_product']);
                    } else {
                        $temp->disc = 0;
                        $temp->disc_persen = 0;
                    }

                    $temp->total = ($product->selling_price * $temp->product_qty) - $temp->disc;
                    $temp->save();
                } else {
                    $success = false;
                    $message = 'Product already added';
                }
            } catch (\Exception $e) {
                $success = false;
                $message = $e->getMessage();
            }
        } else {
            $success = false;
            $message = 'Product not found';
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function addOrder()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = WashSaleDetailTemp::where([
                'user_id' => Auth::id(),
                'service_id' => $request['service_id'],
            ])->first();
            if (!isset($temp)) {
                $temp = new WashSaleDetailTemp();
                $temp->user_id = Auth::id();
                $temp->service_id = $request['service_id'];
                $service = WashService::findOrFail($request['service_id']);
                $temp->service_name = $service->name;
                $temp->service_price = $service->cost;
                $temp->service_qty = (float) str_replace('.', '', $request['service_qty']);
                if (strlen($request['disc_persen']) > 0) {
                    $temp->service_disc = round(($service->cost * $temp->service_qty) * (float) str_replace(',', '.', $request['disc_persen']) / 100);
                    $temp->disc_persen = (float) str_replace(',', '.', $request['disc_persen']);
                } else {
                    $temp->service_disc = 0;
                    $temp->disc_persen = 0;
                }

                $temp->service_total = ($service->cost * $temp->service_qty) - $temp->service_disc;
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

    public function addCar()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $car = new car();
            $car->car_brand_id = $request['car_brand_id'];
            $car->car_type_id = $request['car_type_id'];
            $car->name = $request['name'];
            $car->year = $request['year'];
            $car->save();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $car = Car::all();
        $html = '';
        foreach ($car as $row) {
            $html .= "<option value='" . $row->id . "'>" . $row->type->name . ' - ' . $row->brand->name . ' - ' . $row->name . "</option>";
        }
        return $html;
    }

    public function deleteOrder()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = WashSaleDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function deleteOrderProduct()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = WashSaleProductTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function addInvoice()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $order = WashSale::findorfail($request['order_id']);
            $order->status = '2';
            $order->save();

            $invoice = new Invoice();
            $invoice->code = $this->generateCodeInv(date('ymd'));
            $invoice->date = (!empty($request['date']) ? date('Y-m-d', strtotime($request['date'])) : NULL);
            $invoice->order_id = $request['order_id'];
            $total = substr($request['total'], 3);
            $total = str_replace('.', '', $total);
            $invoice->total = $total;
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

    public static function generateCode($date)
    {
        $count = WashSale::where('code', 'LIKE', '%ORD' . $date . '%')->count();
        $n = 0;
        if ($count > 0) {
            $order = WashSale::where('code', 'LIKE', '%ORD' . $date . '%')->orderBy('code', 'DESC')->first();
            $n = (int) substr($order->code, -4);
        }
        return (string) 'ORD' . $date . sprintf('%04s', ($n + 1));
    }

    public static function generateCodeInv($date)
    {
        $count = Invoice::where('code', 'LIKE', '%INV%')->count();
        $n = 0;
        if ($count > 0) {
            $inv = Invoice::where('code', 'LIKE', '%INV%')->orderBy('code', 'DESC')->first();
            $codeInv = explode('-', $inv->code);
            $n = (int) substr($codeInv[0], -4);
        }
        return (string) 'INV' . sprintf('%04s', ($n + 1)) . '-' . $date;
    }

    private function clean($string)
    {
        $string = str_replace(' ', '', $string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public function allDetail()
    {
        WashSaleDetailTemp::where('user_id', Auth::id())->delete();
        $sql = "INSERT INTO wash_sales_detail_temp(user_id,service_id,service_name,service_price,service_qty,service_disc,service_total,disc_persen)
			SELECT " . Auth::id() . ", service_id, service_name, service_price, service_qty, service_disc, service_total, disc_persen 
			FROM wash_sales_detail where order_id = '" . $_GET['id'] . "'
		";
        DB::statement($sql);

        WashSaleProductTemp::where('user_id', Auth::id())->delete();
        $sql = "INSERT INTO wash_sales_product_temp(user_id,product_id,product_name,product_price,product_qty,disc,total,disc_persen)
			SELECT " . Auth::id() . ", product_id, product_name, product_price, product_qty, disc, total, disc_persen FROM wash_sales_product where order_id = '" . $_GET['id'] . "'
		";
        DB::statement($sql);

        $model = WashSale::where('id', $_GET['id'])->first();
        return json_encode(['ppn' => $model->ppn_persen_header, 'disc' => $model->disc_persen_header]);
    }

    public function price()
    {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if (isset($request)) {
            $service = WashService::findOrFail($request['service_id']);
            $price = $service->cost;
        }

        return json_encode(['price' => $price]);
    }

    public function priceProduct()
    {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if (isset($request)) {
            $service = WashProduct::findOrFail($request['product_id']);
            $price = $service->selling_price;

        }

        return json_encode(['price' => $price]);
    }

}
