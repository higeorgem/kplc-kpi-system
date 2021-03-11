@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Edit Section</h2>
        </div>
        <div class="float-right">
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

<div class="card shadow card-body table-responsive">
{!! Form::model($subsection, ['method' => 'PATCH','route' => ['subsections.update', $subsection->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Select Division:</strong><br>
            <select name="division_name" id="division_name" class="form-control">
                <option value="" selected disabled>Select Division</option>
                @forelse ($divisions as $division)
                <option value="{{$division->id}}" {{old('division_name',$division->id) == $division->id ? 'selected' : ''}}>{{$division->name ?? ""}}
                </option>
                @empty

                @endforelse
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Select Department:</strong><br>
            <select name="department_name" id="department_name" class="form-control">
                <option value="" selected disabled>Select Division</option>
                @forelse ($departments as $department)
                <option value="{{$department->id}}" {{old('department_name',$department->id) == $department->id ? 'selected' : ''}}>{{$department->department_name ?? ""}}
                </option>
                @empty

                @endforelse
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Select Section:</strong><br>
            <select name="section_name" id="section_name" class="form-control">
                <option value="" selected disabled>Select Section</option>
                @forelse ($sections as $section)
                <option value="{{$section->id}}" {{old('section_name',$section->id) == $section->id ? 'selected' : ''}}>
                    {{$section->section_name}}
                </option>
                @empty
                <option value="" selected disabled>No Division Data</option>
                @endforelse
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Sub-Section Name:</strong>
            {!! Form::text('subsection_name', null, array('placeholder' => 'Sub-Section Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
</div>



@endsection
