@extends('layouts.app')
@section('title', 'User')
@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
    @parent
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                Daftar user
            </h4>
        </div>
        <div class="card-body">
            <a href="javascript:void(0)" id="btn-create-user" class="btn btn-sm btn-info">Tambah User</a>
            <table class="table" id="example1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Avatar</th>
                        <th>Id Device</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data as $item)
                        @php $no++; @endphp
                        <tr>
                            <td>{{ $no }}</td>
                            <td>
                                <img src="{{ url('storage', $item->profile_photo_path) }}" alt=""
                                     class="rounded-circle" style="width: 80px; height: 80px;">
                            </td>
                            <td>
                                @if ($item->id_device == null)
                                    <span class="badge badge-danger">
                                        User Belum aktive
                                    </span>
                                @else
                                    <h2 class="badge badge-success">
                                        {{ $item->id_device }}
                                    </h2>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->role_id == 2)
                                    <span class="badge badge-success">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td>
                                <form method="post" action="{{ url('user', $item->id) }}" id="delete{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteData({{ $item->id }})">
                                        <i data-feather='trash'></i></button>
                                    <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $item->id }}"
                                        class="btn btn-sm btn-primary"><i data-feather='edit-3'></i></a>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name" class="control-label">Username</label>
                        <input type="text" class="form-control" id="name">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Email</label>
                        <input type="email" class="form-control" id="email">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Password</label>
                        <input type="password" class="form-control" id="password">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password-edit"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-success" id="store">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modalEdit --}}
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit User <span id="id_devices"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="post_id">

                    <div class="form-group">
                        <label for="name" class="control-label">Username</label>
                        <input type="text" class="form-control" id="name-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name-edit"></div>
                    </div>


                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" id="email-edit" readonly>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email-edit"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-warning" id="update">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
    {{-- endModalEdit --}}
@endsection
@push('script')
    <script>
        $('body').on('click', '#btn-create-user', function() {
            $('#modal-create').modal('show');
        });
        $('#store').click(function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/user`,
                type: "POST",
                cache: false,
                data: {
                    "name": name,
                    "email": email,
                    "password": password,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    $('#name').val('');
                    $('#email').val('');
                    $('#password').val('');
                    location.reload();
                    $('#modal-create').modal('hide');
                }
            });
        });
    </script>
    <script>
        $('body').on('click', '#btn-edit-post', function() {

            let post_id = $(this).data('id');
            console.log(post_id);


            $.ajax({
                url: `/user/${post_id}`,
                type: "GET",
                cache: false,
                success: function(response) {

                    //fill data to form
                    $('#post_id').val(response.data.id);
                    $('#name-edit').val(response.data.name);
                    $('#email-edit').val(response.data.email);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });
        $('#update').click(function(e) {
            e.preventDefault();
            let post_id = $('#post_id').val();
            let name = $('#name-edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/user/${post_id}`,
                type: "PUT",
                cache: false,
                data: {
                    "name": name,
                    "_token": token
                },
                success: function(response) {
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
                error: function(error) {
                    if (error.responseJSON.name[0]) {
                        $('#alert-name-edit').removeClass('d-none');
                        $('#alert-name-edit').addClass('d-block');

                        $('#alert-name-edit').html(error.responseJSON.name[0]);
                    }
                }
            });
        });
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
        function deleteData(id) {
            Swal.fire({
                title: 'PERINGATAN!',
                text: "Yakin ingin menghapus data user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $('#delete' + id).submit();
                }
            })
        }
    </script>
@endpush
