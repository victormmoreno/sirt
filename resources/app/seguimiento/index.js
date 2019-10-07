var graficosSeguimiento = {
  gestor: 'graficoSeguimientoPorGestorDeUnNodo_column',
  nodo: 'graficoSeguimientoDeUnNodo_column'
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

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Administrador consulta

function consultarSeguimientoDeUnNodo(bandera) {
  console.log('ddd');
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
        data: [
          {
            name: "Proyectos en Inicio",
            y: data.datos.Inicio,
          },
          {
            name: "Proyectos en Planeación",
            y: data.datos.Planeacion,
          },
          {
            name: "Proyectos en Ejecución",
            y: data.datos.Ejecucion,
          },
          {
            name: "Proyectos en Cierre PF",
            y: data.datos.CierrePF,
          },
          {
            name: "Proyectos en Cierre PMV",
            y: data.datos.CierrePMV,
          },
          {
            name: "Proyectos Suspendidos",
            y: data.datos.Suspendido,
          },
          {
            name: "Articulaciones con Grupo de Investigación",
            y: data.datos.ArticulacionesGI,
          },
          {
            name: "Articulaciones con Empresas",
            y: data.datos.ArticulacionesEmp,
          },
          {
            name: "Edts",
            y: data.datos.Edts,
          }
        ]
      }
    ],
  });
}
