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
    exampleArticulaciones({{auth()->user()->dinamizador->nodo_id}});
  });
  function exampleArticulaciones(id) {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/grafico/consultarArticulacionesPorNodo/'+id,
      success: function (data) {
        Highcharts.chart('container', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Articulaciones'
          },
          xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas'],
            title: {
              text: 'Gestores'
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
          series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
          }, {
            name: 'Jane',
            data: [2, 2, 3, 2, 1]
          }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
          }]
        });
      },
    });
  }

</script>
@endpush
