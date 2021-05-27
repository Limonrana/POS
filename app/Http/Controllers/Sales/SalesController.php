<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchasedetail;
use App\Models\Sale;
use App\Models\Salesdetail;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::latest()->get();
        return view('pages.sales.sales', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user       = Auth::id();
        $products   = Product::all();
        $carts      = Cart::where('user_id', $user)->get();
        $customers  = Customer::all();
        $today      = Carbon::today()->format('d/m/y');
        $sales      = Sale::orderBy('id','desc')->first();
        if ($sales) {
            $id = $sales->id;
        } else {
            $id = 0;
        }
        $order_number = '#SO-'.str_pad($id + 1, 6, "0", STR_PAD_LEFT);
        return view('pages.sales.new-sales', compact('products', 'carts', 'customers', 'today', 'order_number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created = Auth::user()->name;
        $user    = Auth::id();
        $validatedData      = $request->validate([
            'order_number'  => 'required|max:10|unique:purchases',
        ]);

        $sales                   = new Sale();
        $sales->order_number     = $request->order_number;
        $sales->customer_id      = $request->customer_id;
        $sales->order_date       = $request->order_date;
        $sales->shipping_date    = $request->shipping_date;
        $sales->discount         = $request->discount;
        $sales->paid             = $request->paid;
        $sales->balance          = $request->balance;
        $sales->subtotal         = $request->subtotal;
        $sales->tax              = $request->tax;
        $sales->freight_cost     = $request->freight_cost;
        $sales->total            = $request->total;
        $sales->remarks          = $request->remarks;
        $sales->month            = date('m');
        $sales->year             = date('Y');
        if ($request->balance == 0) {
            $sales->is_pay           = 1;
        } elseif ($request->paid == 0) {
            $sales->is_pay           = 0;
        } else {
            $sales->is_pay           = 2;
        }
        $sales->status           = 0;
        $sales->created_by       = $created;
        $sales->save();
        $sales_id = $sales->id;

        $customer                   = Customer::where('id', $request->customer_id)->first();
        $wallet                     = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet->balance            = $wallet->balance + $request->balance;
        $wallet->save();

        $carts   = Cart::where('user_id', $user)->where('type', 2)->get();
        foreach ($carts as $val) {
            $details                = new Salesdetail();
            $details->product_id    = $val->product_id;
            $details->qty           = $val->qty;
            $details->price         = $val->price;
            $details->sales_id      = $sales_id;
            $details->order_number  = $request->order_number;
            $details->subtotal      = $request->subtotal;
            $details->save();
        }
        foreach ($carts as $val) {
            $cart = Cart::find($val->id);
            $cart->delete();
        }
        $notification=array(
            'alert'=>'Sales successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('sales.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sale::find($id);
        return response()->json($sales);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales      = Sale::find($id);
        $customers  = Customer::all();
        $products   = Product::all();
        return view('pages.sales.edit-sales', compact('sales', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData(Request $request, $id)
    {
        $created = Auth::user()->name;
        $user    = Auth::id();

        $sales                      = sale::find($id);
        $prev_subtotal              = (int)$sales->subtotal;
        $discount_data              = (int)$request->discount;
        $discount_total             = $prev_subtotal * $discount_data / 100;
        $get_subtotal               = $prev_subtotal - $discount_total;
        $get_total                  = $get_subtotal + (int)$request->freight_cost + (int)$request->tax;
        $sales->order_date          = $request->order_date;
        $sales->shipping_date       = $request->shipping_date;
        $sales->discount            = $request->discount;
        $sales->tax                 = $request->tax;
        $sales->freight_cost        = $request->freight_cost;
        $sales->paid                = $request->paid;
        $last_balance               = $get_total - (int)$request->paid;
        $sales->total               = $get_total;
        $sales->balance             = $last_balance;
        //Wallet Update
        $customer_id                = $sales->customer_id;
        $customer                   = Customer::find($customer_id);
        $wallet                     = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet_balance             = $wallet->balance;
        $wallet->balance            = $wallet_balance + $last_balance;
        $wallet->save();
        //End Update
        $sales->remarks             = $request->remarks;
        if ($sales->balance == 0) {
            $sales->is_pay          = 1;
        } elseif ($sales->paid == 0) {
            $sales->is_pay          = 0;
        } else {
            $sales->is_pay          = 2;
        }
        $sales->updated_by          = $created;
        $sales->save();
        $notification=array(
            'alert'=>'Sales successfully updated.',
            'alert-type'=>'success'
        );
        return redirect()->route('sales.index')->with($notification);
    }

    /**
     * Fulfillment purchase the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fulfilled($id)
    {
        $sales = Sale::find($id);
        $sales->status = 1;
        $sales->save();

        $details = Salesdetail::where('sales_id', $id)->get();
        foreach ($details as $value) {
            $id = $value->product_id;
            $product = Product::find($id);
            $left_qty = $product->stock;
            $product->stock = $left_qty - $value->qty;
            $product->save();
        }
        $notification=array(
            'alert'=>'Fulfillment successfully done',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }

    /**
     * Unfulfillment purchase the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unfulfillment($id)
    {
        $sales = Sale::find($id);
        $sales->status = 0;
        $sales->save();

        $details = Salesdetail::where('sales_id', $id)->get();
        foreach ($details as $value) {
            $id = $value->product_id;
            $product = Product::find($id);
            $left_qty = $product->stock;
            $product->stock = $left_qty + $value->qty;
            $product->save();
        }
        $notification=array(
            'alert'=>'Unfulfillment successfully done',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }

    /**
     * Pay done purchase the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay($id)
    {
        $sales              = Sale::find($id);
        $customer_id        = $sales->customer_id;
        $customer           = Customer::find($customer_id);
        $wallet             = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet_balance     = $wallet->balance;
        $wallet->balance    = $wallet_balance - $sales->balance;
        $wallet->save();
        $amount             = $sales->balance + $sales->paid;
        $sales->paid        = $amount;
        $sales->balance     = "00.00";
        $sales->is_pay      = 1;
        $sales->save();

        $notification=array(
            'alert'=>'Paid successfully done.',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }

    /**
     * Pay done purchase the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unpay($id)
    {
        $sales              = Sale::find($id);
        $customer_id        = $sales->customer_id;
        $customer           = Customer::find($customer_id);
        $wallet             = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet_balance     = $wallet->balance;
        $wallet->balance    = $wallet_balance + $sales->total;
        $wallet->save();
        $amount             = $sales->total;
        $sales->paid        = "00.00";
        $sales->balance     = $amount;
        $sales->is_pay      = 0;
        $sales->save();
        $notification=array(
            'alert'=>'Unpay successfully done.',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }

    /**
     * Product get to the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function purchaseProduct($id)
    {
        $products = Salesdetail::with('getProduct')->where('sales_id', $id)->get();
        return response()->json($products);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = Sale::find($id);
        if ($sales->balance) {
            $customer_id        = $sales->customer_id;
            $customer           = Customer::find($customer_id);
            $wallet             = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
            $wallet_balance     = $wallet->balance - $sales->balance;
            $wallet->balance    = $wallet_balance;
            $wallet->save();
        }
        $details  = Salesdetail::where('sales_id', $id)->get();
        foreach ($details as $val) {
            $val->delete();
        }
        $sales->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $all_id = $request->id;
        foreach($all_id as $id){
            $sales = Sale::find($id);
            if ($sales->balance) {
                $customer_id        = $sales->customer_id;
                $customer           = Customer::find($customer_id);
                $wallet             = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
                $wallet_balance     = $wallet->balance - $sales->balance;
                $wallet->balance    = $wallet_balance;
                $wallet->save();
            }
            $details  = Salesdetail::where('sales_id', $id)->get();
            foreach ($details as $val) {
                $val->delete();
            }
            $sales->delete();
        }
    }

    function generate_Invoice($id) {
        $invoice = Sale::find($id);
        $today   = Carbon::today()->format('d/m/y');
        return view('pages.sales.invoice', compact('invoice', 'today'));
    }

    function generate_pdf($id) {
        $invoice = Sale::find($id);
        $pdf = PDF::loadView('pages.sales.invoice', compact('invoice'));
        $pdf->stream('invoice.pdf');
        return $pdf->download('invoice.pdf');
    }


    /**
     * Update the specified single product quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function singleQty(Request $request, $id) {
        $salesDetails = Salesdetail::find($id);
        $product = Product::find($salesDetails->product_id);
        if ($request->type == 'increment') {
            $qty = $salesDetails->qty + 1;
            $stock = $product->stock - 1;
            if ($product->stock < 1) {
                return response()->json('stock-out');
            }
        } else {
            $qty = $salesDetails->qty - 1;
            $stock = $product->stock + 1;
        }
        $salesDetails->qty = $qty;
        $salesDetails->subtotal = $salesDetails->price * $qty;
        $salesDetails->save();

        $product->stock =  $stock;
        $product->save();

        //Purchase Update
        $sales = Sale::find($salesDetails->sales_id);
        $singleProduct = Salesdetail::where('sales_id', $sales->id)->get();
        $subtotal = 0;
        foreach ($singleProduct as $value){
            $subtotal += $value->subtotal;
        }
        $lastTotal = $subtotal + $sales->tax + $sales->freight_cost;
        $balance = $lastTotal - $sales->paid;
        $sales->subtotal = $subtotal;
        $sales->balance = $balance;
        $sales->total = $lastTotal;

        if ($sales->paid > $lastTotal) {
            $sales->is_pay = 3;
        } elseif ($sales->paid == $lastTotal) {
            $sales->is_pay = 1;
        } elseif ($sales->paid < $lastTotal) {
            $sales->is_pay = 2;
        }
        $sales->save();

        //Wallet Update
        $customer_id                = $sales->customer_id;
        $salesCustomerList          = Sale::where('customer_id', $customer_id)->get();
        $customer                   = Customer::find($customer_id);
        $wallet                     = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet_balance = 0;
        foreach ($salesCustomerList as $value) {
            $wallet_balance += $value->balance;
        }
        $wallet->balance            = $wallet_balance;
        $wallet->save();
    }


    /**
     * Update the specified single product quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function qtyUpdate(Request $request, $id, $qty) {
        $salesDetails = Salesdetail::find($id);
        $product = Product::find($salesDetails->product_id);
        $leftQty = abs($salesDetails->qty - $qty);
        if ($salesDetails->qty > $qty) {
            $stock = $product->stock + $leftQty;
        } else {
            $stock = $product->stock - $leftQty;
            if ($product->stock < $leftQty) return response()->json('stock-out');
        }

        $salesDetails->qty = $qty;
        $salesDetails->subtotal = $salesDetails->price * $qty;
        $salesDetails->save();

        $product->stock =  $stock;
        $product->save();

        //Purchase Update
        $sales = Sale::find($salesDetails->sales_id);
        $singleProduct = Salesdetail::where('sales_id', $sales->id)->get();
        $subtotal = 0;
        foreach ($singleProduct as $value){
            $subtotal += $value->subtotal;
        }
        $lastTotal = $subtotal + $sales->tax + $sales->freight_cost;
        $balance = $lastTotal - $sales->paid;
        $sales->subtotal = $subtotal;
        $sales->balance = $balance;
        $sales->total = $lastTotal;

        if ($sales->paid > $lastTotal) {
            $sales->is_pay = 3;
        } elseif ($sales->paid == $lastTotal) {
            $sales->is_pay = 1;
        } elseif ($sales->paid < $lastTotal) {
            $sales->is_pay = 2;
        }
        $sales->save();

        //Wallet Update
        $customer_id                = $sales->customer_id;
        $salesCustomerList          = Sale::where('customer_id', $customer_id)->get();
        $customer                   = Customer::find($customer_id);
        $wallet                     = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet_balance = 0;
        foreach ($salesCustomerList as $value) {
            $wallet_balance += $value->balance;
        }
        $wallet->balance            = $wallet_balance;
        $wallet->save();
    }

    /**
     * Update the specified single product price.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productPrice(Request $request, $id)
    {
        $salesDetails = Salesdetail::find($id);
        $salesDetails->price = $request->price;
        $salesDetails->subtotal = $request->price * $salesDetails->qty;
        $salesDetails->save();

        //Purchase Update
        $sales = Sale::find($salesDetails->sales_id);
        $singleProduct = Salesdetail::where('sales_id', $sales->id)->get();
        $subtotal = 0;
        foreach ($singleProduct as $value){
            $subtotal += $value->subtotal;
        }
        $lastTotal = $subtotal + $sales->tax + $sales->freight_cost;
        $balance = $lastTotal - $sales->paid;
        $sales->subtotal = $subtotal;
        $sales->balance = $balance;
        $sales->total = $lastTotal;

        if ($sales->paid > $lastTotal) {
            $sales->is_pay = 3;
        } elseif ($sales->paid == $lastTotal) {
            $sales->is_pay = 1;
        } elseif ($sales->paid < $lastTotal) {
            $sales->is_pay = 2;
        }
        $sales->save();

        //Wallet Update
        $customer_id                = $sales->customer_id;
        $salesCustomerList          = Sale::where('customer_id', $customer_id)->get();
        $customer                   = Customer::find($customer_id);
        $wallet                     = Wallet::where('id', $customer->wallet_id)->where('type', 2)->first();
        $wallet_balance = 0;
        foreach ($salesCustomerList as $value) {
            $wallet_balance += $value->balance;
        }
        $wallet->balance            = $wallet_balance;
        $wallet->save();
    }
}
