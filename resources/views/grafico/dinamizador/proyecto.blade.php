@extends('layouts.app')
@section('meta-title', 'Gráficos de Proyectos')
@section('content')
  @php
    $yearNow = Carbon\Carbon::now()->isoFormat('YYYY')
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('grafico')}}">
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
                        <span class="card-title center-align">Gráficos de Proyectos</span>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <ul class="collapsible">
                    <li>
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Proyecto inscritos por año</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="input-field col s12 m4 l4">
                            <select style="width: 100%" name="txtanho_GraficoProyecto1" id="txtanho_GraficoProyecto1" onchange="consultarProyectosInscritosPorAnho_combinate(0, this.value)">
                              @for ($i=2016; $i <= $yearNow; $i++)
                                <option value="{{ $i }}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                            </select>
                            <label for="txtanho_GraficoProyecto1">Seleccione el Año</label>
                            <div class="center col s12 m12 l12">
                              <div class="material-icons">
                                <a onclick="generarExcelGrafico1Proyecto(0)">
                                  <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                                </a>
                              </div>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficosProyectoPorMesYNodo_combinate" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Proyectos inscritos por año con empresas</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m12 l12">
                              <select style="width: 100%" name="txtanho_GraficoProyecto2" id="txtanho_GraficoProyecto2" onchange="consultarProyectosInscritosConEmpresasPorAnho_combinate(0, this.value)">
                                @for ($i=2016; $i <= $yearNow; $i++)
                                  <option value="{{ $i }}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                              </select>
                              <label for="txtanho_GraficoProyecto2">Seleccione el Año</label>
                            </div>
                            <div class="center col s12 m12 l12">
                              <div class="material-icons">
                                <a onclick="generarExcelGrafico2Proyecto(0)">
                                  <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                                </a>
                              </div>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficosProyectoConEmpresaPorMesYNodo_combinate" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              {{-- <div class="row card-panel">
                                <h5 class="center">Para consultar las edts por gestor, se debe seleccionar un gestor y fechas válidas, luego presionar el botón consultar</h5>
                              </div> --}}
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Edt's por línea y fecha</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m12 l12">
                              <select id="txtlinea_id_edtGrafico3" name="txtlinea_id_edtGrafico3" style="width: 100%">
                                <option value="">Seleccione la Línea Tecnológica</option>
                                @foreach($lineas as $id => $nombre)
                                  <option value="{{$id}}">{{$nombre}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_GraficoEdt3" name="txtfecha_inicio_GraficoEdt3" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_GraficoEdt3">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_GraficoEdt3" name="txtfecha_fin_GraficoEdt3" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_GraficoEdt3">Fecha Fin</label>
                            </div>
                            <div class="center">
                              <button onclick="consultarEdtsPorLineaYFecha_stacked()" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoEdtsPorLineaYFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar las cantidad de edts por línea, se debe seleccionar una línea tecnológica y fechas válidas, luego presionar el botón CONSULTAR</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Edt's totales por año</div>
                      <div class="collapsible-body">
                        <div class="row valign-wrapper">
                          <div class="input-field col s12 m4 l4">
                            <select style="width: 100%" name="txtanho_GraficoEdt4" id="txtanho_GraficoEdt4" onchange="consultarEdtsDelNodoPorAnho_variablepie({{ auth()->user()->dinamizador->nodo_id }})">
                              @for ($i=2016; $i <= $yearNow; $i++)
                                <option value="{{ $i }}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                            </select>
                            <label for="txtanho_GraficoEdt4">Seleccione el Año</label>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoEdtsPorNodoYAnho_variablepie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
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
      consultarProyectosInscritosPorAnho_combinate(0, '{{$yearNow}}');
      consultarProyectosInscritosConEmpresasPorAnho_combinate(0, '{{$yearNow}}');
    });
  </script>
@endpush
