<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Mechanic;
use App\Models\Attendance;
use App\Models\AttendancePermit;
use App\Models\PengaturanWorkday;
use App\Models\EmployeeCredit;
use App\Models\EmployeeCreditDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller {

    public function index() {
        $payroll = Payroll::orderBy('id', 'DESC')->get();
        return view('hrm.payroll.index', compact('payroll'));
    }

    public function create() {
        $employee = Mechanic::all();
        return view('hrm.payroll.create', compact('employee'));
    }

    public function getAttendance() {
        $request = array_merge($_POST, $_GET);
        $success = true;
        $message = '';
        $response = [];
        //\DB::enableQueryLog();
        //dd(\DB::getQueryLog());
        if (isset($request['date']) && isset($request['employee_id'])) {
            //attendance
            $workday = DB::table('pengaturan_workdays')
                    ->where("workday_day", ">=", date('Y-m-d', strtotime($request['date'])))
                    ->where("workday_day", "<=", date('Y-m-d'))
                    ->where("workday_status", "=", 1)
                    ->get();

            $totalWorkday = 0;
            foreach ($workday as $row) {
                $attendance = Attendance::
                        where("employee_id", "=", $request['employee_id'])
                        ->where("date", "=", $row->workday_day)
                        ->first();
                if (isset($attendance)) {
                    $totalWorkday++;
                } else {
                    $attendancePermit = AttendancePermit::
                            where("employee_id", "=", $request['employee_id'])
                            ->where("date", "=", $row->workday_day)
                            ->first();
                    if (isset($attendancePermit)) {
                        $totalWorkday++;
                    }
                }
            }
            $response['attendance'] = $totalWorkday;
            //attendance
            //employee
            $employee = Mechanic::where('id', '=', $request['employee_id'])->first();
            if (isset($employee)) {
                $response['salary'] = $employee->salary;
                $response['positional_allowance'] = $employee->positional_allowance;
                $response['positional_allowance'] = $employee->positional_allowance;
                $response['healthy_allowance'] = $employee->healthy_allowance;
                $response['other_allowance'] = $employee->other_allowance;
            }
            //employee
            //credit
            $credit = EmployeeCreditDetail::
                    where("employee_id", "=", $request['employee_id'])
                    //->whereRaw("MONTH(date) = '" . date('m') . "'")
                    ->whereRaw("status = 'unpaid'")
                    ->orderByRaw('date ASC')
                    ->first();
            if (isset($credit)) {
                $response['credit'] = $credit->total;
            }
            //credit
        }

        return json_encode(['success' => $success, 'message' => $message, 'response' => $response]);
    }

}
