<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Color;
use App\Models\ColorGroup;
use Illuminate\Http\Request;

class ColorController extends Controller {

    public function index() {
        $color = Color::all();
        return view('master.color.index', compact('color'));
    }

    public function create() {
        $colorGroup = ColorGroup::all();
        return view('master.color.create', compact('colorGroup'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,NULL,id,deleted_at,NULL',
            'id_color_group' => 'required|integer',
        ]);

        Color::create($request->all());

        return redirect()->route('color.index')
                        ->with('success', 'Color created successfully.');
    }

    public function show(Color $color) {
        return view('master.color.show', compact('color'));
    }

    public function edit(Color $color) {
        $colorGroup = ColorGroup::all();

        return view('master.color.edit', compact('color', 'colorGroup'));
    }

    public function update(Request $request, Color $color) {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,' . $color->id . ',id,deleted_at,NULL',
            'id_color_group' => 'required|integer',
        ]);

        $color->update($request->all());

        return redirect()->route('color.index')
                        ->with('success', 'Color updated successfully');
    }

    public function destroy(Color $color) {
        $color->delete();

        return redirect()->route('color.index')
                        ->with('success', 'Color <b>' . $color->name . '</b> deleted successfully');
    }

}
