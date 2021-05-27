<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = Unit::all();
        return view('pages.inventory.unit.unit', compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created            = Auth::user()->name;
        $validatedData      = $request->validate([
            'name'          => 'required|unique:units|max:55',
            'u_qty'         => 'required|max:3',
        ]);
        $unit               = new Unit();
        $unit->name         = $request->name;
        $unit->u_qty        = $request->u_qty;
        $unit->created_by   = $created;
        $unit->save();
        $notification=array(
            'alert'=>'Unit successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('unit.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::find($id);
        return response()->json($unit);
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
        $update             = Auth::user()->name;
        $unit               = Unit::find($id);
        $unit->name         = $request->name;
        $unit->u_qty        = $request->u_qty;
        $unit->updated_by   = $update;
        $unit->save();
        return response()->json("Unit Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->forceDelete();
        return  response()->json("Unit Deleted");
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
            $unit = Unit::find($id);
            $unit->forceDelete();
        }
        return  response()->json("Unit Deleted");
    }
}
