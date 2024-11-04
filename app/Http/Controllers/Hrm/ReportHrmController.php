<?php

namespace App\Http\Controllers\Hrm;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Exports\AttendanceExport;
use App\Models\Attendance;

class ReportHRMController extends Controller
{
    public function index()
    {
        return view('hrm.report.attendance.index');
    }

    public function attendanceView()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $date = $request['date'];
        $status = $request['status'];

        if ($request['status'] == 'all') {
            if (empty($date)) {
                return redirect()->back()->with('error', 'Date is required.');
            }

            try {
                $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Invalid date format.');
            }

            $attendanceData = Attendance::where('date', $formattedDate)
                ->get(['employee_id', 'date', 'time', 'status', 'type']);

        } else {
            if (empty($date)) {
                return redirect()->back()->with('error', 'Date is required.');
            }

            try {
                $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Invalid date format.');
            }

            $attendanceData = Attendance::where('date', $formattedDate)->where('status', $status)
                ->get(['employee_id', 'date', 'time', 'status', 'type']);
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('hrm.report.attendance.view', compact('attendanceData'))->render()
        ];

        return json_encode($data);
    }

}
