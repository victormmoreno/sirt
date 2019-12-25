@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <a class="footer-text left-align" href="{{ route('proyecto') }}">
                        <i class="material-icons arrow-l">arrow_back</i>
                      </a> Proyectos Pendientes de Aprobación
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('proyecto')}}">Proyectos</a></li>
                      <li class="active">Proyectos Pendientes</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="center-align">
                  <span class="card-title center-align">Proyectos Pendientes de Aprobación</span>
                </div>
              </div>
            </div>
            <div class="divider"></div>
            @include('proyectos.table_pendientes')
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
  consultarProyectosPendientesPorAprobacion();
  </script>
@endpush
