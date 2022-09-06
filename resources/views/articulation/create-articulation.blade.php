@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
    <div class="row content">
        <div class="col s12">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    {{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="active"><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li class="active">{{__('New Articulation')}}</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    <form id="articulation-form" action="{{route('articulations.store', $articulationStage->id)}}" method="POST">
                        @csrf
                        <div>
                            @include('articulation.form.step-articulation-type')
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
