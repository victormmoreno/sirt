$(document).ready(function() {

  $('#ideas_emprendedores_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: "/idea",
      type: "get",
    },
    columns: [
      {
        data: 'codigo_idea',
        name: 'codigo_idea',
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

  $('#tblideasempresas').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: "/idea/consultarIdeasEmpresasGIPorNodo/"+0,
      type: "get",
    },
    columns: [
      {
        data: 'codigo_idea',
        name: 'codigo_idea',
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

function cambiarEstadoIdeaDeProyecto(id, estado) {
  Swal.fire({
    title: '¿Desea cambiar el estado de la idea de proyecto a '+estado+'?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/idea/updateEstadoIdea/'+id+'/'+estado,
        success: function (data) {
          Swal.fire({
            title: 'El estado de la idea se ha cambiado exitosamente!',
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Sí'
          }).then((result) => {
            window.location.replace(data.route);
          })
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
    }
  })

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
      $("#detalle_idea").append(
        '<div class="row">'
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
