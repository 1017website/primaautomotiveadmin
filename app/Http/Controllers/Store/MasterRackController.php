<?php

namespace App\Http\Controllers\Store;

use App\Models\MixingRack as MasterRack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use File;

class MasterRackController extends Controller {

    public function index() {
        $master = MasterRack::all();
        return view('store.master-rack.index', compact('master'));
    }

    public function create() {
        return view('store.master-rack.create');
    }

    public function store(Request $request) {
        $success = true;
        $message = "";
		
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:25'
        ]);

        try {
            DB::beginTransaction();
            
            $rack = MasterRack::create($validateData);
            if ($success) {
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('master-rack.index')
                        ->with('success', 'Master created successfully.');
    }
	
    public function edit(MasterRack $masterRack) {
		$mixingRack = $masterRack;
        return view('store.master-rack.edit', compact('mixingRack'));
    }

    public function update(Request $request, MasterRack $MasterRack) {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:25'
        ]);

        $MasterRack->update($validateData);

        return redirect()->route('master-rack.index')
                        ->with('success', 'Master updated successfully');
    }

    public function destroy(MasterRack $MasterRack) {
        $MasterRack->delete();

        return redirect()->route('master-rack.index')
                        ->with('success', 'Master <b>' . $MasterRack->name . '</b> deleted successfully');
    }

    public function print($id) {
        $storeProduct = StoreProduct::findorfail($id);
        return view('store.product.print', compact('storeProduct'));
    }

}
