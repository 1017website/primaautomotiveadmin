<?php

namespace App\Http\Controllers\Hrm;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Mechanic;

class ReportHRMController extends Controller
{
    public function index()
    {
        return view('hrm.report.attendance.index');
    }

    public function indexMonth()
    {
        return view('hrm.report.monthly-attendance.index');
    }

    public function indexWeek()
    {
        return view('hrm.report.weekly-attendance.index');
    }

    public function attendanceView()
    {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        $date = $request['date'];

        if (empty($date)) {
            return redirect()->back()->with('error', 'Date is required.');
        }

        try {
            $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date format.');
        }

        $attendanceData = Attendance::where('date', $formattedDate)
            ->get(['employee_id', 'date', 'time', 'status', 'type'])
            ->groupBy('employee_id');

        $attendanceRecords = [];
        foreach ($attendanceData as $employeeId => $records) {
            $checkIn = $records->firstWhere('status', 'in')->time ?? '-';
            $checkOut = $records->firstWhere('status', 'out')->time ?? '-';

            $attendanceRecords[] = [
                'employee' => $records->first()->employee,
                'check_in' => $checkIn,
                'check_out' => $checkOut
            ];
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('hrm.report.attendance.view', compact('attendanceRecords'))->render()
        ];

        return json_encode($data);
    }

    public function attendanceViewMonth(Request $request)
    {
        $success = true;
        $message = '';

        $month = $request->input('month');

        if (empty($month)) {
            return response()->json([
                'success' => false,
                'message' => 'Month is required.'
            ]);
        }

        try {
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid month format.'
            ]);
        }
        $mechanics = Mechanic::all();

        $attendanceData = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'in')
            ->get(['employee_id', 'date'])
            ->groupBy('employee_id');

        $attendanceRecords = [];
        $daysInMonth = Carbon::parse($startDate)->daysInMonth;

        foreach ($mechanics as $mechanic) {
            $attendance = [];
            $records = $attendanceData->get($mechanic->id, collect());

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dayDate = Carbon::createFromFormat('Y-m-d', $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT))->format('Y-m-d');
                $attendance[$day] = $records->contains('date', $dayDate) ? '✓' : '-';
            }

            $attendanceRecords[] = [
                'employee' => $mechanic,
                'attendance' => $attendance
            ];
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('hrm.report.monthly-attendance.view', compact('attendanceRecords', 'daysInMonth', 'month', 'mechanics'))->render()
        ];

        return json_encode($data);
    }

    public function attendanceViewWeek(Request $request)
    {
        $success = true;
        $message = '';

        $week = $request->input('week');

        if (empty($week)) {
            return response()->json([
                'success' => false,
                'message' => 'Week is required.'
            ]);
        }

        try {
            $startDate = Carbon::parse($week)->startOfWeek();
            $endDate = Carbon::parse($week)->endOfWeek();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid week format.'
            ]);
        }

        $mechanics = Mechanic::all();
        $attendanceData = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'in')
            ->get(['employee_id', 'date'])
            ->groupBy('employee_id');

        $datesInWeek = [];
        for ($day = 0; $day < 7; $day++) {
            $datesInWeek[] = $startDate->copy()->addDays($day)->format('Y-m-d');
        }

        $attendanceRecords = [];

        foreach ($mechanics as $mechanic) {
            $attendance = [];
            $records = $attendanceData->get($mechanic->id, collect());

            foreach ($datesInWeek as $date) {
                $attendance[$date] = $records->contains('date', $date) ? '✓' : '-';
            }

            $attendanceRecords[] = [
                'employee' => $mechanic,
                'attendance' => $attendance
            ];
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request,
            'html' => view('hrm.report.weekly-attendance.view', compact('attendanceRecords', 'datesInWeek', 'week', 'startDate', 'endDate'))->render()
        ];

        return response()->json($data);
    }
}
