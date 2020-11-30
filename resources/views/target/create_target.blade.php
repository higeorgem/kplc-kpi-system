@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">CREATE TASK</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card container">
                        <div class="card-header">Create Task Form <br><span class="text-danger font-weight-bold h3">*</span>Tasks created by this form will be assigned to you.</div>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="kpi">Select KPI:</label>
                                <select name="kpi" id="kpi" class="form-control">
                                    @foreach (\Illuminate\Support\Facades\DB::table('k_p_i_s')->get() as $kpi)
                                        <option value="{{$kpi->id}}">{{$kpi->kpi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="task">Task: </label>
                                <textarea name="task" id="task" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="task_status">Task Status: </label>
                                <select name="task_status" id="task_status" class="form-control">
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
                                <button type="submit" class="btn btn-outline-success">Create Task</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Upload Task sheet <br><span class="text-danger font-weight-bold h3">*</span>Accepted files CSV </div>
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

    })
</script>
@endsection
