<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;
use App\Models\WashService;

class WashServiceController extends Controller
{
    public function index()
    {
        $services = WashService::all();
        return view('wash.services.index', compact('services'));
    }

    public function create()
    {
        return view('wash.services.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'cost' => 'required'
            ]
        );

        WashService::create($request->all());

        return redirect()->route('wash-service.index')->with('success', 'Service created Successfully');
    }

    public function edit(WashService $washService)
    {
        return view('wash.services.edit', compact('washService'));
    }

    public function update(Request $request, WashService $washService)
    {
        $request->validate([
            'name' => 'required|max:255',
            'cost' => 'required'
        ]);

        $washService->update($request->all());

        return redirect()->route('wash-service.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(WashService $washService)
    {
        $washService->delete();

        return redirect()->route('wash-service.index')->with('success', 'Service <b>' . $washService->name . '</b> deleted successfully');

    }
}
