@extends('layouts.app')
@section('meta-title', 'Tecnoparque nodo '. $nodo->entidad->present()->entidadName())

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s12 m8 l7">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}
                        </h5>
                    </div>
                    <div class="col s12 m4 l5 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('nodo.index')}}">Nodos</a></li>
                            <li class="active">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m12 l12">
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    <div class="left">
                                                        <span class="mailbox-title  orange-text text-darken-3">
                                                        Tecnoparque nodo {{$nodo->entidad->present()->entidadName()}} -
                                                        {{$nodo->entidad->present()->entidadLugar()}}
                                                    </span>
                                                    <span class="mailbox-author">
                                                        <b class="black-text text-darken-3">Dirección: </b> {{$nodo->direccion}}<br/>
                                                        <b class="black-text text-darken-3">Correo Electrónco: </b>
                                                        {{$nodo->entidad->present()->entidadEmail()}}<br/>
                                                        <b class="black-text text-darken-3">Teléfono: </b>
                                                        {{isset($nodo->telefono) ? $nodo->telefono : 'No registra'}}<br/>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="right mailbox-buttons hide-on-med-and-down">
                                                    <span class="mailbox-title">
                                                        <p class="center">Información Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}</p><br/>
                                                        <p class="center">{{isset($nodo->centro->entidad->nombre) ? $nodo->centro->entidad->nombre : ''}} - {{isset($nodo->centro->entidad->ciudad->nombre) ? $nodo->centro->entidad->ciudad->nombre : ''}} ({{ isset($nodo->centro->entidad->ciudad->departamento->nombre) ? $nodo->centro->entidad->ciudad->departamento->nombre : ''}})</p>
                                                    </span>
                                                </div>
                                            </div>
                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsAdministrador())
                                            <div class="right hide-on-med-and-down">
                                                <small class="green-text text-darken-2">
                                                    <a class="waves-effect waves-green btn-flat" href="{{route('excel.exportexcelfornodo',$nodo->entidad->slug)}}">
                                                        <i class="fas fa-file-excel fa-lg"></i>Exportar a Excel
                                                    </a>
                                                </small>
                                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                <small class="green-text text-darken-2">
                                                <a href="{{route('nodo.edit', $nodo->entidad->slug)}}" class="waves-effect waves-blue btn-flat">
                                                        Cambiar Infomación
                                                    </a>
                                                </small>
                                                @endif
                                            </div>
                                            @endif
                                            <div class="divider mailbox-divider"></div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m4 l3 ">
                                                        <ul class="collection with-header">
                                                            <li class="collection-header center ">
                                                                <h5 class="orange-text text-darken-1"><b>Lineas Tecnológicas ({{$nodo->lineas->count()}})</b></h5>
                                                            </li>
                                                            @forelse($lineatecnologicas as $value)
                                                                <li class="collection-item">
                                                                    <span class="title">
                                                                        {{$value->abreviatura}} - {{$value->nombre}}
                                                                    </span>
                                                                </li>
                                                            @empty
                                                            <div class="center">
                                                                <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">No tienes lineas tecnológicas registradas aún.</p>
                                                            </div>
                                                            @endforelse
                                                        </ul>
                                                        @if(isset($lineatecnologicas))
                                                            <div class="center">
                                                                {{ $lineatecnologicas->links() }}
                                                            </div>
                                                        @endif
                                                        <ul class="collection with-header">
                                                            <li class="collection-header center">
                                                                <h5 class=" orange-text text-darken-3"><b>Equipos ({{$nodo->equipos->count()}})</b></h5>
                                                            </li>
                                                            @forelse($equipos as $value)
                                                                <li class="collection-item">
                                                                    <span class="title">
                                                                        {{$value->nombre}}
                                                                    </span>
                                                                    <p class="p-v-xs">
                                                                        {{$value->lineatecnologica->abreviatura}} - {{$value->lineatecnologica->nombre}}
                                                                    </p>
                                                                </li>
                                                            @empty
                                                            <div class="center">
                                                                <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">No tienes equipos registrados aún.</p>
                                                            </div>
                                                            @endforelse
                                                        </ul>
                                                        @if(isset($equipos))
                                                            <div class="center">
                                                                {{ $equipos->links() }}
                                                            </div>
                                                        @endif

                                                        <div class="divider mailbox-divider"></div>
                                                    </div>
                                                    <div class="col s12 m8 l9">
                                                        <div class="center">
                                                            <span class="mailbox-title orange-text text-darken-3">

                                                                <i class="material-icons    fas fa-user-friends orange-text darken-3"></i>
                                                                Equipo Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}
                                                            </span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        <div class="row">
                                                            <div class="col s12 m12 l6">
                                                                <div class="center">
                                                                    <span class="zurich-bt-fonts orange-text text-darken-2"><b>{{App\User::IsDinamizador()}} </b></span>
                                                                </div>
                                                                <ul class="collection">
                                                                    @forelse($nodo->dinamizador as $dinamizador)
                                                                        @if(isset($dinamizador->user))
                                                                        <li class="collection-item">
                                                                            <span class="title">
                                                                                {{$dinamizador->user->present()->userFullName()}}
                                                                            </span>
                                                                            <p>
                                                                                <b class="black-text text-darken-3">Número documento:</b> {{$dinamizador->user->present()->userDocumento()}}<br/>
                                                                                <b class="black-text text-darken-3">Correo Electrónco:</b> {{$dinamizador->user->present()->userEmail()}}<br/>
                                                                                <b class="black-text text-darken-3">Teléfono:</b> {{$dinamizador->user->present()->userTelefono()}}<br/>
                                                                                <b class="black-text text-darken-3">Celular: </b>
                                                                                {{$dinamizador->user->present()->userCelular()}}<br/>
                                                                            </p>
                                                                        </li>
                                                                        @endif
                                                                    @empty
                                                                        <div class="center">
                                                                            <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}} no cuenta con un {{App\User::IsDinamizador()}} aún</p>
                                                                        </div>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                            <div class="col s12 m12 l6">
                                                                <div class="center">
                                                                    <span class="zurich-bt-fonts orange-text text-darken-2"><b>{{App\User::IsInfocenter()}}</b></span>
                                                                </div>
                                                                <ul class="collection">
                                                                    @forelse($nodo->infocenter as $infocenter)
                                                                    @if(isset($infocenter->user))
                                                                    <li class="collection-item">
                                                                        <span class="title">
                                                                            {{$infocenter->user->present()->userFullName()}}
                                                                        </span>
                                                                        <p>
                                                                            <b class="black-text text-darken-3">Número documento:</b> {{$infocenter->user->present()->userDocumento()}}<br/>
                                                                            <b class="black-text text-darken-3">Correo Electrónco:</b> {{$infocenter->user->present()->userEmail()}}<br/>
                                                                            <b class="black-text text-darken-3">Teléfono:</b> {{$infocenter->user->present()->userTelefono()}}<br/>
                                                                            <b class="black-text text-darken-3">Celular: </b>
                                                                            {{$infocenter->user->present()->userCelular()}}<br/>
                                                                        </p>
                                                                    </li>
                                                                    @endif
                                                                    @empty
                                                                        <div class="center">
                                                                            <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}} no cuenta con un {{App\User::IsInfocenter()}} aún</p>
                                                                        </div>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="center">
                                                                <span class="zurich-bt-fonts orange-text text-darken-2"><b>Expertos y Articulador</b></span>
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                            </div>
                                                            @forelse($nodo->gestores as $gestor)
                                                                <div class="col s12 m12 l6">

                                                                    @if(isset($gestor->user))
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                            <span class="title">
                                                                                {{$gestor->user->present()->userFullName()}}
                                                                            </span>
                                                                            <p>
                                                                                <b class="black-text text-darken-3">Número documento:</b> {{$gestor->user->present()->userDocumento()}}<br/>
                                                                                <b class="black-text text-darken-3">Correo Electrónco:</b> {{$gestor->user->present()->userEmail()}}<br/>
                                                                                <b class="black-text text-darken-3">Teléfono:</b> {{$gestor->user->present()->userTelefono()}}<br/>
                                                                                <b class="black-text text-darken-3">Celular: </b>
                                                                                {{$gestor->user->present()->userCelular()}}<br/>
                                                                                <b class="black-text text-darken-3">Roles: </b>
                                                                                {{$gestor->user->present()->userRolesNames()}}<br/>
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                    @endif

                                                                </div>
                                                            @empty
                                                                <div class="col s12 m12 l6">
                                                                    <ul class="collection">
                                                                        <div class="center">
                                                                            <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}} no cuenta con un {{App\User::IsGestor()}} aún</p>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                        <div class="row">

                                                            <div class="col s12 m12 l12">
                                                                <div class="center">
                                                                    <span class="zurich-bt-fonts orange-text text-darken-2"><b>Ingreso</b></span>
                                                                </div>
                                                                <div class="divider mailbox-divider">
                                                                </div>
                                                                @forelse($nodo->ingresos as $ingreso)
                                                                    <div class="col s12 m12 l6">
                                                                        @if(isset($ingreso->user))
                                                                        <ul class="collection">
                                                                            <li class="collection-item">
                                                                                <span class="title">
                                                                                    {{$ingreso->user->present()->userFullName()}}
                                                                                </span>
                                                                                <p>
                                                                                    <b class="black-text text-darken-3">Número documento:</b> {{$ingreso->user->present()->userDocumento()}}<br/>
                                                                                    <b class="black-text text-darken-3">Correo Electrónco:</b> {{$ingreso->user->present()->userEmail()}}<br/>
                                                                                    <b class="black-text text-darken-3">Teléfono:</b> {{$ingreso->user->present()->userTelefono()}}<br/>
                                                                                    <b class="black-text text-darken-3">Celular: </b>
                                                                                    {{$ingreso->user->present()->userCelular()}}<br/>
                                                                                </p>
                                                                            </li>
                                                                        </ul>
                                                                        @endif
                                                                    </div>
                                                                @empty
                                                                    <div class="col s12 m12 l6">
                                                                        <ul class="collection">
                                                                            <div class="center">
                                                                            <i class="large material-icons center">
                                                                                    block
                                                                                </i>
                                                                                <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}} no cuenta con un usuario {{App\User::IsIngreso()}} aún</p>
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                @endforelse
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
        </div>
    </div>
</main>
@endsection
