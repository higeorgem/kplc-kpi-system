@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="float-left">
            <h2>Sub-Section Management</h2>
        </div>
        <div class="float-right">
            {{-- @can('role-create') --}}
            <a class="btn btn-success btn-xs" href="{{ route('subsections.create') }}"> Create New Sub-Section</a>
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
        <th>Sub-Section Name</th>
        <th>Section Name</th>
        <th>Department</th>
        <th>Division</th>
        <th width="">Action</th>
    </tr>
    @foreach ($subsections as $key => $subsection)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $subsection->subsection_name }}</td>
        <td>{{ $subsection->section->section_name }}</td>
        <td>{{ $subsection->department->department_name ?? ''}}</td>
        <td>{{ $subsection->division->name ?? ''}}</td>
        <td>
            <a class="btn btn-info btn-xs" href="{{ route('subsections.show',$subsection->id) }}">Show</a>
            {{-- @can('subsection-edit') --}}
            <a class="btn btn-primary btn-xs" href="{{ route('subsections.edit',$subsection->id) }}">Edit</a>
            {{-- @endcan --}}
            {{-- @can('subsection-delete') --}}
            {!! Form::open(['method' => 'DELETE','route' => ['subsections.destroy', $subsection->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs', 'onClick'=>'return confirm("Are you sure")']) !!}
            {!! Form::close() !!}
            {{-- @endcan --}}
        </td>
    </tr>
    @endforeach
</table>
</div>


{!! $subsections->render() !!}

@endsection
