@extends('layouts.app')
@section('meta-title', 'Intervención a Empresas')
@section('meta-content', 'Intervención a Empresas')
@section('meta-keywords', 'Intervención a Empresas')
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
                    Intervención a Empresas
                </h5>
            </div>
            <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Intervención a Empresas</li>
                </ol>
            </div>
        </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m10 l10">
                  <div class="center-align">
                    <span class="card-title center-align">Intervención a Empresas - {{auth()->user()->nombres}} {{ auth()->user()->apellidos}}</span>
                  </div>
                </div>
                <div class="col s12 m2 l2">
                  <a href="{{ route('intervencion.create') }}">
                    <div class="card green">
                      <div class="card-content center">
                        <i class="left material-icons white-text">add</i>
                        <span class="white-text">Nueva Intervención a Empresa</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="input-field">
                    <select class="js-states" tabindex="-1" style="width: 100%" id="txtanho_articulaciones_Gestor" name="txtanho_articulaciones_Gestor" onchange="consultarIntervencionesEmpresaDelGestor(this.value);">
                      @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                      @endfor
                    </select>
                    <label for="txtanho_articulaciones_Gestor">Seleccione el Año</label>
                  </div>
                </div>
                <table id="IntervencionGestor_table" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Código de la Intervención</th>
                      <th>Nombre</th>
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
                      <th><input type="text" name="estado_GestorTable" id="estado_GestorTable" placeholder="Buscar por Estado"></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('intervencion.modals')
@endsection
@push('script')
  <script>
  $(document).ready(function() {
    consultarIntervencionesEmpresaDelGestor({{$year}});
  });
  </script>
@endpush
