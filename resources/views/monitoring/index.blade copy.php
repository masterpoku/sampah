@extends('layouts.app')
@section('title','Monitoring')
@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('title')</li>
    @parent
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Monitoring Sensor</h4>
                <form action="{{route('deleteall')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                 <input type="checkbox" class="form-check-input position-static" id="master">
                                </th>
                                <th>No</th>
                                <th>Tegangan</th>
                                <th>Status PH</th>
                                <th>Temperature</th>
                                <th>Status</th>
                            </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($data as $item)
                        @php
                            $no++;
                        @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[{{$item->id}}]" class="form-check-input sub_chk" value="{{$item->id}}">
                                </td>
                                <td>{{$no}}</td>
                                <td>{{$item->tegangan}} <sup>ADC</sup></td>
                                <td>{{$item->ph}}<sup>pH</sup></td>
                                <td>{{$item->temp}} C<sup>o</sup></td>
                                <td>
                                    @if ($item->status == 'asam')
                                    <span class="badge badge-warning">
                                        Asam
                                    </span>
                                    @elseif ($item->status == 'normal')
                                    <span class="badge badge-primary">
                                        Normal
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        Basa
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
 $('#master').on('click', function(e) {
         if($(this).is(':checked',true))
         {
            $(".sub_chk").prop('checked', true);
         } else {
            $(".sub_chk").prop('checked',false);
         }
        });
</script>
@endpush
