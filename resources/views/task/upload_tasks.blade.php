@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">CREATE TASK</div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Upload Task sheet <br><span
                                class="text-danger font-weight-bold h3">*</span>Accepted files CSV </div>
                        <div class="card-body">
                            <form method='post' action="{{route('tasks.storeUpload')}}" enctype='multipart/form-data' >
                                 {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="task_file">Upload Task File: </label>
                                    <input type="file" name="task_file" id="task_fie" class="form-control @error('task_file') is-invalid @enderror">
                                    @error('task_file')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group text-center">
                                    <button type='submit' name='submit' class="btn btn-sm btn-outline-success ">
                                       <i class="fa fa-upload"></i> Upload
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function () {
        $(':file').on('change', function(){


        })

    })
</script>
@endsection
