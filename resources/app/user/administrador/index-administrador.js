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

function detalles(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/usuario/administrador/"+id
  }).done(function(respuesta){
    $("#titulo").empty();
    $("#detalle_idea").empty();

    console.log(respuesta);
    // if (respuesta == null) {
    //   swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    // } else {
    //   $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+respuesta.nombre_proyecto+"");
    //         $("#detalle_idea").append('<div class="row">'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span>'
    //         +'</div>'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="black-text">'+respuesta.aprendiz_sena+'</span>'
    //         +'</div>'
    //         +'</div>'
    //         +'<div class="divider"></div>'
    //         +'<div class="row">'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span>'
    //         +'</div>'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="black-text">'+respuesta.pregunta1String+'</span>'
    //         +'</div>'
    //         +'</div>'
    //         +'<div class="divider"></div>'
    //         +'<div class="row">'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span>'
    //         +'</div>'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="black-text">'+respuesta.pregunta2String+'</span>'
    //         +'</div>'
    //         +'</div>'
    //         +'<div class="divider"></div>'
    //         +'<div class="row">'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="cyan-text text-darken-3">Descripcion: </span>'
    //         +'</div>'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="black-text">'+respuesta.descripcion+'</span>'
    //         +'</div>'
    //         +'</div>'
    //         +'<div class="divider"></div>'
    //         +'<div class="row">'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="cyan-text text-darken-3">Objetivo: </span>'
    //         +'</div>'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="black-text">'+respuesta.objetivo+'</span>'
    //         +'</div>'
    //         +'</div>'
    //         +'<div class="divider"></div>'
    //         +'<div class="row">'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="cyan-text text-darken-3">Alcance: </span>'
    //         +'</div>'
    //         +'<div class="col s12 m6 l6">'
    //         +'<span class="black-text">'+respuesta.alcance+'</span>'
    //         +'</div>'
    //         +'</div>'
    //       );
      $('#modal1').openModal();
    // }
    })
}