<?php

namespace App\Http\Controllers\Hrm;

use App\Models\AttendancePermit;
use App\Models\AttendancePermitType;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AttendancePermitController extends Controller {

    public function index() {
        $attendancePermit = AttendancePermit::orderBy('id', 'DESC')->get();
        return view('hrm.permit.index', compact('attendancePermit'));
    }

    public function create() {
        $employee = Mechanic::all();
        $type = AttendancePermitType::all();
        return view('hrm.permit.create', compact('employee', 'type'));
    }

    public function store(Request $request) {
        $success = true;
        $message = '';

        $validateData = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'type' => 'required',
        ]);

        if ($success) {
            DB::beginTransaction();
            try {
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $attendancePermit = AttendancePermit::create($validateData);
                if (!$attendancePermit) {
                    $success = false;
                    $message = 'Failed save';
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

        return redirect()->route('attendance-permit.index')->with('success', 'Attendance Permit Added Successfully.');
    }

    public function destroy(AttendancePermit $attendancePermit) {
        $attendancePermit->delete();

        return redirect()->route('attendance-permit.index')->with('success', 'Attendance Permit Deleted');
    }

}
