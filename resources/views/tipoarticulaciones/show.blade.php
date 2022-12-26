@extends('layouts.app')
@section('meta-title', 'Soporte')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="row no-m-t no-m-b">
        <div class="container ">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent  ">
                        <div class="row mt-2">
                            <div class="left left-align">
                                <a class="footer-text mt-2" href="{{route('tipoarticulaciones.index')}}">
                                    <i class="material-icons arrow-l mt-2">
                                        arrow_back
                                    </i>
                                </a>
                                Configuración
                            </div>
                            <div class="right right-align">
                                <ol class="breadcrumbs">
                                    <li><a href="{{route('home')}}">Inicio</a></li>
                                    <li ><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                                    <li ><a href="{{route('tipoarticulaciones.index')}}">Tipos Articulaciones</a></li>
                                    <li class="active">Detalle</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m8 l8">
                                <h4>{{$typeArticulation->present()->nombre()}}</h4>
                            </div>
                            <div class="col s12 m4 l4 right-align hide-on-small-only">
                                <i class="large material-icons">settings</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12 no-p-h">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">

                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left">

                                                <div class="left">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->nombre()}}</span>
                                                    <span class="mailbox-author">{{$typeArticulation->present()->estado()}}</span>

                                                </div>
                                            </div>
                                            <div class="right mailbox-buttons">
                                                <a href="{{ route('tipoarticulaciones.edit', $typeArticulation->id) }}" class="waves-effect waves-orange btn-flat m-t-xs" >Cambiar información</a>
                                                @if(!$typeArticulation->articulacionespbt->count() > 0 )
                                                <a href="javascript:void(0)" class="waves-effect waves-red btn-flat m-t-xs" onclick="typeArticulacion.destroyTypeArticulation('{{$typeArticulation->id}}')">Eliminar</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">

                                            <div class="card card-transparent ">
                                                <div class="card-content ">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->nombre()}}</span>
                                                    <span class="mailbox-author">Nombre</span>
                                                </div>
                                                <div class="card-content">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->descripcion()}}</span>
                                                    <span class="mailbox-author">Descripción</span>
                                                </div>
                                                <div class="card-content mb-2">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->entidad()}}</span>
                                                    <span class="mailbox-author">Entidad (se muestra por defecto)</span>
                                                </div>
                                                <div class="card-content mb-2">
                                                    <span class="mailbox-title">{{$typeArticulation->present()->estado()}}</span>
                                                    <span class="mailbox-author">Estado</span>
                                                </div>
                                                <div class="card-content mt-2">
                                                    <span class="mailbox-title">{{optional($typeArticulation->created_at)->isoFormat('lll')}}</span>
                                                    <span class="mailbox-author">Fecha registro</span>
                                                </div>
                                                <div class="card-content mt-2">
                                                    {{-- <span class="mailbox-author">Nodos</span> --}}
                                                    <span class="card-title m-t-sm">Nodos</span>
                                                    @foreach($typeArticulation->nodos as $nodo)
                                                    <div class="chip m-t-sm">{{$nodo->entidad->nombre}}</div>
                                                    @endforeach
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
    </div>
</main>
@endsection
