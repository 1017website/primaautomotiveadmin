<?php

namespace App\Imports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class AttendanceImport implements ToModel, WithHeadingRow {

    public function model(array $row) {
        
        $dateTime = !empty($row['datetime']) ? strtotime($row['datetime']) : NULL;
        $date = "";
        $time = "";
        if (isset($dateTime)) {
            $date = date('Y-m-d', $dateTime);
            $time = date('H:i:s', $dateTime);
        }

        
        return new Attendance([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);
    }

}
