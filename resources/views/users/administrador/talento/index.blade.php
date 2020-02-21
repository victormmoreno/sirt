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
                                    <div class="center-align">
                                        <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">
                                             
                                            @if($view == 'activos')
                                            Talentos con acceso a {{config('app.name')}}
                                            @else
                                            Talentos sin acceso a {{config('app.name')}}
                                            @endif
                                        </span>
                                        <i class="material-icons orange-text text-darken-3">
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
                            
                            @includeWhen($view == 'activos', 'users.settings.button_filter', ['url' => route('usuario.usuarios.talento.papelera'), 'message' => 'Ver Talentos sin acceso'])
                            @includeWhen($view == 'inactivos', 'users.settings.button_filter', ['url' => route('usuario.talento.index'), 'message' => 'Ver Talentos con acceso'])
                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                  
                                  <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1">
                                  
                                    <option value="">Seleccione Nodo * </option>
                                    @foreach($nodos as $nodo)
                                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                    @endforeach
                                  </select>
                                  <label for="txtnodo">Nodo</label>
                                </div>
                                <div class="col s12 m6 l6">
                                  <div class="input-field col s12 m12 l12">
                                    <select class="js-states"  tabindex="-1" style="width: 100%" id="txt_anio_user" name="txt_anio_user">
                                      @for ($i=2016; $i <= $year; $i++)
                                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                      @endfor
                                    </select>
                                    <label for="txt_anio_user">Seleccione el Año</label>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m4 l4 offset-l4">
                                      @if($view == 'activos')
                                      <a onclick="usuarios.consultarTalentosByTecnoparque();" href="javascript:void(0)">
                                      @elseif($view == 'inactivos')
                                      <a onclick="usuarios.consultarTalentosByTecnoparqueTrash();" href="javascript:void(0)">
                                      @endif
                                        
                                          <div class="card blue">
                                            <div class="card-content center flow-text">
                                              <i class="left material-icons white-text small">search</i>
                                              <span class="white-text">Consultar Talento</span>
                                            </div>
                                          </div>
                                        </a>
                                      </div>
                                </div>
                              </div>
                              @if($view == 'activos')
                                @include('users.table', ['id' => 'talentoByDinamizador_table_activos'] )  
                              @elseif($view == 'inactivos')
                                @include('users.table', ['id' => 'talentoByDinamizador_table_inactivos'] ) 
                              @endif
                             
                            </div>
                            
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('usuario.usuarios.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Usuario">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<div  class="modal detalleUsers">
  <div class="modal-content">
    <div class="titulo_users"></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>



@endsection