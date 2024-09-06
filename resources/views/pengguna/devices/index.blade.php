@push('css_vendor')
    <link rel="stylesheet" href="{{asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@extends('layouts.app')
@section('title','Devices')
@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
    @parent
@endsection
@section('content')
<div class="row">
    @foreach ($devices as $item )
    @if ($item->publish == 0)
    <div class="col-lg-12">
        <div class="alert alert-dark alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="fas fa-bullhorn"></i> Alert!</h5>
            <strong>Peingatan ! </strong>Device Belum <strong> Active</strong>
            Silahkan hubungi admin untuk aktivasi </br>
        </div>
    </div>
    @endif
    @endforeach
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    Daftar Device
                </h4>
            </div>
            <div class="card-body">
                @if ($devicesCount == 0)
                    <a href="javascript:void(0)" id="btn-create-device" class="btn btn-sm btn-primary mb-3">Tambah Device</a>
                @endif
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Device</th>
                            <th>Nama Device</th>
                            <th>User Device</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                            @foreach ($devices as $item)
                                @php
                                    $no++;
                                @endphp
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>
                                        @if ($item->publish == 0)
                                        <span class="badge badge-dark">ID Device Kosong</span>
                                        @else
                                        <span class="badge badge-success">{{$item->user->id_device}}</span>
                                        @endif
                                    </td>
                                    <td>{{$item->nama_devices}}</td>
                                    <td>{{$item->user->name}}</td>
                                    <td>{{$item->keterangan}}</td>
                                    <td>
                                        @if ($item->publish == 0)
                                            <span class="badge badge-dark">Not Active</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="post" action="{{url('devices',$item->id)}}" id="delete{{$item->id}}">
                                            @if ($item->publish == 0)
                                                <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $item->id }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData({{$item->id}})" >
                                                <i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD DEVICES <span id="id_devices"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Nama Device</label>
                    <input type="text" class="form-control" id="nama_devices">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_devices-edit"></div>
                </div>


                <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-success" id="store">Tambah</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT DEVICES <span id="id_devices"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="name" class="control-label">Nama Device</label>
                    <input type="text" class="form-control" id="nama_devices-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_devices-edit"></div>
                </div>


                <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan-edit" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-warning" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>
{{-- endModal --}}
@endsection
@push('script_vendor')
    <script src="{{asset('template/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('template/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
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
<script>
     $('body').on('click','#btn-create-device',function(){
        $('#modal-create').modal('show');
    });
    $('#store').click(function(e){
        e.preventDefault();
        let nama_devices = $('#nama_devices').val();
        let keterangan = $('#keterangan').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url : `/devices`,
            type : "POST",
            cache: false,
            data : {
                "nama_devices"  : nama_devices,
                "keterangan"    : keterangan,
                "_token"        : token
            },
            success:function(response)
            {
               Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                $('#nama_devices').val('');
                $('#keterangan').val('');
                location.reload();
                $('#modal-create').modal('hide');
            }
        });
    });
</script>
<script>
    $('body').on('click', '#btn-edit-post', function () {

        let post_id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `/devices/${post_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#post_id').val(response.data.id);
                $('#id_devices').val(response.data.id_user);
                $('#nama_devices-edit').val(response.data.nama_devices);
                $('#keterangan-edit').val(response.data.keterangan);

                //open modal
                $('#modal-edit').modal('show');
            },
             error:function(error)
            {
                if (error.responseJSON.nama_devices[0]) {
                    $('#alert-nama_devices-edit').removeClass('d-none');
                    $('#alert-nama_devices-edit').addClass('d-block');

                    $('#alert-nama_devices-edit').html(error.responseJSON.nama_devices[0]);
                }
                if (error.responseJSON.keterangan[0]) {
                    $('#alert-keterangan-edit').removeClass('d-none');
                    $('#alert-keterangan-edit').addClass('d-block');
                    $('#alert-keterangan-edit').html(error.responseJSON.keterangan[0]);
                }
            }
        });
    });
    $('#update').click(function(e){
        e.preventDefault();
        let post_id = $('#post_id').val();
        let nama_devices = $('#nama_devices-edit').val();
        let keterangan = $('#keterangan-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: `/devices/${post_id}`,
            type: "PUT",
            cache: false,
            data: {
                "nama_devices": nama_devices,
                "keterangan": keterangan,
                "_token": token
            },
            success: function (response) {
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                location.reload();
                 $('#modal-edit').modal('hide');
            },
            error:function(error)
            {
                if (error.responseJSON.nama_devices[0]) {
                    $('#alert-nama_devices-edit').removeClass('d-none');
                    $('#alert-nama_devices-edit').addClass('d-block');

                    $('#alert-nama_devices-edit').html(error.responseJSON.nama_devices[0]);
                }
                if (error.responseJSON.keterangan[0]) {
                    $('#alert-keterangan-edit').removeClass('d-none');
                    $('#alert-keterangan-edit').addClass('d-block');
                    $('#alert-keterangan-edit').html(error.responseJSON.keterangan[0]);
                }
            }
        });
    });
</script>
 <script>
    function deleteData(id){
    Swal.fire({
            title: 'PERINGATAN!',
            text: "Yakin ingin menghapus data devices ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.value) {
                $('#delete'+id).submit();
                }
            })
}
</script>
@endpush
