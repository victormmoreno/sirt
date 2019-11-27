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
          <h5><i class="left material-icons">search</i>Seguimiento</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a class="active" href="#gestor">Gestor</a></li>
                    <li class="tab col s3"><a class="" href="#proyectos">Proyectos</a></li>
                  </ul>
                  <br>
                </div>
                <div id="gestor" class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m4 l4">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio_Gestor" name="txtfecha_inicio_Gestor" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                        <label for="txtfecha_inicio_Gestor">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_fin_Gestor" name="txtfecha_fin_Gestor" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                        <label for="txtfecha_fin_Gestor">Fecha Fin</label>
                      </div>
                      <div class="center col s12 m6 l6">
                        <button onclick="consultarSeguimientoDeUnGestor(0)" class="btn">Consultar</button>
                      </div>
                      <div class="center col s12 m6 l6">
                        <button onclick="generarExcelSeguimentoDeUnGestor(0)" class="btn green">Excel</button>
                      </div>
                    </div>
                    <div class="col s12 m8 l8">
                      <div id="graficoSeguimientoPorGestorDeUnNodo_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                          <h5 class="center">
                            Para consultar el seguimiento de un gestor, debes seleccionar en el campo de gestores, luego seleccionar
                            un rango de fecha y por último pulsar el botón de consultar.
                          </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="proyectos" class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m4 l4">
                      <blockquote>
                        <h5>Aquí puedes generar un archivo PDF con detalles de los usos de infraestructuras que se realizaron en un proyecto.</h5>
                        <h5>Para generar el archivo pdf, debes seleccionar el año en que se finalizó el proyecto y luego presionar el botón con el ícono <b><i class="far fa-file-pdf"></i></b> para descargar el archivo.</h5>
                      </blockquote>
                    </div>
                    <div class="col s12 m8 l8">
                      <div class="input-field">
                        <select class="js-states" onchange="consultarProyectosSeguimiento_Gestor()" tabindex="-1" style="width: 100%" id="txtanho_proyecto_Seguimiento" name="txtanho_proyecto_Seguimiento" onchange="consultarProyectosDelGestor();">
                          {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
                          @for ($i=2016; $i <= $year; $i++)
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
    consultarProyectosSeguimiento_Gestor();
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
        url: "/proyecto/datatableProyectosDelGestorPorAnho/"+{{ auth()->user()->gestor->id }}+"/"+anho,
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
  </script>
@endpush
