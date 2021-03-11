@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class=" justify-content-center">
        <div class="">
            <div class="card" id="tasksCard">
                <div class="card-header bg-dark">
                    <div class="kpiTableTitle float-left h3">
                        ALL MY TASKS
                    </div>
                    <span class="float-right">
                        <a href="{{route('tasks.create')}}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Task
                        </a>
                        <a href="{{route('tasks.upload')}}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-upload"></i> Upload Task
                        </a>
                    </span>

                </div>

                <div class="card-body">
                    {{-- <div id="scroll_to"></div> --}}
                    {{-- <div id="taskAlert" class="alert"></div> --}}
                    <table id="tasksTable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#SN</th>
                                <th>Task</th>
                                <th>Created</th>
                                <th>Resolved</th>
                                <th>Status</th>
                                <th>Function</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\Illuminate\Support\Facades\DB::table('tasks')
                            ->where('responsible', Auth::user()->staff_no)
                            ->whereNull('deleted_at')
                            ->get() as $task)
                            <tr>
                                <td>{{$task->key}}</td>
                                <td>{{$task->task}}</td>
                                <td>{{$task->created_date}}</td>
                                <td>{{$task->resolution_date}}</td>
                                <td>{{$task->status}} @if($task->status == 'open')<a href="#"
                                        class="btn btn-xs btn-rounded btn-success close_task"
                                        id="{{$task->id}}">close</a> @endif</td>
                                <td>
                                    {{-- <a href="{{URL::signedRoute('tasks.show', [$task->id])}}"
                                    class="btn btn-xs btn-outline-info">Show</a> --}}
                                    @if($task->status == 'open') <a href="#" class="btn btn-xs btn-outline-warning edit"
                                        id="{{$task->id}}">Edit</a> @endif
                                    <button type="submit" id="{{$task->id}}"
                                        class="btn btn-xs btn-outline-danger delete">Trash</button>
                                    {{-- <form action="{{route('tasks.destroy', [$task->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are You Sure ?')"
                                        class="btn btn-xs btn-outline-danger">Trash</button>
                                    </form> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#SN</th>
                                <th>Task</th>
                                <th>Created</th>
                                <th>Resolved</th>
                                <th>Status</th>
                                <th>Function</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog"
                    aria-labelledby="editTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTaskModalLabel">EDIT KPI</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" id="task_form">
                                <div class="modal-body">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="task_key" id="task_key" value="">
                                    <div class="form-group">
                                        <label for="key">Select key:</label>
                                        <select name="key" id="key" class="form-control" required>
                                            <option value="" selected disabled>Select key</option>
                                            @foreach (\Illuminate\Support\Facades\DB::table('k_p_i_s')->get() as $kpi)
                                            <option value="{{$kpi->code}}">{{$kpi->kpi}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="task">Task: </label>
                                        <textarea name="task" id="task" class="form-control" required></textarea>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="status">Task Status: </label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="open" >Open</option>
                                            <option value="closed" >Closed</option>
                                        </select>
                                    </div> --}}
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="created_date">Created Date</label>
                                            <input type="datetime-local" name="created_date" id="created_date"
                                                class="form-control" required>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <label for="resolution_date">Resolution Date</label>
                                            <input type="datetime-local" name="resolution_date" id="resolution_date"
                                                class="form-control" required>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="card-footer text-center">
                                                    <button type="submit" id="form_submit" class="btn btn-outline-success">Create
                                                        Task</button>
                                                </div> --}}

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
        $(function () {
            $("#tasksTable").DataTable({
            "responsive": false, "lengthChange": true, "autoWidth": false,'ordering': true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#kpiTable_wrapper .col-md-6:eq(0)');
        })
    </script>
    <script>
        $(function () {
            // close task
            $('.close_task').on('click', function () {
            // confirm choice
            // var choice = confirm('Close Task ??');
            // console.log(choice);
                Swal.fire({
                    title: 'Close Task ?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, close it !'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')
                            }
                            })
                            $.ajax({
                            url: '/tasks/close/'+$(this).attr('id'),
                            type: 'get',
                            dataType: 'json',
                            cache: false,
                            data: {
                            id: $(this).attr('id')
                            },
                            success: function(respon){
                            // console.log(respon);
                            // display close success message
                            Swal.fire('Task Closed !!','','success')
                            setTimeout(function() {
                                location.reload();
                            }, 2500);

                            },
                            error: function(err){
                            // console.log(err)
                            }
                            })
                        }
                });
            });
            // tr click event on the kpi table get the kpi id use to search tasks
            $('.edit').on('click', function () {
            // fetch tasks
            fetchTask($(this).attr('id'));
            });

            $('#task_form').submit(function(e){
                e.preventDefault();
                var key = $('#task_key').val();
                $.ajax({
                    url: "tasks/"+key,
                    // url: 'tasks',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response){
                        $('#editTaskModal').modal('hide');
                        Swal.fire('UPDATED!','Your Task has been Updated.','success')
                    },
                    error: function(error){
                        console.log(error)
                    }
                })
            });

            function fetchTask(param) {
                $.ajax({
                url:'tasks/'+param,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(response){
                // console.log(response)
                // console.log(response)
                    // show the edit modal
                    $('#editTaskModal').modal('show');
                    // append kpi
                    $('#key option[value='+response.description+']').attr('selected','selected');
                    // append task_key to input
                    $('#task_key').val(response.id);
                    // append task to input
                    $('#task').val(response.task);
                    // append status
                    $('#status').val(response.status).change();
                    // append created date
                    $('#created_date').val(response.created_date).change();
                    // append resolution date
                    // $('#resolution_date').val(response.resolution_date).change();

                },
                error: function(err){
                    console.log(err)
                }
                })
            }

            // trash kpi
            $('.delete').on('click', function(){
                console.log($(this).attr('id'))
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                    // delete the task
                    $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')
                    }
                    })
                    $.ajax({
                        url: '/tasks/'+$(this).attr('id'),
                        type: 'DELETE',
                        dataType: 'json',
                        cache: false,
                        data: {
                        id: $(this).attr('id')
                    },
                    success: function(respon){
                        // console.log(respon);
                        // display delete success message
                        Swal.fire('Deleted!','Your file has been deleted.','success')
                        },
                        error: function(err){
                        // console.log(err)
                        }
                    })

                    }
                })
            });
        })
    </script>
    @endsection
