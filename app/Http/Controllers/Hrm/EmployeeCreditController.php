<?php

namespace App\Http\Controllers\Hrm;

use App\Models\EmployeeCredit;
use App\Models\EmployeeCreditDetail;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class EmployeeCreditController extends Controller {

    public function index() {
        $credit = EmployeeCredit::orderBy('id', 'DESC')->get();
        return view('hrm.credit.index', compact('credit'));
    }

    public function create() {
        $employee = Mechanic::all();
        return view('hrm.credit.create', compact('employee'));
    }

    public function store(Request $request) {
        $success = true;
        $message = '';

        $validateData = $request->validate([
            'date' => 'required',
            'employee_id' => 'required',
            'total' => 'required',
            'tenor' => 'required',
            'description' => 'max:500',
        ]);

        if ($success) {
            DB::beginTransaction();
            try {
                $date = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
                $total = substr(str_replace('.', '', $request->total), 3);
                $validateData['date'] = $date;
                $validateData['total'] = $total;
                $validateData['status'] = 'unpaid';
                $credit = EmployeeCredit::create($validateData);
                if (!$credit) {
                    $success = false;
                    $message = 'Failed save credit';
                } else {
                    //create detail
                    $totalCredit = round($credit->total / $credit->tenor);
                    for ($x = 1; $x <= $credit->tenor; $x++) {
                        $dateNow = strtotime($date);
                        $interval = (string) "+" . $x . " month";
                        $dateTenor = date("Y-m-d", strtotime($interval, $dateNow));
                        $creditDetail = new EmployeeCreditDetail();
                        $creditDetail->employee_credit_id = $credit->id;
                        $creditDetail->employee_id = $credit->employee_id;
                        $creditDetail->date = $dateTenor;
                        $creditDetail->total = $totalCredit;
                        $creditDetail->status = 'unpaid';
                        $saved = $creditDetail->save();
                        if (!$saved) {
                            $success = false;
                            $message = 'Failed save credit detail';
                        }
                    }
                }
                if ($success) {
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
                $success = false;
                $message = $e->getMessage();
            }
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message])->withInput();
        }

        return redirect()->route('employee-credit.index')->with('success', 'Credit Added Successfully.');
    }

    public function destroy(EmployeeCredit $employeeCredit) {
        $employeeCreditDetail = EmployeeCreditDetail::where(['employee_credit_id' => $employeeCredit->id])->get();
        foreach ($employeeCreditDetail as $row) {
            $row->delete();
        }
        $employeeCredit->delete();

        return redirect()->route('employee-credit.index')->with('success', 'Credit Deleted');
    }

    public function show(EmployeeCredit $employeeCredit) {
        return view('hrm.credit.show', compact('employeeCredit'));
    }

    public function paid() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $id = $_POST['id'];
            $employeeCreditDetail = EmployeeCreditDetail::where(['id' => $request['id']])->first();
            $employeeCreditDetail->status = 'paid';
            $employeeCreditDetail->paid_date = date('Y-m-d H:i:s');
            $employeeCreditDetail->description = 'Paid Manual';
            $saved = $employeeCreditDetail->save();
            if ($saved) {
                $employeeCreditCheck = EmployeeCreditDetail::where(['employee_credit_id' => $employeeCreditDetail->employee_credit_id, 'status' => 'unpaid'])->first();
                if (!isset($employeeCreditCheck)) {
                    $employeeCredit = EmployeeCredit::where(['id' => $employeeCreditDetail->employee_credit_id])->first();
                    $employeeCredit->status = 'paid';
                    $employeeCredit->save();
                }
            }
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }

}
