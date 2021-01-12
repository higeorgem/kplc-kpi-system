@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header h4 bg-info">
        MY KPIS
    </div>
    <div class="table-responsive-sm card-body">

        <table id="kpiTable" class="table table-striped table-sm table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#CODE</th>
                    <th>Perspective</th>
                    <th title="Key Performance Indicator">KPI</th>
                    <th>Function</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($my_kpis as $key => $kpi)
                <tr id="{{$kpi->code}}" class="record">
                    <td> {{$kpi->code}}</td>
                    <td> {{$kpi->perspective}}</td>
                    <td id="kpi"> {{$kpi->kpi}}</td>
                    <td><a href="kpi/tasks/{{$kpi->id}}" class="btn btn-xs btn-outline-primary"><i class="fas fa-tasks"></i> Tasks</a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#CODE</th>
                    <th>Perspective</th>
                    <th title="Key Performance Indicator">KPI</th>
                    <th>Function</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


@endsection
@section('scripts')
<script>

</script>
@endsection
