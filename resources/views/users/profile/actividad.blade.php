@extends('layouts.app')

@section('meta-title', 'Perfil | Actividades ' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                             Perfil | Actividades
                        </h5>
                    </div>
                </div>
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
                                                @include('users.profile.nav.header')

                                            </div>
                                            <div class="right">
                                                <small>
                                                    {{{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}}
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m8 offset-m2 l10 offset-l1">
                                                    @forelse($actividades  as $actividad)
                                                        <div class="card-panel grey lighten-5 z-depth-1">
                                                            <div class="row valign-wrapper">
                                                                @if(\Session::get('login_role') == App\User::IsTalento() && isset($actividad->actividad))

                                                                    <div class="col s12">
                                                                        <div class="black-text">
                                                                            @if(isset($actividad->actividad->articulacion_proyecto->proyecto) && $actividad->actividad->articulacion_proyecto->proyecto != null)
                                                                                <a href="{{route('proyecto.inicio',$actividad->actividad->articulacion_proyecto->proyecto->id)}}" class="heading-title">{{$actividad->actividad->codigo_actividad}} - {{$actividad->actividad->nombre}} </a>
                                                                                <a href="{{route('proyecto.inicio',$actividad->actividad->articulacion_proyecto->proyecto->id)}}" class="green-text">{{route('proyecto.inicio',$actividad->actividad->articulacion_proyecto->proyecto->id)}}</a>
                                                                            @elseif(isset($actividad->actividad->articulacion_proyecto->articulacion) && $actividad->actividad->articulacion_proyecto->articulacion != null)
                                                                                <a href="{{route('articulacion.inicio',$actividad->actividad->articulacion_proyecto->articulacion->id)}}" class="heading-title">{{$actividad->actividad->codigo_actividad}} - {{$actividad->actividad->nombre}} </a>
                                                                                <a href="{{route('articulacion.inicio',$actividad->actividad->articulacion_proyecto->articulacion->id)}}" class="green-text">{{route('articulacion.inicio',$actividad->actividad->articulacion_proyecto->articulacion->id)}}</a>
                                                                            @else
                                                                                {{$actividad->actividad->codigo_actividad}} - {{$actividad->actividad->nombre}}  
                                                                            @endif
                                                                            <p class="blue-grey-text ">{{optional($actividad->actividad->fecha_inicio)->isoFormat('LL')}}   Tecnoparque Nodo {{$actividad->actividad->nodo->entidad->nombre}}
                                                                                {{-- <div class="right">
                                                                                <small>
                                                                                    <a class="modal-trigger waves-effect waves-light btn" href="#modal1">Ver más</a>
                                                                                </small>
                                                                            </div> --}}
                                                                            </p>
                                                                        </div>
                                                                    </div
                                                                @elseif(\Session::get('login_role') == App\User::IsGestor() && isset($actividad))
                                                                <div class="col s12">
                                                                    <div class="black-text">
                                                                        
                                                                        @if(isset($actividad->articulacion_proyecto->proyecto) && $actividad->articulacion_proyecto->proyecto != null)
                                                                            <a href="{{route('proyecto.inicio',$actividad->articulacion_proyecto->proyecto->id)}}" class="heading-title">{{$actividad->codigo_actividad}} - {{$actividad->nombre}} </a>
                                                                            <a href="{{route('proyecto.inicio',$actividad->articulacion_proyecto->proyecto->id)}}" class="green-text">{{route('proyecto.inicio',$actividad->articulacion_proyecto->proyecto->id)}}</a>
                                                                        @elseif(isset($actividad->articulacion_proyecto->articulacion) && $actividad->articulacion_proyecto->articulacion != null)
                                                                            <a href="{{route('articulacion.inicio',$actividad->articulacion_proyecto->articulacion->id)}}" class="heading-title">{{$actividad->codigo_actividad}} - {{$actividad->nombre}} </a>
                                                                            <a href="{{route('articulacion.inicio',$actividad->articulacion_proyecto->articulacion->id)}}" class="green-text">{{route('articulacion.inicio',$actividad->articulacion_proyecto->articulacion->id)}}</a>
                                                                        @else
                                                                            {{$actividad->codigo_actividad}} - {{$actividad->nombre}}  
                                                                        @endif
                                                                        
                                                                        
                                                                        <p class="blue-grey-text ">{{optional($actividad->fecha_inicio)->isoFormat('LL')}}   Tecnoparque Nodo {{$actividad->nodo->entidad->nombre}}
                                                                            {{-- <div class="right">
                                                                                <small>
                                                                                    <a class="modal-trigger waves-effect waves-light btn" href="#modal1">Ver más</a>
                                                                                </small>
                                                                            </div> --}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="card-panel grey lighten-5 z-depth-1">
                                                            <div class="row valign-wrapper">
                                                                <div class="col s12">
                                                                    <div class="black-text">
                                                                        <p class="blue-grey-text valign-wrapper center-align">Aún no tienes actividades registradas</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforelse

                                                </div>


                                            </div>
                                            @if(isset($actividades))
                                                <div class="center">
                                                    {{ $actividades->links() }}
                                                </div>
                                            @endif
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
{{-- <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4 class="valign-wrapper truncate center-align">Modal Header</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
    </div>
</div> --}}
@endsection
