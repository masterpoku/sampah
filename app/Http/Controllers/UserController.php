<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->role_id;
        if ($user == 1) {
            $data = User::
            where('role_id','=', 2)
            ->orderBy('name','ASC')
            ->get();

            return view('user.index',compact('data'));
            # code...
        } else {
            return view('dashboard');
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
        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'email'     => 'required|unique:users,email',
            'password'  =>' required|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $data1 = [
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role_id'       => 2,
            'id_device'     => Str::random(8),
            'is_active'     => 0,            
            'profile_photo_path' => '/user/default_image.png'
        ];
        $user = User::create($data1);
        $id = DB::getPdo()->lastInsertId();
        $data2 = [
            'id_user'   => $id,
            'nama_devices' => 'Device_'.$request->name,
            'mode'  => 0,
            'keterangan' => 'Device Utama '.$request->name,
            'publish' => 0
        ];
        $devices = DB::table('devices')->insert($data2);
        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil disimpan',
            'data'      => $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Uost',
            'data'    => $user
    ]);
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
        $validator = Validator::make($request->all(),[
            'name'  => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422 );
        }

        $user = User::find($id);
        $user->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil diupdate',
            'data'      => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         if(User::find($id)->delete()) :
            Alert::success('Berhasil!', 'Data Berhasil Dihapus');
         else :
            Alert::error('Terjadi Kesalahan!', 'Data Gagal Dihapus');
         endif;

         return back();
    }
    public function login(Request $request)
    {
    //    $credentials = $request->validate([
    //         'email' => ['required'],
    //         'password' => ['required'],
    //     ]);
        if(auth()->attempt())
        {
            $user = auth()->user();
        }
        return response()->json([
            'message' => 'Your credential does not match.',
        ], 401);
    }

    public function deleteUser($id)
    {

    }

}
