@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"> Edit Admin</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="/admin/users/{{ $data['result']->id }}" method="post" class="form-horizontal form-bordered">
                            @method("PUT")
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" value="{{ $data['result']->name }}" required class="form-control" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Surname</label>
                                    <div class="col-md-9">
                                        <input type="text" value="{{ $data['result']->surname }}" placeholder="Surname" required class="form-control" name="surname">
                                        @error('surname')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" placeholder="Email" value="{{ $data['result']->email }}" required class="form-control" name="email">
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Select Gas Station</label>
                                    <div class="col-md-9">
                                        <select name="station_id[]" class="form-control select2" required multiple="multiple" id="">
                                            <option value="">Select Station</option>
                                            @foreach($data['stations'] as $station)
                                                <option @if(null != $data['chosen'] && in_array($station->id, $data['chosen'])) {{ 'selected' }} @endif value="{{ $station->id }}">{{ $station->name }}</option>
                                            @endForeach
                                        </select>
                                        @error('station_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Select The Pages, Which New Admin Will Have Access.</label>
                                    <div class="col-md-9">
                                        <select name="pages[]" class="form-control select2" multiple="multiple" required id="">
                                            <option value="">Select Pages</option>
                                            @foreach($data['pages'] as $bin => $pages)
                                                <option @if(null != $data['chosenPages'] && in_array($pages->id, $data['chosenPages'])) {{ 'selected' }} @endif value="{{ $pages->id }}">{{ $pages->name }}</option>
                                            @endForeach
                                        </select>
                                        @error('station_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Password</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Password" value="{{ $data['result']->password_show }}" required class="form-control" name="password">
                                        @error('password')
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
