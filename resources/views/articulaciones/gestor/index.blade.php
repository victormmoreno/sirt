@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
  @php
  $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY');
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
            <div class="col s8 m8 l10">
                <h5 class="left-align">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    Articulaciones con Grupos de Investigación
                </h5>
            </div>
            <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Articulaciones G.I</li>
                </ol>
            </div>
        </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m10 l10">
                  <div class="center-align">
                    <span class="card-title center-align">Articulaciones G.I - {{auth()->user()->nombres}} {{ auth()->user()->apellidos}}</span>
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
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="input-field">
                    <select class="js-states" tabindex="-1" style="width: 100%" id="txtanho_articulaciones_Gestor" name="txtanho_articulaciones_Gestor" onchange="consultarArticulacionesDelGestor(this.value);">
                      @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                      @endfor
                    </select>
                    <label for="txtanho_articulaciones_Gestor">Seleccione el Año</label>
                  </div>
                </div>
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
                {{-- <div class="col s12 m2 l2">
                  <a href="{{route('articulacion.excel.gestor', auth()->user()->gestor->id)}}">
                    <div class="card green">
                      <div class="card-content center">
                        <span class="white-text">Descargar tabla</span>
                      </div>
                    </div>
                  </a>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('articulaciones.modals')
@endsection
@push('script')
  <script>
  $(document).ready(function() {
    consultarArticulacionesDelGestor({{$year}});
  });
  </script>
@endpush
