@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        {{-- <div class="card-header">EDIT KPI</div> --}}
        <div class="card-body row justify-content-center">
            <div class="card shadow col-md-8">
                <div class="card-header text-uppercase h3 text-center">Edit KPI Form</div>
                <div id="validation-errors"></div>
                <form action="{{route('kpi.update', [$kpi->id])}}" method="post" id="kpi_form">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="perspective">Perspective:</label>
                        <select id="perspective" class="form-control @error('perspective') is-invalid @enderror"
                            name="perspective">
                            <option value="" selected disabled>Select Perspective</option>
                            <option value=" Customer/ Stakeholder" @if (old('perspective', $kpi->perspective)==" Customer/ Stakeholder" )
                                selected="selected" @endif>Customer/ Stakeholder</option>
                            <option value="Organizational Capabilities" @if (old('perspective', $kpi->perspective)=="Organizational Capabilities" ) selected="selected" @endif>
                                Organizational Capabilities</option>
                        </select>
                        @error('perspective')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    {{-- division and group--}}
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="division_id">Division:</label>
                            <select id="division_id" class="form-control @error('division_id') is-invalid @enderror" name="division_id">
                                <option value="" selected disabled>Select Division</option>
                                @forelse (\Illuminate\Support\Facades\DB::table('divisions')->get() as $division)
                                <option value="{{$division->id}}" @if(old('division_id',$division->id)==$division->id )
                                    selected="selected" @endif>
                                    {{$division->name}}
                                </option>
                                @empty
                                <option value="" selected disabled>No Division Data</option>
                                @endforelse
                            </select>
                            @error('division_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="group_id">Group:</label>
                            <select id="group_id" class="form-control @error('group_id') is-invalid @enderror" name="group_id">
                                <option value="" selected disabled>Select Division</option>
                                @forelse (\Illuminate\Support\Facades\DB::table('groups')->get() as $group)
                                <option value="{{$group->id}}" @if(old('group_id',$group->id)==$group->id )
                                    selected="selected" @endif>
                                    {{$group->group_name}}
                                </option>
                                @empty
                                <option value="" selected disabled>No Division Data</option>
                                @endforelse
                            </select>
                            @error('group_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="kpi">KPI Name: </label>
                            <textarea name="kpi" id="kpi"
                                class="form-control @error('kpi') is-invalid @enderror">{{old('kpi',$kpi->kpi)}}</textarea>
                            @error('kpi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="period">{{ __('Period') }}</label>
                            <input id="period" type="text" class="form-control @error('period') is-invalid @enderror"
                                name="period" value="{{ old('period',$kpi->period) }}" autocomplete="period" placeholder="20-21">
                            @error('period')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-groupv col-sm-6">
                            <label for="unit_of_mesure">UOM: </label>
                            <select name="unit_of_mesure" id="unit_of_mesure"
                                class="form-control  @error('unit_of_mesure') is-invalid @enderror">
                                <option selected disabled>Select Unit Of Mesure</option>
                                <option value="%" @if (old('unit_of_mesure', $kpi->unit_of_measure)=="%" ) selected="selected" @endif>%
                                </option>
                                <option value="Day" @if (old('unit_of_mesure', $kpi->unit_of_measure)=="Day" ) selected="selected" @endif>Day
                                </option>
                                <option value="Hrs" @if (old('unit_of_mesure', $kpi->unit_of_measure)=="Hours" ) selected="selected" @endif>Hours
                                </option>
                                <option value="No" @if (old('unit_of_mesure', $kpi->unit_of_measure)=="No" ) selected="selected" @endif>No
                                </option>
                                <option value="Date" @if (old('unit_of_mesure', $kpi->unit_of_measure)=="Date" ) selected="selected" @endif>
                                    Date</option>
                            </select>
                            @error('unit_of_mesure')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="weight">{{ __('Weight') }}</label>
                            <input id="weight" type="text" class="form-control @error('weight') is-invalid @enderror"
                                name="weight" value="{{ old('weight',$kpi->weight) }}" autocomplete="weight">
                            @error('weight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-row">
                       <div class="form-group col-sm-6">
                        <label for="target">{{ __('Target') }}</label>
                        <input id="target" type="text" class="form-control @error('target') is-invalid @enderror" name="target"
                            value="{{ old('target', $kpi->target) }}" autocomplete="target">
                        @error('target')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                        {{-- <div class="form-group col-sm-4">
                            <label for="achievement">{{ __('achievement') }}</label>
                            <input id="achievement" type="text"
                                class="form-control @error('achievement') is-invalid @enderror" name="achievement"
                                value="{{ old('achievement',$kpi->achievement) }}" autocomplete="achievement">
                            @error('achievement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="validated_achievement">{{ __('Validated Achievement') }}</label>
                            <input id="validated_achievement" type="text"
                                class="form-control @error('validated_achievement') is-invalid @enderror"
                                name="validated_achievement" value="{{ old('validated_achievement', $kpi->validated_achievement) }}"
                                autocomplete="validated_achievement">
                            @error('validated_achievement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> --}}
                         <div class="form-group col-sm-6">
                            <label for="previous_target">{{ __('Previous Target') }}</label>
                            <input id="previous_target" type="text"
                                class="form-control @error('previous_target') is-invalid @enderror"
                                name="previous_target" value="{{ old('previous_target', $kpi->previous_target) }}"
                                autocomplete="previous_target">
                            @error('previous_target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" id="form_submit" class="btn btn-outline-success">Update
                            KPI</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
@endsection
@section('scripts')
<script>

</script>
@endsection
