@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="active"><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a>
                    </li>
                    <li ><a href="{{route('articulation-stage.show',  $articulationStage)}}">{{ $articulationStage->present()->articulationStageCode() }}</a></li>
                    <li class="active">{{__('Edit ArticulationStage')}}</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    <form method="POST" id="articulation-stage-form"
                        action="{{route('articulation-stage.update', $articulationStage)}}"
                        enctype="multipart/form-data">
                        @csrf
                        {!! method_field('PUT')!!}
                        <div>
                            @include('articulation.form.step-basic-information-articulation-stage')
                            @include('articulation.form.step-articulation-stage')
                            @include('articulation.form.step-terms')
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

