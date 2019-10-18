@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="left material-icons">autorenew</i>Articulaciones</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m10 l10">
                <div class="center-align">
                  <span class="card-title center-align">Articulaciones - {{auth()->user()->nombres}} {{ auth()->user()->apellidos}}</span>
                </div>
              </div>
              <div class="col s12 m2 l2">
                <a href="{{ route('articulacion.create') }}">
                  <div class="card green">
                    <div class="card-content center">
                      <i class="left material-icons white-text">add</i>
                      <span class="white-text">Nueva Articulación</span>
                    </div>
                  </div>
                </a>
              </div>
              {{-- <div class="col s12 m2 l2">
                <div class="click-to-toggle show-on-large hide-on-med-and-down">
                  <a href="{{route('articulacion.create')}}"  class="btn btn-floating btn-large tooltipped green pulse" data-position="bottom" data-delay="50" data-tooltip="Nueva Articulación">
                    <i class="material-icons">autorenew</i>
                  </a>
                </div>
              </div> --}}
            </div>
            <div class="divider"></div>
            {{-- <div class="right material-icons">
              <a href="{{route('articulacion.excel.gestor', auth()->user()->gestor->id)}}">
                <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
              </a>
            </div> --}}
            <div class="row">
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
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th><input type="text" name="codigo_articulacion_GestorTable" id="codigo_articulacion_GestorTable" placeholder="Buscar por código de articulación"></th>
                    <th><input type="text" name="nombre_GestorTable" id="nombre_GestorTable" placeholder="Buscar por nombre"></th>
                    <th><input type="text" name="tipo_articulacion_GestorTable" id="tipo_articulacion_GestorTable" placeholder="Buscar por Tipo de Articulación"></th>
                    <th><input type="text" name="estado_GestorTable" id="estado_GestorTable" placeholder="Buscar por Estado"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>

                </tbody>
              </table>
              <div class="col s12 m2 l2">
                <a href="{{route('articulacion.excel.gestor', auth()->user()->gestor->id)}}">
                  <div class="card green">
                    <div class="card-content center">
                      <span class="white-text">Descargar tabla</span>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@include('articulaciones.modals')
@endsection
