@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
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
                    {{__('Accompaniments')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="active"><a href="{{route('articulation.accompaniments')}}">{{__('Accompaniments')}}</a></li>
                    <li class="active">{{__('New Accompaniment')}}</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    <form id="accompaniment-form" action="{{route('articulation.accompaniments.store')}}" method="POST">
                        @csrf
                        <div>
                            @include('articulation.form.step-accompaniment-type')
                            @include('articulation.form.step-basic-information-accompaniment')
                            @include('articulation.form.step-accompaniment')
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

