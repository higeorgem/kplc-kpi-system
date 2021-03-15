@extends('layouts.app')
@section('styles')

@endsection
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-primary">
                <span class="info-box-icon">
                    <i class="fas fa-user-tag"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text border-bottom border-warning">My KPIs</span>
                    <span class="info-box-number h5">
                            {{-- {{\Illuminate\Support\Facades\DB::table('k_p_i_s')
                            ->where('section_id', Auth::user()->section_id)
                            ->whereNull('deleted_at')
                            ->where('division_id', Auth::user()->division_id)->count()}} --}}
                    </span>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-tasks"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text border-bottom border-warining">My Tasks</span>
                    <span class="info-box-number h5">
                        {{\Illuminate\Support\Facades\DB::table('tasks')
                        ->where('responsible', Auth::user()->staff_no)
                        ->whereNull('deleted_at')
                        ->count()}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text border-bottom border-primary">Events</span>
                    <span class="info-box-number h5">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text border-bottom border-warning">Comments</span>
                    <span class="info-box-number h5">0</span>

                    {{-- <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        70% Increase in 30 Days
                    </span> --}}
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <!-- Chart's container -->
            {{-- <div id="chart" style="height: 300px;"></div> --}}
            <!-- Charting library -->
            <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
            <!-- Chartisan -->
            <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
            <!-- Your application script -->
            <script>
                const chart = new Chartisan({
                el: '#chart',
                url: "@chart('chart_route_name')",
                error: {
                    color: '#ff00ff',
                    size: [30, 30],
                    text: 'There was an error...',
                    textColor: '#ffff00',
                    type: 'general',
                    debug: true,
                },
                hooks: new ChartisanHooks()
                    // .colors(['#ECC94B', '#4299E1'])
                    // .responsive()
                    // .beginAtZero()
                    // .legend({ position: 'bottom' })
                    .title('User Registration')
                    .datasets([{ type: 'line', fill: true }, 'line'])
              });
            </script>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="taskchart" style="height: 300px;"></div>
            <script>
                const chart = new Chartisan({
                    el: '#taskchart',
                    url: "@chart('task_chart')",
                  });
            </script>
        </div>
    </div>

</section>
@endsection
@section('scripts')

@endsection
