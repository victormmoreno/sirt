var ano = (new Date).getFullYear();

var graficosId = {
  grafico1: 'graficoArticulacionesPorGestorYNodoPorFecha_stacked',
  grafico2: 'graficoArticulacionesPorGestorYFecha_stacked',
  grafico3: 'graficoArticulacionesPorLineaYFecha_stacked',
  grafico4: ''
};


function consultaArticulacionesDelGestorPorNodoYFecha_stacked(id) {
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/grafico/consultarArticulacionesPorNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      var tamanho = data.consulta.length;
        // console.log(tamanho);
        var datos = {
          gestores: [],
          gruposArray: [],
          empresasArray: [],
          emprendedoresArray: []
        };
        // console.log(data.tipos);
        for (var i = 0; i < tamanho; i++) {
            // console.log(data.consulta[i].gestor);
            if (data.consulta[i].gestor != null) {
              datos.gestores.push(data.consulta[i].gestor);
            }
          }

          for (var i = 0; i < tamanho; i++) {
            if (data.consulta[i].grupos != null) {
              datos.gruposArray.push(data.consulta[i].grupos);
            }
          }

          for (var i = 0; i < tamanho; i++) {
            if (data.consulta[i].empresas != null) {
              datos.empresasArray.push(data.consulta[i].empresas);
            }
          }
          for (var i = 0; i < tamanho; i++) {
            if (data.consulta[i].emprendedores != null) {
              datos.emprendedoresArray.push(data.consulta[i].emprendedores);
            }
          }

          var dataGraphic = [];

          for (var i = 0; i < tamanho; i++) {
            let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.gruposArray[i]+', '+datos.empresasArray[i]+', '+datos.emprendedoresArray[i]+']}';
            array = JSON.parse(array);
            dataGraphic.push(array);
          }
          Highcharts.chart(graficosId.grafico1, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones ' + ano
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