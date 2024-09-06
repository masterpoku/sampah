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
@if ($ok == 0 )
    <div class="col-lg-12">
    <div class="alert alert-dark alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="fas fa-bullhorn"></i> Alert!</h5>
        <strong>Peingatan ! </strong>Device Belum <strong> Active</strong>
        Silahkan hubungi admin untuk aktivasi </br>
    </div>
</div>
@else
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Cetak Laporan Sensor
                    </h4>
                </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-lg-12">
                            <table class="table" id="example2">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Sensor</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 0; ?>
                            @foreach ($data as $item )
                            <?php $no++ ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{tanggal_indonesia($item->date)}}</td>
                                    <td>{{$item->jumlah}}</td>
                                    <td>
                                        <a href="{{route('PDF',$item->date)}}" class="btn btn-sm btn-success">Cetak</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
@endif
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
