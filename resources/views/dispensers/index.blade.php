@extends('layouts.app')

@section('content')

    <div class="white-box">
        <h3 class="box-title m-b-10">All Dispensers</h3>
        <a href="/admin/dispensers/create" class="box-title m-b-20 btn btn-success">Add New Dispenser</a>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Gas Station</th>
                    <th>Created</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['dispensers'] as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->stations->name }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>
                            <a href="/admin/dispensers/{{$value->id}}/edit" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-circle tooltip-primary">
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

