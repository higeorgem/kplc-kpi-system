@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Department</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-xs" href="{{ route('department.index') }}"> Back</a>
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
  {!! Form::open(array('route' => 'department.store','method'=>'POST')) !!}
  <div class="row">
      <div class="col-xs-12 col-sm-12 colmd-12">
          <strong>Division Name</strong>
          <select name="division_name" id="division_name" class="form-control @error('division_name') is-invalid @enderror">
            <option value="" selected disabled>Select Division</option>
            @foreach ($divisions as $division)
                <option value="{{$division->id}}">{{$division->name}}</option>
            @endforeach
          </select>
      </div>
  </div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Department Name:</strong>
            {!! Form::text('department_name', null, array('placeholder' => 'Department Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
</div>




@endsection
