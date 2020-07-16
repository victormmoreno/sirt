@extends('layouts.app')
@section('meta-title','')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="middle-content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m3 l3 ">
          <a href="{{ route('proyecto.pendientes') }}" class="black-text">
            <div class="card green lighten-3 stats-card">
              <div class="card-content">
                <h6>Proyectos pendientes de aprobación para iniciar</h6>
              </div>
              <div class="progress green darken-4 stats-card-progress">
                <div class="determinate"></div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="card card-transparent">
            <div class="card-content">
              <center>
                <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de la Red de Tecnoparques Colombia</span></p>
              </center>
              <div class="row">
                <div class="col s12 m12 l10 offset-l1">
                  <img class="materialboxed responsive-img" src="{{ asset('img/logonacional_Negro.png') }}" alt="Sena | Tecnoparque">
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
  <script href="resources"></script>
@endpush
