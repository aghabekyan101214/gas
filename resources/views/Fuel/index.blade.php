@extends('layouts.app')

@section('content')
    <div class="white-box">
        <h3 class="box-title m-b-10">Station data</h3>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                <tr>
                    <th>Station</th>
                    <th>Dispenser</th>
                    <th>Price</th>
                    <th>Liter</th>
                    <th>Bonus</th>
                    <th>Client</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td colspan="7">
                        <form action="{{ url('admin/fuels') }}" class="filter">
                            <div class="col-md-2">
                                <select onchange="$('.filter').submit()" name="station_id" id="" class="form-control">
                                    <option value="">All</option>
                                    @foreach($stations as $s)
                                        <option @if($request->station_id == $s->id) selected @endif value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select onchange="$('.filter').submit()" name="dispenser_id" id="" class="form-control">
                                    <option value="">All</option>
                                    @foreach($dispensers as $d)
                                        <option @if($request->dispenser_id == $d->id) selected @endif value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </td>
                </tr>
                </thead>
                <tbody>

                    @foreach($fuels as $bin => $fuel)
                        <tr>
                            <td>{{ $fuel->dispensers->stations->name  }}</td>
                            <td>{{ $fuel->dispensers->name }}</td>
                            <td>{{ $fuel->price }}</td>
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
    </script>
@endsection
