@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"> Add New User</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="/admin/users" method="post" class="form-horizontal form-bordered">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" class="form-control" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Surname</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Surname" class="form-control" name="surname">
                                        @error('surname')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" placeholder="Email" class="form-control" name="email">
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Age</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Age" class="form-control" name="age">
                                        @error('age')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">QR Code</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="QR Code" class="form-control"
                                               name="identity_number">
                                        @error('identity_number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Passport Number</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Passport Number" class="form-control"
                                               name="passport_number">
                                        @error('passport_number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Car Model</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Car Model" class="form-control"
                                               name="car_model">
                                        @error('car_model')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Vehicle Plate</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Vehicle Plate" class="form-control"
                                               name="vehicle_plate">
                                        @error('vehicle_plate')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-offset-11 col-md-9">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fa fa-check"></i>
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
