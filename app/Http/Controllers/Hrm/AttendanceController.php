<?php

namespace App\Http\Controllers\Hrm;

use App\Models\Attendance;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{

    public function index()
    {
        return view('hrm.attendance.index');
    }

    public function data(Request $request)
    {
        $columns = [
            'attendances.location',
            'employees.name',
            'attendances.date',
            'attendances.time',
            'attendances.status',
            'attendances.type',
        ];

        $query = Attendance::query();
        $total = $query->count();
        $query->leftJoinSub(Mechanic::select('id', 'name'), 'employees', 'employees.id', '=', 'attendances.employee_id');

        $filtered = $total;
        $search = $request->input('search.value');
        if (is_string($search) && trim($search) !== '') {
            $formattedDate = $query->getConnection()->getDriverName() === 'sqlite'
                ? "strftime('%d-%m-%Y', attendances.date)"
                : "DATE_FORMAT(attendances.date, '%d-%m-%Y')";
            $searchColumns = [...$columns, $formattedDate, "COALESCE(employees.name, '-')"];

            preg_match_all('/"[^"]+"|\S+/u', mb_substr($search, 0, 200), $terms);
            foreach ($terms[0] as $term) {
                $pattern = '%' . strtr(mb_strtolower(trim($term, '"')), ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
                $query->where(function ($query) use ($searchColumns, $pattern) {
                    foreach ($searchColumns as $column) {
                        $query->orWhereRaw("LOWER($column) LIKE ? ESCAPE '!'", [$pattern]);
                    }
                });
            }
            $filtered = $query->count();
        }

        foreach (array_slice((array) $request->input('order', []), 0, count($columns)) as $order) {
            $column = filter_var($order['column'] ?? null, FILTER_VALIDATE_INT);
            if ($column !== false && isset($columns[$column])) {
                $direction = ($order['dir'] ?? null) === 'desc' ? 'desc' : 'asc';
                $query->orderBy($columns[$column], $direction);
            }
        }

        $start = max(0, filter_var($request->input('start'), FILTER_VALIDATE_INT) ?: 0);
        $length = min(100, max(1, filter_var($request->input('length'), FILTER_VALIDATE_INT) ?: 10));
        $rows = $query->orderByDesc('attendances.id')
            ->offset($start)
            ->limit($length)
            ->get(['attendances.id', ...$columns])
            ->map(fn (Attendance $row) => [
                'location' => ucfirst($row->location ?? ''),
                'employee' => $row->name ?? '-',
                'date' => $row->date ? date('d-m-Y', strtotime($row->date)) : '',
                'time' => $row->time ?? '',
                'status' => ucfirst($row->status ?? ''),
                'type' => ucfirst($row->type ?? ''),
                'delete_url' => route('attendance.destroy', $row->id),
            ]);

        return response()->json([
            'draw' => filter_var($request->input('draw'), FILTER_VALIDATE_INT) ?: 0,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $rows,
        ]);
    }

    public function create()
    {
        $employee = Mechanic::all();
        return view('hrm.attendance.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $success = true;
        $message = '';

        $validateData = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'status' => 'required',
        ]);

        $employee = isset($_POST['employee']) ? $_POST['employee'] : [];
        if (empty($employee)) {
            return Redirect::back()->withErrors(['msg' => 'Please select employee']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                foreach ($employee as $row) {
                    $date = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                    $existData = Attendance::where(['date' => $date, 'status' => $validateData['status'], 'employee_id' => $row])->first();
                    if (!isset($existData)) {
                        $validateData['employee_id'] = $row;
                        $validateData['date'] = $date;
                        $validateData['type'] = 'manual';
                        $attendance = Attendance::create($validateData);
                        if (!$attendance) {
                            $success = false;
                            $message = 'Failed save';
                        }
                    }
                }

                if ($success) {
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
                $success = false;
                $message = $e->getMessage();
            }
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance Manual Successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance Deleted');
    }

    public function import()
    {
        return view('hrm.attendance.import');
    }

    public function importUpload()
    {
        //Excel::import(new AttendanceImport, request()->file('file'));

        return back();
    }

    public function importAttendance()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_attlog';
            $randKey = bin2hex(random_bytes(25));
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "start_date":"' . date('Y-m-d', strtotime($_POST['date'])) . '", "end_date":"' . date('Y-m-d', strtotime($_POST['date'])) . '"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'get_attlog', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => date('Y-m-d H:i:s')];
            DB::table('finger_logs')->insert($data);
            //import to system
            $data = (array) json_decode($response);
            $listAttendance = $data['data'];
            if (!empty($listAttendance)) {
                //delete old data
                $whereArray = ['date' => date('Y-m-d', strtotime($_POST['date'])), 'type' => 'finger'];
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

    public function importAttendanceShine()
    {
        $success = true;
        $message = "";
        try {
            $url = 'https://developer.fingerspot.io/api/get_attlog';
            $randKey = bin2hex(random_bytes(25));
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C262B895032B1C34", "start_date":"' . date('Y-m-d', strtotime($_POST['date'])) . '", "end_date":"' . date('Y-m-d', strtotime($_POST['date'])) . '"}';
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
            $data = ['unique_id' => $randKey, 'type' => 'get_attlog', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => date('Y-m-d H:i:s')];
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
                        $whereArray = ['date' => date('Y-m-d', strtotime($_POST['date'])), 'type' => 'finger', 'employee_id' => $mechanic->id, 'status' => $statusCheck];
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

    public function downloadTemplate()
    {
        $file = "template/import_attendance.xlsx";

        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="import_attendance.xlsx"'
        );

        return response()->download($file, 'import_attendance.xlsx', $headers);
    }
}
