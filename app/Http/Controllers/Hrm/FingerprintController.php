<?php

namespace App\Http\Controllers\Hrm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class FingerprintController extends Controller
{

    function rand_char($length)
    {
        $random = bin2hex(random_bytes($length));
        return $random;
    }

    public function callback()
    {
        $success = true;
        $message = "";

        $original_data  = file_get_contents('php://input');
        $decoded_data   = json_decode($original_data, true);
        $encoded_data   = json_encode($decoded_data);

        try {
            $type       = isset($decoded_data['type']) ? $decoded_data['type'] : null;
            $cloud_id   = isset($decoded_data['cloud_id']) ? $decoded_data['cloud_id'] : null;
            $created_at = date('Y-m-d H:i:s');
            $values = ['cloud_id' => $cloud_id, 'type' => $type, 'created_at' => $created_at, 'original_data' => $original_data];
            DB::table('finger_callbacks')->insert($values);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }

    public function getLog()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_attlog';
            $randKey = $this->rand_char(25);
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "start_date":"2024-10-13", "end_date":"2024-10-13"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'get_attlog', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }

    public function getUser()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_userinfo';
            $randKey = $this->rand_char(25);
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "pin":"1"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'get_userinfo', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }

    public function deleteUser()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/delete_userinfo';
            $randKey = $this->rand_char(25);
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "pin":"1"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'delete_user', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }

    public function getUserAll()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_all_pin';
            $randKey = $this->rand_char(25);
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
            $data = ['unique_id' => $randKey, 'type' => 'get_userall', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }

    public function setTimezone()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/set_time';
            $randKey = $this->rand_char(25);
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
            $data = ['unique_id' => $randKey, 'type' => 'set_timezone', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }

    public function restart()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/restart_device';
            $randKey = $this->rand_char(25);
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
            $data = ['unique_id' => $randKey, 'type' => 'restart', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ['success' => $success, 'message' => $message];
    }
}
