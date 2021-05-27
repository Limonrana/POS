<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchasedetail;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = Purchase::latest()->get();
        return view('pages.purchase.purchase', compact('purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::id();
        $products = Product::all();
        $carts = Cart::where('user_id', $user)->get();
        $vendors = Vendor::all();
        $today = Carbon::today()->format('d/m/y');
        $purchase = Purchase::orderBy('id','desc')->first();
        if ($purchase) {
           $id = $purchase->id;
        } else {
            $id = 0;
        }
        $order_number = '#PO-'.str_pad($id + 1, 6, "0", STR_PAD_LEFT);
        return view('pages.purchase.new-purchase', compact('products', 'carts', 'vendors', 'today', 'order_number'));
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

        $purchase                   = new Purchase();
        $purchase->order_number     = $request->order_number;
        $purchase->vendor_id        = $request->vendor_id;
        $purchase->order_date       = $request->order_date;
        $purchase->shipping_date    = $request->shipping_date;
        $purchase->discount         = $request->discount;
        $purchase->paid             = $request->paid;
        $purchase->balance          = $request->balance;
        $purchase->subtotal         = $request->subtotal;
        $purchase->tax              = $request->tax;
        $purchase->freight_cost     = $request->freight_cost;
        $purchase->total            = $request->total;
        $purchase->remarks          = $request->remarks;
        $purchase->month            = date('m');
        $purchase->year             = date('Y');
        if ($request->balance == 0) {
            $purchase->is_pay           = 1;
        } elseif ($request->paid == 0) {
            $purchase->is_pay           = 0;
        } else {
            $purchase->is_pay           = 2;
        }
        $purchase->status           = 0;
        $purchase->created_by       = $created;
        $purchase->save();
        $purchase_id = $purchase->id;

        $vendor                     = Vendor::where('id', $request->vendor_id)->first();
        $wallet                     = Wallet::find($vendor->wallet_id);
        $wallet->balance            = $wallet->balance + $request->balance;
        $wallet->save();

        $carts   = Cart::where('user_id', $user)->where('type', 1)->get();
        foreach ($carts as $val) {
            $details                = new Purchasedetail();
            $details->product_id    = $val->product_id;
            $details->qty           = $val->qty;
            $details->price         = $val->price;
            $details->purchase_id   = $purchase_id;
            $details->order_number  = $request->order_number;
            $details->subtotal      = $request->subtotal;
            $details->save();
        }
        foreach ($carts as $val) {
            $cart = Cart::find($val->id);
            $cart->delete();
        }
        $notification=array(
            'alert'=>'Purchase successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('purchase.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::find($id);
        return response()->json($purchase);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::find($id);
        $vendors = Vendor::all();
        $products = Product::all();
        return view('pages.purchase.edit-purchase', compact('purchase', 'vendors', 'products'));
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

        $purchase                   = Purchase::find($id);
        $prev_subtotal              = (int)$purchase->subtotal;
        $discount_data              = (int)$request->discount;
        $discount_total             = $prev_subtotal * $discount_data / 100;
        $get_subtotal               = $prev_subtotal - $discount_total;
        $get_total                  = $get_subtotal + (int)$request->freight_cost + (int)$request->tax;
        $purchase->order_date       = $request->order_date;
        $purchase->shipping_date    = $request->shipping_date;
        $purchase->discount         = $request->discount;
        $purchase->tax              = $request->tax;
        $purchase->freight_cost     = $request->freight_cost;
        $purchase->paid             = $request->paid;
        $purchase->total            = $get_total;
        $last_balance               = $get_total - (int)$request->paid;
        $purchase->balance          = $last_balance;
        //Wallet Update
        $vendor_id                  = $purchase->vendor_id;
        $vendor                     = Vendor::find($vendor_id);
        $wallet                     = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
        $wallet_balance             = $wallet->balance;
        $wallet->balance            = $wallet_balance + $last_balance;
        $wallet->save();
        //End Update
        $purchase->remarks          = $request->remarks;
        if ($purchase->balance == 0) {
            $purchase->is_pay           = 1;
        } elseif ($purchase->paid == 0) {
            $purchase->is_pay           = 0;
        } else {
            $purchase->is_pay           = 2;
        }
        $purchase->updated_by       = $created;
        $purchase->save();
        $notification=array(
            'alert'=>'Purchase successfully updated.',
            'alert-type'=>'success'
        );
        return redirect()->route('purchase.index')->with($notification);
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
        $purchase = Purchase::find($id);
        $purchase->status = 1;
        $purchase->save();

        $details = Purchasedetail::where('purchase_id', $id)->get();
        foreach ($details as $value) {
            $id = $value->product_id;
            $product = Product::find($id);
            $left_qty = $product->stock;
            $product->stock = $value->qty + $left_qty;
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
        $purchase = Purchase::find($id);
        $purchase->status = 0;
        $purchase->save();

        $details = Purchasedetail::where('purchase_id', $id)->get();
        foreach ($details as $value) {
            $id = $value->product_id;
            $product = Product::find($id);
            $left_qty = $product->stock;
            $product->stock = $left_qty - $value->qty;
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
        $purchase           = Purchase::find($id);
        $vendor_id          = $purchase->vendor_id;
        $vendor             = Vendor::find($vendor_id);
        $wallet             = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
        $wallet_balance     = $wallet->balance;
        $wallet->balance    = $wallet_balance - $purchase->balance;
        $wallet->save();
        $amount             = $purchase->balance + $purchase->paid;
        $purchase->paid     = $amount;
        $purchase->balance  = "00.00";
        $purchase->is_pay   = 1;
        $purchase->save();
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
        $purchase           = Purchase::find($id);
        $vendor_id          = $purchase->vendor_id;
        $vendor             = Vendor::find($vendor_id);
        $wallet             = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
        $wallet_balance     = $wallet->balance;
        $wallet->balance    = $wallet_balance + $purchase->total;
        $wallet->save();
        $amount             = $purchase->total;
        $purchase->paid     = "00.00";
        $purchase->balance  = $amount;
        $purchase->is_pay   = 0;
        $purchase->save();

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
        $products = Purchasedetail::with('getProduct')->where('purchase_id', $id)->get();
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
        $purchase = Purchase::find($id);
        if ($purchase->balance) {
            $vendor_id          = $purchase->vendor_id;
            $vendor             = Vendor::find($vendor_id);
            $wallet             = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
            $wallet_balance     = $wallet->balance - $purchase->balance;
            $wallet->balance    = $wallet_balance;
            $wallet->save();
        }
        $details  = Purchasedetail::where('purchase_id', $id)->get();
        foreach ($details as $val) {
            $val->delete();
        }
        $purchase->delete();
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
            $purchase = Purchase::find($id);
            if ($purchase->balance) {
                $vendor_id          = $purchase->vendor_id;
                $vendor             = Vendor::find($vendor_id);
                $wallet             = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
                $wallet_balance     = $wallet->balance - $purchase->balance;
                $wallet->balance    = $wallet_balance;
                $wallet->save();
            }
            $details  = Purchasedetail::where('purchase_id', $id)->get();
            foreach ($details as $val) {
                $val->delete();
            }
            $purchase->delete();
        }
    }

    /**
     * Purchase Invoice Genarate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate_Invoice($id) {
        $invoice = Purchase::find($id);
        $today   = Carbon::today()->format('d/m/y');
        return view('pages.purchase.invoice', compact('invoice', 'today'));
    }

    /**
     * Purchase Invoice Genarate PDF Format.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate_pdf($id) {
        $invoice = Purchase::find($id);
        $today   = Carbon::today()->format('d/m/y');
        $pdf = PDF::loadView('pages.purchase.invoice-pdf', compact('invoice', 'today'));
        $pdf->stream($invoice->order_number.'.pdf');
        return $pdf->download($invoice->order_number.'.pdf');
    }


    /**
     * Update the specified single product quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function singleQty(Request $request, $id) {
        $purchaseDetails = Purchasedetail::find($id);
        $product = Product::find($purchaseDetails->product_id);
        if ($request->type == 'increment') {
            $qty = $purchaseDetails->qty + 1;
            $stock = $product->stock - 1;
            if ($product->stock < 1) {
                return response()->json('stock-out');
            }
        } else {
            $qty = $purchaseDetails->qty - 1;
            $stock = $product->stock + 1;
        }
        $purchaseDetails->qty = $qty;
        $purchaseDetails->subtotal = $purchaseDetails->price * $qty;
        $purchaseDetails->save();

        $product->stock =  $stock;
        $product->save();

        //Purchase Update
        $purchase = Purchase::find($purchaseDetails->purchase_id);
        $singleProduct = Purchasedetail::where('purchase_id', $purchase->id)->get();
        $subtotal = 0;
        foreach ($singleProduct as $value){
            $subtotal += $value->subtotal;
        }
        $lastTotal = $subtotal + $purchase->tax + $purchase->freight_cost;
        $balance = $lastTotal - $purchase->paid;
        $purchase->subtotal = $subtotal;
        $purchase->balance = $balance;
        $purchase->total = $lastTotal;

        if ($purchase->paid > $lastTotal) {
            $purchase->is_pay = 3;
        } elseif ($purchase->paid == $lastTotal) {
            $purchase->is_pay = 1;
        } elseif ($purchase->paid < $lastTotal) {
            $purchase->is_pay = 2;
        }
        $purchase->save();

        //Wallet Update
        $vendor_id                  = $purchase->vendor_id;
        $purchaseVendorList         = Purchase::where('vendor_id', $vendor_id)->get();
        $vendor                     = Vendor::find($vendor_id);
        $wallet                     = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
        $wallet_balance = 0;
        foreach ($purchaseVendorList as $value) {
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
        $purchaseDetails = Purchasedetail::find($id);
        $product = Product::find($purchaseDetails->product_id);
        $leftQty = abs($purchaseDetails->qty - $qty);
        if ($purchaseDetails->qty > $qty) {
            $stock = $product->stock + $leftQty;
        } else {
            $stock = $product->stock - $leftQty;
            if ($product->stock < $leftQty) return response()->json('stock-out');
        }

        $purchaseDetails->qty = $qty;
        $purchaseDetails->subtotal = $purchaseDetails->price * $qty;
        $purchaseDetails->save();

        $product->stock =  $stock;
        $product->save();

        //Purchase Update
        $purchase = Purchase::find($purchaseDetails->purchase_id);
        $singleProduct = Purchasedetail::where('purchase_id', $purchase->id)->get();
        $subtotal = 0;
        foreach ($singleProduct as $value){
            $subtotal += $value->subtotal;
        }
        $lastTotal = $subtotal + $purchase->tax + $purchase->freight_cost;
        $balance = $lastTotal - $purchase->paid;
        $purchase->subtotal = $subtotal;
        $purchase->balance = $balance;
        $purchase->total = $lastTotal;

        if ($purchase->paid > $lastTotal) {
            $purchase->is_pay = 3;
        } elseif ($purchase->paid == $lastTotal) {
            $purchase->is_pay = 1;
        } elseif ($purchase->paid < $lastTotal) {
            $purchase->is_pay = 2;
        }
        $purchase->save();

        //Wallet Update
        $vendor_id                  = $purchase->vendor_id;
        $purchaseVendorList         = Purchase::where('vendor_id', $vendor_id)->get();
        $vendor                     = Vendor::find($vendor_id);
        $wallet                     = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
        $wallet_balance = 0;
        foreach ($purchaseVendorList as $value) {
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
        $purchaseDetails = Purchasedetail::find($id);
        $purchaseDetails->price = $request->price;
        $purchaseDetails->subtotal = $request->price * $purchaseDetails->qty;
        $purchaseDetails->save();

        //Purchase Update
        $purchase = Purchase::find($purchaseDetails->purchase_id);
        $singleProduct = Purchasedetail::where('purchase_id', $purchase->id)->get();
        $subtotal = 0;
        foreach ($singleProduct as $value){
            $subtotal += $value->subtotal;
        }
        $lastTotal = $subtotal + $purchase->tax + $purchase->freight_cost;
        $balance = $lastTotal - $purchase->paid;
        $purchase->subtotal = $subtotal;
        $purchase->balance = $balance;
        $purchase->total = $lastTotal;

        if ($purchase->paid > $lastTotal) {
            $purchase->is_pay = 3;
        } elseif ($purchase->paid == $lastTotal) {
            $purchase->is_pay = 1;
        } elseif ($purchase->paid < $lastTotal) {
            $purchase->is_pay = 2;
        }
        $purchase->save();

        //Wallet Update
        $vendor_id                  = $purchase->vendor_id;
        $purchaseVendorList         = Purchase::where('vendor_id', $vendor_id)->get();
        $vendor                     = Vendor::find($vendor_id);
        $wallet                     = Wallet::where('id', $vendor->wallet_id)->where('type', 1)->first();
        $wallet_balance = 0;
        foreach ($purchaseVendorList as $value) {
            $wallet_balance += $value->balance;
        }
        $wallet->balance            = $wallet_balance;
        $wallet->save();
    }
}
