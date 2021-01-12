@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm- card card-body">
                {{-- personal detail table --}}
                <table class="table table-bordered table-sm w-50 m-auto">
                    <thead>
                        <th class="text-uppercase text-center" colspan="2">Appendix 1: Targets Matrix</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>NAME:</th>
                            <td>{{ Auth::user()->fullName() }}</td>
                        </tr>
                        <tr>
                            <th>STAFF NO:</th>
                            <td>{{Auth::user()->staff_no}}</td>
                        </tr>
                        <tr>
                            <th>JOB TITLE:</th>
                            <td>{{Auth::user()->title}}</td>
                        </tr>
                        <tr>
                            <th>DIVISION:</th>
                            <td>{{Auth::user()->getDivision(Auth::user()->division_id)->name}}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-upper text-center">For the period </td>
                        </tr>
                    </tfoot>
                </table>
                {{-- performance table --}}
                <table class="table table-striped table-sm table-responsive m-1">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Performance Indicators</th>
                        <th>Unit of Measure</th>
                        <th>Weights</th>
                        <th>Actual</th>
                        <th>Target</th>
                        <th>Achievement</th>
                        <th>Validated Achievement</th>
                        <th>Raw Score</th>
                        <th>Weighted Score</th>
                    </thead>
                    <tbody>
                        @forelse (\Illuminate\Support\Facades\DB::table('k_p_i_s')->get() as $key => $kpi)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$kpi->kpi}}</td>
                                <td>{{$kpi->unit_of_measure}}</td>
                                <td>{{$kpi->weight}}</td>
                                <td>{{$kpi->previous_target}}</td>
                                <td>{{$kpi->target}}</td>
                                <td>{{$kpi->achievement}}</td>
                                <td>{{$kpi->validated_achievement}}</td>
                                @php
                                    $report = new App\KPI;
                                @endphp
                                <td>{{$report->rawScore($kpi->target,$kpi->validated_achievement)}}</td>
                                <td>{{$report->weightedScore($kpi->target,$kpi->validated_achievement, $kpi->weight)}}</td>

                            </tr>
                        @empty
                            <tr>
                                <td class="alert alert-info" colspan="10">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- performance grade value table --}}
                <table class="table  table-bordered table-sm w-50 m-auto">
                    <tr>
                        <td class="border-left-0"></td>
                        <th colspan="2">Grade Value Range</th>
                    </tr>
                   <tr>
                       <th>Performance Grade</th>
                       <th>Upper</th>
                       <th>Lower</th>
                   </tr>
                   <tbody>
                       <tr>
                           <th>Excellent</th>
                           <td>From 1.0</td>
                           <td>To 2.4</td>
                       </tr>
                       <tr>
                           <th>Very Good</th>
                           <td>Over 2.4</td>
                           <td>To 3.0</td>
                       </tr>
                       <tr>
                           <th>Good</th>
                           <td>Over 3.0</td>
                           <td>To 3.6</td>
                       </tr>
                       <tr>
                           <th>Fair</th>
                           <td>Over 3.6</td>
                           <td>To 4.0</td>
                       </tr>
                       <tr>
                           <th>Poor</th>
                           <td>Over 4.0</td>
                           <td>To 5.0</td>
                       </tr>
                   </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
</script>
@endsection
