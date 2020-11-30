@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">CREATE TASK</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card container">
                        <div class="card-header">Create Task Form <br><span
                                class="text-danger font-weight-bold h3">*</span>Tasks created by this form will be
                            assigned to you.</div>
                        <div id="validation-errors"></div>
                        <form action="" method="post" id="task_form">
                            @csrf
                            <div class="form-group">
                                <label for="key">Select key:</label>
                                <select name="key" id="key" class="form-control">
                                    <option value="" selected disabled>Select key</option>
                                    @foreach (\Illuminate\Support\Facades\DB::table('k_p_i_s')->get() as $kpi)
                                    <option value="{{$kpi->code}}">{{$kpi->kpi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="task">Task: </label>
                                <textarea name="task" id="task"
                                    class="form-control "></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Task Status: </label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="new">New</option>
                                    <option value="pending">Pending</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="created_date">Created Date</label>
                                    <input type="date" name="created_date" id="created_date" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label for="resolution_date">Resolution Date</label>
                                    <input type="date" name="resolution_date" id="resolution_date" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" id="form_submit" class="btn btn-outline-success">Create
                                    Task</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Upload Task sheet <br><span
                                class="text-danger font-weight-bold h3">*</span>Accepted files CSV </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="task_file">Upload Task File: </label>
                                <input type="file" name="task_file" id="task_fie" class="form-control">
                            </div>
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
        // hide validation errors div
        $('#validation-errors').hide();
        $('#validation-errors').html('');

        // on click submit
        $('form').submit(function(e){
            // e.preventDefault();
            submitTaskForm();
            return false;
        })

        function submitTaskForm() {
           console.log($('#task_form').serializeArray());
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
               url: '{{route("targets.store")}}',
               type: 'POST',
               dataType: 'json',
               cache: false,
               data: $('#task_form').serialize(),
               success: function(response){
                   console.log(response)

               },
               error: function (error) {
                   console.log(error)
                    $('.alert').hide()
                    $('.form-control').removeClass('is-invalid');
                    $('#validation-errors').show(600);
                if (error.statusText != 'OK') {
                    $('#validation-errors').append('<div class="alert alert-danger">'+error.responseJSON.message+'</div');
                    $.each(error.responseJSON.errors, function(key,value) {
                        $(document).find('[id='+key+']').addClass('is-invalid');
                        $(document).find('[id='+key+']').after('<span class="alert text-danger">'+value+'</span>')
                    });
                }

               }
           })
        }

    })
</script>
@endsection
