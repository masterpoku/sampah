<?php

namespace App\Http\Controllers;

use App\Models\{
    Mode,
    Control,
    User
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        $data = Mode::orderBy('created_at','DESC')
        ->where('id_user','=',$user)
        ->get();
        return view('mode.index',compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mode $mode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mode $mode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mode $mode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mode $mode)
    {
        //
    }
    public function getKontrol()
    {
        $user = Auth::user()->id;
        $data = Mode::where('id_user','=',$user)
                ->get();

            foreach ($data as $item) {
            $data1 = $item->mode;
        }
        return response()->json($data1);

    }
    public function controlPH(Request $request, $id_devices)
    {
        $id_device = Auth::user()->id_device;
        $use = Auth::user()->id;
        $user = User::
        where('id_device','=',$id_device)
        ->get();
        if ($id_devices == $id_device) {
            # code...
            foreach ($user as $item) {
                $id =  $item->id;
            }
            $control = Control::
            where('id_user','=',$use)
            ->get();
            foreach ($control as $con) {
                $data["$con->gpio"] = "$con->state";
            }
            echo json_encode($data);
        }else{
             return response()->json([
            'errors' => false,
            'massage'   => 'Data tidak ada'
            ]);
        }

    }
    public function changeStatus(Request $request)
        {
            $mode = Mode::find($request->id);
            if (!$mode) {
                return response()->json(['error' => 'Data Control tidak ditemukan'], 404);
            }
            $mode->mode = $request->mode;
            $mode->save();
            return response()->json(['success' => 'State berhasil diubah', 'data' => $mode]);
        }
    public function getStatus(Request $request)
        {
            $mode = Mode::find($request->id);
            if (!$mode) {
                return response()->json(['error' => 'Data Control tidak ditemukan'], 404);
            }
            return response()->json(['mode' => $mode->mode]);
        }
    public function modestatus()
    {
        $user = Auth::user()->id;
        $data = DB::table('devices')
        ->orderBy('id','DESC')
        ->limit(1)
        ->get();
        foreach ($data as $item) {
           $mode = $item->mode;
        }
        return json_encode($mode);
    }
}
