@extends('layouts.app')

@section('content')
    <div class="white-box">
        <h3 class="box-title m-b-10">Redeem bonus</h3>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Number</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                {{--                @foreach($data['users'] as $key => $value)--}}
                <tr>
                    {{--                        <td>{{$key+1}}</td>--}}

                </tr>
                {{--                @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
