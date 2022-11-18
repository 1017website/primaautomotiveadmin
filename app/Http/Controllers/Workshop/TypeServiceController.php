<?php

namespace App\Http\Controllers\Workshop;

use App\Models\TypeService;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TypeServiceController extends Controller {

    public function index() {
        $typeService = TypeService::all();
        return view('master.type_service.index', compact('typeService'));
    }

    public function create() {
        $color = Color::all();
        return view('master.type_service.create', compact('color'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255|unique:type_services,name,NULL,id,deleted_at,NULL',
        ]);

        $color = isset($_POST['color']) ? $_POST['color'] : [];
        if (empty($color)) {
            return Redirect::back()->withErrors(['msg' => 'Please select color']);
        }

        $validateData['color_id'] = implode(',', $color);

        TypeService::create($validateData);

        return redirect()->route('type-service.index')
                        ->with('success', 'Type Service created successfully.');
    }

    public function show(TypeService $typeService) {
        return view('master.type_service.show', compact('typeService'));
    }

    public function edit(TypeService $typeService) {
        $color = Color::all();
        return view('master.type_service.edit', compact('typeService', 'color'));
    }

    public function update(Request $request, TypeService $typeService) {
        $validateData = $request->validate([
            'name' => 'required|max:255|unique:type_services,name,' . $typeService->id . ',id,deleted_at,NULL',
        ]);

        $color = isset($_POST['color']) ? $_POST['color'] : [];
        if (empty($color)) {
            return Redirect::back()->withErrors(['msg' => 'Please select color']);
        }

        $validateData['color_id'] = implode(',', $color);

        $typeService->update($validateData);

        return redirect()->route('type-service.index')
                        ->with('success', 'Type Service updated successfully');
    }

    public function destroy(TypeService $typeService) {
        $typeService->delete();

        return redirect()->route('type-service.index')
                        ->with('success', 'Type Service <b>' . $typeService->name . '</b> deleted successfully');
    }

}
