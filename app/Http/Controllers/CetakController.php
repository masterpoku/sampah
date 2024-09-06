<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDF;

class CetakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Auth::user()->role_id;
            if ($role == 2) {
                    $user = Auth::user()->id;
                    $data = DB::table('sensors')
                    ->select(DB::raw("DATE_FORMAT(waktu, '%Y-%m-%d') as date"),
                        DB::raw('count(*) as jumlah'))
                    ->where('id_user','=',$user)
                    ->groupBy('date')
                    ->get();

                return view('pengguna.cetak.index',compact('data'));

            }elseif ($role == 1) {
                $user = Auth::user()->id;
                $data = DB::table('sensors')
                ->select(
                    DB::raw("DATE_FORMAT(waktu, '%Y-%m-%d') as date"),
                    'users.name',
                    'users.id_device',
                    'users.id'
                    )
                ->join('users','users.id','=','sensors.id_user')
                ->orderBy('date','DESC')
                ->distinct()
                ->get();

                return view('cetak.index',compact('data'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function cetakPDF($tanggal)
    {

        $user = Auth::user()->id;
        $date = Carbon::now()->format('Y-m-d');
        $rata_ph = DB::table('sensors')
        ->where('id_user','=',$user)
        ->whereDate('waktu','=',$tanggal)
        ->avg('ph');

        $rata_temp = DB::table('sensors')
        ->where('id_user','=',$user)
        ->whereDate('waktu','=',$tanggal)
        ->avg('temp');

        $rata_tegangan = DB::table('sensors')
        ->where('id_user','=',$user)
        ->whereDate('waktu','=',$tanggal)
        ->avg('tegangan');

        $data_control = DB::table('controls')
        ->where('id_user','=',$user)
        ->get();

        $data = DB::table('sensors')
        ->where('id_user','=',$user)
        ->whereDate('waktu','=',$tanggal)
        ->limit(50)
        ->get();
        // foreach ($data as $item) {
        //     $ph[] = $item->ph;
        //     $temp[] = $item->temp;
        // }

        $pdf = PDF::loadView('cetak.cetak_sensor',compact(
            'data',
            'rata_ph',
            'rata_temp',
            'data_control',
            'tanggal'
        ));
        return $pdf->stream("data-sensor.pdf");

    }
    public function detaildata(Request $request)
    {
        $date = $request->date;
        $username = $request->name;
        $data = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->orderBy('id','DESC')
        ->get();
        $datacount = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->count();
        $tegangan = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->avg('tegangan');
        $ph = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->avg('ph');
        $temperature = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->avg('temp');
        $teganganMin = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->min('tegangan');
        $phMin = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->min('ph');
        $temperatureMin = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->min('temp');
        $teganganMax = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->max('tegangan');
        $phMax = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->max('ph');
        $temperatureMax = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->max('temp');

        $dataterakhir = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->limit(1)
        ->orderBy('waktu','DESC')
        ->get();

        return view('cetak.detaildata',compact(
            'data',
            'date',
            'username',
            'datacount',
            'tegangan',
            'ph',
            'temperature',
            'teganganMin',
            'phMin',
            'temperatureMin',
            'teganganMax',
            'phMax',
            'temperatureMax',
            'dataterakhir'
        ));
    }
    public function cetakData(Request $request)
    {
        $date = $request->date;
        $username = $request->name;
        $data = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->orderBy('id','DESC')
        ->get();
        $datacount = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->count();
        $tegangan = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->avg('tegangan');
        $ph = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->avg('ph');
        $temperature = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->avg('temp');
        $teganganMin = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->min('tegangan');
        $phMin = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->min('ph');
        $temperatureMin = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->min('temp');
        $teganganMax = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->max('tegangan');
        $phMax = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->max('ph');
        $temperatureMax = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->max('temp');

        $dataterakhir = DB::table('sensors')
        ->where('id_user','=',$request->id)
        ->whereDate('waktu','=',$request->date)
        ->limit(1)
        ->orderBy('waktu','DESC')
        ->get();
        $auth = Auth::user()->name;

        $pdf = PDF::loadView('cetak.cetakData',compact(
            'data',
            'date',
            'username',
            'datacount',
            'tegangan',
            'ph',
            'temperature',
            'teganganMin',
            'phMin',
            'temperatureMin',
            'teganganMax',
            'phMax',
            'temperatureMax',
            'dataterakhir',
            'auth'
        ));
        return $pdf->stream("data-sensor.pdf");
    }
}
