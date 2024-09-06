@extends('layouts.app')
@section('title', 'Monitoring')
@section('breadcrumb')
    @parent
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Monitoring Sensor</h5>
            <div>
                {!! Form::label('id_device', 'ID Device', ['class' => 'mr-2']) !!}
                {!! Form::select('id_device', $Device, null, ['id' => 'devices', 'class' => 'custom-select']) !!}
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Tegangan</th>
                        <th>Ph</th>
                        <th>Temperature</th>
                    </tr>
                </thead>
                <tbody id="data_id">
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($data as $item)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <td>{{ $item->waktu }}</td>
                            <td>{{ round($item->tegangan, 2) }}</td>
                            <td>
                                @php
                                    $ph = round($item->ph, 2);
                                    $badgeClass = '';
                                    $statusText = '';
                                    if ($ph <= 6) {
                                        $badgeClass = 'badge-danger';
                                        $statusText = 'Acid';
                                    } elseif ($ph == 7) {
                                        $badgeClass = 'badge-success';
                                        $statusText = 'Natural';
                                    } else {
                                        $badgeClass = 'badge-info';
                                        $statusText = 'Alkaline';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $ph }} - {{ $statusText }}</span> 
                            </td>                            
                            <td>
                                <span class="badge badge-dark">
                                    {{ round($item->temp) }}</td>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#devices').on('change', function(e) {
                var id = e.target.value;
                $.get('{{ url('id_devices') }}/' + id, function(data) {
                    console.log(id);
                    console.log(data);
                    $('#data_id').empty();
                    $.each(data, function(index, element) {
                        $('#data_id').append("<tr><td>" + element.waktu + "</td><td>" +
                            element.tegangan + "</td><td>" + element.ph + "</td><td>" +
                            element.temp + "</td></tr>")
                    });
                });
            });
        });
    </script>
@endpush
