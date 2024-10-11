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
use App\Models\Service;
use App\Models\CarProfileTmp;
use App\Models\CarProfile;
use Session;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{

    public function index()
    {
        $car = Car::all();
        return view('master.car.index', compact('car'));
    }

    public function create()
    {
        $carBrand = CarBrand::all();
        $carType = CarType::all();
        $carImages = DB::table('car_image_temps')->where('user_id', Auth::id())->get();

        $sql = "
            delete from car_profile_tmp where 
            session_id = '" . Session()->getid() . "'
        ";
        DB::statement($sql);
        $service = Service::whereRaw('deleted_at is null')->get();
        return view('master.car.create', compact('service', 'carBrand', 'carType', 'carImages'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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
                if ($images != '') {
                    $profileImage = $images->image;
                    $imageUrl = $images->image_url;
                    $imageSizes = $images->size;
                }

                $imageUpload = new CarImage();
                $imageUpload->car_id = $car->id;
                $imageUpload->image = $profileImage;
                $imageUpload->image_url = $imageUrl;
                $imageUpload->size = $imageSizes;
                $imageUpload->save();
            }
            CarImageTemp::where(['user_id' => Auth::id()])->delete();
            //images
            $detail = CarProfileTmp::where(['session_id' => Session()->getid()])->get();
            foreach ($detail as $row) {
                $detail = new CarProfile();
                $detail->car_id = $car->id;
                $detail->service_id = $row->service_id;
                $detail->save();
            }

            $sql = "
                delete from car_profile_tmp where 
                session_id = '" . Session()->getid() . "'
            ";
            DB::statement($sql);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('car.index')
            ->with('success', 'Car created successfully.');
    }

    public function show(Car $car)
    {
        return view('master.car.show', compact('car'));
    }

    public function edit(Car $car)
    {
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

        $sql = "
            delete from car_profile_tmp where 
            session_id = '" . Session()->getid() . "'
        ";
        DB::statement($sql);

        $detail = CarProfile::where(['car_id' => $car->id])->get();
        foreach ($detail as $row) {
            $detail = new CarProfileTmp();
            $detail->session_id = Session()->getid();
            $detail->car_id = $car->id;
            $detail->service_id = $row->service_id;
            $detail->save();
        }

        $service = Service::whereRaw('deleted_at is null')->get();

        return view('master.car.edit', compact('service', 'car', 'carBrand', 'carType', 'carImages'));
    }

    public function update(Request $request, Car $car)
    {

        DB::beginTransaction();
        try {
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

            $sql = "
                delete from car_profile where 
                car_id = '" . $car->id . "'
            ";
            DB::statement($sql);

            $detail = CarProfileTmp::where(['session_id' => Session()->getid()])->get();
            foreach ($detail as $row) {
                $detail = new CarProfile();
                $detail->car_id = $car->id;
                $detail->service_id = $row->service_id;
                $detail->save();
            }

            $sql = "
                delete from car_profile_tmp where 
                session_id = '" . Session()->getid() . "'
            ";
            DB::statement($sql);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }
        return redirect()->route('car.index')
            ->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car)
    {
        $carImages = CarImage::where(['car_id' => $car->id])->get();
        foreach ($carImages as $images) {
            if (isset($images)) {
                $imagePath = $images->image_url;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $images->delete();
            }
            $images->delete();
        }
        $car->delete();

        return redirect()->route('car.index')
            ->with('success', 'Car <b>' . $car->name . '</b> deleted successfully');
    }

    public function uploadImages(Request $request)
    {
        $images = $request->file('file');
        foreach ($images as $image) {
            if ($image != '') {
                $destinationPath = 'images/car-images/';
                $profileImage = "carImages" . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
                $imageSizes = $image->getSize();
                $image->move($destinationPath, $profileImage);
            }

            $imageUpload = new CarImageTemp();
            $imageUpload->image = $profileImage;
            $imageUpload->image_url = $destinationPath . $profileImage;
            $imageUpload->size = $imageSizes;
            $imageUpload->user_id = Auth::id();
            $imageUpload->save();

            return response()->json(['success' => $profileImage]);
        }
    }

    public function deleteImages(Request $request)
    {
        $filename = $request->get('filename');
        $carImages = CarImageTemp::where(['image' => $filename, 'user_id' => Auth::id()])->first();

        if (isset($carImages)) {
            $imagePath = $carImages->image_url;

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $carImages->delete();
        }

        return $filename;
    }

    public function detailCar()
    {
        $request = array_merge($_POST, $_GET);
        $detail = CarProfileTmp::where('session_id', Session()->getid())->get();

        return view('master.car.detail', compact('detail'));
    }

    public function addCar()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $sql = "
                Replace into car_profile_tmp(session_id, car_id, service_id)
                select '" . Session()->getid() . "', " . (isset($request['car_id']) ? $request['car_id'] : '0') . ", '" . $request['service_id'] . "'
            ";
            DB::statement($sql);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function deleteCar()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $sql = "
                delete from car_profile_tmp where 
                session_id = '" . Session()->getid() . "' 
                and car_id = " . (isset($request['car_id']) ? $request['car_id'] : '0') . " 
                and service_id = '" . $request['service_id'] . "'
            ";
            DB::statement($sql);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

}
