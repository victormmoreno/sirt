@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>Comité de Selección de Ideas</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">CSIBT de Tecnoparque nodo {{ \NodoHelper::returnNodoUsuario() }}</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{route('csibt.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Nuevo Comité">
                        <i class="material-icons">gavel</i>
                      </a>
                    </div>
                  </div>
                </div>
                <center>
                </center>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="comitesDelNodo_table">
                  <thead>
                    <tr>
                      <th>Código del Comité</th>
                      <th>Fecha</th>
                      <th>Observaciones</th>
                      <th>Ideas de Proyecto</th>
                      <th>Editar</th>
                      <th>Evidencias</th>
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
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('csibt.create')}}"  class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nuevo Comité">
          <i class="material-icons">gavel</i>
        </a>
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
            <th style="width: 40%">Observaciones</th>
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
