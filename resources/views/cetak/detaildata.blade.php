@extends('layouts.app')
@section('title','Detail Cetak')
@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
    @parent
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
            <div class="card-header">
                <h6>Detail Data</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>{{$username}}</td>
                    </tr>
                    <tr>
                        <td>Sensor Date</td>
                        <td>:</td>
                        <td>
                            <span class="badge badge-primary">
                                <i>
                                    {{tanggal_indonesia($date)}}
                                </i>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah data</td>
                        <td>:</td>
                        <td>
                            <span class="badge badge-danger">
                                {{$datacount}}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <center><h6>Rekap Nilai Sensor {{tanggal_indonesia($date)}} </h6></center>
                </div>
                <div class="card-body">
                    <h6>Nilai Rata-rata</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th>Tegangan</th>
                            <th>PH</th>
                            <th>Temperature</th>
                        </tr>
                        <tr>
                            <td>{{$tegangan}}</td>
                            <td>{{$ph}}</td>
                            <td>{{$temperature}}</td>
                        </tr>
                    </table>
                    <br>
                     <h6>Nilai Tertinggi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th>Tegangan</th>
                            <th>PH</th>
                            <th>Temperature</th>
                        </tr>
                        <tr>
                            <td>{{$teganganMax}}</td>
                            <td>{{$phMax}}</td>
                            <td>{{$temperatureMax}}</td>
                        </tr>
                    </table>
                     <br>
                     <h6>Nilai Terrendah</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th>Tegangan</th>
                            <th>PH</th>
                            <th>Temperature</th>
                        </tr>
                        <tr>
                            <td>{{$teganganMin}}</td>
                            <td>{{$phMin}}</td>
                            <td>{{$temperatureMin}}</td>
                        </tr>
                    </table>
                    <h6>Data terakhir</h6>
                    <table class="table">
                        <tr>
                            <th>Waktu</th>
                            <th>Tegangan</th>
                            <th>PH</th>
                            <th>Temperature</th>
                        </tr>
                        @foreach ($dataterakhir as $item )
                            <tr>
                                <td>{{$item->waktu}}</td>
                                <td>{{$item->tegangan}}</td>
                                <td>{{$item->ph}}</td>
                                <td>{{$item->temp}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
