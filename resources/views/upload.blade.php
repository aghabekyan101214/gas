@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"> Static Data </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="/admin/upload-file" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-2">Upload file</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="file_up">
                                        @error('file_up')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success">Upload</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
