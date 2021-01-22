@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Role Management</h2>
        </div>
        <div class="float-right">
            @can('role-create')
            <a class="btn btn-success btn-xs" href="{{ route('roles.create') }}"> Create New Role</a>
            @endcan
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="card shadow card-body table-responsive">
<table class="table table-bordered table-sm">
    <tr>
        <th>No</th>
        <th>Role Name</th>
        <th width="">Action</th>
    </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info btn-xs" href="{{ route('roles.show',$role->id) }}">Show</a>
            @can('role-edit')
            <a class="btn btn-primary btn-xs" href="{{ route('roles.edit',$role->id) }}">Edit</a>
            @endcan
            @can('role-delete')
            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>
</div>


{!! $roles->render() !!}

@endsection
