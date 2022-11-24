@extends('layouts.app')
@section('meta-title', __('articulation-subtype'))

@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a href="{{route('tiposubarticulaciones.index')}}" class="footer-text left-align">
                            <i class="material-icons arrow-l left">arrow_back</i>
                        </a>
                        {{__('articulation-subtype')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('tiposubarticulaciones.index')}}">{{__('articulation-subtype')}}</a></li>
                        <li class="active">{{$articulationSubtype->present()->name()}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content">
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
                                                    <span class="mailbox-title primary-text">{{$articulationSubtype->present()->name()}}</span>
                                                    <span class="mailbox-author secondary-text">{{$articulationSubtype->present()->status()}}</span>
                                                </div>
                                            </div>
                                            <div class="right mailbox-buttons">
                                                <a href="{{ route('tiposubarticulaciones.edit', $articulationSubtype) }}" class="waves-effect bg-primary white-text btn-flat m-t-xs" >Cambiar información</a>
                                                @if(isset($articulationSubtype->articulations) && $articulationSubtype->articulations->IsEmpty())
                                                    <a href="javascript:void(0)" class="waves-effect bg-danger white-text btn-flat m-t-xs" onclick="articulationSubtype.destroyArticulationSubtype('{{$articulationSubtype->id}}')">Eliminar</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            <div class="card card-transparent ">
                                                <div class="card-content ">
                                                    <span class="mailbox-title">{{$articulationSubtype->present()->name()}}</span>
                                                    <span class="mailbox-author">Nombre</span>
                                                </div>
                                                <div class="card-content">
                                                    <span class="mailbox-title">{{$articulationSubtype->present()->description()}}</span>
                                                    <span class="mailbox-author">Descripción</span>
                                                </div>
                                                <div class="card-content mb-2">
                                                    <span class="mailbox-title">{{$articulationSubtype->present()->status()}}</span>
                                                    <span class="mailbox-author">Estado</span>
                                                </div>
                                                <div class="card-content mt-2">
                                                    <span class="mailbox-title">{{optional($articulationSubtype->created_at)->isoFormat('lll')}}</span>
                                                    <span class="mailbox-author">Fecha registro</span>
                                                </div>
                                                <div class="card-content mt-2">
                                                    <span class="card-title m-t-sm">Entidades promotoras</span>
                                                    @if(is_array($articulationSubtype->entity))
                                                        @foreach( $articulationSubtype->entity as $value)
                                                            <div class="chip m-t-sm">{{$value}}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="card-content mt-2">
                                                    <span class="card-title m-t-sm">Nodos</span>
                                                    @foreach($articulationSubtype->nodos as $nodo)
                                                        <div class="chip m-t-sm">{{$nodo->entidad->nombre}}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="divider mailbox-divider"></div>
                                            <div class="row details-list" style="display: block;">
                                                <div class="right right-alignl">
                                                    <span>Fecha actualización: </span>
                                                    <span>{{optional($articulationSubtype->updated_at)->isoFormat('lll')}} ({{optional($articulationSubtype->updated_at)->diffForHumans()}})</span>
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
