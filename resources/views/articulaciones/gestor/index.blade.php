@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="material-icons">autorenew</i>Articulaciones</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m10 l10">
                <div class="center-align">
                  <span class="card-title center-align">Articulaciones - {{auth()->user()->nombres}} {{ auth()->user()->apellidos}}</span>
                </div>
              </div>
              <div class="col s12 m2 l2">
                <div class="click-to-toggle show-on-large hide-on-med-and-down">
                  <a href="{{route('articulacion.create')}}"  class="btn btn-floating btn-large tooltipped green pulse" data-position="bottom" data-delay="50" data-tooltip="Nueva Articulación">
                    <i class="material-icons">autorenew</i>
                  </a>
                </div>
              </div>
            </div>
            <div class="divider"></div>
            <table id="articulacionesGestor_table" class="display responsive-table datatable-example dataTable">
              <thead>
                <tr>
                  <th>Código de la Articulación</th>
                  <th>Nombre</th>
                  <th>Tipo de Articulación</th>
                  <th>Estado</th>
                  <th>Revisado Final</th>
                  <th>Detalles</th>
                  <th>Entregables</th>
                  <th>Editar</th>
                  {{-- <th>Fecha de Articulación</th> --}}
                  {{-- <th>Tipo de Articulación</th> --}}
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('articulacion.create')}}"  class="btn btn-floating btn-large tooltipped green pulse" data-position="left" data-delay="50" data-tooltip="Nueva Articulación">
          <i class="material-icons">autorenew</i>
        </a>
      </div>
    </div>
  </div>
</main>
<div id="articulacionGestorDetalle" class="modal">
  <div class="modal-content">
    <center><h4 id="articulacionGestorDetalle_titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="detalleArticulacionGestor"></div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
