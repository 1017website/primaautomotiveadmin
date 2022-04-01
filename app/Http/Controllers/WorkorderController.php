<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class WorkorderController extends Controller {

    public function index() {
        $workorder = Workorder::all();
        return view('workorder.index', compact('workorder'));
    }


}
