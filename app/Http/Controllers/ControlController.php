<?php

namespace App\Http\Controllers;

use App\Models\{
    Control,
    Mode
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        $data = Control::
        where('id_user','=',$user)
        ->get();
        $controlCount = Control::
        where('id_user','=',$user)
        ->count();
        $mode = Mode::
        where('id_user','=',$user)
        ->get();
        foreach ($mode as $key) {
            $status = $key->mode;
        }
        return view('control.index',compact('data','status','controlCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'nama_device'      => 'required',
            'gpio'             => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $device = Control::create([
            'id_user'       => $user,
            'nama_device' => $request->nama_device,
            'gpio'          => $request->gpio,
            'state'         => 0,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil disimpan',
            'data'      => $device,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Control $control)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Control $control)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Control $control)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Control $control)
    {
        //
    }
     public function changeState(Request $request)
    {
        $data = Control::find($request->id);
        $data->state = $request->state;
        $data->save();

        return response()->json(['success'=>'State change successfully']);
    }
}
