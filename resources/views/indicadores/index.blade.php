@extends('layouts.app')
@section('meta-title', 'Indicadores')
@section('content')
  @php
  $now = Carbon\Carbon::now();
  $yearNow = $now->year;
  $monthNow = $now->month;
  @endphp
  <link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          info_outline
                      </i>
                      Indicadores
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Indicadores</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Indicadores</span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m4 l4 offset-m8 offset-l8">
                      <a href="{{route('indicadores.form.metas')}}" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Registrar metas</a>
                    </div>
                  </div>
                  <ul class="collapsible">
                    <li>
                      <div class="collapsible-header"><i class="material-icons">edit</i>Generar indicadores de proyectos inscritos entre un rango de fechas</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.proyectos.inscritos')
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">done</i>Generar indicadores de proyectos finalizados y suspendidos entre un rango de fechas</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.proyectos.finalizados')
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">play_arrow</i>Generar indicadores de proyectos activos</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.proyectos.activos')
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">done_all</i>Generar todos</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.proyectos.todos')
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">assignment</i>Metas de tecnoparque</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.metas.metas')
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">lightbulb</i>Ideas de tecnoparque</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.ideas.download')
                      </div>
                    </li>
                  </ul>
                  <div class="divider"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
