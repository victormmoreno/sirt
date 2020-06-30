@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
@section('meta-content', 'Articulaciones G.I')
@section('meta-keywords', 'Articulaciones G.I')

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
                    <span class="card-title center-align">Articulaciones con Grupos de Investigación</span>
                  </div>
                </div>
              </div>
              <div class="divider"></div><br>
              <div class="row">
                <div class="input-field col s12 m6 l6">
                  <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_articulaciones_Nodo" name="txtanho_articulaciones_Nodo">
                    @for ($i=2016; $i <= $year; $i++)
                      <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                    @endfor
                  </select>
                  <label for="txtanho_articulaciones_Nodo">Seleccione el Año</label>
                </div>
                <div class="input-field col s12 m6 l6">
                  <select class="initialized" id="txtnodo_id" name="txtnodo_id" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Nodo * </option>
                    @foreach($nodos as $nodo)
                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
                  </select>
                  <label for="txtnodo_id">Seleccione un Nodo</label>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m4 l4 offset-l4">
                  <a onclick="consultarLasArticulacionesDeUnNodo();" href="javascript:void(0)">
                    <div class="card blue">
                      <div class="card-content center flow-text">
                        <i class="left material-icons white-text small">search</i>
                        <span class="white-text">Consultar Articulaciones G.I</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="divider"></div>
              @include('articulaciones.table')
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
    function consultarLasArticulacionesDeUnNodo() {
      let id = $('#txtnodo_id').val();
      let anho = $('#txtanho_articulaciones_Nodo').val();
      if (id === '') {
        Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
      } else {
        
        $('#articulacionesNodo_table').dataTable().fnDestroy();
        $('#articulacionesNodo_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          "lengthChange": false,
          ajax:{
            url: "/articulacion/datatableArticulacionesDelNodo/"+id+"/"+anho,
            data: function (d) {
              d.codigo_articulacion = $('#codigo_articulacion_AdministradorTable').val(),
              d.nombre_gestor = $('#nombre_GestorAdministradorTable').val(),
              d.nombre_nodo = $('#nombre_nodoAdministradorTable').val(),
              d.nombre = $('#nombre_AdministradorTable').val(),
              d.fase = $('#fase_AdministradorTable').val(),
              d.search = $('input[type="search"]').val()
            }
          },
          columns: [
            {
            data: 'codigo_articulacion',
            name: 'codigo_articulacion',
            },
            {
              data: 'nombre_nodo',
              name: 'nombre_nodo',
            },
            {
              data: 'nombre_completo_gestor',
              name: 'nombre_completo_gestor',
            },
            {
              data: 'nombre',
              name: 'nombre',
            },
            {
              data: 'nombre_fase',
              name: 'nombre_fase',
            },
            {
                width: '8%',
                data: 'info',
                name: 'info',
                orderable: false
           },
            {
              data: 'proceso',
              name: 'proceso',
              orderable: false
            },
            ],
          });
      }
    }

    $("#codigo_articulacion_AdministradorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#nombre_GestorAdministradorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#nombre_nodoAdministradorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#nombre_AdministradorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#fase_AdministradorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

  </script>
@endpush
