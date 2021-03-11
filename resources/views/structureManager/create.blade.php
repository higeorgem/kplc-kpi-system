@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2 class="text-uppercase">
                Create
                <b>{{ $structure->structure_name }}
                    {{$structure_type}}</b>
                {{$manager_type}}

            </h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary btn-xs" href="{{url()->previous()}}"> Back</a>
        </div>
    </div>
</div>

<div class="row card card-body shadow">
    <div class="">
        <form action="{{URL::signedRoute('saveManager')}}" method="post">
            @csrf
            {{-- structure id --}}
            <input type="hidden" name="structure_id" value="{{$structure->id}}">
            {{-- structure type --}}
            {{-- <input type="hidden" name="structure_type" value="{{$structure_type}}"> --}}
            {{-- manager_type --}}
            <input type="hidden" name="manager_type" value="{{$manager_type}}">

            <div class="col-md-6 form-group">
                <label for="manager_id">Select {{$manager_type}} :</label>
                <select name="manager_id" id="manager_id"
                    class="form-control @error('manager_id') is-invalid @enderror">
                    <option value="" selected disabled>Select Manger</option>
                    @foreach ($managers as $manager)
                    <option value="{{$manager->id}}">{{$manager->first_name}} {{$manager->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6  form-group">
                <button type="submit" class="btn btn-sm btn-outline-success float-right">Save</button>
            </div>
        </form>
    </div>

</div>

@endsection
