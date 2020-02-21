@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons">library_books</i>Proyectos de Base Tecnológica</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Proyectos de Desarrollo Tecnológico - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} </span>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div>
                    @include('proyectos.table')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
    consultarProyectosDeTalentos();
  </script>
@endpush
