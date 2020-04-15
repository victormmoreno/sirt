@extends('layouts.app')
@section('meta-title', 'Talentos')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
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
                            Usuarios | Talentos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Talentos</li>
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
                                          Talentos con acceso y  con proyectos en {{config('app.name')}}
                                          @else
                                          Talentos sin acceso y  con proyectos en {{config('app.name')}}
                                          @endif
                                        </span>
                                        <i class="material-icons">
                                            supervised_user_circle
                                        </i>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('usuario.search')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nuevo Usuario</a>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            @includeWhen($view == 'activos', 'users.settings.button_filter', [$event = 'userTalentoByDinamizador.downloadTalento(1)','url' => route('usuario.usuarios.talento.papelera'), 'message' => 'Ver Talentos sin acceso'])
                            @includeWhen($view == 'inactivos', 'users.settings.button_filter', [$event = 'userTalentoByDinamizador.downloadTalento(0)','url' => route('usuario.talento.index'), 'message' => 'Ver Talentos con acceso'])
                            <br><br>
                            <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                              <li class="tab col s3"><a href="#historialTalento" class="active">Talentos {{config('app.name')}}</a></li>
                              <li class="tab col s3"><a href="#talentoByGestor" >Talentos por Gestor </a></li>
                              <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                            </ul>

                            <div id="historialTalento">
                                <h5 class="center-align">Talentos {{config('app.name')}}</h5>
                                <div class="divider">
                            </div>
                            <div class="col s12 m12 l12">
                                <div class="input-field col s12 m12 l12">
                                  @if($view == 'activos')
                                    <select class="js-states"  tabindex="-1" style="width: 100%" id="anio_proyecto_talento" name="anio_proyecto_talento" onchange="userTalentoByDinamizador.consultarTalentosByTecnoparque();">
                                  @elseif($view == 'inactivos')
                                  <select class="js-states"  tabindex="-1" style="width: 100%" id="anio_proyecto_talento" name="anio_proyecto_talento" onchange="userTalentoByDinamizador.consultarTalentosByTecnoparqueTrash();">
                                  @endif
                                    
                                        @for ($i=2016; $i <= $year; $i++)
                                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label for="anio_proyecto_talento">Seleccione el Año</label>
                                </div>
                            </div>
                            @if($view == 'activos')
                                @include('users.table', ['id' => 'talentoByDinamizador_table'] )  
                            @elseif($view == 'inactivos')
                                @include('users.table', ['id' => 'talentoByDinamizador_inactivos_table'] ) 
                            @endif
                            
                            </div>
                            <div id="talentoByGestor">
                                <h5 class="center-align">Talentos Por Gestor</h5>
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                        <div class="input-field">
                                          <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_user_talento" name="txtanho_user_talento">
                                            @for ($i=2016; $i <= $year; $i++)
                                              <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                            @endfor
                                          </select>
                                          <label for="txtanho_user_talento">Seleccione el Año</label>
                                        </div>
                                      </div>
                                      <div class="input-field col s12 m6 l6">
                                        <select class="initialized" id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
                                          <option value="">Seleccione un gestor del nodo * </option>
                                          @foreach($gestores as $id => $nombres_gestor)
                                            <option value="{{$id}}">{{$nombres_gestor}}</option>
                                          @endforeach
                                        </select>
                                        <label for="txtgestor_id">Gestor</label>
                                      </div>
                                </div>

                                <div class="row">
                                  <div class="col s12 m4 l4 offset-l4">
                                    @if($view == 'activos')
                                      <a onclick="userTalentoByDinamizador.getUserTalentosByGestor();" href="javascript:void(0)">
                                    @elseif($view == 'inactivos')
                                      <a onclick="userTalentoByDinamizador.getUserTalentosByGestorTrash();" href="javascript:void(0)">
                                    @endif
                                      <div class="card blue">
                                        <div class="card-content center flow-text">
                                          <i class="left material-icons white-text small">search</i>
                                          <span class="white-text">Consultar Talento</span>
                                        </div>
                                      </div>
                                    </a>
                                  </div>
                                  
                                  @if($view == 'activos')
                                      @include('users.table2', ['id' => 'talentoByGestor_table'] )  
                                  @elseif($view == 'inactivos')
                                      @include('users.table2', ['id' => 'talentoByGestor_inactivos_table'] ) 
                                  @endif
                                </div>
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


