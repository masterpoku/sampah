<?php

namespace App\Http\Controllers;

use App\Models\{
    Monitoring,
    Devices,
    User
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use DataTables;
use Illuminate\Contracts\Queue\Monitor;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $role = Auth::user()->role_id;
            if ($role == 1) {
                $data = Monitoring::all();
                $Device = Devices::pluck('nama_devices','id_user');
                 return view('monitoring.index_admin',compact('Device','data'));
            } else {
                 $user = Auth::user()->id;
                    if ($request->ajax()) {
                        $data = Monitoring::select('id','id_user','tegangan','temp','ph','waktu')
                        ->orderBy('id','DESC')
                        ->where('id_user','=',$user)
                        ->get();
                        return Datatables::of($data)->addIndexColumn()
                            ->addColumn('id_user', function($data){
                                return $data->user->name;
                            })
                            ->addColumn('ph', function($data){
                                return $data->ph .' pH';
                            })
                            ->addColumn('tegangan', function($data){
                                return $data->tegangan .' ADC';
                            })
                            ->addColumn('temp', function($data){
                                return $data->temp .' %';
                            })
                            ->addColumn('actions', function($row){
                            return '<div class="btn-group">
                                        <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteSensorBtn">Delete</button>
                                    </div>';
                            })
                            ->addColumn('checkbox', function($row){
                                return '<input type="checkbox" name="country_checkbox" data-id="'.$row['id'].'"><label></label>';
                            })
                            ->rawColumns(['checkbox','actions'])
                            ->removeColumn('id')
                            ->make(true);
                    }

                    return view('monitoring.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoring $monitoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Monitoring::findOrFail($id);
        $data->delete();
    }
    public function insertSensor(Request $request)
    {
            $data = Auth::user()->id_device;
            $user = Auth::user()->id;
            if ($request->id_device == $data) {
                $insert = DB::table('sensors');
                    $insert->insert([
                        'id_user'   =>$user,
                        'tegangan'  =>$request->tegangan,
                        'ph'        =>$request->ph,
                        'temp'      =>$request->temp,
                    ]);
                    return response()->json("mantap men");
            }else {
                $dataid = "tdak sama";
                return response($dataid);
            }

    }
    public function waktu()
    {
        $user = Auth::user()->id;
        $data = DB::table('sensors')
        ->where('id_user','=',$user)
        ->orderBy('id','DESC')
        ->limit(1)
        ->get();
        foreach($data as $item)
        {
            $waktu = $item->waktu;
        }
        $selisih = time() - strtotime($waktu);
            $detik = $selisih ;
            $menit = round($selisih / 60 );
            $jam = round($selisih / 3600 );
            $hari = round($selisih / 86400 );
            $minggu = round($selisih / 604800 );
            $bulan = round($selisih / 2419200 );
            $tahun = round($selisih / 29030400 );
             if ($detik <= 60) {
            $waktu = $detik.' detik yang lalu';
            } else if ($menit <= 60) {
                $waktu = $menit.' menit yang lalu';
            } else if ($jam <= 24) {
                $waktu = $jam.' jam yang lalu';
            } else if ($hari <= 7) {
                $waktu = $hari.' hari yang lalu';
            } else if ($minggu <= 4) {
                $waktu = $minggu.' minggu yang lalu,'.' Pada : '.$waktu;
            } else if ($bulan <= 12) {
                $waktu = $bulan.' bulan yang lalu,'.' Pada : '.$waktu;
            } else {
                $waktu = $tahun.' tahun yang lalu,'.' Pada : '.$waktu;
            }

            return $waktu;
    }
    public function ph()
    {
        $user = Auth::user()->id;
        $data = DB::table('sensors')
        ->where('id_user','=',$user)
        ->orderBy('id','desc')
        ->first();
        $respons = ['status' => 'success','sensor' => $data];
        return response()->json($respons,200);
    }
    public function deleteall(Request $request)
    {
        $ids = $request->ids;

        $user = Auth::user()->id;
        if(DB::table('sensors')
        ->where('id_user','=',$user)
        ->whereIn('id',$ids)->delete()):
        else:
        endif;
        return back();
    }
    public function deleteSelected(Request $request)
    {
        $selected_ids = $request->countries_ids;
        Monitoring::whereIn('id', $selected_ids)->delete();
        return response()->json(['code' => 1, 'msg' => 'Data Berhasil Dihapus..']);
    }
    public function deleteSensor(Request $request)
    {
        $sensor_id = $request->sensor_id;
        $query = Monitoring::find($sensor_id)->delete();
         if($query){
            return response()->json(['code'=>1, 'msg'=>'Country has been deleted from database']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }
    }
    public function Id_device($id)
    {
        if($id == 0)
        {
            $data = "Data Tidak Ada";
        }else{
            $data = Monitoring::where('id_user','=',$id)->get();
        }
        return $data;
    }
     public function dataloger()
    {
            $user = Auth::user()->id;
            $data = DB::table('devices')
        ->where('id_user','=',$user)
        ->orderBy('id','desc')
        ->get();
        $respons = ['status' => 'success','sensor' => $data];
        return response()->json($respons,200);
    }
    public function dataStatus(Request $request)
    {
        $status_mode = 0;
            if ($request->status_mode == 'true') {
                $status_mode = 1;
            }
            $mode = Devices::findOrFail($request->id_mode);
            $mode->mode = $status_mode;
            $mode->update();
        echo $status_mode;
    }
}
