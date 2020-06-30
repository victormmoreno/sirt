$(document).ready(function() {
  consultarProyectosDelGestorPorAnho();
  consultarProyectosDelNodoPorAnho();
});

function consultarProyectosDeTalentos () {

  $('#tblProyectoDelTalento').dataTable().fnDestroy();
  $('#tblProyectoDelTalento').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    "lengthChange": false,
    ajax:{
      url: "/proyecto/datatableProyectosDelTalento/",
      // type: "get",
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
    url:"/proyecto/ajaxConsultarTalentosDeUnProyecto/"+id
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
        // let talento = '<a class="waves-effect waves-light btn tooltipped cyan m-b-xs modal-trigger" onclick="talento('+item.idpersona+')" data-position="bottom" data-delay="50" data-tooltip="Información del Talento"><i class="material-icons">assignment_ind</i> Información del Talento</a>'
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

// Ajax que muestra los proyectos de un gestor por año
function consultarProyectosDelGestorPorAnho() {

  let anho = $('#anho_proyectoPorAnhoGestorNodo').val();

  $('#tblproyectosGestorPorAnho').dataTable().fnDestroy();
  $('#tblproyectosGestorPorAnho').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    "lengthChange": false,
    ajax:{
      url: "/proyecto/datatableProyectosDelGestorPorAnho/"+0+"/"+anho,

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
$(".codigo_proyecto").keyup(function(){
  $('#tblproyectosGestorPorAnho').DataTable().draw();
});

$(".nombre").keyup(function(){
  $('#tblproyectosGestorPorAnho').DataTable().draw();
});

$(".nombre_fase").keyup(function(){
  $('#tblproyectosGestorPorAnho').DataTable().draw();
});


/**
* Key ups para la tabla de tblproyectosDelNodoPorAnho
*/
$("#codigo_proyecto_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

$("#gestor_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

$("#nombre_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

$("#sublinea_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

$("#fase_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

function preguntaReversar(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de reversar este proyecto a la fase de inicio?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmReversarFase.submit();
    }
  })
}

/**
* Consulta los proyectos del nodo por año
*/
function consultarProyectosDelNodoPorAnho() {
  let anho_proyectos_nodo = $('#anho_proyectoPorNodoYAnho').val();
  $('#tblproyectosDelNodoPorAnho').dataTable().fnDestroy();
  $('#tblproyectosDelNodoPorAnho').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    "lengthChange": false,
    ajax:{
      url: "/proyecto/datatableProyectosDelNodoPorAnho/"+0+"/"+anho_proyectos_nodo,
      data: function (d) {
        d.codigo_proyecto = $('#codigo_proyecto_tblProyectosDelNodoPorAnho').val(),
        d.gestor = $('#gestor_tblProyectosDelNodoPorAnho').val(),
        d.nombre = $('#nombre_tblProyectosDelNodoPorAnho').val(),
        d.sublinea_nombre = $('#sublinea_nombre_tblProyectosDelNodoPorAnho').val(),
        d.nombre_fase = $('#fase_nombre_tblProyectosDelNodoPorAnho').val(),
        d.search = $('input[type="search"]').val()
      }
      // type: "get",
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
        width: '6%',
        data: 'proceso',
        name: 'proceso',
        orderable: false
      },

    ],
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
    url: '/proyecto/eliminarProyecto/'+id,
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
                url:'/actividad/detalle/'+code
            }).done(function (response) {
                $("#actividad_titulo").empty();
                $("#detalleActividad").empty();
                $("#actividad_titulo").append("<span class='cyan-text text-darken-3'>"+response.data.actividad.codigo_actividad +' - '+ response.data.actividad.nombre+" </span><br>");
                if(response.data.actividad.articulacion_proyecto.proyecto !== null){
                    infoActividad.openIsProyect(response);
                }else if(response.data.actividad.articulacion_proyecto.articulacion !== null){
                    infoActividad.openIsArticulacion(response);
                }
                
                $('#info_actividad_modal').openModal();
             });

        }else{
            
        }
    },
    openIsProyect: function(response){
        $("#detalleActividad").append(`
            <table class="striped centered">
            <TR>
                <TH width="25%">Nodo</TH>
                <TD width="25%">${response.data.actividad.nodo.entidad.nombre}</TD>
                <TH width="25%" >Linea Tecnológica</TH>
                <TD width="25%" COLSPAN=3>${response.data.actividad.gestor.lineatecnologica.abreviatura} - ${response.data.actividad.gestor.lineatecnologica.nombre}</TD>
            </TR>
            <TR>
                <TH width="25%">Idea de proyecto</TH>
                <TD width="25%">${response.data.actividad.articulacion_proyecto.proyecto.idea.codigo_idea} - ${response.data.actividad.articulacion_proyecto.proyecto.idea.nombre_proyecto}</TD>
                <TH width="25%" >Idea inscrita por</TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.idea.nombre_completo)}</TD>
            </TR>
            <TR>
                <TH width="25%">Correo</TH>
                <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.idea.correo_contacto)} </TD>
                <TH width="25%" >Telefono</TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.idea.telefono_contacto)}</TD>
            </TR>
            <TR>
                <TH width="25%">Código Proyecto</TH>
                <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                <TH width="25%" >Nombre Proyecto</TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
            </TR>
            <TR>
                <TH width="16,6%">Fase</TH>
                <TD width="16,6%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.fase.nombre)}</TD>
                <TH width="16,6%">Fecha de Inicio </TH>
                <TD width="16,6%">${infoActividad.showDateActivity(response.data.actividad.fecha_inicio)}</TD>
                <TH width="16,6%">Fecha de cierre </TH>
                <TD width="16,6%">${infoActividad.showDateActivity(response.data.actividad.fecha_cierre)}</TD>
            </TR>
            <TR>
                <TH width="25%">Sublinea</TH>
                <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.sublinea.nombre)}</TD>
                <TH width="25%">Área de conocimiento </TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.areaconocimiento.nombre)}</TD>
            </TR>
            <TR>
                <TH width="25%">Gestor</TH>
                <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.gestor.user.documento)} - ${response.data.actividad.gestor.user.nombres} ${response.data.actividad.gestor.user.apellidos}</TD>
                <TH width="25%">Correo Electrónico</TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.gestor.user.email)}</TD>
            </TR>
            <TR>
                <TH width="16,6%">TRL que se pretende realizar</TH>
                <TD width="16,6%">${infoActividad.validateDataIsTRL(response.data.actividad.articulacion_proyecto.proyecto.trl_esperado)}</TD>
                <TH width="16,6%">¿Recibido a través de fábrica de productividad?</TH>
                <TD width="16,6%">${infoActividad.validateDataIsBoolean(response.data.actividad.articulacion_proyecto.proyecto.fabrica_productividad )}</TD>
                <TH width="16,6%">¿Recibido a través del área de emprendimiento SENA?</TH>
                <TD width="16,6%">${infoActividad.validateDataIsBoolean(response.data.actividad.articulacion_proyecto.proyecto.reci_ar_emp)}</TD>
            </TR>
            <TR>
                <TH width="16,6%">¿El proyecto pertenece a la economía naranja?</TH>
                <TD width="16,6%">${infoActividad.dataPerteneceEconomiaNaranja(response.data.actividad.articulacion_proyecto.proyecto)}</TD>
                <TH width="16,6%">¿El proyecto está dirigido a discapacitados?</TH>
                <TD width="16,6%">${infoActividad.dataDirigidoDiscapacitados(response.data.actividad.articulacion_proyecto.proyecto)}</TD>
                <TH width="16,6%">¿Articulado con CT+i?</TH>
                <TD width="16,6%">${infoActividad.dataArticuladaCTI(response.data.actividad.articulacion_proyecto.proyecto)}</TD>
            </TR>
            <TR>
                <TH width="16,6%">¿TRL obtenido?</TH>
                <TD width="16,6%">${infoActividad.validateDataIsTRL(response.data.actividad.articulacion_proyecto.proyecto.trl_obtenido)}</TD>
                <TH width="16,6%">¿Dirigido a área de emprendimiento SENA?</TH>
                <TD width="16,6%">${infoActividad.validateDataIsBoolean(response.data.actividad.articulacion_proyecto.proyecto.diri_ar_emp)}</TD>
                <TH width="16,6%">Costo Aproximado del Proyecto</TH>
                <TD width="16,6%">$ ${infoActividad.showInfoNull(response.data.costo.original.costosTotales)}</TD>
            </TR>
            </table>
            <div class="row">
            <div class="col s12 m6 l6">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title cyan-text text-darken-3">
                            Alcance del Proyecto
                        </span>
                        <p>
                        ${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.alcance_proyecto  )}
                        </p>
                    </li>

                    <li class="collection-item">
                        <span class="title cyan-text text-darken-3">
                            Primer objetivo específico
                        </span>
                        <p>
                            ${infoActividad.showInfoNull(response.data.actividad.objetivos_especificos.length > 0 ? response.data.actividad.objetivos_especificos[0].objetivo : null)}
                        </p>
                    </li>

                    <li class="collection-item">
                        <span class="title cyan-text text-darken-3">
                            Tercer objetivo específico
                        </span>
                        <p>
                            ${infoActividad.showInfoNull(response.data.actividad.objetivos_especificos.length > 0 ? response.data.actividad.objetivos_especificos[2].objetivo : null)}
                        </p>
                    </li>

                </ul>
            </div>
            <div class="col s12 m6 l6">
                <ul class="collection">

                    <li class="collection-item">
                        <span class="title cyan-text text-darken-3">
                            Objetivo General del Proyecto
                        </span>
                        <p>
                        ${infoActividad.showInfoNull(response.data.actividad.objetivo_general)}
                        </p>
                    </li>

                    <li class="collection-item">
                        <span class="title cyan-text text-darken-3">
                            Segundo objetivo específico
                        </span>
                        <p>
                            ${infoActividad.showInfoNull(response.data.actividad.objetivos_especificos.length > 0 ? response.data.actividad.objetivos_especificos[1].objetivo : null)}
                        </p>
                    </li>

                    <li class="collection-item">
                        <span class="title cyan-text text-darken-3">
                            Cuarto objetivo específico
                        </span>
                        
                        <p>
                        ${infoActividad.showInfoNull(response.data.actividad.objetivos_especificos.length > 0 ? response.data.actividad.objetivos_especificos[3].objetivo : null)}
                        </p>
                        </p>
                    </li>
                </ul>
            </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l6">
                    <ul class="collection">
                        <li class="collection-item">
                            <span class="title cyan-text text-darken-3">
                                Evidencias Prototipo producto
                            </span>
                            <p>
                                ${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.trl_prototipo)}
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title cyan-text text-darken-3">
                                Evidencias Pruebas documentadas
                            </span>
                            <p>
                                ${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.trl_pruebas)}
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col s12 m6 l6">
                    <ul class="collection">
                        <li class="collection-item">
                            <span class="title cyan-text text-darken-3">
                                Evidencias Modelo de negocio
                            </span>
                            <p>
                                ${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.trl_modelo)}
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title cyan-text text-darken-3">
                                Evidencias Normatividad
                            </span>
                            <p>
                                ${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.trl_normatividad)}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
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
                    Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.
                </span>
            </div>
            <div class="divider mailbox-divider"></div>
                <div class="row">
                <div class="col s12 m12 l12">
                        <div class="card-panel blue lighten-5">
                            <h5 class="center">Talentos que participan en el proyecto</h5>
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
                </div>
                <div class="row">
                    <div class="card-panel green lighten-5 col s12 m12 l12">
                        <h5 class="center">Dueño(s) de la propiedad intelectual</h5>
                        <div class="row">
                            <div class="col s12 m4 l4">
                                <div class="card-panel">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5>Empresas</h5></li>
                                        <div id="detalleEmpresas"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-panel">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5>Personas (Talentos)</h5></li>
                                        <div id="detallePropiedadTalentos"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-panel">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5>Grupos de Investigación</h5></li>
                                        <div id="detallePropiedadGrupo"></div>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
            infoActividad.showTalentos(response.data.actividad.articulacion_proyecto.talentos);
            infoActividad.showPropiedadIntelectualEmpresas(response.data.actividad.articulacion_proyecto.proyecto.empresas);
            infoActividad.showPropiedadIntelectualTalentos(response.data.actividad.articulacion_proyecto.proyecto.users_propietarios);
            infoActividad.showPropiedadIntelectualGrupo(response.data.actividad.articulacion_proyecto.proyecto.gruposinvestigacion);
    },
    openIsArticulacion: function(response){
        $("#detalleActividad").append(`
            <table class="striped centered">
            <TR>
                <TH width="25%">Nodo</TH>
                <TD width="25%">${response.data.actividad.nodo.entidad.nombre}</TD>
                <TH width="25%" >Linea Tecnológica</TH>
                <TD width="25%" COLSPAN=3>${response.data.actividad.gestor.lineatecnologica.abreviatura} - ${response.data.actividad.gestor.lineatecnologica.nombre}</TD>
            </TR>
            <TR>
                <TH width="25%">Código Articulación</TH>
                <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                <TH width="25%" >Nombre de Articulación</TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
            </TR>
            <TR>
                <TH width="16,6%">Fase</TH>
                <TD width="16,6%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.fase.nombre)}</TD>
                <TH width="16,6%">Fecha de Inicio </TH>
                <TD width="16,6%">${infoActividad.showDateActivity(response.data.actividad.fecha_inicio)}</TD>
                <TH width="16,6%">Fecha de cierre </TH>
                <TD width="16,6%">${infoActividad.showDateActivity(response.data.actividad.fecha_cierre)}</TD>
            </TR>
            
            <TR>
                <TH width="25%">Gestor</TH>
                <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.gestor.user.documento)} - ${response.data.actividad.gestor.user.nombres} ${response.data.actividad.gestor.user.apellidos}</TD>
                <TH width="25%">Correo Electrónico</TH>
                <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.gestor.user.email)}</TD>
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
                        ${infoActividad.showInfoNull(el.nit)} - ${infoActividad.showInfoNull(el.entidad.nombre)}
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
