@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
    @parent
@endsection
@section('content')
    @if ($ok == 0)
        <div class="col-lg-12">
            <div class="alert alert-danger" role="alert">
                <div class="alert-body">
                    <i data-feather="star"></i>
                    <span>
                        <strong>Peingatan ! </strong>Device Belum <strong> Active</strong>
                        Silahkan hubungi admin untuk aktivasi </br>
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger" id="peringatan" role="alert" style="display: block;">
                    <div class="alert-body">
                        <span>
                            Peringatan ! Alat tidak berfungsi/dalam keadaan mati, segera periksa
                            dan pastikan alat kembali berfungsi dengan
                            baik. Data terakhir masuk pada <b><span id="time"></span></b>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div id="kontent_data" style="display: block;">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <span id="container"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            Device info
                        </div>
                        <div class="card-body">
                            <table class="table">
                                @foreach ($data as $item)
                                    <tr>
                                        <td>ID Device</td>
                                        <td>:</td>
                                        <td><span class="btn btn-sm btn-success">{{ $item->user->id_device }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Nama device</td>
                                        <td>:</td>
                                        <td>{{ $item->nama_devices }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Controller</td>
                                        <td>:</td>
                                        <td><span class="badge badge-danger">2</span></td>
                                    </tr>
                                    <tr>
                                        <td>Status device</td>
                                        <td>:</td>
                                        <td>
                                            @if ($item->publish == 1)
                                                <span class="badge badge-primary">
                                                    Aktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-body" id="bg-ph">
                            <h4 class="text-white"><span id="text-level1"></span></h4>
                        </div>
                        <div class="card-footer">
                            <table>
                                <tr>
                                    <td>
                                        <h3 id="ph_1"></h3>
                                    </td>
                                    <td><sup>pH</sup></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3 id="teg"></h3>
                                    </td>
                                    <td colspan="2"><sup>ADC</sup></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
@endsection
@push('script')
    <script src="{{ asset('template/assets/js/highcharts.js') }}"></script>
    <script src="{{ asset('template/assets/js/highcharts-more.js') }}"></script>
    <script src="{{ asset('template/js/waktu-peringatan.js') }}"></script>
    <script>
        var APP_URL = "{{ url('/') }}";
    
        let chartT = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line'
            },
            title: {
                text: 'Grafik Sensor'
            },
            series: [{
                name: 'Temperature (°C)',
                color: '#00008B',
                data: []
            }],
            yAxis: {
                title: {
                    text: 'Data Sensor'
                }
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            credits: {
                enabled: false
            }
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
                    var sensor = response.sensor;
                    var currentTime = (new Date()).getTime();
                    var tempData = parseFloat(sensor.temp);
    
                    if (chartT.series[0].data.length > 30) {
                        chartT.series[0].addPoint([currentTime, tempData], true, true, true);
                    } else {
                        chartT.series[0].addPoint([currentTime, tempData], true, false, true);
                    }
    
                    updatePhDisplay(sensor.ph);
                    document.getElementById("ph_1").innerHTML = Math.round(sensor.ph);
                    document.getElementById("teg").innerHTML = Math.round(sensor.tegangan);
                }
            });
        }
    
        function updatePhDisplay(ph) {
            var phClass = $('.ph');
            var bgPh = $('#bg-ph');
            var textLevel1 = $('#text-level1');
    
            if (ph > 0 && ph < 6) {
                phClass.addClass('text-danger').removeClass('text-success text-primary text-warning');
                bgPh.addClass('info-box-icon bg-danger elevation-1').removeClass('bg-warning bg-primary bg-success');
                textLevel1.html('Acid');
            } else if (ph <= 7) {
                phClass.addClass('text-danger').removeClass('text-success text-warning');
                bgPh.addClass('info-box-icon bg-success elevation-1').removeClass('bg-danger bg-primary bg-warning');
                textLevel1.html('Normal');
            } else {
                phClass.addClass('text-success').removeClass('text-danger text-warning');
                bgPh.addClass('info-box-icon bg-primary elevation-1').removeClass('bg-danger bg-success bg-warning');
                textLevel1.html('Alkaline');
            }
        }
    
        setInterval(AllData, 1000);
    </script>
    
@endpush
