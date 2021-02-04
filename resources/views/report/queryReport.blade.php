@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 card shadow">
      <form class="form-inline p-2">
        <div class="form-group ">
            <label for="staticEmail2">Filter</label>
        </div>
        <div class="form-group mx-sm-3">
            <label for="category" class="sr-only">Password</label>
            <select name="category" id="category" class="form-control">
                <option value="" selected disabled>Category</option>
                <option value=""> All KPI</option>
                <option value=""> My Kpis</option>
            </select>
        </div>
        <div class="form-group mx-xs-3">
            <label for="inputStartDate" class="sr-only">Start Date</label>
            <input type="date" class="form-control " id="inputStartDate" name="inputEndDate" placeholder="Start Date">
        </div>
         <div class="form-group mx-sm-3">
            <label for="inputEndDate" class="sr-only">End date</label>
            <input type="date" class="form-control " id="inputEndDate" name="inputEndDate" placeholder="End Date">
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Query</button>
    </form>
    </div>
</div>

@endsection
@section('scripts')
{{-- append my kpis options --}}

{{-- filter query search --}}
@endsection
