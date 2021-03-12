@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h4>Edit New User</h4>
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

<div class="card shadow card-body">
    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
    <div class="row">
        <div class="col-md-12">
            Staff Number: <span class="border border-success rounded p-1">{{$user->staff_no}}</span>
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
                <option value="{{$division->id}}"
                    {{old('division_id', $division->id) == $division->id ? 'selected' : ''}}>
                    {{$division->division_name}}</option>
                @empty
                <option value="" disabled>No Division Data</option>
                @endforelse
            </select>
        </div>
        <div class="form-group col-sm-6">
            <strong>Section:</strong>
            <select name="group_id" id="group_id" class="form-control @error('group_id') is-invalid @enderror">
                <option value="" selected disabled>Select Group</option>
                @forelse (\Illuminate\Support\Facades\DB::table('sections')->get() as $section)
                <option value="{{$section->id}}" {{old('group_id', $section->id) == $section->id ? 'selected' : ''}}>
                    {{$section->section_name}}
                </option>
                @empty
                <option value="" disabled>No Group Data</option>
                @endforelse
            </select>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div> --}}
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
        </div>{{----}}
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>


@endsection
