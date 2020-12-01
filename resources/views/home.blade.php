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
                                <th title="Previous Target">PT</th>
                                <th>Target</th>
                                <th>Achievement</th>
                                <th>Vailidated Achievement</th>
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
                                <td>{{$kpi->previous_target}}</td>
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
                                <th title="Previous Target">PT</th>
                                <th>Target</th>
                                <th>Achievement</th>
                                <th>Vailidated Achievement</th>
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
                        <a href="{{route('targets.create')}}" class="btn btn-success btn-sm">
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
                    <div id="taskAlert" class="alert"></div>
                    <div class="tasksTable">
                        <table id="tasksTable" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#SN</th>
                                    <th>Task</th>
                                    <th>Created</th>
                                    <th>Resolved</th>
                                    <th>Description</th>
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
                                    <th>Description</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
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
            // hide the task alert div
            $("#taskAlert").hide()
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
        })
        // hide tasks card
        $('#tasksCard').hide();
        // set the tasks card title on clicking the kpi table row
        $('#kpiTable tr.record td#kpi').on('click', function () {
            // console.log($(this).html())
            $('#tasksCard .kpiTableTitle').html($(this).html()).addClass("h4 text-uppercase")
        })
        // tr click event on the kpi table get the kpi id use to search tasks
        $('#kpiTable tr.record').on('click', function () {
            console.log($(this).attr('id')3)
            // fetch tasks
            $.ajax({
                url:'/target/'+$(this).attr('id'),
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(response){
                    console.log(response)
                    if (response == '') {
                        // alert absence of task
                        Swal.fire({
                            icon: 'info',
                            title: 'No tasks for this KPI.',
                            showConfirmButton: false,
                            timer: 2000
                         })
                        // hide task card
                        $('#tasksCard').hide(750).show(1000);
                        //  show task card
                        // $('#tasksCard').show(1000);
                        // hide the taks table
                        $("#tasksTable").html('')
                        // append no tasks message
                         $("#taskAlert").show().addClass("alert-info").text("No tasks for this KPI")
                        // navigate to the table section
                        $('html, body').animate({
                            scrollTop: $(".tasksTable").offset().top
                        }, 2000);
                    } else {
                        // remove the initial tasks
                        $('#tasksTable tbody').html('');
                        // hide task alert div
                        $("#taskAlert").hide()
                        // hide task card
                        $('#tasksCard').hide(2000);
                        // show tasks card
                        $('#tasksCard').show(2000);
                        // show the tasks table
                        $("#tasksTable").show()
                        //  populate tasks table body
                        $.each(response, function(key,val) {
                            $('#tasksTable tbody').append('<tr><td>'+response[key].key+'</td><td>'+response[key].task+'</td><td>'+response[key].created_date+'</td><td>'+response[key].resolution_date+'</td><td>'+response[key].description+'</td><td><a href="#" class="btn btn-outline-info">Edit</a> | <a href="#" class="btn btn-outline-danger">Trash</a></td></tr>');
                        });
                        // navigate to the table section
                         $('html, body').animate({
                            scrollTop: $(".tasksTable").offset().top
                        }, 2000);
                    }
                },
                error: function(err){
                    console.log(err)
                }
            })
        })
    })
    </script>
    @endsection
