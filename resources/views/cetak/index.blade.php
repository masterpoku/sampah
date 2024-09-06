@push('css_vendor')
    <link rel="stylesheet" href="{{asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endpush
@extends('layouts.app')
@section('title','Cetak')
@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
    @parent
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Cetak Laporan Sensor
                    </h4>
                </div>
                    <div class="card-body">
                        <table id="example1" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 0;
                                @endphp
                                @forelse ($data as $item )
                                @php $no++ @endphp
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{tanggal_indonesia($item->date)}}</td>
                                        <td>
                                            <span class="badge badge-warning">
                                                {{$item->name}} - #{{$item->id_device}}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{url('data-detail/'.$item->id.'/'.$item->name.'/'.$item->date)}}" class="btn btn-sm btn-success"><i data-feather='eye'></i></a>
                                            <a href="{{url('cetak/data/'.$item->id.'/'.$item->name.'/'.$item->date)}}" class="btn btn-sm btn-info"><i data-feather='printer'></i></a>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@endsection
@push('script_vendor')
    <script src="{{asset('template/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@endpush
@push('script')
    <script>
        $(function () {
            $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            });
        });
</script>
@endpush
