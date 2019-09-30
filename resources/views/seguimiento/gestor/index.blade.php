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
          <h5><i class="material-icons">search</i>Seguimiento</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    {{-- <li class="tab col s3"><a class="" href="#tecnoparque">Tecnoparque</a></li>  --}}
                    <li class="tab col s3"><a class="" href="#gestor">Gestor</a></li>
                    {{-- <li class="tab col s3"><a class="" href="#linea">Línea</a></li> --}}
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
  var graficosSeguimiento = {
    gestor: 'graficoSeguimientoPorGestorDeUnNodo_column'
  };

  function alertaLineaNoValido() {
    Swal.fire('Advertencia!', 'Seleccione una Línea Tecnológica', 'warning');
  };

  function alertaGestorNoValido() {
    Swal.fire('Advertencia!', 'Seleccione un Gestor', 'warning');
  };

  function alertaFechasNoValidas() {
    Swal.fire('Advertencia!', 'Seleccione fechas válidas', 'warning');
  };
  // 1 para cuando el Dinamizador consultar
  // 0 para cuando el gestor consulta

  function consultarSeguimientoDeUnGestor(bandera) {
    let id = 0;
    let fecha_inicio = $('#txtfecha_inicio_Gestor').val();
    let fecha_fin = $('#txtfecha_fin_Gestor').val();

    if ( bandera == 1 ) {
      id = $('#txtgestor_id').val();
    }
    console.log(id);
    if ( id === "" ) {
      alertaGestorNoValido();
    } else {
      if ( fecha_inicio > fecha_fin ) {
        alertaFechasNoValidas();
      } else {
        $.ajax({
          dataType: 'json',
          type: 'get',
          url: '/seguimiento/seguimientoDeUnGestor/'+id+'/'+fecha_inicio+'/'+fecha_fin,
          success: function (data) {
            graficoSeguimiento(data, graficosSeguimiento.gestor);
          },
          error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
          },
        })
      }
    }
  };

  function graficoSeguimiento(data, name) {
    console.log(data.datos.Inicio);
    Highcharts.chart(name, {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Seguimiento'
      },
      yAxis: {
        title: {
          text: 'Cantidad'
        }
      },
      xAxis: {
        type: 'category'
      },
      legend: {
        enabled: false
      },
      tooltip: {
        headerFormat: '<span style="font-size:11px">Cantidad</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
      },
      series: [
      {
        colorByPoint: true,
        data: [
        {
          name: "Proyectos en Inicio",
          y: data.datos.Inicio,
        },
        {
          name: "Proyectos en Planeación",
          y: data.datos.Planeacion,
        },
        {
          name: "Proyectos en Ejecución",
          y: data.datos.Ejecucion,
        },
        {
          name: "Proyectos en Cierre PF",
          y: data.datos.CierrePF,
        },
        {
          name: "Proyectos en Cierre PMV",
          y: data.datos.CierrePMV,
        },
        {
          name: "Articulaciones con Grupo de Investigación",
          y: data.datos.ArticulacionesGI,
        },
        {
          name: "Articulaciones con Grupo de Empresas",
          y: data.datos.ArticulacionesEmp,
        }
        ]
      }
      ],
    });
  }

</script>
@endpush
