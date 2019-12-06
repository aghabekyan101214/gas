@extends('layouts.app')

@section('content')
    <div class="white-box">
        <h3 class="box-title m-b-10">Exceeds</h3>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <select onchange="filter()" name="date" id="" class="form-control date">
                            <option value="">Select Date</option>
                            @foreach($exceedFuels as $e)
                                <option @if($request->date == $e->day) selected @endif value="{{ $e->day }}">{{ $e->day }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150px">Station</th>
                    <th style="width: 150px">Dispenser</th>
                    <th>Liter</th>
                    <th>Client</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($data as $bin => $d)
                        <tr>
                            <td>{{ $d->dispensers->stations->name  }}</td>
                            <td>{{ $d->dispensers->name }}</td>
                            <td>{{ $d->liter }}</td>
                            <td>@if(isset($d->clients->name)) {{ $d->clients->name }} @endif</td>
                            <td>{{ $d->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
{{--            {{ $fuels->appends(request()->except('page'))->links() }}--}}
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                "paging":   false,
            } );
        } );

        function filter() {
            let date = $(".date").val();
            let params = {};
            if(date != "") params.date = date;
            var query = $.param(params);
            window.location.replace("/admin/exceeds?" + query);
        }

        $(document).on("click", ".applyBtn", function () {
            filter();
        });
    </script>
@endsection
