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
  $('.modal').modal();
});

function detalles(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"idea/"+id
  }).done(function(respuesta){
    $("#titulo").empty();
    $("#detalle_idea").empty();
    if (respuesta == null) {
      swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
      $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+respuesta.nombre_proyecto+"");
            $("#detalle_idea").append('<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.aprendiz_sena+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.pregunta1String+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.pregunta2String+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Descripcion: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.descripcion+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Objetivo: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.objetivo+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Alcance: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.alcance+'</span>'
            +'</div>'
            +'</div>'
          );
      $('#modal1').openModal();
    }
    })
}
//     console.log(respuesta);
//     $("#titulo").empty();
//     $("#detalle_idea").empty();
//     if (respuesta == null) {
//       swal('Ups!!', 'Ha ocurrido un error', 'warning');
//     } else {
//       $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+respuesta.nombreproyecto+"");
//       $("#detalle_idea").append('<div class="row">'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span>'
//       +'</div>'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="black-text">'+respuesta.aprendizsena+'</span>'
//       +'</div>'
//       +'</div>'
//       +'<div class="divider"></div>'
//       +'<div class="row">'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span>'
//       +'</div>'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="black-text">'+respuesta.pregunta1+'</span>'
//       +'</div>'
//       +'</div>'
//       +'<div class="divider"></div>'
//       +'<div class="row">'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span>'
//       +'</div>'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="black-text">'+respuesta.pregunta2+'</span>'
//       +'</div>'
//       +'</div>'
//       +'<div class="divider"></div>'
//       +'<div class="row">'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="cyan-text text-darken-3">Descripcion: </span>'
//       +'</div>'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="black-text">'+respuesta.descripcion+'</span>'
//       +'</div>'
//       +'</div>'
//       +'<div class="divider"></div>'
//       +'<div class="row">'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="cyan-text text-darken-3">Objetivo: </span>'
//       +'</div>'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="black-text">'+respuesta.objetivo+'</span>'
//       +'</div>'
//       +'</div>'
//       +'<div class="divider"></div>'
//       +'<div class="row">'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="cyan-text text-darken-3">Alcance: </span>'
//       +'</div>'
//       +'<div class="col s12 m6 l6">'
//       +'<span class="black-text">'+respuesta.alcance+'</span>'
//       +'</div>'
//       +'</div>'
//     );
//     $('.modal-trigger').leanModal();
//   }
// });
// }
