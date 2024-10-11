<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class StoreCustomerController extends Controller
{

    public function index()
    {
        $customer = StoreCustomer::all();
        return view('store.customer.index', compact('customer'));
    }

    public function create()
    {
        return view('store.customer.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:500',
            'image' => 'image|file|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/store-customer-images/';
            $profileImage = "storeCustomerImages" . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
            $input['image_url'] = $destinationPath . $profileImage;
        }

        $input['status'] = '1';

        StoreCustomer::create($input);

        return redirect()->route('store-customer.index')->with('success', 'Customer created successfully.');
    }

    public function show($id)
    {
        $customer = StoreCustomer::findOrFail($id);
        return view('store.customer.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = StoreCustomer::findOrFail($id);
        return view('store.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = StoreCustomer::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:500',
            'image' => 'image|file|max:2048',
        ]);

        $input = $request->except(['_token', '_method']);

        if (!empty($customer->image) && $request->hasFile('image')) {
            $imagePath = $customer->image_url;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        if ($image = $request->file('image')) {
            $destinationPath = 'images/store-customer-images/';
            $profileImage = "storeCustomerImages" . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
            $input['image_url'] = $destinationPath . $profileImage;
        } elseif (!$request->hasFile('image') && !$customer->image) {
            unset($input['image_url']);
        }

        $customer->update($input);

        return redirect()->route('store-customer.index')->with('success', 'Customer Store updated successfully');
    }

    public function destroy($id)
    {
        $customer = StoreCustomer::findOrFail($id);

        if (!empty($customer->image)) {
            $imagePath = $customer->image_url;

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $customer->delete();

        return redirect()->route('store-customer.index')->with('success', 'Customer <b>' . $customer->name . '</b> deleted successfully');
    }

}
