@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons">attach_money</i>Costos</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m4 l4">
                  <div class="input-field col s12 m12 l12">
                    <select id="txtactividad_id" name="txtactividad_id" class="js-states select2 browser-default">
                      <option value="">Seleccione una Actividad</option>
                      @forelse ($actividades as $id => $value)
                        <option value="{{$id}}">{{$value}}</option>
                      @empty
                        <option value="">No hay información disponible</option>
                      @endforelse
                    </select>
                    <label for="txtactividad_id" class="active">Seleccione una Actividad</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtlinea" id="txtlinea" disabled>
                    <label for="txtlinea">Línea Tecnológica</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtgestor" id="txtgestor" disabled>
                    <label for="txtgestor">Gestor</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txthoras_asesoria" id="txthoras_asesoria" disabled>
                    <label for="txthoras_asesoria">Horas de Asesoria en Proyecto</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txthoras_uso" id="txthoras_uso" disabled>
                    <label for="txthoras_uso">Horas de Uso de Equipos</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcosto_asesorias" id="txtcosto_asesorias" disabled>
                    <label for="txtcosto_asesorias">Costo de Asesoría en Proyectos</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_equipos" id="txtcostos_equipos" disabled>
                    <label for="txtcostos_equipos">Costo de Equipos en Proyectos</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_administrativos" id="txtcostos_administrativos" disabled>
                    <label for="txtcostos_administrativos">Costos Administrativos en Proyectos</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcosto_total" id="txtcosto_total" disabled>
                    <label for="txtcosto_total">Total Costos</label>
                  </div>
                  <center>
                    <button onclick="consultarCostoDeUnaActividad()" class="btn">Consultar</button>
                  </center>
                </div>
                <div class="col s12 m8 l8">
                  <div id="costosDeUnProyecto_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
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
