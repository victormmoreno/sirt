@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('meta-content', 'CSIBT')
@section('meta-keywords', 'CSIBT')
@section('content')
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
                  <span class="card-title center-align">CSIBT de Tecnoparque</span>
                  <div class="divider"></div>
                </center>
                <div class="input-fiel col s12 m12 l12">
                  <label class="active" for="txtnodo">Nodo <span class="red-text">*</span></label>
                  <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="consultarCsibtPorNodo()">
                    <option value="">Seleccione nodo</option>
                    @foreach($nodos as $nodo)
                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example dataTable" id="comitesDelNodoAdministrador_table" style="width: 100%">
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
@endsection
