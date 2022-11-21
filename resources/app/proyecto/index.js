$(document).ready(function() {
    // consultarProyectosDelGestorPorAnho();
    consultarProyectosUnNodoPorAnho();
});

function verHorasDeExpertosEnProyecto(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url: host_url + "/proyecto/consultarHorasExpertos/"+id
  }).done(function(respuesta){
    $("#horasAsesoriasExpertosPorProyeto_table").empty();
    if (respuesta.horas.length == 0 ) {
      Swal.fire({
        title: 'Ups!!',
        text: "No se encontraron horas de asesorías de los expertos en este proyecto!",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
      })
    } else {
      $("#horasAsesoriasExpertosPorProyeto_titulo").empty();
      $("#horasAsesoriasExpertosPorProyeto_titulo").append("<span class='cyan-text text-darken-3'>Horas de los experto en el proyecto</span>");
      $.each(respuesta.horas, function (i, item) {
        // console.log(item.experto);
        $("#horasAsesoriasExpertosPorProyeto_table").append(
          '<tr>'
          +'<td>'+item.experto+'</td>'
          +'<td>'+item.horas_directas+'</td>'
          +'<td>'+item.horas_indirectas+'</td>'
          +'</tr>'
        );
      });
      $('#horasAsesoriasExpertosPorProyeto_modal').openModal();
    }
  });
}

function consultarProyectosDeTalentos() {

    $('#tblProyectos_Master').dataTable().fnDestroy();
    $('#tblProyectos_Master').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        "lengthChange": false,
        ajax:{
            url: host_url + "/proyecto/datatableProyectosDelTalento/",
            data: function (d) {
                d.codigo_proyecto = $('.codigo_proyecto').val(),
                d.nombre = $('.nombre').val(),
                d.nombre_fase = $('.nombre_fase').val(),
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            {
                width: '15%',
                data: 'codigo_proyecto',
                name: 'codigo_proyecto',
            },
            {
                data: 'nombre_gestor',
                name: 'nombre_gestor',
            },
            {
                data: 'nombre',
                name: 'nombre',
            },
            {
                data: 'nombre_fase',
                name: 'nombre_fase',
            },
            {
                width: '8%',
                data: 'info',
                name: 'info',
                orderable: false
            },
            {
                width: '8%',
                data: 'proceso',
                name: 'proceso',
                orderable: false
            },
        ],
    });
}

/**
* Consulta los talentos que tiene un proyecto
*/
function verTalentosDeUnProyecto(id){
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/proyecto/ajaxConsultarTalentosDeUnProyecto/"+id
    }).done(function(respuesta){
        $("#talentosAsociadosAUnProyecto_table").empty();
        if (respuesta.talentos.length != 0 ) {
        $("#talentosAsociadosAUnProyecto_titulo").empty();
        $("#talentosAsociadosAUnProyecto_titulo").append("<span class='cyan-text text-darken-3'>Código de Proyecto: </span>"+respuesta.proyecto+"");
        $.each(respuesta.talentos, function(i, item) {
            let icon = "";
            let celular = item.celular;
            if (item.rol == 'Talento Líder') {
                icon = '<i class="material-icons green-text left">face</i>'
            }
            if (item.celular == null) {
                celular = "";
            }
            $("#talentosAsociadosAUnProyecto_table").append(
                '<tr>'
                +'<td>'+icon+' '+item.rol+'</td>'
                +'<td>'+item.talento+'</td>'
                +'<td>'+item.email+'</td>'
                +'<td>'+celular+'</td>'
                +'</tr>'
            );
        });
        $('#talentosAsociadosAUnProyecto_modal').openModal();
        } else {
        Swal.fire({
            title: 'Ups!!',
            text: "No se encontraron talentos asociados a este proyecto!",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
        }
    });
}

// Ajax que muestra los proyectos de un experto por año
// function consultarProyectosDelGestorPorAnho() {
//     let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
//     $('#tblproyectosGestorPorAnho').dataTable().fnDestroy();
//     $('#tblproyectosGestorPorAnho').DataTable({
//         language: {
//             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
//         },
//         pageLength: 20,
//         processing: true,
//         serverSide: true,
//         order: [ 0, 'desc' ],
//         "lengthChange": false,
//         ajax:{
//             url: host_url + "/proyecto/datatableProyectosDelGestorPorAnho/"+0+"/"+anho,
//             data: function (d) {
//                 d.codigo_proyecto = $('.codigo_proyecto').val(),
//                 d.nombre = $('.nombre').val(),
//                 d.nombre_fase = $('.nombre_fase').val(),
//                 d.search = $('input[type="search"]').val()
//             }
//         },
//         columns: [
//             {
//                 width: '15%',
//                 data: 'codigo_proyecto',
//                 name: 'codigo_proyecto',
//             },
//             {
//                 data: 'nombre',
//                 name: 'nombre',
//             },
//             {
//                 data: 'nombre_fase',
//                 name: 'nombre_fase',
//             },
//             {
//                 width: '8%',
//                 data: 'info',
//                 name: 'info',
//                 orderable: false
//             },
//             {
//                 width: '8%',
//                 data: 'proceso',
//                 name: 'proceso',
//                 orderable: false
//             },
//         ],
//     });
// }
// $(".codigo_proyecto").keyup(function(){
//     $('#tblproyectosGestorPorAnho').DataTable().draw();
// });

// $(".nombre").keyup(function(){
//     $('#tblproyectosGestorPorAnho').DataTable().draw();
// });

// $(".nombre_fase").keyup(function(){
//     $('#tblproyectosGestorPorAnho').DataTable().draw();
// });

// $("#codigo_proyecto_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#gestor_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#nombre_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#sublinea_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#fase_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

function preguntaReversar(e, id, fase){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de reversar este proyecto a la fase de '+fase+'?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
        if (result.value) {
            sendReversarProyecto(id, fase);
        }
    })
}

function sendReversarProyecto(id, fase) {
    $.ajax({
        type: 'get',
        url: host_url + '/proyecto/reversar/'+id+'/'+fase,
        dataType: 'json',
        success: function (data) {
            Swal.fire({
                title: data.msg,
                type: data.type_alert,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Ok!'
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
}


function eliminarProyectoPorId_event(id, e) {
    Swal.fire({
        title: '¿Desea eliminar el Proyecto?',
        text: "Al hacer esto, todo lo relacionado con este proyecto será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'No',
        confirmButtonText: 'Sí, eliminar!'
    }).then((result) => {
        if (result.value) {
            eliminarProyectoPorId_moment(id);
        }
    })
}

function eliminarProyectoPorId_moment(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/proyecto/eliminarProyecto/'+id,
        success: function (data) {
            if (data.retorno) {
                Swal.fire('Eliminación Exitosa!', 'El proyecto se ha eliminado completamente!', 'success');
                location.href = '/proyecto';
            } else {
                Swal.fire('Eliminación Errónea!', 'El proyecto no se ha eliminado!', 'error');
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    })
}

var infoActividad = {
    infoDetailActivityModal : function(code){
        if(typeof code === 'string'){
            $.ajax({
                dataType:'json',
                type:'get',
                url: host_url + '/actividad/detalle/'+code
            }).done(function (response) {
                $("#actividad_titulo").empty();
                $("#detalleActividad").empty();
                $("#actividad_titulo").append("<span class='primary-text'>"+response.data.actividad.codigo_actividad +' - '+ response.data.actividad.nombre+" </span><br>");
                if(response.data.actividad.articulacion_proyecto.proyecto !== null){
                    infoActividad.openIsProyect(response);
                }else if(response.data.actividad.articulacion_proyecto.articulacion !== null){
                    infoActividad.openIsArticulacion(response);
                }
                $('#info_actividad_modal').openModal();
            });
        }
    },
    openIsProyect: function(response){
        $("#detalleActividad").append(`
            <table class="striped centered">
                <TR>
                    <TH class="secondary-text" width="25%">Código Proyecto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                    <TH class="secondary-text" width="25%" >Nombre Proyecto</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
                </TR>
                <TR>
                    <TH class="secondary-text" width="25%">Experto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.asesor.user.documento)} - ${response.data.actividad.articulacion_proyecto.proyecto.asesor.user.nombres} ${response.data.actividad.articulacion_proyecto.proyecto.asesor.user.apellidos}</TD>
                    <TH class="secondary-text" width="25%">Correo Electrónico</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.asesor.user.email)}</TD>
                </TR>
            </table>
            <div class="right">
                <small>
                    <b class="secondary-text">Cantidad de usos de infraestructura:  </b>
                    ${infoActividad.showInfoNull(response.data.total_usos)}
                </small>
            </div>
            <div class="divider mailbox-divider"></div>
            <div class="center">
                <span class="mailbox-title primary-text">
                    <i class="material-icons">group</i>
                    Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.
                </span>
            </div>
            <div class="divider mailbox-divider"></div>
                <div class="row">
                <div class="col s12 m12 l12">
                        <div class="card-transparent">
                            <h5 class="center primary-text">Talentos que participan en el proyecto</h5>
                            <table>
                                <thead class="bg-primary white-text">
                                    <tr>
                                        <th style="width: 10%">Talento Interlocutor</th>
                                        <th style="width: 40%">Talento</th>
                                        <th style="width: 20%">Correo</th>
                                        <th style="width: 15%">Telefono</th>
                                        <th style="width: 15%">Celular</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleTalentos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-transparent col s12 m12 l12">
                        <h5 class="center primary-text">Dueño(s) de la propiedad intelectual</h5>
                        <div class="row">
                            <div class="col s12 m4 l4">
                                <div class="card-transparent">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5 class="secondary-text">Empresas</h5></li>
                                        <div id="detalleEmpresas"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-transparent">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5 class="secondary-text">Personas (Talentos)</h5></li>
                                        <div id="detallePropiedadTalentos"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-transparent">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5 class="secondary-text">Grupos de Investigación</h5></li>
                                        <div id="detallePropiedadGrupo"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
            infoActividad.showTalentos(response.data.actividad.articulacion_proyecto.talentos);
            infoActividad.showPropiedadIntelectualEmpresas(response.data.actividad.articulacion_proyecto.proyecto.sedes);
            infoActividad.showPropiedadIntelectualTalentos(response.data.actividad.articulacion_proyecto.proyecto.users_propietarios);
            infoActividad.showPropiedadIntelectualGrupo(response.data.actividad.articulacion_proyecto.proyecto.gruposinvestigacion);
    },
    openIsArticulacion: function(response){
        $("#detalleActividad").append(`
            <table class="striped centered">
                <TR>
                    <TH width="25%">Código Articulación</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                    <TH width="25%" >Nombre de Articulación</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
                </TR>
                <TR>
                    <TH width="25%">Experto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.asesor.documento)} - ${response.data.actividad.articulacion_proyecto.articulacion.asesor.nombres} ${response.data.actividad.articulacion_proyecto.articulacion.asesor.apellidos}</TD>
                    <TH width="25%">Correo Electrónico</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.asesor.email)}</TD>
                </TR>
            </table>
            <div class="right">
                <small>
                    <b>Cantidad de usos de infraestructura:  </b>
                    ${infoActividad.showInfoNull(response.data.total_usos)}
                </small>
            </div>
            <div class="divider mailbox-divider"></div>
            <div class="center">
                <span class="mailbox-title">
                    <i class="material-icons">group</i>
                    Talentos que participan en la articulación.
                </span>
            </div>
            <div class="divider mailbox-divider"></div>
                <div class="row">
                <div class="col s12 m12 l12">
                        <div class="card-panel blue lighten-5">
                            <h5 class="center">Talentos que participan en la Articulación</h5>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Talento Interlocutor</th>
                                        <th style="width: 40%">Talento</th>
                                        <th style="width: 20%">Correo</th>
                                        <th style="width: 15%">Telefono</th>
                                        <th style="width: 15%">Celular</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleTalentos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`);
                infoActividad.showTalentos(response.data.actividad.articulacion_proyecto.talentos);
    },
    showDateActivity: function(date){
        if(date === null || date === ''){
            return "El proceso no se ha cerrado";
        }else{
            return date;
        }
    },
    showInfoNull: function(info){
        if(info === null || info === ''){
            return "No se encontraron resultados";
        }else{

            return info;
        }
    },
    validateDataIsTRL: function(data){
        return data == 0 ? 'TRL 6' : 'TRL 7 - TRL 8';
    },
    validateDataIsBoolean: function(data){
        return data == 0 ? 'NO' : 'SI';
    },
    dataPerteneceEconomiaNaranja: function(data){
        return data.economia_naranja == 0 ? 'NO' :  data.economia_naranja == 1 ? ' SI (' + data.tipo_economianaranja +')' : '';
    },
    dataDirigidoDiscapacitados: function(data){
        return data.dirigido_discapacitados == 0 ? 'NO' :  data.dirigido_discapacitados == 1 ? 'SI (' + data.tipo_discapacitados +')' : '';
    },
    dataArticuladaCTI: function(data){
        return data.art_cti == 0 ? 'NO' :  data.art_cti == 1 ? ' SI (' + data.nom_act_cti +')' : '';
    },
    showTalentos: function (data){
        let fila = "";

        if(data.length > 0){
            fila = data.map(function(el){
                return `<tr class="selected">
                            <td> ${infoActividad.validateDataIsBoolean(el.pivot.talento_lider)}</td>
                            <td>${infoActividad.showInfoNull(el.user.documento)} - ${infoActividad.showInfoNull(el.user.nombres)} ${infoActividad.showInfoNull(el.user.apellidos)}</td>
                            <td>${infoActividad.showInfoNull(el.user.email)}</td>
                            <td>${infoActividad.showInfoNull(el.user.telefono)}</td>
                            <td>${infoActividad.showInfoNull(el.user.celular)}</td>
                        </tr>`;
            });

        }else{
            fila = `<tr class="selected">
                        <td COLSPAN=4>No se encontraron resultados</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>`;
        }
        document.getElementById("detalleTalentos").innerHTML = fila;

    },
    showPropiedadIntelectualEmpresas: function(data){
        let info = "";

        if(data.length > 0){
            info = data.map(function(el){
                    return `
                        <li class="collection-item">
                        ${infoActividad.showInfoNull(el.empresa.nit)} - ${infoActividad.showInfoNull(el.empresa.nombre)} (${infoActividad.showInfoNull(el.nombre_sede)})
                        </li>`;
            });

        }else{
            info = `<li class="collection-item">
                    No se han encontrado empresas dueña(s) de la propiedad intelectual.
                </li>`;
        }
        document.getElementById("detalleEmpresas").innerHTML = info;
    },
    showPropiedadIntelectualTalentos: function(data){
        let info = "";

        if(data.length > 0){
            info = data.map(function(el){
                return `<li class="collection-item">
                        ${infoActividad.showInfoNull(el.documento)} - ${infoActividad.showInfoNull(el.nombres)} ${infoActividad.showInfoNull(el.apellidos)}
                        </li>`;
            });
        }else{
            info = `<li class="collection-item">
                    No se han encontrado talento(s) dueño(s) de la propiedad intelectual.
                </li>`;
        }
        document.getElementById("detallePropiedadTalentos").innerHTML = info;
    },
    showPropiedadIntelectualGrupo: function(data){
        let info = "";

        if(data.length > 0){
            info = data.map(function(el){
                return `<li class="collection-item">
                        ${infoActividad.showInfoNull(el.codigo_grupo)} - ${infoActividad.showInfoNull(el.entidad.nombre)}
                        </li>`;
            });
        }else{
            info = `<li class="collection-item">
            No se han encontrado grupo(s) de investigación dueño(s) de la propiedad intelectual.
                </li>`;
        }
        document.getElementById("detallePropiedadGrupo").innerHTML = info;
    },

}

$("#codigo_proyecto_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#gestor_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#nombre_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#sublinea_nombre_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#estado_nombre_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

/**
 * Consulta los proyectos de un nodo por año (Este método es para el dinamizador)
 */
function consultarProyectosUnNodoPorAnho() {
let anho_proyectos_nodo = $('#anho_proyectoPorNodoYAnho').val();
let nodo = $('#nodo_proyectoPorNodoYAnho').val();

$('#tblProyectos_Master').dataTable().fnDestroy();
$('#tblProyectos_Master').DataTable({
    language: {
    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    "lengthChange": false,
    ajax:{
    url: host_url + "/proyecto/datatableProyectosAnho/"+nodo+"/"+anho_proyectos_nodo,
    data: function (d) {
        d.codigo_proyecto = $('#codigo_proyecto_tblProyectos_Master').val(),
        d.gestor = $('#gestor_tblProyectos_Master').val(),
        d.nombre = $('#nombre_tblProyectos_Master').val(),
        d.sublinea_nombre = $('#sublinea_nombre_tblProyectos_Master').val(),
        d.nombre_fase = $('#estado_nombre_tblProyectos_Master').val(),
        d.search = $('input[type="search"]').val()
    }
    },
    columns: [
    {
        width: '15%',
        data: 'codigo_proyecto',
        name: 'codigo_proyecto',
    },
    {
        data: 'gestor',
        name: 'gestor',
    },
    {
        data: 'nombre',
        name: 'nombre',
    },
    {
        data: 'sublinea_nombre',
        name: 'sublinea_nombre',
    },
    {
        data: 'nombre_fase',
        name: 'nombre_fase',
    },
    {
        width: '8%',
        data: 'info',
        name: 'info',
        orderable: false
    },
    {
        width: '8%',
        data: 'proceso',
        name: 'proceso',
        orderable: false
    },
    ],
    });
}