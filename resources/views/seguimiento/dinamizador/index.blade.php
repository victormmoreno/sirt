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
              <ul class="collapsible">
                <li>
                  <div class="collapsible-header">Proyectos activos (TRL esperado) del nodo</div>
                  <div class="collapsible-body">
                    <div id="graficoSeguimientoDeUnNodo_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                      <div class="row card-panel">
                        <h5 class="center">
                          Para consultar el seguimiento de proyectos del nodo, debes pulsar el botón de <button onclick="consultarSeguimientoEsperadoDeUnNodo(0)"
                            class="btn">Consultar</button>
                        </h5>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header">Fase actual de proyectos del nodo</div>
                  <div class="collapsible-body">
                    <div id="graficoSeguimientoDeUnNodoFases_column" class="green lighten-3"
                      style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                      <div class="row card-panel">
                        <h5 class="center">
                          Aquí puedes ver los estados actuales de los proyectos.
                        </h5>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header">Proyectos activos (TRL esperado) por experto</div>
                  <div class="collapsible-body">
                    <div class="row">
                      <div class="col s12 m4 l4">
                        <div class="input-field col s12 m12 l12">
                          <select id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1" onchange="consultarSeguimientoDeUnGestor(this.value)">
                            <option value="">Seleccione el experto</option>
                            @foreach($gestores as $id => $nombres_gestor)
                            <option value="{{$id}}">{{$nombres_gestor}}</option>
                            @endforeach
                          </select>
                          <label for="txtgestor_id">Experto</label>
                        </div>
                      </div>
                      <div class="col s12 m8 l8">
                        <div id="graficoSeguimientoEsperadoPorGestorDeUnNodo_column" class="green lighten-3"
                          style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                          <div class="row card-panel">
                            <h5 class="center">
                              Para consultar el seguimiento de un experto, debes seleccionar un experto del nodo en la lista desplegable de los expertos.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header">Fase actual de proyectos por experto</div>
                  <div class="collapsible-body">
                    <div class="row">
                      <div class="col s12 m4 l4">
                        <div class="input-field col s12 m12 l12">
                          <select id="txtgestor_id_actual" name="txtgestor_id_actual" style="width: 100%" tabindex="-1" onchange="consultarSeguimientoActualDeUnGestor(this.value)">
                            <option value="">Seleccione el experto</option>
                            @foreach($gestores as $id => $nombres_gestor)
                            <option value="{{$id}}">{{$nombres_gestor}}</option>
                            @endforeach
                          </select>
                          <label for="txtgestor_id_actual">Experto</label>
                        </div>
                      </div>
                      <div class="col s12 m8 l8">
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
                </li>
                <li>
                  <div class="collapsible-header">Proyectos activos (TRL esperado) por línea tecnológica</div>
                  <div class="collapsible-body">
                    <div class="row">
                      <div class="col s12 m4 l4">
                        <div class="input-field col s12 m12 l12">
                          <select id="txtlinea_esperado" name="txtlinea_esperado" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione la línea tecnológica</option>
                            @foreach($lineas as $id => $nombre)
                            <option value="{{$id}}">{{$nombre}}</option>
                            @endforeach
                          </select>
                          <label for="txtlinea_esperado">Línea Tecnológica</label>
                        </div>
                        <div class="col s12 m12 l12 center">
                          <button onclick="consultarSeguimientoEsperadoDeUnaLinea(0)" class="btn">Consultar</button>
                        </div>
                      </div>
                      <div class="col s12 m8 l8">
                        <div id="graficoSeguimientoEsperadoPorLineaDeUnNodo_column" class="green lighten-3"
                          style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                          <div class="row card-panel">
                            <h5 class="center">
                              Para consultar el seguimiento de una línea tecnológica, debes seleccionar una línea tecnológica del nodo en la lista desplegable de las líneas del nodo y luego presionar el botón de "Consultar".
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header">Fase actual de proyectos por línea tecnológica</div>
                  <div class="collapsible-body">
                    <div class="row">
                      <div class="col s12 m4 l4">
                        <div class="input-field col s12 m12 l12">
                          <select id="txtlinea_actual" name="txtlinea_actual" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione la línea tecnológica</option>
                            @foreach($lineas as $id => $nombre)
                            <option value="{{$id}}">{{$nombre}}</option>
                            @endforeach
                          </select>
                          <label for="txtlinea_actual">Línea Tecnológica</label>
                        </div>
                        <div class="col s12 m12 l12 center">
                          <button onclick="consultarSeguimientoActualDeUnaLinea(0)" class="btn">Consultar</button>
                        </div>
                      </div>
                      <div class="col s12 m8 l8">
                        <div id="graficoSeguimientoActualPorLineaDeUnNodo_column" class="green lighten-3"
                          style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                          <div class="row card-panel">
                            <h5 class="center">
                              Para consultar el seguimiento de una línea tecnológica, debes seleccionar una línea tecnológica del nodo en la lista desplegable de las líneas del nodo y luego presionar el botón de "Consultar".
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
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
      consultarSeguimientoEsperadoDeUnNodo(0);
      consultarSeguimientoDeUnNodoFases(0);
    </script>
@endpush