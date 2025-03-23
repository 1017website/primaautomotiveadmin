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

        $date = $request['date'] ?? null;
        $location = $request['location'] ?? 'all';

        if (empty($date)) {
            return redirect()->back()->with('error', 'Date is required.');
        }

        try {
            $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date format.');
        }

        $attendanceQuery = Attendance::where('date', $formattedDate);

        if ($location !== 'all') {
            $attendanceQuery->where('location', $location);
        }

        $attendanceData = $attendanceQuery->get(['employee_id', 'date', 'time', 'status', 'type', 'location'])
            ->groupBy('employee_id');

        $attendanceRecords = [];
        foreach ($attendanceData as $employeeId => $records) {
            $employee = $records->first()->employee;

            if ($employee->status == 1) {
                $checkIn = $records->firstWhere('status', 'in')->time ?? '-';
                $checkOut = $records->firstWhere('status', 'out')->time ?? '-';

                $attendanceRecords[] = [
                    'employee' => $records->first()->employee,
                    'location' => $records->first()->location,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut
                ];
            }
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
        $location = $request->input('location', 'all');

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

        $attendanceQuery = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'in');

        if ($location !== 'all') {
            $attendanceQuery->where('location', $location);
        }

        $attendanceData = $attendanceQuery
            ->get(['employee_id', 'date', 'location'])
            ->groupBy('employee_id');

        $mechanicIds = $attendanceData->keys();
        $mechanics = Mechanic::whereIn('id', $mechanicIds)->where('status', 1)->get();

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
                'attendance' => $attendance,
                'location' => $records->first()->location ?? '-'
            ];
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request->all(),
            'html' => view('hrm.report.monthly-attendance.view', compact('attendanceRecords', 'daysInMonth', 'month', 'mechanics'))->render()
        ];

        return json_encode($data);
    }


    public function attendanceViewWeek(Request $request)
    {
        $success = true;
        $message = '';

        $week = $request->input('week');
        $location = $request->input('location', 'all');

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

        $attendanceQuery = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($location !== 'all') {
            $attendanceQuery->where('location', $location);
        }

        $attendanceData = $attendanceQuery
            ->get(['employee_id', 'date', 'time', 'status', 'type', 'location'])
            ->groupBy(['employee_id', 'date']);

        $mechanicIds = $attendanceData->keys();
        $mechanics = Mechanic::whereIn('id', $mechanicIds)->where('status', 1)->get();

        $datesInWeek = [];
        for ($day = 0; $day < 7; $day++) {
            $datesInWeek[] = $startDate->copy()->addDays($day)->format('Y-m-d');
        }

        $attendanceRecords = [];

        foreach ($mechanics as $mechanic) {
            $attendance = [];

            foreach ($datesInWeek as $date) {
                $records = $attendanceData->get($mechanic->id, collect())->get($date, collect());

                $checkInRecord = $records->where('status', 'in')->first();
                $checkOutRecord = $records->where('status', 'out')->first();

                $checkIn = $checkInRecord ? $checkInRecord->time : null;
                $checkOut = $checkOutRecord ? $checkOutRecord->time : null;

                $formattedCheckIn = $checkIn ? Carbon::parse($checkIn)->format('H:i') : '-';
                $formattedCheckOut = $checkOut ? Carbon::parse($checkOut)->format('H:i') : '-';

                $workHours = '-';
                if ($checkIn && $checkOut) {

                    $diffInMinutes = Carbon::parse($checkIn)->diffInMinutes(Carbon::parse($checkOut));

                    $hours = floor($diffInMinutes / 60);
                    $minutes = $diffInMinutes % 60;
                    $workHours = sprintf('%02d:%02d', $hours, $minutes);
                }

                $attendance[$date] = [
                    'checkIn' => $formattedCheckIn,
                    'checkOut' => $formattedCheckOut,
                    'workHours' => $workHours,
                ];
            }

            $attendanceRecords[] = [
                'employee' => $mechanic,
                'attendance' => $attendance,
                'location' => $records->first()->location ?? '-'
            ];
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'filter' => $request->all(),
            'html' => view('hrm.report.weekly-attendance.view', compact('attendanceRecords', 'datesInWeek', 'week', 'startDate', 'endDate'))->render()
        ];

        return response()->json($data);
    }
}
