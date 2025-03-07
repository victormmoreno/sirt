@extends('layouts.app')
@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">supervised_user_circle</i>Usuarios | Perfil
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Perfil</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card mailbox-content">
                                <div class="card-content">
                                    <div class="row no-m-t no-m-b">
                                        <div class="col s12 m5 l3">
                                            <div class="row">
                                                @include('users.profile.nav.nav-profile')
                                            </div>
                                        </div>
                                        <div class="col s12 m7 l9">
                                            @include('users.profile.nav.navbar')
                                            <div class="mailbox-view">
                                                <div class="mailbox-view-header">
                                                    <div class="left">
                                                        <div class="left">
                                                            @if ($user->nombre_genero == 'Masculino')
                                                                <img alt="{{$user->nombres}}" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-masculine.png') }}"></img>
                                                            @elseif ($user->nombre_genero == 'Femenino')
                                                                <img alt="{{$user->nombres}}" class="circle mailbox-profile-image z-depth-1" src="{{asset('img/profile-image-female.png')}}"></img>
                                                            @else
                                                                <img alt="{{$user->nombres}}"  class="circle mailbox-profile-image z-depth-1" src="{{asset('img/profile-img-default.png')}}"></img>
                                                            @endif
                                                        </div>
                                                        <div class="left">
                                                            <span class="mailbox-title secondary-text">
                                                                {{$user->nombres.' '.$user->apellidos}}
                                                            </span>
                                                            <span class="mailbox-author">
                                                                {{$user->rols}}
                                                                <br>
                                                                    Miembro desde {{isset($user->created_at) ? $user->created_at->isoFormat('LL') : ': No Registra'}}
                                                                    <br>
                                                                @if(isset($user->fechanacimiento))
                                                                {{$user->fechanacimiento->age}} años
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="right mailbox-buttons">
                                                    <span class="mailbox-title primary-text">
                                                        <p class="center">
                                                            Información Personal
                                                            <div class="right">
                                                                <a class="waves-effect waves-light btn bg-secondary m-t-xs dropdown-button "
                                                                    data-activates="more" href="#">
                                                                    <i class="material-icons right">
                                                                        more_vert
                                                                    </i>
                                                                    Más Información
                                                                </a>
                                                                <ul class="dropdown-content" id="more">
                                                                    <li>
                                                                        <a href="{{route('perfil.edit')}}">
                                                                            Cambiar Información
                                                                        </a>
                                                                    </li>
                                                                    <li class="divider"></li>
                                                                    @can('downloadCertificatedPlataform', $user)
                                                                    <li>
                                                                        <a href="{{route('certificado')}}" target="_blank">
                                                                            Obtener certificado de registro en el sistema
                                                                        </a>
                                                                    </li>
                                                                    @endcan
                                                                </ul>
                                                            </div>
                                                        </p>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <small>
                                                        {{$user->nombre_genero}}
                                                    </small>
                                                </div>
                                                <div class="divider mailbox-divider"></div>
                                                @include('users.details.personal-information')
                                                <div class="divider mailbox-divider"></div>
                                                <div class="right">
                                                    <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs"
                                                        href="{{route('perfil.edit')}}">
                                                        Cambiar Información Personal
                                                    </a>
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
