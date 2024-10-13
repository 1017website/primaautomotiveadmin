<?php

namespace App\Http\Controllers\Hrm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FingerprintController extends Controller
{

    public function index()
    {
        $success = true;
        $message = "";

        $original_data  = file_get_contents('php://input');
        $decoded_data   = json_decode($original_data, true);
        $encoded_data   = json_encode($decoded_data);

        if (isset($decoded_data['type']) and isset($decoded_data['cloud_id'])) {

            try {
                $type       = $decoded_data['type'];
                $cloud_id   = $decoded_data['cloud_id'];
                $created_at = date('Y-m-d H:i:s');
                $values = array('cloud_id' => $cloud_id, 'type' => $type, 'created_at' => $created_at, 'original_data' => $encoded_data);
                DB::table('t_log')->insert($values);
            } catch (\Exception $e) {
                $success = false;
                $message = $e->getMessage();
            }
        }

        return ['success' => $success, 'message' => $message];
    }
}
