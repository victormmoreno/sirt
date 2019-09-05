@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5>
          <a class="footer-text left-align" href="{{ route('proyecto') }}">
            <i class="left material-icons">arrow_back</i>
          </a> Proyectos
        </h5>
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
