@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h4>Users Management</h4>
        </div>
        <div class="float-right">
            <a class="btn btn-sm btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
    </div>
</div>
{{-- {{dd($data)}} --}}
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="table-responsive">
    <table class="display compact table table-bordered table-sm" id="usersTable" style="width:100%">
        <thead>
            <th>No</th>
            <th>Full-Name</th>
            <th>Email</th>
            <th>Division</th>
            <th>Department</th>
            <th>Section</th>
            <th>Sub-Section</th>
            <th>Roles</th>
            <th width="350px">Action</th>
        </thead>
        @foreach ($data as $key => $user)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $user->fullName($user->id) ?? ''}}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->division->division_name ?? ''}}</td>
            <td>{{ $user->department->department_name ?? ''}}</td>
            <td>{{ $user->section->section_name}}</td>
            <td>{{ $user->subsection->sub_section_name ?? ''}}</td>
            <td>
                @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
                @endforeach
                @endif
            </td>
            <td class="" style="display: inline">
                <a class="btn btn-xs btn-outline-info float-left" href="{{ route('users.show',$user->id) }}">Show</a>
                <a class="btn btn-xs btn-outline-primary float-left" href="{{ route('users.edit',$user->id) }}">Edit</a>
                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'',
                'class'=>'float-left']) !!}
                {!! Form::submit('Trash', ['class' => 'btn btn-xs btn-outline-danger', 'onclick']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
        <tfoot>
            <th>No</th>
            <th>Full-Name</th>
            <th>Email</th>
            <th>Division</th>
            <th>Department</th>
            <th>Section</th>
            <th>Sub-Section</th>
            <th>Roles</th>
            <th>Action</th>
        </tfoot>
    </table>
</div>
{{-- {!! $data->render() !!} --}}
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
         $('#usersTable').DataTable();
        //  $('body').toggle().addClass('sidebar-collaplse');
    } );
</script>
@endsection
