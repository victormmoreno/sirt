@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('meta-content', 'CSIBT')
@section('meta-keywords', 'CSIBT')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          gavel
                      </i>
                      Comité de Selección de Ideas
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Comité de Selección de Ideas</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <center>
                  <span class="card-title center-align">CSIBT de Tecnoparque nodo {{ \NodoHelper::returnNodoUsuario() }}</span>
                </center>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example dataTable" id="comitesDelNodoGestor_table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Código del Comité</th>
                      <th>Fecha</th>
                      <th>Estado del Comité</th>
                      <th>Observaciones</th>
                      <th style="width: 8%">Detalles</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<div id="ideaProyecto" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="detalle_idea"></div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
<div id="modalIdeasComite" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="fechaComiteModal" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div>
      <table class="striped" style="width: 100%"> 
        <thead>
          <tr>
            <th>Idea de Proyecto</th>
            <th>Hora</th>
            <th>Asistencia</th>
            <th>Observaciones</th>
            <th>Admitido</th>
            <th>Editar Idea</th>
            <th>Detalles de la Idea</th>
          </tr>
        </thead>
        <tbody id="ideasProyectoDeUnComite">

        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
