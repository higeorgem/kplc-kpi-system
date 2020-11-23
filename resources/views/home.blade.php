@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class=" justify-content-center">
        <div class="card">
            <div class="card-header h3 text-center ">{{ __('Key Performance Indicators') }}</div>
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
                                <td> {{$kpi->kpi}}</td>
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
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="">
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
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
        $(function () {
        $("#kpiTable").DataTable({
            "responsive": false, "lengthChange": false, "autoWidth": false,'ordering': true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#kpiTable_wrapper .col-md-6:eq(0)');
            // $("#tasksTable").DataTable({
            //     "responsive": false, "lengthChange": false, "autoWidth": false,'ordering': false,
            //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            //     }).buttons().container().appendTo('#tasksTable_wrapper .col-md-6:eq(0)');
         // tr mouseover event
        $('#kpiTable tr.record').hover(function () {
                $(this).css("background","grey");
            },
            function () {
                $(this).css("background","");
        })
        // hide tasks table
        $('#tasksCard').hide();
        // tr click event
        $('#kpiTable tr.record').on('click', function () {
            console.log($(this).attr('id'))
            // fetch tasks
            $.ajax({
                url:'/target/'+$(this).attr('id'),
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(response){
                    console.log(response)

                    if (response == '') {
                        // hide task table
                        $('#tasksCard').hide(750);
                        // alert absence of task
                        // alert('No tasks for this KPI')
                        Swal.fire({
                            icon: 'info',
                            title: 'No tasks for this KPI.',
                            showConfirmButton: false,
                            timer: 2000
                         })
                        // Swal.fire('No tasks for this KPI.')
                    } else {
                        // show tasks table
                         $('#tasksCard').show(1000);
                        //  console.log(response[0].key)
                        //  poppulate the table
                        // $(response).each(function(){
                        //     $('#tasksTable tbody').append(
                        //         '<tr><td>'+response.key+'</td><td>'+response.task+'</td><td>'+response.creation_date+'</td><td>'+response.resolution_date+'</td><td>'+response.description+'</td></tr>');
                        // });
                        $.each(response, function(key,val) {
                            $('#tasksTable tbody').append('<tr><td>'+response[key].key+'</td><td>'+response[key].task+'</td><td>'+response[key].creation_date+'</td><td>'+response[key].resolution_date+'</td><td>'+response[key].description+'</td></tr>');
                        });

                        // navigate to the table section
                         $('html, body').animate({
                            scrollTop: $("#tasksTable").offset().top
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
