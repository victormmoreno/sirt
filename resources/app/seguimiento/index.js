var graficosSeguimiento = {
  gestor: 'graficoSeguimientoEsperadoPorGestorDeUnNodo_column',
  nodo_esperado: 'graficoSeguimientoDeUnNodo_column',
  nodo_fases: 'graficoSeguimientoDeUnNodoFases_column',
  gestor_fases: 'graficoSeguimientoPorGestorFases_column',
  linea_esperado: 'graficoSeguimientoEsperadoPorLineaDeUnNodo_column',
  linea_actual: 'graficoSeguimientoActualPorLineaDeUnNodo_column'
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
// 1 para cuando el gestor consulta

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

function graficoSeguimientoEsperado(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos que se encuentran abiertos'
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
