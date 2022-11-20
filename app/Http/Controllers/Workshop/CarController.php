<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use App\Models\CarImage;
use App\Models\CarImageTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CarController extends Controller {

    public function index() {
        $car = Car::all();
        return view('master.car.index', compact('car'));
    }

    public function create() {
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        $carImages = DB::table('car_image_temps')->where('user_id', Auth::id())->get();

        return view('master.car.create', compact('carBrand', 'carType', 'carImages'));
    }

    public function store(Request $request) {
        $request->validate([
            'car_brand_id' => 'required',
            'car_type_id' => 'required',
            'year' => 'required',
            //'name' => 'required|max:255|unique:cars,name,NULL,id,year,deleted_at,NULL',
            'name' => 'required|max:255',
        ]);

        $car = Car::create($request->all());
        //images
        $carImages = CarImageTemp::where(['user_id' => Auth::id()])->get();
        foreach ($carImages as $images) {
            $imageUpload = new CarImage();
            $imageUpload->car_id = $car->id;
            $imageUpload->image = $images->image;
            $imageUpload->image_url = $images->image_url;
            $imageUpload->size = $images->size;
            $imageUpload->save();
        }
        CarImageTemp::where(['user_id' => Auth::id()])->delete();
        //images

        return redirect()->route('car.index')
                        ->with('success', 'Car created successfully.');
    }

    public function show(Car $car) {
        return view('master.car.show', compact('car'));
    }

    public function edit(Car $car) {
        $carBrand = CarBrand::all();
        $carType = CarType::all();

        //move image to temp
        $carImage = CarImage::where(['car_id' => $car->id])->get();
        foreach ($carImage as $images) {
            $imageUpload = new CarImageTemp();
            $imageUpload->user_id = Auth::id();
            $imageUpload->image = $images->image;
            $imageUpload->image_url = $images->image_url;
            $imageUpload->size = $images->size;
            $imageUpload->save();
        }
        //move image to temp
        $carImages = DB::table('car_image_temps')->where('user_id', Auth::id())->get();

        return view('master.car.edit', compact('car', 'carBrand', 'carType', 'carImages'));
    }

    public function update(Request $request, Car $car) {
        $request->validate([
            'car_brand_id' => 'required',
            'car_type_id' => 'required',
            'year' => 'required',
            //'name' => 'required|max:255|unique:cars,name,' . $car->id . ',id,year,deleted_at,NULL',
            'name' => 'required|max:255',
        ]);

        $car->update($request->all());
        //images
        CarImage::where(['car_id' => $car->id])->delete();
        $carImages = CarImageTemp::where(['user_id' => Auth::id()])->get();
        foreach ($carImages as $images) {
            $imageUpload = new CarImage();
            $imageUpload->car_id = $car->id;
            $imageUpload->image = $images->image;
            $imageUpload->image_url = $images->image_url;
            $imageUpload->size = $images->size;
            $imageUpload->save();
        }
        CarImageTemp::where(['user_id' => Auth::id()])->delete();
        //images

        return redirect()->route('car.index')
                        ->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car) {
        $carImages = CarImage::where(['car_id' => $car->id])->get();
        foreach ($carImages as $images) {
            if (Storage::exists('car-images/' . $images->image)) {
                Storage::delete('car-images/' . $images->image);
            }
            $images->delete();
        }
        $car->delete();

        return redirect()->route('car.index')
                        ->with('success', 'Car <b>' . $car->name . '</b> deleted successfully');
    }

    public function uploadImages(Request $request) {
        $images = $request->file('file');
        foreach ($images as $image) {
            $imageName = $image->getClientOriginalName();
            $imagePic = $image->storeAs('car-images', $imageName);
            $imageUpload = new CarImageTemp();
            $imageUpload->image = $imageName;
            $imageUpload->image_url = asset('storage/car-images/' . $imageName);
            $imageUpload->size = $request->filesize;
            $imageUpload->user_id = Auth::id();
            $imageUpload->save();

            return response()->json(['success' => $imageName]);
        }
    }

    public function deleteImages(Request $request) {
        $filename = $request->get('filename');
        $carImages = CarImageTemp::where(['image' => $filename, 'user_id' => Auth::id()])->first();
        if (Storage::exists('car-images/' . $carImages->image)) {
            Storage::delete('car-images/' . $carImages->image);
        }
        $carImages->delete();

        return $filename;
    }

}
