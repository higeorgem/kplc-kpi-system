@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header h4 bg-dark text-uppercase">
      <div id="title">{{$structure->name}} {{$structure_type}} KPI<small>s</small></div>
        <a href="{{url()->previous()}}" class="float-right m-1 btn-xs btn-info">
            <i class="fas  nav-icon"></i> Back
        </a>
        @can('kpi-create')
        <a href="{{route('kpi.create')}}" class="float-right btn btn-xs btn-success">
            <i class="fas fa-plus nav-icon"></i> Create KPI
        </a>
        @endcan
    </div>
    <div class="table-responsive card-body">
        <table id="kpiTable" class="table table-sm table-striped  table-bordered table-hover">
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
                @forelse ($structures as $key => $kpi)
                <tr id="{{$kpi->code}}" class="record">
                    <td> {{$kpi->code}}</td>
                    @php
                    $kp = new App\KPI;
                    @endphp
                    <td> {{$kp->kpiPerspective($kpi->perspective)->perspective}}</td>
                    <td id="kpi"> {{$kpi->kpi}}</td>
                    <td> {{$kpi->kpi_type}}</td>
                    <td>
                        @if ($kpi->kpi_type == 'Tasked')
                        <a href="{{URL::signedRoute('kpiTasks',[$kpi->id])}}"
                            class="btn btn-xs btn-outline-primary float-left m-1">
                            <i class="badge badge-info">{{--$kpi->tasks->count()--}}</i> Tasks
                        </a>
                        @endif
                        {{-- @can('kpi-edit') --}}
                        <a href="{{URL::signedRoute('kpi.edit',[$kpi->id])}}"
                            class="btn btn-xs btn-outline-warning float-left mr-1">
                            {{-- <i class="fa fa-edit"></i> --}}
                            Edit
                        </a>
                        {{-- @endcan --}}
                        {{-- @can('kpi-delete') --}}
                        <form action="{{route('kpi.destroy',[$kpi->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are You Sure ?')"
                                class="btn btn-xs btn-outline-danger float-left mr-1">Trash</button>
                        </form>
                        {{-- @endcan --}}
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
    // $("#kpiTable").DataTable({
    // "responsive": true, "lengthChange": true, "autoWidth": false,'ordering': true,
    // "buttons": ["copy", "csv", "excel", "pdf", "print"]
    // }).buttons().container().appendTo('#kpiTable_wrapper .col-md-6:eq(0)');
    // console.log($('.main-footer strong').text())
        // console.log($('#title').text())
    var title = $('#title').text();
    // Append a caption to the table before the DataTables initialisation
    $('#kpiTable').append('<caption style="caption-side: bottom">'+$('.main-footer strong').text()+' All rights reserved.</caption>');

    $("#kpiTable").DataTable({
    "responsive": true, "lengthChange": true, "autoWidth": false,'ordering': true,
    "buttons": [
            {
                extend: 'copyHtml5',
                messageTop: title,
                messageBottom: 'The information in this table is copyright to Sirius Cybernetics Corp.',
                exportOptions: {
                columns: [ 0, 1, 2, 3]
            }
        },
            {
                extend: 'excelHtml5',
                messageTop: title,
                messageBottom: 'The information in this table is copyright to Sirius Cybernetics Corp.',
                exportOptions: {
                columns: [ 0, 1, 2, 3]
            }
        },
            {
                extend: 'pdfHtml5',
                messageTop: title,
                messageBottom: 'The information in this table is copyright to Sirius Cybernetics Corp.',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
        },
            {
                extend: 'print',
                messageTop: title,
                messageBottom: 'The information in this table is copyright to Sirius Cybernetics Corp.',
                exportOptions: {
                    columns: ':visible'
                },
                // customize: function ( win ) {
                //     $(win.document.body)
                //         .css( 'font-size', '10pt' )
                //         .prepend(
                //         '<img src="http://127.0.0.1:8000/css/dist/img/logo_2.jpeg" style="position:absolute; top:0; left:0;" />'
                //     );
                //     $(win.document.body).find( 'table' )
                //     .addClass( 'compact' )
                //     .css( 'font-size', 'inherit' );
                // }
            },
            "colvis"
    ]
    }).buttons().container().appendTo('#kpiTable_wrapper .col-md-6:eq(0)');
//  is a button
    })
</script>
@endsection
