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
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Full-Name</th>
        <th>Email</th>
        <th>Division</th>
        <th>Group</th>
        <th>Roles</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
       <td>{{ $user->fullName($user->id) ?? ''}}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->division->name ?? ''}}</td>
          <td>{{ $user->group->group_name ?? ''}}</td>
        <td>
            @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
            @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-xs btn-outline-info" href="{{ route('users.show',$user->id) }}">Show</a>
            <a class="btn btn-xs btn-outline-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Trash', ['class' => 'btn btn-xs btn-outline-danger ']) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>


{!! $data->render() !!}


@endsection
