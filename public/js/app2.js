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
        	url: "nodo",
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
  });

  $('#ideas_emprendedores_table .dataTables_length select').addClass('browser-default');


});

// function secondDataTable() {
//   if (!$.fn.dataTable.isDataTable('#tblideasempresas')) {
//     $('#tblideasempresas').DataTable({
//       language: {
//         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
//       },
//       processing: true,
//       serverSide: true,
//       // order: [[0, 'desc']],
//       // buttons: [
//         //     'csv', 'excel', 'pdf', 'print', 'reset', 'reload'
//         // ],
//         ajax: 'idea/ideasEmpGI',
//         columns: [
//           {
//             data: 'consecutivo',
//             name: 'consecutivo',
//           },
//           {
//             data: 'fecha_registro',
//             name: 'fecha_registro',
//           },
//           {
//             data: 'nit',
//             name: 'nit',
//           },
//           {
//             data: 'razon_social',
//             name: 'razon_social',
//           },
//           {
//             data: 'nombre_idea',
//             name: 'nombre_idea',
//           },
//         ],
//         // order: [[0, 'desc']]
//       });
//     }
//   }

$('#ideas_emprendedores_table .dataTables_length select').addClass('browser-default');

function detallesIdeaPorId(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"idea/"+id
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

$(document).ready(function() {

  $('#tblideas').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
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

    ],
  });
  $('#ideas_emprendedores_table .dataTables_length select').addClass('browser-default');
  // $('.modal').modal();
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

$(document).ready(function() {
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
  $("#formValidate").on('submit',function(event){
    event.preventDefault();
    entrenamiento.registrar();
  });
});

var cont = 0;

// Valida que el talento agregado a la articulación no exista
function noRepeat() {
  let idIdea = $("#txtidea").val();
  let retorno = true;
  let a = document.getElementsByName("idideas[]");
  for (x=0;x<a.length;x++){
    if (a[x].value == idIdea) {
      retorno = false;
      break;
    }
  }
  return retorno;
}

// Quita al talento de la lista de los talentos que harán parte de la articulación
function eliminar(index){
  $('#fila'+ index).remove();
}

// Método para agregar talentos a una articulación
function agregar() {
  if (noRepeat() == false) {
    swal("Error!", "La idea de proyecto ya está asociada al entrenamiento!", "warning");
  } else {
    let idIdea = $("#txtidea").val();
    $.ajax({
      url:uri+"idea/detalle_idea/" + idIdea,
      dataType:'json',
      type:'get',
      // data: idIdea,
    }).done(function(response){
      var a = document.getElementsByName("idideas[]");
      if (idIdea != 0) {
        let fila = '<tr class="selected" id="fila'+cont+'">'
        +'<td><input type="hidden" name="idideas[]" value="'+response.ididea+'">'+response.nombreproyecto+'</td>'
        +'<td>'+ response.nombrec + ' ' + response.apellidoc + '</td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="confirm_asist'+response.ididea+'" id="confirm_asist'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="canvas'+response.ididea+'" id="canvas'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="first_sesion'+response.ididea+'" id="first_sesion'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="second_sesion'+response.ididea+'" id="second_sesion'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="csbit'+response.ididea+'" id="csbit'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+cont+');"><i class="material-icons">delete_sweep</i></a></td>'
        +'</tr>';
        cont++;
        $('#detalles').append(fila);
      } else {
        swal('Ups!!', 'Por favor seleccione por lo menos un talento', 'warning');
      }
    })
  }

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

    console.log(respuesta);
    if (respuesta == null) {
      swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
      $("#titulo_administrador").append("<span class='cyan-text text-darken-3'>Usuario </span>"+respuesta.user.nombre);
            $("#detalle_administrador").append('<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Nombre Completo: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.nombre+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Tipo Documento: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.tipodocumento+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Documento</span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.documento+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Descripcion: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.rol+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
          );
      $('#modal1').openModal();
    }
    })
}