<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller {

    public function index() {
        $service = Service::all();
        return view('master.service.index', compact('service'));
    }

    public function create() {
        return view('master.service.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:services,name,NULL,id,deleted_at,NULL',
        ]);

        Service::create($request->all());

        return redirect()->route('service.index')
                        ->with('success', 'Service created successfully.');
    }

    public function show(Service $service) {
        return view('master.service.show', compact('service'));
    }

    public function edit(Service $service) {
        return view('master.service.edit', compact('service'));
    }

    public function update(Request $request, Service $service) {
        $request->validate([
            'name' => 'required|max:255|unique:services,name,' . $service->id . ',id,deleted_at,NULL',
        ]);

        $service->update($request->all());

        return redirect()->route('service.index')
                        ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service) {
        $service->delete();

        return redirect()->route('service.index')
                        ->with('success', 'Service <b>' . $service->name . '</b> deleted successfully');
    }

}
