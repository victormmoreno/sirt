@extends('layouts.app')
@section('meta-title', 'Ingresos de Tecnoparque')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="material-icons left ">transit_enterexit</i> Ingresos</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l10">
                      <div class="center-align">
                        <span class="card-title center-align"> Ingresos de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                      </div>
                    </div>
                    <div class="col s12  l2">
                      <div class="click-to-toggle show-on-large hide-on-med-and-down">
                        <a href="{{route('ingreso')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Ingreso">
                          <i class="material-icons">transit_enterexit</i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <table class="display responsive-table datatable-example dataTable">
                    <thead>
                      <tr>
                        <th>Día/Hora Ingreso</th>
                        <th>Hora de Salida</th>
                        <th>Nombres</th>
                        <th>Tipo de Persona</th>
                        <th>Correo Eletrónico</th>
                        <th>Servicio</th>
                        <th>Descripcion</th>
                        <th>Editar</th>
                        <!-- <th>Eliminar</th> -->
                      </tr>
                    </thead>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('ingreso')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Ingreso">
              <i class="material-icons">transit_enterexit</i>
            </a>
          </div>
        </div>
      </div>
    </main>
  @endsection
