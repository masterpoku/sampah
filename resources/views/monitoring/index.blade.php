@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
@endpush
@extends('layouts.app')
@section('title', 'Monitoring')
@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
    @parent
@endsection
@section('content')
    @if ($ok == 0)
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
                        <h4>Monitoring Sensor</h4>
                        <div class="card-body">
                            <table class="table table-striped table-bordered mont_datatable" id="mont_datatable">
                                <thead>
                                    <tr>
                                        <th width="6%"><input type="checkbox" name="main_checkbox"><label></label></th>
                                        <th>Waktu</th>
                                        <th>Username</th>
                                        <th>Tegangan</th>
                                        <th>Ph</th>
                                        <th>Temp</th>
                                        <th>Aksi <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete
                                                All</button></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    @endif
@endsection
@push('script_vendor')
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
@endpush
@push('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.mont_datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            rowGroup: {
                dataSrc: 2
            },
            ajax: "{{ route('monitoring.index') }}",
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'waktu',
                    name: 'waktu'
                },
                {
                    data: 'id_user',
                    name: 'user'
                },
                {
                    data: 'tegangan',
                    name: 'tegangan'
                },
                {
                    data: 'ph',
                    name: 'ph'
                },
                {
                    data: 'temp',
                    name: 'temp'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        }).on('draw', function() {
            $('input[name="country_checkbox"]').each(function() {
                this.checked = false;
            });
            $('input[name="main_checkbox"]').prop('checked', false);
            $('button#deleteAllBtn').addClass('d-none');
        });
        $(document).on('click', 'input[name="main_checkbox"]', function() {
            if (this.checked) {
                $('input[name="country_checkbox"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[name="country_checkbox"]').each(function() {
                    this.checked = false;
                });
            }
            toggledeleteAllBtn();

        });
        $(document).on('change', 'input[name="country_checkbox"]', function() {
            if ($('input[name="country_checkbox"]').length == $('input[name="country_checkbox"]:checked').length) {
                $('input[name="main_checkbox"]').prop('checked', true);
            } else {
                $('input[name="main_checkbox"]').prop('checked', false);
            }
            toggledeleteAllBtn();
        });

        function toggledeleteAllBtn() {
            if ($('input[name="country_checkbox"]:checked').length > 0) {
                $('button#deleteAllBtn').text('Delete (' + $('input[name="country_checkbox"]:checked').length + ')')
                    .removeClass('d-none');
            } else {
                $('button#deleteAllBtn').addClass('d-none');
            }
        }
        $(document).on('click', 'button#deleteAllBtn', function() {
            var checked = [];
            $('input[name="country_checkbox"]:checked').each(function() {
                checked.push($(this).data('id'));
                console.log(checked)
            });
            var url = '{{ route('delete.selected') }}';
            if (checked.length > 0) {
                swal.fire({
                    title: 'Are you sure?',
                    html: 'You want to delete <b>(' + checked.length + ')</b> <strong>Data Sensor</strong>',
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#556ee6',
                    cancelButtonColor: '#d33',
                    width: 300,
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.value) {
                        $.post(url, {
                            countries_ids: checked
                        }, function(data) {
                            if (data.code == 1) {
                                $('#mont_datatable').DataTable().ajax.reload(null, true);
                                toastr.success(data.msg);
                            }
                        }, 'json');
                    }
                })
            }
        });
        $(document).on('click', '#deleteSensorBtn', function() {
            var sensor_id = $(this).data('id');
            var url = '<?= route('delete.sensor') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>delete</b> this Sensor',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 450,
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    $.post(url, {
                        sensor_id: sensor_id
                    }, function(data) {
                        if (data.code == 1) {
                            $('#mont_datatable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });
    </script>
@endpush
