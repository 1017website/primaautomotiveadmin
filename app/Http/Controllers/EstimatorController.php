<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\TypeService;
use App\Models\Car;
use App\Models\Service;

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

            return view('estimator-detail', compact('car', 'services'));
        }
    }

}
