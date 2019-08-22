@extends('layouts.app')
@section('meta-title', 'Gráficos de Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('grafico')}}">
              {{ $yearNow = Carbon\Carbon::now()->isoFormat('YYYY') }}
              <i class="left material-icons">arrow_back</i>
            </a> Gráficos
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Gráficos de Articulaciones</span>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <ul class="collapsible">
                    <li>
                      <div class="collapsible-header"><i class="material-icons">autorenew</i>Articulaciones por fechas</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="input-field col s12 m4 l4">
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_Grafico1" name="txtfecha_inicio_Grafico1" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_Grafico1">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_Grafico1" name="txtfecha_fin_Grafico1" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_Grafico1">Fecha Fin</label>
                            </div>
                            <div class="center col s12 m12 l12">
                              <button onclick="consultaArticulacionesDelGestorPorNodoYFecha_stacked({{auth()->user()->dinamizador->nodo_id}});" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoArticulacionesPorGestorYNodoPorFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">autorenew</i>Articulaciones por gestor y fecha</div>
                      <div class="collapsible-body">
                        <div class="row">
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
                              <input type="text" id="txtfecha_inicio_Grafico2" name="txtfecha_inicio_Grafico2" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_Grafico2">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_Grafico2" name="txtfecha_fin_Grafico2" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_Grafico2">Fecha Fin</label>
                            </div>
                            <div class="center col s12 m12 l12">
                              <button onclick="consultarArticulacionesDeUnGestorPorFecha_stacked();" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoArticulacionesPorGestorYFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar las articulaciones por gestor, se debe seleccionar un gestor y fechas válidas, luego presionar el botón consultar</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">autorenew</i>Articulaciones por línea y fecha</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m12 l12">
                              <select id="txtlinea_tecnologica" name="txtlinea_tecnologica" style="width: 100%">
                                <option value="">Seleccione la Línea Tecnológica</option>
                                @foreach($lineas as $id => $nombre)
                                  <option value="{{$id}}">{{$nombre}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_Grafico3" name="txtfecha_inicio_Grafico3" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_Grafico3">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_Grafico3" name="txtfecha_fin_Grafico3" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_Grafico3">Fecha Fin</label>
                            </div>
                            <div class="center">
                              <button onclick="consultarArticulacionesDeUnaLineaDelNodoPorFechas_stacked(0);" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoArticulacionesPorLineaYFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar las cantidad de articulaciones por línea, se debe seleccionar una línea tecnológica y fechas válidas, luego presionar el botón CONSULTAR</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">autorenew</i>Articulaciones totales por año</div>
                      <div class="collapsible-body">
                        <div class="row valign-wrapper">
                          <div class="input-field col s12 m4 l4">
                            <select style="width: 100%" name="txtanho_Grafico4" id="txtanho_Grafico4" onchange="consultarTiposDeArticulacionesDelAnho_variablepie({{auth()->user()->dinamizador->nodo_id}})">
                              {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
                              @for ($i=2016; $i <= $year; $i++)
                                <option value="{{ $i }}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                            </select>
                            <label for="txtanho_Grafico4">Seleccione el Año</label>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoArticulacionesPorNodoYAnho_variablepie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
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
    </div>
  </main>
@endsection
@push('script')
  <script>
    $(document).ready(function(){
      consultaArticulacionesDelGestorPorNodoYFecha_stacked({{auth()->user()->dinamizador->nodo_id}});
      consultarTiposDeArticulacionesDelAnho_variablepie({{auth()->user()->dinamizador->nodo_id}});
    });
  </script>
@endpush
