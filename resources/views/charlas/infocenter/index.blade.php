@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>Charlas Informativas</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">Charlas Informativas de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{route('charla.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Nueva Charla Informativa">
                        <i class="material-icons">exposure_plus_1</i>
                      </a>
                    </div>
                  </div>
                </div>
                <center>
                </center>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Encargado</th>
                      <th>Número de Asistentes</th>
                      <th>Observaciones</th>
                      <th>Listado de Asistentes</th>
                      <th>Evidencias Fotográficas</th>
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
        <a href="{{route('charla.create')}}"  class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nueva Charla Informativa">
          <i class="material-icons">exposure_plus_1</i>
        </a>
      </div>
    </div>
  </div>
</main>
@endsection
