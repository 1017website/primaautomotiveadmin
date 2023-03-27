<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\PrimerColor;
use App\Models\TypeService;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use App\Models\Service;
use App\Models\Estimator;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\CustomerDetail;
use Session;
use App\Models\Setting;
use PDF;

class EstimatorInternalController extends Controller {

    public function index() {
        $colors = Color::all();
        $services = TypeService::all();
        $cars = Car::all();
		$colorPrimers = PrimerColor::all();
        $carBrand = CarBrand::all();
        $carType = CarType::all();

		$setting = Setting::where('code', env('APP_NAME', 'primaautomotive'))->first();
		
        return view('estimator.estimator', compact('colors', 'services', 'cars','colorPrimers', 'carBrand', 'carType', 'setting'));
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

    public function saveMaster() {
        $success = true;
        $message = '';
        $html = '';

        if (isset($_POST['value'])) {
			if($_POST['type'] == 'primer_color'){
				$check = PrimerColor::where(['name' => $_POST['value']])->first();
				if(!isset($check)){
					$model = new PrimerColor();
					$model->name = $_POST['value'];
					if(!$model->save()){
						$success = false;
						$message = "Save Failed";
					}else{
						$html = "<option value='".$model->id."'>".$model->name."</option>";
					}
				}else{
					$success = false;
					$message = "Color sudah ada";
				}
			}
			if($_POST['type'] == 'color'){
				$check = Color::where(['name' => $_POST['value']])->first();
				if(!isset($check)){
					$model = new Color();
					$model->name = $_POST['value'];
					if(!$model->save()){
						$success = false;
						$message = "Save Failed";
					}else{
						$html = "<option value='".$model->id."'>".$model->name."</option>";
					}
				}else{
					$success = false;
					$message = "Color sudah ada";
				}
			}
			if($_POST['type'] == 'service'){
				$check = TypeService::where(['name' => $_POST['value']])->first();
				if(!isset($check)){
					$model = new TypeService();
					$model->name = $_POST['value'];
					$model->color_id = implode(",",$_POST['color']);
					if(!$model->save()){
						$success = false;
						$message = "Save Failed";
					}else{
						$html = "<option value='".$model->id."'>".$model->name."</option>";
					}
				}else{
					$success = false;
					$message = "Service sudah ada";
				}
			}
			if($_POST['type'] == 'cars'){
				$check = Car::where(['name' => $_POST['value'], 'year' => $_POST['year']])->first();
				if(!isset($check)){
					$model = new Car();
					$model->name = $_POST['value'];
					$model->car_brand_id = $_POST['brand'];
					$model->car_type_id = $_POST['type_car'];
					$model->year = $_POST['year'];
					if(!$model->save()){
						$success = false;
						$message = "Save Failed";
					}else{
						$html = "<option value='".$model->id."'>".$model->name.' '. $model->year ."</option>";
					}
				}else{
					$success = false;
					$message = "Cars sudah ada";
				}
			}
        } else {
            $success = false;
            $message = 'Invalid value color';
        }

        return json_encode(['success' => $success, 'message' => $message, 'html' => $html]);
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

            return view('estimator.estimator-detail', compact('car', 'services', 'session', 'additionalServices'));
        }
    }

    public function detailEstimatorService() {
        $request = array_merge($_POST, $_GET);
        $estimateTime = '';
        $detailOrder = Estimator::where('session_id', $request['session_id'])->get();

		$estimator = Estimator::where('session_id', $request['session_id'])->first();
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

        return view('estimator.estimator-detail-service', compact('detailOrder', 'estimateTime'));
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

            $temp = Estimator::where([
                        'session_id' => $request['session_id'],
                        'service_id' => $service,
                    ])->first();
            if (!isset($temp)) {
                $temp = new Estimator();
                $temp->session_id = $request['session_id'];
                $temp->service_id = $service;
                $service = Service::findOrFail($service);
                $temp->service_name = $service->name;
                $temp->service_price = $service->estimated_costs;
                $temp->service_qty = (float) str_replace('.', '', $request['service_qty']);
				$temp->disc_persen = (float) str_replace(',', '.', $request['disc_persen']);
                $temp->service_disc = ($temp->service_price * $temp->service_qty) * $temp->disc_persen / 100;
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
            $temp = Estimator::findOrFail($request['id']);
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

        $temp = Estimator::where('session_id', $request['session_id'])->get();
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
                    $checkCar = CustomerDetail::where([
                                'cars_id' => $order->cars_id,
                                'car_plate' => $this->clean($order->vehicle_plate)
								])
							->first();
				
                    if (!isset($checkCar)) {
						$checkCustomer = Customer::where([
									'phone' => $order->cust_phone
								])
								->first();
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
                    $orderDetail->service_total = $row->service_total;
                    $service = Service::where('id', $row->service_id)->first();
                    $orderDetail->panel = isset($service) ? $service->panel : 0;
                    $saved = $orderDetail->save();
                    if (!$saved) {
                        $success = false;
                        $message = 'Failed save order detail';
                    }
                }

                // $deleted = Estimator::where('session_id', $request['session_id'])->delete();
                // if (!$deleted) {
                    // $success = false;
                    // $message = 'Failed delete temp';
                // }

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

    public function download($id) {
        ini_set('max_execution_time', 300);
        ini_set("memory_limit", "512M");

        $invoice = Estimator::where('session_id', $id)->get();
        $setting = Setting::where('id', '1')->first();
        
        //view html
        //return view('invoice.download', compact('invoice', 'setting'));

        $pdf = PDF::loadview('estimator.download', ['invoice' => $invoice, 'setting' => $setting]);
        $pdf->render();

        //render
        return $pdf->stream();

        //download
        //return $pdf->download('DOC INV-' . $invoice->code . '.pdf');
    }
}
