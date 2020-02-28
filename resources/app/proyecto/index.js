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
        width: '6%',
        data: 'proceso',
        name: 'proceso',
        orderable: false
      },
      // {
      //   width: '6%',
      //   data: 'delete',
      //   name: 'delete',
      //   orderable: false
      // },
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
