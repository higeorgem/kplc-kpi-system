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
            <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror">
                <option value="" selected disabled>Select Department</option>
                @forelse (\Illuminate\Support\Facades\DB::table('departments')->get() as $department)
                <option value="{{$department->id}}" {{old('department_id') == $department->id ? 'selected' : ''}}>
                    {{$department->department_name}}
                </option>
                @empty
                <option value="" disabled>No Department Data</option>
                @endforelse
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
                <option value="" selected disabled>Select Group</option>
                @forelse (\Illuminate\Support\Facades\DB::table('sections')->get() as $section)
                <option value="{{$section->id}}" {{old('section_id') == $section->id ? 'selected' : ''}}>
                    {{$section->section_name}}
                </option>
                @empty
                <option value="" disabled>No Section Data</option>
                @endforelse
            </select>
        </div>
        <div class="form-group col-sm-6">
            <strong>Sub-Section:</strong>
            <select name="sub_section_id" id="sub_section_id" class="form-control @error('sub_section_id') is-invalid @enderror">
                <option value="" selected disabled>Select Division</option>
                @forelse (\Illuminate\Support\Facades\DB::table('sub_sections')->get() as $sub_section)
                <option value="{{$sub_section->id}}" {{old('sub_section_id') == $sub_section->id ? 'selected' : ''}}>
                    {{$sub_section->sub_section_name}}</option>
                @empty
                <option value="" disabled>No Sub-Section Data</option>
                @endforelse
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
