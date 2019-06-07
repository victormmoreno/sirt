@extends('layouts.app')
@section('meta-title', 'Entrenamientos')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>Entrenamientos</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">Entrenamientos de Tecnoparque nodo {{$nodo}}</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{route('entrenamientos.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Nuevo Entrenamiento">
                        <i class="material-icons">exposure_plus_1</i>
                      </a>
                    </div>
                  </div>
                </div>
                <center>
                </center>
                <div class="divider"></div>
                <table id="entrenamientos_nodo_table" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Consecutivo</th>
                      <th>Primera Sesion</th>
                      <th>Segunda Sesion</th>
                      <th>Corres</th>
                      <th>Fotos</th>
                      <th>Listado de Asistentes</th>
                      <th>Ideas</th>
                      <th>Editar</th>
                      <th>Inhabilitar</th>
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
        <a href="{{route('entrenamientos.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nuevo Entrenamiento">
          <i class="material-icons">exposure_plus_1</i>
        </a>
      </div>
    </div>
  </div>
</main>
<div id="modalIdeasEntrenamiento" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="fechasEntrenamiento" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div>
      <table class="striped">
        <thead>
          <tr>
            <th>Idea de Proyecto</th>
            <th>¿Confirmación a los Entrenamientos?</th>
            <th>¿Convocado a Comité?</th>
            <th>Canvas</th>
            <th>Asistencia al Primer Entrenamiento</th>
            <th>Asistencia al Segundo Entrenamiento</th>
          </tr>
        </thead>
        <tbody id="ideasEntrenamiento">

        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
