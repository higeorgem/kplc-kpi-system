@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Section</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-xs" href="{{ route('sections.index') }}"> Back</a>
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

<div class="card card-body shadow table-responsive">
    {!! Form::open(array('route' => 'sections.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Select Division:</strong><br>
                <select name="division_name" id="division_name" class="form-control @error('division_name') is-invalid @enderror">
                    <option value="" selected disabled>Select Division</option>
                    @forelse ($divisions as $division)
                    <option value="{{$division->id}}" {{old('division_name') == $division->id ? 'selected' : ''}}>{{$division->name}}</option>
                    @empty
<option value="" selected disabled>No Division Data</option>
                    @endforelse
                </select>
                @error('division_name')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Select Department:</strong><br>
                <select name="department_name" id="department_name" class="form-control">
                    <option value="" selected disabled>Select Department</option>
                    @forelse ($departments as $department)
                    <option value="{{$department->id}}" {{old('department_name') == $department->id ? 'selected' : ''}}>{{$department->department_name}}
                    </option>
                    @empty
                    <option value="" selected disabled>No Division Data</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Section Name:</strong>
                {!! Form::text('section_name', null, array('placeholder' => 'Section Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-1`2 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>




@endsection
