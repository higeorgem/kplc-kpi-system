@extends('layouts.app')

@section('styles')
{{-- datatables --}}
{{-- <link rel="stylesheet" href="{{asset('css/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('css/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> --}}
@endsection

@section('content')
<div class="container-fluid">
    <div class=" card card-body shadow">
        <form class="" id="query_form" action="{{route('create_pdf')}}">
            @csrf
            <div class="form-group row">
                <div class="col-md-3">
                        <label for="kpi_id" >Category</label>
                        <select name="kpi_id" id="kpi_id" class="form-control" required>
                            <option value="" selected disabled>Category</option>
                            <option value="all"> All My Tasks</option>
                            @forelse (\Illuminate\Support\Facades\DB::table('k_p_i_s')
                            ->whereNUll('deleted_at')
                            ->where('division_id', Auth::user()->division_id)->get() as $kpi)
                            <option value="{{$kpi->code}}" {{old('kpi_code') == $kpi->code ? 'selected' : ''}}> {{$kpi->kpi}}
                            </option>
                            @empty

                            @endforelse
                        </select>
                </div>
                <div class="col-md-3 ">
                        <label for="inputStartDate" >Start Date</label>
                        <input type="date" class="form-control" value="{{old('inputStartDate')}}" id="inputStartDate"
                            name="inputStartDate" placeholder="Start Date" required>
                </div>
                <div class="col-md-3 ">
                        <label for="inputEndDate" >End date</label>
                        <input type="date" class="form-control" value="{{old('inputEndDate')}}" id="inputEndDate"
                            name="inputEndDate" placeholder="End Date" required>
                </div>
                <div class="col-md-3">
                    <label for="operations">Execute</label> <br>
                    <button type="submit" id="submit_report" class="btn btn-outline-secondary btn-xs">
                         Search <i class="icofont-search-2"></i>
                    </button>
                    <button type="button" id="print_report" class="btn btn-xs btn-outline-primary"><i class="icofont-print"></i>
                        Print
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="table_card">
            <div class="card-header">
                <h4 id="title" class="text-center text-uppercase">Showing Filter Results </h4>
                <div id="helper_text" class="helper text-center"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Task</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Index</th>
                                <th>Task</th>
                                <th>Created Date</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{-- <table id="example1" class="display" width="100%"></table> --}}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
{{-- <script src="{{asset('css/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>p --}}
{{-- <script src="{{asset('css/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>p --}}
{{-- <script src="{{asset('css/plugins/pdfmake/pdfmake.min.js')}}"></script>p --}}
<script>
    // $(function () {
    //     var table = $('.data-table').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //           url: "{{ route('get_task_query') }}",
    //           type: "POST"
    //         }
    //         columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'name', name: 'name'},
    //         {data: 'email', name: 'email'},
    //         {data: 'action', name: 'action', orderable: false, searchable: false},
    //         ]
    //     });
    // });
    $(document).ready(function(){
        $('#table_card').hide();
        $('#print_report').hide();
    // data tables initialization
        // $('#example1').DataTable();
    // global variable declaration
    var kpi_id;
    var start_date;
    var end_date;

    // select kpi_id change
    $('#kpi_id').on('change', function(){
        // variable declaration
       kpi_id = $(this).val();
        // console.log(kpi_id)
        // if kpi_id is all
    });

    // select start date change
    $('#inputStartDate').on('change', function(){
        // variable declaration
       start_date = $(this).val();
        // console.log(start_date)
        // if kpi_id is all
    });
      // select end date change
    $('#inputEndDate').on('change', function(){
        // variable declaration
       end_date = $(this).val();
        // console.log(end_date)
        // if kpi_id is all
    });

    // submit query form
    $('#query_form').submit(function(e){
        e.preventDefault();
        // hide div
        $('#table_card').hide(500);
        // load gif
        // console.log('loading gif')

        // display query data
        var form_data = $(this).serializeArray();
        // console.log(form_data);
        getQuery(form_data);
    })
    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
        // print btn click function
        $('#print_report').click(function(){
            $.ajax({
                url: '{{route("create_pdf")}}',
                type: 'Post',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kpi_id" : $('#kpi_id').val(),
                    "inputStartDate" : $('#inputStartDate').val(),
                    "inputEndDate" : $('#inputEndDate').val(),
                },
                success: function(response){
console.log(response)
                },
                error: function(err){
console.log(err)
                }
            })
        })


    function getQuery(params) {
        $.ajax({
            url: '{{route("get_task_query")}}',
            type: 'POST',
            data: params,
            success: function(response){
                // console.log(response)
                // $('#example1 tbody').text('')
                $('#helper_text').text($('#kpi_id :selected').text()+' '+ start_date + ' To '+ end_date)
                // hide the print button
                $('#print_report').hide();
                if (response.length == 0) {
                    $(document).Toasts('create', {
                        title: 'Warning',
                        body: 'No Tasks',
                        autohide: true,
                        fade: true,
                        class: 'bg-warning',
                        delay: 2000,
                    })
                } else {
                    // show report table
                 $('#table_card').show(1000);
                //  show print button
                $('#print_report').show(500);
                // print data to table
                 $('#example1 tbody').text('')
                    $.each(response, function(index, value){
                        // console.log(value)
                        $('#example1 tbody').append('<tr><td>'+ ++index +'</td><td>'+value.task+'</td><td>'+new Date(value.created_at).toLocaleString()+'</td></tr>')
                    })
                }


            },
            error: function(err){
                console.log(err)
            }
        })
    }


})
</script>

{{-- append my kpis options --}}

{{-- filter query search --}}
@endsection
