@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"> Static Data </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="/admin/static-data" method="post" class="form-horizontal form-bordered">
                            @csrf
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-2">Bonus Percent</label>
                                    <div class="col-md-9">
                                        <input type="number" step="any" placeholder="Bonus Percent" @if(isset($data->bonus)) value="{{ $data->bonus }}" @endif required class="form-control" name="bonus">
                                        @error('bonus')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Filling Max Quantity</label>
                                    <div class="col-md-9">
                                        <input type="number" placeholder="Filling Max Quantity" @if(isset($data->filling_max_quantity)) value="{{ $data->filling_max_quantity }}" @endif required class="form-control" name="filling_max_quantity">
                                        @error('filling_max_quantity')
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
