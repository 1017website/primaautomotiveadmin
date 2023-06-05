<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\CustomerDetailTemp;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use File;

class CustomerController extends Controller {

    public function index() {
        $customer = Customer::all();
        return view('master.customer.index', compact('customer'));
    }

    public function create() {
        $car = Car::all();
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        CustomerDetailTemp::where('user_id', Auth::id())->delete();

        return view('master.customer.create', compact('car', 'carBrand', 'carType'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255', 'id_card' => 'max:255', 'phone' => 'required|max:255', 'address' => 'required|max:500',
            'image' => 'image|file|max:2048',
        ]);

        $success = true;
        if ($request->file('image')) {
            $uploadImage = Controller::uploadImage($request->file('image'), 'images/customer-images/', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
            $validateData['image'] = $uploadImage['imgName'];
            $validateData['image_url'] = $uploadImage['imgUrl'];
        }
        $validateData['status'] = '1';

        DB::beginTransaction();
        try {
            $customer = Customer::create($validateData);
            $detailCustomer = CustomerDetailTemp::where('user_id', Auth::id())->get();
            foreach ($detailCustomer as $v) {
                $temp = new CustomerDetail();
                $temp->customer_id = $customer->id;
                $temp->cars_id = $v->cars_id;
                $temp->car_plate = $v->car_plate;
                $temp->car_color = $v->car_color;
                $temp->car_year = $v->car_year;
                $temp->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer) {
        return view('master.customer.show', compact('customer'));
    }

    public function edit(Customer $customer) {
        $car = Car::all();
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        CustomerDetailTemp::where('user_id', Auth::id())->delete();
        foreach ($customer->detail as $v) {
            $temp = new CustomerDetailTemp();
            $temp->customer_id = $v->customer_id;
            $temp->cars_id = $v->cars_id;
            $temp->car_plate = $v->car_plate;
            $temp->car_color = $v->car_color;
            $temp->car_year = $v->car_year;
            $temp->status = $v->status;
            $temp->user_id = Auth::id();
            $temp->save();
        }
        return view('master.customer.edit', compact('car', 'carBrand', 'carType', 'customer'));
    }

    public function update(Request $request, Customer $customer) {
        $validateData = $request->validate([
            'name' => 'required|max:255', 'id_card' => 'max:255', 'phone' => 'required|max:255', 'address' => 'required|max:500',
            'image' => 'image|file|max:2048',
        ]);

        $success = true;
        if ($request->file('image') && request('image') != '') {
            if (!empty($customer->image)) {
                if (File::exists('images/customer-images/' . $customer->image)) {
                    File::delete('images/customer-images/' . $customer->image);
                }
            }
            $uploadImage = Controller::uploadImage($request->file('image'), 'images/customer-images/', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
            $validateData['image'] = $uploadImage['imgName'];
            $validateData['image_url'] = $uploadImage['imgUrl'];
        }
        DB::beginTransaction();
        try {
            $customer->update($validateData);
            $sql = 'DELETE from customer_detail WHERE customer_id = ' . strval($customer->id);
            DB::statement($sql);
            $detailCustomer = CustomerDetailTemp::where('user_id', Auth::id())->get();
            foreach ($detailCustomer as $v) {
                $temp = new CustomerDetail();
                $temp->customer_id = $customer->id;
                $temp->cars_id = $v->cars_id;
                $temp->car_plate = $v->car_plate;
                $temp->car_color = $v->car_color;
                $temp->car_year = $v->car_year;
                $temp->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
    }

    public function customerDetail() {
        if (isset($_GET['view'])) {
            $detailCustomer = CustomerDetail::where('customer_id', $_GET['id'])->get();
        } else {
            $detailCustomer = CustomerDetailTemp::where('user_id', Auth::id())->get();
        }
        return view('master.customer.detail', compact('detailCustomer'));
    }

    public function deleteCustomerCar() {
        CustomerDetailTemp::where('user_id', Auth::id())->where('id', $_POST['id'])->delete();
        $detailCustomer = CustomerDetailTemp::where('user_id', Auth::id())->get();
        return view('master.customer.detail', compact('detailCustomer'));
    }

    public function addCarCustomer() {
        $success = true;

        $temp = new CustomerDetailTemp();
        $temp->customer_id = 0;
        $temp->cars_id = $_POST['cars_id'];
        $temp->car_plate = $_POST['car_plate'];
        $temp->car_color = $_POST['car_color'];
        $temp->car_year = $_POST['car_year'];
        $temp->user_id = Auth::id();
        if (!$temp->save())
            $success = false;

        return json_encode(['success' => $success]);
    }

    public function destroy(Customer $customer) {
        $sql = 'DELETE from customer_detail WHERE customer_id = ' . strval($customer->id);
        DB::statement($sql);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer <b>' . $customer->name . '</b> deleted successfully');
    }

}
