<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Paymentmethod;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::latest()->get();
        return view('pages.vendor.vendor', compact('vendors'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendor($id)
    {
        $ven_id             = Vendor::where('id', $id)->first();
        $data['vendor']     = Vendor::where('id', $id)->first();
        $data['address']    = Address::where('id', $ven_id->address)->first();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.vendor.new-vendor');
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
            'title_name'    => 'required|unique:vendors|max:30',
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
        $wallet->type           = 1;
        $wallet->save();
        $wallet_id              = $wallet->id;

        $vendor                 = new Vendor();
        $vendor->title_name     = $request->title_name;
        $vendor->name           = $request->name;
        $vendor->phone          = $request->phone;
        $vendor->email          = $request->email;
        $vendor->website        = $request->website;
        $vendor->address        = $address_id;
        $vendor->payment_method = $payment_id;
        $vendor->wallet_id      = $wallet_id;
        $vendor->remarks        = $request->remarks;
        $vendor->status         = $request->status;
        $vendor->created_by     = $created;
        $vendor->save();
        $notification=array(
            'alert'=>'Vendor successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('vendors.index')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return view('pages.vendor.edit-vendor', compact('vendor'));
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
            'title_name'    => 'required|max:30|unique:vendors,title_name,'.$id,
            'email'         => 'required|email',
            'name'          => 'required',
            'phone'         => 'required',
        ]);
        $payment                = Paymentmethod::find($request->payment_method);
        $payment->name          = $request->payment_name;
        $payment->updated_by    = $created;
        $payment->save();

        $vendor                 = Vendor::find($id);
        $vendor->title_name     = $request->title_name;
        $vendor->name           = $request->name;
        $vendor->phone          = $request->phone;
        $vendor->email          = $request->email;
        $vendor->website        = $request->website;
        $vendor->address        = $request->address;
        $vendor->payment_method = $request->payment_method;
        $vendor->remarks        = $request->remarks;
        $vendor->status         = $request->status;
        $vendor->updated_by     = $created;
        $vendor->save();
        $notification=array(
            'alert'=>'Vendor successfully updated.',
            'alert-type'=>'success'
        );
        return redirect()->route('vendors.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $payment  = Paymentmethod::find($vendor->payment_method);
        $payment->delete();
        $wallet   = Wallet::find($vendor->wallet_id);
        $wallet->delete();
        $address = Address::find($vendor->address);
        $address->delete();
        $vendor->delete();
        return  response()->json("Vendor Deleted");
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
            $vendor = Vendor::find($id);
            $payment  = Paymentmethod::find($vendor->payment_method);
            $payment->delete();
            $wallet   = Wallet::find($vendor->wallet_id);
            $wallet->delete();
            $address = Address::find($vendor->address);
            $address->delete();
            $vendor->delete();
        }
        return  response()->json("Vendor Deleted");
    }
}
