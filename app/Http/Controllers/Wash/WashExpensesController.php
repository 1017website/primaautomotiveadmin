<?php

namespace App\Http\Controllers\Wash;

use Illuminate\Http\Request;

class WashExpensesController extends Controller
{
    public function index()
    {
        return view('wash.expenses.index');
    }
}
