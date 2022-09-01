<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class SettingController extends Controller {

    public function index() {

        $setting = Setting::where('id', '1')->first();

        return view('setting.index', compact('setting'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255', 
            'address' => 'required|max:255',
            'email' => 'required|max:255',
        ]);

        $setting = Setting::where('id', '1')->first();

        if ($setting) {
            $setting->update($validateData);
        } else {
            Setting::create($validateData);
        }

        return redirect()->route('setting.index')->with('success', 'Update successfully.');
    }

}
