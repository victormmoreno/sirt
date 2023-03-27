@extends('layouts.app')
@section('meta-title', 'Tecnoparque nodo '. $nodo->entidad->present()->entidadName())
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">domain</i>Tecnoparque
                        Nodo {{$nodo->entidad->present()->entidadName()}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('nodo.index')}}">Nodos</a></li>
                        <li class="active">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left">
                                                <div class="left">
                                                <span class="mailbox-title primary-text">
                                                Tecnoparque nodo {{$nodo->entidad->present()->entidadName()}} -
                                                {{$nodo->entidad->present()->entidadLugar()}}
                                            </span>
                                                        <span class="mailbox-author">
                                                            <b class="secondary-text">Dirección: </b> {{$nodo->direccion}}<br/>
                                                            <b class="secondary-text">Correo Electrónco: </b>
                                                            {{$nodo->entidad->present()->entidadEmail()}}<br/>
                                                            <b class="secondary-text">Teléfono: </b>
                                                            {{isset($nodo->telefono) ? $nodo->telefono : 'No registra'}}<br/>
                                                            <b class="secondary-text">Extensión: </b>
                                                            {{isset($nodo->extension) ? $nodo->extension : 'No registra'}}<br/>
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
                                        <div class="right hide-on-med-and-down">
                                            @can('uploadFiles', $nodo)
                                            <small class="info-text">
                                                <a href="{{route('nodo.upload-files', $nodo->entidad->slug)}}"
                                                   class="waves-effect waves-grey info-text btn-flat">
                                                   <i class="fas fa-upload fa-lg"></i> Subir documentos ({{ $nodo->model()->whereYear('created_at',$year)->count() }})
                                                </a>
                                            </small>
                                            @endcan
                                            @can('downloadOne', $nodo)
                                                <small class="success-text">
                                                    <a class="waves-effect waves-grey  success-text btn-flat"
                                                       href="{{route('excel.exportexcelfornodo',$nodo->entidad->slug)}}">
                                                        <i class="fas fa-file-excel fa-lg"></i> Exportar a Excel
                                                    </a>
                                                </small>
                                            @endcan
                                            @can('edit', $nodo)
                                                <small class="info-text">
                                                    <a href="{{route('nodo.edit', $nodo->entidad->slug)}}"
                                                       class="waves-effect waves-warning btn-flat">
                                                       <i class="fas fa-edit fa-lg"></i> Cambiar Infomación
                                                    </a>
                                                </small>
                                            @endcan
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            <div class="row">
                                                <div class="col s12 m4 l3 ">
                                                    <ul class="collection with-header">
                                                        <li class="collection-header center ">
                                                            <h5 class="primary-text"><b>Lineas Tecnológicas ({{$nodo->lineas->count()}})</b></h5>
                                                        </li>
                                                        @forelse($lineatecnologicas as $value)
                                                            <li class="collection-item">
                                                                <span class="title">
                                                                    {{$value->abreviatura}} - {{$value->nombre}}
                                                                </span>
                                                                <a href="{{route("lineas.show", $value->slug)}}" target="_blank" class="info tooltipped" data-position="bottom" data-tooltip="Ver más información">
                                                                    <i class="material-icons right">info</i>
                                                                </a>

                                                            </li>
                                                        @empty
                                                            <div class="center">
                                                                <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">No tienes lineas
                                                                    tecnológicas registradas aún.</p>
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
                                                            <h5 class="primary-text"><b>Equipos
                                                                    ({{$nodo->equipos->count()}})</b></h5>
                                                        </li>
                                                        @forelse($equipos as $value)
                                                            <li class="collection-item">
                                                            <span class="title">
                                                                {{$value->nombre}}
                                                            </span>
                                                                <p class="p-v-xs">
                                                                    {{$value->lineatecnologica->abreviatura}}
                                                                    - {{$value->lineatecnologica->nombre}}
                                                                </p>
                                                            </li>
                                                        @empty
                                                            <div class="center">
                                                                <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">No tienes equipos
                                                                    registrados aún.</p>
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
                                                    <span class="mailbox-title primary-text">

                                                        <i class="material-icons fas fa-user-friends"></i>
                                                        Equipo humano Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}
                                                    </span>
                                                    </div>
                                                    <div class="divider mailbox-divider"></div>
                                                    <div class="row">
                                                        <div class="col s12 m12 l6">
                                                            <div class="center">
                                                                <span
                                                                    class="secondary-text"><b>{{App\User::IsDinamizador()}} </b></span>
                                                            </div>
                                                            <ul class="collection">
                                                                @forelse($nodo->dinamizador as $dinamizador)
                                                                    @if(isset($dinamizador->user) && $dinamizador->user->hasRole(App\User::IsDinamizador()) && $dinamizador->user->estado == App\User::IsActive() &&  $dinamizador->user->deleted_at == null)
                                                                        <li class="collection-item">
                                                                    <span class="title">
                                                                        {{$dinamizador->user->present()->userFullName()}}
                                                                    </span>
                                                                            <p>
                                                                                <b class="secondary-text">Número
                                                                                    documento:</b> {{$dinamizador->user->present()->userDocumento()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Correo
                                                                                    Electrónco:</b> {{$dinamizador->user->present()->userEmail()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Teléfono:</b> {{$dinamizador->user->present()->userTelefono()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Celular: </b>
                                                                                {{$dinamizador->user->present()->userCelular()}}
                                                                                <br/>
                                                                            </p>
                                                                            <a target="_blank" href="{{route("usuario.usuarios.show", $dinamizador->user->documento)}}" class="info">
                                                                                Ver mas información del usuario.
                                                                            </a>

                                                                        </li>
                                                                    @endif
                                                                @empty
                                                                    <div class="center">
                                                                        <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">Tecnoparque
                                                                            Nodo {{$nodo->entidad->present()->entidadName()}}
                                                                            no cuenta con
                                                                            un {{App\User::IsDinamizador()}}
                                                                            aún</p>
                                                                    </div>
                                                                @endforelse
                                                            </ul>
                                                        </div>
                                                        <div class="col s12 m12 l6">
                                                            <div class="center">
                                                                <span
                                                                    class="secondary-text"><b>{{App\User::IsInfocenter()}}</b>
                                                                </span>
                                                            </div>
                                                            <ul class="collection">
                                                                @forelse($nodo->infocenter as $infocenter)
                                                                    @if(isset($infocenter->user) && $infocenter->user->hasRole(App\User::IsInfocenter()) && $infocenter->user->estado == App\User::IsActive() &&  $infocenter->user->deleted_at == null)
                                                                        <li class="collection-item">
                                                                            <span class="title">
                                                                                {{$infocenter->user->present()->userFullName()}}
                                                                            </span>
                                                                            <p>
                                                                                <b class="secondary-text">Número
                                                                                    documento:</b> {{$infocenter->user->present()->userDocumento()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Correo
                                                                                    Electrónco:</b> {{$infocenter->user->present()->userEmail()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Teléfono:</b> {{$infocenter->user->present()->userTelefono()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Celular: </b>
                                                                                {{$infocenter->user->present()->userCelular()}}
                                                                                <br/>
                                                                            </p>
                                                                            <a target="_blank" href="{{route("usuario.usuarios.show", $infocenter->user->documento)}}" class="info">
                                                                                Ver mas información del usuario.
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @empty
                                                                    <div class="center">
                                                                        <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">Tecnoparque
                                                                            Nodo {{$nodo->entidad->present()->entidadName()}}
                                                                            no cuenta con
                                                                            un {{App\User::IsInfocenter()}}
                                                                            aún</p>
                                                                    </div>
                                                                @endforelse
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="center">
                                                            <span
                                                                class="secondary-text"><b>Expertos</b></span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        @forelse($nodo->gestores as $gestor)
                                                            @if(isset($gestor->user) && $gestor->user->hasRole(App\User::IsExperto()) && $gestor->user->estado == App\User::IsActive() &&  $gestor->user->deleted_at == null)
                                                                <div class="col s12 m12 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                    <span class="title">
                                                                        {{$gestor->user->present()->userFullName()}}
                                                                    </span>
                                                                            <p>
                                                                                <b class="secondary-text">Número
                                                                                    documento:</b> {{$gestor->user->present()->userDocumento()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Correo
                                                                                    Electrónco:</b> {{$gestor->user->present()->userEmail()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Teléfono:</b> {{$gestor->user->present()->userTelefono()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Celular: </b>
                                                                                {{$gestor->user->present()->userCelular()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Roles: </b>
                                                                                {{$gestor->user->present()->userRolesNames()}}
                                                                                <br/>
                                                                            </p>
                                                                            <a target="_blank" href="{{route("usuario.usuarios.show", $gestor->user->documento)}}" class="info">
                                                                                Ver mas información del usuario.
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <div class="col s12 m12 l6">
                                                                <ul class="collection">
                                                                    <div class="center">
                                                                        <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">Tecnoparque
                                                                            Nodo {{$nodo->entidad->present()->entidadName()}}
                                                                            no cuenta con
                                                                            un {{App\User::IsExperto()}} aún</p>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <div class="row">
                                                        <div class="center">
                                                            <span
                                                                class="secondary-text"><b>Articuladores</b></span>
                                                        </div>
                                                        <div class="divider mailbox-divider">
                                                        </div>
                                                        @forelse($nodo->articuladores as $articulador)
                                                            @if(isset($articulador->user) && $articulador->user->hasRole(App\User::IsArticulador()) && $articulador->user->estado == App\User::IsActive() &&  $articulador->user->deleted_at == null)
                                                                <div class="col s12 m12 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                            <span class="title">
                                                                                {{$articulador->user->present()->userFullName()}}
                                                                            </span>
                                                                            <p>
                                                                                <b class="secondary-text">Número
                                                                                    documento:</b> {{$articulador->user->present()->userDocumento()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Correo
                                                                                    Electrónco:</b> {{$articulador->user->present()->userEmail()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Teléfono:</b> {{$articulador->user->present()->userTelefono()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Celular: </b>
                                                                                {{$articulador->user->present()->userCelular()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Roles: </b>
                                                                                {{$articulador->user->present()->userRolesNames()}}
                                                                                <br/>
                                                                            </p>
                                                                            <a target="_blank" href="{{route("usuario.usuarios.show", $articulador->user->documento)}}" class="info">
                                                                                Ver mas información del usuario.
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <div class="col s12 m12 l6">
                                                                <ul class="collection">
                                                                    <div class="center">
                                                                        <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">Tecnoparque
                                                                            Nodo {{$nodo->entidad->present()->entidadName()}}
                                                                            no cuenta con
                                                                            un {{App\User::IsArticulador()}}
                                                                            aún</p>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <div class="row">
                                                        <div class="center">
                                                            <span
                                                                class="secondary-text"><b>{{App\User::IsApoyoTecnico()}}</b></span>
                                                        </div>
                                                        <div class="divider mailbox-divider">
                                                        </div>
                                                        @forelse($nodo->apoyostecnicos as $apoyotecnico)
                                                            @if(isset($apoyotecnico->user) && $apoyotecnico->user->hasRole(App\User::IsApoyoTecnico()) && $apoyotecnico->user->estado == App\User::IsActive() &&  $apoyotecnico->user->deleted_at == null)
                                                                <div class="col s12 m12 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                            <span class="title">
                                                                                {{$apoyotecnico->user->present()->userFullName()}}
                                                                            </span>
                                                                            <p>
                                                                                <b class="secondary-text">Número
                                                                                    documento:</b> {{$apoyotecnico->user->present()->userDocumento()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Correo
                                                                                    Electrónco:</b> {{$apoyotecnico->user->present()->userEmail()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Teléfono:</b> {{$apoyotecnico->user->present()->userTelefono()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Celular: </b>
                                                                                {{$apoyotecnico->user->present()->userCelular()}}
                                                                                <br/>
                                                                                <b class="secondary-text">Roles: </b>
                                                                                {{$apoyotecnico->user->present()->userRolesNames()}}
                                                                                <br/>
                                                                            </p>
                                                                            <a target="_blank" href="{{route("usuario.usuarios.show", $apoyotecnico->user->documento)}}" class="info">
                                                                                Ver mas información del usuario.
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <div class="col s12 m12 l6">
                                                                <ul class="collection">
                                                                    <div class="center">
                                                                        <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">Tecnoparque
                                                                            Nodo {{$nodo->entidad->present()->entidadName()}}
                                                                            no cuenta con
                                                                            un {{App\User::IsApoyoTecnico()}}
                                                                            aún</p>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    {{-- <div class="row">
                                                        <div class="col s12 m12 l12">
                                                            <div class="center">
                                                                <span
                                                                    class="secondary-text"><b>Ingreso</b></span>
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                            </div>
                                                            @forelse($nodo->ingresos as $ingreso)
                                                                <div class="col s12 m12 l6">
                                                                    @if(isset($ingreso->user) && $ingreso->user->hasRole(App\User::IsIngreso()) && $ingreso->user->estado == App\User::IsActive() &&  $ingreso->user->deleted_at == null)
                                                                        <ul class="collection">
                                                                            <li class="collection-item">
                                                                            <span class="title">
                                                                                {{$ingreso->user->present()->userFullName()}}
                                                                            </span>
                                                                                <p>
                                                                                    <b class="secondary-text">Número
                                                                                        documento:</b> {{$ingreso->user->present()->userDocumento()}}
                                                                                    <br/>
                                                                                    <b class="secondary-text">Correo
                                                                                        Electrónco:</b> {{$ingreso->user->present()->userEmail()}}
                                                                                    <br/>
                                                                                    <b class="secondary-text">Teléfono:</b> {{$ingreso->user->present()->userTelefono()}}
                                                                                    <br/>
                                                                                    <b class="secondary-text">Celular: </b>
                                                                                    {{$ingreso->user->present()->userCelular()}}
                                                                                    <br/>
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
                                                                            <p class="center-align">Tecnoparque
                                                                                Nodo {{$nodo->entidad->present()->entidadName()}}
                                                                                no cuenta con un
                                                                                usuario {{App\User::IsIngreso()}}
                                                                                aún</p>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            @endforelse
                                                        </div>
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
