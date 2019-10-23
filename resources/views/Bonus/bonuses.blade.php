@extends('layouts.app')

@section('content')

    <div class="white-box">
        <h3 class="box-title m-b-10">Bonus data</h3>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <select onchange="filter()" name="station_id" id="" class="form-control station">
                            <option value="">All</option>
                            @foreach($stations as $s)
                                <option @if($request->station_id == $s->id) selected @endif value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td style="width: 150px">
                        <select onchange="filter()" name="dispenser_id" id="" class="form-control dispenser">
                            <option value="">All</option>
                            @foreach($dispensers as $d)
                                <option @if($request->dispenser_id == $d->id) selected @endif value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>

                    </td>

                    <td></td>

                    <td>

                    </td>

                    <td>
                        <select onchange="filter()" name="client_id" id="" class="form-control select2 client">
                            <option value="">All</option>
                            @foreach($clients as $c)
                                <option @if($request->client_id == $c->id) selected @endif value="{{ $c->id }}">{{ $c->name . " " . $c->surname }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="text" class="form-control daterange-datepicker" @if(null != $request->from && null != $request->to) value="{{ $request->from . " - " . $request->to }}" @else value=" " @endif>
                    </td>

                </tr>
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
                    @foreach($fuels as $bin => $fuel)
                        <tr>
                            <td>{{ $fuel->dispensers->stations->name  }}</td>
                            <td>{{ $fuel->dispensers->name }}</td>
                            <td>{{ $fuel->liter }}</td>
                            <td>@if(isset($fuel->bonuses->bonus)) {{ $fuel->bonuses->bonus }} @endif</td>
                            <td>@if(isset($fuel->clients->name)) {{ $fuel->clients->name }} @endif</td>
                            <td>{{ $fuel->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $fuels->appends(request()->except('page'))->links() }}
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
            window.location.replace("/admin/bonuses?" + query);
        }

        $(document).on("click", ".applyBtn", function () {
            filter();
        });
    </script>
@endsection
