<?php

namespace App\Http\Controllers\Workshop;

use App\Models\ColorCategory;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorCategoryController extends Controller
{
    public function index()
    {
        $color = ColorCategory::all();
        return view('master.color_category.index', compact('color'));
    }

    public function create()
    {
        return view('master.color_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,NULL,id,deleted_at,NULL',
            'cost' => 'required|numeric|between:0,99.99',
        ]);

        ColorCategory::create($request->all());

        return redirect()->route('color-category.index')
            ->with('success', 'Color Primer created successfully.');
    }

    public function show(Color $color)
    {
        return view('master.color.show', compact('color'));
    }

    public function edit(ColorCategory $ColorCategory)
    {
        return view('master.color_category.edit', compact('ColorCategory'));
    }

    public function update(Request $request, ColorCategory $ColorCategory)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,' . $ColorCategory->id . ',id,deleted_at,NULL',
            'cost' => 'required|numeric|between:0,99.99',
        ]);

        $ColorCategory->update($request->all());

        return redirect()->route('color-category.index')
            ->with('success', 'Color updated successfully');
    }

    public function destroy(ColorCategory $ColorCategory)
    {
        $ColorCategory->delete();

        return redirect()->route('color-category.index')
            ->with('success', 'Color <b>' . $ColorCategory->name . '</b> deleted successfully');
    }

}
