@extends('layouts.app')
@section('title', 'Device')
@section('breadcrumb')
    @parent
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Daftar Device</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Device</th>
                        <th>Nama Device</th>
                        <th>User Device</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($devices as $item)
                        @php $no++; @endphp
                        <tr>
                            <td>{{ $no }}</td>
                            <td>
                                <span class="badge badge-success">
                                    {{ $item->user->id_device }}
                                </span>
                            </td>
                            <td>{{ $item->nama_devices }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                @if ($item->publish != 0)
                                    <?php $button = 'btn-success'; ?>
                                @else
                                    <?php $button = 'btn-dark'; ?>
                                @endif
                                <a href="{{ route('publish_device', $item->id) }}" class="btn btn-sm {{ $button }}">
                                    <i data-feather='send'></i>
                                </a>
                                <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $item->id }}"
                                    class="btn btn-sm btn-primary">
                                    <i data-feather='edit-3'></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- modal --}}
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
@push('script')
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
@endpush
