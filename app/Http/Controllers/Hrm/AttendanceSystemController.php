<?php

namespace App\Http\Controllers\Hrm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mechanic;
use App\Models\Attendance;


class AttendanceSystemController extends Controller
{
    public function importAttendanceSystem()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_attlog';
            $randKey = bin2hex(random_bytes(25));
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "start_date":"' . date('Y-m-d', strtotime(date('Y-m-d'))) . '", "end_date":"' . date('Y-m-d') . '"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'get_attlog', 'request' => $request, 'response' => $response, 'created_at' => date('Y-m-d H:i:s')];
            DB::table('finger_logs')->insert($data);
            //import to system
            $data = (array) json_decode($response);
            $listAttendance = $data['data'];
            if (!empty($listAttendance)) {
                //delete old data
                $whereArray = ['date' => date('Y-m-d', strtotime(date('Y-m-d'))), 'type' => 'finger'];
                $query = DB::table('attendances');
                foreach ($whereArray as $field => $value) {
                    $query->where($field, $value);
                }
                $query->delete();

                foreach ($listAttendance as $r => $v) {
                    $v = (array) $v;
                    $mechanic = Mechanic::where(['id_finger' => $v['pin']])->first();
                    if (isset($mechanic)) {
                        $model = new Attendance();
                        $date = strtotime($v['scan_date']);
                        $model->location = 'Prima Automotive';
                        $model->employee_id = $mechanic->id;
                        $model->finger_id = $v['pin'];
                        $model->date = date('Y-m-d', $date);
                        $model->time = date('H:i:s', $date);
                        //$model->status = ($v['status_scan'] == 0 ? 'in' : 'out');
                        $model->status = date('H:i:s', $date) < '12:00:00' ? 'in' : 'out';
                        $type = "";
                        if ($v['verify'] == 1) {
                            $type = 'finger';
                        } elseif ($v['verify'] == 2) {
                            $type = 'password';
                        } elseif ($v['verify'] == 3) {
                            $type = 'password';
                        } elseif ($v['verify'] == 4) {
                            $type = 'card';
                        } elseif ($v['verify'] == 5) {
                            $type = 'gps';
                        } elseif ($v['verify'] == 6) {
                            $type = 'vein';
                        }
                        $model->type = $type;
                        if (!$model->save()) {
                            $success = false;
                            $message = "Save Failed";
                        }
                    }
                }
            } else {
                $success = false;
                $message = "Attendance empty";
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function importAttendanceSystemShine()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_attlog';
            $randKey = bin2hex(random_bytes(25));
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C262B895032B1C34", "start_date":"' . date('Y-m-d', strtotime(date('Y-m-d'))) . '", "end_date":"' . date('Y-m-d') . '"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'get_attlog', 'request' => $request, 'response' => $response, 'created_at' => date('Y-m-d H:i:s')];
            DB::table('finger_logs')->insert($data);
            //import to system
            $data = (array) json_decode($response);
            $listAttendance = $data['data'];
            if (!empty($listAttendance)) {
                foreach ($listAttendance as $r => $v) {
                    $v = (array) $v;
                    $mechanic = Mechanic::where(['id_finger' => $v['pin']])->first();
                    if (isset($mechanic)) {
                        $date = strtotime($v['scan_date']);
                        $statusCheck = date('H:i:s', $date) < '12:00:00' ? 'in' : 'out';

                        //delete old data
                        $whereArray = ['date' => date('Y-m-d'), 'type' => 'finger', 'employee_id' => $mechanic->id, 'status' => $statusCheck];
                        $query = DB::table('attendances');
                        foreach ($whereArray as $field => $value) {
                            $query->where($field, $value);
                        }
                        $query->delete();

                        //add new data
                        $model = new Attendance();
                        $model->location = 'Shine Barrier';
                        $model->employee_id = $mechanic->id;
                        $model->finger_id = $v['pin'];
                        $model->date = date('Y-m-d', $date);
                        $model->time = date('H:i:s', $date);
                        //$model->status = ($v['status_scan'] == 0 ? 'in' : 'out');
                        $model->status = $statusCheck;
                        $type = "";
                        if ($v['verify'] == 1) {
                            $type = 'finger';
                        } elseif ($v['verify'] == 2) {
                            $type = 'password';
                        } elseif ($v['verify'] == 3) {
                            $type = 'password';
                        } elseif ($v['verify'] == 4) {
                            $type = 'card';
                        } elseif ($v['verify'] == 5) {
                            $type = 'gps';
                        } elseif ($v['verify'] == 6) {
                            $type = 'vein';
                        }
                        $model->type = $type;
                        if (!$model->save()) {
                            $success = false;
                            $message = "Save Failed";
                        }
                    }
                }
            } else {
                $success = false;
                $message = "Attendance empty";
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function importAttendanceSystemRange()
    {
        $success = true;
        $message = "";

        $key = $_GET['key']; //kode akses
        $type = $_GET['type']; //shine or prima
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];

        if (isset($key) && isset($type) && isset($startDate) && isset($endDate)) {
            if ($key !== '1017Website2020') {
                $success = false;
                $message = "Key not valid!";
            }

            if (isset($type) && !in_array($type, ['shine', 'prima'])) {
                $success = false;
                $message = "Type not valid!";
            }

            if ($success) {
                if ($type == 'prima') {
                    $cloudId = 'C2630451071B1E34';
                    $bearerId = 'ASC98HR77NKSYS0O';
                    $location = 'Prima Automotive';
                } else if ($type == 'shine') {
                    $cloudId = 'C262B895032B1C34';
                    $bearerId = 'ASC98HR77NKSYS0O';
                    $location = 'Shine Barrier';
                }

                $start = new \DateTime($startDate);
                $end   = new \DateTime($endDate);
                $end->modify('+1 day'); // supaya end date ikut termasuk dalam loop

                $interval = new \DateInterval('P1D'); // P1D = 1 day
                $period   = new \DatePeriod($start, $interval, $end);

                foreach ($period as $date) {
                    $url = 'https://developer.fingerspot.io/api/get_attlog';
                    $randKey = bin2hex(random_bytes(25));
                    $request = '{"trans_id":"' . $randKey . '", "cloud_id":"' . $cloudId . '", "start_date":"' . $date->format('Y-m-d') . '", "end_date":"' . $date->format('Y-m-d') . '"}';
                    $authorization = "Authorization: Bearer " . $bearerId;

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
                    $data = ['unique_id' => $randKey, 'type' => 'get_attlog', 'request' => $request, 'response' => $response, 'created_at' => date('Y-m-d H:i:s')];
                    DB::table('finger_logs')->insert($data);

                    //import to system
                    $data = (array) json_decode($response);
                    if ($data['success']) {
                        $listAttendance = $data['data'];
                        if (!empty($listAttendance)) {
                            foreach ($listAttendance as $r => $v) {
                                $v = (array) $v;
                                $mechanic = Mechanic::where(['id_finger' => $v['pin']])->first();
                                if (isset($mechanic)) {
                                    $date = strtotime($v['scan_date']);
                                    $statusCheck = date('H:i:s', $date) < '12:00:00' ? 'in' : 'out';

                                    //delete old data
                                    $whereArray = ['date' => date('Y-m-d'), 'type' => 'finger', 'employee_id' => $mechanic->id, 'status' => $statusCheck];
                                    $query = DB::table('attendances');
                                    foreach ($whereArray as $field => $value) {
                                        $query->where($field, $value);
                                    }
                                    $query->delete();

                                    //add new data
                                    $model = new Attendance();
                                    $model->location = $location;
                                    $model->employee_id = $mechanic->id;
                                    $model->finger_id = $v['pin'];
                                    $model->date = date('Y-m-d', $date);
                                    $model->time = date('H:i:s', $date);
                                    $model->status = $statusCheck;
                                    $type = "";
                                    if ($v['verify'] == 1) {
                                        $type = 'finger';
                                    } elseif ($v['verify'] == 2) {
                                        $type = 'password';
                                    } elseif ($v['verify'] == 3) {
                                        $type = 'password';
                                    } elseif ($v['verify'] == 4) {
                                        $type = 'card';
                                    } elseif ($v['verify'] == 5) {
                                        $type = 'gps';
                                    } elseif ($v['verify'] == 6) {
                                        $type = 'vein';
                                    }
                                    $model->type = $type;
                                    if (!$model->save()) {
                                        $success = false;
                                        $message = "Save Failed";
                                    }
                                }
                            }
                        }
                    } else {
                        $success = false;
                        $message = "Attendance empty or API error: " . $data['message'];
                    }
                }
            }
        } else {
            $success = false;
            $message = "Request not found!";
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }
}
