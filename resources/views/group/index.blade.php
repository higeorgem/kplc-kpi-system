@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Section Management</h2>
        </div>
        <div class="float-right">
            {{-- @can('role-create') --}}
            <a class="btn btn-success btn-xs" href="{{ route('groups.create') }}"> Create New Section</a>
            {{-- @endcan --}}
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
        <th>Section Name</th>
        <th>Division</th>
        <th width="">Action</th>
    </tr>
    @foreach ($groups as $key => $group)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $group->group_name }}</td>
        <td>{{ $group->division->name ?? ''}}</td>
        <td>
            <a class="btn btn-info btn-xs" href="{{ route('groups.show',$group->id) }}">Show</a>
            {{-- @can('group-edit') --}}
            <a class="btn btn-primary btn-xs" href="{{ route('groups.edit',$group->id) }}">Edit</a>
            {{-- @endcan --}}
            {{-- @can('group-delete') --}}
            {!! Form::open(['method' => 'DELETE','route' => ['groups.destroy', $group->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs', 'onClick'=>'return confirm("Are you sure")']) !!}
            {!! Form::close() !!}
            {{-- @endcan --}}
        </td>
    </tr>
    @endforeach
</table>
</div>


{!! $groups->render() !!}

@endsection
