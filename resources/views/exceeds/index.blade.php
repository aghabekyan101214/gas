@extends('layouts.app')

@section('content')
    <div class="white-box">
        <h3 class="box-title m-b-10">Exceeds</h3>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 150px">Station</th>
                    <th style="width: 150px">Dispenser</th>
                    <th>Liter</th>
                    <th>Bonus</th>
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
                            <td>@if(isset($d->bonuses->bonus)) {{ $d->bonuses->bonus }} @endif</td>
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
            let station = $(".station").val();
            let dispenser = $(".dispenser").val();
            let bonus_type = $(".bonus_type").val();
            let client = $(".client").val();
            let created_at = $(".daterange-datepicker").val().split(" - ");
            let from = created_at[0];
            let to = created_at[1];
            let params = {};
            if(station != "") params.station_id = station;
            if(dispenser != "") params.dispenser_id = dispenser;
            if(bonus_type != "") params.bonus_type = bonus_type;
            if(client != "") params.client_id = client;
            if(created_at != "") { params.from = from; params.to = to; }
            var query = $.param(params);
            window.location.replace("/admin/exceeds?" + query);
        }

        $(document).on("click", ".applyBtn", function () {
            filter();
        });
    </script>
@endsection
