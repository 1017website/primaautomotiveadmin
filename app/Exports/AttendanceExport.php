<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $date;
    protected $status;

    public function __construct($date, $status)
    {
        $this->date = $date;
        $this->status = $status;
    }

    public function collection()
    {
        return Attendance::with('employee')
            ->where('date', $this->date)
            ->where('status', $this->status)
            ->get(['employee_id', 'date', 'time', 'status', 'type'])
            ->map(function ($attendance) {
                return [
                    'Employee Name' => $attendance->employee->name,
                    'Date' => $attendance->date,
                    'Time' => $attendance->time,
                    'Status' => $attendance->status,
                    'Type' => $attendance->type,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Date',
            'Time',
            'Status',
            'Type',
        ];
    }
}
