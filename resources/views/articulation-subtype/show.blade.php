@extends('layouts.app')
@section('meta-title', 'Soporte')

@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="left left-align">
                    <h5 class="left-align orange-text text-darken-3">
                        <i class="material-icons left">autorenew</i>{{__('articulation-subtype')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li class="active">{{__('articulation-subtype')}}</li>
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
                                                    <span class="mailbox-title">{{$articulationSubtype->present()->name()}}</span>
                                                    <span class="mailbox-author">{{$articulationSubtype->present()->status()}}</span>
                                                </div>
                                            </div>
                                            <div class="right mailbox-buttons">
                                                <a href="{{ route('tiposubarticulaciones.edit', $articulationSubtype) }}" class="waves-effect waves-orange btn-flat m-t-xs" >Cambiar información</a>
                                                @if(isset($articulationSubtype->articulations) && $articulationSubtype->articulations->IsEmpty())
                                                    <a href="javascript:void(0)" class="waves-effect waves-red btn-flat m-t-xs" onclick="articulationSubtype.destroyArticulationSubtype('{{$articulationSubtype->id}}')">Eliminar</a>
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
                                                    @foreach($articulationSubtype->entity as $value)
                                                        <div class="chip m-t-sm">{{$value}}</div>
                                                    @endforeach
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
