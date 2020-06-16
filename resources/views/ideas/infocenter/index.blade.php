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
                  <div class="col s12 m10 l10">
                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                      <span class="card-title center-align">Ideas de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2 show-on-large hide-on-med-and-down">
                    <a target="_blank" href="{{ route('ideas.index') }}">
                      <div class="card green">
                        <div class="card-content center">
                          <i class="left material-icons white-text">add</i>
                          <span class="white-text">Nueva Idea de Proyecto</span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <label class="active" for="selectYearIdea">Año <span class="red-text">*</span></label>
                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectYearIdea">

                            @for ($i=$year; $i >= 2016; $i--)
                                <option value="{{$i}}" >{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col s12 m6 l6">
                        <label class="active" for="txtestadoIdea">Estado <span class="red-text">*</span></label>
                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="txtestadoIdea">
                            @forelse($estadosIdeas  as $id => $name)
                                <option value="{{$id}}" >{{$name}}</option>
                            @empty
                                <p>No se encontraron resultados</p>
                            @endforelse

                        
                        </select>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col s12 m4 l4 offset-l4 offset-m4">
                        <a onclick="ideas.getIdeasForEmprendedores()" href="javascript:void(0)">
                            <div class="card blue">
                                <div class="card-content center flow-text">
                                    <i class="left material-icons white-text small">search</i>
                                    <span class="white-text">Buscar Idea</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                  <table id="ideas_emprendedores_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
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
            <a href="{{ route('ideas.index') }}" target="_blank" class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva Idea">
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
