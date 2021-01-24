@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2> Show Role</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary btn-xs" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="card card-body shadow">
 <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
            <ul>
                @foreach($rolePermissions as $v)
                <li>{{ $v->name }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
</div>

@endsection
