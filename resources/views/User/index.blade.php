@extends('layouts.app')

@section('content')


    <div class="white-box">
        <h3 class="box-title m-b-10">All Admins</h3>
        <a href="/admin/users/create" class="box-title m-b-20 btn btn-success">Add New Admin</a>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Gas Stations</th>
                    <th>Password</th>
                    <th>Created</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['users'] as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->surname }}</td>
                        <td>{{ $value->email }}</td>
                        <td>
                            @foreach($value->stations as $station)
                                <p>{{ $station->name }}</p>
                            @endforeach
                        </td>
                        <td> <input type="password" style="text-align: center; background: transparent; border: none" disabled value="{{ $value->password_show }}"> <a class="eye" href="javascript:void(0)" style="float: right;"><i class="fas fa-eye"></i></a></td>
                        <td>{{$value->created_at}}</td>

                        <td>
                            <a href="/admin/users/{{$value->id}}/edit" data-toggle="tooltip" data-placement="top" title="Edit this user" class="btn btn-primary btn-circle tooltip-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).on("click", ".eye", function(){
            let type = $(this).parentsUntil("tr").find("input").attr("type");
            if(type == 'password') {
                $(this).parentsUntil("tr").find("input").attr("type", "text");
            } else {
                $(this).parentsUntil("tr").find("input").attr("type", "password");
            }
        });
    </script>
@endsection

