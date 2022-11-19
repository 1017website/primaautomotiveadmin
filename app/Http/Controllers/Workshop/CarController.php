<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarController extends Controller {

    public function index() {
        $car = Car::all();
        return view('master.car.index', compact('car'));
    }

    public function create() {
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        return view('master.car.create', compact('carBrand', 'carType'));
    }

    public function store(Request $request) {
        $request->validate([
            'car_brand_id' => 'required',
            'car_type_id' => 'required',
            'year' => 'required',
            'name' => 'required|max:255|unique:cars,name,NULL,id,deleted_at,NULL',
        ]);

        Car::create($request->all());

        return redirect()->route('car.index')
                        ->with('success', 'Car created successfully.');
    }

    public function show(Car $car) {
        return view('master.car.show', compact('car'));
    }

    public function edit(Car $car) {
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        return view('master.car.edit', compact('car', 'carBrand', 'carType'));
    }

    public function update(Request $request, Car $car) {
        $request->validate([
            'car_brand_id' => 'required',
            'car_type_id' => 'required',
            'year' => 'required',
            'name' => 'required|max:255|unique:cars,name,' . $car->id . ',id,deleted_at,NULL',
        ]);

        $car->update($request->all());

        return redirect()->route('car.index')
                        ->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car) {
        $car->delete();

        return redirect()->route('car.index')
                        ->with('success', 'Car <b>' . $car->name . '</b> deleted successfully');
    }

}
