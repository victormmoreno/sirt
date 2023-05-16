@extends('layouts.app')
@section('meta-title', 'Usuario | ' . $user->present()->userFullName())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('usuario.index')}}">
                        <i class="material-icons left">arrow_back</i>
                    </a>Usuarios
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                    <li class="active">Detalle</li>
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
                                        <div class="left mailbox-buttons">
                                            {!!$user->present()->userProfileUserImage()!!}
                                        </div>
                                        <div class="left">
                                            <p class="m-t-lg flow-text secondary-text">{{$user->present()->userFullName()}}</p>
                                            <span class="mailbox-title">{{$user->present()->userYearOld()}}</span>
                                            @foreach(explode(';', $user->rols) as $role)
                                                <div class="chip m-t-sm blue-grey white-text"> {{$role}}</div>
                                            @endforeach
                                            <div class="position-top-right p f-12 mail-date show-on-large hide-on-med-and-down">Miembro desde {{$user->present()->userCreatedAtFormat()}}</div>
                                        </div>
                                        <div class="right mailbox-buttons">
                                            @can('tomar_control', $user)
                                                <a href="{{route('usuario.tomar.control', $user->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Tomar control</a>
                                            @endcan
                                            @can('access', $user)
                                                <a href="{{route('usuario.acceso', $user->documento)}}" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar Acceso</a>
                                            @endcan
                                            @can('generatePassword', $user)
                                                <a href="{{route('password.generate', $user->documento)}}" class="waves-effect waves-grey btn-flat m-t-xs">Generar nueva contraseña</a>
                                            @endcan
                                            @canany(['update','updateNodeAndRole'], $user)
                                            <a class='dropdown-button btn waves-effect secondary-text btn-flat m-t-xs' href='#' data-activates='dropdown-actions'>Cambiar información</a>
                                            <ul id='dropdown-actions' class='dropdown-content'>
                                                @can('update',$user)
                                                    <li><a href="{{route('usuario.edit', $user->documento)}}">Cambiar Información personal</a></li>
                                                @endcan
                                                @can('updateNodeAndRole',$user)
                                                    <li class="divider"></li>
                                                    <li><a  href="{{route('usuario.changenode', $user->documento)}}">Cambiar Roles y Nodos</a></li>
                                                @endcan
                                            </ul>
                                            @endcanany
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        @if(session()->has('status') || session()->has('error'))
                                            <div class="center ">
                                                <div class="card  {{session('status') ? 'bg-success': ''}} {{session('error') ? 'bg-danger': ''}}  white-text">
                                                    <div class="row">
                                                        <div class="col s12 m10">
                                                            <div class="card-content white-text">
                                                                <p>
                                                                    <i class="material-icons left">info_outline</i>
                                                                    {{session('status') ? : session('error')}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @include('users.details.personal-information')
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

