@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l5">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    {{__('Accompaniments')}}
                </h5>
            </div>
            <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li ><a href="{{route('articulation.accompaniments')}}">{{__('Accompaniments')}}</a></li>
                    <li class="active">detalle</li>
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
                                        <li class="text-mailbox ">El acompañamiento se encuentra actualmente abierto</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha registro: 24 mayo 2022</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <div class="left">
                                                <span class="mailbox-title">A2022-464356-4645 Acompañamiento Ecommerce lorem 125 <a href="" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar acompañamiento"><i class="tiny material-icons">edit</i></a></span>
                                                <span class="mailbox-title">Nodo Bogotá</span>
                                                <span class="mailbox-author">Ana Milena Zapata (Talento interlocutor) <a href="" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar talento interlocutor"><i class="tiny material-icons">edit</i></a></span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons">

                                            <a href="" class="waves-effect waves-orange btn orange m-t-xs">Nueva Articulación</a>
                                            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsDinamizador()) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsSuspendido()))
                                                <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar articulador</a>
                                            @endif
                                            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
                                                <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Descargar</a>
                                                <a href="" class="waves-effect waves-orange btn-flat m-t-xs">Cerrar</a>
                                            @endif
                                            <a class="waves-effect waves-red btn-flat m-t-xs">Eliminar</a>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12">
                                            </div>
                                            <div class="row">
                                                @forelse($articulations as $articulation)

                                                    <div class="col s12 m12 l4">
                                                        <div class="card card-panel server-card">

                                                            <div class="card-content">
                                                                <div class="card-options">
                                                                    <ul>
                                                                        <li><a class="dropdown-button "  href='#' data-activates="dropdown{{$articulation->id}}"><i class="material-icons">more_vert</i></a></li>
                                                                    </ul>
                                                                </div>
                                                                <ul id="dropdown{{$articulation->id}}" class="dropdown-content">
                                                                    <li><a href="#!">Editar</a></li>
                                                                    {{-- <li class="divider"></li> --}}
                                                                    <li><a href="#!" class="red-text">Elimnar</a></li>
                                                                </ul>
                                                                <span class="card-title">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}</span>
                                                                <div class="server-load row">
                                                                    <div class="server-stat col s4">
                                                                        <p class="">{{$articulation->users_count}}</p>
                                                                        <span>Talentos participantes</span>
                                                                    </div>
                                                                    <div class="server-stat col s4">
                                                                        <p>Inicio</p>
                                                                        <span>Fase</span>
                                                                    </div>
                                                                    <div class="server-stat col s4">
                                                                        <p>57.4%</p>
                                                                        <span>Progreso</span>
                                                                    </div>
                                                                </div>
                                                                <div class="stats-info">
                                                                    <ul>
                                                                        <li>Google Chrome<div class="percent-info green-text right">32% <i class="material-icons">trending_up</i></div></li>
                                                                        <li>Safari<div class="percent-info red-text right">20% <i class="material-icons">trending_down</i></div></li>
                                                                        <li>Mozilla Firefox<div class="percent-info green-text right">18% <i class="material-icons">trending_up</i></div></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="progress stats-card-progress">
                                                                <div class="determinate" style="width: 70%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty

                                                @endforelse

                                            </div>
                                            {{$articulations->links()}}
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

