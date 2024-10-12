$('#consultar_por').val('por_funcionario');
selectDependienteDeFuncionarios();

function selectDependienteDeFuncionarios(e) {
    // e.preventDefault();
    let nodo = $('#slct_nodo').val();
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: `${host_url}/usuarios/funcionarios/nodo/${nodo}`
    }).done(function(response) {
        $('#slct_funcionario').empty();
        pintarExpertos(response.expertos);
        pintarApoyos(response.apoyos);
        pintarArticuladores(response.articuladores);
        $('#slct_funcionario').material_select();
    });
}

function pintarExpertos(expertos) {
    $('#slct_funcionario').append(`<optgroup label="Experto/s">`);
    $.each(expertos, function(i, e) {
        $('#slct_funcionario').append('<option value="' + e.id + '">' + e.nombre_completo + '</option>');
    })
    $('#slct_funcionario').append(`</optgroup>`);
}

function pintarApoyos(apoyos) {
    $('#slct_funcionario').append(`<optgroup label="Apoyo/s Técnico/s">`);
    $.each(apoyos, function(i, e) {
        $('#slct_funcionario').append('<option value="' + e.id + '">' + e.nombre_completo + '</option>');
    })
    $('#slct_funcionario').append(`</optgroup>`);
}

function pintarArticuladores(articuladores) {
    $('#slct_funcionario').append(`<optgroup label="Articulador/es">`);
    $.each(articuladores, function(i, e) {
        $('#slct_funcionario').append('<option value="' + e.id + '">' + e.nombre_completo + '</option>');
    })
    $('#slct_funcionario').append(`</optgroup>`);
}


function updateCardMessage() {
    let message_element = $('#info-message');
    message_element.empty();
    switch ($('#consultar_por').val()) {
        case 'por_funcionario':
                message_element.append('Esta consulta se realiza sobre el rango fecha en el que un funcionario realiza asesorias');
            break;
            case 'por_fecha_asesoria':
                message_element.append('Esta consulta se realiza sobre el rango fecha en el que se registran asesorias a proyectos (No aplica para articulaciones');
            break;
            case 'por_proyecto_finalizado':
                message_element.append(`Esta consulta se realiza sobre el rango FECHA DE CIERRE de los proyectos. Por lo 
                    que podrás ver asesorias que se realizaron en meses anteriores al rango de fecha pero cuyo proyecto cerró 
                    entre el rango de fechas seleccionado`);
            break;
    
        default:
            break;
    }
}

function paginar_info(container, items_to_paginate, paginator) {
    let itemsPerPage = 5; // Número de elementos por página
    let itemContainer = document.getElementById(container);
    let items = Array.from(itemContainer.getElementsByClassName(items_to_paginate));
    let pagination = document.getElementById(paginator);

    let currentPage = 1;
    let totalPages = Math.ceil(items.length / itemsPerPage);

    // Función para mostrar los elementos de la página actual
    function showPage(page) {
        // Ocultar todos los elementos
        items.forEach(item => item.style.display = 'none');

        // Mostrar solo los elementos de la página actual
        let start = (page - 1) * itemsPerPage;
        let end = start + itemsPerPage;

        items.slice(start, end).forEach(item => {
            item.style.display = 'block';
        });

        // Actualizar los botones de paginación
        updatePagination();
    }

    // Función para actualizar los botones de paginación
    function updatePagination() {
        pagination.innerHTML = '';

        // Botón para ir a la página anterior
        let prevButton = document.createElement('li');
        prevButton.classList.add('waves-effect');
        prevButton.innerHTML = `<a href="#!"><i class="material-icons">chevron_left</i></a>`;
        if (currentPage === 1) prevButton.classList.add('disabled');
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });
        pagination.appendChild(prevButton);

        // Botones numéricos de paginación
        for (let i = 1; i <= totalPages; i++) {
            let pageButton = document.createElement('li');
            pageButton.classList.add('waves-effect');
            // pageButton.classList.add('bg-primary');
            if (i === currentPage) pageButton.classList.add('bg-primary');
            pageButton.innerHTML = `<a href="#!">${i}</a>`;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                showPage(currentPage);
            });
            pagination.appendChild(pageButton);
        }

        // Botón para ir a la página siguiente
        let nextButton = document.createElement('li');
        nextButton.classList.add('waves-effect');
        nextButton.innerHTML = `<a href="#!"><i class="material-icons">chevron_right</i></a>`;
        if (currentPage === totalPages) nextButton.classList.add('disabled');
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });
        pagination.appendChild(nextButton);
    }

    // Mostrar la primera página cuando se carga la página
    showPage(currentPage);
}

// Enviar formulario para modificar el proyecto en fase de cierre
$(document).on('submit', 'form#frmConsultarCostosAsesoria', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormConsultaAsesorias(form, data, url);
});

function ajaxSendFormConsultaAsesorias(form, data, url) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            printInformacionCosto(data);
            graficarCostos(data);
            paginar_info('info_equipos', 'items-equipos', 'pagination-equipos');
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function printInformacionCosto(data) {
    $('#datos_asesorias').empty();
    $('#info_equipos').empty();
    $('#info_materiales').empty();
    printAsesorias(data);
    printEquipos(data);
    printMateriales(data);
}

function printAsesorias(data) {
    let div = '';
    div += printAsesoriasNoEncontradas(data);
    div += printAsesoriasEncontradas(data);
    div += printTotalesAsesorias(data);
    $('#datos_asesorias').append(div);
    paginar_info('datos_asesorias', 'items-asesores', 'pagination-asesores');
}

function printEquipos(data) {
    let div = '';
    div += printEquiposNoEncontrados(data);
    div += printEquiposEncontrados(data);
    div += printTotalesEquipos(data);
    $('#info_equipos').append(div);
    paginar_info('info_equipos', 'items-equipos', 'pagination-equipos');
}

function printMateriales(data) {
    let div = '';
    div += printMaterialesNoEncontrados(data);
    div += printMaterialesEncontrados(data);
    div += printTotalesMateriales(data);
    $('#info_materiales').append(div);
    paginar_info('info_materiales', 'items-materiales', 'pagination-materiales');
}

function printTotalesAsesorias(data) {
    return `<p>
        <h5>Total horas: <b>${data.totales.total_horas_asesoria == null ? 0 : data.totales.total_horas_asesoria} horas</b></h5>
    </p>
    <p>
        <h5>Costo total de asesorias: <b>${formatMoney(data.totales.total_costo_asesoria)}</b></h5>
    </p>`;
}

function printTotalesMateriales(data) {
    return `<p>
        <h5>Costo total de uso de materiales: <b>${formatMoney(data.totales.total_costo_materiales)}</b></h5>
    </p>`;
}

function printTotalesEquipos(data) {
    return `<p>
        <h5>Total horas de uso de equipos: <b>${data.totales.total_horas_uso_equipos == null ? 0 : data.totales.total_horas_uso_equipos} horas</b></h5>
    </p>
    <p>
        <h5>Costo total de uso de equipos: <b>${formatMoney(data.totales.total_costo_uso_equipos)}</b></h5>
    </p>`;
}

function printAsesoriasEncontradas(data) {
    let string = '';
    if (data.datos.asesorias != null && data.datos.asesorias.length != 0) {
        $.each( data.datos.asesorias, function( i, asesorias ) {
            string += `<div class="row card-panel green lighten-3 items-asesores">
            <h5>${asesorias.asesor}</h5>
            <div class="col s12 m6 l6 ">
                <input type="text" id="experto1" value="${asesorias.horas_asesoria} horas" disabled>
            </div>
            <div class="col s12 m4 l4 ">
                <input type="text" id="experto1" value="${formatMoney(asesorias.costo_asesoria)}" disabled>
            </div>
            <div class="col s12 m2 l2 black-text">
                <a onclick="getDetalleAsesoriasFuncionario(${asesorias.asesor_id}, '${data.request.txtasesorias_desde}', '${data.request.txtasesorias_hasta}', '${$("#consultar_por").val()}')" class="btn bg-info">Detalle</a>
            </div>
        </div>`;
        });
    }
    return string;
}

function printEquiposEncontrados(data) {
    let string = '';
    if (data.datos.equipos != null && data.datos.equipos.length != 0) {
        $.each( data.datos.equipos, function( i, equipo ) {
            string += `<div class="row card-panel green lighten-3 items-equipos">
            <h5>${equipo.equipo}</h5>
            <div class="col s12 m6 l6 ">
                <input type="text" id="experto1" value="${equipo.tiempo_uso} horas" disabled>
            </div>
            <div class="col s12 m4 l4 ">
                <input type="text" id="experto1" value="${formatMoney(equipo.costo_uso_equipo)}" disabled>
            </div>
            <div class="col s12 m2 l2 black-text">
                <a onclick="getDetalleUsoEquipos(${equipo.equipo_id}, '${data.request.txtasesorias_desde}', '${data.request.txtasesorias_hasta}', '${$("#consultar_por").val()}')" class="btn bg-info">Detalle</a>
            </div>
        </div>`;
        });
    }
    return string;
}

function printMaterialesEncontrados(data) {
    let string = '';
    if (data.datos.materiales != null && data.datos.materiales.length != 0) {
        $.each( data.datos.materiales, function( i, material ) {
            string += `<div class="row card-panel green lighten-3 items-materiales">
            <h5>${material.material}</h5>
            <div class="col s12 m6 l6 ">
                <input type="text" id="experto1" value="${material.unidad} ${material.medida} usada/os" disabled>
            </div>
            <div class="col s12 m4 l4 ">
                <input type="text" id="experto1" value="${formatMoney(material.costo_material)}" disabled>
            </div>
            <div class="col s12 m2 l2 black-text">
                <a onclick="getDetalleUsoMateriales(${material.material_id}, '${data.request.txtasesorias_desde}', '${data.request.txtasesorias_hasta}', '${$("#consultar_por").val()}')" class="btn bg-info">Detalle</a>
            </div>
        </div>`;
        });
    }
    return string;
}

function printAsesoriasNoEncontradas(data) { 
    let string = '';
    if (data.datos.asesorias == null || data.datos.asesorias.length == 0 || data.datos.asesorias[0].asesor_id == null) {
        string +=  returnNotFoundCard();
    }
    return string;
}

// Refactorizar luego
function printEquiposNoEncontrados(data) { 
    let string = '';
    if (data.datos.equipos == null || data.datos.equipos.length == 0 || data.datos.equipos[0].equipo_id == null) {
        string +=  returnNotFoundCard();
    }
    return string;
}

// Refactorizar luego
function printMaterialesNoEncontrados(data) { 
    let string = '';
    if (data.datos.materiales == null || data.datos.materiales.length == 0 || data.datos.materiales[0].material_id == null) {
        string +=  returnNotFoundCard();
    }
    return string;
}

function returnNotFoundCard() {
    return `<div class="row card-panel red lighten-3 center"><h5>No se encontraron resultados</h5></div>`;
}

function getDetalleAsesoriasFuncionario(asesor_id, desde, hasta, tipo_fecha) {
    $.ajax({
        type: 'get',
        url: `${host_url}/asesorias/indicadores/search`,
        data: {
            'consultar_por': tipo_fecha,
            'asesor_id': asesor_id,
            'desde': desde,
            'hasta': hasta
        },
        success: function (data) {
            printModalDetalles(data, desde, hasta);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
}

function getDetalleUsoEquipos(equipo_id, desde, hasta, tipo_fecha) {
    $.ajax({
        type: 'get',
        url: `${host_url}/equipo/indicadores/search`,
        data: {
            'consultar_por': tipo_fecha,
            'equipo_id': equipo_id,
            'desde': desde,
            'hasta': hasta
        },
        success: function (data) {
            printModalDetallesEquipo(data, desde, hasta);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
}

function getDetalleUsoMateriales(material_id, desde, hasta, tipo_fecha) {
    $.ajax({
        type: 'get',
        url: `${host_url}/material/indicadores/search`,
        data: {
            'consultar_por': tipo_fecha,
            'material_id': material_id,
            'desde': desde,
            'hasta': hasta
        },
        success: function (data) {
            printModalDetallesMaterial(data, desde, hasta);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
}

function printModalDetalles(data, desde, hasta) {
    let asesorias = '';
    $("#titulo-modal").empty();
    $("#detalle-modal").empty();
    printTituloModal(data.asesorias, 'Asesorias entre '+desde+' y '+hasta);
    asesorias += pintarTablaDeAsesorias(data);
    // console.info(asesorias);
    $('#detalle-modal').append(asesorias);
    $('#modal-default').openModal();
}

function printModalDetallesEquipo(data, desde, hasta) {
    let equipos = '';
    $("#titulo-modal").empty();
    $("#detalle-modal").empty();
    printTituloModal(data.equipos, 'Asesorias donde se usó este equipo entre '+desde+' y '+hasta);
    equipos += pintarTablaDeEquipos(data);
    // console.info(asesorias);
    $('#detalle-modal').append(equipos);
    $('#modal-default').openModal();
}

function printModalDetallesMaterial(data, desde, hasta) {
    let materiales = '';
    $("#titulo-modal").empty();
    $("#detalle-modal").empty();
    printTituloModal(data.materiales, 'Asesorias donde se usó este material entre '+desde+' y '+hasta);
    materiales += pintarTablaDeMateriales(data);
    // console.info(asesorias);
    $('#detalle-modal').append(materiales);
    $('#modal-default').openModal();
}

function pintarTablaDeAsesorias(data) {
    let string = '';
    string += `<table class="responsive-table">
        <thead>
        <tr>
            <th>Código de actividad</th>
            <th>Código de asesoria</th>
            <th>Fecha</th>
            <th>Horas de asesoría</th>
            <th>Costo de asesoría</th>
        </tr>
        </thead>
    <tbody>`;
    $.each( data.asesorias, function( i, asesorias ) {
        string += `
            <tr>
                <td>${retornarNombreDeActividad(asesorias)}</td>
                <td>${asesorias.codigo}</td>
                <td>${asesorias.fecha}</td>
                <td>${asesorias.horas_asesoria}</td>
                <td>${formatMoney(asesorias.costo_asesoria)}</td>
            </tr>`;
    });
    string += `</tbody></table>`;
    return string;
}

function pintarTablaDeEquipos(data) {
    let string = '';
    string += `<table class="responsive-table">
        <thead>
        <tr>
            <th>Código de actividad</th>
            <th>Código de asesoria</th>
            <th>Fecha</th>
            <th>Horas de uso del equipo</th>
            <th>Costo de uso del equipo</th>
        </tr>
        </thead>
    <tbody>`;
    $.each( data.equipos, function( i, equipos ) {
        string += `
            <tr>
                <td>${retornarNombreDeActividad(equipos)}</td>
                <td>${equipos.codigo}</td>
                <td>${equipos.fecha}</td>
                <td>${equipos.tiempo_uso}</td>
                <td>${formatMoney(equipos.costo_uso_equipo)}</td>
            </tr>`;
    });
    string += `</tbody></table>`;
    return string;
}

function pintarTablaDeMateriales(data) {
    let string = '';
    string += `<table class="responsive-table">
        <thead>
        <tr>
            <th>Código de actividad</th>
            <th>Código de asesoria</th>
            <th>Fecha</th>
            <th>Unidades usadas del material</th>
            <th>Costo de uso del material</th>
        </tr>
        </thead>
    <tbody>`;
    $.each( data.materiales, function( i, materiales ) {
        string += `
            <tr>
                <td>${retornarNombreDeActividad(materiales)}</td>
                <td>${materiales.codigo}</td>
                <td>${materiales.fecha}</td>
                <td>${materiales.unidad} ${materiales.medida}</td>
                <td>${formatMoney(materiales.costo_material)}</td>
            </tr>`;
    });
    string += `</tbody></table>`;
    return string;
}


function printTituloModal(data, string) {
    if (data.length >= 1){
        $("#titulo-modal").append("<span class='cyan-text text-darken-3'>"+string+"</span>");
    } else {
        $("#titulo-modal").append("<span class='cyan-text text-darken-3'>No se encontraron resultados</span>");
    }
}

function retornarNombreDeActividad(data) {
    if (data.codigo_proyecto != null) {
        return data.codigo_proyecto;
    }
    if (data.codigo_articulacion != null) {
        return data.codigo_articulacion;
    }
    if (data.codigo_idea != null) {
        return data.codigo_idea;
    }
    return "No se encontró el código de la actividad";
}

function graficarCostos(data) {
    Highcharts.chart('costosDeAsesorias_column', {
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
        text: 'Costos de asesorias'
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
              y: data.totales.total_costo_asesoria,
            },
            {
              name: "Costos de Equipos",
              y: data.totales.total_costo_uso_equipos,
            },
            {
              name: "Costos de Materiales",
              y: data.totales.total_costo_materiales,
            },
            {
              name: "Total de Costos",
              y: data.totales.total_costos,
            },
          ]
        }
      ],
    });
  }