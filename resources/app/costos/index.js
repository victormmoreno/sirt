var graficosCostos = {
    actividad: 'costosDeUnProyecto_column',
    proyectos: 'costosDeProyectos_column',
    proyectos_ipe: 'costosDeProyectos_ipe_column'
};

function setValueInput(data, chart) {
    $('#txtcosto_asesorias' + chart).val(formatMoney(data.costosAsesorias));
    $("label[for='txtcosto_asesorias"+chart+"']").addClass("active", true);
    $('#txtcostos_equipos' + chart).val(formatMoney(data.costosEquipos));
    $("label[for='txtcostos_equipos"+chart+"']").addClass("active", true);
    $('#txtcostos_materiales' + chart).val(formatMoney(data.costosMateriales));
    $("label[for='txtcostos_materiales"+chart+"']").addClass("active", true);
    $('#txtcostos_administrativos' + chart).val(formatMoney(data.costosAdministrativos));
    $("label[for='txtcostos_administrativos"+chart+"']").addClass("active", true);
    $('#txtcosto_total' + chart).val(formatMoney(data.costosTotales));
    $("label[for='txtcosto_total"+chart+"']").addClass("active", true);
    $('#txthoras_asesoria' + chart).val(data.horasAsesorias);
    $("label[for='txthoras_asesoria"+chart+"']").addClass("active", true);
    $('#txthoras_uso' + chart).val(data.horasEquipos);
    $("label[for='txthoras_uso"+chart+"']").addClass("active", true);
}

function consultarCostosDeProyectos(bandera, tipo) {
    let idnodo = 0;
    let tipos = [];
    let estado;
    let fecha_inicio;
    let fecha_fin;
    let chart = '';

    if (tipo == 1) {
        chart = '_proyectos';
        estado = $("input[name='estado']:checked").val();
        fecha_inicio = $('#txtfecha_inicio_costosProyectos').val();
        fecha_fin = $('#txtfecha_fin_costosProyectos').val();
        $("input[name='tipoProyecto[]']:checked").each(function (index, obj) {
        tipos.push($(this).val());
        });
    } else {
        chart = '_proyectos_ipe';
        estado = $("input[name='estado_ipe']:checked").val();
        fecha_inicio = $('#txtfecha_inicio_costosProyectos_ipe').val();
        fecha_fin = $('#txtfecha_fin_costosProyectos_ipe').val();
        $("input[name='tipoProyecto_ipe[]']:checked").each(function (index, obj) {
            tipos.push($(this).val());
        });
    }

  // En caso de que sea el Administrador el que consulta los costos
    if (bandera == 1) {
        idnodo = $('#txtnodo_id').val();
    }

    if (idnodo === '') {
        Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
    } else {
        if (tipos.length == 0) {
        Swal.fire('Advertencia!', 'Seleccione por lo menos un tipo de proyecto', 'warning');
        } else {
        if (estado == null) {
            Swal.fire('Advertencia!', 'Seleccione un estado de proyecto', 'warning');
        } else {
            if (fecha_inicio > fecha_fin) {
            Swal.fire('Advertencia!', 'Seleccione fecha válidas', 'warning');
            } else {
            let tiposArr = JSON.stringify(tipos);
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: host_url + '/costos/costosDeProyectos/'+idnodo+'/'+tiposArr+'/'+estado+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo,
                success: function (data) {
                setValueInput(data, chart);
                graficoCostos(data, tipo == 1 ? graficosCostos.proyectos : graficosCostos.proyectos_ipe, 'Proyectos');
                },
                error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
                },
            })
            }
        }
        }
    }
}

function consultarCostoDeUnaActividad() {
    let id = $('#txtactividad_id').val();
    if (id === '') {
        Swal.fire('Advertencia!', 'Seleccione una actividad', 'warning');
    } else {
        $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/costos/proyecto/'+id,
        success: function (data) {
            let chart = '_actividad';
            console.log(data);
            setValueInput(data, chart);
            $('#txtgestor' + chart).val(data.gestorActividad);
            $("label[for='txtgestor"+chart+"']").addClass("active", true);
            $('#txtlinea' + chart).val(data.lineaActividad);
            $("label[for='txtlinea"+chart+"']").addClass("active", true);
            graficoCostos(data, graficosCostos.actividad, data.codigoActividad);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
        })
    }
}

function graficoCostos(data, name, title) {
  Highcharts.chart(name, {
    exporting: {
      allowHTML: true,
      chartOptions: {
        chart: {
          height: 600,
          marginTop: 110,
          events: {
            load: function() {
              this.renderer.image('http://drive.google.com/uc?export=view&id=1qLb9tjGI1hEnmEzQ6mPzxqv1zjMtxdMw', 80, 20, 200, 47).add();
              this.renderer.image('http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C', 290, 20, 200, 47).add();
              this.update({
                credits: {
                  text: 'Generado: ' + Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', Date.now())
                }
              });
            }
          }
        },
        legend: {
          y: -220
        },
        title: {
          align: 'center',
          y: 90
        },

      }
    },
    chart: {
      type: 'column',
    },
    title: {
      text: 'Costos - ' + title
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
            y: data.costosAsesorias,
          },
          {
            name: "Costos de Equipos",
            y: data.costosEquipos,
          },
          {
            name: "Costos de Materiales",
            y: data.costosMateriales,
          },
          {
            name: "Costos Administrativos",
            y: data.costosAdministrativos,
          },
          {
            name: "Total de Costos",
            y: data.costosTotales,
          },
        ]
      }
    ],
  });
}
