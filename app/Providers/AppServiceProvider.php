<?php

namespace App\Providers;

use App\Models\Devices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('monitoring.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
        view()->composer('monitoring.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
        view()->composer('control.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
        view()->composer('pengguna.dahsborad.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
        view()->composer('devices.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
        view()->composer('pengguna.cetak.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
        view()->composer('mode.index', function($view){
            $Auth = Auth::user()->id;
            $data = Devices::where('id_user','=',$Auth)->get();
            foreach ($data as $item) {
                $ok = $item->publish;
            }
            $view->with('ok', $ok);
        });
    }
}
