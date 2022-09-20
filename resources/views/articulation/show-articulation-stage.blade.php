@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
    <main class="mn-inner">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="left left-align">
                    <h5 class="left-align orange-text text-darken-3">
                        <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                        <li class="active">{{ __('Details') }}</li>
                    </ol>
                </div>
            </div>

            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12 no-p-h">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-options">
                                        <ul>
                                            <li class="text-mailbox ">La {{__('articulation-stage')}} se encuentra
                                                actualmente {{$articulationStage->present()->articulationStageStatus()}}</li>
                                            <div class="right">
                                                <li class="text-mailbox">Fecha
                                                    registro: {{$articulationStage->present()->articulationStageCreatedDate()}}</li>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="mailbox-view no-s">

                                        @include('articulation.options.options-articulations')

                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <div class="row">
                                                        <div class="col s12 m6 l6">
                                                            <ul class="collection">
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{__('Code ArticulationStage')}}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageCode()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{__('Name ArticulationStage')}}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageName()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{ __('Start Date') }}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageStartDate()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{ __('Status') }}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageStatus()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{__('ArticulationStage Type')}}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageableType()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{__('Project')}}
                                                                </span>
                                                                    <p>
                                                                        {!! $articulationStage->present()->articulationStageableLink() !!}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col s12 m6 l6">
                                                            <ul class="collection">
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{ __('Descrition') }}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageDescription()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{ __('Scope') }}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageScope()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{ __('Interlocutory talent') }}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageInterlocutorTalent()}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item">
                                                                <span class="title black-text text-darken-3">
                                                                    {{ __('Created_by') }}
                                                                </span>
                                                                    <p>
                                                                        {{$articulationStage->present()->articulationStageBy()}}
                                                                    </p>
                                                                </li>
                                                                {!! $articulationStage->present()->articulationStageNameConfidentialityFormat() !!}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s12 m12 l12">
                                                    <table id="articulation_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Nombre articulación</th>
                                                            <th>Descripción</th>
                                                            <th>Fecha inicio</th>
                                                            <th>Fecha de cierre</th>
                                                            <th>Talentos participantes</th>
                                                            <th>Progreso</th>
                                                            <th>{{__('Phase')}}</th>
                                                            <th>{{__('Process')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($articulationStage->articulations as $articulation)
                                                                <tr>
                                                                    <td>
                                                                        <blockquote class="blue-text text-darken-2">
                                                                        <a href="{{route('articulations.show', $articulation)}}"
                                                                           class="orange-text">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}</a>
                                                                        </blockquote>
                                                                    </td>
                                                                    <td>{{Str::limit($articulation->present()->articulationDescription(),60)}}</td>
                                                                    <th>{{$articulation->present()->articulationStartDate()}}</th>
                                                                    <td>{{$articulation->present()->articulationEndDate()}}</td>
                                                                    <td>{{$articulation->users_count}}</td>
                                                                    <td>
                                                                        {{$articulation->progress}}% <br>
                                                                        <div class="progress stats-card-progress ">
                                                                            <div
                                                                                class="determinate {{$articulation->progress >= 0 && $articulation->progress <=25 ? 'red' : ($articulation->progress > 25 && $articulation->progress <= 50 ? 'yellow' : ($articulation->progress > 50 && $articulation->progress <= 75 ? 'orange' : 'green' ))}}"
                                                                                style="width: {{$articulation->progress}}%"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$articulation->present()->articulationPhase()}}</td>
                                                                    <td><a class="btn m-b-xs modal-trigger" href="{{route('articulation-stage.show', $articulation->id)}}">
                                                                        <i class="material-icons">search</i>
                                                                    </a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

