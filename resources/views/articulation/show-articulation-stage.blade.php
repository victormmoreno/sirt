@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align ">
                <h5 class="left-align primary-text">
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
                                    @include('articulation.options.articulation-stages-options-header')
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="col s12">
                                            @include('articulation.articulation-stage-history-change')
                                        </div>
                                        <div class="row">
                                            @include('articulation.options.articulation-stages-options-menu-left')

                                            <div class="@canany(['showButtonAprobacion', 'requestApproval', 'changeTalent', 'update', 'downloadCertificateEnd', 'downloadCertificateStart', 'uploadEvidences', 'delete'], $articulationStage) col s12 m8 l9 @elsecanany(['create'], App\Models\Articulation::class) @if($articulationStage->status == \App\Models\ArticulationStage::STATUS_OPEN) col s12 m8 l9 @else col s12 m12 l12  @endif  @else col s12 m12 l12 @endcanany ">
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{__('Code ArticulationStage')}}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->present()->articulationStageCode()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{__('Name ArticulationStage')}}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->present()->articulationStageName()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Start Date') }}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->present()->articulationStageStartDate()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Status') }}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->present()->articulationStageStatus()}}
                                                                </p>
                                                            </li>
                                                            @if(isset($articulationStage->articulation_type))
                                                            <li class="collection-item">
                                                                <span class="title black-text">
                                                                    {{__('ArticulationStage Type')}}
                                                                </span>
                                                                <p>
                                                                    {{$articulationStage->articulation_type}}
                                                                </p>
                                                            </li>
                                                            @endif
                                                            @if(isset($articulationStage->codigo_proyecto))
                                                            <li class="collection-item">
                                                                <span class="title black-text">
                                                                    {{__('Project')}}
                                                                </span>
                                                                    <p>
                                                                        <a class="primary-text" target="_blank"  href="{{route('proyecto.detalle', [$articulationStage->proyecto_id])}}">{{ $articulationStage->codigo_proyecto . ' - '. $articulationStage->nombre_proyecto}}</a>
                                                                    </p>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Descrition') }}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->present()->articulationStageDescription()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Scope') }}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->present()->articulationStageScope()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Interlocutory talent') }}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->talent_interlocutor}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Created_by') }}
                                                            </span>
                                                                <p>
                                                                    {{$articulationStage->created_by}}
                                                                </p>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l12">
                                                <span class="mailbox-title primary-text text-center">Articulaciones</span>
                                            </div>
                                            <div class="col s12 m12 l12">
                                                <table id="articulation_data_table"
                                                        class="display responsive-table datatable-example dataTable"
                                                        style="width: 100%">
                                                    <thead class="bg-primary white-text">
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
                                                                <blockquote class="secondary-text">
                                                                    <a href="{{route('articulations.show', $articulation)}}"
                                                                        class="primary-text">{{$articulation->present()->articulationCode()}}
                                                                        - {{$articulation->present()->articulationName()}}</a>
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
                                                            <td><a class="btn bg-info white-text m-b-xs modal-trigger"
                                                                    href="{{route('articulations.show', $articulation)}}">
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

