<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailTemp;
use App\Models\Service;
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
            'description' => 'max:500',
            'vehicle_document' => 'file|mimes:zip|size:5120'
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
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $order = Order::create($validateData);

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
            return Redirect::back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('order.index')->with('success', 'Order added successfully.');
    }

    public function show($id) {
        $order = Order::findorfail($id);
        return view('order.show', compact('order'));
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

}
