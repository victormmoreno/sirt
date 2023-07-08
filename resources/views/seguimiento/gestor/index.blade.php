@extends('layouts.app')
@section('meta-title', 'Seguimiento')
@section('content')
  @php
  $yearNow = Carbon\Carbon::now()->isoFormat('YYYY');
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          search
                      </i>
                      Seguimiento
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Seguimiento</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a class="active" href="#gestor">Experto</a></li>
                    <li class="tab col s3"><a class="" href="#proyectos">Proyectos</a></li>
                    <li class="tab col s3"><a class="" href="#articulaciones">Articulaciones</a></li>
                  </ul>
                  <br>
                </div>
                <div id="gestor" class="col s12 m12 l12">
                  <div class="col s12 m12 l12">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                      <li class="tab col s3"><a class="active" href="#gestor_todo">Proyectos activos (TRL esperado)</a></li>
                      <li class="tab col s3"><a class="" href="#gestor_actual">Fase actual de proyectos</a></li>
                    </ul>
                    <br>
                  </div>
                  <div class="row" id="gestor_todo">
                    <div class="col s12 m12 l12">
                      <div id="graficoSeguimientoEsperadoPorGestorDeUnNodo_column" class="green lighten-3"
                        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                          <h5 class="center">
                            Para consultar el seguimiento de un experto, solo debe esperar unos segundos.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="gestor_actual">
                    <div class="col s12 m12 l12">
                      <div id="graficoSeguimientoPorGestorFases_column" class="green lighten-3"
                        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                          <h5 class="center">
                            Para consultar el seguimiento de un experto, debes seleccionar un experto del nodo en la lista desplegable de los expertos.
                          </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="proyectos" class="col s12 m12 l12">
                  <div class="col s12 m12 l12">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                      <li class="tab col s3"><a class="active" href="#proyectos_asesorias">Resumen de asesorias por proyecto</a></li>
                      <li class="tab col s3"><a class="" href="#proyectos_inscritos">Proyectos inscritos por mes en el año actual</a></li>
                    </ul>
                    <br>
                  </div>
                  <div class="row" id="proyectos_asesorias">
                    <div class="col s12 m4 l4">
                      <blockquote>
                        <h5>Aquí puedes generar un archivo PDF con detalles de los usos de infraestructuras que se realizaron en un proyecto.</h5>
                        <h5>Para generar el archivo pdf, debes seleccionar el año en que se finalizó el proyecto y luego presionar el botón con el ícono <b><i class="far fa-file-pdf"></i></b> para descargar el archivo.</h5>
                      </blockquote>
                    </div>
                    <div class="col s12 m8 l8">
                      <div class="input-field">
                        <select class="js-states" onchange="consultarProyectosSeguimiento_Gestor()" tabindex="-1" style="width: 100%" id="txtanho_proyecto_Seguimiento" name="txtanho_proyecto_Seguimiento">
                          @for ($i=2016; $i <= $yearNow; $i++)
                            <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                          @endfor
                        </select>
                        <label for="txtanho_proyecto_Seguimiento">Seleccione el Año</label>
                      </div>
                      <div class="row">
                        @include('seguimiento.table_proyectos')
                      </div>
                    </div>
                  </div>
                  <div class="row" id="proyectos_inscritos">
                    <div class="col s12 m12 l12">
                      <div id="graficoSeguimientoInscritosPorMes_column" class="green lighten-3"
                        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                          <h5 class="center">
                            Para consultar el seguimiento de un experto, solo debe esperar unos segundos.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="articulaciones" class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m4 l4">
                      <blockquote>
                        <h5>Aquí puedes generar un archivo PDF con detalles de los usos de infraestructuras que se realizaron en una articulación.</h5>
                        <h5>Para generar el archivo pdf, debes seleccionar el año en que se finalizó la articulación y luego presionar el botón con el ícono <b><i class="far fa-file-pdf"></i></b> para descargar el archivo.</h5>
                      </blockquote>
                    </div>
                    <div class="col s12 m8 l8">
                      <div class="input-field">
                        <select class="js-states" onchange="consultarArticulacionesSeguimiento_Gestor()" tabindex="-1" style="width: 100%" id="txtanho_articulacion_Seguimiento" name="txtanho_articulacion_Seguimiento">
                          @for ($i=2016; $i <= $yearNow; $i++)
                            <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                          @endfor
                        </select>
                        <label for="txtanho_articulacion_Seguimiento">Seleccione el Año</label>
                      </div>
                      <div class="row">
                        @include('seguimiento.table_articulaciones')
                      </div>
                    </div>
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
  <script type="text/javascript">
  $( document ).ready(function() {
    consultarSeguimientoDeUnGestor({{auth()->user()->experto->id}});
    consultarSeguimientoActualDeUnGestor({{auth()->user()->experto->id}});
    consultarProyectosInscritosPorMes({{auth()->user()->experto->id}});
    consultarProyectosSeguimiento_Gestor();
    consultarArticulacionesSeguimiento_Gestor();
  });

  function consultarProyectosSeguimiento_Gestor() {
    let anho = $('#txtanho_proyecto_Seguimiento').val();
    $('#tblproyecto_Seguimiento').dataTable().fnDestroy();
    $('#tblproyecto_Seguimiento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: host_url + "/proyecto/datatableProyectosDelGestorPorAnho/"+{{ auth()->user()->gestor->id }}+"/"+anho,
        data: function (d) {
          d.codigo_proyecto = $('#codigo_proyecto_tblproyectosDelGestorPorAnho_seguimiento').val(),
          d.nombre = $('#nombre_tblproyectosDelGestorPorAnho_seguimiento').val(),
          d.search = $('input[type="search"]').val()
        }
        // type: "get",
      },
      columns: [
        {
          width: '20%',
          data: 'codigo_proyecto',
          name: 'codigo_proyecto',
        },
        {
          width: '60%',
          data: 'nombre',
          name: 'nombre',
        },
        {
          width: '20%',
          data: 'download_seguimiento',
          name: 'download_seguimiento',
          orderable: false
        },
        ],
      });
    }

  function consultarArticulacionesSeguimiento_Gestor() {
    let anho = $('#txtanho_articulacion_Seguimiento').val();
    $('#tblarticulacion_Seguimiento').dataTable().fnDestroy();
    $('#tblarticulacion_Seguimiento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: host_url + "/articulacion/datatableArticulacionesDelGestor/"+{{ auth()->user()->gestor->id }}+"/"+anho,
        data: function (d) {
          d.search = $('input[type="search"]').val()
        }
      },
      columns: [
        {
          width: '20%',
          data: 'codigo_articulacion',
          name: 'codigo_articulacion',
        },
        {
          width: '60%',
          data: 'nombre',
          name: 'nombre',
        },
        {
          width: '20%',
          data: 'download_seguimiento',
          name: 'download_seguimiento',
          orderable: false
        },
        ],
      });
    }

  </script>
@endpush
