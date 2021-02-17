@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Show Group</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary btn-xs" href="{{ route('groups.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="card card-body shadow">
 <div class="row">
     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Division Name:</strong> <br>
            {{ $group->division->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Group Name:</strong> <br>
            {{ $group->group_name }}
        </div>
    </div>
</div>
</div>

@endsection
