@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class=" justify-content-center">
        <div class="">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="">
                        <table id="example1" class="table table-bordered table-hover table-sm table-responsive">
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
                                @foreach (\Illuminate\Support\Facades\DB::table('targets')->where('responsible',
                                Auth::user()->staff_no)->get() as $key => $target)
                                <tr>
                                    <td> {{$target->key}}</td>
                                    <td> {{$target->task}}</td>
                                    <td> {{$target->creation_date}}</td>
                                    <td> {{$target->resolution_date}}</td>
                                    <td> {{$target->description}}</td>
                                </tr>
                                @endforeach


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
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
        $(function () {
            $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": true,'ordering': true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        })
    </script>
    @endsection
