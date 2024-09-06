@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
    @parent
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="font-weight-bolder mb-0">{{ $device }}</h2>
                        <a class="card-text" href="{{ route('devices.index') }}">Jumlah Device</a>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="cpu" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="font-weight-bolder mb-0">{{ $users }}</h2>
                        <a class="card-text" href="{{ route('user.index') }}">Jumlah User</a>
                    </div>
                    <div class="avatar bg-light-success p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="users" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card card-transaction">
                <div class="card-header">
                    <h4 class="card-title">Aktifitas</h4>
                </div>
                <div class="card-body">
                    @foreach ($listnotifikasi as $key => $notifikasi)
                        @foreach ($notifikasi as $item)
                            <div class="transaction-item">
                                <div class="media">
                                    <div class="avatar {{ $key == 'user' ? 'bg-light-warning' : ($key == 'device' ? 'bg-light-danger' : 'bg-light-primary') }} rounded">
                                        <div class="avatar-content">
                                            <i data-feather="{{ $key == 'user' ? 'users' : ($key == 'device' ? 'cpu' : 'pocket') }}" class="avatar-icon font-medium-3"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                       <a href="{{route("$key.index")}}"><h6 class="transaction-title">
                                        {{ $item->name ?? $item->email ?? $item->user->name ?? "" }}    
                                    </h6>{{$key}} Baru</a>
                                    </div>
                                </div>
                                <div class="font-weight-bolder text-dark">{{ now()->parse($item->created_at)->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                
        </div>
        </section>
    </div>

    </div>
@endsection
@push('script')
    <script src="{{ asset('template/js/highcharts.js') }}"></script>
    <script src="{{ asset('template/js/highcharts-more.js') }}"></script>

    <script>
        var APP_URL = "{{ url('/') }}";

        let chartT = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'spline'
            },
            title: {
                text: 'Grafik Sensor'

            },
            series: [{
                name: 'Temperature',
                color: '#00008B',
                data: []
            }, ],
            yAxis: {
                title: {
                    text: 'Data Sensor'
                },
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: false
                    },
                }
            },
            credits: {
                enabled: false
            },
        });

        function AllData() {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
            $.ajax({
                type: 'GET',
                url: APP_URL + '/ph',
                dataType: "json",
                success: function(response) {
                    var ph = response.sensor.ph
                    var z = (new Date()).getTime()
                    if (chartT.series[0].data.length > 30) {
                        chartT.series[0].addPoint([z, parseFloat(response.sensor.temp)], true, true,
                            true);
                    } else {
                        chartT.series[0].addPoint([z, parseFloat(response.sensor.temp)], true, false,
                            true);
                    }

                    if (response.sensor.ph > 0 && response.sensor.ph <= 6) {
                        $('.ph').addClass('text-danger').removeClass(
                            'text-success text-danger text-primary text-warning');
                        $('#bg-ph').addClass('info-box-icon bg-danger elevation-1').removeClass(
                            'bg-warning bg-primary bg-success');
                        $('#text-level1').html('Acid');

                    } else if (response.sensor.ph == 7) {
                        $('.ph').addClass('text-danger').removeClass('text-success text-warning');
                        $('#bg-ph').addClass('info-box-icon bg-success elevation-1').removeClass(
                            'bg-danger bg-primary bg-c-warning');
                        $('#text-level1').html('Natural');
                    } else {
                        $('.ph').addClass('text-success').removeClass('text-danger text-warning');

                        $('#bg-ph').addClass('info-box-icon bg-primary elevation-1').removeClass(
                            'bg-danger bg-success bg-warning');

                        $('#text-level1').html('Alkaline');

                    }
                    document.getElementById("ph_1").innerHTML = ph;
                }
            })
        };
        setInterval(function() {
            AllData();
        }, 1000)
    </script>
    {{-- <script src="{{asset('template/js/waktu-peringatan.js')}}"></script> --}}
@endpush
