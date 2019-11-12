@extends('layouts.app')
@section('meta-title', 'Eventos de Divulgación Tecnológica')
@section('meta-content', 'Eventos de Divulgación Tecnológica')
@section('meta-keywords', 'Eventos de Divulgación Tecnológica')
@section('content')
  @php
    $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY');
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons">hearing</i>Edt</h5>
          <div class="card stats-card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m10 l10">
                  <div class="center-align">
                    <span class="card-title center-align"> Edts de {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</span>
                  </div>
                </div>
                <div class="col s12 m2 l2">
                  <a href="{{ route('edt.create') }}">
                    <div class="card green">
                      <div class="card-content center">
                        <i class="left material-icons white-text">add</i>
                        <span class="white-text">Nueva EDT</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m12 l12">
                    <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_edts_Gestor" name="txtanho_edts_Gestor" onchange="consultarEdtsDeUnGestor(0);">
                      @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                      @endfor
                    </select>
                    <label for="txtanho_edts_Gestor">Seleccione el Año</label>
                  </div>
                </div>
              </div>
              <table class="display responsive-table datatable-example" id="edtPorGestor_table" >
                <thead>
                  <th>Código de la Edt</th>
                  <th>Nombre</th>
                  <th>Gestor</th>
                  <th>Área de Conocimiento</th>
                  <th>Tipo de Edt</th>
                  <th>Fecha de Inicio</th>
                  <th>Estado</th>
                  <th>Empresas</th>
                  <th>Detalles</th>
                  <th>Editar</th>
                  <th>Entregables</th>
                </thead>

              </table>
              {{-- <div class="col s12 m2 l2">
                <a href="{{route('edt.excel.gestor', auth()->user()->gestor->id)}}">
                  <div class="card green">
                    <div class="card-content center">
                      <span class="white-text">Descargar tabla</span>
                    </div>
                  </div>
                </a>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('edt.modals')
@endsection
