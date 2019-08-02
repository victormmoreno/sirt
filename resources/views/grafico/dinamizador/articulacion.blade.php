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

        console.log(datos.articulaciones);

        var dataGraphic = [];

        for (var i = 0; i < tamanho; i++) {
          let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.articulaciones[i]+', '+datos.articulacionesb[i]+', '+datos.articulacionesc[i]+']}';
          // var part2 = '{"name": "datos", "data": [5, 5, 5]}';
          array = JSON.parse(array);
          dataGraphic.push(array);
        }
        // part2 = JSON.parse(part2);
        // console.log();
        // dataGraphic.push(part2);
        // var part1 = true ? dataGraphic.push(JSON.parse("{name: 'datos.gestores', data: ['50', '10', '10']},")) : '';
        // var part1 = true ? dataGraphic += "{name: 'datos.gestores'}}, {data: [ '50', '10', '10']}," : '';
        // var parte2 = true ? dataGraphic.push(JSON.parse("{name: 'datos', data: ['1', '1', '1']},")) : '';

        var resulta =  [{
          name: 'John',
          data: [5, 3, 4, 7, 2]
        }, {
          name: 'Jane',
          data: [2, 2, 3, 2, 1]
        }, {
          name: 'Joe',
          data: [3, 4, 4, 2, 5]
        }]

        // dataGraphic = Object.assign({}, dataGraphic);
        // console.log();

        // dataGraphic = [
        //   dataGraphic
        //   // {data: [
        //   //   '50', '10', '10'
        //   // ]},
        // ]

        // dataGraphic += [
        //   {name: 'datos'},
        //   {data: [
        //     '50', '10', '10'
        //   ]},
        // ]

        console.log(dataGraphic);
        // console.log(resulta);

        // console.log(datos.articulaciones);
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
