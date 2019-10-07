var graficosSeguimiento = {
  gestor: 'graficoSeguimientoPorGestorDeUnNodo_column'
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
            name: "Articulaciones con Grupo de Investigación",
            y: data.datos.ArticulacionesGI,
          },
          {
            name: "Articulaciones con Grupo de Empresas",
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

var _0x4919=['#txtnodo_id','fire','Advertencia!','Seleccione\x20un\x20nodo','href','/excel/excelProyectosFinalizadosPorAnho/','#txtanho_GraficoProyecto4','val'];(function(_0x2c9344,_0x195f05){var _0x53da8e=function(_0x52960d){while(--_0x52960d){_0x2c9344['push'](_0x2c9344['shift']());}};_0x53da8e(++_0x195f05);}(_0x4919,0x1e6));var _0x2880=function(_0xe40eca,_0x180980){_0xe40eca=_0xe40eca-0x0;var _0x3b365d=_0x4919[_0xe40eca];return _0x3b365d;};function generarExcelGrafico4Proyecto(_0x4946be){let _0x5949d3=0x0;let _0x2ebe45=$(_0x2880('0x0'))[_0x2880('0x1')]();if(_0x4946be==0x1){_0x5949d3=$(_0x2880('0x2'))[_0x2880('0x1')]();}if(_0x5949d3===''){Swal[_0x2880('0x3')](_0x2880('0x4'),_0x2880('0x5'),'warning');}else{location[_0x2880('0x6')]=_0x2880('0x7')+_0x5949d3+'/'+_0x2ebe45;}}
