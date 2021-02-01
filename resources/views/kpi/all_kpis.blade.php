@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header h4 bg-info">
        ALL KPIS
    </div>
    <div class="table-responsive card-body">
        <table id="kpiTable" class="table table-striped table-sm table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#CODE</th>
                    <th>Perspective</th>
                    <th title="Key Performance Indicator">KPI</th>
                    <th title="KPI Type">Type</th>
                    <th>Function</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kpis as $key => $kpi)
                <tr id="{{$kpi->code}}" class="record">
                    <td> {{$kpi->code}}</td>
                    <td> {{$kpi->perspective}}</td>
                    <td id="kpi"> {{$kpi->kpi}}</td>
                    <td> {{$kpi->kpi_type}}</td>
                    <td>
                        @if ($kpi->kpi_type == 'Tasked')
                        <a href="{{URL::signedRoute('kpiTasks',[$kpi->id])}}"
                            class="btn btn-xs btn-outline-primary float-left mr-1">
                            <i class="badge badge-info">{{$kpi->tasks->count()}}</i> Tasks
                        </a>
                        @endif
                        @can('kpi-edit')
                        <a href="{{URL::signedRoute('kpi.edit',[$kpi->id])}}"
                            class="btn btn-xs btn-outline-warning float-left mr-1">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @endcan
                        @can('kpi-delete')
                        <form action="{{route('kpi.destroy',[$kpi->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are You Sure ?')"
                                class="btn btn-xs btn-outline-danger float-left mr-1">Trash</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="4">No Data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-light">
                <tr>
                    <th>#CODE</th>
                    <th>Perspective</th>
                    <th title="Key Performance Indicator">KPI</th>
                    <th title="KPI Type">Type</th>
                    <th>Function</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
    //
$(function () {
    $("#kpiTable").DataTable({
    "responsive": true, "lengthChange": true, "autoWidth": false,'ordering': true,
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#kpiTable_wrapper .col-md-6:eq(0)');

    })
</script>
@endsection