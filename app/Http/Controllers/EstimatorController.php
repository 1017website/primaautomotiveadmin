<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\TypeService;
use App\Models\Car;
use App\Models\Service;
use App\Models\EstimatorTemp;
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

}
