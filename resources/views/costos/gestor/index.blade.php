@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('meta-content', 'Proyectos de Base Tecnológica')
@section('meta-keywords', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
         <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          attach_money
                      </i>
                      Costos
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Costos</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m4 l4">
                  <div class="input-field col s12 m3 l3">
                    <select class="js-states" tabindex="-1" style="width: 100%" id="txtanho_proyectos" name="txtanho_proyectos" onchange="consultarProyectosDelGestor_costos(this.value);">
                      {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
                      @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                      @endfor
                    </select>
                    <label for="txtanho_proyectos">Seleccione el Año</label>
                  </div>
                  <div class="input-field col s12 m9 l9">
                    <select id="txtactividad_id" name="txtactividad_id" class="js-states select2 browser-default">
                      <option value="">Seleccione un año</option>
                    </select>
                    <label for="txtactividad_id" class="active">Seleccione una Actividad</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtlinea_actividad" id="txtlinea_actividad" disabled>
                    <label for="txtlinea_actividad">Línea Tecnológica</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtgestor_actividad" id="txtgestor_actividad" disabled>
                    <label for="txtgestor_actividad">Gestor</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txthoras_asesoria_actividad" id="txthoras_asesoria_actividad" disabled>
                    <label for="txthoras_asesoria_actividad">Horas de Asesoria en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txthoras_uso_actividad" id="txthoras_uso_actividad" disabled>
                    <label for="txthoras_uso_actividad">Horas de Uso de Equipos en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcosto_asesorias_actividad" id="txtcosto_asesorias_actividad" disabled>
                    <label for="txtcosto_asesorias_actividad">Costo de Asesoría en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_equipos_actividad" id="txtcostos_equipos_actividad" disabled>
                    <label for="txtcostos_equipos_actividad">Costo de Equipos en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_materiales_actividad" id="txtcostos_materiales_actividad" disabled>
                    <label for="txtcostos_materiales_actividad">Costos de Materiales en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_administrativos_actividad" id="txtcostos_administrativos_actividad" disabled>
                    <label for="txtcostos_administrativos_actividad">Costos Administrativos en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcosto_total_actividad" id="txtcosto_total_actividad" disabled>
                    <label for="txtcosto_total_actividad">Total Costos</label>
                  </div>
                  <center>
                    <button onclick="consultarCostoDeUnaActividad()" class="btn">Consultar</button>
                  </center>
                </div>
                <div class="col s12 m8 l8">
                  <div id="costosDeUnProyecto_column" class="green lighten-3">
                    <div class="row card-panel">
                      <h5 class="center">
                        Para consultar el costo de una actividad, debes seleccionar una actividad en el campo de actividades y luego pulsar el botón de consultar.
                      </h5>
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
  <script>
    $( document ).ready(function() {
      consultarProyectosDelGestor_costos('{{$yearNow}}');
    });
    function consultarProyectosDelGestor_costos (value) {
      let anho;
      anho = value;
      $('#txtactividad_id').empty();
      $('#txtactividad_id').append('<option value="">Seleccione una actividad</option>');
      consultarProyectos(anho);
      consultarArticulaciones(anho);
      $('#txtactividad_id').select2();
    }

    function consultarProyectos(anho) {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/proyecto/consultarProyectos_costos/' + anho
      }).done(function(response) {
        
        $.each(response.proyectos, function(i, e) {
          $('#txtactividad_id').append('<option  value="' + e.actividad_id + '">' + e.codigo_proyecto + ' - ' + e.nombre + '</option>');
        })
      });
    }

    function consultarArticulaciones(anho) {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/articulacion/consultarArticulaciones_costos/' + anho
      }).done(function(response) {
        $.each(response.articulaciones, function(i, e) {
          $('#txtactividad_id').append('<option  value="' + e.actividad_id + '">' + e.codigo_articulacion + ' - ' + e.nombre + '</option>');
        })
      });
    }
  </script>
@endpush
