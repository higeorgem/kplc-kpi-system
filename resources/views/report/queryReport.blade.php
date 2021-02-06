@extends('layouts.app')

@section('styles')
{{-- datatables --}}
<link rel="stylesheet" href="{{asset('css/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 card shadow">
        <form class="form-inline p-2" id="query_form">
            @csrf
            <div class="form-group ">
                <label for="staticEmail2">Filter</label>
            </div>
            <div class="form-group mx-sm-4">
                <label for="kpi_id" class="sr-only">Password</label>
                <select name="kpi_id" id="kpi_id" class="form-control" required>
                    <option value="" selected disabled>Category</option>
                    <option value="all"> All My Tasks</option>
                    @forelse (\Illuminate\Support\Facades\DB::table('k_p_i_s')
                    ->whereNUll('deleted_at')
                    ->where('division_id', Auth::user()->division_id)->get() as $kpi)
                    <option value="{{$kpi->id}}" {{old('kpi_id') == $kpi->id ? 'selected' : ''}}> {{$kpi->kpi}}</option>
                    @empty

                    @endforelse
                </select>
            </div>
            <div class="form-group mx-xs-3">
                <label for="inputStartDate" class="sr-only">Start Date</label>
                <input type="date" class="form-control" value="{{old('inputStartDate')}}" id="inputStartDate"
                    name="inputStartDate" placeholder="Start Date" required>
            </div>
            <div class="form-group mx-sm-3">
                <label for="inputEndDate" class="sr-only">End date</label>
                <input type="date" class="form-control" value="{{old('inputEndDate')}}" id="inputEndDate"
                    name="inputEndDate" placeholder="End Date" required>
            </div>
            <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="icofont-question"></i>
                Query</button>
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
<script src="{{asset('css/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>p
<script src="{{asset('css/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>p
<script src="{{asset('css/plugins/pdfmake/pdfmake.min.js')}}"></script>p
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
    // data tables initialization
    // global variable declaration
    var kpi_id;
    var start_date;
    var end_date;

    // select kpi_id change
    $('#kpi_id').on('change', function(){
        // variable declaration
       kpi_id = $(this).val();
        console.log(kpi_id)
        // if kpi_id is all
    });

    // select start date change
    $('#inputStartDate').on('change', function(){
        // variable declaration
       start_date = $(this).val();
        console.log(start_date)
        // if kpi_id is all
    });
      // select end date change
    $('#inputEndDate').on('change', function(){
        // variable declaration
       end_date = $(this).val();
        console.log(end_date)
        // if kpi_id is all
    });

    // submit query form
    $('#query_form').submit(function(e){
        e.preventDefault();
        // load gif
        console.log('loading gif')

        // display query data
        var form_data = $(this).serializeArray();
        // console.log(form_data);
        getQuery(form_data);
        // $('#example1').DataTable();
    })
    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    function getQuery(params) {
        $.ajax({
            url: '{{route("get_task_query")}}',
            type: 'POST',
            data: params,
            success: function(response){
                // console.log(response)
                // $('#example1 tbody').text('')
                 $('#table_card').show(1000);
                $('#helper_text').text($('#kpi_id :selected').text()+' '+ start_date + ' To '+ end_date)
                $.each(response, function(index, value){
                    console.log(value)
                    $('#example1 tbody').append('<tr><td>'+ ++index +'</td><td>'+value.task+'</td><td>'+value.created_at+'</td></tr>')
                })

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
