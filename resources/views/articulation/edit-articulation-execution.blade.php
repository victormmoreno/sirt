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
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <form action="{{route('articulation.update.execution', $articulation)}}" method="POST" onsubmit="return checkSubmit()">
                                @include('articulation.form.execution-form', ['btnText' => 'Modificar'])
                                <div class="row">
                                    @include('articulation.table-archive-phase', ['fase' => 'ejecucion'])
                                </div>
                                <center>
                                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Guardar</button>
                                    <a href="{{ route('articulations.show', $articulation->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('articulation.shared.project-modal')
    @include('articulation.shared.interlocutor-talents-modal')
</main>
@endsection
