<?php

namespace App\Http\Controllers;

use App\Models\{
    Devices,
    User
};

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->id;
        if ($id == 1) {
            $users = User::count();
            $device = Devices::where('publish', '=', 0)->count();
            $listnotifikasi = [
                'user'      => User::whereDate('created_at', date('Y-m-d'))->get(),
                'devices' => Devices::where('publish', '=', 0)->get(),
            ];
            $countNotifikasi = collect($listnotifikasi)->map(fn ($item) => $item->count())->sum();
            return view('dashboard', compact('countNotifikasi', 'listnotifikasi', 'users', 'device'));
        } else {
            $id = Auth::user()->id;
            $data = Devices::where('id_user', '=', $id)->get();

            return view('pengguna.dahsborad.index', compact('data'));
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
    public function show(string $id)
    {
        //
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
}
