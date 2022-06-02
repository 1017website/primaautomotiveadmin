<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller {

    public function index() {
        $carBrand = CarBrand::all();
        return view('master.car_brand.index', compact('carBrand'));
    }

    public function create() {
        return view('master.car_brand.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:car_brands,name,NULL,id,deleted_at,NULL',
        ]);

        CarBrand::create($request->all());

        return redirect()->route('car-brand.index')
                        ->with('success', 'Car Brand created successfully.');
    }

    public function show(CarBrand $carBrand) {
        return view('master.car_brand.show', compact('carBrand'));
    }

    public function edit(CarBrand $carBrand) {
        return view('master.car_brand.edit', compact('carBrand'));
    }

    public function update(Request $request, CarBrand $carBrand) {
        $request->validate([
            'name' => 'required|max:255|unique:car_brands,name,' . $carBrand->id . ',id,deleted_at,NULL',
        ]);

        $carBrand->update($request->all());

        return redirect()->route('car-brand.index')
                        ->with('success', 'Car Brand updated successfully');
    }

    public function destroy(CarBrand $carBrand) {
        $carBrand->delete();

        return redirect()->route('car-brand.index')
                        ->with('success', 'Car Brand <b>' . $carBrand->name . '</b> deleted successfully');
    }

}
