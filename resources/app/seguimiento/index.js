var graficosSeguimiento = {
  gestor: 'graficoSeguimientoPorGestorDeUnNodo_column',
  nodo: 'graficoSeguimientoDeUnNodo_column',
  nodo_fases: 'graficoSeguimientoDeUnNodoFases_column',
  gestor_fases: 'graficoSeguimientoPorGestorFases_column'
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

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
};
// 0 para cuando el Dinamizador consultar
// 1 para cuando el gestor consulta

function consultarSeguimientoDeUnGestor(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Gestor').val();
  let fecha_fin = $('#txtfecha_fin_Gestor').val();

  if ( bandera == 1 ) {
    id = $('#txtgestor_id').val();
  }

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

function consultarSeguimientoDeUnGestorFase(bandera) {
  let id = 0;

  if ( bandera == 1 ) {
    id = $('#txtgestor_id_actual').val();
  }

  if ( id === "" ) {
    alertaGestorNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoDeUnGestorFases/'+id,
      success: function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.gestor_fases);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Administrador consulta

function consultarSeguimientoDeUnNodo(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Nodo').val();
  let fecha_fin = $('#txtfecha_fin_Nodo').val();

  if ( bandera == 1 ) {
    id = $('#txtnodo_id').val();
  }

  if ( id === "" ) {
    alertaNodoNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/seguimiento/seguimientoDeUnNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          graficoSeguimiento(data, graficosSeguimiento.nodo);
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      })
    }
  }
};

function consultarSeguimientoDeUnNodoFases(bandera) {
  let id = 0;

  if ( bandera == 1 ) {
    id = $('#txtnodo_id').val();
  }

  if ( id === "" ) {
    alertaNodoNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoDeUnNodoFases/'+id,
      success: function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Administrador consulta
function generarExcelSeguimentoNodo(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Nodo').val();
  let fecha_fin = $('#txtfecha_fin_Nodo').val();

  if ( bandera == 1 ) {
    id = $('#txtnodo_id').val();
  }

  if ( id === "" ) {
    alertaNodoNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      location.href = '/excel/excelSeguimientoDeUnNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }
}

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Gestor consulta
function generarExcelSeguimentoDeUnGestor(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Gestor').val();
  let fecha_fin = $('#txtfecha_fin_Gestor').val();

  if ( bandera == 1 ) {
    id = $('#txtgestor_id').val();
  }

  if ( id === "" ) {
    alertaGestorNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      location.href = '/excel/excelSeguimientoDeUnGestor/'+id+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }
}

function graficoSeguimiento(data, name) {
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
        dataLabels: {
          enabled: true
        },
        data: [
          {
            name: "Proyectos Inscritos",
            y: data.datos.Inscritos,
          },
          {
            name: "TRL 6 esperados",
            y: data.datos.Esperado6,
          },
          {
            name: "TRL 7 - 8 esperados",
            y: data.datos.Esperado7_8,
          },
          {
            name: "Proyectos Cerrados",
            y: data.datos.Cerrados,
          },
          {
            name: "TRL 6 obtenidos",
            y: data.datos.Obtenido6,
          },
          {
            name: "TRL 7 obtenidos",
            y: data.datos.Obtenido7_8,
          },
          {
            name: "TRL 8 obtenidos",
            y: data.datos.Obtenido8,
          },
          {
            name: "Articulaciones con G.I Inscritas",
            y: data.datos.ArticulacionesInscritas,
          },
          {
            name: "Articulaciones con G.I Cerradas",
            y: data.datos.ArticulacionesCerradas,
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
      text: 'Seguimiento (Fases)'
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
            name: "Proyectos en Inicio",
            y: data.datos.ProyectosInicio,
          },
          {
            name: "Proyectos en Planeación",
            y: data.datos.ProyectosPlaneacion,
          },
          {
            name: "Proyectos en Ejecución",
            y: data.datos.ProyectosEjecucion,
          },
          {
            name: "Proyectos en Cierre",
            y: data.datos.ProyectosCierre,
          },
          {
            name: "Articulaciones en Inicio",
            y: data.datos.ArticulacionesInicio,
          },
          {
            name: "Articulaciones en Planeación",
            y: data.datos.ArticulacionesPlaneacion,
          },
          {
            name: "Articulaciones en Ejecución",
            y: data.datos.ArticulacionesEjecucion,
          },
          {
            name: "Articulaciones en Cierre",
            y: data.datos.ArticulacionesCierre,
          },
        ]
      }
    ],
  });
}
