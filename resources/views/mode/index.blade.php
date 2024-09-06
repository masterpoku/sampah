@push('css')
    <link rel="stylesheet" href="{{ asset('template/assets/css/button.css') }}">
    <style>
        .icon-lg {
            font-size: 3rem;
        }
    </style>
@endpush
@extends('layouts.app')
@section('title', 'Mode')
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
            @foreach ($data as $item)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="mb-2">Mode Device</h4>
                                    <h5>Nama : {{ $item->nama_devices }}</h5>
                                    <input type="checkbox" data-id="{{ $item->id }}" data-toggle="toggle"
                                        data-on="Manual" data-off="Automatis" data-onstyle="info" class="toggle-class"
                                        data-offstyle="success" {{ $item->mode ? 'checked' : '' }}>
                                </div>
                                <div class="col-lg-6 d-flex align-items-center justify-content-center"
                                    style="height: 100%;">
                                    <i data-feather='zap' id="icon-id" style="width: 70px; height: 120px; line-height: 120px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
@push('script_vendor')
    <script src="{{ asset('template/assets/js/asset-button.js') }}"></script>
    <script>
        $(document).ready(function() {
            var id = $('.toggle-class').data('id');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Fetch initial mode status from server
            $.ajax({
                type: "POST",
                url: '/getStatus',
                data: { 'id': id },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: "json",
                success: function(response) {
                    var mode = response.mode;
                    var icon = $('#icon-id');
                    var toggle = $('.toggle-class');

                    if (mode === 1) {
                        icon.addClass('text-info');
                        toggle.prop('checked', true).change();
                    } else {
                        icon.removeClass('text-info');
                        toggle.prop('checked', false).change();
                    }

                    // Initialize Feather icons
                    feather.replace();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            $('.toggle-class').change(function() {
                var mode = $(this).prop('checked') ? 1 : 0;
                
                $.ajax({
                    type: "POST",
                    url: '/changeStatus',
                    data: {
                        'mode': mode,
                        'id': id
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    dataType: "json",
                    success: function(response) {
                        var icon = $('#icon-id');
                        
                        if (mode === 1) {
                            icon.addClass('text-info');
                        } else {
                            icon.removeClass('text-info');
                        }

                        // Refresh Feather icons
                        feather.replace();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    
@endpush
