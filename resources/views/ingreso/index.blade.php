@extends('layouts.app')
@section('meta-title', 'Ingresos de Tecnoparque')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="material-icons left">transit_enterexit</i>Ingresos</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m8 l8">
                      <div class="center-align">
                        <span class="card-title center-align"> Ingresos de Tecnoparque</span>
                      </div>
                    </div>
                    @can('create', App\Models\IngresoVisitante::class)
                      <div class="col s12 m4 l4">
                        <a href="{{route('ingreso.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo ingreso</a>
                      </div>
                    @endcan
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="input-field col m2 l2 s2">
                      <input id="txtstart_date_ingresos" name="txtstart_date_ingresos" type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                      <label for="txtstart_date_ingresos">Desde</label>
                    </div>
                    <div class="input-field col m2 l2 s2">
                      <input id="txtend_date_ingresos" name="txtend_date_ingresos" type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                      <label for="txtend_date_ingresos">Hasta</label>
                    </div>
                    <div class="col s12 m6 l4 offset-m3 right">
                      <button class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs" id="download_excel_visitas"><i class="material-icons left">cloud_download</i>Descargar</button>
                      <button class="waves-effect waves-grey bg-secondary white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs" id="filter_ingresos"><i class="material-icons left">search</i>Buscar</button>
                  </div>
                  </div>
                  @include('ingreso.table_nodo')
                </div>
              </div>
            </div>
          </div>
        </div>
        @can('create', App\Models\IngresoVisitante::class)
          <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('ingreso.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Ingreso">
              <i class="material-icons">transit_enterexit</i>
            </a>
          </div>
        @endcan
      </div>
    </div>
  </main>
@endsection
@include('ingreso.functions')
