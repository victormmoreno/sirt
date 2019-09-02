@extends('layouts.app')

@section('meta-title', 'usuarios ' )

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
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
                                        <span class="card-title center-align">
                                            Usuarios {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a class="btnregister btn btn-floating btn-large tooltipped green" data-delay="50" data-position="button" data-tooltip="Nuevo Usuario" href="{{route('usuario.usuarios.create')}}">
                                            <i class="material-icons">
                                                how_to_reg
                                            </i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    @forelse($roles as $role)
                                    <div class="col s12 m3 l3">
                                        <div class="card">
                                            <div class="card-image waves-effect waves-block waves-light center">
                                              <i class="large material-icons center ">
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
            </div>
        </div>
    </div>
</main>

@endsection
