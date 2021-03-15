@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h3>{{ucfirst($title[0])}} {{ucfirst($title[1])}}</h3>
        </div>
        <div class="float-right">
            {{-- @can('role-create') --}}
            <a class="btn btn-success btn-xs" href="{{ route('department.create') }}"> Create New Department</a>
            {{-- @endcan --}}
        </div>
    </div>
</div>
@if ($admin)
@include('includes.structure_nav', [
'user_title'=> explode(' ',$title)[0].' '.explode(' ',$title)[1],
'users_url'=> '/users',
'kpi_url' => '/all/kpis/'.explode(' ',$title)[1],
'visual_url' => 'structure/visual/',
'report_url' => 'structure/report',
])
@else
    @include('includes.structure_nav', [
    'user_title'=> $title[0],
    'users_url'=> strtolower(explode(' ',$title[1])[0]).'/users/'.$structure->id,
    'kpi_url' => URL::signedRoute('kpi_structure', [strtolower(explode(' ',$title[1])[0]), $structure->id]),
    'visual_url' => 'structure/visual/',
    'report_url' => 'structure/report',
    ])
@endif
<div class="card shadow card-body table-responsive">
    <table class="dispaly compact table table-bordered table-sm" id="departmentTable">
        <thead>
            <th>No</th>
            <th>Department Name</th>
            @if ($admin)
<th>Division Name</th>
            @endif
            <th>Manager</th>
            <th>Action</th>
        </thead>
        @foreach ($departments as $key => $department)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $department->department_name }}</td>
            @if ($admin)
                <td>{{ $department->division->division_name ?? '' }}</td>
            @endif
            <td>

                @php
                $manager = ($department->manageStructure != null) ?
                '<a href="">'.($department->division->head($department->manageStructure->manager_id)->first_name.'
                    '.$department->division->head($department->manageStructure->manager_id)->last_name).'</a>' :
                '<a href="'.URL::signedRoute("manage_structure",['departments', $department->id ,'Manager']).'"
                    class="btn btn-sm
                    btn-outline-success"><i class="icofont icofont-plus"></i> Add Manager</a>';
                @endphp
                {!!$manager!!}
            </td>
            <td>
                <a class="btn btn-info btn-xs" href="{{ route('department.show',$department ->id) }}">Show</a>
                {{-- @can('department -edit') --}}
                <a class="btn btn-primary btn-xs" href="{{ route('department.edit',$department ->id) }}">Edit</a>
                {{-- @endcan --}}
                {{-- @can('department -delete') --}}
                {!! Form::open(['method' => 'DELETE','route' => ['department.destroy', $department
                ->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs', 'onClick'=>'return confirm("Are you
                sure")']) !!}
                {!! Form::close() !!}
                {{-- @endcan --}}
            </td>
        </tr>
        @endforeach
    </table>
</div>
{{-- {!! $departments->render() !!} --}}
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
         $('#departmentTable').DataTable(
        //      {
        // dom: 'Bfrtip',
        // buttons: [
        // 'print'
        // ]
        // }
        );
        //  $('body').toggle().addClass('sidebar-collaplse');
    } );
</script>
@endsection
