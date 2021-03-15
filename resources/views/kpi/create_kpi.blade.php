@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-dark text-center h2">CREATE KPI</div>
        <div class="card-body row justify-content-center">
            <div class=" container col-md-">
                {{-- <div class="card-header text-uppercase h3">Create KPI Form
                </div>--}}
                <div id="validation-errors"></div>
                <form action="{{route('kpi.store')}}" method="post" id="kpi_form">
                    @csrf
                    {{-- perspective --}}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="perspective">Perspective:</label>
                            <select id="perspective" class="form-control @error('perspective') is-invalid @enderror"
                                name="perspective">
                                <option value="" selected disabled>Select Perspective</option>
                                @forelse (\Illuminate\Support\Facades\DB::table('k_p_i_perspectives')->get() as $perspective)
                                <option value="{{$perspective->id}}" @if (old('perspective')==$perspective->id) selected="selected"
                                    @endif>{{ucfirst($perspective->perspective)}}</option>
                                @empty
                                    <option value="" selected disabled>No Units Of Measure</option>
                                @endforelse
                               {{--  <option value="Customer/ Stakeholder" @if (old('perspective')=="Customer/ Stakeholder" )
                                    selected="selected" @endif>Customer/ Stakeholder</option>
                                <option value="Organizational Capabilities"
                                    @if(old('perspective')=="Organizational Capabilities" ) selected="selected" @endif>
                                    Organizational Capabilities</option> --}}
                            </select>
                            @error('perspective')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kpi_type">KPI Type:</label>
                            <select id="kpi_type" class="form-control @error('kpi_type') is-invalid @enderror"
                                name="kpi_type">
                                <option value="" selected disabled>Select KPI Type</option>
                                <option value="Tasked" @if (old('kpi_type')=="Tasked" ) selected="selected" @endif>
                                    Tasked</option>
                                <option value="NotTasked" @if(old('kpi_type')=="NotTasked" ) selected="selected" @endif>
                                    Not Tasked</option>
                            </select>
                            @error('kpi_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    {{-- division and group--}}
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="structure">Structure:</label>
                            <select id="structure" class="form-control @error('structure') is-invalid @enderror"
                                name="structure">
                                <option value="" selected disabled>Select Structure</option>
                                <option value="divisions">Division</option>
                                <option value="departments">Department</option>
                                <option value="sections">Section</option>
                                <option value="sub_sections">Sub-Section</option>
                            </select>
                            @error('structure')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="structure_id" id="structure_label">Select Structure:</label>
                            <select id="structure_id" class="form-control @error('structure_id') is-invalid @enderror"
                                name="structure_id">
                               <option value="" selected disabled>Select Structure Type:</option>
                               {{--   @forelse (\Illuminate\Support\Facades\DB::table('groups')->get() as $group)
                                    <option value="{{$group->id}}" @if(old('structure_id')==$group->id )
                                        selected="selected" @endif>
                                        {{$group->group_name}}
                                    </option>
                                @empty
                                <option value="" selected disabled>No Division Data</option>
                                @endforelse --}}

                            </select>
                            @error('structure_id')
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
                                class="form-control @error('kpi') is-invalid @enderror">{{old('kpi')}}</textarea>
                            @error('kpi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="period">{{ __('Period') }}</label>
                            <input type="hidden" name="period" value="{{ date('y') }}-{{ date('y')+1 }}">
                            <input id="period" type="text" class="form-control @error('period') is-invalid @enderror"
                                name="period" value="{{ date('y') }}-{{ date('y')+1 }}" autocomplete="period"
                                placeholder="20-21" disabled>
                            @error('period')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-groupv col-sm-6">
                            <label for="unit_of_mesure">Unit Of Measure: </label>
                            <select name="unit_of_mesure" id="unit_of_mesure"
                                class="form-control  @error('unit_of_mesure') is-invalid @enderror">
                                <option value="" selected disabled>Select Unit Of Mesure</option>
                                @forelse (\Illuminate\Support\Facades\DB::table('unit_of_measures')->get() as $uom)
                                <option value="{{$uom->id}}" @if (old('unit_of_mesure')== $uom->id) selected="selected" @endif>{{ucfirst($uom->unit_of_measure)}}</option>
                                @empty
                                    <option value="" selected disabled>No Units Of Measure</option>
                                @endforelse

                                {{-- <option value="Day" @if (old('unit_of_mesure')=='Day' ) selected="selected" @endif>Day
                                </option>
                                <option value="Hrs" @if (old('unit_of_mesure')=='Hrs' ) selected="selected" @endif>Hrs
                                </option>
                                <option value="No" @if (old('unit_of_mesure')=='No' ) selected="selected" @endif>No
                                </option>
                                <option value="Date" @if (old('unit_of_mesure')=='Date' ) selected="selected" @endif>
                                    Date</option> --}}
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
                                name="weight" value="{{ old('weight') }}" autocomplete="weight">
                            @error('weight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="form-group col-sm-6">
                            <label for="target">{{ __('Target') }}</label>
                            <input id="target" type="text" class="form-control @error('target') is-invalid @enderror"
                                name="target" value="{{ old('target') }}" autocomplete="target">
                            @error('target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> --}}


                        {{-- <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="achievement">{{ __('achievement') }}</label>
                        <input id="achievement" type="text"
                            class="form-control @error('achievement') is-invalid @enderror" name="achievement"
                            value="{{ old('achievement') }}" autocomplete="achievement">
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
                            autocomplete="validated_achievement">
                        @error('validated_achievement')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>--}}
                    {{-- <div class="form-group col-sm-6">
                        <label for="previous_target">{{ __('Previous Target') }}</label>
                        <input id="previous_target" type="text"
                            class="form-control @error('previous_target') is-invalid @enderror" name="previous_target"
                            value="{{ old('previous_target') }}" autocomplete="previous_target">
                        @error('previous_target')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> --}}
            </div>
            <div class="card-footer text-center">
                <button type="submit" id="form_submit" class="btn btn-outline-success">Create
                    KPI</button>
            </div>
            </form>
        </div>

    </div>
</div>
<div class="card-footer"></div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    $(document).ready(function(){
        // var declaration
        // var weight = $('#weight');
        // var int_kpi_type = $('#kpi_type :selected').val();
        //     fillWeight(int_kpi_type);

        // // on select kpi_type toggle the weight
        // $('#kpi_type').on('change', function(){
        //     // if the value is not tasked populate and disable the weight
        // var kpi_type = $(this).val();
        //     fillWeight(kpi_type);
        // });

        // function fillWeight(kpi_type_val) {
        //     if(kpi_type_val == 'NotTasked'){
        //         weight.val(100);
        //         weight.prop("readonly", true);
        //     }else{
        //         weight.val('');
        //         weight.prop("readonly", false);
        //     }
        // }
$.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

    $('#structure').on('change', function() {
        // clear structure options
        $("#structure_id").children('option:not(:first)').remove();

        var structure = $(this).val();
        // console.log(structure);
        var new_label = structure.substring(0, structure.length-1);
        // console.log(new_label);
            $('#structure_label').text('Select '+new_label+':');

            // add loading
            $("#structure_id").LoadingOverlay("show", {
                    background : "rgba(165, 190, 100, 0.5)"
            });

            // timeout for loading
            setTimeout(function(){
                $("#structure_id").LoadingOverlay("hide", true);
            }, 1000);

        $.ajax({
            url: '/get/kpi/structure/'+structure,
            type: 'GET',
            dataType: 'json',
            success: function(response){
                // console.log(response.length)
                if (response.length == 0) {
                    // add invalid class to the group select
                    $("#structure_id").addClass('is-invalid')
                    // add no data message to the group select
                    $("#structure_id").append('<option selected disabled>No Data !!</option>');
                } else {
                    // remove the invalid class from the group select
                    $("#structure_id").removeClass('is-invalid');

                    $.each(response, function(index, value){
                        // console.log(value)
                        $("#structure_id").append('<option value='+value.id+' @if(old("structure_id") == '+value.id+' ) selected="selected" @endif>'+value.name+'</option>')
                    })
                }
            },
            error: function(error){
                console.log(error)
            }
        })

    });
    // $("#structure_id").on('change', function(){
    //         alert($(this).find(':selected').val())
    //     })
});
</script>
@endsection
