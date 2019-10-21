var graficosCostos = {
  actividad: 'costosDeUnProyecto_column'
};

function consultarCostoDeUnaActividad() {
  // graficoCostos(0, graficosCostos.actividad);
  let id = $('#txtactividad_id').val();
  if (id === '') {
    Swal.fire('Advertencia!', 'Seleccione una actividad', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/costos/costosDeUnaActividad/'+id,
      success: function (data) {
        graficoCostos(data, graficosCostos.actividad);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function graficoCostos(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Seguimiento'
    },
    yAxis: {
      title: {
        text: '$ Pesos'
      },
      labels: {
        format: '$ {value}'
      }
    },
    xAxis: {
        type: 'category'
    },
    legend: {
        enabled: false,
        floating: true,
    },
    tooltip: {
      headerFormat: '<span style="font-size:11px">Costos</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y}</b><br/>'
    },
    plotOptions: {
      series: {
        dataLabels: {
          enabled: true
        },
        animationLimit: 1000
      },
    },
    series: [
      {
        colorByPoint: true,
        data: [
          {
            name: "Costos de Asesorias",
            y: 25,
          },
          {
            name: "Costos de Equipos",
            y: 20,
          },
          {
            name: "Costos Administrativos",
            y: 30,
          },
          {
            name: "Total de Costos",
            y: 75,
          },
        ]
      }
    ],
  });
}
