@extends('layouts.app')

@section('content')

    <div class="white-box">
        <h3 class="box-title m-b-10">All Clients</h3>
        <a href="/admin/clients/create" class="box-title m-b-20 btn btn-success">Add New Client</a>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surame</th>
                    <th>Birthday</th>
                    <th>Passport</th>
                    <th>Car</th>
                    <th>License Plate</th>
                    <th>RFID</th>
                    @if(Auth::user()->role == 1)
                        <th>Bonus</th>
                    @endif
                    <th>Created</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['clients'] as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->surname }}</td>
                        <td>{{ date("Y/M/d", $value->birthday) }}</td>
                        <td>{{ $value->passport }}</td>
                        <td>{{ $value->car }}</td>
                        <td>{{ $value->license_plate }}</td>
                        <td>{{ $value->qr }}</td>
                        @if(Auth::user()->role == 1)
                            <td>{{ $value->bonus }}</td>
                        @endif
                        <td>{{ $value->created_at }}</td>
                        <td>
                            <a href="/admin/clients/{{$value->id}}/edit" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-circle tooltip-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form style="display: inline-block" onsubmit="if(confirm('Dou You Really Want To Delete This Client?') == false ) return false;" action="/admin/clients/{{$value->id}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger btn-circle tooltip-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
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

