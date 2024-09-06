<?php

namespace App\Http\Controllers;

use App\Models\{
    Devices,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Auth::user()->role_id;
        if ($role == 1) {
            $devices = Devices::all()->where('publish','=',0);
            return view('device.index',compact('devices'));
        } else {
            $user = Auth::user()->id;
            $devices = Devices::
            where('id_user','=',$user)
            ->get();

            $devicesCount = Devices::
            where('id_user','=',$user)
            ->count();
            // dd($devicesCount);
            return view('pengguna.devices.index',compact('devices','devicesCount'));
        }

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
            'nama_devices'      => 'required',
            'keterangan'       => 'required|unique:users,email'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $data = [
            'id_user'       => $user,
            'nama_devices'  => $request->nama_devices,
            'mode'          => 0,
            'keterangan'    => $request->keterangan,
            'publish'       => 0,
        ];
        $device = DB::table('devices')->insert($data);
        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil disimpan',
            'data'      => $device
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $devices = Devices::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $devices
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Devices $devices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Devices $devices, $id)
    {

        $validator = Validator::make($request->all(),[
            'nama_devices'  => 'required',
            'keterangan'    => 'required'
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422 );
        }

        $devices = Devices::find($id);
        $devices->update([
            'nama_devices' => $request->nama_devices,
            'keterangan'    => $request->keterangan
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil diupdate',
            'data'      => $devices
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
         if(Devices::find($id)->delete()) :
            Alert::success('Berhasil!', 'Data Berhasil Dihapus');
         else :
            Alert::error('Terjadi Kesalahan!', 'Data Gagal Dihapus');
         endif;

         return back();
    }

    public function publish_device($id)
    {
        $device = Devices::find($id);
        if ($device->publish) {
            $device->publish = 0;
        }else{
            $device->publish = 1;
            if($device->update()) :
                Alert::success('Berhasil!', 'Data Berhasil diupdate');
                else :
                Alert::error('Terjadi Kesalahan!', 'Data Gagal diupdate');
             endif;
        }
        if ($device->publish) {
            $device->publish = 1;
        }else{
            $device->publish = 0;
            if($device->update()) :
                Alert::success('Berhasil!', 'Data Berhasil diupdate');
                else :
                Alert::error('Terjadi Kesalahan!', 'Data Gagal diupdate');
             endif;
        }
        return redirect()->route('devices.index')->with('message','Device Berhasil Dipublish..!');
    }
    }
