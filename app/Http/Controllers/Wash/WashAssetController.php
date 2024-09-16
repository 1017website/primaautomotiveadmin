<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;
use App\Models\WashAsset;

class WashAssetController extends Controller
{
    public function index()
    {
        $assets = WashAsset::all();
        return view('wash.assets.index', compact('assets'));
    }

    public function create()
    {
        return view('wash.assets.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'quantity' => 'required|integer'
            ]
        );

        WashAsset::create($request->all());

        return redirect()->route('wash-asset.index')->with('success', 'Asset created Successfully');
    }

    public function edit(WashAsset $washAsset)
    {
        return view('wash.assets.edit', compact('washAsset'));
    }

    public function update(Request $request, WashAsset $washAsset)
    {
        $request->validate([
            'name' => 'required|max:255',
            'quantity' => 'required|integer'
        ]);

        $washAsset->update($request->all());

        return redirect()->route('wash-asset.index')
            ->with('success', 'Asset updated successfully');
    }

    public function destroy(WashAsset $washAsset)
    {
        $washAsset->delete();

        return redirect()->route('wash-asset.index')->with('success', 'Asset <b>' . $washAsset->name . '</b> deleted successfully');
    }
}
