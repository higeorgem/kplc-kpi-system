@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Show Section</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary btn-xs" href="{{ route('sections.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="card card-body shadow">
 <div class="row">
     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-section">
            <strong>Division Name:</strong> <br>
            {{ $section->division->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-section">
            <strong>Department Name:</strong> <br>
            {{ $section->department->department_name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-section">
            <strong>Section Name:</strong> <br>
            {{ $section->section_name }}
        </div>
    </div>
</div>
</div>

@endsection
