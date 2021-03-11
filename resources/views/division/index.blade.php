@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Division Management</h2>
        </div>
        <div class="float-right">
            @can('division-create')
            <a class="btn btn-success btn-xs" href="{{ route('divisions.create') }}"> Create New Division</a>
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
        <th>Division Name</th>
        <th>General Manager</th>
        <th width="">Action</th>
    </tr>
    @foreach ($divisions as $key => $division)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $division->division_name }}</td>
        <td>
            {{-- {{ $division->manageStructure->manager_id}} --}}
            @php
               $manager = ($division->manageStructure != null) ?  ($division->head($division->manageStructure->manager_id)->first_name.' '.$division->head($division->manageStructure->manager_id)->last_name) : '<a href="'.URL::signedRoute("manage_structure",['divisions', $division->id ,'General Manager']).'" class="btn btn-sm btn-outline-success"><i class="icofont icofont-plus"></i>
                 Add Manager</a>';
            @endphp
            {!!$manager!!}
        </td>
        <td>
            <a class="btn btn-info btn-xs" href="{{ route('divisions.show',$division->id) }}">Show</a>
            @can('division-edit')
            <a class="btn btn-primary btn-xs" href="{{ route('divisions.edit',$division->id) }}">Edit</a>
            @endcan
            @can('division-delete')
            {!! Form::open(['method' => 'DELETE','route' => ['divisions.destroy', $division->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs', 'onClick'=>'return confirm("Are you sure")']) !!}
            {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>
</div>


{!! $divisions->render() !!}

@endsection
