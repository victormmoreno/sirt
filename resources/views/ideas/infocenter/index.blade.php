@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l9">
                  <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                      <i class="material-icons left">
                          lightbulb
                      </i>
                      Ideas de Proyecto
                  </h5>
              </div>
              <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Ideas de Proyecto</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m8 l8">
                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                      <span class="card-title center-align">Ideas de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                    </div>
                  </div>
                  <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
                    <a target="_blank" href="{{ route('idea.create') }}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down"><i class="material-icons">add</i> Nueva Idea de Proyecto</a>
                  </div>

                </div>
                <div class="divider"></div>

                    <div class="row search-tabs-row search-tabs-header">
                        
                        <div class="input-field col s12 m12 l1">
                            <label class="active" for="filter_state">Año <span class="red-text">*</span></label>
                            <select name="filter_year" id="filter_year">
                                @for ($i=$year; $i >= 2016; $i--)
                                    <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                                <option value="all" >todos</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m12 l2">
                            <label class="active" for="filter_state">Estado <span class="red-text">*</span></label>
                            <select name="filter_state" id="filter_state">
                                @forelse($estadosIdeas  as $id => $name)
                                    <option value="{{$id}}" >{{$name}}</option>
                                @empty
                                    <option>No se encontraron resultados</option>
                                @endforelse
                                <option value="all" >todos</option>
                            </select>
                        </div>

                        <div class="input-field col s12 m12 l1">
                            <label class="active" for="filter_vieneconvocatoria">Convocatoria</label>
                          <select  name="filter_vieneconvocatoria" id="filter_vieneconvocatoria">
                            <option value="all">Todas</option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
                          </select>
                        </div>

                        <div class="input-field col s12 m12 l4">

                            <input type="text" id="filter_convocatoria" placeholder="nombre de convocatoria">
                        </div>
                        <div class="col s12 m12 l4 right">
                          <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_excel"><i class="material-icons">cloud_download</i>Descargar</button>
                            <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_idea"><i class="material-icons">search</i>Buscar</button>
                        </div>
                    </div>

                
                  <table id="ideas_data_action_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Código de la Idea</th>
                        <th>Fecha de Registro</th>
                        <th>Persona</th>
                        <th>Correo</th>
                        <th>Contacto</th>
                        <th>Nombre de la Idea</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                        <th>Editar</th>
                        <th>Inhabilitar</th>
                        <th>No aplica</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
        <div id="modal1" class="modal modal-fixed-footer">
          <div class="modal-content">
            <center><h4 id="titulo" class="center-aling"></h4></center>
            <div class="divider"></div>
            <div id="detalle_idea"></div>
          </div>
          <div class="modal-footer  white-text">
            <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
          </div>
        </div>
      </div>
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{ route('idea.create') }}" target="_blank" class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva Idea">
                <i class="material-icons">lightbulb</i>
            </a>
        </div>
    </div>
  </div>
</main>
<div id="modal1" class="modal">
  <div class="modal-content">
    <center><h4 id="titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="detalle_idea"></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
