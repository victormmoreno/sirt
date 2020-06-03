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
                  <li class="tab col s3"><a class="" href="#tecnoparque">Tecnoparque</a></li>
                  <li class="tab col s3"><a class="" href="#gestor">Gestor</a></li>
                  {{-- <li class="tab col s3"><a class="" href="#linea">Línea</a></li> --}}
                </ul>
                <br>
              </div>
              <div id="gestor" class="col s12 m12 l12">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a class="" href="#gestor_todo">Proyectos y AGI Inscritos - Cerrados</a></li>
                    <li class="tab col s3"><a class="" href="#gestor_actual">Fase actual de proyectos y AGI</a></li>
                    {{-- <li class="tab col s3"><a class="" href="#linea">Línea</a></li> --}}
                  </ul>
                  <br>
                </div>
                <div class="row" id="gestor_todo">
                  <div class="col s12 m4 l4">
                    <div class="input-field col s12 m12 l12">
                      <select id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione el Gestor</option>
                        @foreach($gestores as $id => $nombres_gestor)
                        <option value="{{$id}}">{{$nombres_gestor}}</option>
                        @endforeach
                      </select>
                      <label for="txtgestor_id">Gestor</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input type="text" id="txtfecha_inicio_Gestor" name="txtfecha_inicio_Gestor"
                        class="datepicker picker__input"
                        value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                      <label for="txtfecha_inicio_Gestor">Fecha Inicio</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input type="text" id="txtfecha_fin_Gestor" name="txtfecha_fin_Gestor"
                        class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                      <label for="txtfecha_fin_Gestor">Fecha Fin</label>
                    </div>
                    <div class="center col s12 m6 l6">
                      <button onclick="consultarSeguimientoDeUnGestor(1)" class="btn">Consultar</button>
                    </div>
                    {{-- <div class="center col s12 m6 l6">
                        <button onclick="generarExcelSeguimentoDeUnGestor(1)" class="btn green">Excel</button>
                      </div> --}}
                  </div>
                  <div class="col s12 m8 l8">
                    <div id="graficoSeguimientoPorGestorDeUnNodo_column" class="green lighten-3"
                      style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                      <div class="row card-panel">
                        <h5 class="center">
                          Para consultar el seguimiento de un gestor, debes seleccionar un gestor del nodo en el campo
                          de gestores, luego seleccionar
                          un rango de fecha y por último pulsar el botón de <button
                            onclick="consultarSeguimientoDeUnGestor(1)" class="btn">Consultar</button>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" id="gestor_actual">
                  <div class="col s12 m4 l4">
                    <div class="input-field col s12 m12 l12">
                      <select id="txtgestor_id_actual" name="txtgestor_id_actual" style="width: 100%" tabindex="-1" onchange="consultarSeguimientoDeUnGestorFase(1)">
                        <option value="">Seleccione el Gestor</option>
                        @foreach($gestores as $id => $nombres_gestor)
                        <option value="{{$id}}">{{$nombres_gestor}}</option>
                        @endforeach
                      </select>
                      <label for="txtgestor_id_actual">Gestor</label>
                    </div>
                  </div>
                  <div class="col s12 m8 l8">
                    <div id="graficoSeguimientoPorGestorFases_column" class="green lighten-3"
                      style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                      <div class="row card-panel">
                        <h5 class="center">
                          Para consultar el seguimiento de un gestor, debes seleccionar un gestor del nodo en el campo
                          de gestores.
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="tecnoparque" class="col s12 m12 l12">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a class="" href="#tecnoparque_todo">Proyectos y AGI Inscritos - Cerrados</a></li>
                    <li class="tab col s3"><a class="" href="#tecnoparque_actual">Fase actual de proyectos y AGI</a></li>
                    {{-- <li class="tab col s3"><a class="" href="#linea">Línea</a></li> --}}
                  </ul>
                  <br>
                </div>
                <div class="row" id="tecnoparque_todo">
                  <div class="col s12 m4 l4">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio_Nodo" name="txtfecha_inicio_Nodo"
                          class="datepicker picker__input"
                          value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                        <label for="txtfecha_inicio_Nodo">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_fin_Nodo" name="txtfecha_fin_Nodo"
                          class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                        <label for="txtfecha_fin_Nodo">Fecha Fin</label>
                      </div>
                    </div>
                    <div class="center col s12 m6 l6">
                      <button onclick="consultarSeguimientoDeUnNodo(0)" class="btn">Consultar</button>
                    </div>
                    {{-- <div class="center col s12 m6 l6">
                        <button onclick="generarExcelSeguimentoNodo(0)" class="btn green">Excel</button>
                      </div> --}}
                  </div>
                  <div class="col s12 m8 l8">
                    <div id="graficoSeguimientoDeUnNodo_column" class="green lighten-3"
                      style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                      <div class="row card-panel">
                        <h5 class="center">
                          Para consultar el seguimiento de proyectos del nodo, debes seleccionar
                          un rango de fecha y luego pulsar el botón de <button onclick="consultarSeguimientoDeUnNodo(0)"
                            class="btn">Consultar</button>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" id="tecnoparque_actual">
                  <div class="col s12 m12 l12">
                    <div id="graficoSeguimientoDeUnNodoFases_column" class="green lighten-3"
                      style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                      <div class="row card-panel">
                        <h5 class="center">
                          Aquí puedes ver los estados actuales de los proyectos y articulaciones con grupos de investigación.
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
    </div>
  </div>
</main>
@endsection
@push('script')
    <script>
      consultarSeguimientoDeUnNodoFases(0);
    </script>
@endpush