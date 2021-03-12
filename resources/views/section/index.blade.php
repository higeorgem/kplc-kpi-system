@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>{{ucfirst($title)}}</h2>
        </div>
        <div class="float-right">
            {{-- @can('role-create') --}}
            <a class="btn btn-success btn-xs" href="{{ route('sections.create') }}"> Create New Section</a>
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
        <th>Department</th>
        <th>Division</th>
        <th>Chief</th>
        <th width="">Action</th>
    </tr>
    @foreach ($sections as $key => $section)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $section->section_name }}</td>
        <td>{{ $section->department->department_name ?? ''}}</td>
        <td>{{ $section->department->division->division_name ?? ''}}</td>
        <td>
            {{-- {{dd($section->department->division)}} --}}

            @php
            $manager = ($section->manageStructure != null) ?
            ($section->department->division->head($section->manageStructure->manager_id)->first_name.'
            '.$section->department->division->head($section->manageStructure->manager_id)->last_name) :
            '<a href="'.URL::signedRoute("manage_structure",['sections', $section->id ,'Chief']).'" class="btn btn-sm
                btn-outline-success"><i class="icofont icofont-plus"></i> Add Chief</a>';
            @endphp
            {!!$manager!!}
        </td>
        <td>
            <a class="btn btn-info btn-xs" href="{{ route('sections.show',$section->id) }}">Show</a>
            {{-- @can('section-edit') --}}
            <a class="btn btn-primary btn-xs" href="{{ route('sections.edit',$section->id) }}">Edit</a>
            {{-- @endcan --}}
            {{-- @can('section-delete') --}}
            {!! Form::open(['method' => 'DELETE','route' => ['sections.destroy', $section->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs', 'onClick'=>'return confirm("Are you sure")']) !!}
            {!! Form::close() !!}
            {{-- @endcan --}}
        </td>
    </tr>
    @endforeach
</table>
</div>


{!! $sections->render() !!}

@endsection