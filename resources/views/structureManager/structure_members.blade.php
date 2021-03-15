@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-header bg-dark">
<div class="float-left">
            <h4>{{$title}}</h4>
        </div>
        <div class="float-right">
            <a class="btn btn-sm btn-info" href="{{ url()->previous() }}"> Back</a>
        </div>
    </div>
    <div class="card-body">
       <div class="table-responsive">
    <table class="display compact table table-sm table-bordered " id="usersTable" style="width:100%">
        <thead class="">
            <th>No</th>
            <th>Full-Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Section</th>
            <th>Sub-Section</th>
            <th width="350px">Action</th>
        </thead> @php
                $structure = new App\User;
            @endphp
        @foreach ($structure->hydrate($data) as $key => $user)
        <tr>
            <td>{{ ++$key }}</td>
            <td>
                {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
                {{-- {{ $user->fullName($user->id) ?? ''}} --}}
            </td>

            <td>{{ $user->email }}</td>
            <td>{{ $user->department->department_name ?? ''}}</td>
            <td>{{ $user->section->section_name ?? ''}}</td>
            <td>{{ $user->subsection->sub_section_name ?? ''}}</td>
            <td class="p-1" style="display: inline">

                <a class="btn btn-xs btn-outline-info float-left" href="{{ route('users.show',$user->id) }}">Show</a>
                @can('users-edit')
<a class="btn btn-xs btn-outline-primary float-left m-1" href="{{ route('users.edit',$user->id) }}">Edit</a>
                @endcan
                {{-- {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'',
                'class'=>'float-left']) !!}
                {!! Form::submit('Trash', ['class' => 'btn btn-xs btn-outline-danger', 'onclick']) !!}
                {!! Form::close() !!} --}}
                @can('users-delete')
                <form action="{{route('users.destroy',[$user->id])}}" method="post" class="float-left">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are You Sure ?')"
                        class="btn btn-xs btn-outline-danger">Trash</button>
                </form>
                @endcan

            </td>
        </tr>
        @endforeach
        <tfoot>
            <th>No</th>
            <th>Full-Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Section</th>
            <th>Sub-Section</th>
            <th>Action</th>
        </tfoot>
    </table>
</div>
    </div>
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
