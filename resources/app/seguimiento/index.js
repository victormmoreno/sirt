var graficosSeguimiento = {
  gestor: 'graficoSeguimientoEsperadoPorGestorDeUnNodo_column',
  nodo_esperado: 'graficoSeguimientoDeUnNodo_column',
  tecnoparque_esperado: 'graficoSeguimientoTecnoparque_column',
  nodo_fases: 'graficoSeguimientoDeUnNodoFases_column',
  tecnoparque_fases: 'graficoSeguimientoTecnoparqueFases_column',
  gestor_fases: 'graficoSeguimientoPorGestorFases_column',
  linea_esperado: 'graficoSeguimientoEsperadoPorLineaDeUnNodo_column',
  linea_actual: 'graficoSeguimientoActualPorLineaDeUnNodo_column',
  inscritos_mes: 'graficoSeguimientoInscritosPorMes_column'
};

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una línea tecnológica', 'warning');
};

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un experto', 'warning');
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
};
// 0 para cuando el Dinamizador consultar
// 1 para cuando el experto consulta

function consultarSeguimientoDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoEsperadoDeUnGestor/'+gestor_id,
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.gestor);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

// Bandera
// 0 para dinamizadores y expertos
// 1 para administradores
function consultarSeguimientoEsperadoDeUnaLinea(bandera) {
  let nodo_id = null;
  let linea_id = null;
  if (bandera == 0) {
    linea_id = $('#txtlinea_esperado').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
  } else {
    linea_id = $('#txtlinea_esperado').val();
    nodo_id = $('#txtnodo_linea_esperado').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
    if (nodo_id == '') {
      return alertaNodoNoValido();
    }
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoEsperadoDeUnaLinea/'+linea_id+'/'+nodo_id,
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.linea_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosPorMes(gestor_id) {
  if (gestor_id == null) {
      alertaGestorNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoInscritosPorMesExperto/'+gestor_id,
      success: function (data) {
        console.log(data.datos.meses);
        graficoSeguimientoPorMes(data, graficosSeguimiento.inscritos_mes);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function consultarSeguimientoActualDeUnaLinea(bandera) {
  let nodo_id = null;
  let linea_id = null;
  if (bandera == 0) {
    linea_id = $('#txtlinea_actual').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
  } else {
    linea_id = $('#txtlinea_actual').val();
    nodo_id = $('#txtnodo_linea_actual').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
    if (nodo_id == '') {
      return alertaNodoNoValido();
    }
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoActualDeUnaLinea/'+linea_id+'/'+nodo_id,
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.linea_actual);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarSeguimientoActualDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoActualDeUnGestor/'+gestor_id,
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.gestor_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoEsperadoDeTecnoparque() {
  
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoEsperadoDeTecnoparque/',
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.tecnoparque_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoEsperadoDeUnNodo(nodo_id) {

  if ( nodo_id === "" ) {
    alertaNodoNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoEsperadoDeUnNodo/'+nodo_id,
      success: function (data) {
        graficoSeguimientoEsperado(data, graficosSeguimiento.nodo_esperado);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

function consultarSeguimientoDeUnNodoFases(nodo_id) {
  if ( nodo_id === "" ) {
    alertaNodoNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoDeUnNodoFases/'+nodo_id,
      success: function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

function consultarSeguimientoDeTecnoparqueFases() {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoDeTecnoparqueFases/',
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.tecnoparque_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function graficoSeguimientoEsperado(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos que se encuentran activos'
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
        dataLabels: {
          enabled: true
        },
        data: [
          {
            name: "TRL 6 esperados",
            y: data.datos.Esperado6,
          },
          {
            name: "TRL 7 - 8 esperados",
            y: data.datos.Esperado7_8,
          },
          {
            name: "Total de proyectos activos",
            y: data.datos.Activos,
          },
        ]
      }
    ],
  });
}

function graficoSeguimientoPorMes(data, name) {
  Highcharts.chart(name, {
    title: {
      text: 'Proyectos inscritos por mes en el año actual'
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
  
    // plotOptions: {
    //   series: {
    //     label: {
    //       connectorAllowed: false
    //     },
    //     pointStart: 2010
    //   }
    // },
  
    series: [{
      name: 'Proyectos inscritos',
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

function graficoSeguimientoFases(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos actuales y finalizados en el año actual'
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
        dataLabels: {
          enabled: true
        },
        data: [
          {
            name: "Proyectos en inicio",
            y: data.datos.Inicio,
          },
          {
            name: "Proyectos en planeación",
            y: data.datos.Planeacion,
          },
          {
            name: "Proyectos en ejecución",
            y: data.datos.Ejecucion,
          },
          {
            name: "Proyectos en cierre",
            y: data.datos.Cierre,
          },
          {
            name: "Proyectos finalizados",
            y: data.datos.Finalizado,
          },
          {
            name: "Proyectos suspendidos",
            y: data.datos.Suspendido,
          },
          {
            name: "Total de proyecto en el año actual",
            y: data.datos.Total,
          },
        ]
      }
    ],
  });
}
