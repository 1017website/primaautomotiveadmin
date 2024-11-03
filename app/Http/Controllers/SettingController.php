<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

    public function index()
    {

        $setting = Setting::where('code', env('APP_NAME', 'primaautomotive'))->first();

        return view('setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
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

    public function setTimezone()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/set_time';
            $randKey = bin2hex(random_bytes(25));
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "timezone":"Asia/Jakarta"}';
            $authorization = "Authorization: Bearer ASC98HR77NKSYS0O";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = ['unique_id' => $randKey, 'type' => 'set_timezone', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => date('Y-m-d H:i:s')];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function restartFinger()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/restart_device';
            $randKey = bin2hex(random_bytes(25));
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34"}';
            $authorization = "Authorization: Bearer ASC98HR77NKSYS0O";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = ['unique_id' => $randKey, 'type' => 'restart', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => date('Y-m-d H:i:s')];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }
}
