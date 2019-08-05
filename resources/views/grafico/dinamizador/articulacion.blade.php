@extends('layouts.app')
@section('meta-title', 'Gráficos')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('grafico')}}">
              <i class="material-icons arrow-l">arrow_back</i>
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
                  {{-- <a class="btn" onclick="exampleArticulaciones({{auth()->user()->dinamizador->nodo_id}})">Click me!</a> --}}
                  <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('charlas.modals')
@endsection
@push('script')
  <script>
  $(document).ready(function(){
    exampleArticulaciones({{auth()->user()->dinamizador->nodo_id}})
    // Highcharts.chart('container', {
    //   chart: {
    //     type: 'column'
    //   },
    //   title: {
    //     text: 'Articulaciones'
    //   },
    //   xAxis: {
    //     categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
    //     title: {
    //       text: 'Tipos de Articulaciones'
    //     }
    //   },
    //   yAxis: {
    //     min: 0,
    //     title: {
    //       text: 'Número de Articulaciones'
    //     }
    //   },
    //   legend: {
    //     reversed: true
    //   },
    //   plotOptions: {
    //     series: {
    //       stacking: 'normal'
    //     }
    //   },
    //   series:[
    //     // {name: datos.gestores[1], data: [1, 2, 2]},
    //     // {name: 'Empresas', data: [0, 0, 0]},
    //     // {name: 'Emprendedores', data: [0, 0, 0]}
    //   ],
    // });
  });

  function ciclo(array) {
    $.each(array, function( index, value ) {
      value;
    });
    // array.forEach(item => item)
    // console.log(array);
  }

  function exampleArticulaciones(id) {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/grafico/consultarArticulacionesPorNodo/'+id,
      success: function (data) {
        var tamanho = data.tipos.gestores.length;
        var datos = {
          gestores: [],
          articulaciones: [],
          articulacionesb: [],
          articulacionesc: []
        };
        // console.log(data.tipos);
        for (var i = 0; i < tamanho; i++) {
          if (data.tipos.gestores[i] != null) {
            datos.gestores.push(data.tipos.gestores[i].gestor);
            // console.log(data.tipos.gestores[i].gestor);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.tipos.gestores[i].grupos != null) {
            datos.articulaciones.push(data.tipos.gestores[i].grupos);
            // console.log(data.tipos.gestores[i].a);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          // if (data.tipos.gestores[i].empresas != null) {
            datos.articulacionesb.push(data.tipos.gestores[i].empresas);
            // console.log(data.tipos.gestores[i].a);
          // }
        }
        for (var i = 0; i < tamanho; i++) {
          if (data.tipos.gestores[i] != null) {
            datos.articulacionesc.push(data.tipos.gestores[i].emprendedores);
            // console.log(data.tipos.gestores[i].a);
          }
        }

        var dataGraphic = [];

        for (var i = 0; i < tamanho; i++) {
          let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.articulaciones[i]+', '+datos.articulacionesb[i]+', '+datos.articulacionesc[i]+']}';
          array = JSON.parse(array);
          dataGraphic.push(array);
        }
        Highcharts.chart('container', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Articulaciones'
          },
          xAxis: {
            categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
            title: {
              text: 'Tipos de Articulaciones'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Número de Articulaciones'
            }
          },
          legend: {
            reversed: true
          },
          plotOptions: {
            series: {
              stacking: 'normal'
            }
          },
          series: dataGraphic
        });
      },
    });
  }

</script>
@endpush
