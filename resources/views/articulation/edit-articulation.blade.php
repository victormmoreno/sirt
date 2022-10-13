@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
    <div class="row content">
        <div class="row no-m-t no-m-b">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li ><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li ><a href="{{route('articulation-stage.show',  $articulation->articulationstage)}}">{{ $articulation->articulationstage->present()->articulationStageCode() }}</a></li>
                    <li class="active">{{ __('Articulations') }}</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    <form id="articulation-form" action="{{route('articulation.update', $articulation)}}" method="POST">
                        {!! method_field('PUT')!!}
                        @csrf
                        <div>
                            @include('articulation.form.step-articulation')
                            @include('articulation.form.step-articulation-contact')
                            @include('articulation.form.step-articulation-participants')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('articulation.shared.project-modal')
    @include('articulation.shared.interlocutor-talents-modal')
</main>
@endsection
@push('script')
    <script>
        $( document ).ready(function() {
            getSubarticulation();
        });
        function getSubarticulation(){
            let articulaciontype = $('#articulation_type').val();
            if(articulaciontype !=null || articulaciontype != ''){
                $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: `/tipoarticulaciones/${articulaciontype}/tiposubarticulaciones`
                }).done(function (response) {
                    $("#articulation_subtype").empty();
                    $('#articulation_subtype').append('<option value="">Seleccione el tipo de subarticulación</option>');
                    $.each(response.data, function(i, element) {
                        $('#articulation_subtype').append(`<option  value="${element.id}">${element.name}</option>`);
                        @if(isset($articulation->articulationsubtype))
                        $('#articulation_subtype').val('{{$articulation->articulationsubtype->id}}');
                        @endif
                    });
                    $('#articulation_subtype').material_select();
                });
            }
        }
    </script>
@endpush
