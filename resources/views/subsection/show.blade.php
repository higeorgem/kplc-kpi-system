@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Show Sub-Section</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary btn-xs" href="{{ route('subsections.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="card card-body shadow">
 <div class="row">
     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-section">
            <strong>Division Name:</strong> <br>
            {{ $subsection->division->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-subsection">
            <strong>Department Name:</strong> <br>
            {{ $subsection->department->department_name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-section">
            <strong>Section:</strong> <br>
            {{ $subsection->section->section_name }}
        </div>
    </div>
     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-section">
            <strong>Sub-Section:</strong> <br>
            {{ $subsection->subsection_name }}
        </div>
    </div>
</div>
</div>

@endsection
