@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">CREATE KPI</div>
        <div class="card-body row justify-content-center">
            <div class="card container col-md-8">
                <div class="card-header text-uppercase h3">Create KPI Form
                </div>
                <div id="validation-errors"></div>
                <form action="{{route('kpi.store')}}" method="post" id="kpi_form">
                    @csrf
                    <div class="form-group">
                        <label for="perspective">Perspective:</label>
                        <select id="perspective" class="form-control @error('perspective') is-invalid @enderror"
                            name="perspective">
                            <option value="" selected disabled>Select Perspective</option>
                            <option value="Customer/ Stakeholder" @if (old('perspective')=="Customer/ Stakeholder" )
                                selected="selected" @endif>Customer/ Stakeholder</option>
                            <option value="Organizational Capabilities" @if (old('perspective')=="Organizational Capabilities" ) selected="selected" @endif>
                                Organizational Capabilities</option>
                        </select>
                        @error('perspective')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="kpi">KPI Name: </label>
                            <textarea name="kpi" id="kpi"
                                class="form-control @error('kpi') is-invalid @enderror">{{old('kpi')}}</textarea>
                            @error('kpi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="period">{{ __('Period') }}</label>
                            <input id="period" type="text" class="form-control @error('period') is-invalid @enderror" name="period"
                                value="{{ date('y') }}-{{ date('y')+1 }}" autocomplete="period" placeholder="20-21" disabled>
                            @error('period')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-groupv col-sm-4">
                            <label for="unit_of_mesure">UOM: </label>
                            <select name="unit_of_mesure" id="unit_of_mesure"
                                class="form-control  @error('unit_of_mesure') is-invalid @enderror">
                                <option selected disabled>Select Unit Of Mesure</option>
                                <option value="%" @if (old('unit_of_mesure')=='%' ) selected="selected" @endif>%
                                </option>
                                <option value="Day" @if (old('unit_of_mesure')=='Day' ) selected="selected" @endif>Day
                                </option>
                                <option value="Hrs" @if (old('unit_of_mesure')=='Hrs' ) selected="selected" @endif>Hrs
                                </option>
                                <option value="No" @if (old('unit_of_mesure')=='No' ) selected="selected" @endif>No
                                </option>
                                <option value="Date" @if (old('unit_of_mesure')=='Date' ) selected="selected" @endif>
                                    Date</option>
                            </select>
                            @error('unit_of_mesure')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="weight">{{ __('Weight') }}</label>
                            <input id="weight" type="text" class="form-control @error('weight') is-invalid @enderror"
                                name="weight" value="{{ old('weight') }}" autocomplete="weight" >
                            @error('weight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="target">{{ __('Target') }}</label>
                            <input id="target" type="text" class="form-control @error('target') is-invalid @enderror"
                                name="target" value="{{ old('target') }}" autocomplete="target" >
                            @error('target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="achievement">{{ __('achievement') }}</label>
                            <input id="achievement" type="text"
                                class="form-control @error('achievement') is-invalid @enderror" name="achievement"
                                value="{{ old('achievement') }}" autocomplete="achievement" >
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
                                name="validated_achievement" value="{{ old('validated_achievement') }}"
                                autocomplete="validated_achievement" >
                            @error('validated_achievement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="previous_target">{{ __('Previous Target') }}</label>
                            <input id="previous_target" type="text"
                                class="form-control @error('previous_target') is-invalid @enderror"
                                name="previous_target" value="{{ old('previous_target') }}"
                                autocomplete="previous_target" >
                            @error('previous_target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" id="form_submit" class="btn btn-outline-success">Create
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
