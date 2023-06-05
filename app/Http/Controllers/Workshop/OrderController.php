<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailTemp;
use App\Models\OrderProductTemp;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use App\Models\Customer;
use App\Models\Product;
use App\Models\CarProfile;
use App\Models\OrderProduct;
use App\Models\CustomerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use File;

class OrderController extends Controller {

    public function index() {
        $product = Product::all();
        $service = Service::all();

        $order = Order::orderBy('code', 'DESC')->get();
        return view('order.index', compact('order', 'product', 'service'));
    }

    public function create() {
        $service = Service::all();
        $car = Car::all();
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        $product = Product::all();
        return view('order.create', compact('service', 'car', 'product', 'carBrand', 'carType'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required|date_format:d-m-Y',
            'description' => 'max:500', 'cust_address' => 'required|max:500',
            'cust_name' => 'required|max:255', 'cust_id_card' => 'max:255', 'cars_id' => 'required',
            'vehicle_year' => 'max:255', 'vehicle_color' => 'max:255', 'vehicle_plate' => 'required|max:255',
            'cust_phone' => 'required|max:50',
            'vehicle_document' => 'file|mimes:zip,rar,jpg,png,jpeg,pdf,doc,docx|max:5120'
        ]);

        $temp = OrderDetailTemp::where('user_id', Auth::id())->get();
        $tempProduct = OrderProductTemp::where('user_id', Auth::id())->get();
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

                $order = Order::create($validateData);

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
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->service_id = $row->service_id;
                    $orderDetail->service_name = $row->service_name;
                    $orderDetail->service_price = $row->service_price;
                    $orderDetail->service_qty = $row->service_qty;
                    $orderDetail->service_disc = $row->service_disc;
                    $orderDetail->disc_persen = $row->disc_persen;
                    $orderDetail->service_total = $row->service_total;
                    $service = Service::where('id', $row->service_id)->first();
                    $orderDetail->panel = isset($service) ? $service->panel : 0;

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
                    $orderProduct = new OrderProduct();
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

                OrderDetailTemp::where('user_id', Auth::id())->delete();
                OrderProductTemp::where('user_id', Auth::id())->delete();

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

    public function updateOrder() {
        $success = true;
        $message = "";

        $model = Order::where('id', $_POST['id'])->first();
        $temp = OrderDetailTemp::where('user_id', Auth::id())->get();
        $tempProduct = OrderProductTemp::where('user_id', Auth::id())->get();
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
                    OrderDetail::where('order_id', $model->id)->delete();
                    foreach ($temp as $row) {
                        //detail
                        $orderDetail = new OrderDetail();
                        $orderDetail->order_id = $model->id;
                        $orderDetail->service_id = $row->service_id;
                        $orderDetail->service_name = $row->service_name;
                        $orderDetail->service_price = $row->service_price;
                        $orderDetail->service_qty = $row->service_qty;
                        $orderDetail->service_disc = $row->service_disc;
                        $orderDetail->disc_persen = $row->disc_persen;
                        $orderDetail->service_total = $row->service_total;
                        $service = Service::where('id', $row->service_id)->first();
                        $orderDetail->panel = isset($service) ? $service->panel : 0;

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

                    OrderProduct::where('order_id', $model->id)->delete();
                    foreach ($tempProduct as $row) {
                        //detail
                        $orderProduct = new OrderProduct();
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
                    OrderDetailTemp::where('user_id', Auth::id())->delete();
                    OrderProductTemp::where('user_id', Auth::id())->delete();
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

    public function show($id) {
        $order = Order::findorfail($id);
        $total = OrderDetail::where('order_id', $id)->sum('service_total');
        return view('order.show', compact('order', 'total'));
    }

    public function profile() {
        $request = array_merge($_POST, $_GET);
        $detail = CarProfile::where('car_id', $request['car_id'])->get();

        return view('order.profile', compact('detail'));
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

    public function detailProduct() {
        $detailOrder = OrderProductTemp::where('user_id', Auth::id())->get();
        return view('order.detailProduct', compact('detailOrder'));
    }

    public function addOrderProduct() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);
        $product = Product::find($request['product_id']);

        if (isset($product)) {
            try {

                $temp = OrderProductTemp::where([
                            'user_id' => Auth::id(),
                            'product_id' => $request['product_id'],
                        ])->first();
                if (!isset($temp)) {
                    $temp = new OrderProductTemp();
                    $temp->user_id = Auth::id();
                    $temp->product_id = $request['product_id'];
                    $product = Product::findOrFail($request['product_id']);
                    $temp->product_name = $product->name;
                    $temp->product_price = $product->price;
                    $temp->product_qty = (float) str_replace('.', '', $request['product_qty']);
                    if (strlen($request['disc_persen_product']) > 0) {
                        $temp->disc = round(($product->price * $temp->product_qty) * (float) str_replace(',', '.', $request['disc_persen_product']) / 100);
                        $temp->disc_persen = (float) str_replace(',', '.', $request['disc_persen_product']);
                    } else {
                        $temp->disc = 0;
                        $temp->disc_persen = 0;
                    }

                    $temp->total = ($product->price * $temp->product_qty) - $temp->disc;
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
                $temp->service_qty = (float) str_replace('.', '', $request['service_qty']);
                if (strlen($request['disc_persen']) > 0) {
                    $temp->service_disc = round(($service->estimated_costs * $temp->service_qty) * (float) str_replace(',', '.', $request['disc_persen']) / 100);
                    $temp->disc_persen = (float) str_replace(',', '.', $request['disc_persen']);
                } else {
                    $temp->service_disc = 0;
                    $temp->disc_persen = 0;
                }

                $temp->service_total = ($service->estimated_costs * $temp->service_qty) - $temp->service_disc;
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

    public function addCar() {
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

    public function deleteOrderProduct() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = OrderProductTemp::findOrFail($request['id']);
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
        $count = Invoice::where('code', 'LIKE', '%INV%')->count();
        $n = 0;
        if ($count > 0) {
            $inv = Invoice::where('code', 'LIKE', '%INV%')->orderBy('code', 'DESC')->first();
            $codeInv = explode('-', $inv->code);
            $n = (int) substr($codeInv[0], -4);
        }
        return (string) 'INV' . sprintf('%04s', ($n + 1)) . '-' . $date;
    }

    private function clean($string) {
        $string = str_replace(' ', '', $string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public function allDetail() {
        OrderDetailTemp::where('user_id', Auth::id())->delete();
        $sql = "INSERT INTO order_detail_temp(user_id,service_id,service_name,service_price,service_qty,service_disc,service_total,disc_persen)
			SELECT " . Auth::id() . ", service_id, service_name, service_price, service_qty, service_disc, service_total, disc_persen 
			FROM order_detail where order_id = '" . $_GET['id'] . "'
		";
        DB::statement($sql);

        OrderProductTemp::where('user_id', Auth::id())->delete();
        $sql = "INSERT INTO order_product_temp(user_id,product_id,product_name,product_price,product_qty,disc,total,disc_persen)
			SELECT " . Auth::id() . ", product_id, product_name, product_price, product_qty, disc, total, disc_persen FROM order_product where order_id = '" . $_GET['id'] . "'
		";
        DB::statement($sql);

        $model = Order::where('id', $_GET['id'])->first();
        return json_encode(['ppn' => $model->ppn_persen_header, 'disc' => $model->disc_persen_header]);
    }

    public function price() {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if (isset($request)) {
            $service = Service::findOrFail($request['service_id']);
            $price = $service->estimated_costs;
        }

        return json_encode(['price' => $price]);
    }

}
