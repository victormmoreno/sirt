@extends('layouts.app')

@section('meta-title', 'usuarios ' )

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Usuarios</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                        <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">
                                            Usuarios {{ config('app.name')}}
                                        </span>
                                        @else
                                        <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">
                                            Usuarios Tecnoparque Nodo {{ \App\Helpers\NodoHelper::returnNameNodoUsuario()}}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col s12 l2">
                                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsInfocenter())
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('usuario.search')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">search</i>Filtrar Usuario</a>
                                    </div>
                                    @else
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('usuario.search')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nuevo Usuario</a>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    @forelse($roles as $role)
                                    <div class="col s12 m3 l3">
                                        <div class="card">
                                            <div class="card-image waves-effect waves-block waves-light center">
                                              <i class="large material-icons center green-complement-text">
                                                person_pin
                                            </i>
                                            </div>

                                            <div class="card-content">
                                              <span class="card-title activator grey-text text-darken-4 center">{{$role}}</span>
                                              @switch($role)
                                                    @case(config('laravelpermission.roles.roleAdministrador'))
                                                        <p class="center"><a href="{{route('usuario.administrador.index')}}">ir a {{$role}}</a></p>
                                                    @break
                                                    @case(config('laravelpermission.roles.roleDinamizador'))
                                                        <p class="center"><a href="{{route('usuario.dinamizador.index')}}">ir a {{$role}}</a></p>
                                                    @break
                                                    @case(config('laravelpermission.roles.roleGestor'))
                                                        <p class="center"><a href="{{route('usuario.gestor.index')}}">ir a {{$role}}</a></p>
                                                    @break
                                                    @case(config('laravelpermission.roles.roleInfocenter'))
                                                        <p class="center"><a href="{{route('usuario.infocenter.index')}}">ir a {{$role}}</a></p>
                                                    @break
                                                    @case(config('laravelpermission.roles.roleTalento'))
                                                        <p class="center"><a href="{{route('usuario.talento.index')}}">ir a {{$role}}</a></p>
                                                    @break
                                                    @case(config('laravelpermission.roles.roleIngreso'))
                                                        <p class="center"><a href="{{route('usuario.ingreso.index')}}">ir a {{$role}}</a></p>
                                                    @break
                                                @default
                                                    <p class="center"><a href="">ir a {{$role}}</a></p>
                                                    @break
                                                @endswitch

                                            </div>
                                            
                                          </div> 
                                    </div>
                                    @empty
                                        <div class="center">
                                            <i class="large material-icons  teal-text lighten-2 center">
                                                notifications_off
                                            </i>
                                            <p class="center-align">No se encontraron resultados</p> 
                                        </div>
                                    @endforelse
                                </div>
                                
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('usuario.search')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Usuario">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
