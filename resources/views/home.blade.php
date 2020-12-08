@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class=" justify-content-center">
        <div class="card">
            <div class="card-header h3 text-center text-uppercase">{{ __('Key Performance Indicators') }}</div>
            <div class="card-body">
                <div class="">
                    <table id="kpiTable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#CODE</th>
                                <th>Perspective</th>
                                <th title="Key Performance Indicator">KPI</th>
                                <th title="Unit Of Measure">UOM</th>
                                <th>Weight</th>
                                <th title="Previous Target">Previous Targets</th>
                                <th>Current Target</th>
                                <th>Achievement</th>
                                <th>Vailidated Achievement</th>
                                <th>Raw Score</th>
                                <th>Weighted Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\Illuminate\Support\Facades\DB::table('k_p_i_s')->get() as $key => $kpi)
                            <tr id="{{$kpi->code}}" class="record">
                                <td> {{$kpi->code}}</td>
                                <td> {{$kpi->perspective}}</td>
                                <td id="kpi"> {{$kpi->kpi}}</td>
                                <td> {{$kpi->unit_of_measure}}</td>
                                <td> {{$kpi->weight}}</td>
                                <td>{{$kpi->target}}</td>
                                <td>{{$kpi->achievement}}</td>
                                <td>{{$kpi->validated_achievement}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#CODE</th>
                                <th>Perspective</th>
                                <th title="Key Performance Indicator">KPI</th>
                                <th title="Unit Of Measure">UOM</th>
                                <th>Weight</th>
                                <th title="Previous Target">Previous Targets</th>
                                <th>Current Target</th>
                                <th>Achievement</th>
                                <th>Vailidated Achievement</th>
                                <th>Raw Score</th>
                                <th>Weighted Score</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="">
            <div class="card" id="tasksCard">
                <div class="card-header">
                    <div class="kpiTableTitle"></div>
                    <!-- Button trigger modal -->
                    <span class="">
                        <a href="{{route('tasks.create')}}" class="btn btn-success btn-sm">
                            Add Task
                        </a>
                        {{-- <a type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                            Add Task
                        </a> --}}
                        {{-- <a type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                            Add Tasks
                        </a>
                        <a type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#exampleModal">
                            Analyze
                        </a> --}}
                    </span>


                </div>
                <div class="card-body">
                    <div id="scroll_to"></div>
                    <div id="taskAlert" class="alert"></div>
                    <div class="tasksTable">
                        <table id="tasksTable" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#SN</th>
                                    <th>Task</th>
                                    <th>Created</th>
                                    <th>Resolved</th>
                                    <!-- <th>Description</th> -->
                                    <th>Status</th>
                                    <th>Functions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#SN</th>
                                    <th>Task</th>
                                    <th>Created</th>
                                    <th>Resolved</th>
                                    <!-- <th>Description</th> -->
                                    <th>Status</th>
                                    <th>Functions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
                aria-hidden="true">
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
                                <div class="form-group">
                                    <label for="status">Task Status: </label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="open">Open</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="created_date">Created Date</label>
                                        <input type="datetime-local" name="created_date" id="created_date"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="resolution_date">Resolution Date</label>
                                        <input type="datetime-local" name="resolution_date" id="resolution_date"
                                            class="form-control" required>
                                    </div>
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
    @endsection
    @section('scripts')
    <script>
        $(function () {
            // hide the task alert div
            $("#taskAlert").hide()
            $("#tasksTable").DataTable()
            $("#kpiTable").DataTable({
            "responsive": false, "lengthChange": true, "autoWidth": false,'ordering': true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#kpiTable_wrapper .col-md-6:eq(0)');
         // tr mouseover event for kpi table
        $('#kpiTable tr.record').hover(function () {
                $(this).css("background","grey");
            },
            function () {
                $(this).css("background","");
        });
        // hide tasks card
        $('#tasksCard').hide();
        // set the tasks card title on clicking the kpi table row
        $('#kpiTable tr.record td#kpi').on('click', function () {
            // console.log($(this).html())
            $('#tasksCard .kpiTableTitle').html($(this).html()).addClass("h4 text-uppercase")
        });
        // tr click event on the kpi table get the kpi id use to search tasks
        $('#kpiTable tr.record').on('click', function () {
            // console.log($(this).attr('id'))
            // fetch tasks
           fetchTasks($(this).attr('id'));
        });
        // save kpi changes
        $('#task_form').submit(function(e){
            e.preventDefault();
            Swal.fire({
                    title: 'Do you want to save the changes?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Save`,
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // save updates on the task
                        console.log($(this).serializeArray())
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN' : jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        $.ajax({
                            url: '/tasks/'+$('#task_key').val(),
                            type: 'PUT',
                            dataType: 'json',
                            cache: false,
                            data: $(this).serialize(),
                            success: function(reply){
                                // console.log(reply.kpi_key)
                                fetchTasks(reply.kpi_key);
                            },
                            error: function(err){
                                console.log(err)
                            }
                        })
                        // show saved success
                        Swal.fire('Changes Saved!', '', 'success')
                        // close the modal
                        $('#editTaskModal').modal('hide');
                        //
                        scrollToTask();
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                        scrollToTask();
                }
            });

        })

        function fetchTasks(param) {
            $.ajax({
            url:'/kpi/tasks/'+param,
            type: 'GET',
            dataType: 'json',
            cache:false,
            success: function(response){
            // console.log(response)
            if (response == '') {
            // alert absence of task
            Swal.fire({
            icon: 'info',
            title: 'No tasks for this KPI.',
            showConfirmButton: false,
            timer: 1000
            });
            // hide task card
            $('#tasksCard').hide(750).show(1000);
            // hide the taks table div
            $(".tasksTable").hide()
            // append no tasks message
            $("#taskAlert").show().addClass("alert-info").text("No tasks for this KPI")
            } else {
            // hide task alert div
            $("#taskAlert").hide()
            // show the taks table div
            $(".tasksTable").show()
            // remove the initial tasks
            $('#tasksTable tbody').html('');
            // hide then show task card
            $('#tasksCard').hide(1000).show(1000);
            // show the tasks table
            $("#tasksTable").show()
            // populate tasks table body
            $.each(response, function(key,val) {
                $('#tasksTable tbody').append('<tr><td>'+response[key].key+'</td><td>'+response[key].task+'</td><td>'+new Date(response[key].created_date.split('T')[0]).toDateString()+' '+response[key].created_date.split('T')[1]+'</td><td>'+new Date(response[key].resolution_date.split('T')[0]).toDateString()+' '+response[key].resolution_date.split('T')[1]+'</td><td>'+response[key].description+'</td><td>'+response[key].status+'</td><td><a href="#" id='+response[key].key+' class="btn btn-sm btn-outline-info editTask">Edit</a> | <a href="#" id='+response[key].key+' class="btn btn-sm btn-outline-danger del">Trash</a></td></tr>');
            });
            // edit modal
            $.each(response, function(key,val) {
                // edit prompt modal
                $('#'+response[key].key).on('click', function(){
                        // show the edit modal
                        $('#editTaskModal').modal('show');
                        // reset the form
                        $('#task_form')[0].reset();
                        // append kpi
                        $('#key option[value='+response[key].description+']').attr('selected','selected');
                        // append task_key to input
                        $('#task_key').val(response[key].key);
                        // append task to input
                        $('#task').val(response[key].task);
                        // append status
                        $('#status').val(response[key].status).change();
                        // append created date
                        $('#created_date').val(response[key].created_date).change();
                        // append resolution date
                        $('#resolution_date').val(response[key].resolution_date).change();
                    })
                })
            }
            // trash modal prompt
            $.each(response, function(key,val) {
                // trash kpi
                $('.del#'+response[key].key).on('click', function(){
                 console.log($(this).attr('id'))
                console.log(response[key].description)
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
                                    console.log(respon);
                                     // display delete success message
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    setTimeout(function() {
                                        fetchTasks(response[key].description)
                                    }, 1000);
                                },
                                error: function(err){
                                    // console.log(err)
                                }
                            })

                        }
                    })
                });
            })
            // navigate to the task table section
            scrollToTask();
            },
            error: function(err){
                console.log(err)
            }
            })
        }
        function scrollToTask(){
            // navigate to the task table section
            $('html, body').animate({
            scrollTop: $("#scroll_to").offset().top
            }, 1000);
        }


    })
    </script>
    @endsection
