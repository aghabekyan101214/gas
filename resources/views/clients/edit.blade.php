@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"> Edit The Client</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="/admin/clients/{{ $client->id }}" method="post" class="form-horizontal form-bordered">
                            @method("PUT")
                            @csrf
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" value="{{ $client->name }}" required class="form-control" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Surname</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Surname" value="{{ $client->surname }}" required class="form-control" name="surname">
                                        @error('surname')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Birthday</label>
                                    <div class="col-md-9">
                                        <input type="date" placeholder="Birthday" value="{{ date("Y-m-d", $client->birthday) }}" class="form-control" name="birthday">
                                        @error('birthday')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Passport</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Passport" value="{{ $client->passport }}" class="form-control" name="passport">
                                        @error('passport')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Car</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Car" value="{{ $client->car }}" class="form-control" name="car">
                                        @error('car')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">License Plate</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="License Plate" value="{{ $client->license_plate }}" class="form-control" name="license_plate">
                                        @error('license_plate')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">RFID</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="RFID" value="{{ $client->qr }}" required class="form-control" name="qr">
                                        @error('qr')
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
