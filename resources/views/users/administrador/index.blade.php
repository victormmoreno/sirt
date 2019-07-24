@extends('layouts.app')

@section('meta-title', 'usuarios ' )

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios
                        </h5>
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
                                              <span class="card-title activator grey-text text-darken-4 center">{{$role}}<i class="material-icons right">more_vert</i></span>
                                              
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
                                                @default
                                                    <p class="center"><a href="">ir a {{$role}}</a></p>
                                                @endswitch

                                            </div>
                                            <div class="card-reveal ">
                                            <span class="card-title grey-text text-darken-4 center">{{$role}}<i class="material-icons right">close</i></span>
                                            @switch($role)
                                                @case(config('laravelpermission.roles.roleAdministrador'))
                                                    <p>Rol {{config('laravelpermission.roles.roleAdministrador')}}</p>
                                                    
                                                @break
                                                @case(config('laravelpermission.roles.roleInfocenter'))
                                                    <p>Rol {{config('laravelpermission.roles.roleInfocenter')}}</p>
                                                    
                                                @break
                                              
                                            @default
                                                <p>Here is some more information about this product that is only revealed once clicked on.</p>
                                                @break
                                            @endswitch
                                            </div>
                                          </div> 
                                    </div>
                                    @empty
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
