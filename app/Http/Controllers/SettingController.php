<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class SettingController extends Controller {

    public function index() {

        $setting = Setting::where('code', env('APP_NAME', 'primaautomotive'))->first();

        return view('setting.index', compact('setting'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'code' => 'required|max:255',
            'backend_url' => 'max:255',
            'frontend_url' => 'max:255',
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|max:255',
			'disclaimer' => 'max:255',
        ]);

        $validateData['target_panel'] = str_replace(',', '.', $request->target_panel);
        $validateData['target_revenue'] = substr(str_replace('.', '', $request->target_revenue), 3);
        $validateData['bonus_panel'] = substr(str_replace('.', '', $request->bonus_panel), 3);
        
        $setting = Setting::where('code', env('APP_NAME', 'primaautomotive'))->first();
        if ($setting) {
            $setting->update($validateData);
        } else {
            Setting::create($validateData);
        }

        return redirect()->route('setting.index')->with('success', 'Update successfully.');
    }

}
