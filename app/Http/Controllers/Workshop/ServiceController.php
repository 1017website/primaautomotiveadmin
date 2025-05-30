<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Service;
use App\Models\TypeService;
use Illuminate\Http\Request;

class ServiceController extends Controller {

    public function index() {
        $service = Service::all();
        return view('master.service.index', compact('service'));
    }

    public function create() {
        $typeService = TypeService::all();
        return view('master.service.create', compact('typeService'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            //'name' => 'required|max:255|unique:services,name,NULL,id,deleted_at,NULL',
            'name' => 'required|max:255',
            'type_service_id' => ''
        ]);

        $validateData['estimated_costs'] = substr(str_replace('.', '', $request->estimated_costs), 3);
        $validateData['panel'] = str_replace(',', '.', $request->panel);

        Service::create($validateData);

        return redirect()->route('service.index')
                        ->with('success', 'Service created successfully.');
    }

    public function show(Service $service) {
        return view('master.service.show', compact('service'));
    }

    public function edit(Service $service) {
        $typeService = TypeService::all();
        return view('master.service.edit', compact('service', 'typeService'));
    }

    public function update(Request $request, Service $service) {
        $validateData = $request->validate([
            //'name' => 'required|max:255|unique:services,name,' . $service->id . ',id,deleted_at,NULL',
            'name' => 'required|max:255',
            'type_service_id' => ''
        ]);

        $validateData['estimated_costs'] = substr(str_replace('.', '', $request->estimated_costs), 3);
        $validateData['panel'] = str_replace(',', '.', $request->panel);

        $service->update($validateData);

        return redirect()->route('service.index')
                        ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service) {
        $service->delete();

        return redirect()->route('service.index')
                        ->with('success', 'Service <b>' . $service->name . '</b> deleted successfully');
    }

}
