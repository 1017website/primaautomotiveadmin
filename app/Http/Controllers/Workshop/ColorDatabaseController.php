<?php

namespace App\Http\Controllers\Workshop;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\ColorDatabase;
use App\Models\ColorGroup;
use App\Models\ColorCategory;
use App\Models\CarBrand;

class ColorDatabaseController extends Controller
{
    public function index()
    {
        $colorCode = Color::all();
        $colorGroup = ColorGroup::all();
        $colorCategory = ColorCategory::all();
        $colorDatabase = ColorDatabase::all();
        $carBrand = CarBrand::all();

        return view('master.color_database.index', compact('colorCode', 'colorGroup', 'colorCategory', 'colorDatabase', 'carBrand'));
    }

    public function create()
    {
        $colorCode = Color::all();
        $colorGroup = ColorGroup::all();
        $colorCategory = ColorCategory::all();
        $colorDatabase = ColorDatabase::all();
        $carBrand = CarBrand::all();

        return view('master.color_database.create', compact('colorCode', 'colorGroup', 'colorCategory', 'colorDatabase', 'carBrand'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,NULL,id,deleted_at,NULL',
            'code_price' => 'required|integer',
            'id_color_code' => 'required',
            'id_color_group' => 'required',
            'id_color_category' => 'required',
            'id_car_brands' => 'required'
        ]);

        ColorDatabase::create($request->all());

        return redirect()->route('color-database.index')
            ->with('success', 'Color Database created successfully.');
    }

    public function edit(ColorDatabase $colorDatabase)
    {
        $colorCode = Color::all();
        $colorGroup = ColorGroup::all();
        $colorCategory = ColorCategory::all();
        $carBrand = CarBrand::all();

        return view('master.color_database.edit', compact('colorDatabase', 'colorCode', 'colorGroup', 'colorCategory', 'carBrand'));
    }

    public function update(Request $request, ColorDatabase $colorDatabase)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,' . $colorDatabase->id . ',id,deleted_at,NULL',
            'code_price' => 'required|integer',
            'id_color_code' => 'required',
            'id_color_group' => 'required',
            'id_color_category' => 'required',
            'id_car_brands' => 'required'
        ]);

        $colorDatabase->update($request->all());

        return redirect()->route('color-database.index')
            ->with('success', 'Color updated successfully');
    }

    public function destroy(ColorDatabase $colorDatabase)
    {
        $colorDatabase->delete();

        return redirect()->route('color-database.index')
            ->with('success', 'Color Database <b>' . $colorDatabase->name . '</b> deleted successfully');
    }

    public function getColorGroups()
    {
        $request = array_merge($_POST, $_GET);
        $colorGroup = 0;

        if (isset($request['id_color_code'])) {
            $idColorCode = $request['id_color_code'];
            $color = Color::findOrFail($idColorCode);
            $colorGroup = $color['id_color_group'];

            $colorGroups = ColorGroup::findOrFail($colorGroup);
        }
        return response()->json($colorGroups);
    }

    public function saveMaster()
    {
        $success = true;
        $message = '';
        $html = '';

        if (isset($_POST['value'])) {
            if ($_POST['type'] == 'color') {
                $check = Color::where(['name' => $_POST['value']])->first();

                if (!isset($check)) {
                    $model = new Color();
                    $model->name = $_POST['value'];
                    $model->id_color_group = $_POST['colorGroup'];
                    if (!$model->save()) {
                        $success = false;
                        $message = "Save Failed";
                    } else {
                        $success = true;
                        $message = "Save Success";
                        $html = "<option value='" . $model->id . "'>" . $model->name . "</option>";
                    }
                } else {
                    $success = false;
                    $message = "Color sudah ada";
                }
            }
            if ($_POST['type'] == 'colorGroup') {
                $check = ColorGroup::where(['name' => $_POST['value']])->first();

                if (!isset($check)) {
                    $model = new ColorGroup();
                    $model->name = $_POST['value'];
                    if (!$model->save()) {
                        $success = false;
                        $message = "Save Failed";
                    } else {
                        $success = true;
                        $message = "Save Success";
                        $html = "<option value='" . $model->id . "'>" . $model->name . "</option>";
                    }
                } else {
                    $success = false;
                    $message = "Color sudah ada";
                }
            }
            if ($_POST['type'] == 'colorCategory') {
                $check = ColorCategory::where(['name' => $_POST['value']])->first();

                if (!isset($check)) {
                    $model = new ColorCategory();
                    $model->name = $_POST['value'];
                    $model->cost = $_POST['cost'];
                    if (!$model->save()) {
                        $success = false;
                        $message = "Save Failed";
                    } else {
                        $success = true;
                        $message = "Save Success";
                        $html = "<option value='" . $model->id . "'>" . $model->name . "</option>";
                    }
                } else {
                    $success = false;
                    $message = "Color sudah ada";
                }
            }
        } else {
            $success = false;
            $message = 'Invalid test color';
        }

        return json_encode(['success' => $success, 'message' => $message, 'html' => $html]);
    }
}
