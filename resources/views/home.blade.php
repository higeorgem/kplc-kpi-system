@extends('layouts.app')

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
                        {{\Illuminate\Support\Facades\DB::table('k_p_i_s')
                        ->where('group_id', Auth::user()->group_id)
                        ->whereNull('deleted_at')
                        ->where('division_id', Auth::user()->division_id)->count()}}
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
</section>
@endsection
@section('scripts')

@endsection
