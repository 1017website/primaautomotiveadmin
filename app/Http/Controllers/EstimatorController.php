<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EstimatorController extends Controller {

    public function index() {

        return view('estimator');
    }

}
