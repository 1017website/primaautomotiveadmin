<?php

namespace App\Http\Controllers;

use App\Models\StoreCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreCustomerController extends Controller {

    public function index() {
        $customer = StoreCustomer::all();
        return view('store.customer.index', compact('customer'));
    }

    public function create() {
        return view('store.customer.create');
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255', 'phone' => 'required|max:255', 'address' => 'required|max:500',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->storeAs('customer-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }
        $validateData['status'] = '1';

        StoreCustomer::create($validateData);

        return redirect()->route('store-customer.index')
                        ->with('success', 'Customer created successfully.');
    }

    public function show($id) {
		$customer = StoreCustomer::findOrFail($id);
        return view('store.customer.show', compact('customer'));
    }

    public function edit($id) {
		$customer = StoreCustomer::findOrFail($id);
        return view('store.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id) {
		$customer = StoreCustomer::findOrFail($id);
        $validateData = $request->validate([
            'name' => 'required|max:255', 'phone' => 'required|max:255', 'address' => 'required|max:500',
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

        $customer->update($validateData);

        return redirect()->route('store-customer.index')
                        ->with('success', 'Customer Store updated successfully');
    }

    public function destroy($id) {
		$customer = StoreCustomer::findOrFail($id);
        $customer->delete();

        return redirect()->route('store-customer.index')
                        ->with('success', 'Customer <b>' . $customer->name . '</b> deleted successfully');
    }

}
