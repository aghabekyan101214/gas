@extends('layouts.app')

@section('content')
    <div class="white-box">
        <h3 class="box-title m-b-10">Station data</h3>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Station</th>
                    <th>Dispenser</th>
                    <th>Price</th>
                    <th>Liter</th>
                    <th>Bonus</th>
                    <th>Client</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($fuels as $bin => $fuel)
                        <tr>
                            <td>{{ $fuel->id }}</td>
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
            {{ $fuels->links() }}
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
