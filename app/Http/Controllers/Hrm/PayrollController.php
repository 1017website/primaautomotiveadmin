<?php

namespace App\Http\Controllers\Hrm;

use App\Models\Payroll;
use App\Models\Mechanic;
use App\Models\Attendance;
use App\Models\AttendancePermit;
use App\Models\PengaturanWorkday;
use App\Models\EmployeeCredit;
use App\Models\EmployeeCreditDetail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller {

    public function index() {
        $payroll = Payroll::orderBy('id', 'DESC')->get();
        return view('hrm.payroll.index', compact('payroll'));
    }

    public function create() {
        $employee = Mechanic::all();
        return view('hrm.payroll.create', compact('employee'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'start_date' => 'required',
            'employee_id' => 'required',
        ]);

        try {
            $validateData['start_date'] = date('Y-m-d', strtotime($request['start_date']));
            $validateData['end_date'] = date('Y-m-d');
            $validateData['month'] = $request['month'];
            $validateData['year'] = date('Y');
            $validateData['attendance'] = $request['attendance'];
            $validateData['employee_salary'] = substr(str_replace('.', '', $request['employee_salary']), 3);
            $validateData['positional_allowance'] = substr(str_replace('.', '', $request['positional_allowance']), 3);
            $validateData['healty_allowance'] = substr(str_replace('.', '', $request['healthy_allowance']), 3);
            $validateData['other_allowance'] = substr(str_replace('.', '', $request['other_allowance']), 3);
            $validateData['bonus'] = substr(str_replace('.', '', $request['bonus']), 3);
            $validateData['total_other'] = substr(str_replace('.', '', $request['total_other']), 3);
            $validateData['penalty'] = substr(str_replace('.', '', $request['penalty']), 3);
            $validateData['credit'] = substr(str_replace('.', '', $request['credit']), 3);
            $validateData['total_salary'] = substr(str_replace('.', '', $request['total_salary']), 3);
            $validateData['description_other'] = $request['description_other'];
            $validateData['status'] = 'paid';
            Payroll::create($validateData);

            if ($validateData['credit'] > 0) {
                $credit = EmployeeCreditDetail::
                        where("employee_id", "=", $request['employee_id'])
                        ->whereRaw("status = 'unpaid'")
                        ->orderByRaw('date ASC')
                        ->first();
                if (isset($credit)) {
                    $credit->status = 'paid';
                    $credit->description = 'Payroll';
                    $credit->paid_date = date('Y-m-d H:i:s');
                    $saved = $credit->save();
                    if ($saved) {
                        $employeeCreditCheck = EmployeeCreditDetail::where(['employee_credit_id' => $credit->employee_credit_id, 'status' => 'unpaid'])->first();
                        if (!isset($employeeCreditCheck)) {
                            $employeeCredit = EmployeeCredit::where(['id' => $credit->employee_credit_id])->first();
                            $employeeCredit->status = 'paid';
                            $employeeCredit->save();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        if (!$success) {
            return Redirect::back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('payroll.index')->with('success', 'Payroll added successfully.');
    }

    public function getAttendance() {
        $request = array_merge($_POST, $_GET);
        $success = true;
        $message = '';
        $response = [];
        //\DB::enableQueryLog();
        //dd(\DB::getQueryLog());
        if (isset($request['date']) && isset($request['employee_id'])) {
            //attendance
            $workday = DB::table('pengaturan_workdays')
                    ->where("workday_day", ">=", date('Y-m-d', strtotime($request['date'])))
                    ->where("workday_day", "<=", date('Y-m-d'))
                    ->where("workday_status", "=", 1)
                    ->get();

            $totalWorkday = 0;
            foreach ($workday as $row) {
                $attendance = Attendance::
                        where("employee_id", "=", $request['employee_id'])
                        ->where("date", "=", $row->workday_day)
                        ->first();
                if (isset($attendance)) {
                    $totalWorkday++;
                } else {
                    $attendancePermit = AttendancePermit::
                            where("employee_id", "=", $request['employee_id'])
                            ->where("date", "=", $row->workday_day)
                            ->first();
                    if (isset($attendancePermit)) {
                        $totalWorkday++;
                    }
                }
            }
            $response['attendance'] = $totalWorkday;
            //attendance
            //employee
            $employee = Mechanic::where('id', '=', $request['employee_id'])->first();
            if (isset($employee)) {
                $response['salary'] = $employee->salary;
                $response['positional_allowance'] = $employee->positional_allowance;
                $response['positional_allowance'] = $employee->positional_allowance;
                $response['healthy_allowance'] = $employee->healthy_allowance;
                $response['other_allowance'] = $employee->other_allowance;
            }
            //employee
            //credit
            $credit = EmployeeCreditDetail::
                    where("employee_id", "=", $request['employee_id'])
                    //->whereRaw("MONTH(date) = '" . date('m') . "'")
                    ->whereRaw("status = 'unpaid'")
                    ->orderByRaw('date ASC')
                    ->first();
            if (isset($credit)) {
                $response['credit'] = $credit->total;
            }
            //credit
            //bonus
            $setting = Setting::where('code', env('APP_NAME', 'primaautomotive'))->first();
            if ($setting->target_revenue > 0 && $setting->target_panel > 0) {
                $revenue = DB::table('invoice')
                        ->selectRaw("
				concat(year(date),'-',lpad(month(date),2,0)) as month,
					sum(dp) as revenue
			")
                        ->whereRaw("date > (LAST_DAY(NOW()) - INTERVAL 1 MONTH) and date <= (LAST_DAY(NOW()))")
                        ->groupBy(DB::raw("concat(year(date),lpad(month(date),2,0))"))
                        ->orderBy(DB::raw("concat(year(date),lpad(month(date),2,0))"))
                        ->get();

                foreach ($revenue as $v) {
                    $revenue = $v->revenue;
                }
                if ($revenue > $setting->target_revenue) {
                    $totalPanel = DB::table('order_detail')
                            ->selectRaw('workorder.mechanic_id, sum(order_detail.panel) AS total_panel ')
                            ->join('order', 'order.id', '=', 'order_detail.order_id')
                            ->join('workorder', 'workorder.order_id', '=', 'order_detail.order_id')
                            ->where('workorder.mechanic_id', $request['employee_id'])
                            ->groupBy('workorder.mechanic_id')
                            ->first();
                    if(isset($totalPanel)){
                        if($totalPanel->total_panel > $setting->target_panel){
                            $totalPanelBonus = $totalPanel->total_panel - $setting->target_panel;
                            $totalPanelRp = $totalPanelBonus * $setting->bonus_panel;
                            $response['bonus'] = $totalPanelRp;
                        }
                    }
                }
            }
            //bonus
        }

        return json_encode(['success' => $success, 'message' => $message, 'response' => $response]);
    }

    public function show($id) {
        $payroll = Payroll::findorfail($id);
        $mechanic = Mechanic::findorfail($payroll->employee_id);
        $setting = Setting::where('code', 'primaautomotive')->first();
        
        return view('hrm.payroll.show', compact('payroll', 'setting', 'mechanic'));
    }
    
}
