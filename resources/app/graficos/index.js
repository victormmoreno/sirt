$(document).ready(function(){});
var ano = (new Date).getFullYear();

var graficosId = {
  grafico1: 'graficoArticulacionesPorGestorYNodoPorFecha_stacked',
  grafico2: 'graficoArticulacionesPorGestorYFecha_stacked',
  grafico3: 'graficoArticulacionesPorLineaYFecha_stacked',
  grafico4: 'graficoArticulacionesPorNodoYAnho_variablepie'
};

var graficosEdtId = {
  grafico1: 'graficosEdtsPorGestorNodoYFecha_stacked',
  grafico2: 'graficosEdtsPorGestorYFecha_stacked',
  grafico3: 'graficoEdtsPorLineaYFecha_stacked',
  grafico4: 'graficoEdtsPorNodoYAnho_variablepie'
};

var graficosProyectoId = {
  grafico1: 'graficosProyectoPorMesYNodo_combinate',
  grafico2: 'graficosProyectoConEmpresaPorMesYNodo_combinate',
  grafico3: 'graficoProyectosPorTipoNodoYFecha_column',
  grafico4: 'graficoProyectosFinalizadosPorNodoYAnho_column',
  grafico5: 'graficoProyectosFinalizadosPorTipoNodoYFecha_column'
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
}

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un experto', 'warning');
}

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una Línea Tecnológica', 'warning');
}

function alertaFechasNoValidas() {
  Swal.fire('Advertencia!', 'Seleccione fechas válidas!', 'warning');
}

function generarExcelGrafico3Edt(bandera) {
  let idnodo = 0;
  let idlinea = $('#txtlinea_id_edtGrafico3').val();
  let fecha_inicio = $('#txtfecha_inicio_GraficoEdt3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoEdt3').val();

  if ( bandera == 1 ) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    alertaNodoNoValido();
  } else {
    if ( idlinea === '' ) {
      alertaLineaNoValido();
    } else {
      location.href = '/excel/excelEdtsFinalizadasPorLineaNodoYFecha/'+idnodo+'/'+idlinea+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }

}

function generarExcelGrafico2Edt(bandera) {
  let id = 0;

  if (bandera == 0) {
    id = $('#txtgestor_id_edtGrafico2').val();
  }

  let fecha_inicio = $('#txtfecha_inicio_edtGrafico2').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico2').val();

  if (id === '') {
    alertaGestorNoValido();
  } else {
    location.href = '/excel/excelEdtsFinalizadasPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico1Edt(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico1').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelEdtsFinalizadasPorFechaYNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}


function generarExcelGrafico1Articulacion(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorFechaYNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico3Articulacion(bandera) {
  let id = 0;
  let linea = $('#txtlinea_tecnologica').val();
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    if (linea === '') {
      alertaLineaNoValido();
    } else {
      location.href = '/excel/excelArticulacionFinalizadasPorFechaNodoYLinea/'+id+'/'+linea+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }

}

function generarExcelGrafico2Articulacion() {
  let id = $('#txtgestor_id').val();
  let fecha_inicio = $('#txtfecha_inicio_Grafico2').val();
  let fecha_fin = $('#txtfecha_fin_Grafico2').val();

  if (id === '') {
    alertaGestorNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico4Articulacion(bandera) {
  let id = 0;
  let anho = $('#txtanho_Grafico4').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorNodoYAnho/'+id+'/'+anho;
  }

}

function generarExcelGrafico1Proyecto(bandera) {
  let id = 0;
  let anho = $('#txtanho_GraficoProyecto1').val();
  if (bandera == 1) {
    id = $('#txtnodo_excelGrafico1Proyecto').val();
  }
  location.href = '/excel/excelProyectosInscritosPorAnho/'+id+'/'+anho
}

function generarExcelGrafico2Proyecto(bandera) {
  let id = 0;
  let anho = $('#txtanho_GraficoProyecto2').val();
  if (bandera == 1) {
    id = $('#txtnodo_excelGrafico2Proyecto').val();
  }
  location.href = '/excel/excelProyectosInscritosConEmpresasPorAnho/'+id+'/'+anho
}

function graficosProyectosPromedioCantidadesMeses(data, name) {
  let tamanho = data.proyectos.cantidades.length;
  let datos = {
    cantidades: [],
    meses: [],
    promedios: []
  };
  for (let i = 0; i < tamanho; i++) {
    datos.cantidades.push(data.proyectos.cantidades[i]);
  }
  for (let i = 0; i < tamanho; i++) {
    datos.meses.push(data.proyectos.meses[i]);
  }
  for (let i = 0; i < tamanho; i++) {
    datos.promedios.push(data.proyectos.promedios[i]);
  }
  Highcharts.chart(name, {
    title: {
      text: 'Proyectos Inscritos'
    },
    yAxis: {
      title: {
        text: 'Cantidad/Promedio'
      }
    },
    xAxis: {
      categories: datos.meses,
      title: {
        text: 'Meses'
      }
    },
    series: [{
      type: 'column',
      name: 'Proyectos Inscritos',
      data: datos.cantidades
    }, {
      type: 'spline',
      name: 'Proyectos Inscritos',
      data: datos.cantidades,
      dataLabels: {
        enabled: true
      },
      marker: {
        lineWidth: 2,
        lineColor: '#008981',
        fillColor: '#008981'
      }
    }]
  });
}

function graficosProyectosAgrupados(data, name, name_label) {
  let tamanho = data.proyectos.cantidades.length;
  let datos = {
    cantidades: [],
    labels: [],
  };
  for (let i = 0; i < tamanho; i++) {
    datos.cantidades.push(data.proyectos.cantidades[i]);
  }

  for (let i = 0; i < tamanho; i++) {
    datos.labels.push(data.proyectos.labels[i]);
  }

  Highcharts.chart(name, {
    title: {
      text: 'Proyectos Inscritos'
    },
    yAxis: {
      title: {
        text: 'Cantidad'
      }
    },
    xAxis: {
      categories: datos.labels,
      title: {
        text: name_label
      }
    },
    series: [{
      type: 'column',
      name: 'Proyectos Inscritos',
      data: datos.cantidades
    }, {
      type: 'spline',
      name: 'Proyectos Inscritos',
      data: datos.cantidades,
      dataLabels: {
        enabled: true
      },
      marker: {
        lineWidth: 2,
        lineColor: '#008981',
        fillColor: '#008981'
      }
    }]
  });
}

function consultarProyectosFinalizadosPorTipoNodoYFecha_column(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_GraficoProyecto5').val();
  let fecha_fin = $('#txtfecha_fin_GraficoProyecto5').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if ( fecha_inicio > fecha_fin ) {
    alertaFechasNoValidas();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarProyectosFinalizadosPorTipoNodoYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
      success: function (data) {
        graficosProyectosAgrupados(data, graficosProyectoId.grafico5, 'Tipo de Proyecto');
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function consultarProyectosInscritosPorTipoNodoYFecha_column(bandera) {

  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_GraficoProyecto3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoProyecto3').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosInscritosPorTipoNodoYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      graficosProyectosAgrupados(data, graficosProyectoId.grafico3, 'Tipo de Proyecto');
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })

}


function consultarProyectosFinalizadosPorAnho_combinate(bandera) {
  id = 0;
  let anho = $('#txtanho_GraficoProyecto4').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosFinalzadosPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico4);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosConEmpresasPorAnho_combinate(bandera, anho) {
  id = 0;
  if (bandera == 1) {
    id = $('#txtnodo_proyectoGrafico1');
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosInscritosConEmpresasPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico2);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosPorAnho_combinate(bandera, anho) {
  id = 0;
  if (bandera == 1) {
    id = $('#txtnodo_proyectoGrafico1');
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosInscritosPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico1);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarEdtsDelNodoPorAnho_variablepie(bandera) {
  let anho = $('#txtanho_GraficoEdt4').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarEdtsPorNodoYAnho/'+idnodo+'/'+anho,
      success: function (data) {
        Highcharts.chart(graficosEdtId.grafico4, {
          chart: {
            type: 'variablepie'
          },
          title: {
            text: 'Tipos de Edt\'s.'
          },
          plotOptions: {
            variablepie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                connectorColor: 'silver'
              }
            }
          },
          tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad: <b>{point.y}</b><br/>'
          },
          series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: '',
            data: [
              { name: 'Tipo 1', y: data.consulta.tipo1, z: 15 },
              { name: 'Tipo 2', y: data.consulta.tipo2, z: 15 },
              { name: 'Tipo 3', y: data.consulta.tipo3, z: 15 }
            ]
          }]
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })

  }
}

function consultarEdtsPorLineaYFecha_stacked(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  let fecha_inicio = $('#txtfecha_inicio_GraficoEdt3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoEdt3').val();
  let id = $('#txtlinea_id_edtGrafico3').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona una Línea Tecnológica!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarEdtsPorLineaYFecha/'+id+'/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          Highcharts.chart(graficosEdtId.grafico3, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Tipos de Edt\'s'
            },
            xAxis: {
              categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
              title: {
                text: 'Tipos de Edt\'s'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Edt\'s'
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
            series: [{name: data.consulta.lineatecnologica, data: [data.consulta.tipo1, data.consulta.tipo2, data.consulta.tipo3]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

function consultarEdtsPorGestorYFecha_stacked(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico2').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico2').val();
  let id = $('#txtgestor_id_edtGrafico2').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona un experto!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarEdtsPorGestorYFecha/'+id+'/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          Highcharts.chart(graficosEdtId.grafico2, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Tipos de Edt\'s'
            },
            xAxis: {
              categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
              title: {
                text: 'Tipos de Edt\'s'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Edt\'s'
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
            series: [{name: data.consulta.gestor, data: [data.consulta.tipo1, data.consulta.tipo2, data.consulta.tipo3]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

function consultarEdtsPorNodoGestorYFecha_stacked(bandera) {
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico1').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico1').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (fecha_inicio > fecha_fin) {
    Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarEdtsPorNodoGestorYFecha/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
      success: function (data) {
        var tamanho = data.consulta.length;
        var datos = {
          gestores: [],
          tipo1Array: [],
          tipo2Array: [],
          tipo3Array: []
        };
        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].gestor != null) {
            datos.gestores.push(data.consulta[i].gestor);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos1 != null) {
            datos.tipo1Array.push(data.consulta[i].tipos1);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos2 != null) {
            datos.tipo2Array.push(data.consulta[i].tipos2);
          }
        }
        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos3 != null) {
            datos.tipo3Array.push(data.consulta[i].tipos3);
          }
        }

        var dataGraphic = [];

        for (var i = 0; i < tamanho; i++) {
          let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.tipo1Array[i]+', '+datos.tipo2Array[i]+', '+datos.tipo3Array[i]+']}';
          array = JSON.parse(array);
          dataGraphic.push(array);
        }
        Highcharts.chart(graficosEdtId.grafico1, {
          chart: {
            type: 'column'
            // renderTo: ''
          },
          title: {
            text: 'Edt\'s entre ' + fecha_inicio + ' y ' + fecha_fin
          },
          xAxis: {
            categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
            title: {
              text: 'Tipos de Edt\'s'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Número de Edts\'s'
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
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    });
  }
}


function consultarTiposDeArticulacionesDelAnho_variablepie(bandera) {
  let anho = $('#txtanho_Grafico4').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarArticulacionesPorNodoYAnho/'+idnodo+'/'+anho,
      success: function (data) {
        Highcharts.chart(graficosId.grafico4, {
          chart: {
            type: 'variablepie'
          },
          title: {
            text: 'Tipos de Articulación.'
          },
          plotOptions: {
            variablepie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                connectorColor: 'silver'
              }
            }
          },
          tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad: <b>{point.y}</b><br/>'
            // 'Population density (people per square km): <b>{point.z}</b><br/>'
          },
          series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: '',
            data: [
              { name: 'Grupos de Investigación', y: data.consulta.grupos, z: 15 },
              { name: 'Empresas', y: data.consulta.empresas, z: 15 },
              { name: 'Emprendedores', y: data.consulta.emprendedores, z: 15 }
            ]
          }]
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })

  }
}

function articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarArticulacionesPorNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      var tamanho = data.consulta.length;
      var datos = {
        gestores: [],
        gruposArray: [],
        empresasArray: [],
        emprendedoresArray: []
      };
      for (var i = 0; i < tamanho; i++) {
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
          // renderTo: ''
        },
        title: {
          text: 'Articulaciones entre ' + fecha_inicio + ' y ' + fecha_fin
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
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  });
}

function consultaArticulacionesDelGestorPorNodoYFecha_stacked(id) {
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();
  articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin);
}

function consultaArticulacionesDelGestorPorNodoYFecha_stackedAdministrador() {
  let id = $('#txtnodo_id').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Seleccione un Nodo!', 'warning');
  } else {
    let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
    let fecha_fin = $('#txtfecha_fin_Grafico1').val();
    articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin);
  }
}

function consultarArticulacionesDeUnGestorPorFecha_stacked() {
  let fecha_inicio = $('#txtfecha_inicio_Grafico2').val();
  let fecha_fin = $('#txtfecha_fin_Grafico2').val();
  let id = $('#txtgestor_id').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona un experto!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarArticulacionesPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          Highcharts.chart(graficosId.grafico2, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones'
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
            series: [{name: data.consulta.gestor, data: [data.consulta.grupos, data.consulta.empresas, data.consulta.emprendedores]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

/**
* Consulta la cantidad de arituclaciones por tipo según la línea tecnológica de un nodo y parametrizado entre fechas (estas fecha son de cierre)
*/
function consultarArticulacionesDeUnaLineaDelNodoPorFechas_stacked(bandera) {
  let idnodo = "";
  if (bandera == 0) {
    idnodo = 0;
  } else {
    idnodo = $('#txtnodo_id').val();
  }
  let id = $('#txtlinea_tecnologica').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona una Línea Tecnológica!', 'warning')
  } else {
    let fecha_inicio = $('#txtfecha_inicio_Grafico3').val();
    let fecha_fin = $('#txtfecha_fin_Grafico3').val();
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Debes seleccionar fecha válidas!', 'warning')
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/'+idnodo+'/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
        success: function (data) {
          Highcharts.chart(graficosId.grafico3, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones'
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
            series: [{name: data.consulta.lineatecnologica, data: [data.consulta.grupos, data.consulta.empresas, data.consulta.emprendedores]}]
          });
        }
      })
    }
  }
}
