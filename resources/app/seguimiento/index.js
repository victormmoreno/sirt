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
  Swal.fire('Advertencia!', 'Seleccione por lo menos un nodo', 'warning');
};
// 0 para cuando el Dinamizador consultar
// 1 para cuando el experto consulta

function consultarSeguimientoDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoEsperadoDeUnGestor/'+gestor_id,
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
    url: host_url + '/seguimiento/seguimientoEsperadoDeUnaLinea/'+linea_id+'/'+nodo_id,
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
      url: host_url + '/seguimiento/seguimientoInscritosPorMesExperto/'+gestor_id,
      success: function (data) {
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
    url: host_url + '/seguimiento/seguimientoActualDeUnaLinea/'+linea_id+'/'+nodo_id,
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
    url: host_url + '/seguimiento/seguimientoActualDeUnGestor/'+gestor_id,
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
    url: host_url + '/seguimiento/seguimientoEsperadoDeTecnoparque/',
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.tecnoparque_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoDeTecnoparqueFases() {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoDeTecnoparqueFases/',
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.tecnoparque_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function graficoSeguimientoEsperado(data, name) {
  let nodos = [];
  let trl6 = [];
  let trl7_8 = [];
  data.datos.forEach(element => {
    nodos.push(element.nodo);
    trl6.push(element.trl6);
    trl7_8.push(element.trl7_8);
  });
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos que se encuentran activos'
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
              color: ( // theme
                  Highcharts.defaultOptions.title.style &&
                  Highcharts.defaultOptions.title.style.color
              ) || 'gray',
              textOutline: 'none'
          }
      }
    },
    xAxis: {
      title: {
        text: 'Nodos'
      },
      categories: nodos
    },
    legend: {
      align: 'left',
      x: 70,
      verticalAlign: 'top',
      y: 20,
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
        name: 'TRL 6 esperado',
        data: trl6
    }, {
        name: 'TRL 7 y 8 esperado',
        data: trl7_8
    }]
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
  let nodos = [];
  let inicio = [];
  let planeacion = [];
  let ejecucion = [];
  let cierre = [];
  let finalizado = [];
  let suspendido = [];
  data.datos.forEach(element => {
    nodos.push(element.nodo);
    inicio.push(element.inicio);
    planeacion.push(element.planeacion);
    ejecucion.push(element.ejecucion);
    cierre.push(element.cierre);
    finalizado.push(element.finalizado);
    suspendido.push(element.suspendido);
  });
  Highcharts.chart(name, {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Proyectos actuales y finalizados en el año actual'
    },
    xAxis: {
        title: {
          text: 'Nodos'
        },
        categories: nodos
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
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray',
                textOutline: 'none'
            }
        }
    },
    legend: {
        align: 'left',
        x: 70,
        verticalAlign: 'top',
        y: 20,
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
        name: 'Inicio',
        data: inicio
    }, {
        name: 'Planeación',
        data: planeacion
    }, {
        name: 'Ejecución',
        data: ejecucion
    }, {
      name: 'Cierre',
      data: cierre
    }, {
      name: 'Finalizado',
      data: finalizado
    }, {
      name: 'Concluido sin finalizar',
      data: suspendido
    }]
});
}
