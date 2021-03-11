@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Department Management</h2>
        </div>
        <div class="float-right">
            {{-- @can('role-create') --}}
            <a class="btn btn-success btn-xs" href="{{ route('department.create') }}"> Create New Department</a>
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
        <th>Department Name</th>
        <th>Division Name</th>
        <th width="">Action</th>
    </tr>
    @foreach ($departments as $key => $department)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $department->department_name }}</td>
        <td>{{ $department->division->name ?? '' }}</td>
        <td>
            <a class="btn btn-info btn-xs" href="{{ route('department.show',$department ->id) }}">Show</a>
            {{-- @can('department -edit') --}}
            <a class="btn btn-primary btn-xs" href="{{ route('department.edit',$department ->id) }}">Edit</a>
            {{-- @endcan --}}
            {{-- @can('department -delete') --}}
            {!! Form::open(['method' => 'DELETE','route' => ['department.destroy', $department ->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs', 'onClick'=>'return confirm("Are you sure")']) !!}
            {!! Form::close() !!}
            {{-- @endcan --}}
        </td>
    </tr>
    @endforeach
</table>
</div>


{!! $departments->render() !!}

@endsection
