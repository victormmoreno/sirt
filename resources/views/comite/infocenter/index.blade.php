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
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">CSIBT de Tecnoparque nodo {{ \NodoHelper::returnNodoUsuario() }}</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <a class="red" href="{{ route('csibt.create') }}">
                      <div class="card green">
                        <div class="card-content center">
                          <i class="left material-icons white-text">add</i>
                          <span class="white-text">Nuevo Comité</span>
                        </div>
                      </div>
                    </a>
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
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('csibt.create')}}"  class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nuevo Comité">
          <i class="material-icons">gavel</i>
        </a>
      </div>
    </div>
  </div>
</main>
@endsection
