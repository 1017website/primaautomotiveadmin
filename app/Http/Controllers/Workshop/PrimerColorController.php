<?php

namespace App\Http\Controllers\Workshop;

use App\Models\PrimerColor;
use Illuminate\Http\Request;

class PrimerColorController extends Controller {

    public function index() {
        $color = PrimerColor::all();
        return view('master.primer_color.index', compact('color'));
    }

    public function create() {
        return view('master.primer_color.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,NULL,id,deleted_at,NULL',
        ]);

        PrimerColor::create($request->all());

        return redirect()->route('primer-color.index')
                        ->with('success', 'Color Primer created successfully.');
    }

    public function show(Color $color) {
        return view('master.color.show', compact('color'));
    }

    public function edit(PrimerColor $PrimerColor) {
        return view('master.primer_color.edit', compact('PrimerColor'));
    }

    public function update(Request $request, PrimerColor $PrimerColor) {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,' . $PrimerColor->id . ',id,deleted_at,NULL',
        ]);

        $PrimerColor->update($request->all());

        return redirect()->route('primer-color.index')
                        ->with('success', 'Color updated successfully');
    }

    public function destroy(PrimerColor $PrimerColor) {
        $PrimerColor->delete();

        return redirect()->route('primer-color.index')
                        ->with('success', 'Color <b>' . $PrimerColor->name . '</b> deleted successfully');
    }

}
