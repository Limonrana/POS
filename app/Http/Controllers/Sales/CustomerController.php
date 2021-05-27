<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Paymentmethod;
use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('pages.customer.customer', compact('customers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomer($id)
    {
        $cum_id             = Customer::where('id', $id)->first();
        $data['customer']     = Customer::where('id', $id)->first();
        $data['address']    = Address::where('id', $cum_id->address)->first();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.customer.new-customer');
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
        $validatedData      = $request->validate([
            'title_name'    => 'required|unique:customers|max:30',
            'email'         => 'required|email',
            'name'          => 'required',
            'phone'         => 'required',
        ]);

        $address                = new Address();
        $address->address_name  = $request->address_name;
        $address->street        = $request->street;
        $address->city          = $request->city;
        $address->state         = $request->state;
        $address->zip           = $request->zip;
        $address->country       = $request->country;
        $address->remarks       = $request->remark;
        $address->created_by    = $created;
        $address->save();
        $address_id             = $address->id;

        $payment                = new Paymentmethod();
        $payment->name          = $request->payment_name;
        $payment->created_by    = $created;
        $payment->save();
        $payment_id             = $payment->id;

        $wallet                 = new Wallet();
        $wallet->balance        = 00.00;
        $wallet->credit         = 00.00;
        $wallet->type           = 2;
        $wallet->save();
        $wallet_id              = $wallet->id;

        $customer                 = new Customer();
        $customer->title_name     = $request->title_name;
        $customer->name           = $request->name;
        $customer->phone          = $request->phone;
        $customer->email          = $request->email;
        $customer->website        = $request->website;
        $customer->address        = $address_id;
        $customer->payment_method = $payment_id;
        $customer->wallet_id      = $wallet_id;
        $customer->remarks        = $request->remarks;
        $customer->status         = $request->status;
        $customer->created_by     = $created;
        $customer->save();
        $notification=array(
            'alert'=>'Customer successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('customers.index')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('pages.customer.edit-customer', compact('customer'));
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
        $validatedData      = $request->validate([
            'title_name'    => 'required|max:30|unique:customers,title_name,'.$id,
            'email'         => 'required|email',
            'name'          => 'required',
            'phone'         => 'required',
        ]);
        $payment                = Paymentmethod::find($request->payment_method);
        $payment->name          = $request->payment_name;
        $payment->updated_by    = $created;
        $payment->save();

        $customer                 = Customer::find($id);
        $customer->title_name     = $request->title_name;
        $customer->name           = $request->name;
        $customer->phone          = $request->phone;
        $customer->email          = $request->email;
        $customer->website        = $request->website;
        $customer->address        = $request->address;
        $customer->payment_method = $request->payment_method;
        $customer->remarks        = $request->remarks;
        $customer->status         = $request->status;
        $customer->updated_by     = $created;
        $customer->save();
        $notification=array(
            'alert'=>'Customer successfully updated.',
            'alert-type'=>'success'
        );
        return redirect()->route('customers.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $payment  = Paymentmethod::find($customer->payment_method);
        $payment->delete();
        $wallet   = Wallet::find($customer->wallet_id);
        $wallet->delete();
        $address = Address::find($customer->address);
        $address->delete();
        $customer->delete();
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
            $customer = Customer::find($id);
            $payment  = Paymentmethod::find($customer->payment_method);
            $payment->delete();
            $wallet   = Wallet::find($customer->wallet_id);
            $wallet->delete();
            $address = Address::find($customer->address);
            $address->delete();
            $customer->delete();
        }
    }
}
