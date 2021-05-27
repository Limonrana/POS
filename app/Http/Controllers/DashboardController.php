<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Salesdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function mainRoot() {
        return redirect()->route('home');
    }

    public function index()
    {
        $today                              = date('d/m/y');
        $yesterday                          = Carbon::yesterday();
        $prev_month                         = strval(date('m') - 01);
        $month                              = date('m');
        $year                               = date('Y');
        $prev_month                         = strval(date('m') - 1);

        $data['today_sales']           = Sale::where('order_date', $today)->sum('total');
        $data['yesterday_sales']       = Sale::where('created_at', $yesterday)->sum('total');
        $data['current_month_sales']        = Sale::where('month', $month)->where('year', $year)->sum('total');
        $data['prev_month_sales']           = Sale::where('month', $prev_month)->where('year', $year)->sum('total');
        $data['sales']                      = Sale::latest()->get();

        $data['current_month_purchase']     = Purchase::where('month', $month)->where('year', $year)->sum('total');
        $data['prev_month_purchase']        = Purchase::where('month', $prev_month)->where('year', $year)->sum('total');

        $getAllSales = Sale::where('month', $month)->where('year', $year)->get();
        $revenue = 0;
        foreach ($getAllSales as $sale) {
            $product_ids = Salesdetail::where('sales_id', $sale->id)->get();
            foreach ($product_ids as $product_id) {
                $product = Product::find($product_id->product_id);
                $getPrice = $product_id->price - $product->buying_price;
                $revenue += $getPrice;
            }
        }

        $getAllPrevSales = Sale::where('month', $prev_month)->where('year', $year)->get();
        $getPrevRevenue = 0;
        foreach ($getAllPrevSales as $sale) {
            $product_ids = Salesdetail::where('sales_id', $sale->id)->get();
            foreach ($product_ids as $product_id) {
                $product = Product::find($product_id->product_id);
                $getPrice = $product_id->price - $product->buying_price;
                $getPrevRevenue += $getPrice;
            }
        }
        $data['getRevenue'] = $revenue;
        $data['getPrevRevenue'] = $getPrevRevenue;
      return view('pages.dashboard')->with($data);
    }
}
