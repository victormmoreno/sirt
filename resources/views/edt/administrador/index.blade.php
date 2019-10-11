@extends('layouts.app')
@section('meta-title', 'Eventos de Divulgación Tecnológica')
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
                    <span class="card-title center-align"> Edts de Red Tecnoparque</span>
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
