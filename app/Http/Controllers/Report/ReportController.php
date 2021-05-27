<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * Display and listing all of the sales report.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales()
    {
        $today          = date('d/m/y');
        $yesterday      = Carbon::yesterday();
        $priv_month     = strval(date('m') - 01);
        $month          = date('m');
        $year           = date('Y');
        $priv_year      = strval(date('Y') - 1);

        $sale['today_sales']           = Sale::where('order_date', $today)->sum('total');
        $sale['yesterday_sales']       = Sale::where('created_at', $yesterday)->sum('total');
        $sale['monthly_sales']         = Sale::where('month', $month)->where('year', $year)->sum('total');
        $sale['prev_sales']            = Sale::where('month', $priv_month)->where('year', $year)->sum('total');
        $sale['yearly_sales']          = Sale::where('year', $year)->sum('total');
        $sale['prev_year']             = Sale::where('year', $priv_year)->sum('total');
        $sale['sales']                 = Sale::all();

        return view('pages.report.sales')->with($sale);
    }

    public function getSales($start, $end)
    {
        $sales = Sale::with('customer')->whereBetween('created_at',[$start,$end])->get();
        return response()->json($sales);
    }

    /**
     * Display and listing all of the sales report.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchase()
    {
        $today          = date('d/m/y');
        $yesterday      = Carbon::yesterday();
        $priv_month     = strval(date('m') - 01);
        $month          = date('m');
        $year           = date('Y');
        $priv_year      = strval(date('Y') - 1);

        $sale['today_sales']           = Purchase::where('order_date', $today)->sum('total');
        $sale['yesterday_sales']       = Purchase::where('created_at', $yesterday)->sum('total');
        $sale['monthly_sales']         = Purchase::where('month', $month)->where('year', $year)->sum('total');
        $sale['prev_sales']            = Purchase::where('month', $priv_month)->where('year', $year)->sum('total');
        $sale['yearly_sales']          = Purchase::where('year', $year)->sum('total');
        $sale['prev_year']             = Purchase::where('year', $priv_year)->sum('total');
        $sale['sales']                 = Purchase::all();

        return view('pages.report.purchase')->with($sale);
    }

    public function getPurchase($start, $end)
    {
        $sales = Purchase::with('vendor')->whereBetween('created_at',[$start,$end])->get();
        return response()->json($sales);
    }
}
