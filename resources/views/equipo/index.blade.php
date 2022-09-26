@extends('layouts.app')
@section('meta-title', 'Equipos')
@section('meta-content', 'Equipos')
@section('meta-keywords', 'Equipos')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <i class="material-icons">account_balance_wallet</i>
                            Equipos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Equipos</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">

                        <div class="row">
                            <div class="row">
                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsGestor()))
                                <div class="col s12 m12 l12">
                                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                        <span class="card-title center-align">
                                            @if(session()->get('login_role') == App\User::IsActivador())
                                                Equipos {{ config('app.name')}}
                                            @elseif(session()->get('login_role') == App\User::IsGestor())
                                                Equipos {{auth()->user()->gestor->lineatecnologica->nombre}} |  Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @elseif(session()->get('login_role') == App\User::IsDinamizador())
                                    <div class="row">
                                        <div class="col s12 m8 l8">
                                            <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                                <span class="card-title ">
                                                    Equipos Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
                                            <a  href="{{route('equipo.create')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo Equipo </a>
                                        </div>
                                    </div>
                                @elseif(session()->get('login_role') == App\User::IsAdministrador())
                                    <div class="row">
                                        <div class="col s12 m8 l8">
                                            <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                                <span class="card-title ">
                                                    Equipos de Tecnoparque
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
                                            <a  href="{{route('equipo.create')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo Equipo </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="divider"></div>
                            <div class="row no-m-t no-m-b search-tabs-row search-tabs-header ">
                                @can('showOptionsForAdmin', App\Models\Equipo::class)
                                    <div class="input-field col s12 m2 l2">
                                        <label class="active" for="filter_nodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2" name="filter_nodo" id="filter_nodo">
                                            <option value="all" >todos</option>
                                            @forelse($nodos as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                            @empty
                                                <option>No se encontraron Resultados</option>
                                            @endforelse
                                        </select>
                                    </div>
                                @endcan
                                <div class="input-field col s12 m2 l2">
                                    <label class="active" for="filter_state">Estado <span class="red-text">*</span></label>
                                    <select name="filter_state" id="filter_state">
                                        <option value="si" >Habilitados</option>
                                        <option value="no" >Inhabilitados</option>
                                        <option value="all" >todos</option>
                                    </select>
                                </div>
                                <div class="col s12 m6 l4 offset-m3 right">
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_equipos"><i class="material-icons">cloud_download</i>Descargar</button>
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_equipo"><i class="material-icons">search</i>Buscar</button>
                                </div>
                            </div>
                            <br>
                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsGestor()))
                            <table class="display responsive-table" id="equipo_data_table">
                                <thead>
                                    <th width="15%">Linea Tecnológica</th>
                                    <th width="15%">Equipo</th>
                                    <th width="15%">Referencia</th>
                                    <th width="15%">Marca</th>
                                    <th width="15%">Costo Adquisición</th>
                                    <th width="15%">Vida Util (Años)</th>
                                    <th width="15%">Promedio Horas uso al año</th>
                                    <th width="15%">Año de compra</th>
                                    <th width="15%">Año fin depreciación</th>
                                    <th width="15%">Depreciación por año</th>
                                    <th width="15%">Estado</th>
                                </thead>
                            </table>
                            @else
                            <table class="display responsive-table" id="equipo_actions_data_table" style="width: 100%">
                                <thead>
                                    <th width="15%">Linea Tecnológica</th>
                                    <th width="15%">Equipo</th>
                                    <th width="15%">Referencia</th>
                                    <th width="15%">Marca</th>
                                    <th width="15%">Costo Adquisición</th>
                                    <th width="15%">Vida Util (Años)</th>
                                    <th width="15%">Estado</th>
                                    <th width="15%">Detalle</th>
                                    <th width="15%">Editar</th>
                                    <th width="15%">Cambiar estado</th>
                                    <th width="15%">Eliminar</th>
                                </thead>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('showCreateButton', App\Models\Empresa::class)
            <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                <a href="{{route('equipo.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo equipo">
                    <i class="material-icons">add</i>
                </a>
            </div>
        @endcan
    </div>
</main>
<div  class="modal modal-equipo">
    <div class="modal-content">
      <center><h4 id="titulo" class="center-aling"></h4></center>
      <div class="divider"></div>
      <div id="detalle_equipo"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
    </div>
  </div>
@endsection
