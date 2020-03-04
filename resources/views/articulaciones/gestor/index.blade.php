@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
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
                @include('articulaciones.table')
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
