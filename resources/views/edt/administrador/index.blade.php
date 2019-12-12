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
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          hearing
                      </i>
                      Edt
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Edt</li>
                  </ol>
              </div>
          </div>
          <div class="card stats-card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="center-align">
                    <span class="card-title center-align"> Edts de Red Tecnoparque</span>
                     <div class="divider"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1">
                      <option value="">Seleccione Nodo * </option>
                      @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                      @endforeach
                    </select>
                    <label for="txtnodo">Nodo</label>
                  </div>
                  <div class="col s12 m6 l6">
                    <div class="input-field col s12 m12 l12">
                      <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_edts_Nodo" name="txtanho_edts_Nodo">
                        @for ($i=2016; $i <= $year; $i++)
                          <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                        @endfor
                      </select>
                      <label for="txtanho_edts_Nodo">Seleccione el Año</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m4 l4 offset-l4">
                    <a onclick="prepararDatatableEdtsPorNodo();" href="javascript:void(0)">
                      <div class="card blue">
                        <div class="card-content center flow-text">
                          <i class="left material-icons white-text small">search</i>
                          <span class="white-text">Consultar Edt's</span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example" id="edtPorNodo_table" >
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
                    <th>Entregables</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </thead>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('edt.modals')
@endsection
@push('script')
  <script>
    function prepararDatatableEdtsPorNodo() {
      let id = $('#txtnodo').val();
      if (id === "") {
        Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
      } else {
        datatableEdtsPorNodo(id);
      }
    }

  </script>
@endpush
