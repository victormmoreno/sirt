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
                                            </div>
                                            <span
                                                class="flow-text orange-text">Articulaciones  {{ 'con '.$articulationStage->present()->articulationStageables()}}</span>
                                            <div class="row">
                                                @forelse($articulations as $articulation)
                                                    <div class="col s12 m12 l4">
                                                        <div class="card card-panel server-card">
                                                            <div class="card-content">
                                                                <div class="card-options">
                                                                    <ul>
                                                                        <li><a class="dropdown-button " href='#'
                                                                               data-activates="dropdown{{$articulation->id}}"><i
                                                                                    class="material-icons">more_vert</i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <ul id="dropdown{{$articulation->id}}"
                                                                    class="dropdown-content">
                                                                    <li>
                                                                        <a href="{{route('articulations.show', $articulation->id)}}">Ver
                                                                            más</a></li>
                                                                    <li>
                                                                        <a href="{{route('articulations.show', $articulation->id)}}">Editar</a>
                                                                    </li>
                                                                    <li><a href="#!" class="red-text">Elimnar</a></li>
                                                                </ul>
                                                                <span class="card-title">
                                                                <a href="{{route('articulations.show', $articulation)}}"
                                                                   class="orange-text">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}</a>
                                                            </span>
                                                                <div class="server-load row">
                                                                    <div class="server-stat col s4">
                                                                        <p class="">{{$articulation->users_count}}</p>
                                                                        <span>Talentos participantes</span>
                                                                    </div>
                                                                    <div class="server-stat col s4">
                                                                        <p>{{$articulation->present()->articulationPhase()}}</p>
                                                                        <span>{{__('Phase')}}</span>
                                                                    </div>
                                                                    <div class="server-stat col s4">
                                                                        <p>{{$articulation->progress}}%</p>
                                                                        <span>{{__('Progress')}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="stats-info">
                                                                    <ul>
                                                                        <li>{{__('Description')}}
                                                                            <div
                                                                                class="percent-info black-text right">{{Str::limit($articulation->present()->articulationDescription(),60)}} </div>
                                                                        </li>
                                                                        <li>{{__('Start Date')}}
                                                                            <div
                                                                                class="percent-info black-text right">{{$articulation->present()->articulationStartDate()}}</div>
                                                                        </li>
                                                                        <li>{{__('End Date')}}
                                                                            <div
                                                                                class="percent-info black-text right">{{$articulation->present()->articulationEndDate()}}</div>
                                                                        </li>
                                                                        <li>{{__('End Date')}}
                                                                            <div
                                                                                class="percent-info black-text right">{{$articulation->present()->articulationExpectedEndDate()}}</div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="progress stats-card-progress ">
                                                                <div
                                                                    class="determinate {{$articulation->progress >= 0 && $articulation->progress <=25 ? 'red' : ($articulation->progress > 25 && $articulation->progress <= 50 ? 'yellow' : ($articulation->progress > 50 && $articulation->progress <= 75 ? 'orange' : 'green' ))}}"
                                                                    style="width: {{$articulation->progress}}%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="center-align">
                                                        <p><i class=" large material-icons orange-text text-darken-2">portable_wifi_off</i>
                                                        </p>
                                                        <p><span
                                                                class=" flow-text">Aún no registras {{ __('Articulations') }}</span>
                                                        </p>
                                                        @can('update', $articulationStage)
                                                            <p>
                                                                <a href="{{route('articulations.create', $articulationStage->id )}}"
                                                                   class="waves-effect waves-orange btn orange m-t-xs">{{ __('New Articulation') }}</a>
                                                            </p>
                                                        @endcan
                                                    </div>
                                                @endforelse
                                            </div>
                                            <div class="center-align">
                                                {!! $articulations->render() !!}
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

