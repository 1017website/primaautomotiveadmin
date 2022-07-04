<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function index() {
        $union1 = DB::table('invoice')
                ->selectRaw('0 as orders, 0 as progress, 0 as done, sum(dp) as revenue, 0 as expense')
                ->whereRaw(' date <= LAST_DAY(NOW())');
        $union2 = DB::table('expense_spending')
                ->selectRaw('0 as orders, 0 as progress, 0 as done, 0 as revenue, sum(cost) as expense')
                ->whereRaw(' date <= LAST_DAY(NOW())');
        $query = DB::table('order as a')
                ->selectRaw("
				count(a.id) as orders, 
				sum(if(a.status = 3, 1, 0)) as progress, 
				sum(if(a.status = 4, 1, 0)) as done,
				0 as revenue, 0 as expense
			")
                ->unionAll($union1)
                ->unionAll($union2)
                ->whereRaw("a.status <> 0 and a.date <= LAST_DAY(NOW())");

        $all = DB::query()->fromSub($query, 'a')
                ->selectRaw("
				sum(orders) as orders, sum(progress) as progress,
				sum(done) as done, sum(revenue) as revenue, sum(expense) as expense
			")
                ->get();
        $orders = DB::table('order as a')
                ->selectRaw("
				concat(year(date),'-',lpad(month(date),2,0)) as month,
				count(a.id) as orders, 
				sum(if(a.status = 3, 1, 0)) as progress, 
				sum(if(a.status = 4, 1, 0)) as done
			")
                ->whereRaw("a.status <> 0 and a.date > (LAST_DAY(NOW()) - INTERVAL 6 MONTH)")
                ->groupBy(DB::raw("concat(year(a.date),lpad(month(a.date),2,0))"))
                ->orderBy(DB::raw("concat(year(a.date),lpad(month(a.date),2,0))"))
                ->get();

        $revenue = DB::table('invoice')
                ->selectRaw("
				concat(year(date),'-',lpad(month(date),2,0)) as month,
					sum(dp) as revenue
			")
                ->whereRaw("date > (LAST_DAY(NOW()) - INTERVAL 6 MONTH) and date <= (LAST_DAY(NOW()))")
                ->groupBy(DB::raw("concat(year(date),lpad(month(date),2,0))"))
                ->orderBy(DB::raw("concat(year(date),lpad(month(date),2,0))"))
                ->get();

        $expense = DB::table('expense_spending')
                ->selectRaw("
				concat(year(date),'-',lpad(month(date),2,0)) as month,
					sum(cost) as expense
			")
                ->whereRaw("date > (LAST_DAY(NOW()) - INTERVAL 6 MONTH) and date <= (LAST_DAY(NOW()))")
                ->groupBy(DB::raw("concat(year(date),lpad(month(date),2,0))"))
                ->orderBy(DB::raw("concat(year(date),lpad(month(date),2,0))"))
                ->get();
        $data = [];
        foreach ($orders as $v) {
            $data[$v->month]['order'] = $v;
        }
        foreach ($revenue as $v) {
            $data[$v->month]['revenue'] = $v;
        }
        foreach ($expense as $v) {
            $data[$v->month]['expense'] = $v;
        }
        foreach ($all as $v) {
            $data['ALL']['order'] = $v;
            $data['ALL']['revenue'] = $v;
            $data['ALL']['expense'] = $v;
        }

        $products = DB::table('workorder_detail as a')
                ->selectRaw("
				b.name, sum(a.qty) as qty
			")
                ->join('products as b', 'b.id', '=', 'a.product_id')
                ->groupBy('b.id')
                ->get();

        return view('dashboard', compact('data', 'products'));
    }

}
