<?php

namespace App\Http\Controllers\Workshop;

use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller {

    public function index() {
        $carType = CarType::all();
        return view('master.car_type.index', compact('carType'));
    }

    public function create() {
        return view('master.car_type.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:car_types,name,NULL,id,deleted_at,NULL',
        ]);

        CarType::create($request->all());

        return redirect()->route('car-type.index')
                        ->with('success', 'Car Type created successfully.');
    }

    public function show(CarType $carType) {
        return view('master.car_type.show', compact('carType'));
    }

    public function edit(CarType $carType) {
        return view('master.car_type.edit', compact('carType'));
    }

    public function update(Request $request, CarType $carType) {
        $request->validate([
            'name' => 'required|max:255|unique:car_types,name,' . $carType->id . ',id,deleted_at,NULL',
        ]);

        $carType->update($request->all());

        return redirect()->route('car-type.index')
                        ->with('success', 'Car Type updated successfully');
    }

    public function destroy(CarType $carType) {
        $carType->delete();

        return redirect()->route('car-type.index')
                        ->with('success', 'Car Type <b>' . $carType->name . '</b> deleted successfully');
    }

}
