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
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                    <a class="footer-text left-align" href="{{route('grafico')}}">
                      <i class="left material-icons">arrow_back</i>
                    </a> Gráficos
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('grafico')}}">Gráficos</a></li>
                      <li class="active">Proyectos</li>
                  </ol>
              </div>
          </div>
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
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Proyectos inscritos por año</div>
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
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Proyectos inscritos por tipo de proyecto</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_GraficoProyecto3" name="txtfecha_inicio_GraficoProyecto3" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_GraficoProyecto3">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_GraficoProyecto3" name="txtfecha_fin_GraficoProyecto3" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_GraficoProyecto3">Fecha Fin</label>
                            </div>
                            <div class="center">
                              <button onclick="consultarProyectosInscritosPorTipoNodoYFecha_column(0)" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoProyectosPorTipoNodoYFecha_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar la cantidad de proyectos por tipo de proyecto, se deben seleccionar fechas válidas y luego presionar el botón CONSULTAR</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Proyectos finalizados por año</div>
                      <div class="collapsible-body">
                        <div class="row valign-wrapper">
                          <div class="input-field col s12 m4 l4">
                            <select style="width: 100%" name="txtanho_GraficoProyecto4" id="txtanho_GraficoProyecto4" onchange="consultarProyectosFinalizadosPorAnho_combinate(0, this.value)">
                              @for ($i=2016; $i <= $yearNow; $i++)
                                <option value="{{ $i }}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                            </select>
                            <label for="txtanho_GraficoProyecto4">Seleccione el Año</label>
                            <div class="center col s12 m12 l12">
                              <div class="material-icons">
                                <a onclick="generarExcelGrafico4Proyecto(0)">
                                  <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                                </a>
                              </div>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoProyectosFinalizadosPorNodoYAnho_column" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">library_books</i>Proyectos finalizados por tipo de proyecto</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_GraficoProyecto5" name="txtfecha_inicio_GraficoProyecto5" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_GraficoProyecto5">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_GraficoProyecto5" name="txtfecha_fin_GraficoProyecto5" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_GraficoProyecto5">Fecha Fin</label>
                            </div>
                            <div class="center">
                              <button onclick="consultarProyectosFinalizadosPorTipoNodoYFecha_column(0)" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoProyectosFinalizadosPorTipoNodoYFecha_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar la cantidad de proyectos por tipo de proyecto, se deben seleccionar fechas válidas y luego presionar el botón CONSULTAR</h5>
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
