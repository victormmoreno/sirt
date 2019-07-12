$(document).ready(function() {
    
    $('#linea_table').DataTable({
        language: {
            // "sProcessing": "Procesando...",
            // "sLengthMenu": "Mostrar _MENU_ registros",
            // "sZeroRecords": "No se encontraron resultados",
            // "sEmptyTable": "Ningún dato disponible en esta tabla",
            // "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            // "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            // "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            // "sInfoPostFix": "",
            // "sSearch": "Buscar:",
            // "sUrl": "",
            // "sInfoThousands": ",",
            // "sLoadingRecords": "Cargando...",
            // "oPaginate": {
            //     "sFirst": "Primero",
            //     "sLast": "Último",
            //     "sNext": "Siguiente",
            //     "sPrevious": "Anterior"
            // },
            // "oAria": {
            //     "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            // }
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "lineas",
        },
        columns: [
        	{
        		data: 'abreviatura',
        		name: 'abreviatura',
        	},
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
        	{
        		data: 'descripcion',
        		name: 'descripcion',
        	},
        	{
        		data: 'action',
        		name: 'action',
        		orderable: false
        	},

        ],
    });


            

});


$(document).ready(function() {
    
    $('#nodos_table').DataTable({
        language: {
            // "sProcessing": "Procesando...",
            // "sLengthMenu": "Mostrar _MENU_ registros",
            // "sZeroRecords": "No se encontraron resultados",
            // "sEmptyTable": "Ningún dato disponible en esta tabla",
            // "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            // "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            // "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            // "sInfoPostFix": "",
            // "sSearch": "Buscar:",
            // "sUrl": "",
            // "sInfoThousands": ",",
            // "sLoadingRecords": "Cargando...",
            // "oPaginate": {
            //     "sFirst": "Primero",
            //     "sLast": "Último",
            //     "sNext": "Siguiente",
            //     "sPrevious": "Anterior"
            // },
            // "oAria": {
            //     "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            // }
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "/nodo",
        },
        columns: [
        	{
        		data: 'centro',
        		name: 'centro',
        	},
        	{
        		data: 'nodos',
        		name: 'nodos',
        	},
        	{
        		data: 'direccion',
        		name: 'direccion',
        	},
            {
                data: 'ubicacion',
                name: 'ubicacion',
            },
        	{
        		data: 'detail',
        		name: 'detail',
        		orderable: false
        	},
            {
                data: 'edit',
                name: 'edit',
                orderable: false
            },

        ],
    });


            

});
$(document).ready(function() {

  $('#ideas_emprendedores_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "idea",
      type: "get",
    },
    columns: [
      {
        data: 'consecutivo',
        name: 'consecutivo',
      },
      {
        data: 'fecha_registro',
        name: 'fecha_registro',
      },
      {
        data: 'persona',
        name: 'persona',
      },
      {
        data: 'correo',
        name: 'correo',
      },
      {
        data: 'contacto',
        name: 'contacto',
      },
      {
        data: 'nombre_idea',
        name: 'nombre_idea',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        data: 'soft_delete',
        name: 'soft_delete',
        orderable: false
      },
      {
        data: 'dont_apply',
        name: 'dont_apply',
        orderable: false
      },

    ],
    initComplete: function () {
      this.api().columns().every(function () {
        var column = this;
        var input = document.createElement("input");
        $(input).appendTo($(column.footer()).empty())
        .on('change', function () {
          column.search($(this).val(), false, false, true).draw();
        });
      });
    }
  });

});

function secondDataTable() {
  if (!$.fn.dataTable.isDataTable('#tblideasempresas')) {
    $('#tblideasempresas').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      // order: [[0, 'desc']],
      // buttons: [
        //     'csv', 'excel', 'pdf', 'print', 'reset', 'reload'
        // ],
            ajax:{
              url: "idea/ideasEmpGI",
              type: "get",
            },
        // ajax: 'idea/ideasEmpGI',
        columns: [
          {
            data: 'consecutivo',
            name: 'consecutivo',
          },
          {
            data: 'fecha_registro',
            name: 'fecha_registro',
          },
          {
            data: 'nit',
            name: 'nit',
          },
          {
            data: 'razon_social',
            name: 'razon_social',
          },
          {
            data: 'nombre_idea',
            name: 'nombre_idea',
          },
        ],
        // order: [[0, 'desc']]
      });
    }
  }

$('#ideas_emprendedores_table .dataTables_length select').addClass('browser-default');

function detallesIdeaPorId(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/idea/detallesIdea/"+id
  }).done(function(respuesta){
    // console.log(respuesta);
    $("#titulo").empty();
    $("#detalle_idea").empty();
    if (respuesta == null) {
      swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
      $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+respuesta.detalles.nombre_proyecto+"");
      $("#detalle_idea").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.aprendiz_sena+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.pregunta1String+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.pregunta2String+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Descripcion: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.descripcion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Objetivo: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.objetivo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Alcance: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.alcance+'</span>'
      +'</div>'
      +'</div>'
    );
    $('#modal1').openModal();
  }
})
}

function consultarIdeasPorNodo() {
  let idNodo = $('#txtnodo').val();
  consultarIdeasEmprendedoresPorNodo(idNodo);
  consultarIdeasEmpresasGIPorNodo(idNodo);
}

function consultarIdeasEmprendedoresPorNodo(idNodo) {
  $('#ideasEmprendedoresPorNodo_table').dataTable().fnDestroy();
  $('#ideasEmprendedoresPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "/idea/consultarIdeasEmprendedoresPorNodo/"+idNodo,
      type: "get",
    },
    columns: [
      {
        data: 'consecutivo',
        name: 'consecutivo',
      },
      {
        data: 'fecha_registro',
        name: 'fecha_registro',
      },
      {
        data: 'persona',
        name: 'persona',
      },
      {
        data: 'correo',
        name: 'correo',
      },
      {
        data: 'contacto',
        name: 'contacto',
      },
      {
        data: 'nombre_idea',
        name: 'nombre_idea',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },

    ],
  });
}
//--- Server side de la datatable que muestra las
function consultarIdeasEmpresasGIPorNodo(idNodo) {
  $('#ideasEmpresasGIPorNodo_table').dataTable().fnDestroy();
  $('#ideasEmpresasGIPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "/idea/consultarIdeasEmpresasGIPorNodo/"+idNodo,
      type: "get",
    },
    columns: [
      {
        data: 'consecutivo',
        name: 'consecutivo',
      },
      {
        data: 'fecha_registro',
        name: 'fecha_registro',
      },
      {
        data: 'nit',
        name: 'nit',
      },
      {
        data: 'razon_social',
        name: 'razon_social',
      },
      {
        data: 'nombre_idea',
        name: 'nombre_idea',
      },
    ],
  });
}

$(document).ready(function() {

  consultarIdeasEmprendedoresPorNodo(0);
  consultarIdeasEmpresasGIPorNodo(0);

});

function detallesIdeasDelEntrenamiento(id){
  $.ajax({
     dataType:'json',
     type:'get',
     url:"entrenamientos/"+id,
     data: {
       identrenamiento: id,
     }
  }).done(function(respuesta){
    $("#ideasEntrenamiento").empty();
    if (respuesta != null ) {
      $("#fechasEntrenamiento").empty();
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Primera Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Segunda Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion2+"");
      $.each(respuesta, function(i, item) {
        $("#ideasEntrenamiento").append("<tr><td>"+item.nombre_proyecto+
          "</td><td>"+item.confirmacion+"</td><td>"+item.convocado+"</td><td>"+item.canvas+"</td><td>"+item.asistencia1+"</td><td>"+item.asistencia2+"</td></tr>");
      });
      $('#modalIdeasEntrenamiento').openModal();
    }
  });
}

$(document).ready(function() {
  $('#entrenamientosPorNodo_tableDinamizador').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/entrenamientos/consultarEntrenamientosPorNodo",
      type: "get",
    },
    columns: [
      {
        data: 'id',
        name: 'id',
      },
      {
        data: 'fecha_sesion1',
        name: 'fecha_sesion1',
      },
      {
        data: 'fecha_sesion2',
        name: 'fecha_sesion2',
      },
      {
        data: 'correos',
        name: 'correos',
      },
      {
        data: 'fotos',
        name: 'fotos',
      },
      {
        data: 'listado_asistencia',
        name: 'listado_asistencia',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
    ],
  });
});

function consultarEntrenamientosPorNodo_Administrador(id) {
  $('#entrenamientosPorNodo_tableAdministrador').dataTable().fnDestroy();
  $('#entrenamientosPorNodo_tableAdministrador').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/entrenamientos/consultarEntrenamientosPorNodo/"+id.value,
      type: "get",
    },
    columns: [
      {
        data: 'id',
        name: 'id',
      },
      {
        data: 'fecha_sesion1',
        name: 'fecha_sesion1',
      },
      {
        data: 'fecha_sesion2',
        name: 'fecha_sesion2',
      },
      {
        data: 'correos',
        name: 'correos',
      },
      {
        data: 'fotos',
        name: 'fotos',
      },
      {
        data: 'listado_asistencia',
        name: 'listado_asistencia',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
    ],
  });
}

function noSeEncontraronResultados() {
  Swal.fire({
    title: '¿Desea inhabilitar elentrenamiento?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, inhabilitar'
  })
}

$(document).ready(function() {
  $('#entrenamientos_nodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "entrenamientos",
      type: "get",
    },
    columns: [
      {
        data: 'id',
        name: 'id',
      },
      {
        data: 'fecha_sesion1',
        name: 'fecha_sesion1',
      },
      {
        data: 'fecha_sesion2',
        name: 'fecha_sesion2',
      },
      {
        data: 'correos',
        name: 'correos',
      },
      {
        data: 'fotos',
        name: 'fotos',
      },
      {
        data: 'listado_asistencia',
        name: 'listado_asistencia',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        data: 'update_state',
        name: 'update_state',
        orderable: false
      },
    ],
  });
});

// function inhabilitarEntrenamientoPorId(id) {
//   $.ajax({
//      dataType:'json',
//      type:'get',
//      url:"entrenamientos/inhabilitarEntrenamiento/"+id,
//   }).done(function(respuesta){
//     // $("#ideasEntrenamiento").empty();
//     // if (respuesta != null ) {
//     //   $("#fechasEntrenamiento").empty();
//     //   $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Primera Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
//     //   $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Segunda Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion2+"");
//     //   $.each(respuesta, function(i, item) {
//     //     $("#ideasEntrenamiento").append("<tr><td>"+item.nombre_proyecto+
//     //       "</td><td>"+item.confirmacion+"</td><td>"+item.convocado+"</td><td>"+item.canvas+"</td><td>"+item.asistencia1+"</td><td>"+item.asistencia2+"</td></tr>");
//     //   });
//     //   $('#modalIdeasEntrenamiento').openModal();
//     // }
//   });
// }

function inhabilitarEntrenamientoPorId(id, e) {
  Swal.fire({
    title: '¿Desea inhabilitar elentrenamiento?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, inhabilitar'
  }).then((result) => {
    if (result.value) {
      Swal.fire({
        // confirmButtonColor: '#3085d6',
        // cancelButtonText: 'Regresar las ideas de proyecto al estado de Inicio',
        // confirmButtonAriaLabel: 'Thumbs up, great!',
        // cancelButtonAriaLabel: 'Thumbs down',
        // confirmButtonText: 'Inhabilitar las ideas de proyecto',
        title: '¿Qué desea hacer?',
        text: "Seleccione lo que ocurrirá con las ideas de proyecto que están asociasdas al entrenamiento",
        type: 'warning',
        footer: '<a onclick="Swal.close()" href="#">Cancelar</a>',
        confirmButtonText: '<a class="white-text" onclick="meth('+id+',6); Swal.close()" href="#">Inhabilitar las ideas de proyecto</a>',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        cancelButtonText: '<a class="white-text" onclick="meth('+id+',1); Swal.close()" href="#">Regresar las ideas de proyecto al estado de Inicio</a>',
        focusConfirm: false,
      })
    }
  })
}

function meth(idea, estado) {
  // console.log(idea+', '+estado);
    $.ajax({
       dataType:'json',
       type:'get',
       url:"entrenamientos/inhabilitarEntrenamiento/"+idea+"/"+estado,
    }).done(function(respuesta){
      // $("#ideasEntrenamiento").empty();
      // if (respuesta != null ) {
      //   $("#fechasEntrenamiento").empty();
      //   $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Primera Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
      //   $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Segunda Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion2+"");
      //   $.each(respuesta, function(i, item) {
      //     $("#ideasEntrenamiento").append("<tr><td>"+item.nombre_proyecto+
      //       "</td><td>"+item.confirmacion+"</td><td>"+item.convocado+"</td><td>"+item.canvas+"</td><td>"+item.asistencia1+"</td><td>"+item.asistencia2+"</td></tr>");
      //   });
      //   $('#modalIdeasEntrenamiento').openModal();
      // }
    });
}

$(document).ready(function() {
  entrenamiento.getIdeas();
  $('#txtfecha_sesion2').bootstrapMaterialDatePicker({
    time:false,
    date:true,
    shortTime:true,
    format: 'YYYY-MM-DD',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
  });

  $('#txtfecha_sesion1').bootstrapMaterialDatePicker({
    time:false,
    date:true,
    shortTime:true,
    format: 'YYYY-MM-DD',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
  }).on('change', function(e, date)
  {
    $('#txtsegundasesion').bootstrapMaterialDatePicker('setMinDate', date);
  });
});
entrenamiento = {
  addIdea:function(){
    let Idea = $("#txtidea").val();
    let token = $("#formEntrenamientos input[name=_token]").val();

    $.ajax({
      dataType:'json',
      type:'post',
      url:'/entrenamientos/addidea',
      data: {
        'Idea':Idea,
        '_token':token
      }
    }).done(function(response){
      if (response.data == 3) {
        Swal.fire({
          title: 'Error!',
          text: 'La idea de proyecto ya está asociada al entrenamiento!',
          type: 'warning',
          confirmButtonText: 'Cool'
        })
      } else {
        entrenamiento.getIdeas();
      }
    })

  },
  getIdeas:function(){
    $.ajax({
      dataType:'json',
      type:'get',
      url:'/entrenamientos/getideasEntrenamiento'
    }).done(function(respuesta){
      $('#tblIdeasEntrenamientoCreate').empty();
      $.each(respuesta, function (i,elemento){
        let confirm = elemento.Confirm == 1 ? "checked" : "";
        let canvas = elemento.Canvas == 1 ? "checked" : "";
        let assistf = elemento.AssistF == 1 ? "checked" : "";
        let assists = elemento.AssistS == 1 ? "checked" : "";
        let convocado = elemento.Convocado == 1 ? "checked" : "";
        $('#tblIdeasEntrenamientoCreate').append('<tr>'
        +'<td>'+elemento.nombre_proyecto+'</td>'
        +'<td>'+elemento.nombres_contacto+' '+elemento.apellidos_contacto+'</td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+confirm+' onclick="entrenamiento.getConfirm('+elemento.id+', '+(elemento.Confirm == 1 ? 1 : 0)+')" name="confirmacion" id="confirmacion'+elemento.id+'" value="1"/><label for="confirmacion'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+canvas+' onclick="entrenamiento.getCanvas('+elemento.id+', '+(elemento.Canvas == 1 ? 1 : 0)+')" name="canvas" id="canvas'+elemento.id+'" value="1"/><label for="canvas'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+assistf+' onclick="entrenamiento.getAssistF('+elemento.id+', '+(elemento.AssistF == 1 ? 1 : 0)+')" name="asistencia_primera_sesion" id="asistencia_primera_sesion'+elemento.id+'" value="1"/><label for="asistencia_primera_sesion'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+assists+' onclick="entrenamiento.getAssistS('+elemento.id+', '+(elemento.AssistS == 1 ? 1 : 0)+')" name="asistencia_segunda_sesion" id="asistencia_segunda_sesion'+elemento.id+'" value="1"/><label for="asistencia_segunda_sesion'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+convocado+' onclick="entrenamiento.getConvocado('+elemento.id+', '+(elemento.Convocado == 1 ? 1 : 0)+')" name="csibt_convocado" id="csibt_convocado'+elemento.id+'" value="1"/><label for="csibt_convocado'+elemento.id+'"></label></p></td>'
        +'<td><a class="waves-effect red lighten-3 btn" onclick="entrenamiento.getEliminar('+elemento.id+');"><i class="material-icons">delete_sweep</i></a></td>'
        +'</tr>');
      })
    })
  },
  // <p class="p-v-xs"><input type="checkbox" id="txtfotos" name="txtfotos" value="1"/><label for="txtfotos">Evidencias Fotográficas</label></p>
  getEliminar:function (idIdea) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/entrenamientos/eliminar/'+idIdea,
    }).done(function(respuesta){
      entrenamiento.getIdeas();
    })
  },
  getConfirm:function (idIdea, estado) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/entrenamientos/getConfirm/'+idIdea+'/'+estado,
    }).done(function(respuesta){
      entrenamiento.getIdeas();
    });
  },
  getCanvas:function (idIdea, estado) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/entrenamientos/getCanvas/'+idIdea+'/'+estado,
    }).done(function(respuesta){
      entrenamiento.getIdeas();
    });
  },
  getAssistF:function (idIdea, estado) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/entrenamientos/getAssistF/'+idIdea+'/'+estado,
    }).done(function(respuesta){
      entrenamiento.getIdeas();
    });
  },
  getAssistS:function (idIdea, estado) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/entrenamientos/getAssistS/'+idIdea+'/'+estado,
    }).done(function(respuesta){
      entrenamiento.getIdeas();
    });
  },
  getConvocado:function (idIdea, estado) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/entrenamientos/getConvocado/'+idIdea+'/'+estado,
    }).done(function(respuesta){
      entrenamiento.getIdeas();
    });
  }
}

$(document).ready(function() {
  entrenamientoEdit.cargarIdeasEdit();
});
entrenamientoEdit = {
  cargarIdeasEdit:function(){
    let entrenamiento = $("#xxx").val();
    let token = $("#formEntrenamientosEdit input[name=_token]").val();

    $.ajax({
      dataType:'json',
      type:'post',
      url:'/entrenamientos/cargarIdeas',
      data: {
        'entrenamiento':entrenamiento,
        '_token':token
      }
    }).done(function(response){
      if (response.data == 3) {
        swal("Error!", "La idea de proyecto ya está asociada al entrenamiento!", "warning");
      } else {
        entrenamientoEdit.getIdeasEdit();
      }
    })
  },
  getIdeasEdit:function(){
    $.ajax({
      dataType:'json',
      type:'get',
      url:'/entrenamientos/getideasEntrenamientoEdit'
    }).done(function(respuesta){
      $('#tblIdeasEntrenamientoCreateEdit').empty();
      $.each(respuesta, function (i,elemento){
        let confirm = elemento.Confirm == 1 ? "checked" : "";
        let canvas = elemento.Canvas == 1 ? "checked" : "";
        let assistf = elemento.AssistF == 1 ? "checked" : "";
        let assists = elemento.AssistS == 1 ? "checked" : "";
        let convocado = elemento.Convocado == 1 ? "checked" : "";
        $('#tblIdeasEntrenamientoCreate').append('<tr>'
        +'<td>'+elemento.nombre_proyecto+'</td>'
        +'<td>'+elemento.nombres_contacto+' '+elemento.apellidos_contacto+'</td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+confirm+' onclick="entrenamiento.getConfirm('+elemento.id+', '+(elemento.Confirm == 1 ? 1 : 0)+')" name="confirmacion" id="confirmacion'+elemento.id+'" value="1"/><label for="confirmacion'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+canvas+' onclick="entrenamiento.getCanvas('+elemento.id+', '+(elemento.Canvas == 1 ? 1 : 0)+')" name="canvas" id="canvas'+elemento.id+'" value="1"/><label for="canvas'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+assistf+' onclick="entrenamiento.getAssistF('+elemento.id+', '+(elemento.AssistF == 1 ? 1 : 0)+')" name="asistencia_primera_sesion" id="asistencia_primera_sesion'+elemento.id+'" value="1"/><label for="asistencia_primera_sesion'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+assists+' onclick="entrenamiento.getAssistS('+elemento.id+', '+(elemento.AssistS == 1 ? 1 : 0)+')" name="asistencia_segunda_sesion" id="asistencia_segunda_sesion'+elemento.id+'" value="1"/><label for="asistencia_segunda_sesion'+elemento.id+'"></label></p></td>'
        +'<td><p class="center p-v-xs"><input type="checkbox" '+convocado+' onclick="entrenamiento.getConvocado('+elemento.id+', '+(elemento.Convocado == 1 ? 1 : 0)+')" name="csibt_convocado" id="csibt_convocado'+elemento.id+'" value="1"/><label for="csibt_convocado'+elemento.id+'"></label></p></td>'
        +'<td><a class="waves-effect red lighten-3 btn" onclick="entrenamiento.getEliminar('+elemento.id+');"><i class="material-icons">delete_sweep</i></a></td>'
        +'</tr>');
      })
    })
  },
  // <p class="p-v-xs"><input type="checkbox" id="txtfotos" name="txtfotos" value="1"/><label for="txtfotos">Evidencias Fotográficas</label></p>
  // getEliminar:function (idIdea) {
  //   $.ajax({
  //     type:'get',
  //     dataType:'json',
  //     url:'/entrenamientos/eliminar/'+idIdea,
  //   }).done(function(respuesta){
  //     entrenamiento.getIdeas();
  //   })
  // },
  // getConfirm:function (idIdea, estado) {
  //   $.ajax({
  //     type:'get',
  //     dataType:'json',
  //     url:'/entrenamientos/getConfirm/'+idIdea+'/'+estado,
  //   }).done(function(respuesta){
  //     entrenamiento.getIdeas();
  //   });
  // },
  // getCanvas:function (idIdea, estado) {
  //   $.ajax({
  //     type:'get',
  //     dataType:'json',
  //     url:'/entrenamientos/getCanvas/'+idIdea+'/'+estado,
  //   }).done(function(respuesta){
  //     entrenamiento.getIdeas();
  //   });
  // },
  // getAssistF:function (idIdea, estado) {
  //   $.ajax({
  //     type:'get',
  //     dataType:'json',
  //     url:'/entrenamientos/getAssistF/'+idIdea+'/'+estado,
  //   }).done(function(respuesta){
  //     entrenamiento.getIdeas();
  //   });
  // },
  // getAssistS:function (idIdea, estado) {
  //   $.ajax({
  //     type:'get',
  //     dataType:'json',
  //     url:'/entrenamientos/getAssistS/'+idIdea+'/'+estado,
  //   }).done(function(respuesta){
  //     entrenamiento.getIdeas();
  //   });
  // },
  // getConvocado:function (idIdea, estado) {
  //   $.ajax({
  //     type:'get',
  //     dataType:'json',
  //     url:'/entrenamientos/getConvocado/'+idIdea+'/'+estado,
  //   }).done(function(respuesta){
  //     entrenamiento.getIdeas();
  //   });
  // }
}

$(document).ready(function() {
$('.dataTables_length select').addClass('browser-default');
  $('#comitesDelNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "/csibt",
      type: "get",
    },
    columns: [
      {
        data: 'codigo',
        name: 'codigo',
      },
      {
        data: 'fechacomite',
        name: 'fechacomite',
      },
      {
        data: 'observaciones',
        name: 'observaciones',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },

    ],
    initComplete: function () {
      this.api().columns().every(function () {
        var column = this;
        var input = document.createElement("input");
        $(input).appendTo($(column.footer()).empty())
        .on('change', function () {
          column.search($(this).val(), false, false, true).draw();
        });
      });
    }
  });

});

csibt = {
  consultarComitesPorNodo:function (id) {
    $.ajax({
      dataType:'json',
      type:'get',
      url:"/csibt/"+id,
    }).done(function(respuesta){
      console.log(respuesta);
      $("#ideasProyectoDeUnComite").empty();
      if (respuesta != null ) {
        $("#fechaComiteModal").empty();
        $("#fechaComiteModal").append("<span class='cyan-text text-darken-3'>Fecha del Comité: </span>"+respuesta.ideasDelComite[0].fechacomite+"");
        $.each(respuesta.ideasDelComite, function(i, item) {
          let ideaDetalle = '<a class="btn cyan m-b-xs" onclick="csibt.consultarIdeaProyectoAsociadaAlEntrenamiento('+item.id+')"><i class="material-icons">library_books</i></a>'

          let editarIdea = '<a target="_blank" href="/idea/'+item.id+'/edit" class="waves-effect waves-light btn btn-info m-b-xs">'+
          '<i class="material-icons">edit</i>'+
          '</a>'

          $("#ideasProyectoDeUnComite").append("<tr><td>"+item.nombre_proyecto+
          "</td><td>"+item.hora+"</td><td>"+item.asistencia+"</td><td>"+item.observaciones+"</td><td>"+item.admitido+"</td><td>"+editarIdea+"</td><td>"+ideaDetalle+"</td></tr>");
        });
        $('#modalIdeasComite').openModal();
      }
    });
  },
  consultarIdeaProyectoAsociadaAlEntrenamiento:function (idIdea) {
    $.ajax({
       dataType:'json',
       type:'get',
       url:"/idea/detallesIdea/"+idIdea
    }).done(function(respuesta){
      $("#titulo").empty();
      $("#detalle_idea").empty();
      if (respuesta == null) {
        swal('Ups!!', 'Ha ocurrido un error', 'warning');
      } else {
        $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+respuesta.detalles.nombre_proyecto+"");
        $("#detalle_idea").append('<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.aprendiz_sena+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.pregunta1String+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.pregunta2String+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Descripcion: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.descripcion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Objetivo: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.objetivo+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Alcance: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.alcance+'</span>'
        +'</div>'
        +'</div>'
      );
      $('#ideaProyecto').openModal();
      }
    });
  }


}

$(document).ready(function() {
  csibt_create.getIdeasEnLaSesionDelComite();
  $('#txtfechacomite_create').bootstrapMaterialDatePicker({
    time:false,
    date:true,
    shortTime:true,
    format: 'YYYY-MM-DD',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
  });
  $('#txthoraidea').bootstrapMaterialDatePicker({
  time:true,
  date:false,
  shortTime:true,
  format: 'HH:mm',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});
});

// Reinicializa los campos de la idea
function reInitCamposDeLaIdea() {
  $("#txtideaproyecto").val('0');
  $("#txtideaproyecto").select2();
  $('#txthoraidea').val('');
  $("#txtobservacionesidea").val('');
  $("#labelobservacionesidea").removeClass('active');
  $('input:checkbox').removeAttr('checked');
}

csibt_create = {
  addIdeaDeProyectoAlComite:function(){
    let idIdea = $("#txtideaproyecto").val();
    if (idIdea == 0) {
      Swal.fire({
        title: 'Por favor seleccione por la idea de proyecto que se asociará al comité',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        // cancelButtonColor: '#d33',
        // cancelButtonText: 'Cancelar',
        confirmButtonText: 'Entendido!'
      })
    } else {
      let horaCitacionDeLaIdea = $('#txthoraidea').val();
      let asistenciaAlComite = 0;
      let ideaAdmitida = 0;
      let observacionesIdea = $('#txtobservacionesidea').val();
      if (horaCitacionDeLaIdea == "") {
        Swal.fire({
          title: 'Por favor seleccione la hora que se presentará la idea de proyecto',
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Entendido!'
        })
      } else {
        if ( $('#txtasistencia').is(":checked") ) {
          asistenciaAlComite = 1
        }

        if ( $('#txtadmitido').is(":checked") ) {
          ideaAdmitida = 1;
        }
        console.log('Asistencia');
        console.log(asistenciaAlComite);
        console.log('Admitido');
        console.log(ideaAdmitida);

        let token = $("#formComiteCreate input[name=_token]").val();

        $.ajax({
          dataType:'json',
          type:'post',
          url:'/csibt/addIdeaComite',
          data: {
            'Idea':idIdea,
            'hora':horaCitacionDeLaIdea,
            'asistencia':asistenciaAlComite,
            'observaciones':observacionesIdea,
            'admitido':ideaAdmitida,
            '_token':token
          }
        }).done(function(response){
          if (response.data == 3) {
            Swal.fire({
              title: 'Error!',
              text: 'La idea de proyecto ya está asociada al comité!',
              type: 'warning',
              confirmButtonText: 'Cool'
            })
          } else if (response.data == 2) {
            // Alerta de notificación de que si se agregó la idea de proyecto a la sesion del comité
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              type: 'success',
              title: 'La idea de proyecto se asoció con éxito al comité'
            })
            reInitCamposDeLaIdea()
            csibt_create.getIdeasEnLaSesionDelComite();
          } else {

          }
        })
      }
    }
  },
  getIdeasEnLaSesionDelComite:function(){
    $.ajax({
      dataType:'json',
      type:'get',
      url:'/csibt/getideasComiteCreate'
    }).done(function(respuesta){
      $('#tblIdeasComiteCreate').empty();
      $.each(respuesta, function (i,elemento){
        let asistencia = "No";
        let admitido = "No";
        if(elemento.Asistencia == 1) {
          asistencia = "Si";
        }

        if(elemento.Admitido == 1) {
          admitido = "Si";
        }
        $('#tblIdeasComiteCreate').append('<tr>'
        +'<td>'+elemento.nombre_proyecto+'</td>'
        +'<td>'+elemento.Hora+'</td>'
        +'<td>'+asistencia+'</td>'
        +'<td>'+elemento.Observaciones+'</td>'
        +'<td>'+admitido+'</td>'
        +'<td><a class="waves-effect red lighten-3 btn" onclick="csibt_create.getEliminarIdeaEnLaSesionDelComite('+elemento.id+');"><i class="material-icons">delete_sweep</i></a></td>'
        +'</tr>');
      })
    })
  },
  getEliminarIdeaEnLaSesionDelComite:function (idIdea) {
    $.ajax({
      type:'get',
      dataType:'json',
      url:'/csibt/eliminarIdeaCC/'+idIdea,
    }).done(function(respuesta){
      if (respuesta.data == 1) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'La idea de proyecto se eliminó con éxito del comité'
        })
      }
      csibt_create.getIdeasEnLaSesionDelComite();
    })
  },

}

$(document).ready(function() {
  // alert('2321');
  $('#comitesDelNodoGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "/csibt",
      type: "get",
    },
    columns: [
      {
        data: 'codigo',
        name: 'codigo',
      },
      {
        data: 'fechacomite',
        name: 'fechacomite',
      },
      {
        data: 'observaciones',
        name: 'observaciones',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },

    ],
    initComplete: function () {
      this.api().columns().every(function () {
        var column = this;
        var input = document.createElement("input");
        $(input).appendTo($(column.footer()).empty())
        .on('change', function () {
          column.search($(this).val(), false, false, true).draw();
        });
      });
    }
  });

});

// Ajax para consultar los comités de un nodo y mostrarlos en la tabla
function consultarCsibtPorNodo() {
  let id = $('#txtnodo').val();
  $('#comitesDelNodoAdministrador_table').dataTable().fnDestroy();
  $('#comitesDelNodoAdministrador_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "/csibt/"+id+"/consultarCsibtPorNodo",
      type: "get",
    },
    columns: [
      {
        data: 'codigo',
        name: 'codigo',
      },
      {
        data: 'fechacomite',
        name: 'fechacomite',
      },
      {
        data: 'observaciones',
        name: 'observaciones',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },

    ],
  });
}

$(document).ready(function() {
  $('#empresasDeTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/empresa/datatableEmpresasDeTecnoparque",
      type: "get",
    },
    columns: [
      {
        data: 'nit',
        name: 'nit',
      },
      {
        data: 'nombre_empresa',
        name: 'nombre_empresa',
      },
      {
        data: 'sector_empresa',
        name: 'sector_empresa',
      },
      {
        data: 'ciudad',
        name: 'ciudad',
      },
      {
        data: 'direccion',
        name: 'direccion',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });

  $('#empresasDeTecnoparque_tableNoGestor').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/empresa/datatableEmpresasDeTecnoparque",
      type: "get",
    },
    columns: [
      {
        data: 'nit',
        name: 'nit',
      },
      {
        data: 'nombre_empresa',
        name: 'nombre_empresa',
      },
      {
        data: 'sector_empresa',
        name: 'sector_empresa',
      },
      {
        data: 'ciudad',
        name: 'ciudad',
      },
      {
        data: 'direccion',
        name: 'direccion',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      // {
      //   data: 'soft_delete',
      //   name: 'soft_delete',
      //   orderable: false
      // },
    ],
  });
});

var empresaIndex = {
  consultarDetallesDeUnaEmpresa:function(id){
    $.ajax({
      dataType:'json',
      type:'get',
      url:"/empresa/ajaxDetallesDeUnaEmpresa/"+id
    }).done(function(respuesta){
      $("#modalDetalleDeUnaEmpresaTecnoparque_titulo").empty();
      $("#modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa").empty();
      if (respuesta == null) {
        swal('Ups!!', 'Ha ocurrido un error', 'warning');
      } else {
        $("#modalDetalleDeUnaEmpresaTecnoparque_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>");
        $("#modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa").append("<div class='row'>"
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nit de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nit+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nombre_empresa+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Dirección de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.direccion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Ciudad de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.ciudad+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Email de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.email_entidad+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre del Contacto: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nombre_contacto+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Teléfono del Contacto: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">' + respuesta.detalles.telefono_contacto + '</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Correo del Contacto: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.correo_contacto+'</span>'
        +'</div>'
        +'</div>'
      );
      $('#detalleDeUnaEmpresaTecnoparque').openModal();
    }
  });
  },
}

$(document).ready(function() {
  $('#grupoDeInvestigacionTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: "/grupo/datatableGruposInvestigacionDeTecnoparque",
      type: "get",
    },
    columns: [
      {
        data: 'codigo_grupo',
        name: 'codigo_grupo',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'ciudad',
        name: 'ciudad',
      },
      {
        data: 'tipo_grupo',
        name: 'tipo_grupo',
      },
      {
        data: 'institucion',
        name: 'institucion',
      },
      {
        data: 'clasificacioncolciencias',
        name: 'clasificacioncolciencias',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
});

  $('#grupoDeInvestigacionTecnoparque_tableNoGestor').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/grupo/datatableGruposInvestigacionDeTecnoparque",
      type: "get",
    },
    columns: [
      {
        data: 'codigo_grupo',
        name: 'codigo_grupo',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'ciudad',
        name: 'ciudad',
      },
      {
        data: 'tipo_grupo',
        name: 'tipo_grupo',
      },
      {
        data: 'institucion',
        name: 'institucion',
      },
      {
        data: 'clasificacioncolciencias',
        name: 'clasificacioncolciencias',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
    ],
  });

var grupoInvestigacionIndex = {
  consultarDetallesDeUnGrupoInvestigacion:function(id){
    $.ajax({
      dataType:'json',
      type:'get',
      url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+id
    }).done(function(respuesta){
      $("#modalDetalleDeUnGrupoDeInvestigacion_titulo").empty();
      $("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").empty();
      if (respuesta == null) {
        swal('Ups!!', 'Ha ocurrido un error', 'warning');
      } else {
        $("#modalDetalleDeUnGrupoDeInvestigacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>");
        $("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").append("<div class='row'>"
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.codigo_grupo+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.entidad.nombre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.entidad.email_entidad+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.entidad.ciudad.nombre+' - '+respuesta.detalles.entidad.ciudad.departamento.nombre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.tipogrupo+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.institucion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.clasificacioncolciencias.nombre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre del Contacto: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nombres_contacto+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Teléfono del Contacto: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">' + respuesta.detalles.telefono_contacto + '</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Correo del Contacto: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.correo_contacto+'</span>'
        +'</div>'
        +'</div>'
      );
      $('#detalleDeUnGrupoDeInvestigacion').openModal();
    }
  });
  },
}

$(document).ready(function() {
    
    $('#administrador_table').DataTable({
        language: {
           
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "/usuario/administrador",
            type: "get",
        },
        columns: [
        	{
        		data: 'tipodocumento',
        		name: 'tipodocumento',
        	},
        	{
        		data: 'documento',
        		name: 'documento',
        	},
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
            {
                data: 'email',
                name: 'email',
            },
        	{
        		data: 'telefono',
        		name: 'telefono',
        	},
            {
                data: 'estado',
                name: 'estado',
            },
            {
                data: 'detail',
                name: 'detail',
                orderable: false,
            },
            {
                data: 'edit',
                name: 'edit',
                orderable: false,
            },

        ],
    });
});

function detalleAdministrador(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/usuario/administrador/"+id
  }).done(function(respuesta){
    $("#titulo_administrador").empty();
    $("#detalle_administrador").empty();
    console.log(respuesta.data);
    if (respuesta == null) {
      swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
        let genero = respuesta.data.user.genero == 1 ? 'Masculino' : 'Femenino';
        let otra_eps = respuesta.data.user.otra_eps != null ? respuesta.data.user.otra_eps : 'No registra';
        let telefono = respuesta.data.user.telefono != null ? respuesta.data.user.telefono : 'No registra';
        let celular = respuesta.data.user.celular != null ? respuesta.data.user.celular : 'No registra';
      // $("#titulo_administrador").append("<span class='cyan-text text-darken-3'>Usuario </span>"+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos)
      //       $("#detalle_administrador").append('<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Nombre Completo: </span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //       +'<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Tipo Documento: </span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.tipodocumento+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //       +'<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Documento</span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.user.documento+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //       +'<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Descripcion: </span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.role+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //     );
      //     
      
      $("#titulo_administrador").append(`<div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                        
                                    <div class="col s12 m12 l12">
                                        
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    
                                                    <div class="left">
                                                        <span class="mailbox-title ">
                                                            `+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos+`
                                                        </span>

                                                        <span class="mailbox-author black-text text-darken-2">
                                                            
                                                            `+respuesta.data.role+`<br>
                                                            Miembro desde `+moment(respuesta.data.user.created_at).format('LL')+` <br>
                                                        </span>
                                                    </div>
                                                </div>
                                                

                                                <div class="right mailbox-buttons">
                                                    
                                                </div>
                                            </div>
                                            <div class="right">
                                                <small>`+ genero+`</small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    credit_card
                                                                </i>
                                                                <span class="title">
                                                                    Tipo Documento
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.tipodocumento+`   
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    perm_contact_calendar
                                                                </i>
                                                                <span class="title">
                                                                    Fecha de Nacimiento
                                                                </span>
                                                                <p>
                                                                    `+moment(respuesta.data.user.fechanacimiento).format('LL')+`
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    local_hospital
                                                                </i>
                                                                <div class="left">
                                                                   <span class="title">
                                                                        Eps
                                                                    </span>
                                                                    <p>
                                                                       `+respuesta.data.eps+`   
                                                                    </p> 
                                                                </div>
                                                               
                                                                <div class="right">
                                                                   <span class="title">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                       `+otra_eps+` 
                                                                    </p> 
                                                                </div>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <div class="left">
                                                                    <span class="title">
                                                                       Dirección
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.direccion+`
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Barrio
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.barrio+` 
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    email
                                                                </i>
                                                                <span class="title">
                                                                   Correo Electrónico
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.user.email+`
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    Documento
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.user.documento+` 
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    details
                                                                </i>
                                                                <span class="title">
                                                                    Grupo Sanguineo
                                                                </span>
                                                                <p>
                                                                   `+respuesta.data.gruposanguineo+`   
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    filter_6
                                                                </i>
                                                                <span class="title">
                                                                    Estrato Social
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.user.estrato+`                                                                    
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <span class="title">
                                                                    Lugar de Residencia
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.ciudad+` - `+respuesta.data.departamento+`
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                
                                                                <div class="center">
                                                                    <span class="title">
                                                                       Datos contacto
                                                                    </span>
                                                                </div>
                                                                <div class="left">
                                                                    <i class="material-icons circle teal darken-2">
                                                                    phone
                                                                </i>
                                                                    <p>
                                                                        Telefono <br>
                                                                        `+telefono+` 
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Celular
                                                                    </span>
                                                                    <p>
                                                                        `+celular+` 
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
      $('#modal1').openModal();
    }
    })
}


$(document).ready(function() {
    $('#dinamizador_table').DataTable({
        language: {
             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
         },
    });
    // $('.dataTables_length select').addClass('browser-default');
});


 var UserAdministradorDinamizador = {
     selectDinamizadoresPorNodo: function() {
         let nodo = $('#selectnodo').val();
         $('#dinamizador_table').dataTable().fnDestroy();
         $('#dinamizador_table').DataTable({
             language: {
                 "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
             },
             processing: true,
             serverSide: true,
             order: false,
             ajax: {
                 url: "/usuario/dinamizador/getDinamizador/" + nodo,
                 type: "get",
             },
             columns: [
             {
                 data: 'tipodocumento',
                 name: 'tipodocumento',
             }, {
                 data: 'documento',
                 name: 'documento',
             }, {
                 data: 'nombre',
                 name: 'nombre',
             }, {
                 data: 'email',
                 name: 'email',
             }, {
                 data: 'telefono',
                 name: 'telefono',
             }, {
                 data: 'estado',
                 name: 'estado',
             }, {
                 data: 'detail',
                 name: 'detail',
                 orderable: false,
             }, {
                 data: 'edit',
                 name: 'edit',
                 orderable: false,
             },
             ],
         });
     },
     detalleDinamizador(id){
            $.ajax({
        dataType:'json',
        type:'get',
        url:"/usuario/dinamizador/"+id
      }).done(function(respuesta){
        $("#titulo_dinamizador").empty();
        if (respuesta == null) {
          swal('Ups!!!', 'Ha ocurrido un error', 'warning');
        } else {
            let genero = respuesta.data.user.genero == 1 ? 'Masculino' : 'Femenino';
            let otra_eps = respuesta.data.user.otra_eps != null ? respuesta.data.user.otra_eps : 'No registra';
            let telefono = respuesta.data.user.telefono != null ? respuesta.data.user.telefono : 'No registra';
            let celular = respuesta.data.user.celular != null ? respuesta.data.user.celular : 'No registra';
          
          $("#titulo_dinamizador").append(`<div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card mailbox-content">
                                <div class="card-content">
                                    <div class="row no-m-t no-m-b">
                            
                                        <div class="col s12 m12 l12">
                                            
                                            <div class="mailbox-view">
                                                <div class="mailbox-view-header">
                                                    <div class="left">
                                                        
                                                        <div class="left">
                                                            <span class="mailbox-title ">
                                                                `+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos+`
                                                            </span>

                                                            <span class="mailbox-author black-text text-darken-2">
                                                                
                                                                `+respuesta.data.role+`<br>
                                                                Miembro desde `+moment(respuesta.data.user.created_at).format('LL')+` <br>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="right mailbox-buttons">
                                                        
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <small>`+ genero+`</small>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="mailbox-text">
                                                    <div class="row">
                                                        <div class="col s12 m6 l6">
                                                            <ul class="collection">
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        credit_card
                                                                    </i>
                                                                    <span class="title">
                                                                        Tipo Documento
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.tipodocumento+`   
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        perm_contact_calendar
                                                                    </i>
                                                                    <span class="title">
                                                                        Fecha de Nacimiento
                                                                    </span>
                                                                    <p>
                                                                        `+moment(respuesta.data.user.fechanacimiento).format('LL')+`
                                                                    </p>
                                                                    
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        local_hospital
                                                                    </i>
                                                                    <div class="left">
                                                                       <span class="title">
                                                                            Eps
                                                                        </span>
                                                                        <p>
                                                                           `+respuesta.data.eps+`   
                                                                        </p> 
                                                                    </div>
                                                                   
                                                                    <div class="right">
                                                                       <span class="title">
                                                                            Otra Eps
                                                                        </span>
                                                                        <p>
                                                                           `+otra_eps+` 
                                                                        </p> 
                                                                    </div>
                                                                    
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        map
                                                                    </i>
                                                                    <div class="left">
                                                                        <span class="title">
                                                                           Dirección
                                                                        </span>
                                                                        <p>
                                                                            `+respuesta.data.user.direccion+`
                                                                        </p>
                                                                    </div>
                                                                    <div class="right">
                                                                        <span class="title">
                                                                           Barrio
                                                                        </span>
                                                                        <p>
                                                                            `+respuesta.data.user.barrio+` 
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        email
                                                                    </i>
                                                                    <span class="title">
                                                                       Correo Electrónico
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.email+`
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col s12 m6 l6">
                                                            <ul class="collection">
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        assignment_ind
                                                                    </i>
                                                                    <span class="title">
                                                                        Documento
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.documento+` 
                                                                    </p>
                                                                    
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        details
                                                                    </i>
                                                                    <span class="title">
                                                                        Grupo Sanguineo
                                                                    </span>
                                                                    <p>
                                                                       `+respuesta.data.gruposanguineo+`   
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        filter_6
                                                                    </i>
                                                                    <span class="title">
                                                                        Estrato Social
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.estrato+`                                                                    
                                                                    </p>
                                                                    
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        map
                                                                    </i>
                                                                    <span class="title">
                                                                        Lugar de Residencia
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.ciudad+` - `+respuesta.data.departamento+`
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    
                                                                    <div class="center">
                                                                        <span class="title">
                                                                           Datos contacto
                                                                        </span>
                                                                    </div>
                                                                    <div class="left">
                                                                        <i class="material-icons circle teal darken-2">
                                                                        phone
                                                                    </i>
                                                                        <p>
                                                                            Telefono <br>
                                                                            `+telefono+` 
                                                                        </p>
                                                                    </div>
                                                                    <div class="right">
                                                                        <span class="title">
                                                                           Celular
                                                                        </span>
                                                                        <p>
                                                                            `+celular+` 
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="divider mailbox-divider">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
          $('#detalledinamizador').openModal();
        }
        })
    }
 }

$(document).ready(function() {
    $('#gestor_table').DataTable({
        language: {
             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
         },
    });
    // $('.dataTables_length select').addClass('browser-default');
});


 var UserAdministradorGestor = {
     selectGestoresPorNodo: function() {
         let nodo = $('#selectnodo').val();
         $('#gestor_table').dataTable().fnDestroy();
         $('#gestor_table').DataTable({
             language: {
                 "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
             },
             processing: true,
             serverSide: true,
             order: false,
             ajax: {
                 url: "/usuario/gestor/getGestor/" + nodo,
                 type: "get",
             },
             columns: [
             {
                 data: 'tipodocumento',
                 name: 'tipodocumento',
             }, {
                 data: 'documento',
                 name: 'documento',
             }, {
                 data: 'nombre',
                 name: 'nombre',
             }, {
                 data: 'email',
                 name: 'email',
             }, {
                 data: 'telefono',
                 name: 'telefono',
             }, {
                 data: 'estado',
                 name: 'estado',
             }, {
                 data: 'detail',
                 name: 'detail',
                 orderable: false,
             }, {
                 data: 'edit',
                 name: 'edit',
                 orderable: false,
             },
             ],
         });
    },
    detalleGestor(id){
        $.ajax({
	        dataType:'json',
	        type:'get',
	        url:"/usuario/gestor/"+id
	      }).done(function(respuesta){
	        $("#titulo_gestor").empty();
	        if (respuesta == null) {
	          swal('Ups!!!', 'Ha ocurrido un error', 'warning');
	        } else {
	            let genero = respuesta.data.user.genero == 1 ? 'Masculino' : 'Femenino';
	            let otra_eps = respuesta.data.user.otra_eps != null ? respuesta.data.user.otra_eps : 'No registra';
	            let telefono = respuesta.data.user.telefono != null ? respuesta.data.user.telefono : 'No registra';
	            let celular = respuesta.data.user.celular != null ? respuesta.data.user.celular : 'No registra';
	          
	          $("#titulo_gestor").append(`<div class="row">
	                        <div class="col s12 m12 l12">
	                            <div class="card mailbox-content">
	                                <div class="card-content">
	                                    <div class="row no-m-t no-m-b">
	                            
	                                        <div class="col s12 m12 l12">
	                                            
	                                            <div class="mailbox-view">
	                                                <div class="mailbox-view-header">
	                                                    <div class="left">
	                                                        
	                                                        <div class="left">
	                                                            <span class="mailbox-title ">
	                                                                `+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos+`
	                                                            </span>

	                                                            <span class="mailbox-author black-text text-darken-2">
	                                                                
	                                                                `+respuesta.data.role+`<br>
	                                                                Miembro desde `+moment(respuesta.data.user.created_at).format('LL')+` <br>
	                                                            </span>
	                                                        </div>
	                                                    </div>
	                                                    

	                                                    <div class="right mailbox-buttons">
	                                                        
	                                                    </div>
	                                                </div>
	                                                <div class="right">
	                                                    <small>`+ genero+`</small>
	                                                </div>
	                                                <div class="divider mailbox-divider">
	                                                </div>
	                                                <div class="mailbox-text">
	                                                    <div class="row">
	                                                        <div class="col s12 m6 l6">
	                                                            <ul class="collection">
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        credit_card
	                                                                    </i>
	                                                                    <span class="title">
	                                                                        Tipo Documento
	                                                                    </span>
	                                                                    <p>
	                                                                        `+respuesta.data.tipodocumento+`   
	                                                                    </p>
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        perm_contact_calendar
	                                                                    </i>
	                                                                    <span class="title">
	                                                                        Fecha de Nacimiento
	                                                                    </span>
	                                                                    <p>
	                                                                        `+moment(respuesta.data.user.fechanacimiento).format('LL')+`
	                                                                    </p>
	                                                                    
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        local_hospital
	                                                                    </i>
	                                                                    <div class="left">
	                                                                       <span class="title">
	                                                                            Eps
	                                                                        </span>
	                                                                        <p>
	                                                                           `+respuesta.data.eps+`   
	                                                                        </p> 
	                                                                    </div>
	                                                                   
	                                                                    <div class="right">
	                                                                       <span class="title">
	                                                                            Otra Eps
	                                                                        </span>
	                                                                        <p>
	                                                                           `+otra_eps+` 
	                                                                        </p> 
	                                                                    </div>
	                                                                    
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        map
	                                                                    </i>
	                                                                    <div class="left">
	                                                                        <span class="title">
	                                                                           Dirección
	                                                                        </span>
	                                                                        <p>
	                                                                            `+respuesta.data.user.direccion+`
	                                                                        </p>
	                                                                    </div>
	                                                                    <div class="right">
	                                                                        <span class="title">
	                                                                           Barrio
	                                                                        </span>
	                                                                        <p>
	                                                                            `+respuesta.data.user.barrio+` 
	                                                                        </p>
	                                                                    </div>
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        email
	                                                                    </i>
	                                                                    <span class="title">
	                                                                       Correo Electrónico
	                                                                    </span>
	                                                                    <p>
	                                                                        `+respuesta.data.user.email+`
	                                                                    </p>
	                                                                </li>
	                                                            </ul>
	                                                        </div>
	                                                        <div class="col s12 m6 l6">
	                                                            <ul class="collection">
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        assignment_ind
	                                                                    </i>
	                                                                    <span class="title">
	                                                                        Documento
	                                                                    </span>
	                                                                    <p>
	                                                                        `+respuesta.data.user.documento+` 
	                                                                    </p>
	                                                                    
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        details
	                                                                    </i>
	                                                                    <span class="title">
	                                                                        Grupo Sanguineo
	                                                                    </span>
	                                                                    <p>
	                                                                       `+respuesta.data.gruposanguineo+`   
	                                                                    </p>
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        filter_6
	                                                                    </i>
	                                                                    <span class="title">
	                                                                        Estrato Social
	                                                                    </span>
	                                                                    <p>
	                                                                        `+respuesta.data.user.estrato+`                                                                    
	                                                                    </p>
	                                                                    
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    <i class="material-icons circle teal darken-2">
	                                                                        map
	                                                                    </i>
	                                                                    <span class="title">
	                                                                        Lugar de Residencia
	                                                                    </span>
	                                                                    <p>
	                                                                        `+respuesta.data.ciudad+` - `+respuesta.data.departamento+`
	                                                                    </p>
	                                                                </li>
	                                                                <li class="collection-item avatar">
	                                                                    
	                                                                    <div class="center">
	                                                                        <span class="title">
	                                                                           Datos contacto
	                                                                        </span>
	                                                                    </div>
	                                                                    <div class="left">
	                                                                        <i class="material-icons circle teal darken-2">
	                                                                        phone
	                                                                    </i>
	                                                                        <p>
	                                                                            Telefono <br>
	                                                                            `+telefono+` 
	                                                                        </p>
	                                                                    </div>
	                                                                    <div class="right">
	                                                                        <span class="title">
	                                                                           Celular
	                                                                        </span>
	                                                                        <p>
	                                                                            `+celular+` 
	                                                                        </p>
	                                                                    </div>
	                                                                </li>
	                                                            </ul>
	                                                        </div>
	                                                    </div>
	                                                    <div class="divider mailbox-divider">
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>`);
	          $('#detallegestor').openModal();
	        }
	        })
	    }
 }

var roleUserSession = {
    setRoleSession:function (role) {
        let nameRole = $(role).val();
        let nombre = $("#change-role option:selected").val();
        $.ajax({
        dataType:'json',
        type:'POST',
        data: {
        	'role': nombre,
        	'_token'  : $('meta[name="csrf-token"]').attr('content'),
        },
        url:'/cambiar-role'
      }).done(function(response){
        	if (response.role != null) {
        		location.href= response.url;
        	}else{
        		console.log(response.role );
        	}
        	
      }); 
   }
};
$(document).ready(function() {

	$('#sublineas_table').DataTable({
        language: {
           
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "/sublineas",
            type: "get",
        },
        columns: [
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
        	{
        		data: 'linea',
        		name: 'linea',
        	},
            {
                data: 'edit',
                name: 'edit',
                orderable: false,
            },

        ],
    });
});
$(document).ready(function() {
  $('#articulacionesGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/articulacion/datatableArticulacionesDelGestor/"+0,
      type: "get",
    },
    columns: [
      {
        data: 'codigo_articulacion',
        name: 'codigo_articulacion',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'tipo_articulacion',
        name: 'tipo_articulacion',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        data: 'revisado_final',
        name: 'revisado_final',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });

  // $('#empresasDeTecnoparque_tableNoGestor').DataTable({
  //   language: {
  //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
  //   },
  //   processing: true,
  //   serverSide: true,
  //   ajax:{
  //     url: "/empresa/datatableEmpresasDeTecnoparque",
  //     type: "get",
  //   },
  //   columns: [
  //     {
  //       data: 'nit',
  //       name: 'nit',
  //     },
  //     {
  //       data: 'nombre_empresa',
  //       name: 'nombre_empresa',
  //     },
  //     {
  //       data: 'sector_empresa',
  //       name: 'sector_empresa',
  //     },
  //     {
  //       data: 'ciudad',
  //       name: 'ciudad',
  //     },
  //     {
  //       data: 'direccion',
  //       name: 'direccion',
  //     },
  //     {
  //       data: 'details',
  //       name: 'details',
  //       orderable: false
  //     },
  //     // {
  //     //   data: 'soft_delete',
  //     //   name: 'soft_delete',
  //     //   orderable: false
  //     // },
  //   ],
});
