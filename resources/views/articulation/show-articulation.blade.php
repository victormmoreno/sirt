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
                    <li ><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li ><a href="{{route('articulation-stage.show',  $articulation->accompaniment)}}">{{ $articulation->accompaniment->present()->accompanimentCode() }}</a></li>
                    <li class="active">{{ __('Articulations') }}</li>
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
                                        <li class="text-mailbox ">La articulación se encuentra actualmente en la fase de inicio</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha Inicio: {{$articulation->present()->articulationStartDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <div class="left">
                                                <span class="mailbox-title">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}
                                                @can('update', $articulation)
                                                    <a href="{{route('accompaniments.edit', $articulation)}}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar {{__('articulation-stage')}}"><i class="tiny material-icons">edit</i></a></span>
                                                @endcan
                                                <span class="mailbox-title">{{__('Node')}} {{$articulation->accompaniment->present()->accompanimentNode()}}</span>
                                                <span class="mailbox-author">{{$articulation->present()->articulationBy()}} (Articulador)
                                                    @can('update', $articulation)
                                                        {{-- <a href="{{ route('accompaniments.changeinterlocutor', $articulation) }}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a> --}}
                                                    @endcan
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12">
                                                {{-- @include('articulacionespbt.history-change') --}}
                                            </div>
                                            <div class="col s12">
                                                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                                                    <li class="tab col s3"><a href="#startphase" class="active">Inicio</a></li>
                                                    <li class="tab col s3"><a class="" href="#faseejecucion">Ejecución</a></li>
                                                    <li class="tab col s3"><a href="#fasecierre" class="">Cierre</a></li>
                                                </ul>
                                            </div>
                                            <div id="startphase" class="col s12" style="display: block;">
                                                @include('articulation.detail.start-phase-detail')
                                            </div>
                                            {{-- <div id="faseejecucion" class="col s12" style="display: none;">
                                                @include('articulacionespbt.detail.detail-fase-ejecucion')
                                            </div>
                                            <div id="fasecierre" class="col s12" style="display: none;">
                                                @include('articulacionespbt.detail.detail-fase-cierre')
                                            </div> --}}
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

