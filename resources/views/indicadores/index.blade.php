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
                    <h5 class="left left-align primary-text">
                        <i class="material-icons left primary-text">
                            info_outline
                        </i>
                        Indicadores
                    </h5>
                        <div class="right-align show-on-large hide-on-med-and-down">
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
                            <div class="center-align primary-text">
                                <span class="card-title center-align">Indicadores</span>
                            </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        @can('insert_metas', App\Models\MetaNodo::class)
                            <div class="row">
                            <div class="col s12 m4 l4 offset-m8 offset-l8">
                                <a href="{{route('indicadores.form.metas')}}" class="bg-secondary btn right show-on-large hide-on-med-and-down">Registrar metas</a>
                            </div>
                            </div>
                        @endcan
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <ul class="tabs">
                                    <li class="tab col s3"><a href="#files">Archivos planos</a></li>
                                    <li class="tab col s3"><a href="#graphs">Gráficos</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="files">
                            @include('indicadores.indicadores')
                        </div>
                        <div id="graphs">
                            @include('indicadores.graficas')
                        </div>
                        <div class="divider"></div>
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
      function consultarProyectosInscritosMes(e, rt) {
        e.preventDefault();
        $.ajax({
          dataType: 'json',
          type: 'get',
          url: host_url + '/' + rt,
          data: {
            nodos: $("#txtnodo_select_inscritos_mes").val(),
            expertos: $("#txtexperto_inscritos").val(),
          },
          success: function (data) {
            graficoSeguimientoPorMes(data, graficosSeguimiento.inscritos_mes);
          },
          error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
          },
        })
      }

      function consultarProyectosCerradosMes(e, rt) {
        e.preventDefault();
        $.ajax({
          dataType: 'json',
          type: 'get',
          url: host_url + '/' + rt,
          data: {
            nodos: $("#txtnodo_select_cerrados_mes").val(),
            expertos: $("#txtexperto_cerrados").val(),
          },
          success: function (data) {
            graficoSeguimientoCerradoPorMes(data, 'graficoSeguimientoCerradosPorMes_column');
          },
          error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
          },
        })
      }

      function graficoSeguimientoCerradoPorMes(data, name) {
        Highcharts.chart(name, {
          title: {
            text: 'Proyectos cerrados por mes en el año actual'
          },
          subtitle: {
            text: 'Cuando el mes no aparece es porque el valor es cero(0)'
          },
          yAxis: {
            title: {
              text: 'Cantidad de proyectos'
            }
          },
          xAxis: {
            categories: data.datos.meses,
            accessibility: {
              rangeDescription: 'Mes'
            }
          },
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
          },
          series: [{
            name: 'Proyectos cerrados',
            data: data.datos.cantidades
          }],
        
          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: 'horizontal',
                  align: 'center',
                  verticalAlign: 'bottom'
                }
              }
            }]
          }
        });
      }

      $(document).ready(function(){
        $('#TableEsperado').pageMe({
            pagerSelector:'#PagerEsperado',
            activeColor: 'blue',
            prevText:'Anterior',
            nextText:'Siguiente',
            showPrevNext:true,
            hidePageNumbers:false,
            perPage:5
        });
        $('#TableActual').pageMe({
            pagerSelector:'#PagerActual',
            activeColor: 'blue',
            prevText:'Anterior',
            nextText:'Siguiente',
            showPrevNext:true,
            hidePageNumbers:false,
            perPage:5
        });
      });
    </script>
@endpush
