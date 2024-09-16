<?php

namespace App\Http\Controllers\Workshop;

use Illuminate\Http\Request;
use App\Models\ColorGroup;

class ColorGroupController extends Controller
{
    public function index()
    {
        $color_group = ColorGroup::all();
        return view('master.color_group.index', compact('color_group'));
    }

    public function create()
    {
        return view('master.color_group.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|unique:colors,name, NULL,id,deleted_at,NULL',
            ]
        );

        ColorGroup::create($request->all());

        return redirect()->route('color-group.index')->with('success', 'Color Group created Successfully');
    }

    public function show(ColorGroup $ColorGroup)
    {
        return view('master.color_group.show', compact('ColorGroup'));
    }

    public function edit(ColorGroup $ColorGroup)
    {
        return view('master.color_group.edit', compact('ColorGroup'));
    }

    public function update(Request $request, ColorGroup $ColorGroup)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,' . $ColorGroup->id . ',id,deleted_at,NULL',
        ]);

        $ColorGroup->update($request->all());

        return redirect()->route('color-group.index')
            ->with('success', 'Color Group updated successfully');
    }

    public function destroy(ColorGroup $ColorGroup)
    {
        $ColorGroup->delete();

        return redirect()->route('color-group.index')
            ->with('success', 'Color <b>' . $ColorGroup->name . '</b> deleted successfully');
    }
}
