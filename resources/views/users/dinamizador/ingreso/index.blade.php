@extends('layouts.app')

@section('meta-title', 'Ingreso')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                              <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Usuarios | Ingreso
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Ingreso</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                        <span class="card-title center-align">
                                            
                                            @if($view == 'activos')
                                            Usuarios Ingresos con acceso a Tecnoparque Nodo {{ \App\Helpers\NodoHelper::returnNameNodoUsuario()}} 
                                            @else
                                            Usuarios Ingresos sin acceso a Tecnoparque Nodo {{ \App\Helpers\NodoHelper::returnNameNodoUsuario()}}
                                            @endif
                                            <i class="material-icons">
                                                supervised_user_circle
                                            </i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('usuario.search')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nuevo Usuario</a>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                            </div>
                            @includeWhen($view == 'activos', 'users.settings.button_filter', [ $event = 'UserDinamizadorIngreso.downloadIngreso(1)','url' => route('usuario.ingreso.papelera'), 'message' => 'Ver Usuarios Ingresos sin acceso'])
                            @includeWhen($view == 'inactivos', 'users.settings.button_filter', [ $event = 'UserDinamizadorIngreso.downloadIngreso(0)','url' => route('usuario.ingreso.index'), 'message' => 'Ver Usuarios Ingresos con acceso'])
                            <br>
                            @if($view == 'activos')
                                @include('users.table', ['id' => 'ingresos_dinamizador_table'] )  
                            @elseif($view == 'inactivos')
                                @include('users.table', ['id' => 'ingresos_dinamizador_inactivos_table'] ) 
                            @endif
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