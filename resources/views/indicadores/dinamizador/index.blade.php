@extends('layouts.app')
@section('meta-title', 'Indicadores')
@section('content')
  @php
  $now = Carbon\Carbon::now();
  $yearNow = $now->year;
  $monthNow = $now->month;
  @endphp
  <link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          info_outline
                      </i>
                      Indicadores
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Indicadores</li>
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
                        <span class="card-title center-align">Indicadores</span>
                      </div>
                    </div>
                  </div>
                  <ul class="collapsible">
                    <li>
                      <div class="collapsible-header"><i class="material-icons">edit</i>Generar indicadores de proyectos inscritos entre un rango de fechas</div>
                      <div class="collapsible-body">
                        <div class="row card card-panel teal lighten-5">
                          <h6>Para consultar los indicadores ÚNICAMENTE DE PROYECTOS INSCRITOS, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
                          <h6>Recordar que se está mostrando la fase ACTUAL del proyecto.</h6>
                          <div class="input-field col s12 m5 l5">
                            <input type="text" id="txtfecha_inicio_inscritos" name="txtfecha_inicio_inscritos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                            <label for="txtfecha_inicio_inscritos">Fecha Inicio</label>
                          </div>
                          <div class="input-field col s12 m5 l5">
                            <input type="text" id="txtfecha_fin_inscritos" name="txtfecha_fin_inscritos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                            <label for="txtfecha_fin_inscritos">Fecha Fin</label>
                          </div>
                          <div class="center input-field col s12 m2 l2">
                            <a onclick="generarExcelConTodosLosIndicadoresInscritos();" class="btn"><i class="material-icons">file_download</i></a>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">done</i>Generar indicadores de proyectos finalizados y suspendidos entre un rango de fechas</div>
                      <div class="collapsible-body">
                        <div class="row card card-panel teal lighten-5">
                          <h6>Para consultar los indicadores ÚNICAMENTE DE PROYECTOS FINALIZADOS Y SUSPENDIDOS, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
                          <h6>Recordar que se está mostrando la fase ACTUAL del proyecto.</h6>
                          <div class="input-field col s12 m5 l5">
                            <input type="text" id="txtfecha_inicio_cerrados" name="txtfecha_inicio_cerrados" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                            <label for="txtfecha_inicio_cerrados">Fecha Inicio</label>
                          </div>
                          <div class="input-field col s12 m5 l5">
                            <input type="text" id="txtfecha_fin_cerrados" name="txtfecha_fin_cerrados" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                            <label for="txtfecha_fin_cerrados">Fecha Fin</label>
                          </div>
                          <div class="center input-field col s12 m2 l2">
                            <a onclick="generarExcelConTodosLosIndicadoresFinalizados();" class="btn"><i class="material-icons">file_download</i></a>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">play_arrow</i>Generar indicadores de proyectos activos</div>
                      <div class="collapsible-body">
                        <div class="row card card-panel teal lighten-5">
                          <h6>Para consultar los indicadores ÚNICAMENTE DE PROYECTOS EN FASE DE INICIO, PLANEACIÓN, EJECUCIÓN Y CIERRE, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
                          <h6>Recordar que se está mostrando la fase ACTUAL del proyecto.</h6>
                          <div class="center input-field col s12 m2 l2">
                            <a onclick="generarExcelConTodosLosIndicadoresActuales();" class="btn">Descargar<i class="material-icons right">file_download</i></a>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">done_all</i>Generar todos</div>
                      <div class="collapsible-body">
                        <div class="row card card-panel teal lighten-5">
                          <h6>Para consultar TODOS los indicadores, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
                          <h6>Recordar que se está mostrando la fase ACTUAL del proyecto.</h6>
                          <div class="input-field col s12 m5 l5">
                            <input type="text" id="txtfecha_inicio_todos" name="txtfecha_inicio_todos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                            <label for="txtfecha_inicio_todos">Fecha Inicio</label>
                          </div>
                          <div class="input-field col s12 m5 l5">
                            <input type="text" id="txtfecha_fin_todos" name="txtfecha_fin_todos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                            <label for="txtfecha_fin_todos">Fecha Fin</label>
                          </div>
                          <div class="center input-field col s12 m2 l2">
                            <a onclick="generarExcelConTodosLosIndicadores(0);" class="btn"><i class="material-icons">file_download</i></a>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">assignment</i>Metas del nodo</div>
                      <div class="collapsible-body">
                        @include('indicadores.componentes.metas')
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
    function generarExcelConTodosLosIndicadores(bandera) {
      let idnodo = 0;
      let fecha_inicio = $('#txtfecha_inicio_todos').val();
      let fecha_fin = $('#txtfecha_fin_todos').val();
      if (bandera == 1) {
        idnodo = $('#txtnodo_id').val();
      }

      if (idnodo === '') {
        Swal.fire('Error!', 'Seleccione un nodo', 'error');
      } else {
        if (fecha_inicio > fecha_fin) {
          Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
        } else {
          location.href = '/excel/export/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/all';
        }
      }
    }
    function generarExcelConTodosLosIndicadoresFinalizados() {
      let idnodo = 0;
      let fecha_inicio = $('#txtfecha_inicio_cerrados').val();
      let fecha_fin = $('#txtfecha_fin_cerrados').val();

        if (fecha_inicio > fecha_fin) {
          Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
        } else {
          location.href = '/excel/export_proyectos_finalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/all';
        }
    }
    function generarExcelConTodosLosIndicadoresInscritos() {
      let idnodo = 0;
      let fecha_inicio = $('#txtfecha_inicio_inscritos').val();
      let fecha_fin = $('#txtfecha_fin_inscritos').val();
      if (fecha_inicio > fecha_fin) {
        Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
      } else {
        location.href = '/excel/export_proyectos_inscritos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/all';
      }
    }
    function generarExcelConTodosLosIndicadoresActuales() {
      let idnodo = 0;
      location.href = '/excel/export_proyectos_actuales/'+idnodo+'/all';
    }
    @if($metas_graph != null)
    Highcharts.chart('container', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Metas para la vigencia actual'
      },
      xAxis: {
          categories: ['{{$metas_graph->nodo->entidad->nombre}}']
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Cantidad de proyectos'
          },
          stackLabels: {
              enabled: true,
              style: {
                  fontWeight: 'bold',
                  color: (
                      Highcharts.defaultOptions.title.style &&
                      Highcharts.defaultOptions.title.style.color
                  ) || 'gray'
              }
          }
      },
      legend: {
          align: 'right',
          x: -30,
          verticalAlign: 'top',
          y: 25,
          floating: true,
          backgroundColor:
              Highcharts.defaultOptions.legend.backgroundColor || 'white',
          borderColor: '#CCC',
          borderWidth: 1,
          shadow: false
      },
      plotOptions: {
          column: {
              stacking: 'normal',
              dataLabels: {
                  enabled: true
              }
          }
      },
      series: [{
          name: 'TRL6 obtenido (Finalizados)',
          data: [{{$metas_graph->trl6_obtenido}}]
      }, {
          name: 'TRL7 y TRL8 obtenido (Finalizados)',
          data: [{{$metas_graph->trl7_8_obtenido}}]
      },{
          type: 'spline',
          name: 'Meta de proyectos',
          data: [{{$metas_graph->trl6 + $metas_graph->trl7_trl8}}],
          visible: false,
          marker: {
              lineWidth: 2,
              lineColor: Highcharts.getOptions().colors[3],
              fillColor: 'white'
          }
      }]
  });
  @endif
  </script>
@endpush
