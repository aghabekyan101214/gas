@extends('layouts.app')

@section('content')


    <div class="white-box">
        <h3 class="box-title m-b-10">All Users</h3>
        <a href="/admin/users/create" class="box-title m-b-20 btn btn-success">
            <h4>Add New User</h4>
        </a>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>QR Code</th>
                    <th>Passport Number</th>
                    <th>Car Model</th>
                    <th>Vehicle Plate</th>
                    <th>Created</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['users'] as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->surname}}</td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->age}}</td>
                        <td>{{$value->identity_number}}</td>
                        <td>{{$value->passport_number}}</td>
                        <td>{{$value->car_model}}</td>
                        <td>{{$value->vehicle_plate}}</td>
                        <td>{{$value->created_at}}</td>

                        <td>
                            <a href="/admin/users/{{$value->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Edit this user"
                               class="btn btn-primary btn-circle tooltip-primary"> <i
                                    class="fas fa-pencil-alt"></i> </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
