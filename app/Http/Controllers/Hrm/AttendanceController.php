<?php

namespace App\Http\Controllers\Hrm;

use App\Models\Attendance;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;

class AttendanceController extends Controller {

    public function index() {
        $attendance = Attendance::orderBy('id', 'DESC')->get();
        return view('hrm.attendance.index', compact('attendance'));
    }

    public function create() {
        $employee = Mechanic::all();
        return view('hrm.attendance.create', compact('employee'));
    }

    public function store(Request $request) {
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

    public function destroy(Attendance $attendance) {
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance Deleted');
    }

    public function import() {
        return view('hrm.attendance.import');
    }

    public function importUpload() {
        Excel::import(new AttendanceImport, request()->file('file'));

        return back();
    }

    public function downloadTemplate() {
        $file = "template/import_attendance.xlsx";

        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="import_attendance.xlsx"'
        );

        return response()->download($file, 'import_attendance.xlsx', $headers);
    }

}
