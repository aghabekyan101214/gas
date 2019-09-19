@extends('layouts.app')

@section('content')
    <div class="white-box">
        <h3 class="box-title m-b-10">Bonus</h3>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>station number</th>
                    <th>Date</th>
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
