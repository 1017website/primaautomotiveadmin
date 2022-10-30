<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller {

    public function index() {
        $attendance = Attendance::all();
        return view('hrm.attendance.index', compact('attendance'));
    }

    public function create() {
        
    }

}
