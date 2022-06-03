<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller {

    public function index() {
        $customer = Customer::all();
        return view('master.customer.index', compact('customer'));
    }

    public function create() {
        $car = Car::all();
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        return view('master.customer.create', compact('car', 'carBrand', 'carType'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255', 'id_card' => 'max:255', 'phone' => 'required|max:255', 'address' => 'required|max:500',
            'cars_id' => 'required', 'car_types_id' => 'required', 'car_brands_id' => 'required',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->storeAs('customer-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }
        $validateData['status'] = '1';

        Customer::create($validateData);

        return redirect()->route('customer.index')
                        ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer) {
        return view('master.customer.show', compact('customer'));
    }

    public function edit(Customer $customer) {
        return view('master.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer) {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'id_card' => 'max:255',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image') && request('image') != '') {
            if (!empty($customer->image)) {
                if (Storage::exists($customer->image)) {
                    Storage::delete($customer->image);
                }
            }
            $validateData['image'] = $request->file('image')->storeAs('customer-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $validateData['birth_date'] = (!empty($request->birth_date) ? date('Y-m-d', strtotime($request->birth_date)) : NULL);

        $customer->update($validateData);

        return redirect()->route('customer.index')
                        ->with('success', 'Customer updated successfully');
    }

    public function destroy(Customer $customer) {
        $customer->delete();

        return redirect()->route('customer.index')
                        ->with('success', 'Customer <b>' . $customer->name . '</b> deleted successfully');
    }

}
