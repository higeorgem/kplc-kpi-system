@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class=" justify-content-center">
        <div class="">
            <div class="card" id="tasksCard">
                <div class="card-header">
                    <div class="kpiTableTitle float-left h3">
                       <strong >{{ucwords($kpi->kpi)}}</strong> <span class="font-weight-light">Tasks</span>
                    </div>
                    <span class="float-right">
                        <a href="{{route('tasks.create')}}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Task
                        </a>
                        <a href="{{route('tasks.upload')}}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-upload"></i> Upload Task
                        </a>
                    </span>


                </div>

                <div class="card-body table-responsive-sm">
                    <table id="tasksTable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#SN</th>
                                <th>Task</th>
                                <th>Created</th>
                                <th>Resolved</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kpi_tasks as $kpi)
                            <tr>
                                <td>{{$kpi->key}}</td>
                                <td>{{$kpi->task}}</td>
                                <td>{{$kpi->created_date}}</td>
                                <td>{{$kpi->resolution_date}}</td>
                                <td>{{$kpi->status}}</td>
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
                            </tr>
                        </tfoot>
                    </table>
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
    @endsection
