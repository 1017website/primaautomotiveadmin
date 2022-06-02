<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller {

    public function index() {
        $car = Car::all();
        return view('master.car.index', compact('car'));
    }

    public function create() {
        return view('master.car.create');
    }

    public function store(Request $request) {
        $request->validate([
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
        return view('master.car.edit', compact('car'));
    }

    public function update(Request $request, Car $car) {
        $request->validate([
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
