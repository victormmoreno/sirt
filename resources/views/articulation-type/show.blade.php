@extends('layouts.app')
@section('meta-title', 'Soporte')

@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a href="{{route('tipoarticulaciones.index')}}" class="footer-text left-align">
                            <i class="material-icons arrow-l left">arrow_back</i>
                        </a>
                        {{__('articulation-type')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('tipoarticulaciones.index')}}">{{__('articulation-type')}}</a></li>
                        <li class="active">{{$typeArticulation->present()->name()}}</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left">
                                                <div class="left">
                                                    <span class="mailbox-title primary-text">{{$typeArticulation->present()->name()}}</span>
                                                    <span class="mailbox-author secondary-text">{{$typeArticulation->present()->status()}}</span>
                                                </div>
                                            </div>
                                            <div class="right mailbox-buttons">
                                                <a href="{{ route('tipoarticulaciones.edit', $typeArticulation->id) }}" class="waves-effect bg-primary white-text btn-flat m-t-xs" >Cambiar información</a>
                                                @if($typeArticulation->articulationsubtypes->count() <= 0 )
                                                    <a href="javascript:void(0)" class="waves-effect bg-danger white-text btn-flat m-t-xs" onclick="typeArticulacion.destroyTypeArticulation('{{$typeArticulation->id}}')">Eliminar</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            <div class="card card-transparent ">
                                                <div class="card-content ">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->name()}}</span>
                                                    <span class="mailbox-author">Nombre</span>
                                                </div>
                                                <div class="card-content">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->description()}}</span>
                                                    <span class="mailbox-author">Descripción</span>
                                                </div>
                                                <div class="card-content mb-2">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->status()}}</span>
                                                    <span class="mailbox-author">Estado</span>
                                                </div>
                                                <div class="card-content mt-2">
                                                    <span class="mailbox-title">{{optional($typeArticulation->created_at)->isoFormat('lll')}}</span>
                                                    <span class="mailbox-author">Fecha registro</span>
                                                </div>
                                            </div>
                                            <div class="divider mailbox-divider"></div>
                                            <div class="row details-list" style="display: block;">
                                                <div class="right right-alignl">
                                                    <span>Fecha actualización: </span>
                                                    <span>{{optional($typeArticulation->updated_at)->isoFormat('lll')}} ({{optional($typeArticulation->updated_at)->diffForHumans()}})</span>
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
