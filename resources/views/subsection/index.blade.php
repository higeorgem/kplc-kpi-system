@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="float-left">
            <h3>{{$title}}</h3>
        </div>
        <div class="float-right">
            {{-- @can('role-create') --}}
            <a class="btn btn-success btn-xs" href="{{ route('subsections.create') }}"> Create New Sub-Section</a>
            {{-- @endcan --}}
        </div>
    </div>
</div>


@if (!$admin)
    @include('includes.structure_nav', [
    'user_title'=> explode(' ',$title)[0].' '.explode(' ',$title)[1],
    'users_url'=> explode(' ',$title)[0].' '.strtolower(explode(' ',$title)[1]).'/users/'.$structure->id,
    'kpi_url' => 'structure/kpi/',
    'visual_url' => 'structure/visual/',
    'report_url' => 'structure/report',
    ])
@endif

<div class="card shadow card-body table-responsive">
<table class="display compact table table-bordered table-sm" id="subsectionTable">
    <thead>
        <th>No</th>
        <th>Sub-Section Name</th>
        <th>Section Name</th>
        <th>Department</th>
        <th>Division</th>
        <th>Principle</th>
        <th width="">Action</th>
    </thead>
    @foreach ($subsections as $key => $subsection)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ ucfirst($subsection->sub_section_name) ?? '' }}</td>
        <td>{{ $subsection->section->section_name ?? '' }}</td>
        <td>{{ $subsection->department->department_name ?? ''}}</td>
        <td>{{ $subsection->division->division_name ?? ''}}</td>
        <td>
            @php
            $manager = ($subsection->manageStructure != null) ?
            ($subsection->division->head($subsection->manageStructure->manager_id)->first_name.'
            '.$subsection->division->head($subsection->manageStructure->manager_id)->last_name) :
            '<a href="'.URL::signedRoute("manage_structure",['sub_sections', $subsection->id ,'principle']).'" class="btn btn-sm
                btn-outline-success"><i class="icofont icofont-plus"></i> Add Principle</a>';
            @endphp
            {!!$manager!!}
        </td>
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


{{-- {!! $subsections->render() !!} --}}

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
         $('#subsectionTable').DataTable();
        //  $('body').toggle().addClass('sidebar-collaplse');
    } );
</script>
@endsection
