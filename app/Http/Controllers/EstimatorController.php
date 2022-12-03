<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\TypeService;
use App\Models\Car;
use App\Models\Service;
use App\Models\EstimatorTemp;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use Session;

class EstimatorController extends Controller {

    public function index() {
        $colors = Color::all();
        $services = TypeService::all();
        $cars = Car::all();

        return view('estimator', compact('colors', 'services', 'cars'));
    }

    public function changeColor() {
        $success = true;
        $message = '';
        $services = [];

        if (isset($_POST['color_id'])) {
            $searchvalue = $_POST['color_id'];
            $servicesModel = DB::table('type_services')
                    ->whereRaw('FIND_IN_SET(?, color_id)', [$searchvalue])
                    ->get();

            $services = [];
            foreach ($servicesModel as $row) {
                $services[] = ['id' => $row->id, 'text' => $row->name];
            }
        } else {
            $success = false;
            $message = 'Invalid value color';
        }

        return json_encode(['success' => $success, 'message' => $message, 'services' => $services]);
    }

    public function showEstimator() {
        $success = true;
        $message = '';
        $view = '';

        if (isset($_POST['color_id']) && isset($_POST['type_service_id']) && isset($_POST['car_id'])) {
            $car = Car::where(['id' => $_POST['car_id']])->first();
            $services = Service::where(['type_service_id' => $_POST['type_service_id']])->get();
            $additionalServices = Service::whereRaw('type_service_id is null')->get();
            $session = Session()->getid();

            return view('estimator-detail', compact('car', 'services', 'session', 'additionalServices'));
        }
    }

    public function detailEstimatorService() {
        $request = array_merge($_POST, $_GET);
        $estimateTime = '';
        $detailOrder = EstimatorTemp::where('session_id', $request['session_id'])->get();

        $totalPanel = 0;
        foreach ($detailOrder as $row) {
            $service = Service::findOrFail($row->service_id);
            $totalPanel += $service->panel;
        }
        if ($totalPanel < 3 && $totalPanel > 0) {
            $estimateTime = 'Estimasi panel selesai dalam 2-3 hari kerja';
        } elseif ($totalPanel < 7 && $totalPanel > 0) {
            $estimateTime = 'Estimasi panel selesai dalam 5-7 hari kerja';
        } elseif ($totalPanel < 11 && $totalPanel > 0) {
            $estimateTime = 'Estimasi panel selesai dalam 7-10 hari kerja';
        } elseif ($totalPanel < 16 && $totalPanel > 0) {
            $estimateTime = 'Estimasi panel selesai dalam 10-14 hari kerja';
        } elseif ($totalPanel > 16) {
            $estimateTime = 'Estimasi panel selesai 28 hari Kerja';
        }

        return view('estimator-detail-service', compact('detailOrder', 'estimateTime'));
    }

    public function priceEstimatorService() {
        $request = array_merge($_POST, $_GET);
        $price = 0;

        if (isset($request)) {
            $service = Service::findOrFail($request['service_id']);
            $price = $service->estimated_costs;
        }

        return json_encode(['price' => $price]);
    }

    public function addEstimatorService() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $service = (!empty($request['service_id']) ? $request['service_id'] : $request['service_additional_id']);

            $temp = EstimatorTemp::where([
                        'session_id' => $request['session_id'],
                        'service_id' => $service,
                    ])->first();
            if (!isset($temp)) {
                $temp = new EstimatorTemp();
                $temp->session_id = $request['session_id'];
                $temp->service_id = $service;
                $service = Service::findOrFail($service);
                $temp->service_name = $service->name;
                $temp->service_price = $service->estimated_costs;
                $temp->service_qty = str_replace('.', '', $request['service_qty']);
                $temp->service_disc = 0;
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

    public function deleteEstimatorService() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = EstimatorTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function order() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $temp = EstimatorTemp::where('session_id', $request['session_id'])->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'Service not found']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                $order = new Order();
                $order->date = (!empty($request['order_date']) ? date('Y-m-d', strtotime($request['order_date'])) : NULL);
                $order->code = $this->generateCode(date('Ymd'));
                $order->cust_name = $request['order_name'];
                $order->cust_address = $request['order_address'];
                $order->cust_phone = $request['order_phone'];
                $order->cars_id = $request['car_id'];
                $car = Car::findOrFail($request['car_id']);
                $order->vehicle_name = $car->name;
                $order->vehicle_brand = $car->brand->name;
                $order->vehicle_type = $car->type->name;
                $order->vehicle_year = $car->year;
                $saved = $order->save();
                if (!$saved) {
                    $success = false;
                    $message = 'Failed save order';
                }

                //save customer if not exist
                if ($order) {
                    $checkCustomer = Customer::where([
                                'cars_id' => $order->cars_id,
                                'car_plate' => $this->clean($order->vehicle_plate),
                            ])->first();
                    if (!isset($checkCustomer)) {
                        $checkCustomer = new Customer();
                        $checkCustomer->name = $order->cust_name;
                        $checkCustomer->cars_id = $order->cars_id;
                        $checkCustomer->phone = $order->cust_phone;
                        $checkCustomer->address = $order->cust_address;
                        $checkCustomer->car_year = $order->vehicle_year;
                        $checkCustomer->car_color = $order->vehicle_color;
                        $checkCustomer->car_plate = $this->clean($order->vehicle_plate);
                        $checkCustomer->status = '1';
                        $saved = $checkCustomer->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save customer';
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
                    $orderDetail->service_total = $row->service_total;
                    $service = Service::where('id', $row->service_id)->first();
                    $orderDetail->panel = isset($service) ? $service->panel : 0;
                    $saved = $orderDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save order detail';
                    }
                }

                $deleted = EstimatorTemp::where('session_id', $request['session_id'])->delete();
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

    private function clean($string) {
        $string = str_replace(' ', '', $string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

}
