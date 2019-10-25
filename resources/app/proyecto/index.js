$(document).ready(function() {
  consultarProyectosDelGestorPorAnho();
  consultarProyectosDelNodoPorAnho();
})

// Muestra información de un proyecto en un modal
function detallesDeUnProyecto(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/proyecto/ajaxVerDetallesDeUnProyecto/"+id
  }).done(function(respuesta){
    $("#detallesDeUnProyecto_titulo").empty();
    $("#detallesDeUnProyecto_detalle").empty();
    if (respuesta.proyecto.length == 0) {
      swal('Ups!!', 'Ha ocurrido un error', 'warning');
    } else {
      let color = "";
      if (respuesta.proyecto.revisado_final == 'Por Evaluar') {
        color = "grey lighten-2";
      } else if (respuesta.revisadofinal == 'Aprobado'){
        color = "green lighten-3";
      } else {
        color = "red lighten-3";
      }
      $("#detallesDeUnProyecto_titulo").append('<div class="row card-panel '+color+'">'+
      '<center>'+
      '<h4><span class="cyan-text text-darken-3">Nombre de Proyecto: </span>'+respuesta.proyecto.nombre+'</h4>'+
      '</center>'+
      '</div>');
      $("#detallesDeUnProyecto_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código de Proyecto: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.codigo_proyecto+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Observaciones del Proyecto: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.observaciones_proyecto+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Impacto del Proyecto: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.impacto_proyecto+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Resultados del Proyecto: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.resultado_proyecto+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Estado del Proyecto: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_estadoproyecto+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de Inicio: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.fecha_inicio+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de Cierre: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.fecha_cierre+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Tipo de Articulación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_tipoarticulacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');
      if (respuesta.proyecto.nombre_tipoarticulacion != 'Emprendedor' && respuesta.proyecto.nombre_tipoarticulacion != 'Proyecto financiado por SENNOVA' && respuesta.proyecto.nombre_tipoarticulacion != 'Otro') {
        if (respuesta.proyecto.nombre_tipoarticulacion == 'Universidades') {
          $("#detallesDeUnProyecto_detalle").append('<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="cyan-text text-darken-3">Nombre de la Universidad: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.proyecto.nombre_entidad+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>');
        } else {
          $("#detallesDeUnProyecto_detalle").append('<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="cyan-text text-darken-3">Entidad con la que se está realizando el proyecto: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.proyecto.nombre_entidad+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>');
        }
      }
      $("#detallesDeUnProyecto_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Sector: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_sector+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Área de Conocimiento: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_areaconocimiento+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Proyecto del Nodo: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_nodo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Gestor: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_gestor+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Sublínea: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.nombre_sublinea+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');
      $("#detallesDeUnProyecto_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Articulado con CT+i: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.art_cti+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');
      if (respuesta.proyecto.art_cti == 'Si') {
        $("#detallesDeUnProyecto_detalle").append('<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre del Actor CT+i: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.proyecto.nom_act_cti+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>');
      }
      $("#detallesDeUnProyecto_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Dirigido a área de emprendimiento SENA: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.diri_ar_emp+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Recibido a través del área de emprendimiento SENA: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.reci_ar_emp+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'


      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Dinero de regalías: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.dine_reg+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">¿El Proyecto pertenece a la economía naranja?: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.proyecto.economia_naranja+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');

      $("#detallesDeUnProyecto_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="teal-text text-darken-3">Entregables: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnProyecto('+respuesta.proyecto.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');

      $('#detallesDeUnProyecto_modal').openModal();
    }
    // Modal title

  });
}
function verDetallesDeLosEntregablesDeUnProyecto(id) {
  $.ajax({
     dataType:'json',
     type:'get',
     url:"/proyecto/ajaxDetallesDeLosEntregablesDeUnProyecto/"+id,
  }).done(function(respuesta){
    console.log(respuesta);

    $("#detallesEntregablesDeUnProyecto_titulo").empty();
    $("#detallesEntregablesDeUnProyecto_body").empty();
    if (respuesta.entregables == null) {
      Swal.fire(
        'Ups!!',
        'Ha ocurrido un error',
        'error'
      );
    } else {
      $("#detallesEntregablesDeUnProyecto_titulo").append("<a class='btn btn-small blue-grey' target='_blank' href='/proyecto/"+respuesta.proyecto.id+"/entregables'>Ver los Archivos</a> <span class='teal-text text-darken-3'>Código del Proyecto: </span><b>"+respuesta.proyecto.codigo_proyecto+"</b>");
      $("#detallesEntregablesDeUnProyecto_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Formator de Confidencialidad y Compromiso Firmado: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.acc+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );
      $("#detallesEntregablesDeUnProyecto_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Manual de uso de Infraestructura: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.manual_uso_inf+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );
      $("#detallesEntregablesDeUnProyecto_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Acta de Inicio: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.acta_inicio+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );
      $("#detallesEntregablesDeUnProyecto_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Estado del Arte: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.estado_arte+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );

      $("#detallesEntregablesDeUnProyecto_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Actas de Seguimiento: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.actas_seguimiento+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Video Tutorial: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.video_tutorial+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Url del Video Tutorial: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<a href='+respuesta.proyecto.url_videotutorial+' target="_blank"><span>'+respuesta.proyecto.url_videotutorial+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );

      $("#detallesEntregablesDeUnProyecto_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Ficha de Caracterización del Prototipo: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.ficha_caracterizacion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Acta de Cierre: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.acta_cierre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Encuesta de satisfacción del servicio: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.encuesta+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );
    $("#detallesEntregablesDeUnProyecto_modal").openModal();
    }
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
        if (item.rol == 'Talento Líder') {
          icon = '<i class="material-icons green-text left">face</i>'
        }
        // let talento = '<a class="waves-effect waves-light btn tooltipped cyan m-b-xs modal-trigger" onclick="talento('+item.idpersona+')" data-position="bottom" data-delay="50" data-tooltip="Información del Talento"><i class="material-icons">assignment_ind</i> Información del Talento</a>'
        $("#talentosAsociadosAUnProyecto_table").append(
          '<tr>'
          +'<td>'+icon+' '+item.rol+'</td>'
          +'<td>'+item.talento+'</td>'
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

function consultarProyectosPendientesPorAprobacion() {
  
  $('#tblproyectosPendienteDeAprobacion').dataTable().fnDestroy();
  $('#tblproyectosPendienteDeAprobacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/proyecto/datatableProyectosPendienteDeAprobacion/",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'nombre_idea',
        name: 'nombre_idea',
      },
      {
        data: 'nombre_nodo',
        name: 'nombre_nodo',
      },
      {
        data: 'nombre_gestor',
        name: 'nombre_gestor',
      },
      {
        data: 'estado_aprobacion',
        name: 'estado_aprobacion',
      },
      {
        width: '8%',
        data: 'aprobar',
        name: 'aprobar',
        orderable: false
      },
    ],
  });
  // if (id === '') {
  //   swal('Advertencia!', 'Seleccione un nodo válido', 'error');
  // } else {
  //
  // }
}


// Ajax que muestra los proyectos de un gestor por año
function consultarProyectosDelGestorPorAnho() {
  // console.log('event');
  let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
  // let gestor = $('#txtgestor_id').val();
  $('#tblproyectosGestorPorAnho').dataTable().fnDestroy();
  $('#tblproyectosGestorPorAnho').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/proyecto/datatableProyectosDelGestorPorAnho/"+0+"/"+anho,
      // type: "get",
      data: function (d) {
        d.codigo_proyecto = $('.codigo_proyecto').val(),
        d.nombre = $('.nombre').val(),
        d.sublinea_nombre = $('.sublinea_nombre').val(),
        d.estado_nombre = $('.estado_nombre').val(),
        d.revisado_final = $('.revisado_final').val(),
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
        data: 'sublinea_nombre',
        name: 'sublinea_nombre',
      },
      {
        data: 'estado_nombre',
        name: 'estado_nombre',
      },
      {
        data: 'revisado_final',
        name: 'revisado_final',
      },
      {
        width: '8%',
        data: 'talentos',
        name: 'talentos',
        orderable: false
      },
      {
        width: '8%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '8%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        width: '8%',
        data: 'entregables',
        name: 'entregables',
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

$(".sublinea_nombre").keyup(function(){
  $('#tblproyectosGestorPorAnho').DataTable().draw();
});

$(".estado_nombre").keyup(function(){
  $('#tblproyectosGestorPorAnho').DataTable().draw();
});

$(".revisado_final").keyup(function(){
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

$("#estado_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

$("#revisado_final_tblProyectosDelNodoPorAnho").keyup(function(){
  $('#tblproyectosDelNodoPorAnho').DataTable().draw();
});

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
    ajax:{
      url: "/proyecto/datatableProyectosDelNodoPorAnho/"+0+"/"+anho_proyectos_nodo,
      data: function (d) {
        d.codigo_proyecto = $('#codigo_proyecto_tblProyectosDelNodoPorAnho').val(),
        d.gestor = $('#gestor_tblProyectosDelNodoPorAnho').val(),
        d.nombre = $('#nombre_tblProyectosDelNodoPorAnho').val(),
        d.sublinea_nombre = $('#sublinea_nombre_tblProyectosDelNodoPorAnho').val(),
        d.estado_nombre = $('#estado_nombre_tblProyectosDelNodoPorAnho').val(),
        d.revisado_final = $('#revisado_final_tblProyectosDelNodoPorAnho').val(),
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
        data: 'estado_nombre',
        name: 'estado_nombre',
      },
      {
        data: 'revisado_final',
        name: 'revisado_final',
      },
      {
        width: '6%',
        data: 'talentos',
        name: 'talentos',
        orderable: false
      },
      {
        width: '6%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '6%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        width: '6%',
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
      {
        width: '6%',
        data: 'delete',
        name: 'delete',
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
