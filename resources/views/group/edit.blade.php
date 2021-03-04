@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Edit Group</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary btn-xs" href="{{ route('groups.index') }}"> Back</a>
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
{!! Form::model($group, ['method' => 'PATCH','route' => ['groups.update', $group->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Select Department:</strong><br>
            <select name="dept_id" id="dept_id" class="form-control">
                <option value="" selected disabled>Select Division</option>
                @forelse ($divisions as $division)
                <option value="{{$division->id}}" {{old('dept_id',$division->id) == $division->id ? 'selected' : ''}}>{{$division->name ?? ""}}
                </option>
                @empty

                @endforelse
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Group Name:</strong>
            {!! Form::text('group_name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
</div>



@endsection