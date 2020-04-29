@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica ')
@section('meta-content', 'Proyectos de Base Tecnológica')
@section('meta-keywords', 'Proyectos de Base Tecnológica')
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
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a class="active" href="#actividades">Actividades</a></li>
                    <li class="tab col s3"><a class="" href="#proyectos">Proyectos Cerrados</a></li>
                    <li class="tab col s3"><a class="" href="#proyectos_ipe">Proyectos en Inicio, Planeación o Ejecución</a></li>
                  </ul>
                  <br>
                </div>
                <div id="actividades">
                  <div class="col s12 m4 l4">
                    <div class="row">
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
                        <select id="txtactividad_id" name="txtactividad_id" style="width: 100%" class="js-states select2 browser-default">
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
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                      <center>
                        <button onclick="consultarCostoDeUnaActividad()" class="btn">Consultar</button>
                      </center>
                    </div>
                  </div>
                  <div class="col s12 m8 l8">
                    <div id="costosDeUnProyecto_column" class="green lighten-3" >
                      <div class="row card-panel">
                        <h5 class="center">
                          Para consultar el costo de una actividad, debes seleccionar una actividad en el campo de actividades y luego pulsar el botón de consultar.
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- <div id="proyectos">
                  <div class="row">
                    <div class="col s12 m5 l5">
                      <div class="row">
                        <span>
                          Aquí podrás consulta los costos de proyectos finalizados (En PF ó PMV), según el tipo de proyecto y entre fechas (estas fechas corresponden a
                          las fechas de cierre de los proyectos)
                        </span>
                      </div>
                      <div class="row">
                        <div class="input-field col s12 m6 l6">
                          <input type="text" id="txtfecha_inicio_costosProyectos" name="txtfecha_inicio_costosProyectos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                          <label for="txtfecha_inicio_costosProyectos">Fecha Inicio</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                          <input type="text" id="txtfecha_fin_costosProyectos" name="txtfecha_fin_costosProyectos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                          <label for="txtfecha_fin_costosProyectos">Fecha Fin</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s12 m6 l6">
                          <h5>Tipos de Proyecto</h5>
                          @foreach ($tipos_proyecto as $key => $value)
                            <p class="p-v-xs">
                              <input type="checkbox" name="tipoProyecto[]" id="tipoProyecto_{{ $value->id }}" value="{{ $value->nombre }}">
                              <label for="tipoProyecto_{{ $value->id }}">{{ $value->nombre }}</label>
                            </p>
                          @endforeach
                        </div>
                        <div class="col s12 m6 l6">
                          <h5>Estados de Proyecto</h5>
                          @foreach ($estados as $key => $value)
                            <p class="p-v-xs">
                              <input type="radio" name="estado" id="estado_{{ $value->id }}" value="{{ $value->nombre }}">
                              <label for="estado_{{ $value->id }}">{{ $value->nombre }}</label>
                            </p>
                          @endforeach
                        </div>
                      </div>
                      <div class="divider"></div>
                      <div class="row">
                        <div class="center col s12 m12 l12">
                          <button onclick="consultarCostosDeProyectos(0, 1)" class="btn">Consultar</button>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m7 l7">
                      <div class="row">
                        <ul class="collapsible">
                          <li>
                            <div class="collapsible-header blue-grey"><i class="material-icons">search</i>Ver mas información</div>
                            <div class="collapsible-body">
                              <div class="row">
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" name="txthoras_asesoria_proyectos" id="txthoras_asesoria_proyectos" disabled>
                                  <label for="txthoras_asesoria_proyectos">Horas de Asesoria en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" name="txthoras_uso_proyectos" id="txthoras_uso_proyectos" disabled>
                                  <label for="txthoras_uso_proyectos">Horas de Uso de Equipos en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcosto_asesorias_proyectos" id="txtcosto_asesorias_proyectos" disabled>
                                  <label for="txtcosto_asesorias_proyectos">Costo de Asesoría en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcostos_equipos_proyectos" id="txtcostos_equipos_proyectos" disabled>
                                  <label for="txtcostos_equipos_proyectos">Costo de Equipos en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcostos_materiales_proyectos" id="txtcostos_materiales_proyectos" disabled>
                                  <label for="txtcostos_materiales_proyectos">Costos de Materiales en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcostos_administrativos_proyectos" id="txtcostos_administrativos_proyectos" disabled>
                                  <label for="txtcostos_administrativos_proyectos">Costos Administrativos en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcosto_total_proyectos" id="txtcosto_total_proyectos" disabled>
                                  <label for="txtcosto_total_proyectos">Total Costos</label>
                                </div>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="row">
                        <div id="costosDeProyectos_column" class="green lighten-3">
                          <div class="row card-panel">
                            <h5 class="center">
                              Para consultar los costos de proyectos, debes seleccionar por lo menos un tipo de proyeto, un cierre y fechas.
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> --}}
                {{-- <div id="proyectos_ipe">
                  <div class="row">
                    <div class="col s12 m5 l5">
                      <div class="row">
                        <span>
                          Aquí podrás consulta los costos de proyectos en inicio, plaenación o ejecución según el tipo de proyecto y entre dos fechas (estas fechas corresponden a
                          las fechas de inicio de los proyectos)
                        </span>
                      </div>
                      <div class="row">
                        <div class="input-field col s12 m6 l6">
                          <input type="text" id="txtfecha_inicio_costosProyectos_ipe" name="txtfecha_inicio_costosProyectos_ipe" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                          <label for="txtfecha_inicio_costosProyectos_ipe">Fecha Inicio</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                          <input type="text" id="txtfecha_fin_costosProyectos_ipe" name="txtfecha_fin_costosProyectos_ipe" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                          <label for="txtfecha_fin_costosProyectos_ipe">Fecha Fin</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s12 m6 l6">
                          <h5>Tipos de Proyecto</h5>
                          @foreach ($tipos_proyecto as $key => $value)
                            <p class="p-v-xs">
                              <input type="checkbox" name="tipoProyecto_ipe[]" id="tipoProyecto_ipe_{{ $value->id }}" value="{{ $value->nombre }}">
                              <label for="tipoProyecto_ipe_{{ $value->id }}">{{ $value->nombre }}</label>
                            </p>
                          @endforeach
                        </div>
                        <div class="col s12 m6 l6">
                          <h5>Estados de Proyecto</h5>
                          @foreach ($estados_ipe as $key => $value)
                            <p class="p-v-xs">
                              <input type="radio" name="estado_ipe" id="estado_ipe_{{ $value->id }}" value="{{ $value->nombre }}">
                              <label for="estado_ipe_{{ $value->id }}">{{ $value->nombre }}</label>
                            </p>
                          @endforeach
                        </div>
                      </div>
                      <div class="divider"></div>
                      <div class="row">
                        <div class="center col s12 m12 l12">
                          <button onclick="consultarCostosDeProyectos(0, 2)" class="btn">Consultar</button>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m7 l7">
                      <div class="row">
                        <ul class="collapsible">
                          <li>
                            <div class="collapsible-header blue-grey"><i class="material-icons">search</i>Ver mas información</div>
                            <div class="collapsible-body">
                              <div class="row">
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" name="txthoras_asesoria_proyectos_ipe" id="txthoras_asesoria_proyectos_ipe" disabled>
                                  <label for="txthoras_asesoria_proyectos_ipe">Horas de Asesoria en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" name="txthoras_uso_proyectos_ipe" id="txthoras_uso_proyectos_ipe" disabled>
                                  <label for="txthoras_uso_proyectos_ipe">Horas de Uso de Equipos en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcosto_asesorias_proyectos_ipe" id="txtcosto_asesorias_proyectos_ipe" disabled>
                                  <label for="txtcosto_asesorias_proyectos_ipe">Costo de Asesoría en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcostos_equipos_proyectos_ipe" id="txtcostos_equipos_proyectos_ipe" disabled>
                                  <label for="txtcostos_equipos_proyectos_ipe">Costo de Equipos en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcostos_materiales_proyectos_ipe" id="txtcostos_materiales_proyectos_ipe" disabled>
                                  <label for="txtcostos_materiales_proyectos_ipe">Costos de Materiales en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcostos_administrativos_proyectos_ipe" id="txtcostos_administrativos_proyectos_ipe" disabled>
                                  <label for="txtcostos_administrativos_proyectos_ipe">Costos Administrativos en Proyecto</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" name="txtcosto_total_proyectos_ipe" id="txtcosto_total_proyectos_ipe" disabled>
                                  <label for="txtcosto_total_proyectos_ipe">Total Costos</label>
                                </div>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="row">
                        <div id="costosDeProyectos_ipe_column" class="green lighten-3">
                          <div class="row card-panel">
                            <h5 class="center">
                              Para consultar los costos de proyectos, debes seleccionar por lo menos un tipo de proyeto, un estado (inicio, planeación o ejecución) y dos fechas.
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> --}}
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
