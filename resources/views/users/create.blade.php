@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h4>Create New User</h4>
        </div>
        <div class="float-right">
            <a class="btn btn-xs btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="card card-body shadow">
    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-sm-4">
            <label for="staff_no">Staff Number : </label>
            @php
            // $staff_no = \Illuminate\Support\Facades\DB::table('users')->select('staff_no')->max('staff_no') + 1;
            @endphp
            <input type="text" name="staff_no" class="form-control" value="{{old('staff_no')}}" required autofocus>
            {{-- <input type="text" name="staff_no" id="staff_no" value="{{$staff_no}}" class="w-25" disabled> --}}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            <strong>First Name:</strong>
            {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
        </div>
        <div class="form-group col-sm-4">
            <strong>Middle Name:</strong>
            {!! Form::text('middle_name', null, array('placeholder' => 'Middle Name','class' => 'form-control')) !!}
        </div>
        <div class="form-group col-sm-4">
            <strong>Last Name:</strong>
            {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <strong>Division:</strong>
            <select name="division_id" id="division_id" class="form-control @error('division_id') is-invalid @enderror">
                <option value="" selected disabled>Select Division</option>
                @forelse (\Illuminate\Support\Facades\DB::table('divisions')->get() as $division)
                <option value="{{$division->id}}" {{old('division_id') == $division->id ? 'selected' : ''}}>
                    {{$division->division_name}}</option>
                @empty
                <option value="" disabled>No Division Data</option>
                @endforelse
            </select>
        </div>
        <div class="form-group col-sm-6">
            <strong>Department:</strong>
            <select name="department_id" id="department_id"
                class="form-control @error('department_id') is-invalid @enderror">
                <option value="" selected disabled>Select Department</option>
                {{-- @forelse (\Illuminate\Support\Facades\DB::table('departments')->get() as $department)
                <option value="{{$department->id}}" {{old('department_id') == $department->id ? 'selected' : ''}}>
                    {{$department->department_name}}
                </option>
                @empty
                <option value="" disabled>No Department Data</option>
                @endforelse --}}
            </select>
            @error('department_id')
            <span class="invalid-feedback">
                <strong>{{$message}}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <strong>Section:</strong>
            <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror">
                <option value="" selected disabled>Select Section</option>
                {{-- @forelse (\Illuminate\Support\Facades\DB::table('sections')->get() as $section)
                <option value="{{$section->id}}" {{old('section_id') == $section->id ? 'selected' : ''}}>
                    {{$section->section_name}}
                </option>
                @empty
                <option value="" disabled>No Section Data</option>
                @endforelse --}}
            </select>
        </div>
        <div class="form-group col-sm-6">
            <strong>Sub-Section:</strong>
            <select name="sub_section_id" id="sub_section_id"
                class="form-control @error('sub_section_id') is-invalid @enderror">
                <option value="" selected disabled>Select Division</option>
                {{-- @forelse (\Illuminate\Support\Facades\DB::table('sub_sections')->get() as $sub_section)
                <option value="{{$sub_section->id}}" {{old('sub_section_id') == $sub_section->id ? 'selected' : ''}}>
                    {{$sub_section->sub_section_name}}</option>
                @empty
                <option value="" disabled>No Sub-Section Data</option>
                @endforelse --}}
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' =>
                'form-control'))
                !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script>
    $(function(){
        // disable department section and subsection on load
        enableDisable(true, 'all');
        // on change division 1. enable department 2. populate department select
        $('#division_id').on('change', function(){
            // on change remove the children of the section select
            $("#department_id").children().remove();
            // disable all and enable departments
            enableDisable(true, 'all');
            // clear errors
            clearErrors();
            // get the selected id
            var division_id = $(this).val();
            var table_name = 'departments';
            // console.log(division_id)
            // push and ajax request to collect the data
            getStructureData(table_name,division_id,'division')

        });
        $('#department_id').on('change', function(){
            // on change
            $("#section_id").children().remove();
            // disable all and enable departments
            enableDisable(true, 'section');
            enableDisable(true, 'sub_section');
            // clear errors
            clearErrors();
            // get the selected id
            var department_id = $(this).val();
            var table_name = 'sections';
            // console.log(department_id)
            // push and ajax request to collect the data
            getStructureData(table_name,department_id, 'department')
        })
        $('#section_id').on('change', function(){
            // on change
            $("#sub_section_id").children().remove();
            // disable all and enable departments
            enableDisable(true, 'sub_section');
            // clear errors
            clearErrors();
            // get the selected id
            var sub_section_id = $(this).val();
            var table_name = 'sub_sections';
            // console.log(division_id)
            // push and ajax request to collect the data
            getStructureData(table_name,sub_section_id,'section')
        })

    //function enable disable edepartment section and subsection on load
    function enableDisable(status, inputTag = null){
        if (inputTag  == 'department') {
            $('#department_id').prop('disabled', status);
        }
        if (inputTag  == 'section') {
            $('#section_id').prop('disabled', status);
        }

        if (inputTag  == 'sub_section') {
            $('#sub_section_id').prop('disabled', status);
        }

        if(inputTag  == 'all'){
            $('#department_id').prop('disabled', status);
            $('#section_id').prop('disabled', status);
            $('#sub_section_id').prop('disabled', status);
            loadFasion('#department_id');
            loadFasion('#section_id');
            loadFasion('#sub_section_id');

        }else{
             loadFasion('#'+inputTag+'_id');
        }

    }
    // function to get structure data
        function getStructureData(query_table, query_id, query_value){
            // init structure
            var structure = query_table.substr(0,query_table.length-1);
            // remove the invalid class from the select
            $("#"+structure+"_id").removeClass('is-invalid');
            // setup ajax for laravel queries
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
                }
            });
            // ajax request
            $.ajax({
                url: '{{URL::signedRoute('manage_user_structure')}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    query_table : query_table,
                    query_id : query_id,
                    query_value: query_value
                },
                success: function(response) {
                    console.log(response.length)

                    // unlock the next input tag
                    enableDisable(false, structure);

                    // check for data availability
                    if (response.length == 0) {
                        // no data
                        // add invalid class to the select
                        $("#"+structure+"_id").addClass('is-invalid');
                        // disable the input tag
                        // enableDisable(true, structure);
                        // remove existing options
                        // $("#"+structure+"_id").children('option:not(:first)').remove();
                        // add no data message to the select
                        $("#"+structure+"_id").append('<option selected disabled>No Data !!</option>');
                        }else{
                        // data found
                        $("#"+structure+"_id").append('<option value="" selected disabled>Select '+structure+'</option>');
                        // populate the options on select
                        $.each(response, function(index, value){
                        console.log(value)
                        $("#"+structure+"_id").append('<option value='+value.id+'>'+value.name+'</option>')
                        })
                    }
                },
                error: function(error){
                console.log(error)
                }
            })
        }
        // loading fasion
        function loadFasion(id, timer = 1000){
            // add loading
            $(id).LoadingOverlay("show", {
            background : "rgba(165, 190, 100, 0.5)"
            });

            // timeout for loading
            setTimeout(function(){
                $(id).LoadingOverlay("hide", true);
            }, timer);
        }
        // clear errors
        function clearErrors() {
            $("#department_id").removeClass('is-invalid');
            $("#section_id").removeClass('is-invalid');
            $("#sub_section_id").removeClass('is-invalid');
        }
    })
</script>
@endsection
