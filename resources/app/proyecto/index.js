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
      +'<div class="divider"></div>');

      $("#detallesDeUnProyecto_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="teal-text text-darken-3">Entregables: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaArticulacion()" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');

      $('#detallesDeUnProyecto_modal').openModal();
    }
    // Modal title

  });
}


// Ajax para mostrar los talentos de del proyecto en un modal
function verTalentosDeUnProyecto(id) {
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
      type: "get",
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

// Ajax que muestra los proyectos de un NODO por año
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
      type: "get",
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
