<<<<<<< HEAD
$(document).ready(function() {
    $('#linea_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "lineas",
        },
        columns: [{
            data: 'abreviatura',
            name: 'abreviatura',
        }, {
            data: 'nombre',
            name: 'nombre',
        }, {
            data: 'descripcion',
            name: 'descripcion',
        }, 
        {
            data: 'show',
            name: 'show',
            orderable: false
        },{
            data: 'action',
            name: 'action',
            orderable: false
        }, ],
    });
});
$(document).ready(function() {
    $('#linea_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "lineas",
        },
        columns: [{
            data: 'abreviatura',
            name: 'abreviatura',
        }, {
            data: 'nombre',
            name: 'nombre',
        }, {
            data: 'descripcion',
            name: 'descripcion',
        }, {
            data: 'action',
            name: 'action',
            orderable: false
        }, ],
    });
});
$(document).ready(function() {
    $('#nodos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": true,
        "responsive": true,
        "bSort": false,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'csv',
            text: 'exportar csv',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'excel',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'pdf',
            exportOptions: {
                columns: ':visible'
            }
        }, ],
        ajax: {
            url: "/nodo",
        },
        columns: [{
            data: 'centro',
            name: 'centro',
        }, {
            data: 'nodos',
            name: 'nodos',
        }, {
            data: 'direccion',
            name: 'direccion',
        }, {
            data: 'ubicacion',
            name: 'ubicacion',
        }, {
            data: 'detail',
            name: 'detail',
            orderable: false
        },  
        ],
    });
});

// function eliminarNodoPorId(id, e) {
//     Swal.fire({
//         title: '¿Desea eliminar el nodo?',
//         text: "Al hacer esto, todo lo relacionado con este proyecto será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#d33',
//         cancelButtonColor: '#3085d6',
//         cancelButtonText: 'No',
//         confirmButtonText: 'Sí, eliminar!'
//     }).then((result) => {
//         if (result.value) {
//             eliminarNodoId_moment(id);
//         }
//     })
// };

// function eliminarNodoId_moment(id) {
    
//     $.ajax({
//         dataType: "JSON",
//         type: 'POST',
//         data: {
//             '_token': $('meta[name=csrf-token]').attr("content"),
//             '_method': 'DELETE',
//             "id": id
//         },
//         success: function(data) {
//             console.log(data);
//             // if (data.retorno) {
//             //     Swal.fire('Eliminación Exitosa!', 'El proyecto se ha eliminado completamente!', 'success');
//             //     location.href = '/nodo';
//             // } else {
//             //     Swal.fire('Eliminación Errónea!', 'El proyecto no se ha eliminado!', 'error');
//             // }
//         },
//         error: function(xhr, textStatus, errorThrown) {
//             alert("Error: " + errorThrown);
//         },
//     });
// }
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
        $("#ideasEntrenamiento").append("<tr><td>"+item.codigo_idea+" - "+item.nombre_proyecto+
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
        title: 'Código del Entrenamiento',
        data: 'codigo_entrenamiento',
        name: 'codigo_entrenamiento',
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
        width: '8%',
        data: 'fotos',
        name: 'fotos',
      },
      {
        width: '8%',
        data: 'listado_asistencia',
        name: 'listado_asistencia',
      },
      {
        width: '8%',
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
        title: 'Código del Entrenamiento',
        data: 'codigo_entrenamiento',
        name: 'codigo_entrenamiento',
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
        width: '8%',
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
  $('#entrenamientos_nodo_table').dataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    paging: true,
    ajax:{
      url: "/entrenamientos",
      type: "get",
    },

    columns: [
      {
        title: 'Código del Entrenamiento',
        data: 'codigo_entrenamiento',
        name: 'codigo_entrenamiento',
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
        data: 'update_state',
        name: 'update_state',
        orderable: false
      },
      {
        width: '8%',
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },
    ],
  });
  $('a.toggle-vis').on( 'click', function (e) {
    e.preventDefault();

    // Get the column API object
    var column = table.column( $(this).attr('data-column') );

    // Toggle the visibility
    column.visible( ! column.visible() );
  } );
});

function inhabilitarEntrenamientoPorId(id, e) {
  Swal.fire({
    title: '¿Desea inhabilitar el entrenamiento?',
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
        title: '¿Qué desea hacer?',
        text: "Seleccione lo que ocurrirá con las ideas de proyecto que están asociasdas al entrenamiento",
        type: 'warning',
        footer: '<a onclick="Swal.close()" href="#">Cancelar</a>',
        confirmButtonText: '<a class="white-text" onclick="cambiarEstadoDeIdeasDeProyectoDeEntrenamiento('+id+', \'Inhabilitado\'); Swal.close()" href="#">Inhabilitar las ideas de proyecto</a>',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        cancelButtonText: '<a class="white-text" onclick="cambiarEstadoDeIdeasDeProyectoDeEntrenamiento('+id+', \'Inicio\'); Swal.close()" href="#">Regresar las ideas de proyecto al estado de Inicio</a>',
        focusConfirm: false,
      })
    }
  })
}

function cambiarEstadoDeIdeasDeProyectoDeEntrenamiento(idea, estado) {
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/entrenamientos/inhabilitarEntrenamiento/"+idea+"/"+estado,
    success: function (data) {
      console.log(data);
      if (data.update == "true") {
        Swal.fire({
          title: 'El entrenamiento se ha inhabilitado!',
          html: 'Las ideas de proyecto del entrenamiento han cambiado su estado a: ' + data.estado ,
          type: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok!'
        })
      }
      if (data.update == "1") {
        // console.log('No se cambió');
        Swal.fire({
          title: 'No se puede inhabilitar el entrenamiento!',
          html: 'Al parecer, las siguientes ideas de proyecto se encuentran registradas en un comité: </br> <b> ' + data.ideas + '</b></br>' +
          'Si deseas hacer esto, las ideas de proyecto asociadas al entrenamiento no pueden estar en proyecto ó CSIBT' ,
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Entiendo!'
        })
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    }
  })
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
        +'<td>'+elemento.codigo_idea+' - '+elemento.nombre_proyecto+'</td>'
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


function enviarNotificacionResultadosCSIBT(idea, comite) {
    $.ajax({
        type: 'get',
        url: '/csibt/notificar_resultado/' + idea + '/' + comite,
        dataType: 'json',
        processData: false,
        success: function (data) {
            if (data.state == 'notifica') {
                notificacionExitosaDelResultado(data);
            } else {
                notificacionFallidaDelResultado();
            }
            
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function notificacionExitosaDelResultado(data) {
    Swal.fire({
        title: 'Notificación Exitosa!',
        text: "Se ha enviado un mensaje a la dirección: " + data.idea.correo_contacto + " con los resultados del comité.",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}

function notificacionFallidaDelResultado() {
    Swal.fire({
        title: 'Notificación Fallida!',
        text: "No se ha logrado enviar una mensaje con los resultados del comité al talento.",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}
$(document).on('submit', 'form#formComiteAsignarCreate', function (event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        text: "No podrás revertir estos cambios!",
        // text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los gestores puedes cambiar esta información",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteAsignar(form, data, url, 'create');
        }
    });
});

function ajaxSendFormComiteAsignar(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesComiteAsignarCreate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesComiteAsignarCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La asignación de ideas de proyecto del comité ha sido registrada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/csibt");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'La asignación de ideas de proyecto del comité no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};
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
        data: 'estadocomite',
        name: 'estadocomite',
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
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿La idea viene de una convocatoria? </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+vieneConvocatoria(respuesta.detalles.viene_convocatoria)+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre de Convocatoria: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+nombreConvocatoria(respuesta.detalles.viene_convocatoria,respuesta.detalles.convocatoria)+'</span>'
        +'</div>'
        +'</div>'
      );
      $('#ideaProyecto').openModal();
      }
    });
  }
    
}

function addIdeaComite() {
    let id = $('#txtideaproyecto').val();
    let hora = $('#txthoraidea').val();
    let direccion = $('#txtdireccion').val();
    if (id == 0 || hora == '' || direccion == '') {
        datosIncompletosAgendamiento();
    } else {
        if (noRepeatIdeasAgendamiento(id) == false) {
            ideaYaSeEncuentraAsociadaAgendamiento();
        } else {
            pintarIdeaEnLaTabla(id, hora, direccion);
        }
    }
}

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

$(document).on('submit', 'form#formComiteAgendamientoCreate', function (event) { // $('button[type="submit"]').prop("disabled", true);
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteAgendamiento(form, data, url, 'create');
        }
    });
});

$(document).on('submit', 'form#formComiteAgendamientoUpdate', function (event) { // $('button[type="submit"]').prop("disabled", true);
event.preventDefault();
Swal.fire({
    title: '¿Está seguro(a) de guardar esta información?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, guardar'
  }).then((result) => {
    if (result.value) {
        $('button[type="submit"]').attr('disabled', 'disabled');
        event.preventDefault();
        var form = $(this);
        var data = new FormData($(this)[0]);
        var url = form.attr("action");
        ajaxSendFormComiteAgendamiento(form, data, url, 'update');
    }
  })
});

// Elimina una idea de proyecto agendada en un comité
function eliminarIdeaDelAgendamiento(index) {
    $('#ideaAsociadaAgendamiento' + index).remove();
}

function ajaxSendFormComiteAgendamiento(form, data, url, fase) {
$.ajax({
    type: form.attr('method'),
    url: url,
    data: data,
    cache: false,
    contentType: false,
    dataType: 'json',
    processData: false,
    success: function (data) {
        $('button[type="submit"]').removeAttr('disabled');
        $('.error').hide();
        printErroresFormulario(data);
        if (fase == 'create') {
            mensajesComiteAgendamientoCreate(data);
        } else {
            mensajesComiteAgendamientoUpdate(data);
        }
    },
    error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
    }
});
};

function mensajesComiteAgendamientoCreate(data) {
if (data.state == 'registro') {
    Swal.fire({
        title: 'Registro Exitoso',
        text: "El comité ha sido registrado satisfactoriamente",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
    setTimeout(function () {
        window.location.replace("/csibt");
    }, 1000);
}
if (data.state == 'no_registro') {
    Swal.fire({
        title: 'El comité no se ha registrado, por favor inténtalo de nuevo',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}
};

function mensajesComiteAgendamientoUpdate(data) {
if (data.state == 'update') {
    Swal.fire({
        title: 'Modificación Exitosa',
        text: "El comité se ha modificado satisfactoriamente",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
    setTimeout(function () {
        window.location.replace("/csibt");
    }, 1000);
}
if (data.state == 'no_update') {
    Swal.fire({
        title: 'El comité no se ha modificado, por favor inténtalo de nuevo',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}
};

function pintarIdeaEnLaTabla(id, hora, direccion) {
$.ajax({
    dataType: 'json',
    type: 'get',
    url: '/idea/detallesIdea/' + id
}).done(function (ajax) {
    let fila = prepararFilaEnLaTablaDeIdeas(ajax, hora, direccion);
    $('#tblIdeasComiteCreate').append(fila);
    ideaSeAsocioAlAgendamiento();
    reiniciarCamposAgendamiento();
});
}

function prepararFilaEnLaTablaDeIdeas(ajax, hora, direccion) {
let idIdea = ajax.detalles.id;
let fila = '<tr class="selected" id=ideaAsociadaAgendamiento' + idIdea + '>' + 
    '<td><input type="hidden" name="ideas[]" value="' + idIdea + '">' + ajax.detalles.nombre_proyecto + '</td>' +
    '<td><input type="hidden" name="horas[]" value="' + hora + '">' + hora + '</td>' +
    '<td><input type="hidden" name="direcciones[]" value="' + direccion + '">' + direccion + '</td>' +
    '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelAgendamiento(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' + 
    '</tr>';
return fila;
}

function datosIncompletosAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    type: 'error',
    title: 'Estás ingresando mal los datos'
})
}

function ideaSeAsocioAlAgendamiento() {
Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'La idea de proyecto se asoció con éxito al comité'
        })
}

function ideaYaSeEncuentraAsociadaAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'warning',
    title: 'La idea de proyecto ya se encuentra asociada al comité!'
});
}


function noRepeatIdeasAgendamiento(id) {
let idIdea = id;
let retorno = true;
let a = document.getElementsByName("ideas[]");
for (x = 0; x < a.length; x ++) {
    if (a[x].value == idIdea) {
        retorno = false;
        break;
    }
}
return retorno;
}

function reiniciarCamposAgendamiento() {
$("#txtideaproyecto").val('0');
$("#txtideaproyecto").select2();
$('#txthoraidea').val('');
$("#txtobservacionesidea").val('');
$('#txtdireccion').val('');
$("label[for='txtdireccion']").removeClass('active');
$("label[for='txthoraidea']").removeClass('active');
// $("#labelobservacionesidea").removeClass('active');
// $('input:checkbox').removeAttr('checked');
}
$(document).on('submit', 'form#formComiteRealizadoCreate', function (event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los gestores puedes cambiar esta información",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteRealizado(form, data, url, 'create');
        }
    });
});

function ajaxSendFormComiteRealizado(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesComiteRealizadoCreate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesComiteRealizadoCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La calificación del comité ha sido registrada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/csibt");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'La calificación del comité no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};
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
        name: 'codigo'
      },
      {
        data: 'fechacomite',
        name: 'fechacomite'
      },
      {
        data: 'estadocomite',
        name: 'estadocomite'
      },
      {
        data: 'observaciones',
        name: 'observaciones'
      },
      {
        data: 'details',
        name: 'details',
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
        data: 'estadocomite',
        name: 'estadocomite',
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
    ],
  });
}

$(document).ready(function() {
  // $('#empresasDeTecnoparque_table tfoot th').each( function () {
  //   var title = $(this).text();
  //   $(this).html( '<input type="text" placeholder="Buscar por: '+title+'" />' );
  // } );
  var datatableEmpresas = $('#empresasDeTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/empresa/datatableEmpresasDeTecnoparque",
      type: "get",
    },
    deferRender: true,
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
        data: 'contacts',
        name: 'contacts',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
    initComplete: function () {
      this.api().columns().every( function () {
        var column = this;
        var select = $('<select><option value=""></option></select>')
        .appendTo( $(column.footer()).empty() )
        .on( 'change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
          );

          column
          .search( val ? '^'+val+'$' : '', true, false )
          .draw();
        } );

        column.data().unique().sort().each( function ( d, j ) {
          select.append( '<option value="'+d+'">'+d+'</option>' )
        } );
      } );
    },
  });

  // datatableEmpresas.columns().every( function () {
  //   var that = this;
  //
  //   $( 'input', this.footer() ).on( 'keyup change', function () {
  //     if ( that.search() !== this.value ) {
  //       that
  //       .search( this.value )
  //       .draw();
  //     }
  //   } );
  // } );

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
        data: 'contacts',
        name: 'contacts',
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
        let tipo_grupo = "Interno";
        if (respuesta.detalles.tipogrupo == 0) {
          tipo_grupo = 'Externo';
        }
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
        +'<span class="black-text">'+tipo_grupo+'</span>'
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
      );
      $('#detalleDeUnGrupoDeInvestigacion').openModal();
    }
  });
  },
}

//Enviar formulario
$(document).on('submit', 'form#formSearchUser', function (event) {
    event.preventDefault();
    $('#response-alert').empty();
    let type = $('#txttype_search').val();
    let search = $('#txtsearch_user').val();
    let patronDocumento=new RegExp('^[0-9]{6,11}$');
    let patronEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(type == ''){
        Swal.fire(
            'Error',
            'Por favor selecciona una opción',
            'error'
          );
    }else if(type == 1 && (search == null || search == '' || !patronDocumento.test(search))){
        Swal.fire(
            'Error',
            'Por favor ingrese un número de documento válido',
            'error'
          );
    }else if(type == 2 && (search == null || search == '' || !patronEmail.test(search))){
        Swal.fire(
            'Error',
            'Por favor ingrese un correo electrónico válido',
            'error'
          );
    }else{
        var form = $(this);
        let data = new FormData($(this)[0]);
        var url = form.attr("action");
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {

                $('button[type="submit"]').removeAttr('disabled');
                $('.error').hide();
                $('#response-alert').empty();

                if (data.fail) {
                    Swal.fire({
                        title: 'Registro Erróneo',
                        html: "Estas ingresando mal los datos. " + errores,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }


                if(data.status == 202){
                    if(type == 1){
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a  class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="`+data.url+`/`+search+`">Registrar nuevo usuario</a>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }else{
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li >
                                        <a  class="mail-active">

                                            <h4 class="center-align">no se encontraron resultados</h4>

                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="`+data.url+`">Registrar nuevo usuario</a>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }
                    
                }else if(data.status == 200){
                    $('#response-alert').append(`
                    <div class="mailbox-list">
                        <ul>
                            <li >
                                <a href="`+data.url+`" class="mail-active">

                                    <h5 class="mail-author">`+data.user.documento+` - `+data.user.nombres +` `+ data.user.apellidos+`</h5>
                                    <h4 class="mail-title">`+data.roles+`</h4>
                                    <p class="hide-on-small-and-down mail-text">Miembro desde `+userSearch.userCreated(data.user.created_at)+`</p>
                                    <div class="position-top-right p f-12 mail-date"> Acceso al sistema: `+ userSearch.state(data.user.estado) +`</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    `);
                }
            }
        });
    }
});
var userSearch = {
    state: function (state){
        if(state){
            return 'Si';
        }else{
            return 'No';
        }
    },
    userCreated: function (date){
        if(date == null){
            return "no registra";
        }else{
            return moment(date).format('LL');
        }
    },
    changetextLabel: function(){
        let option = $('#txttype_search').val();
        $("#txtsearch_user").val('');
        if(option == 1){
            $("label[for='txtsearch_user']").text('Número de documento');
        }else if(option == 2){
            $("label[for='txtsearch_user']").text('Correo Electrónico');
        }
    }
}


var user = {
    getCiudadExpedicion:function(){
        let id;
        id = $('#txtdepartamentoexpedicion').val();
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/getciudad/'+id
        }).done(function(response){
          $('#txtciudadexpedicion').empty();
        //   $('#txtciudadexpedicion').append('<option value="">Seleccione la Ciudad</option>')
          $.each(response.ciudades, function(i, e) {
            $('#txtciudadexpedicion').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
          });
          $('#txtciudadexpedicion').material_select();
        });
      },

      getOtraEsp:function (ideps) {
        let id = $(ideps).val();
        let nombre = $("#txteps option:selected").text();
      
        if (id == 42) {
            // $('.otraeps').css("display:block");
            $('.otraeps').removeAttr("style");
             
        }else{
            $('.otraeps').attr("style","display:none");
        }
    },
    getCiudad:function(){
        let id;
        id = $('#txtdepartamento').val();
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/getciudad/'+id
        }).done(function(response){
          $('#txtciudad').empty();
          $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
          $.each(response.ciudades, function(i, e) {
            $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
          })
          
          $('#txtciudad').material_select();
        });
    },
    getGradoDiscapacidad(gradodiscapacidad){
        let grado = $(gradodiscapacidad).val();
        if (grado == 1) {
            $('.gradodiscapacidad').removeAttr("style");
             
        }else{
            $('.gradodiscapacidad').attr("style","display:none");
        }
    }
}


$(document).ready(function() {
    $('#txtocupaciones').select2({
        language: "es",
        isMultiple: true
    });
    estudios.getOtraOcupacion();
});

var estudios = {
    getOtraOcupacion:function (idocupacion) {
        $('#otraocupacion').hide();
        let id = $(idocupacion).val();
        let nombre = $("#txtocupaciones option:selected").text();
        let resultado = nombre.match(/[A-Z][a-z]+/g);
        $('#otraocupacion').hide();
        if (resultado != null) {
            if (resultado.includes('Otra')) {
                $('#otraocupacion').show();
            }
        }
    }
}

$(document).ready(function() {
    // $(".aprendizSena").hide();
    tipoTalento.getSelectTipoTalento();
});

var tipoTalento = {
    getSelectTipoTalento:function (tipotal) {
        let valor = $(tipotal).val();
        let nombreTipoTalento = $("#txttipotalento option:selected").text();
        
        if(valor == 1 || valor == 2){

            tipoTalento.showAprendizSena();
        }
        else if(valor == 3){
            tipoTalento.showEgresadoSena();
        }
        else if(valor == 4){
            tipoTalento.showInstructorSena();
        }
        else if(valor == 5){
            tipoTalento.showFuncionarioSena();
        }
        else if(valor == 6){
            tipoTalento.showPropietarioEmpresa();
        }
        else if(valor == 7){
            tipoTalento.showEmprendedor();
        }
        else if(valor == 8){
            tipoTalento.showUniversitario();
        }
        else if(valor == 9){
            tipoTalento.showFuncionarioEmpresa();
        }
        else{
            tipoTalento.ShowSelectTipoTalento();
        }
    },

    showAprendizSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".aprendizSena").css("display", "block");
        $(".aprendizSena").show();

    },
    showEgresadoSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".egresadoSena").show();

    },
    showInstructorSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".instructorSena").css("display", "block");

    },
    showFuncionarioSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".funcionarioSena").css("display", "block");

    },
    showPropietarioEmpresa: function (){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();

        $('.otherUser').empty();
        $('.otherUser').append(`<div class="valign-wrapper" >
            <h5> Seleccionaste Propietario empresa</h5>
        </div>`);
    },
    showEmprendedor: function (){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $('.otherUser').empty();
        $('.otherUser').append(`<div class="valign-wrapper" >
            <h5> Seleccionaste Emprendedor</h5>
        </div>`);
    },

    showUniversitario: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideFuncionarioEmpresa();
        $(".universitario").css("display", "block");

    },
    showFuncionarioEmpresa: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideUniversitario();
        tipoTalento.hideEmprendedor();
        $(".funcionarioEmpresa").css("display", "block");

    },

    hideAprendizSena: function(){
        // $(".aprendizSena").css("display", "none");
        $(".aprendizSena").hide();

    },
    hideEgresadoSena: function(){
        // $(".egresadoSena").css("display", "none");
        $(".egresadoSena").hide();

    },
    hideInstructorSena: function(){
        $(".instructorSena").css("display", "none");

    },
    hideFuncionarioSena: function(){
        $(".funcionarioSena").css("display", "none");

    },
    hideSelectTipoTalento: function(){
        $(".selecttipotalento").css("display", "none");
    },
    hidePropietarioEmpresa: function(){

        $(".otherUser").css("display", "none");
    },
    hideUniversitario: function(){

        $(".universitario").css("display", "none");
    },
    hideFuncionarioEmpresa: function(){

        $(".funcionarioEmpresa").css("display", "none");
    },

    hideEmprendedor: function(){

        $(".otherUser").css("display", "none");
    },
    ShowSelectTipoTalento: function(){
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hidePropietarioEmpresa();
        $(".selecttipotalento").css("display", "block");
    },
    getCentroFormacionAprendiz:function (){
        let regional = $('#txtregional_aprendiz').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_aprendiz').empty();
            $('#txtcentroformacion_aprendiz').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_aprendiz').append('<option  value="'+id+'">'+nombre+'</option>');


                $('#txtcentroformacion_aprendiz').material_select();

            });
        });
    },
    getCentroFormacionEgresadoSena:function (){
        let regional = $('#txtregional_egresado').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_egresado').empty();
            $('#txtcentroformacion_egresado').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_egresado').append('<option  value="'+id+'">'+nombre+'</option>');


                $('#txtcentroformacion_egresado').material_select();

            });
        });
    },
    getCentroFormacionFuncionarioSena:function (){
        let regional = $('#txtregional_funcionarioSena').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_funcionarioSena').empty();
            $('#txtcentroformacion_funcionarioSena').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_funcionarioSena').append('<option  value="'+id+'">'+nombre+'</option>');


                $('#txtcentroformacion_funcionarioSena').material_select();

            });
        });
    },
    getCentroFormacionInstructorSena:function (){
        let regional = $('#txtregional_instructorSena').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_instructorSena').empty();
            $('#txtcentroformacion_instructorSena').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_instructorSena').append('<option  value="'+id+'">'+nombre+'</option>');


                $('#txtcentroformacion_instructorSena').material_select();

            });
        });
    },
    




}


$(document).on('submit', 'form#formRegisterUser', function (event) {

    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: data,
      cache: false,
      contentType: false,
      dataType: 'json',
      processData: false,
      success: function (data) {
        $('button[type="submit"]').prop("disabled", false);
        $('.error').hide();
        if (data.fail) {
            
          for (control in data.errors) {
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
          }

          createUser.printErroresFormulario(data);
        }
        if (data.state == 'error' && data.url == false) {
          Swal.fire({
            title: 'El Usuario no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        }
        if (data.state == 'success' && data.url != false) {
          Swal.fire({
            title: 'Registro Exitoso',
            text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido creado satisfactoriamente`,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
            footer: '<p class="red-text">Hemos enviado un correo electrónico al  usuario ' + data.user.nombres + ' '+ data.user.apellidos+ ' con las credenciales de ingreso a la plataforma.</p>'
          });
          setTimeout(function(){
            window.location.href = data.url;
          }, 1000);
        }
      },
      // error: function (xhr, textStatus, errorThrown) {
      //   alert("Error: " + errorThrown);
      // }
    });
  });

var createUser = {
  printErroresFormulario: function (data){
    if (data.state == 'error_form') {
      let errores = "";
      for (control in data.errors) {
          errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
          $('#' + control + '-error').html(data.errors[control]);
          $('#' + control + '-error').show();
      }
      Swal.fire({
          title: 'Advertencia!',
          html: 'Estas ingresando mal los datos.' + errores,
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      });
  }
  }
}  
$(document).on('submit', 'form#formEditUser', function (event) {
    
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: data,
      cache: false,
      contentType: false,
      dataType: 'json',
      processData: false,
      success: function (data) {

        $('button[type="submit"]').removeAttr('disabled');
        $('button[type="submit"]').prop("disabled", false);
        $('.error').hide();
        if (data.fail) {

          for (control in data.errors) {
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
          }

          EditUser.printErroresFormulario(data);
        }
        if (data.state == 'error' && data.url == false) {
          Swal.fire({
            title: 'El Usuario no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        }
        if (data.state == 'success' && data.url != false) {
          Swal.fire({
            title: 'Modifciación Exitosa',
            text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido modificado satisfactoriamente`,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
          setTimeout(function(){
            window.location.href = data.url;
          }, 1000);
        }
      },
      // error: function (xhr, textStatus, errorThrown) {
      //   alert("Error: " + errorThrown);
      // }
    });
  });

var EditUser = {
  printErroresFormulario: function (data){
    if (data.state == 'error_form') {
      let errores = "";
      for (control in data.errors) {
          errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
          $('#' + control + '-error').html(data.errors[control]);
          $('#' + control + '-error').show();
      }
      Swal.fire({
          title: 'Advertencia!',
          html: 'Estas ingresando mal los datos.' + errores,
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      });
  }
  }
}

$(document).ready(function() {
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();

    $('#users_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_role !='' || filter_role != null) && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo , filter_role, filter_state, filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_role == '' || filter_role == null || filter_role == undefined) && filter_state != '' && (filter_year == '' || filter_year == null || filter_year == undefined)){
        UserIndex.fillDatatatablesUsers(filter_nodo = null , filter_role = null, filter_state, filter_year = null);
    }else{
        $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

    $('#mytalento_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_role !='' || filter_role != null) && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_nodo , filter_role, filter_state, filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_role == '' || filter_role == null || filter_role == undefined) && filter_state != '' && (filter_year == '' || filter_year == null || filter_year == undefined)){
        UserIndex.fillDatatatablesTalentos(filter_nodo = null , filter_role = null, filter_state, filter_year = null);
    }else{
        $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var UserIndex = {
    showInputs(){
        let filter_role = $('#filter_rol').val();
        if(filter_role == 'Talento'){
            $("#divyear").show();
            $('#filter_year>option[value="all"]').attr('selected', 'selected');
        }else{
            $("#divyear").hide();
            $('#filter_year>option[value="all"]').attr('selected', 'selected');
        }
        
    },
    fillDatatatablesUsers(filter_nodo ,filter_role, filter_state, filter_year){
        var datatable = $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: "/usuario",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_role: filter_role,
                    filter_state: filter_state,
                    filter_year: filter_year,
                }
            },
            columns: [
                {
                    data: 'tipodocumento',
                    name: 'tipodocumento',
                }, {
                    data: 'documento',
                    name: 'documento',
                }, {
                    data: 'nombrecompleto',
                    name: 'nombrecompleto',
                }, {
                    data: 'email',
                    name: 'email',
                }, {
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                }, 
            ],
        });
    },
    fillDatatatablesTalentos(filter_nodo ,filter_role, filter_state, filter_year){
        var datatable = $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: "/usuario/mistalentos",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_role: filter_role,
                    filter_state: filter_state,
                    filter_year: filter_year,
                }
            },
            columns: [
                {
                    data: 'tipodocumento',
                    name: 'tipodocumento',
                }, {
                    data: 'documento',
                    name: 'documento',
                }, {
                    data: 'nombrecompleto',
                    name: 'nombrecompleto',
                }, {
                    data: 'email',
                    name: 'email',
                }, {
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                }, 
            ],
        });
    }
}

$('#filter_user').click(function(){

    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();


    $('#users_data_table').dataTable().fnDestroy();


    if((filter_nodo != '' || filter_nodo != null) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo , filter_role, filter_state, filter_year);
        //idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo = null , filter_role, filter_state, filter_year);
    }else{
        $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
        
    }
    
});

$('#filter_talentos').click(function(){

    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();


    $('#mytalento_data_table').dataTable().fnDestroy();


    if((filter_nodo != '' || filter_nodo != null) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_nodo , filter_role, filter_state, filter_year);
        
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_nodo = null , filter_role, filter_state, filter_year);
    }else{
        $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
        
    }
    
});

$('#download_users').click(function(){
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();
    var query = {
        filter_nodo: filter_nodo,
        filter_role: filter_role,
        filter_state: filter_state,
        filter_year: filter_year,
    }

    var url = "/usuario/export?" + $.param(query)
    window.location = url;
});

$('#download_talentos').click(function(){
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();
    var query = {
        filter_nodo: filter_nodo,
        filter_role: filter_role,
        filter_state: filter_state,
        filter_year: filter_year,
    }

    var url = "/usuario/export-talentos?" + $.param(query)
    window.location = url;
});



$(document).on('submit', 'form#formEditProfile', function (event) {
    // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");

    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
    
          $('button[type="submit"]').removeAttr('disabled');
          $('button[type="submit"]').prop("disabled", false);
          $('.error').hide();
          if (data.fail) {
  
            for (control in data.errors) {
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
  
            EditProfileUser.printErroresFormulario(data);
          }
          if (data.state == 'error') {
            Swal.fire({
              title: 'Tu perfil no se ha modificado, por favor inténtalo de nuevo',
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
                window.location.href = data.url;
              }, 1000);
          }
          if (data.state == 'success') {
            Swal.fire({
              title: 'Modifciación Exitosa',
              text: `Tu perfil ha sido actualizado exitosamente.`,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.href = data.url;
            }, 1000);
          }
        },
        
      });
});


var EditProfileUser = {
    printErroresFormulario: function (data){
      if (data.state == 'error_form') {
        let errores = "";
        for (control in data.errors) {
            errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
        }
        Swal.fire({
            title: 'Advertencia!',
            html: 'Estas ingresando mal los datos.' + errores,
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        }
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
function consultarArticulacionesDelGestor(anho) {
  $('#articulacionesGestor_table').dataTable().fnDestroy();
  $('#articulacionesGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    "lengthChange": false,
    ajax:{
      url: "/articulacion/datatableArticulacionesDelGestor/"+0+"/"+anho,
      data: function (d) {
        d.codigo_articulacion = $('#codigo_articulacion_GestorTable').val(),
        d.gestor = $('#nombre_GestorAdministradorTable').val(),
        d.nombre = $('#nombre_GestorTable').val(),
        d.fase = $('#fase_GestorTable').val(),
        d.search = $('input[type="search"]').val()
      }
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
        data: 'proceso',
        name: 'proceso',
        orderable: false
      },
    ],
  });
}

$("#codigo_articulacion_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});

$("#nombre_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});

$("#fase_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});

function consultarGruposInvestigacion_FaseInicio_Articulaciones() {
    $('#gruposInvestigacion_articulacion_table').dataTable().fnDestroy();
    $('#gruposInvestigacion_articulacion_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [
            0, 'desc'
        ],
        ajax: {
            url: "/grupo/datatableGruposInvestigacionDeTecnoparque",
            type: "get"
        },
        select: true,
        columns: [
            {
                data: 'codigo_grupo',
                name: 'codigo_grupo'
            }, {
                data: 'nombre',
                name: 'nombre'
            }, {
                width: '20%',
                data: 'add_articulacion',
                name: 'add_articulacion',
                orderable: false
            },
        ]
    });
    $('#gruposDeInvestigacion_ArticulacionInicio_modal').openModal();
}

function addGrupoArticulacion(id) {
    $.ajax({
      dataType:'json',
      type:'get',
      url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+id
    }).done(function(respuesta){
      $('#txtgrupoInvestigacion').val(respuesta.detalles.codigo_grupo + ' - ' + respuesta.detalles.entidad.nombre);
      $("label[for='txtgrupoInvestigacion']").addClass('active');
      $('#txtgrupo_id').val(respuesta.detalles.id);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'El código del grupo de investigación con el que se realizará la articulación es: ' + respuesta.detalles.codigo_grupo
      })
      $('#gruposDeInvestigacion_ArticulacionInicio_modal').closeModal();
    })
  }

  // Datatable que muestra los talentos que se encuentran registrados en Tecnoparque
function consultarTalentosDeTecnoparque_Articulacion_FaseInicio_table(tableName, fieldName) {
    $(tableName).dataTable().fnDestroy();
    $(tableName).DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: "/usuario/talento/getTalentosDeTecnoparque/",
            type: "get"
        },
        columns: [
            {
                data: 'documento',
                name: 'documento'
            }, {
                data: 'talento',
                name: 'talento'
            }, {
                data: fieldName,
                name: fieldName,
                orderable: false
            },
        ]
    });
}

function ajaxSendFormArticulacion(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesArticulacionCreate(data);
            } else {
                mensajesArticulacionUpdate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
  };

  function mensajesArticulacionCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La articulación ha sido registrada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/articulacion");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'La articulación no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

function mensajesArticulacionUpdate(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa',
            text: "La articulación ha sido modificada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/articulacion");
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'La articulación no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

$(document).on('submit', 'form#frmArticulaciones_FaseInicio_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'update');
});

$(document).on('submit', 'form#frmArticulacion_FaseInicio', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'create');
});

function talentoYaSeEncuentraAsociado_Articulacion() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El talento ya se encuentra asociado a la articulación!'
    });
}

function talentoSeAsocioALaArticulacion() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El talento se ha asociado a la articulación!'
    });
}

function prepararFilaEnLaTablaDeTalentos_Articulacion(ajax) { // El ajax.talento.id es el id del TALENTO, no del usuario
    let idTalento = ajax.talento.id;
    let fila = '<tr class="selected" id=talentoAsociadoALaArticulacion' + idTalento + '>' + '<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton' + idTalento + '" value="' + idTalento + '" /><label for ="radioButton' + idTalento + '"></label></td>' + '<td><input type="hidden" name="talentos[]" value="' + idTalento + '">' + ajax.talento.documento + ' - ' + ajax.talento.talento + '</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeArticulacion_FaseInicio(' + idTalento + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

function pintarTalentoEnTabla_Fase_Inicio_Articulacion(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/usuario/talento/consultarTalentoPorId/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDeTalentos_Articulacion(ajax);
        $('#detalleTalentosDeUnaArticulacion_Create').append(fila);
        talentoSeAsocioALaArticulacion();
    });
}

function noRepeat_Articulacion(id) {
    let idTalento = id;
    let retorno = true;
    let a = document.getElementsByName("talentos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idTalento) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

function eliminarTalentoDeArticulacion_FaseInicio(index) {
    $('#talentoAsociadoALaArticulacion' + index).remove();
}

function addTalentoArticulacion(id) {
    if (noRepeat_Articulacion(id) == false) {
        talentoYaSeEncuentraAsociado_Articulacion();
    } else {
        pintarTalentoEnTabla_Fase_Inicio_Articulacion(id);
    }
}
// Enviar formulario para modificar el articulacion en fase de cierre
$(document).on('submit', 'form#frmArticulaciones_FaseCierre_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion_FaseCierre(form, data, url);
});

function ajaxSendFormArticulacion_FaseCierre(form, data, url) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            mensajesArticulacionCierre(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};


function mensajesArticulacionCierre(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa!',
            text: "La articulación ha sido modificado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/articulacion");
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'La articulación no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};
function detallesDeUnaArticulacion(id){
  $.ajax({
     dataType:'json',
     type:'get',
     url:"/articulacion/ajaxDetallesDeUnArticulacion/"+id,
  }).done(function(respuesta){
    $("#articulacionDetalle_titulo").empty();
    $("#detalleArticulacion").empty();
    if (respuesta.detalles == null) {
      Swal.fire(
        'Ups!!',
        'Ha ocurrido un error',
        'error'
      );
    } else {
      $("#articulacionDetalle_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaArticulacion/"+id+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='teal-text text-darken-3'>Código de la Articulación: </span><b>"+respuesta.detalles.codigo_articulacion+"</b>");
      $("#detalleArticulacion").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Nombre de la Articulación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nombre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Gestor a cargo: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.gestor+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Fecha de Inicio: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.fecha_inicio+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Estado de la Articulación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.estado+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Observaciones: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.observaciones+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Tipo de Articulación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.tipoArticulacion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Entregables: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaArticulacion('+respuesta.detalles.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Revisado Final: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.revisado_final+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'

        // +'<div class="row">'
        // +'<div class="col s12 m6 l6">'
        // +'<span class="teal-text text-darken-3">Empresa/Emprendedores/Grupo de Investigación: </span>'
        // +'</div>'
        // +'<div class="col s12 m6 l6">'
        // +'<span class="black-text">'+respuesta.detalles.tipo_articulacion+'</span><span onclick="verDetalleDeLaEntidadAsocidadALaArticulacion('+respuesta.detalles.id+')" class="new badge blue" data-badge-caption="Pulse aquí para ver estos detalles"></span>'
        // +'</div>'
        // +'</div>'
        // +'<div class="divider"></div>'
      );
    $('#articulacionDetalle').openModal();
    }
  });
}

function preguntaReversarArticulacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de reversar esta articulación a la fase de inicio?',
  // text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmReversarFaseArticulacion.submit();
    }
  })
}

function verDetalleDeLaEntidadAsocidadALaArticulacion(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/articulacion/consultarEntidadDeLaArticulacion/"+id
  }).done(function(respuesta){
    $("#detalleDeUnaArticulacion_titulo").empty();
    $("#detalleArticulacion_body").empty();
    if (respuesta.detalles == null) {
      Swal.fire(
        'Ups!!',
        'Ha ocurrido un error',
        'error'
      );
    } else {
      if (respuesta.articulacion.tipo_articulacion == 'Empresa') {
        $("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>");
        $("#detalleArticulacion_body").append("<div class='row'>"
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
      );
      $('#detalleArticulacion_modal').openModal();
    } else if (respuesta.articulacion.tipo_articulacion == 'Grupo de Investigación') {
      $("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>");
      $("#detalleArticulacion_body").append("<div class='row'>"
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
      +'<span class="black-text">'+respuesta.detalles.nombre_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.correo_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.ciudad+'</span>'
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
      +'<span class="black-text">'+respuesta.detalles.nombre_clasificacion+'</span>'
      +'</div>'
      +'</div>'
    );
    $('#detalleArticulacion_modal').openModal();
  } else {
    $("#talentosDeUnaArticulacion_titulo").empty();
    $("#talentosDeUnaArticulacion_table").empty();
    $("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>");
    $.each(respuesta.detalles, function( index, value ) {
      let rol = "Autor";
      if (value.talento_lider == 1) {
        rol = "Talento Líder";
      }
      $("#talentosDeUnaArticulacion_table").append('<tr><td>'+rol+'</td><td>'+value.talento+'</td></tr>'
      );
    });
    $('#talentosDeUnaArticulacion_modal').openModal();
  }
  }
});
}


function verDetallesDeLosEntregablesDeUnaArticulacion(id) {
  $.ajax({
     dataType:'json',
     type:'get',
     url:"/articulacion/ajaxDetallesDeLosEntregablesDeUnaArticulacion/"+id,
  }).done(function(respuesta){
    $("#detalleDeUnaArticulacion_titulo").empty();
    $("#detalleArticulacion_body").empty();
    if (respuesta.entregables == null) {
      Swal.fire(
        'Ups!!',
        'Ha ocurrido un error',
        'error'
      );
    } else {
      $("#detalleDeUnaArticulacion_titulo").append("<a class='btn btn-small blue-grey' target='_blank' href='/articulacion/"+respuesta.articulacion.id+"/entregables'>Ver los Archivos</a> <span class='teal-text text-darken-3'>Código de la Articulación: </span><b>"+respuesta.articulacion.codigo_articulacion+"</b>");
      $("#detalleArticulacion_body").append(
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
      if (respuesta.articulacion.tipo_articulacion == 'Grupo de Investigación') {
        $("#detalleArticulacion_body").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Formato de confidencialidad y compromiso firmado: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.entregables.acc+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
      }
      $("#detalleArticulacion_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Actas de Seguimiento: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.actas_seguimiento+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );
      $("#detalleArticulacion_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Acta de Cierre: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.acta_cierre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );

      if (respuesta.articulacion.tipo_articulacion == 'Empresa' || respuesta.articulacion.tipo_articulacion == 'Emprendedor') {
        $("#detalleArticulacion_body").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Informe final de la asesoría: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.entregables.informe_final+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'

          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Encuesta de satisfacción: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.entregables.pantallazo+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
      }

      $("#detalleArticulacion_body").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="teal-text text-darken-3">Otros: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.entregables.otros+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
      );
    $("#detalleArticulacion_modal").openModal();
    }
  });
}

function eliminarArticulacionPorId_event(id, e) {
  Swal.fire({
    title: '¿Desea eliminar la articulación?',
    text: "Al hacer esto, todo lo relacionado con esta articulación será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    cancelButtonText: 'No',
    confirmButtonText: 'Sí, eliminar!'
  }).then((result) => {
    if (result.value) {
      eliminarArticulacionPorId_moment(id);
    }
  })
}

function eliminarArticulacionPorId_moment(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/articulacion/eliminarArticulacion/'+id,
    success: function (data) {
      if (data.retorno) {
        Swal.fire('Eliminación Exitosa!', 'La articulación se ha eliminado completamente!', 'success');
        location.href = '/articulacion';
      } else {
        Swal.fire('Eliminación Errónea!', 'La articulación no se ha eliminado!', 'error');
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarIntervencionesEmpresaDelGestor(anho) {
  $('#IntervencionGestor_table').dataTable().fnDestroy();
  $('#IntervencionGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/intervencion/datatableIntervencionEmpresaDelGestor/"+0+"/"+anho,
      // type: "get",
      data: function (d) {
        d.codigo_articulacion = $('#codigo_articulacion_GestorTable').val(),
        d.nombre = $('#nombre_GestorTable').val(),
        d.estado = $('#estado_GestorTable').val(),
        d.search = $('input[type="search"]').val()
      }
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
}

$("#codigo_articulacion_GestorTable").keyup(function(){
  $('#IntervencionGestor_table').DataTable().draw();
});

$("#nombre_GestorTable").keyup(function(){
  $('#IntervencionGestor_table').DataTable().draw();
});


$("#estado_GestorTable").keyup(function(){
  $('#IntervencionGestor_table').DataTable().draw();
});

function detallesDeUnaIntervencion(id){
    $.ajax({
       dataType:'json',
       type:'get',
       url:"/intervencion/ajaxDetallesDeUnaArticulacion/"+id,
    }).done(function(respuesta){
      $("#articulacionDetalle_titulo").empty();
      $("#detalleArticulacion").empty();
      if (respuesta.detalles == null) {
        Swal.fire(
          'Ups!!',
          'Ha ocurrido un error',
          'error'
        );
      } else {
        $("#articulacionDetalle_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaArticulacion/"+id+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='teal-text text-darken-3'>Código de la Intervención: </span><b>"+respuesta.detalles.codigo_articulacion+"</b>");
        $("#detalleArticulacion").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Nombre de la Articulación: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.nombre+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Gestor a cargo: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.gestor+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Fecha de Inicio: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.fecha_inicio+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Estado de la Articulación: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.estado+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Observaciones: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.observaciones+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Tipo de Articulación: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.tipoArticulacion+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Entregables: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaIntervencionEmpresa('+respuesta.detalles.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Revisado Final: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.revisado_final+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
      $('#articulacionDetalle').openModal();
      }
    });
  }

  function verDetallesDeLosEntregablesDeUnaIntervencionEmpresa(id) {
    $.ajax({
       dataType:'json',
       type:'get',
       url:"/articulacion/ajaxDetallesDeLosEntregablesDeUnaArticulacion/"+id,
    }).done(function(respuesta){
      $("#detalleDeUnaArticulacion_titulo").empty();
      $("#detalleArticulacion_body").empty();
      if (respuesta.entregables == null) {
        Swal.fire(
          'Ups!!',
          'Ha ocurrido un error',
          'error'
        );
      } else {
        $("#detalleDeUnaArticulacion_titulo").append("<a class='btn btn-small blue-grey' target='_blank' href='/intervencion/"+respuesta.articulacion.id+"/entregables'>Ver los Archivos</a> <span class='teal-text text-darken-3'>Código de la Intervención a Empresa: </span><b>"+respuesta.articulacion.codigo_articulacion+"</b>");
        $("#detalleArticulacion_body").append(
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
        if (respuesta.articulacion.tipo_articulacion == 'Grupo de Investigación') {
          $("#detalleArticulacion_body").append(
            '<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="teal-text text-darken-3">Formato de confidencialidad y compromiso firmado: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.entregables.acc+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
          );
        }
        $("#detalleArticulacion_body").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Actas de Seguimiento: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.entregables.actas_seguimiento+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
        $("#detalleArticulacion_body").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Acta de Cierre: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.entregables.acta_cierre+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
  
        if (respuesta.articulacion.tipo_articulacion == 'Empresa' || respuesta.articulacion.tipo_articulacion == 'Emprendedor') {
          $("#detalleArticulacion_body").append(
            '<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="teal-text text-darken-3">Informe final de la asesoría: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.entregables.informe_final+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
  
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="teal-text text-darken-3">Encuesta de satisfacción: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.entregables.pantallazo+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
          );
        }
  
        $("#detalleArticulacion_body").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Otros: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.entregables.otros+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
      $("#detalleArticulacion_modal").openModal();
      }
    });
  }

  function verDetalleDeLaEntidadAsocidadALaArticulacion(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/articulacion/consultarEntidadDeLaArticulacion/"+id
  }).done(function(respuesta){
    $("#detalleDeUnaArticulacion_titulo").empty();
    $("#detalleArticulacion_body").empty();
    if (respuesta.detalles == null) {
      Swal.fire(
        'Ups!!',
        'Ha ocurrido un error',
        'error'
      );
    } else {
      if (respuesta.articulacion.tipo_articulacion == 'Empresa') {
        $("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>");
        $("#detalleArticulacion_body").append("<div class='row'>"
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
      );
      $('#detalleArticulacion_modal').openModal();
    } else if (respuesta.articulacion.tipo_articulacion == 'Grupo de Investigación') {
      $("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>");
      $("#detalleArticulacion_body").append("<div class='row'>"
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
      +'<span class="black-text">'+respuesta.detalles.nombre_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.correo_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.ciudad+'</span>'
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
      +'<span class="black-text">'+respuesta.detalles.nombre_clasificacion+'</span>'
      +'</div>'
      +'</div>'
    );
    $('#detalleArticulacion_modal').openModal();
  } else {
    $("#talentosDeUnaArticulacion_titulo").empty();
    $("#talentosDeUnaArticulacion_table").empty();
    $("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>");
    $.each(respuesta.detalles, function( index, value ) {
      let rol = "Autor";
      if (value.talento_lider == 1) {
        rol = "Talento Líder";
      }
      $("#talentosDeUnaArticulacion_table").append('<tr><td>'+rol+'</td><td>'+value.talento+'</td></tr>'
      );
    });
    $('#talentosDeUnaArticulacion_modal').openModal();
  }
  }
});
}

  function eliminarIntervencionEmpresaPorId_event(id, e) {
    Swal.fire({
      title: '¿Desea eliminar la Intervención a Empresa?',
      text: "Al hacer esto, todo lo relacionado con esta Intervención a Empresa será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      cancelButtonText: 'No',
      confirmButtonText: 'Sí, eliminar!'
    }).then((result) => {
      if (result.value) {
        eliminarIntervencionEmpresaPorId_moment(id);
      }
    })
  }
  
  function eliminarIntervencionEmpresaPorId_moment(id) {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/intervencion/eliminarArticulacion/'+id,
      success: function (data) {
        if (data.retorno) {
          Swal.fire('Eliminación Exitosa!', 'La Intervención a Empresa se ha eliminado completamente!', 'success');
          location.href = '/intervencion';
        } else {
          Swal.fire('Eliminación Errónea!', 'La Intervención a Empresa no se ha eliminado!', 'error');
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
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
                    <TH width="25%">Código Proyecto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                    <TH width="25%" >Nombre Proyecto</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
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
                    <TH width="25%">Código Articulación</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                    <TH width="25%" >Nombre de Articulación</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
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

$(document).ready(function () {
    // Contenedores
    divOtroAreaConocmiento = $('#otroAreaConocimiento_content');
    divEconomiaNaranja = $('#economiaNaranja_content');
    divDiscapacidad = $('#discapacidad_content');
    divNombreActorCTi = $('#nombreActorCTi_content');
    // Ocultar contenedores
    divOtroAreaConocmiento.hide();
    divEconomiaNaranja.hide();
    divDiscapacidad.hide();
    divNombreActorCTi.hide();
});


// Enviar formulario para registrar proyecto
$(document).on('submit', 'form#frmProyectos_FaseInicio', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'create');
});


// Enviar formulario para modificar datos del proyecto (Fase de Inicio)
$(document).on('submit', 'form#frmProyectos_FaseInicio_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'update');
});

function ajaxSendFormProyecto(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesProyectoCreate(data);
            } else {
                mensajesProyectoUpdate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesProyectoCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "El proyecto ha sido registrado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/proyecto");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'El proyecto no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

function mensajesProyectoUpdate(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa',
            text: "El proyecto ha sido registrado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/proyecto");
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'El proyecto no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

// Alerta que indica que el talento ya se encuentra asociado al proyecto
function talentoYaSeEncuentraAsociado() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El talento ya se encuentra asociado al proyecto!'
    });
}

// Alerta que indica que el talento ya se encuentra asociado al proyecto
function usuarioYaSeEncuentraAsociado_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El usuario ya se encuentra asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que la entidad ya se encuentra asociado al proyecto como dueña de la propiedad intelectual
function empresaYaSeEncuentraAsociado_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'Esta empresa ya se encuentra asociada como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que el talento se asoció correctamente al proyecto
function talentoSeAsocioAlProyecto() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El talento se ha asociado al proyecto!'
    });
}

// Alerta que indica que la empresa se asoció correctamente al proyecto como propietario
function empresaSeAsocioAlProyecto_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La empresa se ha asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que el grupo de investigación se asoció correctamente al proyecto como propietario
function grupoSeAsocioAlProyecto_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El grupo de investigación se ha asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que la idea de proyecto se asoció al proyecto
function ideaProyectoAsociadaConExito(codigo, nombre) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La siguiente idea se ha asociado al proyecto: ' + codigo + ' - ' + nombre
    });
}


// Prepara un string con la fila que se va a pintar en la tabla de los talentos que participaran en el proyecto
function prepararFilaEnLaTablaDeTalentos(ajax) { // El ajax.talento.id es el id del TALENTO, no del usuario
    let idTalento = ajax.talento.id;
    let fila = '<tr class="selected" id=talentoAsociadoAProyecto' + idTalento + '>' + '<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton' + idTalento + '" value="' + idTalento + '" /><label for ="radioButton' + idTalento + '"></label></td>' + '<td><input type="hidden" name="talentos[]" value="' + idTalento + '">' + ajax.talento.documento + ' - ' + ajax.talento.talento + '</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio(' + idTalento + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (users/persona) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Users(ajax) { // El ajax.user.id es el id del USER
    let idUser = ajax.user.id;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Persona' + idUser + '>' + '<td><input type="hidden" name="propietarios_user[]" value="' + idUser + '">' + ajax.user.documento + ' - ' + ajax.user.nombres + ' ' + ajax.user.apellidos + '</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona(' + idUser + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}


// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (empresas) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Empresa(ajax) {
    let idEmpresa = ajax.detalles.id;
    let codigo = ajax.detalles.nit;
    let nombre = ajax.detalles.nombre_empresa;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Empresa' + idEmpresa + '>' + '<td><input type="hidden" name="propietarios_empresas[]" value="' + idEmpresa + '">' + codigo + ' - ' + nombre + '</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(' + idEmpresa + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (grupos de investigación) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Grupos(ajax) { // El ajax.user.id es el id del USER
    let idGrupo = ajax.detalles.id;
    let codigo = ajax.detalles.codigo_grupo;
    let nombre = ajax.detalles.entidad.nombre;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Grupo' + idGrupo + '>' + '<td><input type="hidden" name="propietarios_grupos[]" value="' + idGrupo + '">' + codigo + ' - ' + nombre + '</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(' + idGrupo + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Pinta el talento en la tabla de los talentos que participarán en el proyecto
function pintarTalentoEnTabla_Fase_Inicio(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/usuario/talento/consultarTalentoPorId/' + id
    }).done(function (ajax) {

        let fila = prepararFilaEnLaTablaDeTalentos(ajax);
        $('#detalleTalentosDeUnProyecto_Create').append(fila);
        talentoSeAsocioAlProyecto();
    });
}

// Pinta el usuario en la tabla de los usuarios que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/usuario/consultarUserPorId/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Users(ajax);
        $('#propiedadIntelectual_Personas').append(fila);
        talentoSeAsocioAlProyecto();
    });
}

// Pinta el usuario en la tabla de las entidades (empresas) que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Empresa(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/empresa/ajaxDetallesDeUnaEmpresa/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Empresa(ajax);
        $('#propiedadIntelectual_Empresas').append(fila);
        empresaSeAsocioAlProyecto_Propietario();
    });
}

// Pinta el usuario en la tabla de las entidades (grupos de investigacion) que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/grupo/ajaxDetallesDeUnGrupoInvestigacion/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Grupos(ajax);
        // let fila = Grupos);
        $('#propiedadIntelectual_Grupos').append(fila);
        grupoSeAsocioAlProyecto_Propietario();
    });
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat(id) {
    let idTalento = id;
    let retorno = true;
    let a = document.getElementsByName("talentos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idTalento) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat_Propiedad(id) {
    let idUser = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_user[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idUser) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que la empresa no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Empresa(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_empresas[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idEntidad) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que el grupo de investigación no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Grupo(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_grupos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idEntidad) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Elimina un talento que se encuentre asociado a un proyecto
function eliminarTalentoDeProyecto_FaseInicio(index) {
    $('#talentoAsociadoAProyecto' + index).remove();
}

// Elimina una persona que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Persona(index) {
    $('#propietarioAsociadoAlProyecto_Persona' + index).remove();
}

// Elimina una empresa que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(index) {
    $('#propietarioAsociadoAlProyecto_Empresa' + index).remove();
}

// Elimina una empresa que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(index) {
    $('#propietarioAsociadoAlProyecto_Grupo' + index).remove();
}

// Método para agregar talentos a un proyecto
// El parametro recibido es el id de la tabla talentos
function addTalentoProyecto(id) {
    if (noRepeat(id) == false) {
        talentoYaSeEncuentraAsociado();
    } else {
        pintarTalentoEnTabla_Fase_Inicio(id);
    }
}

// Método para agregar un talento como dueño de una ´rpíedad intelectual
// El id recibido es el id de la tabla users
function addPersonaPropiedad(user_id) {
    if (noRepeat_Propiedad(user_id) == false) {
        usuarioYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(user_id);
    }
}

// Método para agregar una empresa como dueño de una propiedad intelectual
// El id recibido es el id de la tabla empresas
function addEntidadEmpresa(id) {
    if (noRepeat_Empresa(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Empresa(id);
    }
}

// Método para agregar un grupo de investigación como dueño de una propiedad intelectual
// El id recibido es el id de la tabla gruposinvestigacion
function addGrupoPropietario(id) {
    if (noRepeat_Grupo(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(id);
    }
}

// Asocia una idea de proyecto al registro de un proyecto
function asociarIdeaDeProyectoAProyecto(id, nombre, codigo) {
    $('#txtidea_id').val(id);
    $('#ideasDeProyectoConEmprendedores_modal').closeModal();
    ideaProyectoAsociadaConExito(codigo, nombre);
    $('#txtnombreIdeaProyecto_Proyecto').val(codigo + " - " + nombre);
    $('#txtnombre').val(nombre);
    $("label[for='txtnombreIdeaProyecto_Proyecto']").addClass('active');
    $("label[for='txtnombre']").addClass('active');
}

// Consultas las ideas de proyecto que fueron aprobadas en el comité
function consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio() {
    $('#ideasDeProyectoConEmprendedores_proyecto_table').dataTable().fnDestroy();
    $('#ideasDeProyectoConEmprendedores_proyecto_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [
            0, 'desc'
        ],
        ajax: {
            url: "/proyecto/datatableIdeasConEmprendedores",
            type: "get"
        },
        select: true,
        columns: [
            {
                data: 'codigo_idea',
                name: 'codigo_idea'
            }, {
                data: 'nombre_proyecto',
                name: 'nombre_proyecto'
            }, {
                data: 'nombres_contacto',
                name: 'nombres_contacto'
            }, {
                width: '20%',
                data: 'checkbox',
                name: 'checkbox',
                orderable: false
            },
        ]
    });
    $('#ideasDeProyectoConEmprendedores_modal').openModal({dismissible: false});
}

// Datatable que muestra las empresas que hay en la base de datos para asociarlas como propietarios
function consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table() {
    $('#posiblesPropietarios_Empresas_table').dataTable().fnDestroy();
    $('#posiblesPropietarios_Empresas_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: "/empresa/datatableEmpresasDeTecnoparque",
            type: "get"
        },
        columns: [
            {
                data: 'nit',
                name: 'nit'
            }, {
                data: 'nombre_empresa',
                name: 'nombre_empresa'
            }, {
                data: 'add_propietario',
                name: 'add_propietario',
                orderable: false
            },
        ]
    });
    $('#posiblesPropietarios_Empresas_modal').openModal();
}

// Datatable que muestra los grupos de investigación que hay en la base de datos para asociarlas como propietarios
function consultarGruposDeTecnoparque_Proyecto_FaseInicio_table() {
    $('#posiblesPropietarios_Grupos_table').dataTable().fnDestroy();
    $('#posiblesPropietarios_Grupos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: "/grupo/datatableGruposInvestigacionDeTecnoparque",
            type: "get"
        },
        columns: [
            {
                data: 'codigo_grupo',
                name: 'codigo_grupo'
            }, {
                data: 'nombre',
                name: 'nombre'
            }, {
                data: 'add_propietario',
                name: 'add_propietario',
                orderable: false
            },
        ]
    });
    $('#posiblesPropietarios_Grupos_modal').openModal();
}

// Datatable que muestra los talentos que se encuentran registrados en Tecnoparque
function consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table(tableName, fieldName) {
    $(tableName).dataTable().fnDestroy();
    $(tableName).DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: "/usuario/talento/getTalentosDeTecnoparque/",
            type: "get"
        },
        columns: [
            {
                data: 'documento',
                name: 'documento'
            }, {
                data: 'talento',
                name: 'talento'
            }, {
                data: fieldName,
                name: fieldName,
                orderable: false
            },
        ]
    });
    if (tableName == '#posiblesPropietarios_Personas_table') {
        $('#posiblesPropietarios_Personas_modal').openModal();
    }
}

function selectAreaConocimiento_Proyecto_FaseInicio() {
    let id = $("#txtareaconocimiento_id").val();
    let nombre = $("#txtareaconocimiento_id [value='" + id + "']").text();
    if (nombre == 'Otro') {
        divOtroAreaConocmiento.show();
    } else {
        divOtroAreaConocmiento.hide();
    }
}

function showInput_EconomiaNaranja() {
    if ($('#txteconomia_naranja').is(':checked')) {
        divEconomiaNaranja.show();
    } else {
        divEconomiaNaranja.hide();
    }
}

function showInput_Discapacidad() {
    if ($('#txtdirigido_discapacitados').is(':checked')) {
        divDiscapacidad.show();
    } else {
        divDiscapacidad.hide();
    }
}

function showInput_ActorCTi() {
    if ($('#txtarti_cti').is(':checked')) {
        divNombreActorCTi.show();
    } else {
        divNombreActorCTi.hide();
    }
}

// Enviar formulario para modificar el proyecto en fase de cierre
$(document).on('submit', 'form#frmProyectos_FaseCierre_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto_FaseCierre(form, data, url);
});

function ajaxSendFormProyecto_FaseCierre(form, data, url) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            mensajesProyectoCierre(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};


function printErroresFormulario(data) {
    if (data.state == 'error_form') {
        let errores = "";
        for (control in data.errors) {
            errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
        }
        Swal.fire({
            title: 'Advertencia!',
            html: 'Estas ingresando mal los datos.' + errores,
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    }
}

function mensajesProyectoCierre(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa!',
            text: "El proyecto ha sido modificado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/proyecto");
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'El proyecto no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

$(document).ready(function() {
  $('#empresasDeTecnoparque_modEdt_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
    processing: true,
    serverSide: true,
    ajax:{
      url: "/empresa/datatableEmpresasDeTecnoparque",
      type: "get",
    },
    deferRender: true,
    columns: [
      { data: 'nit', name: 'nit' },
      { data: 'nombre_empresa', name: 'nombre_empresa' },
      { data: 'add_empresa_a_edt', name: 'add_empresa_a_edt' }
    ],
  });
});

divFechaCierreEdt = $('#divFechaCierreEdt');
divFechaCierreEdt.hide();

function actiarFechaFinDeLaEdt() {
  if ( $('#txtestado').is(':checked') ) {
    divFechaCierreEdt.show();
  } else {
    divFechaCierreEdt.hide();
  }
}

function noRepeat(id) {
  let idEntidad = id;
  let retorno = true;
  let a = document.getElementsByName("entidades[]");
  for (x=0;x<a.length;x++){
    if (a[x].value == idEntidad) {
      retorno = false;
      break;
    }
  }
  return retorno;
}

function addEmpresaAEdt(id) {
  if (noRepeat(id) == false) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      type: 'warning',
      title: 'La empresa ya se encuentra asociada a la edt!'
    });
  } else {
    $.ajax({
      dataType:'json',
      type:'get',
      url:'/empresa/ajaxConsultarEmpresaPorIdEntidad/'+id,
    }).done(function(ajax){
      let idEntidad = ajax.detalles.entidad_id;
      let fila = '<tr class="selected" id=entidadAsociadaAEdt'+idEntidad+'>'
      +'<td><input type="hidden" name="entidades[]" value="'+idEntidad+'">'+ajax.detalles.nit+'</td>'
      +'<td>'+ajax.detalles.nombre+'</td>'
      +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminarEntidadAsociadaAEdt('+idEntidad+');"><i class="material-icons">delete_sweep</i></a></td>'
      +'</tr>';
      $('#detalleEntidadesAsociadasAEdt').append(fila);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La empresa se ha asociado a la edt!'
      });
    });
  }
}

function eliminarEntidadAsociadaAEdt(index){
  $('#entidadAsociadaAEdt'+index).remove();
  Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'success',
    title: 'Se ha removido la empresa de la edt!'
  });
}

$(document).ready(function() {
  consultarEdtsDeUnGestor(0);
})


// Ajax que muestra los proyectos de un gestor por año
function consultarEdtsDeUnGestor(id) {
  // console.log('event');
  let anho = $('#txtanho_edts_Gestor').val();
  // let gestor = $('#txtgestor_id').val();
  $('#edtPorGestor_table').dataTable().fnDestroy();
  $('#edtPorGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/edt/consultarEdtsDeUnGestor/"+id+"/"+anho,
      type: "get",
    },
    columns: [
      {
        width: '10%',
        data: 'codigo_edt',
        name: 'codigo_edt',
      },
      {
        width: '15%',
        data: 'nombre',
        name: 'nombre',
      },
      {
        width: '15%',
        data: 'gestor',
        name: 'gestor',
      },
      {
        width: '6%',
        data: 'area_conocimiento',
        name: 'area_conocimiento',
      },
      {
        width: '6%',
        data: 'tipo_edt',
        name: 'tipo_edt',
      },
      {
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        width: '6%',
        data: 'business',
        name: 'business',
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
    ],
  });
}

$(document).ready(function() {
  datatableEdtsPorNodo(0);
});

function eliminarEdtPorId_event(id, event) {
  Swal.fire({
    title: '¿Desea eliminar la edt?',
    text: "Al hacer esto, todo lo relacionado con esta edt será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    cancelButtonText: 'No',
    confirmButtonText: 'Sí, eliminar!'
  }).then((result) => {
    if (result.value) {
      eliminarEdtPorId_moment(id);
    }
  })
}

function eliminarEdtPorId_moment(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/edt/eliminarEdt/'+id,
    success: function (data) {
      if (data.retorno) {
        Swal.fire('Eliminación Exitosa!', 'La edt se ha eliminado completamente!', 'success');
        location.href = '/edt';
      } else {
        Swal.fire('Eliminación Errónea!', 'La edt no se ha eliminado!', 'error');
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function datatableEdtsPorNodo(id) {
  let anho = $('#txtanho_edts_Nodo').val();
  $('#edtPorNodo_table').dataTable().fnDestroy();
  $('#edtPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/edt/consultarEdtsDeUnNodo/"+id+"/"+anho,
      type: "get",
    },
    columns: [
      {
        width: '10%',
        data: 'codigo_edt',
        name: 'codigo_edt',
      },
      {
        width: '15%',
        data: 'nombre',
        name: 'nombre',
      },
      {
        width: '15%',
        data: 'gestor',
        name: 'gestor',
      },
      {
        width: '6%',
        data: 'area_conocimiento',
        name: 'area_conocimiento',
      },
      {
        width: '6%',
        data: 'tipo_edt',
        name: 'tipo_edt',
      },
      {
        width: '8%',
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        width: '8%',
        data: 'estado',
        name: 'estado',
      },
      {
        width: '5%',
        data: 'business',
        name: 'business',
        orderable: false
      },
      {
        width: '5%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '5%',
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
      {
        width: '5%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        width: '5%',
        data: 'delete',
        name: 'delete',
        orderable: false
      },
    ],
  });
}
/**
* Mostrar la entidades registradas en una por el id de la edt
*/
function verEntidadesDeUnaEdt(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/edt/consultarDetallesDeUnaEdt/"+id+"/"+1,
    success: function (response) {
      $("#entidadesEdt_table").empty();
      if (response.entidades.length != 0 ) {
        $("#entidadesEdt_titulo").empty();
        $("#entidadesEdt_titulo").append("<span class='cyan-text text-darken-3'>Código de la Edt: </span>"+response.edt.codigo_edt+"");
        $.each(response.entidades, function(i, item) {
          $("#entidadesEdt_table").append(
            '<tr>'
            +'<td>'+item.nit+'</td>'
            +'<td>'+item.nombre+'</td>'
            +'</tr>'
          );
        });
        $('#entidadesEdt_modal').openModal();
      } else {
        Swal.fire({
          title: 'Ups!!',
          text: "No se encontraron empresas asociadas a esta Edt!",
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
        })
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    }
  })
}

/**
* Muestra el detalle de una edt
*/
function detallesDeUnaEdt(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url:'/edt/consultarDetallesDeUnaEdt/'+id+"/"+0,
    success: function (response) {
      /**
      * Limpiando el modal
      */
      $('#detalleEdt_titulo').empty();
      $('#detalleEdt_detalle').empty();
      /**
      * Pintando datos en el modal
      */
      let fecha_cierre = "";
      response.edt.estado == 'Inactiva' ? fecha_cierre = response.edt.fecha_cierre : fecha_cierre = 'La Edt aún se encuentra activa!';
      $("#detalleEdt_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaEdt/"+id+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='cyan-text text-darken-3'>Código de la Edt: </span>"+response.edt.codigo_edt+"");
      $("#detalleEdt_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código de la Edt: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.codigo_edt+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Nombre de la Edt: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.nombre+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Área de Conocimiento: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.areaconocimiento+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Tipo de Edt: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.tipoedt+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de Inicio: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.fecha_inicio+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de Cierre: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+fecha_cierre+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m12 l12">'
      +'<h6 class="cyan-text text-darken-3 center">Asistentes</h6>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Empleados: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.empleados+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Instructores: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.instructores+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Aprendices: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.aprendices+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Público: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.publico+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Observaciones: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.observaciones+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');
      /**
      * Abriendo modal
      */
      $('#detalleEdt_modal').openModal();
    },
    error: function (xhr, txtStatus, errorThrown){
      alert("Error: " + errorThrown);
    }
  })
}

$(document).ready(function() {
    $('#laboratorio_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false
    });
});
var selectLaboratorioNodo = {
    selectLaboraotrioForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#laboratorio_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#laboratorio_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                ajax: {
                    url: "/laboratorio/nodo/" + nodo,
                    type: "get",
                },
                dom: "Bfrtip",
                buttons: [
                    
                ],
                columns: [{
                    data: 'nombre',
                    name: 'nombre',
                    width: '30%'
                }, {
                    data: 'lineatecnologica',
                    name: 'lineatecnologica',
                    width: '30%'
                }, {
                    data: 'participacion_costos',
                    name: 'participacion_costos',
                    width: '15%'
                },
                {
                    data: 'estado',
                    name: 'estado',
                    width: '10%'
                },
                 {
                    data: 'materiales',
                    name: 'materiales',
                    orderable: false,
                    width: '8%'
                }, {
                    data: 'edit',
                    name: 'edit',
                    orderable: false,
                    width: '8%'
                }, ],
            });
        }else{
            $('#laboratorio_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
        
    },
}
$(document).ready(function() {
    $('#laboratorio_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "/laboratorio",
            type: "get",
        },
        columns: [{
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'lineatecnologica',
            name: 'lineatecnologica',
            width: '30%'
        }, {
            data: 'participacion_costos',
            name: 'participacion_costos',
            width: '15%'
        }, {
            data: 'estado',
            name: 'estado',
            width: '10%'
        }, {
            data: 'materiales',
            name: 'materiales',
            orderable: false,
            width: '8%'
        }, {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],
    });
});
$(document).ready(function() {
    $('#costoadministrativo_dinamizador_table1').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
         retrieve: true,
       	processing: true,
        // serverSide: true,
        ajax: {
            url: "/costos-administrativos",
            type: "get",
        },
        columns: [{
            data: 'entidad',
            name: 'entidad',
            width: '30%'
        }, {
            data: 'costoadministrativo',
            name: 'costoadministrativo',
            width: '30%'
        }, {
            data: 'valor',
            name: 'valor',
            width: '15%'
        }, {
            data: 'costosadministrativospordia',
            name: 'costosadministrativospordia',
            width: '15%'
        },
        {
            data: 'costosadministrativosporhora',
            name: 'costosadministrativosporhora',
            width: '15%'
        },
        {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            totalCostosHora = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalCostosDia = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalCostosMes = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotalCostosHora = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalCostosDia = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalCostosMes = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$ '+pageTotalCostosHora +' ( $'+ totalCostosHora +' total)'
            );

            $( api.column( 3 ).footer() ).html(
                '$ '+pageTotalCostosDia +' ( $'+ totalCostosDia +' total)'
            );

            $( api.column( 2 ).footer() ).html(
                '$ '+pageTotalCostosMes +' ( $'+ totalCostosMes +' total)'
            );
        }
    });
});
$(document).ready(function() {
    $('#costoadministrativo_dinamizador_table1').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
         retrieve: true,
       	processing: true,
        // serverSide: true,
        ajax: {
            url: "/costos-administrativos",
            type: "get",
        },
        columns: [{
            data: 'entidad',
            name: 'entidad',
            width: '30%'
        }, {
            data: 'costoadministrativo',
            name: 'costoadministrativo',
            width: '30%'
        }, {
            data: 'valor',
            name: 'valor',
            width: '15%'
        }, {
            data: 'costosadministrativospordia',
            name: 'costosadministrativospordia',
            width: '15%'
        },
        {
            data: 'costosadministrativosporhora',
            name: 'costosadministrativosporhora',
            width: '15%'
        },
        {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            totalCostosHora = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalCostosDia = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalCostosMes = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotalCostosHora = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalCostosDia = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalCostosMes = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$ '+pageTotalCostosHora +' ( $'+ totalCostosHora +' total)'
            );

            $( api.column( 3 ).footer() ).html(
                '$ '+pageTotalCostosDia +' ( $'+ totalCostosDia +' total)'
            );

            $( api.column( 2 ).footer() ).html(
                '$ '+pageTotalCostosMes +' ( $'+ totalCostosMes +' total)'
            );
        }
    });
});
$(document).ready(function() {
    $('#equipos_de_tecnoparque_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        "lengthChange": false,
    });

});

var selectEquipoPorNodo = {
    selectEquipoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#equipos_de_tecnoparque_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#equipos_de_tecnoparque_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                 fixedHeader: {
                    header: true,
                    footer: true
                },
                "pagingType": "full_numbers",
                ajax: {
                    url: "/equipos/getequipospornodo/" + nodo,
                    type: "get",
                },
                columns: [{
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '30%'
                }, {
                    data: 'nombre',
                    name: 'nombre',
                    width: '30%'
                }, {
                    data: 'referencia',
                    name: 'referencia',
                    width: '15%'
                }, {
                    data: 'marca',
                    name: 'marca',
                    width: '15%'
                },
                {
                    data: 'costo_adquisicion',
                    name: 'costo_adquisicion',
                    width: '15%'
                },
                {
                    data: 'vida_util',
                    name: 'vida_util',
                    width: '15%'
                },
                {
                    data: 'horas_uso_anio',
                    name: 'horas_uso_anio',
                    width: '15%'
                },
                {
                    data: 'anio_compra',
                    name: 'anio_compra',
                    width: '15%'
                },
                
                {
                    data: 'anio_fin_depreciacion',
                    name: 'anio_fin_depreciacion',
                    width: '15%'
                },
                {
                    data: 'depreciacion_por_anio',
                    name: 'depreciacion_por_anio',
                    width: '15%'
                },],
            });


        }else{
            $('#equipos_de_tecnoparque_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
        
    },
}

$(document).ready(function() {
    $('#equipo_tecnoparque_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
       	processing: true,
        serverSide: true,
        ajax: {
            url: "/equipos",
            type: "get",
        },
        columns: [{
            data: 'nombrelinea',
            name: 'nombrelinea',
            width: '30%'
        }, {
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'referencia',
            name: 'referencia',
            width: '15%'
        }, {
            data: 'marca',
            name: 'marca',
            width: '15%'
        },
        {
            data: 'costo_adquisicion',
            name: 'costo_adquisicion',
            width: '15%'
        },
        {
            data: 'vida_util',
            name: 'vida_util',
            width: '15%'
        },
        {
            data: 'horas_uso_anio',
            name: 'horas_uso_anio',
            width: '15%'
        },
        {
            data: 'anio_compra',
            name: 'anio_compra',
            width: '15%'
        },
        
        {
            data: 'anio_fin_depreciacion',
            name: 'anio_fin_depreciacion',
            width: '15%'
        },
        {
            data: 'depreciacion_por_anio',
            name: 'depreciacion_por_anio',
            width: '15%'
        },
        {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],

    });
});
$(document).ready(function() {
    $('#equipo_tecnoparque_gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        "dom": 'Blfrtip',
        buttons: [{
            extend: 'csv',
            text: 'exportar csv',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'excel',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'pdf',
            exportOptions: {
                columns: ':visible'
            }
        }, ],
        ajax: {
            url: "/equipos",
            type: "get",
        },
        columns: [{
            data: 'nombrelinea',
            name: 'nombrelinea',
            width: '30%'
        }, {
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'referencia',
            name: 'referencia',
            width: '15%'
        }, {
            data: 'marca',
            name: 'marca',
            width: '15%'
        }, {
            data: 'costo_adquisicion',
            name: 'costo_adquisicion',
            width: '15%'
        }, {
            data: 'vida_util',
            name: 'vida_util',
            width: '15%'
        }, {
            data: 'horas_uso_anio',
            name: 'horas_uso_anio',
            width: '15%'
        }, {
            data: 'anio_compra',
            name: 'anio_compra',
            width: '15%'
        }, {
            data: 'anio_fin_depreciacion',
            name: 'anio_fin_depreciacion',
            width: '15%'
        }, {
            data: 'depreciacion_por_anio',
            name: 'depreciacion_por_anio',
            width: '15%'
        }, ],
    });
});
$(document).ready(function() {
    $('#mantenimientosequipos_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        "lengthChange": false,
    });

});

var selectMantenimientosEquiposPorNodo = {
    selectMantenimientosEquipoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#mantenimientosequipos_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#mantenimientosequipos_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                retrieve: true,
                "lengthChange": false,
                 fixedHeader: {
                    header: true,
                    footer: true
                },
                "pagingType": "full_numbers",
                ajax: {
                    url: "/mantenimientos/getmantenimientosequipospornodo/" + nodo,
                    type: "get",
                },
                columns: [{
                    data: 'lineatecnologica',
                    name: 'lineatecnologica',
                    width: '30%'
                }, {
                    data: 'equipo',
                    name: 'equipo',
                    width: '30%'
                }, {
                    data: 'ultimo_anio_mantenimiento',
                    name: 'ultimo_anio_mantenimiento',
                    width: '15%'
                }, {
                    data: 'valor_mantenimiento',
                    name: 'valor_mantenimiento',
                    width: '15%'
                }, {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                }, ],
            });


        }else{
            $('#mantenimientosequipos_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
        
    },
}
$(document).ready(function() {
    $('#mantenimientosequipos_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/mantenimientos",
            type: "get",
        },
        columns: [{
            data: 'lineatecnologica',
            name: 'lineatecnologica',
            width: '30%'
        }, {
            data: 'equipo',
            name: 'equipo',
            width: '30%'
        }, {
            data: 'ultimo_anio_mantenimiento',
            name: 'ultimo_anio_mantenimiento',
            width: '15%'
        }, {
            data: 'valor_mantenimiento',
            name: 'valor_mantenimiento',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        }, {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],
    });
});
$(document).ready(function() {
    $('#mantenimientosequipos_gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/mantenimientos",
            type: "get",
        },
        columns: [{
            data: 'lineatecnologica',
            name: 'lineatecnologica',
            width: '30%'
        }, {
            data: 'equipo',
            name: 'equipo',
            width: '30%'
        }, {
            data: 'ultimo_anio_mantenimiento',
            name: 'ultimo_anio_mantenimiento',
            width: '15%'
        }, {
            data: 'valor_mantenimiento',
            name: 'valor_mantenimiento',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        }, ],
    });
});
$(document).ready(function() {
    $('#materiales_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        "lengthChange": false,
    });

});

var selectMaterialesPorNodo = {
    selectMaterialesForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#materiales_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#materiales_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                retrieve: true,
                "lengthChange": false,
                 fixedHeader: {
                    header: true,
                    footer: true
                },
                "pagingType": "full_numbers",
                ajax: {
                    url: "/materiales/getmaterialespornodo/" + nodo,
                    type: "get",
                },
                columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                    width: '20%'
                },
                {
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '30%'
                },{
                    data: 'codigo_material',
                    name: 'codigo_material',
                    width: '30%'
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    width: '30%'
                }, {
                    data: 'presentacion',
                    name: 'presentacion',
                    width: '15%'
                }, {
                    data: 'medida',
                    name: 'medida',
                    width: '15%'
                },
                {
                    data: 'cantidad',
                    name: 'cantidad',
                    width: '15%'
                },
                {
                    data: 'valor_unitario',
                    name: 'valor_unitario',
                    width: '15%'
                },
                {
                    data: 'valor_compra',
                    name: 'valor_compra',
                    width: '15%'
                },

                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                }, ],
            });


        }else{
            $('#materiales_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
        
    },
    
}
$(document).ready(function() {
    $('#materiales_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/materiales",
            type: "get",
        },
        columns: [{
            data: 'fecha',
            name: 'fecha',
            width: '20%'
        }, {
            data: 'nombrelinea',
            name: 'nombrelinea',
            width: '30%'
        }, {
            data: 'codigo_material',
            name: 'codigo_material',
            width: '30%'
        }, {
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'presentacion',
            name: 'presentacion',
            width: '15%'
        }, {
            data: 'medida',
            name: 'medida',
            width: '15%'
        }, {
            data: 'cantidad',
            name: 'cantidad',
            width: '15%'
        }, {
            data: 'valor_unitario',
            name: 'valor_unitario',
            width: '15%'
        }, {
            data: 'valor_compra',
            name: 'valor_compra',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        },
         ],
    });
});

$(document).ready(function() {
    $('#materiales_gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/materiales",
            type: "get",
        },
        columns: [{
            data: 'fecha',
            name: 'fecha',
            width: '20%'
        },  {
            data: 'codigo_material',
            name: 'codigo_material',
            width: '30%'
        }, {
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'presentacion',
            name: 'presentacion',
            width: '15%'
        }, {
            data: 'medida',
            name: 'medida',
            width: '15%'
        }, {
            data: 'cantidad',
            name: 'cantidad',
            width: '15%'
        }, {
            data: 'valor_unitario',
            name: 'valor_unitario',
            width: '15%'
        }, {
            data: 'valor_compra',
            name: 'valor_compra',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        },
         ],
    });
});

function getSelectMaterialMedida(){
    let medida = $('#txtmedida option:selected').text();
    let id_medida = $('#txtmedida').val();
    $("#txtcantidad").prop('disabled', true);
    $("label[for='txtcantidad']").empty();
     if(id_medida != ''){
        $("#txtcantidad").prop('disabled', false);
        $("#txtcantidad").val('');
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete en '+medida);
    }
    else{

        $("#txtcantidad").prop('disabled', true);
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete');
    }
}

var materialFormacion = {
    destroyMaterial: function(id){

        Swal.fire({
            title: '¿Estas seguro de eliminar este material de formación?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, elminar material',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {

                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: "/materiales/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(data.status == 200){
                            Swal.fire(
                                'Eliminado!',
                                'El material de formación ha sido eliminado satisfactoriamente.',
                                'success'
                              );
                            location.href = data.route;

                        }else if(data.status == 226){
                            Swal.fire(
                                'No se puede elimnar!',
                                data.message,
                                'error'
                              );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                  'Cancelado',
                  'Tu material de formación está a salvo',
                  'error'
                )
            }
        })
    }
}

$(document).ready(function() {
    $('#costoadministrativo_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        // dom: 'Bfrtip',
        // buttons: [
        //     {
        //         text:      '<i class="fa fa-files-o"></i>',
        //         titleAttr: 'EXCEL',
        //         className: 'waves-effect waves-light btn',
        //         action: function ( e, dt, node, config ) {
        //             alert( 'Button activated' );
        //         }
        //     },
        //     {
        //         text: 'PDF',
        //         className: 'waves-effect waves-light btn red',
        //         action: function ( e, dt, node, config ) {
        //             alert( 'Button activated' );
        //         }
        //     }
        // ],

    });

});

var selectCostoAdministrativoNodo = {
	selectCostoAdministrativoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#costoadministrativo_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#costoadministrativo_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                "order": [[ 1, "asc" ]],
                 fixedHeader: {
                    header: true,
                    footer: true
                },
                // "paging":   false,
                // "ordering": false,
                // "info":     false,
                // "dom": '<"top"i>rt<"bottom"flp><"clear">',
                // stateSave: true,
                // "scrollY":        "200px",
                // // "scrollCollapse": true,
                "pagingType": "full_numbers",
                ajax: {
                    url: "/costos-administrativos/costoadministrativo/" + nodo,
                    type: "get",
                },
                columns: [{
			            data: 'entidad',
			            name: 'entidad',
			            width: '30%'
			        }, {
			            data: 'costoadministrativo',
			            name: 'costoadministrativo',
			            width: '30%'
			        }, {
			            data: 'valor',
			            name: 'valor',
			            width: '15%'
			        },
			        {
			            data: 'costosadministrativospordia',
			            name: 'costosadministrativospordia',
			            width: '15%'
			        },
                    {
                        data: 'costosadministrativosporhora',
                        name: 'costosadministrativosporhora',
                        width: '15%'
                    },
			    ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    totalCostosHora = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    totalCostosDia = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    totalCostosMes = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Total over this page
                    pageTotalCostosHora = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalCostosDia = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalCostosMes = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
         
                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        '$ '+pageTotalCostosHora +' ( $'+ totalCostosHora +' total)'
                    );

                    $( api.column( 3 ).footer() ).html(
                        '$ '+pageTotalCostosDia +' ( $'+ totalCostosDia +' total)'
                    );

                    $( api.column( 2 ).footer() ).html(
                        '$ '+pageTotalCostosMes +' ( $'+ totalCostosMes +' total)'
                    );
                }

           	});


        }else{
            $('#costoadministrativo_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
        
    },
}
$(document).ready(function() {
    $('#usoinfraestructura_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });
});

var UsoInfraestructuraAdministrador = {
    selectUsoInfraestructuraPorNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#usoinfraestructura_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            $('#usoinfraestructura_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usoinfraestructura/usoinfraestructurapornodo/" + nodo,
                    type: "get",
                },
                columns: [{
                    data: 'fecha',
                    name: 'fecha',
                },  {
                    data: 'actividad',
                    name: 'actividad',
                }, {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                }, {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                },{
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                }, ],
            });
        }else{
            $('#usoinfraestructura_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },
    queryGestoresByNodo: function(){
        let nodo = $('#selectnodo').val();

        if (nodo == null || nodo == ''){
              $('#selectGestor').empty();
              $('#selectGestor').append('<option value="" selected>Seleccione un Gestor</option>');
        }else{
            $.ajax({
                type: 'GET',
                url: '/usuario/usuarios/gestores/nodo/'+ nodo,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    
                    $('#selectGestor').empty();
                    $('#selectGestor').append('<option value="">Seleccione un Gestor</option>')
                    $.each(data.gestores, function(i, e) {
                        $('#selectGestor').append('<option  value="'+i+'">'+e+'</option>');
                    })
          
                    $('#selectGestor').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }
    },

    queryActivitiesByGestor: function(){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        let nodo = $('#selectnodo').val();
        

        if (nodo == null || nodo == ''){
            
            $('#selectGestor').empty();
            $('#selectGestor').append('<option value="">Seleccione un Gestor</option>');
            $('#selectYear').empty();
            $('#selectYear').append('<option value="">Seleccione un año</option>');
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else if (gestor == null || gestor == ''){
            
            $('#selectYear').empty();
            $('#selectYear').append('<option value="">Seleccione un año</option>');
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else if(anho == null || anho == ''){
            
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ gestor + '/' + anho,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                  
                  $('#selectActivity').empty();
                  $('#selectActivity').append('<option value="">Seleccione la Actividad</option>');
                  $.each(data.actividades, function(i, e) {
                    $('#selectActivity').append('<option  value="'+i+'">'+e+'</option>');
                  });
            
                  $('#selectActivity').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }

    },
    ListActividadesPorGestor: function (){
        let nodo = $('#selectnodo').val();
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        let actividad = $('#selectActivity').val();
    
        if(nodo == '' || nodo == null){
            Swal.fire(
              'Error',
              'Por favor selecciona un nodo',
              'error'
            );
            $('#selectGestor').empty();
            $('#selectGestor').append('<option value="">Seleccione un Gestor</option>');
            
        }
        else if(gestor == '' || gestor == null){
            Swal.fire(
            'Error',
            'Por favor selecciona un gestor',
            'error'
            );
            $('#selectYear').empty();
            $('#selectYear').append('<option value="">Seleccione un año</option>');
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un año',
          'error'
        );
        
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
      }else if(actividad == '' || actividad == null){
        Swal.fire(
            'Error',
            'Por favor selecciona una actividad',
            'error'
            
        );
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>')
      }
      else{
        $('#usoinfraestructura_administrador_table').dataTable().fnDestroy();
        $('#usoinfraestructura_administrador_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usoinfraestructura/actividades/datatable/"+gestor+"/"+anho+"/"+ actividad,
            
          },
          columns: [{
            data: 'fecha',
            name: 'fecha',
        },  {
            data: 'actividad',
            name: 'actividad',
        }, {
            data: 'fase',
            name: 'fase',
        },
        {
            data: 'asesoria_directa',
            name: 'asesoria_directa',
        }, {
            data: 'asesoria_indirecta',
            name: 'asesoria_indirecta',
        },{
            data: 'detail',
            name: 'detail',
            orderable: false,
        },],  
        });
      }
    },
}

$(document).ready(function() {

  $('#usoinfraestructura_dinamizador_table').DataTable({
      language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
  });
  
});

var usoinfraestructura = {
    ListActividadesPorGestor: function (){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        let actividad = $('#selectActivity').val();

      if(gestor == '' || gestor == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un gestor',
          'error'
        );
      }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un año',
          'error'
        );
      }else if(actividad == '' || actividad == null){
        Swal.fire(
            'Error',
            'Por favor selecciona una actividad',
            'error'
        );
      }
      else{
        $('#usoinfraestructura_dinamizador_table').dataTable().fnDestroy();
        $('#usoinfraestructura_dinamizador_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usoinfraestructura/actividades/datatable/"+gestor+"/"+anho+"/"+ actividad,
            
          },
          columns: [{
            data: 'fecha',
            name: 'fecha',
        },  {
            data: 'actividad',
            name: 'actividad',
        }, {
            data: 'fase',
            name: 'fase',
        },
        {
            data: 'asesoria_directa',
            name: 'asesoria_directa',
        }, {
            data: 'asesoria_indirecta',
            name: 'asesoria_indirecta',
        },{
            data: 'detail',
            name: 'detail',
            orderable: false,
        },],  
        });
  
      }
    },
    queryActivitiesByGestor: function(){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();

        if (gestor == null || gestor == ''){
              
              $('#selectYear').empty();
              $('#selectActivity').empty();
          }
          else if(anho == null || anho == ''){
              $('#selectActivity').empty();
          }else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ gestor + '/' + anho,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                  
                  $('#selectActivity').empty();
                  $('#selectActivity').append('<option value="">Seleccione la Actividad</option>')
                  $.each(data.actividades, function(i, e) {
                    $('#selectActivity').append('<option  value="'+i+'">'+e+'</option>');
                  });
            
                  $('#selectActivity').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }

    }


}


var UsoInfraestructuraGestor = {
    queryActivitiesByGestor: function(gestor){

        let anho = $('#selectYear').val();



        if(anho == null || anho == ''){

            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ gestor + '/' + anho,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {

                  $('#selectActivity').empty();
                  $('#selectActivity').append('<option value="">Seleccione la Actividad</option>');
                  $.each(data.actividades, function(i, e) {
                    $('#selectActivity').append('<option  value="'+i+'">'+e+'</option>');
                  });

                  $('#selectActivity').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }

    },
    ListActividadesPorGestor: function (gestor){
        let anho = $('#selectYear').val();
        let actividad = $('#selectActivity').val();

        if(anho == '' || anho == null){
            Swal.fire(
            'Error',
            'Por favor selecciona un año',
            'error'
            );

            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }else if(actividad == '' || actividad == null){
            Swal.fire(
                'Error',
                'Por favor selecciona una actividad',
                'error'

            );
                $('#selectActivity').empty();
                $('#selectActivity').append('<option value="">Seleccione una Actividad</option>')
        }
      else{
        $('#usoinfraestructura_table').dataTable().fnDestroy();
        $('#usoinfraestructura_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usoinfraestructura/actividades/datatable/"+gestor+"/"+anho+"/"+ actividad,

          },
          columns: [{
            data: 'fecha',
            name: 'fecha',
        },  {
            data: 'actividad',
            name: 'actividad',
        }, {
            data: 'fase',
            name: 'fase',
        },
        {
            data: 'asesoria_directa',
            name: 'asesoria_directa',
        }, {
            data: 'asesoria_indirecta',
            name: 'asesoria_indirecta',
        },{
            data: 'detail',
            name: 'detail',
            orderable: false,
        },],
        });
      }
    },
}


$(document).ready(function() {

    $('#usoinfraestructura_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });



});

var usoinfraestructuraIndex = {
    selectProyectListDatatables: function (){
        let proyecto = $('#selecProyecto').val();
        $('#usoinfraestructura_table').dataTable().fnDestroy();
        if (proyecto != '') {
            $('#usoinfraestructura_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                ajax: {
                    url: "/usoinfraestructura/projectsforuser/" + proyecto,
                    type: "get",
                },
                columns: [{
                            data: 'fecha',
                            name: 'fecha',
                        },  {
                            data: 'actividad',
                            name: 'actividad',
                        }, {
                            data: 'fase',
                            name: 'fase',
                        },
                        {
                            data: 'asesoria_directa',
                            name: 'asesoria_directa',
                        }, {
                            data: 'asesoria_indirecta',
                            name: 'asesoria_indirecta',
                        },{
                            data: 'detail',
                            name: 'detail',
                            orderable: false,
                        },],
                });
            }else{
                $('#usoinfraestructura_table').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "lengthChange": false
                }).clear().draw();
            }
        },
        destroyUsoInfraestructura: function(id){

            Swal.fire({
                title: '¿Estas seguro de eliminar este uso de infraestructura?',
                text: "Recuerde que si lo elimina no lo podrá recuperar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'si, elminar uso',
                cancelButtonText: 'No, cancelar',
              }).then((result) => {
                if (result.value) {
                    let token = $("meta[name='csrf-token']").attr("content");
                    $.ajax(
                    {
                        url: "/usoinfraestructura/"+id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (data){
                            if(data.usoinfraestructura == 'success'){
                                Swal.fire(
                                    'Eliminado!',
                                    'Su uso de infraestructura ha sido eliminado satisfactoriamente.',
                                    'success'
                                  );
                                location.href = data.route;
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            alert("Error: " + errorThrown);
                        }
                    });

                }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'Tu uso de infraestructura está a salvo',
                        'error'
                      )
                  }
              })
        }
}

function datatableVisitantesPorNodo_Ingreso() {
  $('#visitantesRedTecnoparque_table').dataTable().fnDestroy();
  $('#visitantesRedTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/visitante/consultarVisitantesRedTecnoparque",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'documento',
        name: 'documento',
      },
      {
        data: 'tipo_documento',
        name: 'tipo_documento',
      },
      {
        data: 'tipo_visitante',
        name: 'tipo_visitante',
      },
      {
        data: 'visitante',
        name: 'visitante',
      },
      {
        data: 'email',
        name: 'email',
      },
      {
        data: 'contacto',
        name: 'contacto'
      },
      {
        width: '8%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
}

function datatableVisitantesPorNodo_DinamizadorAdministrador() {
  $('#visitantesRedTecnoparque_table').dataTable().fnDestroy();
  $('#visitantesRedTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/visitante/consultarVisitantesRedTecnoparque",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'documento',
        name: 'documento',
      },
      {
        data: 'tipo_documento',
        name: 'tipo_documento',
      },
      {
        data: 'tipo_visitante',
        name: 'tipo_visitante',
      },
      {
        data: 'visitante',
        name: 'visitante',
      },
      {
        data: 'email',
        name: 'email',
      },
      {
        data: 'contacto',
        name: 'contacto'
      },
    ],
  });
}

// var JavaScriptObfuscator = require('javascript-obfuscator');
// var obfuscationResult = JavaScriptObfuscator.obfuscate(
//   (function consultarIngresosDeUnNodo(id) {
//       $('#ingresosDeUnNodo_table').dataTable().fnDestroy();
//       $('#ingresosDeUnNodo_table').DataTable({
//         language: {
//           "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
//         },
//         processing: true,
//         serverSide: true,
//         order: [ 0, 'desc' ],
//         ajax:{
//           url: "/ingreso/consultarIngresosDeUnNodoTecnoparque/"+id,
//           type: "get",
//         },
//         columns: [
//           {
//             width: '15%',
//             data: 'fecha_ingreso',
//             name: 'fecha_ingreso',
//           },
//           {
//             width: '15%',
//             data: 'hora_salida',
//             name: 'hora_salida',
//           },
//           {
//             data: 'visitante',
//             name: 'visitante',
//           },
//           {
//             data: 'servicio',
//             name: 'servicio'
//           },
//           {
//             data: 'descripcion',
//             name: 'descripcion'
//           },
//           {
//             width: '8%',
//             data: 'details',
//             name: 'details',
//             orderable: false
//           },
//           {
//             width: '8%',
//             data: 'edit',
//             name: 'edit',
//             orderable: false
//           },
//         ],
//       });
//     })(),{}
// );
function consultarIngresosDeUnNodo(id) {
  $('#ingresosDeUnNodo_table').dataTable().fnDestroy();
  $('#ingresosDeUnNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/ingreso/consultarIngresosDeUnNodoTecnoparque/"+id,
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'fecha_ingreso',
        name: 'fecha_ingreso',
      },
      {
        width: '15%',
        data: 'hora_salida',
        name: 'hora_salida',
      },
      {
        data: 'visitante',
        name: 'visitante',
      },
      {
        data: 'servicio',
        name: 'servicio'
      },
      {
        data: 'descripcion',
        name: 'descripcion'
      },
      // {
      //   width: '8%',
      //   data: 'details',
      //   name: 'details',
      //   orderable: false
      // },
      {
        width: '8%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
}

// var _0xb196=['servicio','descripcion','details','edit','log','Hello\x20World!','dataTable','fnDestroy','#ingresosDeUnNodo_table','DataTable','desc','/ingreso/consultarIngresosDeUnNodoTecnoparque/','15%','fecha_ingreso','hora_salida','visitante'];(function(_0x239bcc,_0xfc3fc5){var _0x78714b=function(_0x9b5eeb){while(--_0x9b5eeb){_0x239bcc['push'](_0x239bcc['shift']());}};_0x78714b(++_0xfc3fc5);}(_0xb196,0x114));var _0x3ac4=function(_0x3532ff,_0x21a970){_0x3532ff=_0x3532ff-0x0;var _0xbac0fa=_0xb196[_0x3532ff];return _0xbac0fa;};function hi(){console[_0x3ac4('0x0')](_0x3ac4('0x1'));}function consultarIngresosDeUnNodo(_0x2984c9){$('#ingresosDeUnNodo_table')[_0x3ac4('0x2')]()[_0x3ac4('0x3')]();$(_0x3ac4('0x4'))[_0x3ac4('0x5')]({'language':{'url':'//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'},'processing':!![],'serverSide':!![],'order':[0x0,_0x3ac4('0x6')],'ajax':{'url':_0x3ac4('0x7')+_0x2984c9,'type':'get'},'columns':[{'width':_0x3ac4('0x8'),'data':_0x3ac4('0x9'),'name':_0x3ac4('0x9')},{'width':_0x3ac4('0x8'),'data':_0x3ac4('0xa'),'name':_0x3ac4('0xa')},{'data':_0x3ac4('0xb'),'name':_0x3ac4('0xb')},{'data':_0x3ac4('0xc'),'name':'servicio'},{'data':_0x3ac4('0xd'),'name':_0x3ac4('0xd')},{'width':'8%','data':_0x3ac4('0xe'),'name':'details','orderable':![]},{'width':'8%','data':_0x3ac4('0xf'),'name':_0x3ac4('0xf'),'orderable':![]}]});}hi();

function consultarVisitanteTecnoparque() {
  let doc = $('#txtdocumento').val();
  if (doc == "") {
    Swal.fire({
      title: 'Advertencia!',
      text: "Digite un número de documento!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    })
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url : '/visitante/consultarVisitantePorDocumento/'+doc,
      success: function (response) {
        if (response.visitante == null) {
          divVisitanteRegistrado.hide();
          divRegistrarVisitante.show();
        } else {
          $('#nombrePersona').val(response.visitante.visitante);
          $('#tipoPersona').val(response.visitante.tipovisitante);
          $('#contactoReg').val(response.visitante.contacto);
          $('#correoReg').val(response.visitante.email);
          divRegistrarVisitante.hide();
          divVisitanteRegistrado.show();
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    })
  }
}

function consultarDetallesDeUnaCharlaInformativa(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/charla/consultarDetallesDeUnaCharlaInformativa/'+id,
    success: function (data) {
      $("#modalDetalleDeUnaCharlaInformativa_titulo").empty();
      $("#modalDetalleDeUnaCharlaInformativa_detalle_charla").empty();
      $("#modalDetalleDeUnaCharlaInformativa_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Charla Informativa </span><br>");
      $("#modalDetalleDeUnaCharlaInformativa_detalle_charla").append("<div class='row'>"
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.codigo_charla+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.fecha+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Encargado de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.encargado+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Número de Asistentens: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.nro_asistentes+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Observaciones: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.observacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<h5 class="center">Evidencias</h5>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Programación de la Charla (Pantallazo del Envío de Correos): </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.programacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Evidencias Fotográficas: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.evidencia_fotografica+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Listado de Asistencia: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.listado_asistentes+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
    );
    $('#detalleDeUnaCharlaInformativa_modal').openModal();
  },
  error: function (xhr, textStatus, errorThrown) {
    alert("Error: " + errorThrown);
  }
})
}

$(document).ready(function(){});
var ano = (new Date).getFullYear();

var graficosId = {
  grafico1: 'graficoArticulacionesPorGestorYNodoPorFecha_stacked',
  grafico2: 'graficoArticulacionesPorGestorYFecha_stacked',
  grafico3: 'graficoArticulacionesPorLineaYFecha_stacked',
  grafico4: 'graficoArticulacionesPorNodoYAnho_variablepie'
};

var graficosEdtId = {
  grafico1: 'graficosEdtsPorGestorNodoYFecha_stacked',
  grafico2: 'graficosEdtsPorGestorYFecha_stacked',
  grafico3: 'graficoEdtsPorLineaYFecha_stacked',
  grafico4: 'graficoEdtsPorNodoYAnho_variablepie'
};

var graficosProyectoId = {
  grafico1: 'graficosProyectoPorMesYNodo_combinate',
  grafico2: 'graficosProyectoConEmpresaPorMesYNodo_combinate',
  grafico3: 'graficoProyectosPorTipoNodoYFecha_column',
  grafico4: 'graficoProyectosFinalizadosPorNodoYAnho_column',
  grafico5: 'graficoProyectosFinalizadosPorTipoNodoYFecha_column'
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
}

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un gestor(a)', 'warning');
}

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una Línea Tecnológica', 'warning');
}

function alertaFechasNoValidas() {
  Swal.fire('Advertencia!', 'Seleccione fechas válidas!', 'warning');
}

function generarExcelGrafico3Edt(bandera) {
  let idnodo = 0;
  let idlinea = $('#txtlinea_id_edtGrafico3').val();
  let fecha_inicio = $('#txtfecha_inicio_GraficoEdt3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoEdt3').val();

  if ( bandera == 1 ) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    alertaNodoNoValido();
  } else {
    if ( idlinea === '' ) {
      alertaLineaNoValido();
    } else {
      location.href = '/excel/excelEdtsFinalizadasPorLineaNodoYFecha/'+idnodo+'/'+idlinea+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }

}

function generarExcelGrafico2Edt(bandera) {
  let id = 0;

  if (bandera == 0) {
    id = $('#txtgestor_id_edtGrafico2').val();
  }

  let fecha_inicio = $('#txtfecha_inicio_edtGrafico2').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico2').val();

  if (id === '') {
    alertaGestorNoValido();
  } else {
    location.href = '/excel/excelEdtsFinalizadasPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico1Edt(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico1').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelEdtsFinalizadasPorFechaYNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}


function generarExcelGrafico1Articulacion(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorFechaYNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico3Articulacion(bandera) {
  let id = 0;
  let linea = $('#txtlinea_tecnologica').val();
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    if (linea === '') {
      alertaLineaNoValido();
    } else {
      location.href = '/excel/excelArticulacionFinalizadasPorFechaNodoYLinea/'+id+'/'+linea+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }

}

function generarExcelGrafico2Articulacion() {
  let id = $('#txtgestor_id').val();
  let fecha_inicio = $('#txtfecha_inicio_Grafico2').val();
  let fecha_fin = $('#txtfecha_fin_Grafico2').val();

  if (id === '') {
    alertaGestorNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico4Articulacion(bandera) {
  let id = 0;
  let anho = $('#txtanho_Grafico4').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorNodoYAnho/'+id+'/'+anho;
  }

}

function generarExcelGrafico1Proyecto(bandera) {
  let id = 0;
  let anho = $('#txtanho_GraficoProyecto1').val();
  if (bandera == 1) {
    id = $('#txtnodo_excelGrafico1Proyecto').val();
  }
  location.href = '/excel/excelProyectosInscritosPorAnho/'+id+'/'+anho
}

function generarExcelGrafico2Proyecto(bandera) {
  let id = 0;
  let anho = $('#txtanho_GraficoProyecto2').val();
  if (bandera == 1) {
    id = $('#txtnodo_excelGrafico2Proyecto').val();
  }
  location.href = '/excel/excelProyectosInscritosConEmpresasPorAnho/'+id+'/'+anho
}

function graficosProyectosPromedioCantidadesMeses(data, name) {
  let tamanho = data.proyectos.cantidades.length;
  let datos = {
    cantidades: [],
    meses: [],
    promedios: []
  };
  for (let i = 0; i < tamanho; i++) {
    datos.cantidades.push(data.proyectos.cantidades[i]);
  }
  for (let i = 0; i < tamanho; i++) {
    datos.meses.push(data.proyectos.meses[i]);
  }
  for (let i = 0; i < tamanho; i++) {
    datos.promedios.push(data.proyectos.promedios[i]);
  }
  Highcharts.chart(name, {
    title: {
      text: 'Proyectos Inscritos'
    },
    yAxis: {
      title: {
        text: 'Cantidad/Promedio'
      }
    },
    xAxis: {
      categories: datos.meses,
      title: {
        text: 'Meses'
      }
    },
    series: [{
      type: 'column',
      name: 'Proyectos Inscritos',
      data: datos.cantidades
    }, {
      type: 'spline',
      name: 'Proyectos Inscritos',
      data: datos.cantidades,
      dataLabels: {
        enabled: true
      },
      marker: {
        lineWidth: 2,
        lineColor: '#008981',
        fillColor: '#008981'
      }
    }]
  });
}

function graficosProyectosAgrupados(data, name, name_label) {
  let tamanho = data.proyectos.cantidades.length;
  let datos = {
    cantidades: [],
    labels: [],
  };
  for (let i = 0; i < tamanho; i++) {
    datos.cantidades.push(data.proyectos.cantidades[i]);
  }

  for (let i = 0; i < tamanho; i++) {
    datos.labels.push(data.proyectos.labels[i]);
  }

  Highcharts.chart(name, {
    title: {
      text: 'Proyectos Inscritos'
    },
    yAxis: {
      title: {
        text: 'Cantidad'
      }
    },
    xAxis: {
      categories: datos.labels,
      title: {
        text: name_label
      }
    },
    series: [{
      type: 'column',
      name: 'Proyectos Inscritos',
      data: datos.cantidades
    }, {
      type: 'spline',
      name: 'Proyectos Inscritos',
      data: datos.cantidades,
      dataLabels: {
        enabled: true
      },
      marker: {
        lineWidth: 2,
        lineColor: '#008981',
        fillColor: '#008981'
      }
    }]
  });
}

function consultarProyectosFinalizadosPorTipoNodoYFecha_column(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_GraficoProyecto5').val();
  let fecha_fin = $('#txtfecha_fin_GraficoProyecto5').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if ( fecha_inicio > fecha_fin ) {
    alertaFechasNoValidas();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/grafico/consultarProyectosFinalizadosPorTipoNodoYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
      success: function (data) {
        graficosProyectosAgrupados(data, graficosProyectoId.grafico5, 'Tipo de Proyecto');
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function consultarProyectosInscritosPorTipoNodoYFecha_column(bandera) {

  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_GraficoProyecto3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoProyecto3').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/grafico/consultarProyectosInscritosPorTipoNodoYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      graficosProyectosAgrupados(data, graficosProyectoId.grafico3, 'Tipo de Proyecto');
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })

}


function consultarProyectosFinalizadosPorAnho_combinate(bandera) {
  id = 0;
  let anho = $('#txtanho_GraficoProyecto4').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/grafico/consultarProyectosFinalzadosPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico4);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosConEmpresasPorAnho_combinate(bandera, anho) {
  id = 0;
  if (bandera == 1) {
    id = $('#txtnodo_proyectoGrafico1');
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/grafico/consultarProyectosInscritosConEmpresasPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico2);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosPorAnho_combinate(bandera, anho) {
  id = 0;
  if (bandera == 1) {
    id = $('#txtnodo_proyectoGrafico1');
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/grafico/consultarProyectosInscritosPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico1);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarEdtsDelNodoPorAnho_variablepie(bandera) {
  let anho = $('#txtanho_GraficoEdt4').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/grafico/consultarEdtsPorNodoYAnho/'+idnodo+'/'+anho,
      success: function (data) {
        Highcharts.chart(graficosEdtId.grafico4, {
          chart: {
            type: 'variablepie'
          },
          title: {
            text: 'Tipos de Edt\'s.'
          },
          plotOptions: {
            variablepie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                connectorColor: 'silver'
              }
            }
          },
          tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad: <b>{point.y}</b><br/>'
          },
          series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: '',
            data: [
              { name: 'Tipo 1', y: data.consulta.tipo1, z: 15 },
              { name: 'Tipo 2', y: data.consulta.tipo2, z: 15 },
              { name: 'Tipo 3', y: data.consulta.tipo3, z: 15 }
            ]
          }]
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })

  }
}

function consultarEdtsPorLineaYFecha_stacked(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  let fecha_inicio = $('#txtfecha_inicio_GraficoEdt3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoEdt3').val();
  let id = $('#txtlinea_id_edtGrafico3').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona una Línea Tecnológica!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/grafico/consultarEdtsPorLineaYFecha/'+id+'/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          // console.log(data);
          Highcharts.chart(graficosEdtId.grafico3, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Tipos de Edt\'s'
            },
            xAxis: {
              categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
              title: {
                text: 'Tipos de Edt\'s'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Edt\'s'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.lineatecnologica, data: [data.consulta.tipo1, data.consulta.tipo2, data.consulta.tipo3]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

function consultarEdtsPorGestorYFecha_stacked(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico2').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico2').val();
  let id = $('#txtgestor_id_edtGrafico2').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona un Gestor!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/grafico/consultarEdtsPorGestorYFecha/'+id+'/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          // console.log(data);
          Highcharts.chart(graficosEdtId.grafico2, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Tipos de Edt\'s'
            },
            xAxis: {
              categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
              title: {
                text: 'Tipos de Edt\'s'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Edt\'s'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.gestor, data: [data.consulta.tipo1, data.consulta.tipo2, data.consulta.tipo3]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

function consultarEdtsPorNodoGestorYFecha_stacked(bandera) {
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico1').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico1').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (fecha_inicio > fecha_fin) {
    Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/grafico/consultarEdtsPorNodoGestorYFecha/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
      success: function (data) {
        var tamanho = data.consulta.length;
        // console.log(tamanho);
        var datos = {
          gestores: [],
          tipo1Array: [],
          tipo2Array: [],
          tipo3Array: []
        };
        // console.log(data.tipos);
        for (var i = 0; i < tamanho; i++) {
          // console.log(data.consulta[i].gestor);
          if (data.consulta[i].gestor != null) {
            datos.gestores.push(data.consulta[i].gestor);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos1 != null) {
            datos.tipo1Array.push(data.consulta[i].tipos1);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos2 != null) {
            datos.tipo2Array.push(data.consulta[i].tipos2);
          }
        }
        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos3 != null) {
            datos.tipo3Array.push(data.consulta[i].tipos3);
          }
        }

        var dataGraphic = [];

        for (var i = 0; i < tamanho; i++) {
          let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.tipo1Array[i]+', '+datos.tipo2Array[i]+', '+datos.tipo3Array[i]+']}';
          array = JSON.parse(array);
          dataGraphic.push(array);
        }
        Highcharts.chart(graficosEdtId.grafico1, {
          chart: {
            type: 'column'
            // renderTo: ''
          },
          title: {
            text: 'Edt\'s entre ' + fecha_inicio + ' y ' + fecha_fin
          },
          xAxis: {
            categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
            title: {
              text: 'Tipos de Edt\'s'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Número de Edts\'s'
            }
          },
          legend: {
            reversed: true
          },
          plotOptions: {
            series: {
              stacking: 'normal'
            }
          },
          series: dataGraphic
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    });
  }
}


function consultarTiposDeArticulacionesDelAnho_variablepie(bandera) {
  let anho = $('#txtanho_Grafico4').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/grafico/consultarArticulacionesPorNodoYAnho/'+idnodo+'/'+anho,
      success: function (data) {
        Highcharts.chart(graficosId.grafico4, {
          chart: {
            type: 'variablepie'
          },
          title: {
            text: 'Tipos de Articulación.'
          },
          plotOptions: {
            variablepie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                connectorColor: 'silver'
              }
            }
          },
          tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad: <b>{point.y}</b><br/>'
            // 'Population density (people per square km): <b>{point.z}</b><br/>'
          },
          series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: '',
            data: [
              { name: 'Grupos de Investigación', y: data.consulta.grupos, z: 15 },
              { name: 'Empresas', y: data.consulta.empresas, z: 15 },
              { name: 'Emprendedores', y: data.consulta.emprendedores, z: 15 }
            ]
          }]
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })

  }
}

function articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/grafico/consultarArticulacionesPorNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      var tamanho = data.consulta.length;
      // console.log(tamanho);
      var datos = {
        gestores: [],
        gruposArray: [],
        empresasArray: [],
        emprendedoresArray: []
      };
      // console.log(data.tipos);
      for (var i = 0; i < tamanho; i++) {
        // console.log(data.consulta[i].gestor);
        if (data.consulta[i].gestor != null) {
          datos.gestores.push(data.consulta[i].gestor);
        }
      }

      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].grupos != null) {
          datos.gruposArray.push(data.consulta[i].grupos);
        }
      }

      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].empresas != null) {
          datos.empresasArray.push(data.consulta[i].empresas);
        }
      }
      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].emprendedores != null) {
          datos.emprendedoresArray.push(data.consulta[i].emprendedores);
        }
      }

      var dataGraphic = [];

      for (var i = 0; i < tamanho; i++) {
        let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.gruposArray[i]+', '+datos.empresasArray[i]+', '+datos.emprendedoresArray[i]+']}';
        array = JSON.parse(array);
        dataGraphic.push(array);
      }
      Highcharts.chart(graficosId.grafico1, {
        chart: {
          type: 'column'
          // renderTo: ''
        },
        title: {
          text: 'Articulaciones entre ' + fecha_inicio + ' y ' + fecha_fin
        },
        xAxis: {
          categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
          title: {
            text: 'Tipos de Articulaciones'
          }
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Número de Articulaciones'
          }
        },
        legend: {
          reversed: true
        },
        plotOptions: {
          series: {
            stacking: 'normal'
          }
        },
        series: dataGraphic
      });
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  });
}

function consultaArticulacionesDelGestorPorNodoYFecha_stacked(id) {
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();
  articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin);
}

function consultaArticulacionesDelGestorPorNodoYFecha_stackedAdministrador() {
  let id = $('#txtnodo_id').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Seleccione un Nodo!', 'warning');
  } else {
    let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
    let fecha_fin = $('#txtfecha_fin_Grafico1').val();
    articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin);
  }
}

function consultarArticulacionesDeUnGestorPorFecha_stacked() {
  let fecha_inicio = $('#txtfecha_inicio_Grafico2').val();
  let fecha_fin = $('#txtfecha_fin_Grafico2').val();
  let id = $('#txtgestor_id').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona un Gestor!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/grafico/consultarArticulacionesPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          // console.log(data);
          Highcharts.chart(graficosId.grafico2, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones'
            },
            xAxis: {
              categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
              title: {
                text: 'Tipos de Articulaciones'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Articulaciones'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.gestor, data: [data.consulta.grupos, data.consulta.empresas, data.consulta.emprendedores]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

/**
* Consulta la cantidad de arituclaciones por tipo según la línea tecnológica de un nodo y parametrizado entre fechas (estas fecha son de cierre)
*/
function consultarArticulacionesDeUnaLineaDelNodoPorFechas_stacked(bandera) {
  let idnodo = "";
  if (bandera == 0) {
    idnodo = 0;
  } else {
    idnodo = $('#txtnodo_id').val();
  }
  let id = $('#txtlinea_tecnologica').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona una Línea Tecnológica!', 'warning')
  } else {
    let fecha_inicio = $('#txtfecha_inicio_Grafico3').val();
    let fecha_fin = $('#txtfecha_fin_Grafico3').val();
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Debes seleccionar fecha válidas!', 'warning')
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/grafico/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/'+idnodo+'/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
        success: function (data) {
          Highcharts.chart(graficosId.grafico3, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones'
            },
            xAxis: {
              categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
              title: {
                text: 'Tipos de Articulaciones'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Articulaciones'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.lineatecnologica, data: [data.consulta.grupos, data.consulta.empresas, data.consulta.emprendedores]}]
          });
        }
      })
    }
  }
}

var graficosSeguimiento = {
  gestor: 'graficoSeguimientoPorGestorDeUnNodo_column',
  nodo: 'graficoSeguimientoDeUnNodo_column',
  nodo_fases: 'graficoSeguimientoDeUnNodoFases_column',
  gestor_fases: 'graficoSeguimientoPorGestorFases_column'
};

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una Línea Tecnológica', 'warning');
};

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un Gestor', 'warning');
};

function alertaFechasNoValidas() {
  Swal.fire('Advertencia!', 'Seleccione fechas válidas', 'warning');
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
};
// 0 para cuando el Dinamizador consultar
// 1 para cuando el gestor consulta

function consultarSeguimientoDeUnGestor(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Gestor').val();
  let fecha_fin = $('#txtfecha_fin_Gestor').val();

  if ( bandera == 1 ) {
    id = $('#txtgestor_id').val();
  }

  if ( id === "" ) {
    alertaGestorNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/seguimiento/seguimientoDeUnGestor/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          graficoSeguimiento(data, graficosSeguimiento.gestor);
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      })
    }
  }
};

function consultarSeguimientoDeUnGestorFase(bandera) {
  let id = 0;

  if ( bandera == 1 ) {
    id = $('#txtgestor_id_actual').val();
  }

  if ( id === "" ) {
    alertaGestorNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoDeUnGestorFases/'+id,
      success: function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.gestor_fases);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Administrador consulta

function consultarSeguimientoDeUnNodo(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Nodo').val();
  let fecha_fin = $('#txtfecha_fin_Nodo').val();

  if ( bandera == 1 ) {
    id = $('#txtnodo_id').val();
  }

  if ( id === "" ) {
    alertaNodoNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/seguimiento/seguimientoDeUnNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          graficoSeguimiento(data, graficosSeguimiento.nodo);
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      })
    }
  }
};

function consultarSeguimientoDeUnNodoFases(bandera) {
  let id = 0;

  if ( bandera == 1 ) {
    id = $('#txtnodo_id').val();
  }

  if ( id === "" ) {
    alertaNodoNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoDeUnNodoFases/'+id,
      success: function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Administrador consulta
function generarExcelSeguimentoNodo(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Nodo').val();
  let fecha_fin = $('#txtfecha_fin_Nodo').val();

  if ( bandera == 1 ) {
    id = $('#txtnodo_id').val();
  }

  if ( id === "" ) {
    alertaNodoNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      location.href = '/excel/excelSeguimientoDeUnNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }
}

// 0 para cuando el Dinamizador consultar
// 1 para cuando el Gestor consulta
function generarExcelSeguimentoDeUnGestor(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Gestor').val();
  let fecha_fin = $('#txtfecha_fin_Gestor').val();

  if ( bandera == 1 ) {
    id = $('#txtgestor_id').val();
  }

  if ( id === "" ) {
    alertaGestorNoValido();
  } else {
    if ( fecha_inicio > fecha_fin ) {
      alertaFechasNoValidas();
    } else {
      location.href = '/excel/excelSeguimientoDeUnGestor/'+id+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }
}

function graficoSeguimiento(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Seguimiento'
    },
    yAxis: {
      title: {
        text: 'Cantidad'
      }
    },
    xAxis: {
        type: 'category'
    },
    legend: {
        enabled: false
    },
    tooltip: {
      headerFormat: '<span style="font-size:11px">Cantidad</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },
    series: [
      {
        colorByPoint: true,
        dataLabels: {
          enabled: true
        },
        data: [
          {
            name: "Proyectos Inscritos",
            y: data.datos.Inscritos,
          },
          {
            name: "TRL 6 esperados",
            y: data.datos.Esperado6,
          },
          {
            name: "TRL 7 - 8 esperados",
            y: data.datos.Esperado7_8,
          },
          {
            name: "Proyectos Cerrados",
            y: data.datos.Cerrados,
          },
          {
            name: "TRL 6 obtenidos",
            y: data.datos.Obtenido6,
          },
          {
            name: "TRL 7 obtenidos",
            y: data.datos.Obtenido7_8,
          },
          {
            name: "TRL 8 obtenidos",
            y: data.datos.Obtenido8,
          },
          {
            name: "Articulaciones con G.I Inscritas",
            y: data.datos.ArticulacionesInscritas,
          },
          {
            name: "Articulaciones con G.I Cerradas",
            y: data.datos.ArticulacionesCerradas,
          },
        ]
      }
    ],
  });
}

function graficoSeguimientoFases(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Seguimiento (Fases)'
    },
    yAxis: {
      title: {
        text: 'Cantidad'
      }
    },
    xAxis: {
        type: 'category'
    },
    legend: {
        enabled: false
    },
    tooltip: {
      headerFormat: '<span style="font-size:11px">Cantidad</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },
    series: [
      {
        colorByPoint: true,
        dataLabels: {
          enabled: true
        },
        data: [
          {
            name: "Proyectos en Inicio",
            y: data.datos.ProyectosInicio,
          },
          {
            name: "Proyectos en Planeación",
            y: data.datos.ProyectosPlaneacion,
          },
          {
            name: "Proyectos en Ejecución",
            y: data.datos.ProyectosEjecucion,
          },
          {
            name: "Proyectos en Cierre",
            y: data.datos.ProyectosCierre,
          },
          {
            name: "Articulaciones en Inicio",
            y: data.datos.ArticulacionesInicio,
          },
          {
            name: "Articulaciones en Planeación",
            y: data.datos.ArticulacionesPlaneacion,
          },
          {
            name: "Articulaciones en Ejecución",
            y: data.datos.ArticulacionesEjecucion,
          },
          {
            name: "Articulaciones en Cierre",
            y: data.datos.ArticulacionesCierre,
          },
        ]
      }
    ],
  });
}

var graficosCostos = {
  actividad: 'costosDeUnProyecto_column',
  proyectos: 'costosDeProyectos_column',
  proyectos_ipe: 'costosDeProyectos_ipe_column'
};

  function setValueInput(data, chart) {
  $('#txtcosto_asesorias' + chart).val(formatMoney(data.costosAsesorias));
  $("label[for='txtcosto_asesorias"+chart+"']").addClass("active", true);
  $('#txtcostos_equipos' + chart).val(formatMoney(data.costosEquipos));
  $("label[for='txtcostos_equipos"+chart+"']").addClass("active", true);
  $('#txtcostos_materiales' + chart).val(formatMoney(data.costosMateriales));
  $("label[for='txtcostos_materiales"+chart+"']").addClass("active", true);
  $('#txtcostos_administrativos' + chart).val(formatMoney(data.costosAdministrativos));
  $("label[for='txtcostos_administrativos"+chart+"']").addClass("active", true);
  $('#txtcosto_total' + chart).val(formatMoney(data.costosTotales));
  $("label[for='txtcosto_total"+chart+"']").addClass("active", true);
  $('#txthoras_asesoria' + chart).val(data.horasAsesorias);
  $("label[for='txthoras_asesoria"+chart+"']").addClass("active", true);
  $('#txthoras_uso' + chart).val(data.horasEquipos);
  $("label[for='txthoras_uso"+chart+"']").addClass("active", true);
}

function consultarCostosDeProyectos(bandera, tipo) {
  let idnodo = 0;
  let tipos = [];
  let estado;
  let fecha_inicio;
  let fecha_fin;
  // let estado = $("input[name='estado']:checked").val();
  // let fecha_inicio = $('#txtfecha_inicio_costosProyectos').val();
  // let fecha_fin = $('#txtfecha_fin_costosProyectos').val();
  let chart = '';

  if (tipo == 1) {
    chart = '_proyectos';
    estado = $("input[name='estado']:checked").val();
    fecha_inicio = $('#txtfecha_inicio_costosProyectos').val();
    fecha_fin = $('#txtfecha_fin_costosProyectos').val();
    $("input[name='tipoProyecto[]']:checked").each(function (index, obj) {
      tipos.push($(this).val());
    });
  } else {
    chart = '_proyectos_ipe';
    estado = $("input[name='estado_ipe']:checked").val();
    fecha_inicio = $('#txtfecha_inicio_costosProyectos_ipe').val();
    fecha_fin = $('#txtfecha_fin_costosProyectos_ipe').val();
    $("input[name='tipoProyecto_ipe[]']:checked").each(function (index, obj) {
      tipos.push($(this).val());
    });
  }

  // En caso de que sea el Administrador el que consulta los costos
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  // $("input[name='tipoProyecto[]']:checked").each(function (index, obj) {
  //   tipos.push($(this).val());
  // });

  // console.log(tipos);

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    if (tipos.length == 0) {
      Swal.fire('Advertencia!', 'Seleccione por lo menos un tipo de proyecto', 'warning');
    } else {
      if (estado == null) {
        Swal.fire('Advertencia!', 'Seleccione un estado de proyecto', 'warning');
      } else {
        if (fecha_inicio > fecha_fin) {
          Swal.fire('Advertencia!', 'Seleccione fecha válidas', 'warning');
        } else {
          let tiposArr = JSON.stringify(tipos);
          $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/costos/costosDeProyectos/'+idnodo+'/'+tiposArr+'/'+estado+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo,
            success: function (data) {
              setValueInput(data, chart);
              graficoCostos(data, tipo == 1 ? graficosCostos.proyectos : graficosCostos.proyectos_ipe, 'Proyectos');
            },
            error: function (xhr, textStatus, errorThrown) {
              alert("Error: " + errorThrown);
            },
          })
        }
      }
    }
  }
}

function consultarCostoDeUnaActividad() {
  let id = $('#txtactividad_id').val();
  if (id === '') {
    Swal.fire('Advertencia!', 'Seleccione una actividad', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/costos/costosDeUnaActividad/'+id,
      success: function (data) {
        let chart = '_actividad';
        setValueInput(data, chart);
        $('#txtgestor' + chart).val(data.gestorActividad);
        $("label[for='txtgestor"+chart+"']").addClass("active", true);
        $('#txtlinea' + chart).val(data.lineaActividad);
        $("label[for='txtlinea"+chart+"']").addClass("active", true);
        graficoCostos(data, graficosCostos.actividad, data.codigoActividad);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function graficoCostos(data, name, title) {
  Highcharts.chart(name, {
    exporting: {
      allowHTML: true,
      chartOptions: {
        chart: {
          height: 600,
          marginTop: 110,
          events: {
            load: function() {
              this.renderer.image('http://drive.google.com/uc?export=view&id=1qLb9tjGI1hEnmEzQ6mPzxqv1zjMtxdMw', 80, 20, 200, 47).add();
              this.renderer.image('http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C', 290, 20, 200, 47).add();
              this.update({
                credits: {
                  text: 'Generado: ' + Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', Date.now())
                }
              });
            }
          }
        },
        legend: {
          y: -220
        },
        title: {
          align: 'center',
          y: 90
        },

      }
    },
    chart: {
      type: 'column',
    },
    title: {
      text: 'Costos - ' + title
    },
    yAxis: {
      title: {
        text: '$ Pesos'
      },
      labels: {
        format: '$ {value}'
      }
    },
    xAxis: {
        type: 'category'
    },
    legend: {
        enabled: false,
        floating: true,
    },
    tooltip: {
      headerFormat: '<span style="font-size:11px">Costos</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y}</b><br/>'
    },
    plotOptions: {
      series: {
        dataLabels: {
          enabled: true
        },
        animationLimit: 1000
      },
    },
    series: [
      {
        colorByPoint: true,
        data: [
          {
            name: "Costos de Asesorias",
            y: data.costosAsesorias,
          },
          {
            name: "Costos de Equipos",
            y: data.costosEquipos,
          },
          {
            name: "Costos de Materiales",
            y: data.costosMateriales,
          },
          {
            name: "Costos Administrativos",
            y: data.costosAdministrativos,
          },
          {
            name: "Total de Costos",
            y: data.costosTotales,
          },
        ]
      }
    ],
  });
}

function setValueInput_indicadores(data, name_input) {
  $('#'+name_input).val(data);
  $("label[for='"+name_input+"']").addClass("active", true);
}

function setIdNodo_Indicadores(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  return idnodo;
}

function ajaxIndicadores_totales(url, name_input) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: url,
    success: function (data) {
      setValueInput_indicadores(data, name_input);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input) {
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      ajaxIndicadores_totales(url, input);
    }
  }
}

function dispararAjax_NoFechas(idnodo, url, input) {
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    ajaxIndicadores_totales(url, input);
  }
}

// Id Indicador 1
function consultarProyectosInscritos_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind1').val();
  let fecha_fin = $('#txtfecha_fin_ind1').val();
  let url = '/indicadores/totalProyectosInscritos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind1';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 2
function consultarProyectosEnEjecucion_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let url = '/indicadores/totalProyectosEnEjecucion/'+idnodo;
  let input = 'txt_total_ind2';
  dispararAjax_NoFechas(idnodo, url, input);
}

// Indicador 3
function consultarPFFfinalizados_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind3').val();
  let fecha_fin = $('#txtfecha_fin_ind3').val();
  let url = '/indicadores/totalPFFfinalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind3';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 4
function consultarProyectosInscritosAprendizInstructor_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind4').val();
  let fecha_fin = $('#txtfecha_fin_ind4').val();
  let url = '/indicadores/totalInscritosSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind4';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 5
function consultarProyectosEnEjecucionConSena_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let url = '/indicadores/totalProyectosEnEjecucionSena/'+idnodo;
  let input = 'txt_total_ind5';
  dispararAjax_NoFechas(idnodo, url, input);
}

// Indicador 6
function consultarProyectosPFFFinalizadosAprendizInstructor_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind6').val();
  let fecha_fin = $('#txtfecha_fin_ind6').val();
  let url = '/indicadores/totalPFFSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind6';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 7
function consultarCostosPFFfinalizadosSena_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind7').val();
  let fecha_fin = $('#txtfecha_fin_ind7').val();
  let url = '/indicadores/totalCostoPFFFinalizadoSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind7';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 8
function consultarProyectosInscritosEmpresas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind8').val();
  let fecha_fin = $('#txtfecha_fin_ind8').val();
  let url = '/indicadores/totalInscritosEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind8';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 9
function consultarProyectosEnEjecucionConEmpresas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let url = '/indicadores/totalProyectosEnEjecucionEmpresas/'+idnodo;
  let input = 'txt_total_ind9';
  dispararAjax_NoFechas(idnodo, url, input);
}

// Indicador 10
function consultarProyectosPFFFinalizadosEmpresas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind10').val();
  let fecha_fin = $('#txtfecha_fin_ind10').val();
  let url = '/indicadores/totalPFFfinalizadosConEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind10';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 11
function consultarCostosPFFfinalizadosEmpresas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind11').val();
  let fecha_fin = $('#txtfecha_fin_ind11').val();
  let url = '/indicadores/totalCostoPFFFinalizadoEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind11';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 12
function consultarTalentoEnAsocioProyectosConEmpresa_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind12').val();
  let fecha_fin = $('#txtfecha_fin_ind12').val();
  let url = '/indicadores/totalTalentosConProyectosEnAsocioConEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind12';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 13
function consultarProyectosInscritosEmprendedoresInvetoresOtros_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind13').val();
  let fecha_fin = $('#txtfecha_fin_ind13').val();
  let url = '/indicadores/totalProyectosInscritosEmprendedoresInvetoresOtro/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind13';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 14
function consultarProyectosEnEjecucionConEmprendedoresInventoresOtros_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let url = '/indicadores/totalProyectosEnEjecucionEmprendedoresInventoresOtros/'+idnodo;
  let input = 'txt_total_ind14';
  dispararAjax_NoFechas(idnodo, url, input);
}

// Indicador 15
function consultarPFFFinalizadosEmprendedoresInvetoresOtros_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind15').val();
  let fecha_fin = $('#txtfecha_fin_ind15').val();
  let url = '/indicadores/totalPFFFinalizadosEmprendedoresInvetoresOtro/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind15';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 16
function consultarCostosPFFfinalizadosEmprendedoresOtros_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind16').val();
  let fecha_fin = $('#txtfecha_fin_ind16').val();
  let url = '/indicadores/totalCostoPFFFinalizadoEmprendedoresOtros/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind16';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 17
function consultarPMVfinalizados_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind17').val();
  let fecha_fin = $('#txtfecha_fin_ind17').val();
  let url = '/indicadores/totalPMVfinalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind17';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 18
function consultarProyectosPMVFinalizadosAprendizInstructor_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind18').val();
  let fecha_fin = $('#txtfecha_fin_ind18').val();
  let url = '/indicadores/totalPMVSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind18';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 19
function consultarCostosPMVfinalizadosSena_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind19').val();
  let fecha_fin = $('#txtfecha_fin_ind19').val();
  let url = '/indicadores/totalCostoPMVFinalizadoSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind19';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 20
function consultarProyectosPMVFinalizadosEmpresas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind20').val();
  let fecha_fin = $('#txtfecha_fin_ind20').val();
  let url = '/indicadores/totalPMVfinalizadosConEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind20';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 21
function consultarCostosPMVfinalizadosEmpresas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind21').val();
  let fecha_fin = $('#txtfecha_fin_ind21').val();
  let url = '/indicadores/totalCostoPMVFinalizadoEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind21';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 22
function consultarPMVFinalizadosEmprendedoresInvetoresOtros_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind22').val();
  let fecha_fin = $('#txtfecha_fin_ind22').val();
  let url = '/indicadores/totalPMVFinalizadosEmprendedoresInvetoresOtro/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind22';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 23
function consultarCostosPMVfinalizadosEmprendedoresOtros_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind23').val();
  let fecha_fin = $('#txtfecha_fin_ind23').val();
  let url = '/indicadores/totalCostoPMVFinalizadoEmprendedoresOtros/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind23';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 24
function consultarProyectoConGruposInternos_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind24').val();
  let fecha_fin = $('#txtfecha_fin_ind24').val();
  let url = '/indicadores/totalProyectoConGruposInternos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind24';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 25
function consultarProyectoConGruposInternosFinalizados_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind25').val();
  let fecha_fin = $('#txtfecha_fin_ind25').val();
  let url = '/indicadores/totalProyectoConGruposInternosFinalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind25';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 26
function consultarProyectoConGruposExternos_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind26').val();
  let fecha_fin = $('#txtfecha_fin_ind26').val();
  let url = '/indicadores/totalProyectoConGruposExternos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind26';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 27
function consultarProyectoConGruposExternosFinalizados_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind27').val();
  let fecha_fin = $('#txtfecha_fin_ind27').val();
  let url = '/indicadores/totalProyectoConGruposExternosFinalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind27';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 28
function consultarTalentosConApoyoYProyectos_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind28').val();
  let fecha_fin = $('#txtfecha_fin_ind28').val();
  let url = '/indicadores/totalTalentosConApoyoYProyectosAsociados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind28';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 29
function consultarTalentosSinApoyoYProyectos_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind29').val();
  let fecha_fin = $('#txtfecha_fin_ind29').val();
  let url = '/indicadores/totalTalentosSinApoyoYProyectosAsociados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind29';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 30
function consultarAsesoriasIDiEmp_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind30').val();
  let fecha_fin = $('#txtfecha_fin_ind30').val();
  let url = '/indicadores/totalAsesoriasIDiEmpresasYEmprendedores/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind30';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 31
function consultarAsesoriasIDiEmpresasEmprendedoresEnEjecucion_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let url = '/indicadores/totalAsesoriasIDiEmpresasEmprendedoresEnEjecucion/'+idnodo;
  let input = 'txt_total_ind31';
  dispararAjax_NoFechas(idnodo, url, input);
  // dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 32
function consultarAsesoriasIDiEmpresasEmprendedoresFinalizadas_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind32').val();
  let fecha_fin = $('#txtfecha_fin_ind32').val();
  let url = '/indicadores/totalAsesoriasIDiEmpresasEmprendedoresFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind32';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 33
function consultarVigilanciaEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Vigilancia Tecnológica.';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind33').val();
  let fecha_fin = $('#txtfecha_fin_ind33').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind33';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 34
function consultarAnalisisEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Análisis de Prospectiva.';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind34').val();
  let fecha_fin = $('#txtfecha_fin_ind34').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind34';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 35
function consultarReestructuracionEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Reestructuración y diseño de planta.';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind35').val();
  let fecha_fin = $('#txtfecha_fin_ind35').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind35';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 36
function consultarEstrategiasPosicionamientoEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Estrategias de creación y posicionamiento de marca.';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind36').val();
  let fecha_fin = $('#txtfecha_fin_ind36').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind36';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 37
function consultarPropiedadIntelectualEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind37').val();
  let fecha_fin = $('#txtfecha_fin_ind37').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind37';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 38
function consultarFormulacionProyectosEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Formular proyectos I+D+i para convocatorias.';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind38').val();
  let fecha_fin = $('#txtfecha_fin_ind38').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind38';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 39
function consultarAsesoriaEmpresasEmprendedoresFinalizadas_total(bandera) {
  let tipo_articulacion_nombre = 'Asesoría a empresa o emprendedor.';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind39').val();
  let fecha_fin = $('#txtfecha_fin_ind39').val();
  let url = '/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo_articulacion_nombre;
  let input = 'txt_total_ind39';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 40
function consultarEdts_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind40').val();
  let fecha_fin = $('#txtfecha_fin_ind40').val();
  let url = '/indicadores/totalEdts/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind40';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 41
function consultarTotalPersonasEnEdts_total(bandera) {
  let campos = 'empleados+instructores+aprendices+publico';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind41').val();
  let fecha_fin = $('#txtfecha_fin_ind41').val();
  let url = '/indicadores/totalAtendidosEnEdts/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+campos;
  let input = 'txt_total_ind41';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 42
function consultarTotalPersonasSenaEnEdts_total(bandera) {
  let campos = 'instructores+aprendices';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind42').val();
  let fecha_fin = $('#txtfecha_fin_ind42').val();
  let url = '/indicadores/totalAtendidosEnEdts/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+campos;
  let input = 'txt_total_ind42';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 43
function consultarTotalPersonasEmpleadosEnEdts_total(bandera) {
  let campos = 'empleados';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind43').val();
  let fecha_fin = $('#txtfecha_fin_ind43').val();
  let url = '/indicadores/totalAtendidosEnEdts/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+campos;
  let input = 'txt_total_ind43';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 44
function consultarTotalPublicoGeneralEnEdts_total(bandera) {
  let campos = 'publico';
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind44').val();
  let fecha_fin = $('#txtfecha_fin_ind44').val();
  let url = '/indicadores/totalAtendidosEnEdts/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+campos;
  let input = 'txt_total_ind44';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 45
function consultarTotalTalentosEnProyecto_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind45').val();
  let fecha_fin = $('#txtfecha_fin_ind45').val();
  let url = '/indicadores/totalTalentosEnProyecto/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind45';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 46
function consultarTotalTalentosSenaEnProyecto_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind46').val();
  let fecha_fin = $('#txtfecha_fin_ind46').val();
  let url = '/indicadores/totalTalentosSenaEnProyecto/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind46';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 47
function consultarTotalTalentosMujerSenaEnProyecto_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind47').val();
  let fecha_fin = $('#txtfecha_fin_ind47').val();
  let url = '/indicadores/totalTalentosMujeresSenaEnProyecto/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind47';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

// Indicador 48
function consultarTotalTalentosEgresadosSenaEnProyecto_total(bandera) {
  let idnodo = setIdNodo_Indicadores(bandera);
  let fecha_inicio = $('#txtfecha_inicio_ind48').val();
  let fecha_fin = $('#txtfecha_fin_ind48').val();
  let url = '/indicadores/totalTalentosEgresadosSenaEnProyecto/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
  let input = 'txt_total_ind48';
  dispararAjax_Fechas(idnodo, fecha_inicio, fecha_fin, url, input);
}

$(document).ready(function() {
  consultarPublicacionesOtros();
  consultarPublicacionesDesarrollador();
})

function consultarPublicacionesOtros() {
  $('#tblnovedades_Otros').dataTable().fnDestroy();
  $('#tblnovedades_Otros').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/publicacion/datatablePublicaciones",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        data: 'titulo',
        name: 'titulo',
      },
      {
        width: '8%',
        data: 'detalle',
        name: 'detalle',
        orderable: false
      },
    ],
  });
}

function consultarPublicacionesDesarrollador() {
  $('#tblnovedades_Desarrollador').dataTable().fnDestroy();
  $('#tblnovedades_Desarrollador').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/publicacion/datatablePublicaciones",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'codigo_publicacion',
        name: 'codigo_publicacion',
      },
      {
        // width: '15%',
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        data: 'titulo',
        name: 'titulo',
      },
      {
        data: 'role',
        name: 'role',
      },
      {
        width: '8%',
        data: 'detalle',
        name: 'detalle',
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
        data: 'update',
        name: 'update',
        orderable: false
      },
    ],
  });
}

$('#txtcontenido').summernote({
  lang: 'es-ES',
  height: 300
});

$('#txtfecha_inicio').bootstrapMaterialDatePicker({
  time:false,
  date:true,
  shortTime:true,
  format: 'YYYY-MM-DD',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});

$('#txtfecha_fin').bootstrapMaterialDatePicker({
  time:false,
  date:true,
  shortTime:true,
  format: 'YYYY-MM-DD',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});
=======
function detallesIdeasDelEntrenamiento(a){$.ajax({dataType:"json",type:"get",url:"entrenamientos/"+a,data:{identrenamiento:a}}).done(function(a){$("#ideasEntrenamiento").empty(),null!=a&&($("#fechasEntrenamiento").empty(),$("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Primera Sesion del Entrenamiento: </span>"+a[0].fecha_sesion1+"<br>"),$("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Segunda Sesion del Entrenamiento: </span>"+a[0].fecha_sesion2),$.each(a,function(a,e){$("#ideasEntrenamiento").append("<tr><td>"+e.codigo_idea+" - "+e.nombre_proyecto+"</td><td>"+e.confirmacion+"</td><td>"+e.convocado+"</td><td>"+e.canvas+"</td><td>"+e.asistencia1+"</td><td>"+e.asistencia2+"</td></tr>")}),$("#modalIdeasEntrenamiento").openModal())})}function consultarEntrenamientosPorNodo_Administrador(a){$("#entrenamientosPorNodo_tableAdministrador").dataTable().fnDestroy(),$("#entrenamientosPorNodo_tableAdministrador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/entrenamientos/consultarEntrenamientosPorNodo/"+a.value,type:"get"},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{data:"fecha_sesion2",name:"fecha_sesion2"},{data:"correos",name:"correos"},{data:"fotos",name:"fotos"},{data:"listado_asistencia",name:"listado_asistencia"},{width:"8%",data:"details",name:"details",orderable:!1}]})}function noSeEncontraronResultados(){Swal.fire({title:"¿Desea inhabilitar elentrenamiento?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, inhabilitar"})}function inhabilitarEntrenamientoPorId(a,e){Swal.fire({title:"¿Desea inhabilitar el entrenamiento?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, inhabilitar"}).then(e=>{e.value&&Swal.fire({title:"¿Qué desea hacer?",text:"Seleccione lo que ocurrirá con las ideas de proyecto que están asociasdas al entrenamiento",type:"warning",footer:'<a onclick="Swal.close()" href="#">Cancelar</a>',confirmButtonText:'<a class="white-text" onclick="cambiarEstadoDeIdeasDeProyectoDeEntrenamiento('+a+', \'Inhabilitado\'); Swal.close()" href="#">Inhabilitar las ideas de proyecto</a>',cancelButtonColor:"#d33",showCancelButton:!0,cancelButtonText:'<a class="white-text" onclick="cambiarEstadoDeIdeasDeProyectoDeEntrenamiento('+a+', \'Inicio\'); Swal.close()" href="#">Regresar las ideas de proyecto al estado de Inicio</a>',focusConfirm:!1})})}function cambiarEstadoDeIdeasDeProyectoDeEntrenamiento(a,e){$.ajax({dataType:"json",type:"get",url:"/entrenamientos/inhabilitarEntrenamiento/"+a+"/"+e,success:function(a){console.log(a),"true"==a.update&&Swal.fire({title:"El entrenamiento se ha inhabilitado!",html:"Las ideas de proyecto del entrenamiento han cambiado su estado a: "+a.estado,type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok!"}),"1"==a.update&&Swal.fire({title:"No se puede inhabilitar el entrenamiento!",html:"Al parecer, las siguientes ideas de proyecto se encuentran registradas en un comité: </br> <b> "+a.ideas+"</b></br>Si deseas hacer esto, las ideas de proyecto asociadas al entrenamiento no pueden estar en proyecto ó CSIBT",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Entiendo!"})},error:function(a,e,t){alert("Error: "+t)}})}function enviarNotificacionResultadosCSIBT(a,e){$.ajax({type:"get",url:"/csibt/notificar_resultado/"+a+"/"+e,dataType:"json",processData:!1,success:function(a){"notifica"==a.state?notificacionExitosaDelResultado(a):notificacionFallidaDelResultado()},error:function(a,e,t){alert("Error: "+t)}})}function notificacionExitosaDelResultado(a){Swal.fire({title:"Notificación Exitosa!",text:"Se ha enviado un mensaje a la dirección: "+a.idea.correo_contacto+" con los resultados del comité.",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function notificacionFallidaDelResultado(){Swal.fire({title:"Notificación Fallida!",text:"No se ha logrado enviar una mensaje con los resultados del comité al talento.",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function ajaxSendFormComiteAsignar(a,e,t,o){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),"create"==o&&mensajesComiteAsignarCreate(a)},error:function(a,e,t){alert("Error: "+t)}})}function mensajesComiteAsignarCreate(a){"registro"==a.state&&(Swal.fire({title:"Registro Exitoso",text:"La asignación de ideas de proyecto del comité ha sido registrada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_registro"==a.state&&Swal.fire({title:"La asignación de ideas de proyecto del comité no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function addIdeaComite(){let a=$("#txtideaproyecto").val(),e=$("#txthoraidea").val(),t=$("#txtdireccion").val();0==a||""==e||""==t?datosIncompletosAgendamiento():0==noRepeatIdeasAgendamiento(a)?ideaYaSeEncuentraAsociadaAgendamiento():pintarIdeaEnLaTabla(a,e,t)}function eliminarIdeaDelAgendamiento(a){$("#ideaAsociadaAgendamiento"+a).remove()}function ajaxSendFormComiteAgendamiento(a,e,t,o){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),"create"==o?mensajesComiteAgendamientoCreate(a):mensajesComiteAgendamientoUpdate(a)},error:function(a,e,t){alert("Error: "+t)}})}function mensajesComiteAgendamientoCreate(a){"registro"==a.state&&(Swal.fire({title:"Registro Exitoso",text:"El comité ha sido registrado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_registro"==a.state&&Swal.fire({title:"El comité no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesComiteAgendamientoUpdate(a){"update"==a.state&&(Swal.fire({title:"Modificación Exitosa",text:"El comité se ha modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_update"==a.state&&Swal.fire({title:"El comité no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function pintarIdeaEnLaTabla(a,e,t){$.ajax({dataType:"json",type:"get",url:"/idea/detallesIdea/"+a}).done(function(a){let o=prepararFilaEnLaTablaDeIdeas(a,e,t);$("#tblIdeasComiteCreate").append(o),ideaSeAsocioAlAgendamiento(),reiniciarCamposAgendamiento()})}function prepararFilaEnLaTablaDeIdeas(a,e,t){let o=a.detalles.id;return'<tr class="selected" id=ideaAsociadaAgendamiento'+o+'><td><input type="hidden" name="ideas[]" value="'+o+'">'+a.detalles.nombre_proyecto+'</td><td><input type="hidden" name="horas[]" value="'+e+'">'+e+'</td><td><input type="hidden" name="direcciones[]" value="'+t+'">'+t+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelAgendamiento('+o+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function datosIncompletosAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"error",title:"Estás ingresando mal los datos"})}function ideaSeAsocioAlAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"success",title:"La idea de proyecto se asoció con éxito al comité"})}function ideaYaSeEncuentraAsociadaAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"La idea de proyecto ya se encuentra asociada al comité!"})}function noRepeatIdeasAgendamiento(a){let e=a,t=!0,o=document.getElementsByName("ideas[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function reiniciarCamposAgendamiento(){$("#txtideaproyecto").val("0"),$("#txtideaproyecto").select2(),$("#txthoraidea").val(""),$("#txtobservacionesidea").val(""),$("#txtdireccion").val(""),$("label[for='txtdireccion']").removeClass("active"),$("label[for='txthoraidea']").removeClass("active")}function ajaxSendFormComiteRealizado(a,e,t,o){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),"create"==o&&mensajesComiteRealizadoCreate(a)},error:function(a,e,t){alert("Error: "+t)}})}function mensajesComiteRealizadoCreate(a){"registro"==a.state&&(Swal.fire({title:"Registro Exitoso",text:"La calificación del comité ha sido registrada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_registro"==a.state&&Swal.fire({title:"La calificación del comité no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function consultarCsibtPorNodo(){let a=$("#txtnodo").val();$("#comitesDelNodoAdministrador_table").dataTable().fnDestroy(),$("#comitesDelNodoAdministrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:!1,ajax:{url:"/csibt/"+a+"/consultarCsibtPorNodo",type:"get"},columns:[{data:"codigo",name:"codigo"},{data:"fechacomite",name:"fechacomite"},{data:"estadocomite",name:"estadocomite"},{data:"observaciones",name:"observaciones"},{data:"details",name:"details",orderable:!1}]})}$(document).ready(function(){$("#linea_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"lineas"},columns:[{data:"abreviatura",name:"abreviatura"},{data:"nombre",name:"nombre"},{data:"descripcion",name:"descripcion"},{data:"show",name:"show",orderable:!1},{data:"action",name:"action",orderable:!1}]})}),$(document).ready(function(){$("#linea_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"lineas"},columns:[{data:"abreviatura",name:"abreviatura"},{data:"nombre",name:"nombre"},{data:"descripcion",name:"descripcion"},{data:"action",name:"action",orderable:!1}]})}),$(document).ready(function(){$("#nodos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!0,responsive:!0,bSort:!1,dom:"Bfrtip",buttons:[{extend:"csv",text:"exportar csv",exportOptions:{columns:":visible"}},{extend:"excel",exportOptions:{columns:":visible"}},{extend:"pdf",exportOptions:{columns:":visible"}}],ajax:{url:"/nodo"},columns:[{data:"centro",name:"centro"},{data:"nodos",name:"nodos"},{data:"direccion",name:"direccion"},{data:"ubicacion",name:"ubicacion"},{data:"detail",name:"detail",orderable:!1}]})}),$(document).ready(function(){$("#entrenamientosPorNodo_tableDinamizador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/entrenamientos/consultarEntrenamientosPorNodo",type:"get"},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{data:"fecha_sesion2",name:"fecha_sesion2"},{data:"correos",name:"correos"},{width:"8%",data:"fotos",name:"fotos"},{width:"8%",data:"listado_asistencia",name:"listado_asistencia"},{width:"8%",data:"details",name:"details",orderable:!1}]})}),$(document).ready(function(){$("#entrenamientos_nodo_table").dataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,paging:!0,ajax:{url:"/entrenamientos",type:"get"},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{data:"fecha_sesion2",name:"fecha_sesion2"},{data:"correos",name:"correos"},{data:"fotos",name:"fotos"},{data:"listado_asistencia",name:"listado_asistencia"},{width:"8%",data:"details",name:"details",orderable:!1},{width:"8%",data:"edit",name:"edit",orderable:!1},{width:"8%",data:"update_state",name:"update_state",orderable:!1},{width:"8%",data:"evidencias",name:"evidencias",orderable:!1}]}),$("a.toggle-vis").on("click",function(a){a.preventDefault();var e=table.column($(this).attr("data-column"));e.visible(!e.visible())})}),$(document).ready(function(){entrenamiento.getIdeas(),$("#txtfecha_sesion2").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$("#txtfecha_sesion1").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}).on("change",function(a,e){$("#txtsegundasesion").bootstrapMaterialDatePicker("setMinDate",e)})}),entrenamiento={addIdea:function(){let a=$("#txtidea").val(),e=$("#formEntrenamientos input[name=_token]").val();$.ajax({dataType:"json",type:"post",url:"/entrenamientos/addidea",data:{Idea:a,_token:e}}).done(function(a){3==a.data?Swal.fire({title:"Error!",text:"La idea de proyecto ya está asociada al entrenamiento!",type:"warning",confirmButtonText:"Cool"}):entrenamiento.getIdeas()})},getIdeas:function(){$.ajax({dataType:"json",type:"get",url:"/entrenamientos/getideasEntrenamiento"}).done(function(a){$("#tblIdeasEntrenamientoCreate").empty(),$.each(a,function(a,e){let t=1==e.Confirm?"checked":"",o=1==e.Canvas?"checked":"",n=1==e.AssistF?"checked":"",i=1==e.AssistS?"checked":"",s=1==e.Convocado?"checked":"";$("#tblIdeasEntrenamientoCreate").append("<tr><td>"+e.codigo_idea+" - "+e.nombre_proyecto+"</td><td>"+e.nombres_contacto+" "+e.apellidos_contacto+'</td><td><p class="center p-v-xs"><input type="checkbox" '+t+' onclick="entrenamiento.getConfirm('+e.id+", "+(1==e.Confirm?1:0)+')" name="confirmacion" id="confirmacion'+e.id+'" value="1"/><label for="confirmacion'+e.id+'"></label></p></td><td><p class="center p-v-xs"><input type="checkbox" '+o+' onclick="entrenamiento.getCanvas('+e.id+", "+(1==e.Canvas?1:0)+')" name="canvas" id="canvas'+e.id+'" value="1"/><label for="canvas'+e.id+'"></label></p></td><td><p class="center p-v-xs"><input type="checkbox" '+n+' onclick="entrenamiento.getAssistF('+e.id+", "+(1==e.AssistF?1:0)+')" name="asistencia_primera_sesion" id="asistencia_primera_sesion'+e.id+'" value="1"/><label for="asistencia_primera_sesion'+e.id+'"></label></p></td><td><p class="center p-v-xs"><input type="checkbox" '+i+' onclick="entrenamiento.getAssistS('+e.id+", "+(1==e.AssistS?1:0)+')" name="asistencia_segunda_sesion" id="asistencia_segunda_sesion'+e.id+'" value="1"/><label for="asistencia_segunda_sesion'+e.id+'"></label></p></td><td><p class="center p-v-xs"><input type="checkbox" '+s+' onclick="entrenamiento.getConvocado('+e.id+", "+(1==e.Convocado?1:0)+')" name="csibt_convocado" id="csibt_convocado'+e.id+'" value="1"/><label for="csibt_convocado'+e.id+'"></label></p></td><td><a class="waves-effect red lighten-3 btn" onclick="entrenamiento.getEliminar('+e.id+');"><i class="material-icons">delete_sweep</i></a></td></tr>')})})},getEliminar:function(a){$.ajax({type:"get",dataType:"json",url:"/entrenamientos/eliminar/"+a}).done(function(a){entrenamiento.getIdeas()})},getConfirm:function(a,e){$.ajax({type:"get",dataType:"json",url:"/entrenamientos/getConfirm/"+a+"/"+e}).done(function(a){entrenamiento.getIdeas()})},getCanvas:function(a,e){$.ajax({type:"get",dataType:"json",url:"/entrenamientos/getCanvas/"+a+"/"+e}).done(function(a){entrenamiento.getIdeas()})},getAssistF:function(a,e){$.ajax({type:"get",dataType:"json",url:"/entrenamientos/getAssistF/"+a+"/"+e}).done(function(a){entrenamiento.getIdeas()})},getAssistS:function(a,e){$.ajax({type:"get",dataType:"json",url:"/entrenamientos/getAssistS/"+a+"/"+e}).done(function(a){entrenamiento.getIdeas()})},getConvocado:function(a,e){$.ajax({type:"get",dataType:"json",url:"/entrenamientos/getConvocado/"+a+"/"+e}).done(function(a){entrenamiento.getIdeas()})}},$(document).on("submit","form#formComiteAsignarCreate",function(a){a.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",text:"No podrás revertir estos cambios!",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(e=>{if(e.value){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteAsignar(t,o,n,"create")}})}),$(document).ready(function(){$(".dataTables_length select").addClass("browser-default"),$("#comitesDelNodo_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:!1,ajax:{url:"/csibt",type:"get"},columns:[{data:"codigo",name:"codigo"},{data:"fechacomite",name:"fechacomite"},{data:"estadocomite",name:"estadocomite"},{data:"observaciones",name:"observaciones"},{data:"details",name:"details",orderable:!1}],initComplete:function(){this.api().columns().every(function(){var a=this,e=document.createElement("input");$(e).appendTo($(a.footer()).empty()).on("change",function(){a.search($(this).val(),!1,!1,!0).draw()})})}})}),csibt={consultarComitesPorNodo:function(a){$.ajax({dataType:"json",type:"get",url:"/csibt/"+a}).done(function(a){console.log(a),$("#ideasProyectoDeUnComite").empty(),null!=a&&($("#fechaComiteModal").empty(),$("#fechaComiteModal").append("<span class='cyan-text text-darken-3'>Fecha del Comité: </span>"+a.ideasDelComite[0].fechacomite),$.each(a.ideasDelComite,function(a,e){let t='<a class="btn cyan m-b-xs" onclick="csibt.consultarIdeaProyectoAsociadaAlEntrenamiento('+e.id+')"><i class="material-icons">library_books</i></a>',o='<a target="_blank" href="/idea/'+e.id+'/edit" class="waves-effect waves-light btn btn-info m-b-xs"><i class="material-icons">edit</i></a>';$("#ideasProyectoDeUnComite").append("<tr><td>"+e.nombre_proyecto+"</td><td>"+e.hora+"</td><td>"+e.asistencia+"</td><td>"+e.observaciones+"</td><td>"+e.admitido+"</td><td>"+o+"</td><td>"+t+"</td></tr>")}),$("#modalIdeasComite").openModal())})},consultarIdeaProyectoAsociadaAlEntrenamiento:function(a){$.ajax({dataType:"json",type:"get",url:"/idea/detallesIdea/"+a}).done(function(a){$("#titulo").empty(),$("#detalle_idea").empty(),null==a?swal("Ups!!","Ha ocurrido un error","warning"):($("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+a.detalles.nombre_proyecto),$("#detalle_idea").append('<div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.aprendiz_sena+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.pregunta1String+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.pregunta2String+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Descripcion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.descripcion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Objetivo: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.objetivo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Alcance: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.alcance+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿La idea viene de una convocatoria? </span></div><div class="col s12 m6 l6"><span class="black-text">'+vieneConvocatoria(a.detalles.viene_convocatoria)+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de Convocatoria: </span></div><div class="col s12 m6 l6"><span class="black-text">'+nombreConvocatoria(a.detalles.viene_convocatoria,a.detalles.convocatoria)+"</span></div></div>"),$("#ideaProyecto").openModal())})}},$("#txthoraidea").bootstrapMaterialDatePicker({time:!0,date:!1,shortTime:!0,format:"HH:mm",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$(document).on("submit","form#formComiteAgendamientoCreate",function(a){a.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(e=>{if(e.value){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteAgendamiento(t,o,n,"create")}})}),$(document).on("submit","form#formComiteAgendamientoUpdate",function(a){a.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(e=>{if(e.value){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteAgendamiento(t,o,n,"update")}})}),$(document).on("submit","form#formComiteRealizadoCreate",function(a){a.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",text:"Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los gestores puedes cambiar esta información",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(e=>{if(e.value){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteRealizado(t,o,n,"create")}})}),$(document).ready(function(){$("#comitesDelNodoGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:!1,ajax:{url:"/csibt",type:"get"},columns:[{data:"codigo",name:"codigo"},{data:"fechacomite",name:"fechacomite"},{data:"estadocomite",name:"estadocomite"},{data:"observaciones",name:"observaciones"},{data:"details",name:"details",orderable:!1}],initComplete:function(){this.api().columns().every(function(){var a=this,e=document.createElement("input");$(e).appendTo($(a.footer()).empty()).on("change",function(){a.search($(this).val(),!1,!1,!0).draw()})})}})}),$(document).ready(function(){$("#empresasDeTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},deferRender:!0,columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"sector_empresa",name:"sector_empresa"},{data:"ciudad",name:"ciudad"},{data:"direccion",name:"direccion"},{data:"details",name:"details",orderable:!1},{data:"contacts",name:"contacts",orderable:!1},{data:"edit",name:"edit",orderable:!1}],initComplete:function(){this.api().columns().every(function(){var a=this,e=$('<select><option value=""></option></select>').appendTo($(a.footer()).empty()).on("change",function(){var e=$.fn.dataTable.util.escapeRegex($(this).val());a.search(e?"^"+e+"$":"",!0,!1).draw()});a.data().unique().sort().each(function(a,t){e.append('<option value="'+a+'">'+a+"</option>")})})}});$("#empresasDeTecnoparque_tableNoGestor").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"sector_empresa",name:"sector_empresa"},{data:"ciudad",name:"ciudad"},{data:"direccion",name:"direccion"},{data:"details",name:"details",orderable:!1}]})});var empresaIndex={consultarDetallesDeUnaEmpresa:function(a){$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetallesDeUnaEmpresa/"+a}).done(function(a){$("#modalDetalleDeUnaEmpresaTecnoparque_titulo").empty(),$("#modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa").empty(),null==a?swal("Ups!!","Ha ocurrido un error","warning"):($("#modalDetalleDeUnaEmpresaTecnoparque_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>"),$("#modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nit de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nit+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_empresa+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Dirección de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.direccion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Email de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.email_entidad+"</span></div></div>"),$("#detalleDeUnaEmpresaTecnoparque").openModal())})}};$(document).ready(function(){$("#grupoDeInvestigacionTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{data:"ciudad",name:"ciudad"},{data:"tipo_grupo",name:"tipo_grupo"},{data:"institucion",name:"institucion"},{data:"clasificacioncolciencias",name:"clasificacioncolciencias"},{data:"details",name:"details",orderable:!1},{data:"contacts",name:"contacts",orderable:!1},{data:"edit",name:"edit",orderable:!1}]})}),$("#grupoDeInvestigacionTecnoparque_tableNoGestor").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{data:"ciudad",name:"ciudad"},{data:"tipo_grupo",name:"tipo_grupo"},{data:"institucion",name:"institucion"},{data:"clasificacioncolciencias",name:"clasificacioncolciencias"},{data:"details",name:"details",orderable:!1}]});var grupoInvestigacionIndex={consultarDetallesDeUnGrupoInvestigacion:function(a){$.ajax({dataType:"json",type:"get",url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+a}).done(function(a){if($("#modalDetalleDeUnGrupoDeInvestigacion_titulo").empty(),$("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").empty(),null==a)swal("Ups!!","Ha ocurrido un error","warning");else{let e="Interno";0==a.detalles.tipogrupo&&(e="Externo"),$("#modalDetalleDeUnGrupoDeInvestigacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>"),$("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.codigo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.entidad.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.entidad.email_entidad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.entidad.ciudad.nombre+" - "+a.detalles.entidad.ciudad.departamento.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.institucion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.clasificacioncolciencias.nombre+"</span></div></div>"),$("#detalleDeUnGrupoDeInvestigacion").openModal()}})}};$(document).ready(function(){$("#administrador_activos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/administrador",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})}),$(document).ready(function(){$("#administrador_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/administrador/papelera",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})});let downloadAdministrador={downloadAdministrator:function(a){null!==a?location.href="/usuario/excel/administrador/"+a:Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",icon:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})},downloadAllUser:function(a){null!==a?location.href="/usuario/excel/"+a:Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",icon:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}};$(document).ready(function(){$("#dinamizador_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}),$("#dinamizador_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var UserAdministradorDinamizador={selectDinamizadoresPorNodo:function(){let a=$("#selectnodo").val();$("#dinamizador_table_activos").dataTable().fnDestroy(),""!=a?$("#dinamizador_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usuario/dinamizador/getDinamizador/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#dinamizador_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},selectDinamizadoresPorNodoTrash:function(){let a=$("#selectnodo").val();$("#dinamizador_table_inactivos").dataTable().fnDestroy(),""!=a?$("#dinamizador_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usuario/dinamizador/getDinamizador/papelera/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#dinamizador_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},downloadDinamizador:function(a){let e=$("#selectnodo").val();null==e||0==e?Swal.fire({title:"Por favor selecciona un nodo",confirmButtonText:"Ok"}):null===a||null===e&&0===e?Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"}):location.href="/usuario/excel/dinamizador/"+a+"/"+e},downloadAllDinamizador:function(a){location.href="/usuario/excel/dinamizador/"+a}};$(document).ready(function(){$("#gestor_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}),$("#gestor_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var UserAdministradorGestor={selectGestoresPorNodo:function(){let a=$("#selectnodo").val();$("#gestor_table_activos").dataTable().fnDestroy(),""!=a?$("#gestor_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usuario/gestor/getGestor/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#gestor_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},selectGestoresPorNodoTrash:function(){let a=$("#selectnodo").val();$("#gestor_table_inactivos").dataTable().fnDestroy(),""!=a?$("#gestor_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usuario/gestor/getGestor/papelera/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#gestor_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},downloadGestor:function(a){let e=$("#selectnodo").val();null==e||0==e?Swal.fire({title:"Por favor selecciona un nodo",confirmButtonText:"Ok"}):null===a||null===e&&0===e?Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"}):location.href="/usuario/excel/gestor/"+a+"/"+e},downloadAllGestor:function(a){location.href="/usuario/excel/gestor/"+a}};$(document).ready(function(){$("#infocenter_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}),$("#infocenter_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var UserAdministradorInfocenter={selectInfocentersForNodo:function(){let a=$("#selectnodo").val();$("#infocenter_table_activos").dataTable().fnDestroy(),""!=a?$("#infocenter_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/infocenter/getinfocenter/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#infocenter_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},selectInfocentersForNodoTrash:function(){let a=$("#selectnodo").val();$("#infocenter_table_inactivos").dataTable().fnDestroy(),""!=a?$("#infocenter_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/infocenter/getinfocenter/papelera/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#infocenter_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},downloadInfocenter:function(a){let e=$("#selectnodo").val();null==e||0==e?Swal.fire({title:"Por favor selecciona un nodo",confirmButtonText:"Ok"}):null===a||null===e&&0===e?Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"}):location.href="/usuario/excel/infocenter/"+a+"/"+e},downloadAllInfocenter:function(a){location.href="/usuario/excel/infocenter/"+a}};$(document).ready(function(){$("#talentoByDinamizador_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}),$("#talentoByDinamizador_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var usuarios={consultarTalentosByTecnoparque:function(){let a=$("#txt_anio_user").val(),e=$("#txtnodo").val();""==e||null==e?Swal.fire("Error","Por favor selecciona un nodo","error"):""==a||null==a?Swal.fire("Error","Por favor selecciona un año","error"):($("#talentoByDinamizador_table_activos").dataTable().fnDestroy(),$("#talentoByDinamizador_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbynodo/"+e+"/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}))},consultarTalentosByTecnoparqueTrash:function(){let a=$("#txt_anio_user").val(),e=$("#txtnodo").val();""==e||null==e?Swal.fire("Error","Por favor selecciona un nodo","error"):""==a||null==a?Swal.fire("Error","Por favor selecciona un año","error"):($("#talentoByDinamizador_table_inactivos").dataTable().fnDestroy(),$("#talentoByDinamizador_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbynodo/papelera/"+e+"/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}))},downloadTalento:function(a){let e=$("#txtnodo").val(),t=$("#txt_anio_user").val();null==e||0==e?Swal.fire({title:"Por favor selecciona un nodo",confirmButtonText:"Ok"}):null==t||0==t?Swal.fire({title:"Por favor selecciona un año",confirmButtonText:"Ok"}):null===a||null===e&&0===e||null===t&&0===t?Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"}):location.href="/usuario/excel/talento/"+a+"/"+e+"/"+t},downloadAllTalentos:function(a){location.href="/usuario/excel/talento/"+a}};$(document).ready(function(){$("#ingreso_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}),$("#ingreso_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var UserAdministradorIngreso={selectIngresoForNodo:function(){let a=$("#selectnodo").val();$("#ingreso_table_activos").dataTable().fnDestroy(),""!=a?$("#ingreso_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usuario/ingreso/getingreso/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#ingreso_table_activos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},selectIngresoForNodoTrash:function(){let a=$("#selectnodo").val();$("#ingreso_table_inactivos").dataTable().fnDestroy(),""!=a?$("#ingreso_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usuario/ingreso/getingreso/papelera/"+a,type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}):$("#ingreso_table_inactivos").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},downloadIngreso:function(a){let e=$("#selectnodo").val();null==e||0==e?Swal.fire({title:"Por favor selecciona un nodo",confirmButtonText:"Ok"}):null===a||null===e&&0===e?Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"}):location.href="/usuario/excel/ingreso/"+a+"/"+e},downloadAllIngreso:function(a){location.href="/usuario/excel/ingreso/"+a}};$(document).ready(function(){$("#gestores_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/gestor/getgestor",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}),$("#gestores_dinamizador_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/gestor/getgestor/papelera",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})});var UserDinamizadorGestor={downloadGestor:function(a){null!==a?location.href="/usuario/excel/gestor/"+a:Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"})}};$(document).ready(function(){userTalentoByDinamizador.consultarTalentosByTecnoparque(),userTalentoByDinamizador.consultarTalentosByTecnoparqueTrash(),$("#talentoByGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}),$("#talentoByGestor_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var userTalentoByDinamizador={consultarTalentosByTecnoparque:function(){let a=$("#anio_proyecto_talento").val();$("#talentoByDinamizador_table").dataTable().fnDestroy(),$("#talentoByDinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbydatatables/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})},consultarTalentosByTecnoparqueTrash:function(){let a=$("#anio_proyecto_talento").val();$("#talentoByDinamizador_inactivos_table").dataTable().fnDestroy(),$("#talentoByDinamizador_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbydatatables/papelera/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})},getUserTalentosByGestor:function(){let a=$("#txtanho_user_talento").val(),e=$("#txtgestor_id").val();""==e||null==e?Swal.fire("Error","Por favor selecciona un gestor","error"):""==a||null==a?Swal.fire("Error","Por favor selecciona un gestor","error"):($("#talentoByGestor_table").dataTable().fnDestroy(),$("#talentoByGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbygestordatatables/"+e+"/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}))},getUserTalentosByGestorTrash:function(){let a=$("#txtanho_user_talento").val(),e=$("#txtgestor_id").val();""==e||null==e?Swal.fire("Error","Por favor selecciona un gestor","error"):""==a||null==a?Swal.fire("Error","Por favor selecciona un gestor","error"):($("#talentoByGestor_inactivos_table").dataTable().fnDestroy(),$("#talentoByGestor_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbygestordatatables/papelera/"+e+"/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}))},downloadTalento:function(a){let e=$("#anio_proyecto_talento").val();if(null==e||0==e)Swal.fire({title:"Por favor selecciona un año",confirmButtonText:"Ok"});else if(null===a||null===e&&0===e)Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"});else{let t=0;location.href="/usuario/excel/talento/"+a+"/"+t+"/"+e}}};$(document).ready(function(){$("#infocenters_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/infocenter/getinfocenter",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}),$("#infocenters_dinamizador_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/infocenter/getinfocenter/papelera",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})});var UserDinamizadorInfocenter={downloadInfocenter:function(a){null!==a?location.href="/usuario/excel/infocenter/"+a:Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"})}};$(document).ready(function(){$("#ingresos_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/ingreso/getingreso",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]}),$("#ingresos_dinamizador_inactivos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usuario/ingreso/getingreso/papelera",type:"get"},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})});var UserDinamizadorIngreso={downloadIngreso:function(a){null!==a?location.href="/usuario/excel/ingreso/"+a:Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"})}};function consultarTalentosByGestor(){let a=$("#anio_proyecto_talento").val();$("#talento_activosByGestor_table").dataTable().fnDestroy(),$("#talento_activosByGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbydatatables/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})}function consultarTalentosByGestorTrash(){let a=$("#anio_proyecto_talento").val();$("#talento_inactivosByGestor_table").dataTable().fnDestroy(),$("#talento_inactivosByGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usuario/getuserstalentosbydatatables/papelera/"+a},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombre",name:"nombre"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"detail",name:"detail",orderable:!1}]})}$(document).ready(function(){consultarTalentosByGestor(),consultarTalentosByGestorTrash()});var UserTalentoByGestor={downloadTalento:function(a){let e=$("#anio_proyecto_talento").val();if(null==e||0==e)Swal.fire({title:"Por favor selecciona un año",confirmButtonText:"Ok"});else if(null===a||null===e&&0===e)Swal.fire({title:"Error al descagar el archivo, intentalo de nuevo",confirmButtonText:"Ok"});else{let t=0;location.href="/usuario/excel/talento/"+a+"/"+t+"/"+e}}};$(document).on("submit","form#formSearchUser",function(a){a.preventDefault(),$("#response-alert").empty();let e=$("#txttype_search").val(),t=$("#txtsearch_user").val(),o=new RegExp("^[0-9]{6,11}$");if(""==e)Swal.fire("Error","Por favor selecciona una opción","error");else if(1!=e||null!=t&&""!=t&&o.test(t))if(2!=e||null!=t&&""!=t&&/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(t)){var n=$(this);let a=new FormData($(this)[0]);var i=n.attr("action");$.ajax({type:n.attr("method"),url:i,data:a,dataType:"json",cache:!1,dataType:"json",contentType:!1,processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),$("#response-alert").empty(),a.fail&&Swal.fire({title:"Registro Erróneo",html:"Estas ingresando mal los datos. "+errores,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),202==a.status?1==e?$("#response-alert").append('\n                            <div class="mailbox-list">\n                                <ul>\n                                    <li >\n                                        <a  class="mail-active">\n\n                                            <h4 class="center-align">no se encontraron resultados</h4>\n\n                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="'+a.url+"/"+t+'">Registrar nuevo usuario</a>\n\n                                        </a>\n                                    </li>\n                                </ul>\n                            </div>\n                        '):$("#response-alert").append('\n                            <div class="mailbox-list">\n                                <ul>\n                                    <li >\n                                        <a  class="mail-active">\n\n                                            <h4 class="center-align">no se encontraron resultados</h4>\n\n                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="'+a.url+'">Registrar nuevo usuario</a>\n\n                                        </a>\n                                    </li>\n                                </ul>\n                            </div>\n                        '):200==a.status&&$("#response-alert").append('\n                    <div class="mailbox-list">\n                        <ul>\n                            <li >\n                                <a href="'+a.url+'" class="mail-active">\n\n                                    <h5 class="mail-author">'+a.user.documento+" - "+a.user.nombres+" "+a.user.apellidos+'</h5>\n                                    <h4 class="mail-title">'+a.roles+'</h4>\n                                    <p class="hide-on-small-and-down mail-text">Miembro desde '+userSearch.userCreated(a.user.created_at)+'</p>\n                                    <div class="position-top-right p f-12 mail-date"> Acceso al sistema: '+userSearch.state(a.user.estado)+"</div>\n                                </a>\n                            </li>\n                        </ul>\n                    </div>\n                    ")}})}else Swal.fire("Error","Por favor ingrese un correo electrónico válido","error");else Swal.fire("Error","Por favor ingrese un número de documento válido","error")});var userSearch={state:function(a){return a?"Si":"No"},userCreated:function(a){return null==a?"no registra":moment(a).format("LL")},changetextLabel:function(){let a=$("#txttype_search").val();$("#txtsearch_user").val(""),1==a?$("label[for='txtsearch_user']").text("Número de documento"):2==a&&$("label[for='txtsearch_user']").text("Correo Electrónico")}},user={getCiudadExpedicion:function(){let a;a=$("#txtdepartamentoexpedicion").val(),$.ajax({dataType:"json",type:"get",url:"/usuario/getciudad/"+a}).done(function(a){$("#txtciudadexpedicion").empty(),$.each(a.ciudades,function(a,e){$("#txtciudadexpedicion").append('<option  value="'+e.id+'">'+e.nombre+"</option>")}),$("#txtciudadexpedicion").material_select()})},getOtraEsp:function(a){let e=$(a).val();$("#txteps option:selected").text();42==e?$(".otraeps").removeAttr("style"):$(".otraeps").attr("style","display:none")},getCiudad:function(){let a;a=$("#txtdepartamento").val(),$.ajax({dataType:"json",type:"get",url:"/usuario/getciudad/"+a}).done(function(a){$("#txtciudad").empty(),$("#txtciudad").append('<option value="">Seleccione la Ciudad</option>'),$.each(a.ciudades,function(a,e){$("#txtciudad").append('<option  value="'+e.id+'">'+e.nombre+"</option>")}),$("#txtciudad").material_select()})},getGradoDiscapacidad(a){1==$(a).val()?$(".gradodiscapacidad").removeAttr("style"):$(".gradodiscapacidad").attr("style","display:none")}};$(document).ready(function(){$("#txtocupaciones").select2({language:"es",isMultiple:!0}),estudios.getOtraOcupacion()});var estudios={getOtraOcupacion:function(a){$("#otraocupacion").hide();$(a).val();let e=$("#txtocupaciones option:selected").text().match(/[A-Z][a-z]+/g);$("#otraocupacion").hide(),null!=e&&e.includes("Otra")&&$("#otraocupacion").show()}};$(document).ready(function(){tipoTalento.getSelectTipoTalento()});var tipoTalento={getSelectTipoTalento:function(a){let e=$(a).val();$("#txttipotalento option:selected").text();1==e||2==e?tipoTalento.showAprendizSena():3==e?tipoTalento.showEgresadoSena():4==e?tipoTalento.showInstructorSena():5==e?tipoTalento.showFuncionarioSena():6==e?tipoTalento.showPropietarioEmpresa():7==e?tipoTalento.showEmprendedor():8==e?tipoTalento.showUniversitario():9==e?tipoTalento.showFuncionarioEmpresa():tipoTalento.ShowSelectTipoTalento()},showAprendizSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".aprendizSena").css("display","block"),$(".aprendizSena").show()},showEgresadoSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".egresadoSena").show()},showInstructorSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".instructorSena").css("display","block")},showFuncionarioSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".funcionarioSena").css("display","block")},showPropietarioEmpresa:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".otherUser").empty(),$(".otherUser").append('<div class="valign-wrapper" >\n            <h5> Seleccionaste Propietario empresa</h5>\n        </div>')},showEmprendedor:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".otherUser").empty(),$(".otherUser").append('<div class="valign-wrapper" >\n            <h5> Seleccionaste Emprendedor</h5>\n        </div>')},showUniversitario:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideFuncionarioEmpresa(),$(".universitario").css("display","block")},showFuncionarioEmpresa:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideUniversitario(),tipoTalento.hideEmprendedor(),$(".funcionarioEmpresa").css("display","block")},hideAprendizSena:function(){$(".aprendizSena").hide()},hideEgresadoSena:function(){$(".egresadoSena").hide()},hideInstructorSena:function(){$(".instructorSena").css("display","none")},hideFuncionarioSena:function(){$(".funcionarioSena").css("display","none")},hideSelectTipoTalento:function(){$(".selecttipotalento").css("display","none")},hidePropietarioEmpresa:function(){$(".otherUser").css("display","none")},hideUniversitario:function(){$(".universitario").css("display","none")},hideFuncionarioEmpresa:function(){$(".funcionarioEmpresa").css("display","none")},hideEmprendedor:function(){$(".otherUser").css("display","none")},ShowSelectTipoTalento:function(){tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideInstructorSena(),tipoTalento.hidePropietarioEmpresa(),$(".selecttipotalento").css("display","block")},getCentroFormacionAprendiz:function(){let a=$("#txtregional_aprendiz").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+a}).done(function(a){$("#txtcentroformacion_aprendiz").empty(),$("#txtcentroformacion_aprendiz").append('<option value="">Seleccione el centro de formación</option>'),$.each(a.centros,function(a,e){$("#txtcentroformacion_aprendiz").append('<option  value="'+a+'">'+e+"</option>"),$("#txtcentroformacion_aprendiz").material_select()})})},getCentroFormacionEgresadoSena:function(){let a=$("#txtregional_egresado").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+a}).done(function(a){$("#txtcentroformacion_egresado").empty(),$("#txtcentroformacion_egresado").append('<option value="">Seleccione el centro de formación</option>'),$.each(a.centros,function(a,e){$("#txtcentroformacion_egresado").append('<option  value="'+a+'">'+e+"</option>"),$("#txtcentroformacion_egresado").material_select()})})},getCentroFormacionFuncionarioSena:function(){let a=$("#txtregional_funcionarioSena").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+a}).done(function(a){$("#txtcentroformacion_funcionarioSena").empty(),$("#txtcentroformacion_funcionarioSena").append('<option value="">Seleccione el centro de formación</option>'),$.each(a.centros,function(a,e){$("#txtcentroformacion_funcionarioSena").append('<option  value="'+a+'">'+e+"</option>"),$("#txtcentroformacion_funcionarioSena").material_select()})})},getCentroFormacionInstructorSena:function(){let a=$("#txtregional_instructorSena").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+a}).done(function(a){$("#txtcentroformacion_instructorSena").empty(),$("#txtcentroformacion_instructorSena").append('<option value="">Seleccione el centro de formación</option>'),$.each(a.centros,function(a,e){$("#txtcentroformacion_instructorSena").append('<option  value="'+a+'">'+e+"</option>"),$("#txtcentroformacion_instructorSena").material_select()})})}};$(document).on("submit","form#formRegisterUser",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");$.ajax({type:e.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){if($('button[type="submit"]').prop("disabled",!1),$(".error").hide(),a.fail){for(control in a.errors)$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();createUser.printErroresFormulario(a)}"error"==a.state&&0==a.url&&Swal.fire({title:"El Usuario no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"success"==a.state&&0!=a.url&&(Swal.fire({title:"Registro Exitoso",text:"El Usuario "+a.user.nombres+" "+a.user.apellidos+"  ha sido creado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok",footer:'<p class="red-text">Hemos enviado un correo electrónico al  usuario '+a.user.nombres+" "+a.user.apellidos+" con las credenciales de ingreso a la plataforma.</p>"}),setTimeout(function(){window.location.href=a.url},1e3))}})});var createUser={printErroresFormulario:function(a){if("error_form"==a.state){let e="";for(control in a.errors)e+=" </br><b> - "+a.errors[control]+" </b> ",$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+e,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}};$(document).on("submit","form#formEditUser",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");$.ajax({type:e.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){if($('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),a.fail){for(control in a.errors)$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();EditUser.printErroresFormulario(a)}"error"==a.state&&0==a.url&&Swal.fire({title:"El Usuario no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"success"==a.state&&0!=a.url&&(Swal.fire({title:"Modifciación Exitosa",text:"El Usuario "+a.user.nombres+" "+a.user.apellidos+"  ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=a.url},1e3))}})});var EditUser={printErroresFormulario:function(a){if("error_form"==a.state){let e="";for(control in a.errors)e+=" </br><b> - "+a.errors[control]+" </b> ",$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+e,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}},UserIndex={detailUser(a){$.ajax({dataType:"json",type:"get",url:"/usuario/usuarios/"+a}).done(function(a){modalUser(a)})}};function modalUser(a){$(".titulo_users").empty();let e=1==a.data.user.genero?"Masculino":"Femenino",t=null!=a.data.user.otra_eps?a.data.user.otra_eps:"No registra",o=null!=a.data.user.telefono?a.data.user.telefono:"No registra",n=null!=a.data.user.celular?a.data.user.celular:"No registra";if($(".titulo_users").append('<div class="row">\n                 <div class="col s12 m12 l12">\n                    <div class="card mailbox-content">\n                        <div class="card-content">\n                            <div class="row no-m-t no-m-b">\n                    \n                                <div class="col s12 m12 l12">\n                                    \n                                    <div class="mailbox-view">\n                                        <div class="mailbox-view-header">\n                                            <div class="left">\n                                                \n                                                <div class="left">\n                                                    <span class="mailbox-title ">\n                                                        '+(null!=a.data.user.nombres?a.data.user.nombres:"No registra")+" "+(null!=a.data.user.apellidos?a.data.user.apellidos:"No registra")+'\n                                                    </span>\n\n                                                    <span class="mailbox-author black-text text-darken-2">\n                                                        \n                                                        '+(null!=a.data.role?a.data.role:"No registra")+"<br>\n                                                        Miembro desde "+(null!=a.data.user.created_at?moment(a.data.user.created_at).format("LL"):"No registra")+' <br>\n                                                    </span>\n                                                </div>\n                                            </div>\n                                            \n\n                                            <div class="right mailbox-buttons">\n                                                \n                                            </div>\n                                        </div>\n                                        <div class="right">\n                                            <small>'+e+'</small>\n                                        </div>\n                                        <div class="divider mailbox-divider">\n                                        </div>\n                                        <div class="mailbox-text">\n                                            <div class="row">\n                                                <div class="col s12 m6 l6">\n                                                    <ul class="collection">\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                credit_card\n                                                            </i>\n                                                            <span class="title">\n                                                                Tipo Documento\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.tipodocumento.nombre?a.data.user.tipodocumento.nombre:"No registra")+'   \n                                                            </p>\n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                perm_contact_calendar\n                                                            </i>\n                                                            <span class="title">\n                                                                Fecha de Nacimiento\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.fechanacimiento?moment(a.data.user.fechanacimiento).format("LL"):"No registra")+'\n                                                            </p>\n                                                            \n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                credit_card\n                                                            </i>\n                                                            <span class="title">\n                                                                Ciudad Expedición documento de identidad\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.ciudadexpedicion.nombre?a.data.user.ciudadexpedicion.nombre:"No registra")+'   \n                                                            </p>\n                                                        </li>\n                                                        \n\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                local_hospital\n                                                            </i>\n                                                            <div class="left">\n                                                               <span class="title">\n                                                                    Eps\n                                                                </span>\n                                                                <p>\n                                                                   '+(null!=a.data.user.eps.nombre?a.data.user.eps.nombre:"No registra")+'   \n                                                                </p> \n                                                            </div>\n                                                           \n                                                            <div class="right">\n                                                               <span class="title">\n                                                                    Otra Eps\n                                                                </span>\n                                                                <p>\n                                                                   '+t+' \n                                                                </p> \n                                                            </div>\n                                                            \n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                map\n                                                            </i>\n                                                            <div class="left">\n                                                                <span class="title">\n                                                                   Dirección\n                                                                </span>\n                                                                <p>\n                                                                    '+(null!=a.data.user.direccion?a.data.user.direccion:"No registra")+'\n                                                                </p>\n                                                            </div>\n                                                            <div class="right">\n                                                                <span class="title">\n                                                                   Barrio\n                                                                </span>\n                                                                <p>\n                                                                    '+(null!=a.data.user.barrio||" "!=a.data.user.barrio?a.data.user.barrio:"No registra")+' \n                                                                </p>\n                                                            </div>\n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                email\n                                                            </i>\n                                                            <span class="title">\n                                                               Correo Electrónico\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.email?a.data.user.email:"No registra")+'\n                                                            </p>\n                                                        </li>\n                                                    </ul>\n                                                </div>\n                                                <div class="col s12 m6 l6">\n                                                    <ul class="collection">\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                assignment_ind\n                                                            </i>\n                                                            <span class="title">\n                                                                Documento\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.documento?a.data.user.documento:"No registra")+' \n                                                            </p>\n                                                            \n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                details\n                                                            </i>\n                                                            <span class="title">\n                                                                Grupo Sanguineo\n                                                            </span>\n                                                            <p>\n                                                               '+(null!=a.data.user.gruposanguineo.nombre?a.data.user.gruposanguineo.nombre:"No registra")+'   \n                                                            </p>\n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                credit_card\n                                                            </i>\n                                                            <span class="title">\n                                                                Deparamento Expedición documento de identidad\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.ciudadexpedicion.departamento.nombre?a.data.user.ciudadexpedicion.departamento.nombre:"No registra")+'\n                                                            </p>\n                                                            \n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                filter_6\n                                                            </i>\n                                                            <span class="title">\n                                                                Estrato Social\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.estrato?a.data.user.estrato:"No registra")+'                                                                    \n                                                            </p>\n                                                            \n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            <i class="material-icons circle teal darken-2">\n                                                                map\n                                                            </i>\n                                                            <span class="title">\n                                                                Lugar de Residencia\n                                                            </span>\n                                                            <p>\n                                                                '+(null!=a.data.user.ciudad.nombre&&null!=a.data.user.ciudad.departamento.nombre?a.data.user.ciudad.nombre+" - "+a.data.user.ciudad.departamento.nombre:"No registra")+'\n                                                            </p>\n                                                        </li>\n                                                        <li class="collection-item avatar">\n                                                            \n                                                            <div class="center">\n                                                                <span class="title">\n                                                                   Datos contacto\n                                                                </span>\n                                                            </div>\n                                                            <div class="left">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                phone\n                                                            </i>\n                                                                <p>\n                                                                    Telefono <br>\n                                                                    '+o+' \n                                                                </p>\n                                                            </div>\n                                                            <div class="right">\n                                                                <span class="title">\n                                                                   Celular\n                                                                </span>\n                                                                <p>\n                                                                    '+n+' \n                                                                </p>\n                                                            </div>\n                                                        </li>\n\n                                                    </ul>\n                                                </div>\n                                            </div>\n                                            <div class="right">\n                                                <small>\n                                                    Información Último Estudio\n                                                </small>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                            <div class="mailbox-text">\n                                                <div class="row">\n                                                    <div class="col s12 m6 l6">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    Institución\n                                                                </span>\n                                                                <p>\n                                                                    '+(null!=a.data.user.institucion?a.data.user.institucion:"No registra")+'\n                                                                </p>\n                                                            </li>\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    Titulo obtenido\n                                                                </span>\n                                                                <p>\n                                                                     '+(null!=a.data.user.titulo_obtenido?a.data.user.titulo_obtenido:"No registra")+'\n                                                                </p>\n                                                            </li>\n                                                        </ul>\n                                                    </div>\n                                                    <div class="col s12 m6 l6">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    Grado de escolaridad\n                                                                </span>\n                                                                <p>\n                                                                     '+(null!=a.data.user.gradoescolaridad.nombre?a.data.user.gradoescolaridad.nombre:"No registra")+'\n                                                                </p>\n                                                            </li>\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    Fecha de terminación\n                                                                </span>\n                                                                <p>\n                                                                     '+(null!=a.data.user.fecha_terminacion?moment(a.data.user.fecha_terminacion).format("LL"):"No registra")+'\n                                                                </p>\n                                                            </li>\n                                                        </ul>\n                                                    </div>\n                                                </div>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>'),null!=a.data.user.dinamizador&&$(".titulo_users").append('<div class="row">\n                 <div class="col s12 m12 l12">\n                    <div class="card mailbox-content">\n                        <div class="card-content">\n                            <div class="row no-m-t no-m-b">\n                    \n                                <div class="col s12 m12 l12">\n                                    \n                                    <div class="mailbox-view">\n                                        \n                                        <div class="mailbox-text">\n                                            \n                                            <div class="right">\n                                                <small>\n                                                    Información Dinamizador\n                                                </small>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                            <div class="mailbox-text">\n                                                <div class="row">\n                                                    <div class="col s12 m6 l6 offset-l3 m-3">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    Nodo\n                                                                </span>\n                                                                <p>\n                                                                    Tecnoparque nodo '+(null!=a.data.user.dinamizador.nodo.entidad.nombre?a.data.user.dinamizador.nodo.entidad.nombre:"No registra")+"\n                                                                    <br>\n                                                                        <small>\n                                                                            <b>Dirección:</b>\n                                                                            "+(null!=a.data.user.dinamizador.nodo.direccion?a.data.user.dinamizador.nodo.direccion:"No registra")+"\n                                                                        </small> \n                                                                    <br>\n                                                                </p>    \n                                                            </li>\n                                                           \n                                                        </ul>\n                                                    </div>\n                                                    \n                                                </div>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                 </div>"),a.data.user.gestor&&$(".titulo_users").append('<div class="row">\n                 <div class="col s12 m12 l12">\n                    <div class="card mailbox-content">\n                        <div class="card-content">\n                            <div class="row no-m-t no-m-b">\n                    \n                                <div class="col s12 m12 l12">\n                                    \n                                    <div class="mailbox-view">\n                                        \n                                        <div class="mailbox-text">\n                                            \n                                            <div class="right">\n                                                <small>\n                                                    Información Gestor\n                                                </small>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                            <div class="mailbox-text">\n                                                <div class="row">\n                                                    <div class="col s12 m8 l8 offset-l2 m-2">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    <b class="teal-text darken-2">\n                                                                        Nodo del Gestor:\n                                                                    </b>\n                                                                    Tecnoparque Nodo '+(null!=a.data.user.gestor.nodo.entidad.nombre?a.data.user.gestor.nodo.entidad.nombre:"No registra")+'\n                                                                    <br> \n                                                                    <b class="teal-text darken-2">\n                                                                        Linea del Gestor:\n                                                                    </b>\n                                                                     '+(null!=a.data.user.gestor.lineatecnologica.nombre?a.data.user.gestor.lineatecnologica.nombre:"No registra")+'\n                                                                    <br> \n                                                                    <b class="teal-text darken-2">\n                                                                        Honorario del Gestor:\n                                                                    </b>\n                                                                    $ '+(null!=a.data.user.gestor.honorarios?a.data.user.gestor.honorarios:null)+"\n                                                                </span>\n                                                                                                                                               \n                                                            </li>\n                                                           \n                                                        </ul>\n                                                    </div>\n                                                    \n                                                </div>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                 </div>"),a.data.user.infocenter&&$(".titulo_users").append('<div class="row">\n                 <div class="col s12 m12 l12">\n                    <div class="card mailbox-content">\n                        <div class="card-content">\n                            <div class="row no-m-t no-m-b">\n                    \n                                <div class="col s12 m12 l12">\n                                    \n                                    <div class="mailbox-view">\n                                        \n                                        <div class="mailbox-text">\n                                            \n                                            <div class="right">\n                                                <small>\n                                                    Información Infocenter\n                                                </small>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                            <div class="mailbox-text">\n                                                <div class="row">\n                                                    <div class="col s12 m8 l8 offset-l2 m-2">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    <b class="teal-text darken-2">\n                                                                        Nodo del Infocenter:\n                                                                    </b>\n                                                                    '+(null!=a.data.user.infocenter.nodo.entidad.nombre?"Tecnoparque Nodo "+a.data.user.infocenter.nodo.entidad.nombre:"No registra")+'\n                                                                    <br> \n                                                                    <b class="teal-text darken-2">\n                                                                        Extensión del Infocenter:\n                                                                    </b>\n                                                                     '+(null!=a.data.user.infocenter.extension?a.data.user.infocenter.extension:"No registra")+"\n                                                                    \n                                                                </span>\n                                                                                                                                               \n                                                            </li>\n                                                           \n                                                        </ul>\n                                                    </div>\n                                                    \n                                                </div>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                 </div>"),a.data.user.talento){let e=a.data.user.talento.entidad.nombre?a.data.user.talento.entidad.nombre:"NO REGISTRA",t=(a.data.user.talento.universidad&&a.data.user.talento.universidad,"Aprendiz SENA sin apoyo de sostenimiento"==a.data.user.talento.perfil.nombre?e:"Aprendiz SENA con apoyo de sostenimiento"==a.data.user.talento.perfil.nombre?e:"Egresado SENA"==a.data.user.talento.perfil.nombre?e:"Funcionario empresa púbilca"==a.data.user.talento.perfil.nombre?a.data.user.talento.empresa?a.data.user.talento.empresa:"NO REGISTRA":"Estudiante Universitario de Pregrado"==a.data.user.talento.perfil.nombre?a.data.user.talento.universidad?a.data.user.talento.universidad:"NO REGISTRA":"Estudiante Universitario de Postgrado"==a.data.user.talento.perfil.nombre?a.data.user.talento.universidad?a.data.user.talento.universidad:"NO REGISTRA":"Funcionario microempresa"==a.data.user.talento.perfil.nombre?a.data.user.talento.empresa?a.data.user.talento.empresa:"NO REGISTRA":"Funcionario mediana empresa"==a.data.user.talento.perfil.nombre?a.data.user.talento.empresa?a.data.user.talento.empresa:"NO REGISTRA":"Funcionario grande empresa"==a.data.user.talento.perfil.nombre?a.data.user.talento.empresa?a.data.user.talento.empresa:"NO REGISTRA":"Emprendedor independiente"==a.data.user.talento.perfil.nombre?"NO REGISTRA":"Investigador"==a.data.user.talento.perfil.nombre?e:"Otro"==a.data.user.talento.perfil.nombre&&a.data.user.talento.otro_tipo_talento?a.data.user.talento.otro_tipo_talento:"NO REGISTRA");$(".titulo_users").append('<div class="row">\n                 <div class="col s12 m12 l12">\n                    <div class="card mailbox-content">\n                        <div class="card-content">\n                            <div class="row no-m-t no-m-b">\n                    \n                                <div class="col s12 m12 l12">\n                                    \n                                    <div class="mailbox-view">\n                                        \n                                        <div class="mailbox-text">\n                                            \n                                            <div class="right">\n                                                <small>\n                                                    Información Talento\n                                                </small>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                            <div class="mailbox-text">\n                                                <div class="row">\n                                                    <div class="col s12 m12 l12">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <div class="row">\n                                                                    <div class="col s12 m6 l6">\n                                                                        <span class="title">\n                                                                            <b class="teal-text darken-2">\n                                                                                Perfil\n                                                                            </b>\n                                                                            <br>                                                                                        \n                                                                        </span>\n                                                                        <p>\n                                                                        '+(null!=a.data.user.talento.perfil.nombre?a.data.user.talento.perfil.nombre:null)+'\n                                                                        </p>\n                                                                    </div>\n                                                                    <div class="col s12 m6 l6">\n                                                                        <span class="title">\n                                                                            <b class="teal-text darken-2">\n                                                                                Entidad asociada\n                                                                            </b>\n                                                                        </span>\n                                                                        <p>\n                                                                         '+t+"\n                                                                        </p>\n                                                                    </div>\n                                                                </div>\n                                                                                                                                            \n                                                            </li>  \n                                                        </ul>\n                                                    </div>\n                                                    \n                                                    \n                                                </div>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                 </div>")}a.data.user.ingreso&&$(".titulo_users").append('<div class="row">\n                 <div class="col s12 m12 l12">\n                    <div class="card mailbox-content">\n                        <div class="card-content">\n                            <div class="row no-m-t no-m-b">\n                    \n                                <div class="col s12 m12 l12">\n                                    \n                                    <div class="mailbox-view">\n                                        \n                                        <div class="mailbox-text">\n                                            \n                                            <div class="right">\n                                                <small>\n                                                    Información Ingreso\n                                                </small>\n                                            </div>\n                                            <div class="divider mailbox-divider">\n                                            </div>\n                                            <div class="mailbox-text">\n                                                <div class="row">\n                                                    <div class="col s12 m6 l6 offset-l3 m-3">\n                                                        <ul class="collection">\n                                                            <li class="collection-item avatar">\n                                                                <i class="material-icons circle teal darken-2">\n                                                                    assignment_ind\n                                                                </i>\n                                                                <span class="title">\n                                                                    Nodo\n                                                                </span>\n                                                                <p>\n                                                                     '+(null!=a.data.user.ingreso.nodo.entidad.nombre?"Tecnoparque nodo"+a.data.user.ingreso.nodo.entidad.nombre:"No registra")+"\n                                                                    <br>\n                                                                        <small>\n                                                                            <b>Dirección:</b>\n                                                                            "+(null!=a.data.user.ingreso.nodo.direccion?a.data.user.ingreso.nodo.direccion:"No registra")+"\n                                                                        </small> \n                                                                    <br>\n                                                                </p>    \n                                                            </li>\n                                                           \n                                                        </ul>\n                                                    </div>\n                                                    \n                                                </div>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                 </div>"),$(".detalleUsers").openModal()}$(document).on("submit","form#formEditProfile",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");$.ajax({type:e.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){if($('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),a.fail){for(control in a.errors)$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();EditProfileUser.printErroresFormulario(a)}"error"==a.state&&(Swal.fire({title:"Tu perfil no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=a.url},1e3)),"success"==a.state&&(Swal.fire({title:"Modifciación Exitosa",text:"Tu perfil ha sido actualizado exitosamente.",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=a.url},1e3))}})});var EditProfileUser={printErroresFormulario:function(a){if("error_form"==a.state){let e="";for(control in a.errors)e+=" </br><b> - "+a.errors[control]+" </b> ",$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+e,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}},roleUserSession={setRoleSession:function(a){$(a).val();let e=$("#change-role option:selected").val();$.ajax({dataType:"json",type:"POST",data:{role:e,_token:$('meta[name="csrf-token"]').attr("content")},url:"/cambiar-role"}).done(function(a){null!=a.role&&(location.href=a.url)})}};function consultarArticulacionesDelGestor(a){$("#articulacionesGestor_table").dataTable().fnDestroy(),$("#articulacionesGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/articulacion/datatableArticulacionesDelGestor/0/"+a,data:function(a){a.codigo_articulacion=$("#codigo_articulacion_GestorTable").val(),a.gestor=$("#nombre_GestorAdministradorTable").val(),a.nombre=$("#nombre_GestorTable").val(),a.fase=$("#fase_GestorTable").val(),a.search=$('input[type="search"]').val()}},columns:[{data:"codigo_articulacion",name:"codigo_articulacion"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{data:"proceso",name:"proceso",orderable:!1}]})}function consultarGruposInvestigacion_FaseInicio_Articulaciones(){$("#gruposInvestigacion_articulacion_table").dataTable().fnDestroy(),$("#gruposInvestigacion_articulacion_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},select:!0,columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{width:"20%",data:"add_articulacion",name:"add_articulacion",orderable:!1}]}),$("#gruposDeInvestigacion_ArticulacionInicio_modal").openModal()}function addGrupoArticulacion(a){$.ajax({dataType:"json",type:"get",url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+a}).done(function(a){$("#txtgrupoInvestigacion").val(a.detalles.codigo_grupo+" - "+a.detalles.entidad.nombre),$("label[for='txtgrupoInvestigacion']").addClass("active"),$("#txtgrupo_id").val(a.detalles.id),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"success",title:"El código del grupo de investigación con el que se realizará la articulación es: "+a.detalles.codigo_grupo}),$("#gruposDeInvestigacion_ArticulacionInicio_modal").closeModal()})}function consultarTalentosDeTecnoparque_Articulacion_FaseInicio_table(a,e){$(a).dataTable().fnDestroy(),$(a).DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/usuario/talento/getTalentosDeTecnoparque/",type:"get"},columns:[{data:"documento",name:"documento"},{data:"talento",name:"talento"},{data:e,name:e,orderable:!1}]})}function ajaxSendFormArticulacion(a,e,t,o){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),"create"==o?mensajesArticulacionCreate(a):mensajesArticulacionUpdate(a)},error:function(a,e,t){alert("Error: "+t)}})}function mensajesArticulacionCreate(a){"registro"==a.state&&(Swal.fire({title:"Registro Exitoso",text:"La articulación ha sido registrada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulacion")},1e3)),"no_registro"==a.state&&Swal.fire({title:"La articulación no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesArticulacionUpdate(a){"update"==a.state&&(Swal.fire({title:"Modificación Exitosa",text:"La articulación ha sido modificada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulacion")},1e3)),"no_update"==a.state&&Swal.fire({title:"La articulación no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function talentoYaSeEncuentraAsociado_Articulacion(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El talento ya se encuentra asociado a la articulación!"})}function talentoSeAsocioALaArticulacion(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"El talento se ha asociado a la articulación!"})}function prepararFilaEnLaTablaDeTalentos_Articulacion(a){let e=a.talento.id;return'<tr class="selected" id=talentoAsociadoALaArticulacion'+e+'><td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+e+'" value="'+e+'" /><label for ="radioButton'+e+'"></label></td><td><input type="hidden" name="talentos[]" value="'+e+'">'+a.talento.documento+" - "+a.talento.talento+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeArticulacion_FaseInicio('+e+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function pintarTalentoEnTabla_Fase_Inicio_Articulacion(a){$.ajax({dataType:"json",type:"get",url:"/usuario/talento/consultarTalentoPorId/"+a}).done(function(a){let e=prepararFilaEnLaTablaDeTalentos_Articulacion(a);$("#detalleTalentosDeUnaArticulacion_Create").append(e),talentoSeAsocioALaArticulacion()})}function noRepeat_Articulacion(a){let e=a,t=!0,o=document.getElementsByName("talentos[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function eliminarTalentoDeArticulacion_FaseInicio(a){$("#talentoAsociadoALaArticulacion"+a).remove()}function addTalentoArticulacion(a){0==noRepeat_Articulacion(a)?talentoYaSeEncuentraAsociado_Articulacion():pintarTalentoEnTabla_Fase_Inicio_Articulacion(a)}function ajaxSendFormArticulacion_FaseCierre(a,e,t){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),mensajesArticulacionCierre(a)},error:function(a,e,t){alert("Error: "+t)}})}function mensajesArticulacionCierre(a){"update"==a.state&&(Swal.fire({title:"Modificación Exitosa!",text:"La articulación ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulacion")},1e3)),"no_update"==a.state&&Swal.fire({title:"La articulación no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function detallesDeUnaArticulacion(a){$.ajax({dataType:"json",type:"get",url:"/articulacion/ajaxDetallesDeUnArticulacion/"+a}).done(function(e){$("#articulacionDetalle_titulo").empty(),$("#detalleArticulacion").empty(),null==e.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):($("#articulacionDetalle_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaArticulacion/"+a+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='teal-text text-darken-3'>Código de la Articulación: </span><b>"+e.detalles.codigo_articulacion+"</b>"),$("#detalleArticulacion").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Nombre de la Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Gestor a cargo: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.gestor+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Fecha de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.fecha_inicio+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Estado de la Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.estado+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Observaciones: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.observaciones+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Tipo de Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.tipoArticulacion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Entregables: </span></div><div class="col s12 m6 l6"><span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaArticulacion('+e.detalles.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Revisado Final: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.revisado_final+'</span></div></div><div class="divider"></div>'),$("#articulacionDetalle").openModal())})}function preguntaReversarArticulacion(a){a.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar esta articulación a la fase de inicio?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(a=>{a.value&&document.frmReversarFaseArticulacion.submit()})}function verDetalleDeLaEntidadAsocidadALaArticulacion(a){$.ajax({dataType:"json",type:"get",url:"/articulacion/consultarEntidadDeLaArticulacion/"+a}).done(function(a){$("#detalleDeUnaArticulacion_titulo").empty(),$("#detalleArticulacion_body").empty(),null==a.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):"Empresa"==a.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nit de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nit+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_empresa+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Dirección de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.direccion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Email de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.email_entidad+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):"Grupo de Investigación"==a.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.codigo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.correo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.tipogrupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.institucion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_clasificacion+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):($("#talentosDeUnaArticulacion_titulo").empty(),$("#talentosDeUnaArticulacion_table").empty(),$("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>"),$.each(a.detalles,function(a,e){let t="Autor";1==e.talento_lider&&(t="Talento Líder"),$("#talentosDeUnaArticulacion_table").append("<tr><td>"+t+"</td><td>"+e.talento+"</td></tr>")}),$("#talentosDeUnaArticulacion_modal").openModal())})}function verDetallesDeLosEntregablesDeUnaArticulacion(a){$.ajax({dataType:"json",type:"get",url:"/articulacion/ajaxDetallesDeLosEntregablesDeUnaArticulacion/"+a}).done(function(a){$("#detalleDeUnaArticulacion_titulo").empty(),$("#detalleArticulacion_body").empty(),null==a.entregables?Swal.fire("Ups!!","Ha ocurrido un error","error"):($("#detalleDeUnaArticulacion_titulo").append("<a class='btn btn-small blue-grey' target='_blank' href='/articulacion/"+a.articulacion.id+"/entregables'>Ver los Archivos</a> <span class='teal-text text-darken-3'>Código de la Articulación: </span><b>"+a.articulacion.codigo_articulacion+"</b>"),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Acta de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.acta_inicio+'</span></div></div><div class="divider"></div>'),"Grupo de Investigación"==a.articulacion.tipo_articulacion&&$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Formato de confidencialidad y compromiso firmado: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.acc+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Actas de Seguimiento: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.actas_seguimiento+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Acta de Cierre: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.acta_cierre+'</span></div></div><div class="divider"></div>'),"Empresa"!=a.articulacion.tipo_articulacion&&"Emprendedor"!=a.articulacion.tipo_articulacion||$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Informe final de la asesoría: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.informe_final+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Encuesta de satisfacción: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.pantallazo+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Otros: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.otros+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_modal").openModal())})}function eliminarArticulacionPorId_event(a,e){Swal.fire({title:"¿Desea eliminar la articulación?",text:"Al hacer esto, todo lo relacionado con esta articulación será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(e=>{e.value&&eliminarArticulacionPorId_moment(a)})}function eliminarArticulacionPorId_moment(a){$.ajax({dataType:"json",type:"get",url:"/articulacion/eliminarArticulacion/"+a,success:function(a){a.retorno?(Swal.fire("Eliminación Exitosa!","La articulación se ha eliminado completamente!","success"),location.href="/articulacion"):Swal.fire("Eliminación Errónea!","La articulación no se ha eliminado!","error")},error:function(a,e,t){alert("Error: "+t)}})}function consultarIntervencionesEmpresaDelGestor(a){$("#IntervencionGestor_table").dataTable().fnDestroy(),$("#IntervencionGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/intervencion/datatableIntervencionEmpresaDelGestor/0/"+a,data:function(a){a.codigo_articulacion=$("#codigo_articulacion_GestorTable").val(),a.nombre=$("#nombre_GestorTable").val(),a.estado=$("#estado_GestorTable").val(),a.search=$('input[type="search"]').val()}},columns:[{data:"codigo_articulacion",name:"codigo_articulacion"},{data:"nombre",name:"nombre"},{data:"estado",name:"estado"},{data:"revisado_final",name:"revisado_final"},{data:"details",name:"details",orderable:!1},{data:"entregables",name:"entregables",orderable:!1},{data:"edit",name:"edit",orderable:!1}]})}function detallesDeUnaIntervencion(a){$.ajax({dataType:"json",type:"get",url:"/intervencion/ajaxDetallesDeUnaArticulacion/"+a}).done(function(e){$("#articulacionDetalle_titulo").empty(),$("#detalleArticulacion").empty(),null==e.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):($("#articulacionDetalle_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaArticulacion/"+a+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='teal-text text-darken-3'>Código de la Intervención: </span><b>"+e.detalles.codigo_articulacion+"</b>"),$("#detalleArticulacion").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Nombre de la Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Gestor a cargo: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.gestor+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Fecha de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.fecha_inicio+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Estado de la Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.estado+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Observaciones: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.observaciones+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Tipo de Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.tipoArticulacion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Entregables: </span></div><div class="col s12 m6 l6"><span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaIntervencionEmpresa('+e.detalles.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Revisado Final: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.revisado_final+'</span></div></div><div class="divider"></div>'),$("#articulacionDetalle").openModal())})}function verDetallesDeLosEntregablesDeUnaIntervencionEmpresa(a){$.ajax({dataType:"json",type:"get",url:"/articulacion/ajaxDetallesDeLosEntregablesDeUnaArticulacion/"+a}).done(function(a){$("#detalleDeUnaArticulacion_titulo").empty(),$("#detalleArticulacion_body").empty(),null==a.entregables?Swal.fire("Ups!!","Ha ocurrido un error","error"):($("#detalleDeUnaArticulacion_titulo").append("<a class='btn btn-small blue-grey' target='_blank' href='/intervencion/"+a.articulacion.id+"/entregables'>Ver los Archivos</a> <span class='teal-text text-darken-3'>Código de la Intervención a Empresa: </span><b>"+a.articulacion.codigo_articulacion+"</b>"),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Acta de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.acta_inicio+'</span></div></div><div class="divider"></div>'),"Grupo de Investigación"==a.articulacion.tipo_articulacion&&$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Formato de confidencialidad y compromiso firmado: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.acc+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Actas de Seguimiento: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.actas_seguimiento+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Acta de Cierre: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.acta_cierre+'</span></div></div><div class="divider"></div>'),"Empresa"!=a.articulacion.tipo_articulacion&&"Emprendedor"!=a.articulacion.tipo_articulacion||$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Informe final de la asesoría: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.informe_final+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Encuesta de satisfacción: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.pantallazo+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_body").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Otros: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.entregables.otros+'</span></div></div><div class="divider"></div>'),$("#detalleArticulacion_modal").openModal())})}function verDetalleDeLaEntidadAsocidadALaArticulacion(a){$.ajax({dataType:"json",type:"get",url:"/articulacion/consultarEntidadDeLaArticulacion/"+a}).done(function(a){$("#detalleDeUnaArticulacion_titulo").empty(),$("#detalleArticulacion_body").empty(),null==a.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):"Empresa"==a.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nit de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nit+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_empresa+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Dirección de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.direccion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Email de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.email_entidad+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):"Grupo de Investigación"==a.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.codigo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.correo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.tipogrupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.institucion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre_clasificacion+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):($("#talentosDeUnaArticulacion_titulo").empty(),$("#talentosDeUnaArticulacion_table").empty(),$("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>"),$.each(a.detalles,function(a,e){let t="Autor";1==e.talento_lider&&(t="Talento Líder"),$("#talentosDeUnaArticulacion_table").append("<tr><td>"+t+"</td><td>"+e.talento+"</td></tr>")}),$("#talentosDeUnaArticulacion_modal").openModal())})}function eliminarIntervencionEmpresaPorId_event(a,e){Swal.fire({title:"¿Desea eliminar la Intervención a Empresa?",text:"Al hacer esto, todo lo relacionado con esta Intervención a Empresa será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(e=>{e.value&&eliminarIntervencionEmpresaPorId_moment(a)})}function eliminarIntervencionEmpresaPorId_moment(a){$.ajax({dataType:"json",type:"get",url:"/intervencion/eliminarArticulacion/"+a,success:function(a){a.retorno?(Swal.fire("Eliminación Exitosa!","La Intervención a Empresa se ha eliminado completamente!","success"),location.href="/intervencion"):Swal.fire("Eliminación Errónea!","La Intervención a Empresa no se ha eliminado!","error")},error:function(a,e,t){alert("Error: "+t)}})}function consultarProyectosDeTalentos(){$("#tblProyectoDelTalento").dataTable().fnDestroy(),$("#tblProyectoDelTalento").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelTalento/",data:function(a){a.codigo_proyecto=$(".codigo_proyecto").val(),a.nombre=$(".nombre").val(),a.nombre_fase=$(".nombre_fase").val(),a.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"nombre_gestor",name:"nombre_gestor"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"8%",data:"proceso",name:"proceso",orderable:!1}]})}function verTalentosDeUnProyecto(a){$.ajax({dataType:"json",type:"get",url:"/proyecto/ajaxConsultarTalentosDeUnProyecto/"+a}).done(function(a){$("#talentosAsociadosAUnProyecto_table").empty(),0!=a.talentos.length?($("#talentosAsociadosAUnProyecto_titulo").empty(),$("#talentosAsociadosAUnProyecto_titulo").append("<span class='cyan-text text-darken-3'>Código de Proyecto: </span>"+a.proyecto),$.each(a.talentos,function(a,e){let t="",o=e.celular;"Talento Líder"==e.rol&&(t='<i class="material-icons green-text left">face</i>'),null==e.celular&&(o=""),$("#talentosAsociadosAUnProyecto_table").append("<tr><td>"+t+" "+e.rol+"</td><td>"+e.talento+"</td><td>"+e.email+"</td><td>"+o+"</td></tr>")}),$("#talentosAsociadosAUnProyecto_modal").openModal()):Swal.fire({title:"Ups!!",text:"No se encontraron talentos asociados a este proyecto!",type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})})}function consultarProyectosDelGestorPorAnho(){let a=$("#anho_proyectoPorAnhoGestorNodo").val();$("#tblproyectosGestorPorAnho").dataTable().fnDestroy(),$("#tblproyectosGestorPorAnho").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelGestorPorAnho/0/"+a,data:function(a){a.codigo_proyecto=$(".codigo_proyecto").val(),a.nombre=$(".nombre").val(),a.nombre_fase=$(".nombre_fase").val(),a.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"8%",data:"proceso",name:"proceso",orderable:!1}]})}function preguntaReversar(a){a.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar este proyecto a la fase de inicio?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(a=>{a.value&&document.frmReversarFase.submit()})}function consultarProyectosDelNodoPorAnho(){let a=$("#anho_proyectoPorNodoYAnho").val();$("#tblproyectosDelNodoPorAnho").dataTable().fnDestroy(),$("#tblproyectosDelNodoPorAnho").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelNodoPorAnho/0/"+a,data:function(a){a.codigo_proyecto=$("#codigo_proyecto_tblProyectosDelNodoPorAnho").val(),a.gestor=$("#gestor_tblProyectosDelNodoPorAnho").val(),a.nombre=$("#nombre_tblProyectosDelNodoPorAnho").val(),a.sublinea_nombre=$("#sublinea_nombre_tblProyectosDelNodoPorAnho").val(),a.nombre_fase=$("#fase_nombre_tblProyectosDelNodoPorAnho").val(),a.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"gestor",name:"gestor"},{data:"nombre",name:"nombre"},{data:"sublinea_nombre",name:"sublinea_nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"6%",data:"proceso",name:"proceso",orderable:!1}]})}function eliminarProyectoPorId_event(a,e){Swal.fire({title:"¿Desea eliminar el Proyecto?",text:"Al hacer esto, todo lo relacionado con este proyecto será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(e=>{e.value&&eliminarProyectoPorId_moment(a)})}function eliminarProyectoPorId_moment(a){$.ajax({dataType:"json",type:"get",url:"/proyecto/eliminarProyecto/"+a,success:function(a){a.retorno?(Swal.fire("Eliminación Exitosa!","El proyecto se ha eliminado completamente!","success"),location.href="/proyecto"):Swal.fire("Eliminación Errónea!","El proyecto no se ha eliminado!","error")},error:function(a,e,t){alert("Error: "+t)}})}$(document).ready(function(){$("#sublineas_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/sublineas",type:"get"},columns:[{data:"nombre",name:"nombre"},{data:"linea",name:"linea"},{data:"edit",name:"edit",orderable:!1}]})}),$("#codigo_articulacion_GestorTable").keyup(function(){$("#articulacionesGestor_table").DataTable().draw()}),$("#nombre_GestorTable").keyup(function(){$("#articulacionesGestor_table").DataTable().draw()}),$("#fase_GestorTable").keyup(function(){$("#articulacionesGestor_table").DataTable().draw()}),$(document).on("submit","form#frmArticulaciones_FaseInicio_Update",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");ajaxSendFormArticulacion(e,t,o,"update")}),$(document).on("submit","form#frmArticulacion_FaseInicio",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");ajaxSendFormArticulacion(e,t,o,"create")}),$(document).on("submit","form#frmArticulaciones_FaseCierre_Update",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");ajaxSendFormArticulacion_FaseCierre(e,t,o)}),$("#codigo_articulacion_GestorTable").keyup(function(){$("#IntervencionGestor_table").DataTable().draw()}),$("#nombre_GestorTable").keyup(function(){$("#IntervencionGestor_table").DataTable().draw()}),$("#estado_GestorTable").keyup(function(){$("#IntervencionGestor_table").DataTable().draw()}),$(document).ready(function(){consultarProyectosDelGestorPorAnho(),consultarProyectosDelNodoPorAnho()}),$(".codigo_proyecto").keyup(function(){$("#tblproyectosGestorPorAnho").DataTable().draw()}),$(".nombre").keyup(function(){$("#tblproyectosGestorPorAnho").DataTable().draw()}),$(".nombre_fase").keyup(function(){$("#tblproyectosGestorPorAnho").DataTable().draw()}),$("#codigo_proyecto_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#gestor_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#nombre_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#sublinea_nombre_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#fase_nombre_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()});var infoActividad={infoDetailActivityModal:function(a){"string"==typeof a&&$.ajax({dataType:"json",type:"get",url:"/actividad/detalle/"+a}).done(function(a){$("#actividad_titulo").empty(),$("#detalleActividad").empty(),$("#actividad_titulo").append("<span class='cyan-text text-darken-3'>"+a.data.actividad.codigo_actividad+" - "+a.data.actividad.nombre+" </span><br>"),null!==a.data.actividad.articulacion_proyecto.proyecto?infoActividad.openIsProyect(a):null!==a.data.actividad.articulacion_proyecto.articulacion&&infoActividad.openIsArticulacion(a),$("#info_actividad_modal").openModal()})},openIsProyect:function(a){$("#detalleActividad").append(`\n            <table class="striped centered">\n                <TR>\n                    <TH width="25%">Código Proyecto</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(a.data.actividad.codigo_actividad)}</TD>\n                    <TH width="25%" >Nombre Proyecto</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(a.data.actividad.nombre)}</TD>\n                </TR>\n                <TR>\n                    <TH width="25%">Gestor</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(a.data.actividad.gestor.user.documento)} - ${a.data.actividad.gestor.user.nombres} ${a.data.actividad.gestor.user.apellidos}</TD>\n                    <TH width="25%">Correo Electrónico</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(a.data.actividad.gestor.user.email)}</TD>\n                </TR>\n            </table>\n            <div class="right">\n                <small>\n                    <b>Cantidad de usos de infraestructura:  </b>\n                    ${infoActividad.showInfoNull(a.data.total_usos)}\n                </small>\n            </div>\n            <div class="divider mailbox-divider"></div>\n            <div class="center">\n                <span class="mailbox-title">\n                    <i class="material-icons">group</i>\n                    Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.\n                </span>\n            </div>\n            <div class="divider mailbox-divider"></div>\n                <div class="row">\n                <div class="col s12 m12 l12">\n                        <div class="card-panel blue lighten-5">\n                            <h5 class="center">Talentos que participan en el proyecto</h5>\n                            <table>\n                                <thead>\n                                    <tr>\n                                        <th style="width: 10%">Talento Interlocutor</th>\n                                        <th style="width: 40%">Talento</th>\n                                        <th style="width: 20%">Correo</th>\n                                        <th style="width: 15%">Telefono</th>\n                                        <th style="width: 15%">Celular</th>\n                                    </tr>\n                                </thead>\n                                <tbody id="detalleTalentos">\n                                </tbody>\n                            </table>\n                        </div>\n                    </div>\n                </div>\n                <div class="row">\n                    <div class="card-panel green lighten-5 col s12 m12 l12">\n                        <h5 class="center">Dueño(s) de la propiedad intelectual</h5>\n                        <div class="row">\n                            <div class="col s12 m4 l4">\n                                <div class="card-panel">\n                                    <ul class="collection with-header">\n                                        <li class="collection-header"><h5>Empresas</h5></li>\n                                        <div id="detalleEmpresas"></div>\n                                    </ul>\n                                </div>\n                            </div>\n                            <div class="col s12 m4 l4">\n                                <div class="card-panel">\n                                    <ul class="collection with-header">\n                                        <li class="collection-header"><h5>Personas (Talentos)</h5></li>\n                                        <div id="detallePropiedadTalentos"></div>\n                                    </ul>\n                                </div>\n                            </div>\n                            <div class="col s12 m4 l4">\n                                <div class="card-panel">\n                                    <ul class="collection with-header">\n                                        <li class="collection-header"><h5>Grupos de Investigación</h5></li>\n                                        <div id="detallePropiedadGrupo"></div>\n\n                                    </ul>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>`),infoActividad.showTalentos(a.data.actividad.articulacion_proyecto.talentos),infoActividad.showPropiedadIntelectualEmpresas(a.data.actividad.articulacion_proyecto.proyecto.empresas),infoActividad.showPropiedadIntelectualTalentos(a.data.actividad.articulacion_proyecto.proyecto.users_propietarios),infoActividad.showPropiedadIntelectualGrupo(a.data.actividad.articulacion_proyecto.proyecto.gruposinvestigacion)},openIsArticulacion:function(a){$("#detalleActividad").append(`\n            <table class="striped centered">\n                <TR>\n                    <TH width="25%">Código Articulación</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(a.data.actividad.codigo_actividad)}</TD>\n                    <TH width="25%" >Nombre de Articulación</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(a.data.actividad.nombre)}</TD>\n                </TR>\n                <TR>\n                    <TH width="25%">Gestor</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(a.data.actividad.gestor.user.documento)} - ${a.data.actividad.gestor.user.nombres} ${a.data.actividad.gestor.user.apellidos}</TD>\n                    <TH width="25%">Correo Electrónico</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(a.data.actividad.gestor.user.email)}</TD>\n                </TR>\n            </table>\n            <div class="right">\n                <small>\n                    <b>Cantidad de usos de infraestructura:  </b>\n                    ${infoActividad.showInfoNull(a.data.total_usos)}\n                </small>\n            </div>\n            <div class="divider mailbox-divider"></div>\n            <div class="center">\n                <span class="mailbox-title">\n                    <i class="material-icons">group</i>\n                    Talentos que participan en la articulación.\n                </span>\n            </div>\n            <div class="divider mailbox-divider"></div>\n                <div class="row">\n                <div class="col s12 m12 l12">\n                        <div class="card-panel blue lighten-5">\n                            <h5 class="center">Talentos que participan en la Articulación</h5>\n                            <table>\n                                <thead>\n                                    <tr>\n                                        <th style="width: 10%">Talento Interlocutor</th>\n                                        <th style="width: 40%">Talento</th>\n                                        <th style="width: 20%">Correo</th>\n                                        <th style="width: 15%">Telefono</th>\n                                        <th style="width: 15%">Celular</th>\n                                    </tr>\n                                </thead>\n                                <tbody id="detalleTalentos">\n                                </tbody>\n                            </table>\n                        </div>\n                    </div>\n                </div>`),infoActividad.showTalentos(a.data.actividad.articulacion_proyecto.talentos)},showDateActivity:function(a){return null===a||""===a?"El proceso no se ha cerrado":a},showInfoNull:function(a){return null===a||""===a?"No se encontraron resultados":a},validateDataIsTRL:function(a){return 0==a?"TRL 6":"TRL 7 - TRL 8"},validateDataIsBoolean:function(a){return 0==a?"NO":"SI"},dataPerteneceEconomiaNaranja:function(a){return 0==a.economia_naranja?"NO":1==a.economia_naranja?" SI ("+a.tipo_economianaranja+")":""},dataDirigidoDiscapacitados:function(a){return 0==a.dirigido_discapacitados?"NO":1==a.dirigido_discapacitados?"SI ("+a.tipo_discapacitados+")":""},dataArticuladaCTI:function(a){return 0==a.art_cti?"NO":1==a.art_cti?" SI ("+a.nom_act_cti+")":""},showTalentos:function(a){let e="";e=a.length>0?a.map(function(a){return`<tr class="selected">\n                            <td> ${infoActividad.validateDataIsBoolean(a.pivot.talento_lider)}</td>\n                            <td>${infoActividad.showInfoNull(a.user.documento)} - ${infoActividad.showInfoNull(a.user.nombres)} ${infoActividad.showInfoNull(a.user.apellidos)}</td>\n                            <td>${infoActividad.showInfoNull(a.user.email)}</td>\n                            <td>${infoActividad.showInfoNull(a.user.telefono)}</td>\n                            <td>${infoActividad.showInfoNull(a.user.celular)}</td>\n                        </tr>`}):'<tr class="selected">\n                        <td COLSPAN=4>No se encontraron resultados</td>\n                        <td></td>\n                        <td></td>\n                        <td></td>\n                        <td></td>\n                    </tr>',document.getElementById("detalleTalentos").innerHTML=e},showPropiedadIntelectualEmpresas:function(a){let e="";e=a.length>0?a.map(function(a){return`\n                        <li class="collection-item">\n                        ${infoActividad.showInfoNull(a.nit)} - ${infoActividad.showInfoNull(a.entidad.nombre)}\n                        </li>`}):'<li class="collection-item">\n                    No se han encontrado empresas dueña(s) de la propiedad intelectual.\n                </li>',document.getElementById("detalleEmpresas").innerHTML=e},showPropiedadIntelectualTalentos:function(a){let e="";e=a.length>0?a.map(function(a){return`<li class="collection-item">\n                        ${infoActividad.showInfoNull(a.documento)} - ${infoActividad.showInfoNull(a.nombres)} ${infoActividad.showInfoNull(a.apellidos)}\n                        </li>`}):'<li class="collection-item">\n                    No se han encontrado talento(s) dueño(s) de la propiedad intelectual.\n                </li>',document.getElementById("detallePropiedadTalentos").innerHTML=e},showPropiedadIntelectualGrupo:function(a){let e="";e=a.length>0?a.map(function(a){return`<li class="collection-item">\n                        ${infoActividad.showInfoNull(a.codigo_grupo)} - ${infoActividad.showInfoNull(a.entidad.nombre)}\n                        </li>`}):'<li class="collection-item">\n            No se han encontrado grupo(s) de investigación dueño(s) de la propiedad intelectual.\n                </li>',document.getElementById("detallePropiedadGrupo").innerHTML=e}};function ajaxSendFormProyecto(a,e,t,o){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),"create"==o?mensajesProyectoCreate(a):mensajesProyectoUpdate(a)},error:function(a,e,t){alert("Error: "+t)}})}function mensajesProyectoCreate(a){"registro"==a.state&&(Swal.fire({title:"Registro Exitoso",text:"El proyecto ha sido registrado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/proyecto")},1e3)),"no_registro"==a.state&&Swal.fire({title:"El proyecto no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesProyectoUpdate(a){"update"==a.state&&(Swal.fire({title:"Modificación Exitosa",text:"El proyecto ha sido registrado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/proyecto")},1e3)),"no_update"==a.state&&Swal.fire({title:"El proyecto no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function talentoYaSeEncuentraAsociado(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El talento ya se encuentra asociado al proyecto!"})}function usuarioYaSeEncuentraAsociado_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El usuario ya se encuentra asociado como dueño de la propiedad intelectual!"})}function empresaYaSeEncuentraAsociado_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"Esta empresa ya se encuentra asociada como dueño de la propiedad intelectual!"})}function talentoSeAsocioAlProyecto(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"El talento se ha asociado al proyecto!"})}function empresaSeAsocioAlProyecto_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La empresa se ha asociado como dueño de la propiedad intelectual!"})}function grupoSeAsocioAlProyecto_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"El grupo de investigación se ha asociado como dueño de la propiedad intelectual!"})}function ideaProyectoAsociadaConExito(a,e){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La siguiente idea se ha asociado al proyecto: "+a+" - "+e})}function prepararFilaEnLaTablaDeTalentos(a){let e=a.talento.id;return'<tr class="selected" id=talentoAsociadoAProyecto'+e+'><td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+e+'" value="'+e+'" /><label for ="radioButton'+e+'"></label></td><td><input type="hidden" name="talentos[]" value="'+e+'">'+a.talento.documento+" - "+a.talento.talento+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio('+e+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDePropietarios_Users(a){let e=a.user.id;return'<tr class="selected" id=propietarioAsociadoAlProyecto_Persona'+e+'><td><input type="hidden" name="propietarios_user[]" value="'+e+'">'+a.user.documento+" - "+a.user.nombres+" "+a.user.apellidos+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona('+e+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDePropietarios_Empresa(a){let e=a.detalles.id;return'<tr class="selected" id=propietarioAsociadoAlProyecto_Empresa'+e+'><td><input type="hidden" name="propietarios_empresas[]" value="'+e+'">'+a.detalles.nit+" - "+a.detalles.nombre_empresa+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa('+e+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDePropietarios_Grupos(a){let e=a.detalles.id;return'<tr class="selected" id=propietarioAsociadoAlProyecto_Grupo'+e+'><td><input type="hidden" name="propietarios_grupos[]" value="'+e+'">'+a.detalles.codigo_grupo+" - "+a.detalles.entidad.nombre+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo('+e+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function pintarTalentoEnTabla_Fase_Inicio(a){$.ajax({dataType:"json",type:"get",url:"/usuario/talento/consultarTalentoPorId/"+a}).done(function(a){let e=prepararFilaEnLaTablaDeTalentos(a);$("#detalleTalentosDeUnProyecto_Create").append(e),talentoSeAsocioAlProyecto()})}function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(a){$.ajax({dataType:"json",type:"get",url:"/usuario/consultarUserPorId/"+a}).done(function(a){let e=prepararFilaEnLaTablaDePropietarios_Users(a);$("#propiedadIntelectual_Personas").append(e),talentoSeAsocioAlProyecto()})}function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Empresa(a){$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetallesDeUnaEmpresa/"+a}).done(function(a){let e=prepararFilaEnLaTablaDePropietarios_Empresa(a);$("#propiedadIntelectual_Empresas").append(e),empresaSeAsocioAlProyecto_Propietario()})}function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(a){$.ajax({dataType:"json",type:"get",url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+a}).done(function(a){let e=prepararFilaEnLaTablaDePropietarios_Grupos(a);$("#propiedadIntelectual_Grupos").append(e),grupoSeAsocioAlProyecto_Propietario()})}function noRepeat(a){let e=a,t=!0,o=document.getElementsByName("talentos[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function noRepeat_Propiedad(a){let e=a,t=!0,o=document.getElementsByName("propietarios_user[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function noRepeat_Empresa(a){let e=a,t=!0,o=document.getElementsByName("propietarios_empresas[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function noRepeat_Grupo(a){let e=a,t=!0,o=document.getElementsByName("propietarios_grupos[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function eliminarTalentoDeProyecto_FaseInicio(a){$("#talentoAsociadoAProyecto"+a).remove()}function eliminarPropietarioDeUnProyecto_FaseInicio_Persona(a){$("#propietarioAsociadoAlProyecto_Persona"+a).remove()}function eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(a){$("#propietarioAsociadoAlProyecto_Empresa"+a).remove()}function eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(a){$("#propietarioAsociadoAlProyecto_Grupo"+a).remove()}function addTalentoProyecto(a){0==noRepeat(a)?talentoYaSeEncuentraAsociado():pintarTalentoEnTabla_Fase_Inicio(a)}function addPersonaPropiedad(a){0==noRepeat_Propiedad(a)?usuarioYaSeEncuentraAsociado_Propietario():pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(a)}function addEntidadEmpresa(a){0==noRepeat_Empresa(a)?empresaYaSeEncuentraAsociado_Propietario():pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Empresa(a)}function addGrupoPropietario(a){0==noRepeat_Grupo(a)?empresaYaSeEncuentraAsociado_Propietario():pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(a)}function asociarIdeaDeProyectoAProyecto(a,e,t){$("#txtidea_id").val(a),$("#ideasDeProyectoConEmprendedores_modal").closeModal(),ideaProyectoAsociadaConExito(t,e),$("#txtnombreIdeaProyecto_Proyecto").val(t+" - "+e),$("#txtnombre").val(e),$("label[for='txtnombreIdeaProyecto_Proyecto']").addClass("active"),$("label[for='txtnombre']").addClass("active")}function consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio(){$("#ideasDeProyectoConEmprendedores_proyecto_table").dataTable().fnDestroy(),$("#ideasDeProyectoConEmprendedores_proyecto_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/proyecto/datatableIdeasConEmprendedores",type:"get"},select:!0,columns:[{data:"codigo_idea",name:"codigo_idea"},{data:"nombre_proyecto",name:"nombre_proyecto"},{data:"nombres_contacto",name:"nombres_contacto"},{width:"20%",data:"checkbox",name:"checkbox",orderable:!1}]}),$("#ideasDeProyectoConEmprendedores_modal").openModal({dismissible:!1})}function consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table(){$("#posiblesPropietarios_Empresas_table").dataTable().fnDestroy(),$("#posiblesPropietarios_Empresas_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"add_propietario",name:"add_propietario",orderable:!1}]}),$("#posiblesPropietarios_Empresas_modal").openModal()}function consultarGruposDeTecnoparque_Proyecto_FaseInicio_table(){$("#posiblesPropietarios_Grupos_table").dataTable().fnDestroy(),$("#posiblesPropietarios_Grupos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{data:"add_propietario",name:"add_propietario",orderable:!1}]}),$("#posiblesPropietarios_Grupos_modal").openModal()}function consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table(a,e){$(a).dataTable().fnDestroy(),$(a).DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/usuario/talento/getTalentosDeTecnoparque/",type:"get"},columns:[{data:"documento",name:"documento"},{data:"talento",name:"talento"},{data:e,name:e,orderable:!1}]}),"#posiblesPropietarios_Personas_table"==a&&$("#posiblesPropietarios_Personas_modal").openModal()}function selectAreaConocimiento_Proyecto_FaseInicio(){let a=$("#txtareaconocimiento_id").val();"Otro"==$("#txtareaconocimiento_id [value='"+a+"']").text()?divOtroAreaConocmiento.show():divOtroAreaConocmiento.hide()}function showInput_EconomiaNaranja(){$("#txteconomia_naranja").is(":checked")?divEconomiaNaranja.show():divEconomiaNaranja.hide()}function showInput_Discapacidad(){$("#txtdirigido_discapacitados").is(":checked")?divDiscapacidad.show():divDiscapacidad.hide()}function showInput_ActorCTi(){$("#txtarti_cti").is(":checked")?divNombreActorCTi.show():divNombreActorCTi.hide()}function ajaxSendFormProyecto_FaseCierre(a,e,t){$.ajax({type:a.attr("method"),url:t,data:e,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(a){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(a),mensajesProyectoCierre(a)},error:function(a,e,t){alert("Error: "+t)}})}function printErroresFormulario(a){if("error_form"==a.state){let e="";for(control in a.errors)e+=" </br><b> - "+a.errors[control]+" </b> ",$("#"+control+"-error").html(a.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+e,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}function mensajesProyectoCierre(a){"update"==a.state&&(Swal.fire({title:"Modificación Exitosa!",text:"El proyecto ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/proyecto")},1e3)),"no_update"==a.state&&Swal.fire({title:"El proyecto no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function actiarFechaFinDeLaEdt(){$("#txtestado").is(":checked")?divFechaCierreEdt.show():divFechaCierreEdt.hide()}function noRepeat(a){let e=a,t=!0,o=document.getElementsByName("entidades[]");for(x=0;x<o.length;x++)if(o[x].value==e){t=!1;break}return t}function addEmpresaAEdt(a){0==noRepeat(a)?Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"La empresa ya se encuentra asociada a la edt!"}):$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxConsultarEmpresaPorIdEntidad/"+a}).done(function(a){let e=a.detalles.entidad_id,t='<tr class="selected" id=entidadAsociadaAEdt'+e+'><td><input type="hidden" name="entidades[]" value="'+e+'">'+a.detalles.nit+"</td><td>"+a.detalles.nombre+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarEntidadAsociadaAEdt('+e+');"><i class="material-icons">delete_sweep</i></a></td></tr>';$("#detalleEntidadesAsociadasAEdt").append(t),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La empresa se ha asociado a la edt!"})})}function eliminarEntidadAsociadaAEdt(a){$("#entidadAsociadaAEdt"+a).remove(),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"Se ha removido la empresa de la edt!"})}function consultarEdtsDeUnGestor(a){let e=$("#txtanho_edts_Gestor").val();$("#edtPorGestor_table").dataTable().fnDestroy(),$("#edtPorGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/edt/consultarEdtsDeUnGestor/"+a+"/"+e,type:"get"},columns:[{width:"10%",data:"codigo_edt",name:"codigo_edt"},{width:"15%",data:"nombre",name:"nombre"},{width:"15%",data:"gestor",name:"gestor"},{width:"6%",data:"area_conocimiento",name:"area_conocimiento"},{width:"6%",data:"tipo_edt",name:"tipo_edt"},{data:"fecha_inicio",name:"fecha_inicio"},{data:"estado",name:"estado"},{width:"6%",data:"business",name:"business",orderable:!1},{width:"6%",data:"details",name:"details",orderable:!1},{width:"6%",data:"edit",name:"edit",orderable:!1},{width:"6%",data:"entregables",name:"entregables",orderable:!1}]})}function eliminarEdtPorId_event(a,e){Swal.fire({title:"¿Desea eliminar la edt?",text:"Al hacer esto, todo lo relacionado con esta edt será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(e=>{e.value&&eliminarEdtPorId_moment(a)})}function eliminarEdtPorId_moment(a){$.ajax({dataType:"json",type:"get",url:"/edt/eliminarEdt/"+a,success:function(a){a.retorno?(Swal.fire("Eliminación Exitosa!","La edt se ha eliminado completamente!","success"),location.href="/edt"):Swal.fire("Eliminación Errónea!","La edt no se ha eliminado!","error")},error:function(a,e,t){alert("Error: "+t)}})}function datatableEdtsPorNodo(a){let e=$("#txtanho_edts_Nodo").val();$("#edtPorNodo_table").dataTable().fnDestroy(),$("#edtPorNodo_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/edt/consultarEdtsDeUnNodo/"+a+"/"+e,type:"get"},columns:[{width:"10%",data:"codigo_edt",name:"codigo_edt"},{width:"15%",data:"nombre",name:"nombre"},{width:"15%",data:"gestor",name:"gestor"},{width:"6%",data:"area_conocimiento",name:"area_conocimiento"},{width:"6%",data:"tipo_edt",name:"tipo_edt"},{width:"8%",data:"fecha_inicio",name:"fecha_inicio"},{width:"8%",data:"estado",name:"estado"},{width:"5%",data:"business",name:"business",orderable:!1},{width:"5%",data:"details",name:"details",orderable:!1},{width:"5%",data:"entregables",name:"entregables",orderable:!1},{width:"5%",data:"edit",name:"edit",orderable:!1},{width:"5%",data:"delete",name:"delete",orderable:!1}]})}function verEntidadesDeUnaEdt(a){$.ajax({dataType:"json",type:"get",url:"/edt/consultarDetallesDeUnaEdt/"+a+"/1",success:function(a){$("#entidadesEdt_table").empty(),0!=a.entidades.length?($("#entidadesEdt_titulo").empty(),$("#entidadesEdt_titulo").append("<span class='cyan-text text-darken-3'>Código de la Edt: </span>"+a.edt.codigo_edt),$.each(a.entidades,function(a,e){$("#entidadesEdt_table").append("<tr><td>"+e.nit+"</td><td>"+e.nombre+"</td></tr>")}),$("#entidadesEdt_modal").openModal()):Swal.fire({title:"Ups!!",text:"No se encontraron empresas asociadas a esta Edt!",type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})},error:function(a,e,t){alert("Error: "+t)}})}function detallesDeUnaEdt(a){$.ajax({dataType:"json",type:"get",url:"/edt/consultarDetallesDeUnaEdt/"+a+"/0",success:function(e){$("#detalleEdt_titulo").empty(),$("#detalleEdt_detalle").empty();let t="";t="Inactiva"==e.edt.estado?e.edt.fecha_cierre:"La Edt aún se encuentra activa!",$("#detalleEdt_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaEdt/"+a+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='cyan-text text-darken-3'>Código de la Edt: </span>"+e.edt.codigo_edt),$("#detalleEdt_detalle").append('<div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código de la Edt: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.codigo_edt+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Edt: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Área de Conocimiento: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.areaconocimiento+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Edt: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.tipoedt+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Fecha de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.fecha_inicio+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Fecha de Cierre: </span></div><div class="col s12 m6 l6"><span class="black-text">'+t+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m12 l12"><h6 class="cyan-text text-darken-3 center">Asistentes</h6></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Empleados: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.empleados+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Instructores: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.instructores+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Aprendices: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.aprendices+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Público: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.publico+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Observaciones: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.edt.observaciones+'</span></div></div><div class="divider"></div>'),$("#detalleEdt_modal").openModal()},error:function(a,e,t){alert("Error: "+t)}})}$(document).ready(function(){divOtroAreaConocmiento=$("#otroAreaConocimiento_content"),divEconomiaNaranja=$("#economiaNaranja_content"),divDiscapacidad=$("#discapacidad_content"),divNombreActorCTi=$("#nombreActorCTi_content"),divOtroAreaConocmiento.hide(),divEconomiaNaranja.hide(),divDiscapacidad.hide(),divNombreActorCTi.hide()}),$(document).on("submit","form#frmProyectos_FaseInicio",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");ajaxSendFormProyecto(e,t,o,"create")}),$(document).on("submit","form#frmProyectos_FaseInicio_Update",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");ajaxSendFormProyecto(e,t,o,"update")}),$(document).on("submit","form#frmProyectos_FaseCierre_Update",function(a){$('button[type="submit"]').attr("disabled","disabled"),a.preventDefault();var e=$(this),t=new FormData($(this)[0]),o=e.attr("action");ajaxSendFormProyecto_FaseCierre(e,t,o)}),$(document).ready(function(){$("#empresasDeTecnoparque_modEdt_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthMenu:[[5,25,50,-1],[5,25,50,"All"]],processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},deferRender:!0,columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"add_empresa_a_edt",name:"add_empresa_a_edt"}]})}),divFechaCierreEdt=$("#divFechaCierreEdt"),divFechaCierreEdt.hide(),$(document).ready(function(){consultarEdtsDeUnGestor(0)}),$(document).ready(function(){datatableEdtsPorNodo(0)}),$(document).ready(function(){$("#laboratorio_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var selectLaboratorioNodo={selectLaboraotrioForNodo:function(){let a=$("#selectnodo").val();$("#laboratorio_administrador_table").dataTable().fnDestroy(),""!=a?$("#laboratorio_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/laboratorio/nodo/"+a,type:"get"},dom:"Bfrtip",buttons:[],columns:[{data:"nombre",name:"nombre",width:"30%"},{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"participacion_costos",name:"participacion_costos",width:"15%"},{data:"estado",name:"estado",width:"10%"},{data:"materiales",name:"materiales",orderable:!1,width:"8%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}]}):$("#laboratorio_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()}};$(document).ready(function(){$("#laboratorio_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/laboratorio",type:"get"},columns:[{data:"nombre",name:"nombre",width:"30%"},{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"participacion_costos",name:"participacion_costos",width:"15%"},{data:"estado",name:"estado",width:"10%"},{data:"materiales",name:"materiales",orderable:!1,width:"8%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}]})}),$(document).ready(function(){$("#costoadministrativo_dinamizador_table1").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,ajax:{url:"/costos-administrativos",type:"get"},columns:[{data:"entidad",name:"entidad",width:"30%"},{data:"costoadministrativo",name:"costoadministrativo",width:"30%"},{data:"valor",name:"valor",width:"15%"},{data:"costosadministrativospordia",name:"costosadministrativospordia",width:"15%"},{data:"costosadministrativosporhora",name:"costosadministrativosporhora",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}],footerCallback:function(a,e,t,o,n){var i=this.api(),s=function(a){return"string"==typeof a?1*a.replace(/[\$,]/g,""):"number"==typeof a?a:0};totalCostosHora=i.column(4).data().reduce(function(a,e){return s(a)+s(e)},0),totalCostosDia=i.column(3).data().reduce(function(a,e){return s(a)+s(e)},0),totalCostosMes=i.column(2).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosHora=i.column(4,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosDia=i.column(3,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosMes=i.column(2,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),$(i.column(4).footer()).html("$ "+pageTotalCostosHora+" ( $"+totalCostosHora+" total)"),$(i.column(3).footer()).html("$ "+pageTotalCostosDia+" ( $"+totalCostosDia+" total)"),$(i.column(2).footer()).html("$ "+pageTotalCostosMes+" ( $"+totalCostosMes+" total)")}})}),$(document).ready(function(){$("#costoadministrativo_dinamizador_table1").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,ajax:{url:"/costos-administrativos",type:"get"},columns:[{data:"entidad",name:"entidad",width:"30%"},{data:"costoadministrativo",name:"costoadministrativo",width:"30%"},{data:"valor",name:"valor",width:"15%"},{data:"costosadministrativospordia",name:"costosadministrativospordia",width:"15%"},{data:"costosadministrativosporhora",name:"costosadministrativosporhora",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}],footerCallback:function(a,e,t,o,n){var i=this.api(),s=function(a){return"string"==typeof a?1*a.replace(/[\$,]/g,""):"number"==typeof a?a:0};totalCostosHora=i.column(4).data().reduce(function(a,e){return s(a)+s(e)},0),totalCostosDia=i.column(3).data().reduce(function(a,e){return s(a)+s(e)},0),totalCostosMes=i.column(2).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosHora=i.column(4,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosDia=i.column(3,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosMes=i.column(2,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),$(i.column(4).footer()).html("$ "+pageTotalCostosHora+" ( $"+totalCostosHora+" total)"),$(i.column(3).footer()).html("$ "+pageTotalCostosDia+" ( $"+totalCostosDia+" total)"),$(i.column(2).footer()).html("$ "+pageTotalCostosMes+" ( $"+totalCostosMes+" total)")}})}),$(document).ready(function(){$("#equipos_de_tecnoparque_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers",lengthChange:!1})});var selectEquipoPorNodo={selectEquipoForNodo:function(){let a=$("#selectnodo").val();$("#equipos_de_tecnoparque_administrador_table").dataTable().fnDestroy(),""!=a?$("#equipos_de_tecnoparque_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/equipos/getequipospornodo/"+a,type:"get"},columns:[{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"referencia",name:"referencia",width:"15%"},{data:"marca",name:"marca",width:"15%"},{data:"costo_adquisicion",name:"costo_adquisicion",width:"15%"},{data:"vida_util",name:"vida_util",width:"15%"},{data:"horas_uso_anio",name:"horas_uso_anio",width:"15%"},{data:"anio_compra",name:"anio_compra",width:"15%"},{data:"anio_fin_depreciacion",name:"anio_fin_depreciacion",width:"15%"},{data:"depreciacion_por_anio",name:"depreciacion_por_anio",width:"15%"}]}):$("#equipos_de_tecnoparque_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};$(document).ready(function(){$("#equipo_tecnoparque_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/equipos",type:"get"},columns:[{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"referencia",name:"referencia",width:"15%"},{data:"marca",name:"marca",width:"15%"},{data:"costo_adquisicion",name:"costo_adquisicion",width:"15%"},{data:"vida_util",name:"vida_util",width:"15%"},{data:"horas_uso_anio",name:"horas_uso_anio",width:"15%"},{data:"anio_compra",name:"anio_compra",width:"15%"},{data:"anio_fin_depreciacion",name:"anio_fin_depreciacion",width:"15%"},{data:"depreciacion_por_anio",name:"depreciacion_por_anio",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}]})}),$(document).ready(function(){$("#equipo_tecnoparque_gestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,dom:"Blfrtip",buttons:[{extend:"csv",text:"exportar csv",exportOptions:{columns:":visible"}},{extend:"excel",exportOptions:{columns:":visible"}},{extend:"pdf",exportOptions:{columns:":visible"}}],ajax:{url:"/equipos",type:"get"},columns:[{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"referencia",name:"referencia",width:"15%"},{data:"marca",name:"marca",width:"15%"},{data:"costo_adquisicion",name:"costo_adquisicion",width:"15%"},{data:"vida_util",name:"vida_util",width:"15%"},{data:"horas_uso_anio",name:"horas_uso_anio",width:"15%"},{data:"anio_compra",name:"anio_compra",width:"15%"},{data:"anio_fin_depreciacion",name:"anio_fin_depreciacion",width:"15%"},{data:"depreciacion_por_anio",name:"depreciacion_por_anio",width:"15%"}]})}),$(document).ready(function(){$("#mantenimientosequipos_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers",lengthChange:!1})});var selectMantenimientosEquiposPorNodo={selectMantenimientosEquipoForNodo:function(){let a=$("#selectnodo").val();$("#mantenimientosequipos_administrador_table").dataTable().fnDestroy(),""!=a?$("#mantenimientosequipos_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,retrieve:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/mantenimientos/getmantenimientosequipospornodo/"+a,type:"get"},columns:[{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"equipo",name:"equipo",width:"30%"},{data:"ultimo_anio_mantenimiento",name:"ultimo_anio_mantenimiento",width:"15%"},{data:"valor_mantenimiento",name:"valor_mantenimiento",width:"15%"},{data:"detail",name:"detail",width:"15%"}]}):$("#mantenimientosequipos_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};$(document).ready(function(){$("#mantenimientosequipos_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/mantenimientos",type:"get"},columns:[{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"equipo",name:"equipo",width:"30%"},{data:"ultimo_anio_mantenimiento",name:"ultimo_anio_mantenimiento",width:"15%"},{data:"valor_mantenimiento",name:"valor_mantenimiento",width:"15%"},{data:"detail",name:"detail",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}]})}),$(document).ready(function(){$("#mantenimientosequipos_gestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/mantenimientos",type:"get"},columns:[{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"equipo",name:"equipo",width:"30%"},{data:"ultimo_anio_mantenimiento",name:"ultimo_anio_mantenimiento",width:"15%"},{data:"valor_mantenimiento",name:"valor_mantenimiento",width:"15%"},{data:"detail",name:"detail",width:"15%"}]})}),$(document).ready(function(){$("#materiales_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers",lengthChange:!1})});var selectMaterialesPorNodo={selectMaterialesForNodo:function(){let a=$("#selectnodo").val();$("#materiales_administrador_table").dataTable().fnDestroy(),""!=a?$("#materiales_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,retrieve:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/materiales/getmaterialespornodo/"+a,type:"get"},columns:[{data:"fecha",name:"fecha",width:"20%"},{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"codigo_material",name:"codigo_material",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"presentacion",name:"presentacion",width:"15%"},{data:"medida",name:"medida",width:"15%"},{data:"cantidad",name:"cantidad",width:"15%"},{data:"valor_unitario",name:"valor_unitario",width:"15%"},{data:"valor_compra",name:"valor_compra",width:"15%"},{data:"detail",name:"detail",width:"15%"}]}):$("#materiales_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};function getSelectMaterialMedida(){let a=$("#txtmedida option:selected").text(),e=$("#txtmedida").val();$("#txtcantidad").prop("disabled",!0),$("label[for='txtcantidad']").empty(),""!=e?($("#txtcantidad").prop("disabled",!1),$("#txtcantidad").val(""),$("label[for='txtcantidad']").text("Tamaño presentacion o venta/paquete en "+a)):($("#txtcantidad").prop("disabled",!0),$("label[for='txtcantidad']").text("Tamaño presentacion o venta/paquete"))}$(document).ready(function(){$("#materiales_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/materiales",type:"get"},columns:[{data:"fecha",name:"fecha",width:"20%"},{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"codigo_material",name:"codigo_material",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"presentacion",name:"presentacion",width:"15%"},{data:"medida",name:"medida",width:"15%"},{data:"cantidad",name:"cantidad",width:"15%"},{data:"valor_unitario",name:"valor_unitario",width:"15%"},{data:"valor_compra",name:"valor_compra",width:"15%"},{data:"detail",name:"detail",width:"15%"}]})}),$(document).ready(function(){$("#materiales_gestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/materiales",type:"get"},columns:[{data:"fecha",name:"fecha",width:"20%"},{data:"codigo_material",name:"codigo_material",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"presentacion",name:"presentacion",width:"15%"},{data:"medida",name:"medida",width:"15%"},{data:"cantidad",name:"cantidad",width:"15%"},{data:"valor_unitario",name:"valor_unitario",width:"15%"},{data:"valor_compra",name:"valor_compra",width:"15%"},{data:"detail",name:"detail",width:"15%"}]})});var materialFormacion={destroyMaterial:function(a){Swal.fire({title:"¿Estas seguro de eliminar este material de formación?",text:"Recuerde que si lo elimina no lo podrá recuperar.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"si, elminar material",cancelButtonText:"No, cancelar"}).then(e=>{if(e.value){let e=$("meta[name='csrf-token']").attr("content");$.ajax({url:"/materiales/"+a,type:"DELETE",data:{id:a,_token:e},success:function(a){200==a.status?(Swal.fire("Eliminado!","El material de formación ha sido eliminado satisfactoriamente.","success"),location.href=a.route):226==a.status&&Swal.fire("No se puede elimnar!",a.message,"error")},error:function(a,e,t){alert("Error: "+t)}})}else e.dismiss===Swal.DismissReason.cancel&&swalWithBootstrapButtons.fire("Cancelado","Tu material de formación está a salvo","error")})}};$(document).ready(function(){$("#costoadministrativo_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers"})});var selectCostoAdministrativoNodo={selectCostoAdministrativoForNodo:function(){let a=$("#selectnodo").val();$("#costoadministrativo_administrador_table").dataTable().fnDestroy(),""!=a?$("#costoadministrativo_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,order:[[1,"asc"]],fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/costos-administrativos/costoadministrativo/"+a,type:"get"},columns:[{data:"entidad",name:"entidad",width:"30%"},{data:"costoadministrativo",name:"costoadministrativo",width:"30%"},{data:"valor",name:"valor",width:"15%"},{data:"costosadministrativospordia",name:"costosadministrativospordia",width:"15%"},{data:"costosadministrativosporhora",name:"costosadministrativosporhora",width:"15%"}],footerCallback:function(a,e,t,o,n){var i=this.api(),s=function(a){return"string"==typeof a?1*a.replace(/[\$,]/g,""):"number"==typeof a?a:0};totalCostosHora=i.column(4).data().reduce(function(a,e){return s(a)+s(e)},0),totalCostosDia=i.column(3).data().reduce(function(a,e){return s(a)+s(e)},0),totalCostosMes=i.column(2).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosHora=i.column(4,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosDia=i.column(3,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),pageTotalCostosMes=i.column(2,{page:"current"}).data().reduce(function(a,e){return s(a)+s(e)},0),$(i.column(4).footer()).html("$ "+pageTotalCostosHora+" ( $"+totalCostosHora+" total)"),$(i.column(3).footer()).html("$ "+pageTotalCostosDia+" ( $"+totalCostosDia+" total)"),$(i.column(2).footer()).html("$ "+pageTotalCostosMes+" ( $"+totalCostosMes+" total)")}}):$("#costoadministrativo_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};$(document).ready(function(){$("#usoinfraestructura_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var UsoInfraestructuraAdministrador={selectUsoInfraestructuraPorNodo:function(){let a=$("#selectnodo").val();$("#usoinfraestructura_administrador_table").dataTable().fnDestroy(),""!=a?$("#usoinfraestructura_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/usoinfraestructura/usoinfraestructurapornodo/"+a,type:"get"},columns:[{data:"fecha",name:"fecha"},{data:"actividad",name:"actividad"},{data:"asesoria_directa",name:"asesoria_directa"},{data:"asesoria_indirecta",name:"asesoria_indirecta"},{data:"detail",name:"detail",orderable:!1}]}):$("#usoinfraestructura_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},queryGestoresByNodo:function(){let a=$("#selectnodo").val();null==a||""==a?($("#selectGestor").empty(),$("#selectGestor").append('<option value="" selected>Seleccione un Gestor</option>')):$.ajax({type:"GET",url:"/usuario/usuarios/gestores/nodo/"+a,contentType:!1,dataType:"json",processData:!1,success:function(a){$("#selectGestor").empty(),$("#selectGestor").append('<option value="">Seleccione un Gestor</option>'),$.each(a.gestores,function(a,e){$("#selectGestor").append('<option  value="'+a+'">'+e+"</option>")}),$("#selectGestor").material_select()},error:function(a,e,t){alert("Error: "+t)}})},queryActivitiesByGestor:function(){let a=$("#selectGestor").val(),e=$("#selectYear").val(),t=$("#selectnodo").val();null==t||""==t?($("#selectGestor").empty(),$("#selectGestor").append('<option value="">Seleccione un Gestor</option>'),$("#selectYear").empty(),$("#selectYear").append('<option value="">Seleccione un año</option>'),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):null==a||""==a?($("#selectYear").empty(),$("#selectYear").append('<option value="">Seleccione un año</option>'),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):null==e||""==e?($("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):$.ajax({type:"GET",url:"/usoinfraestructura/actividades/"+a+"/"+e,contentType:!1,dataType:"json",processData:!1,success:function(a){$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione la Actividad</option>'),$.each(a.actividades,function(a,e){$("#selectActivity").append('<option  value="'+a+'">'+e+"</option>")}),$("#selectActivity").material_select()},error:function(a,e,t){alert("Error: "+t)}})},ListActividadesPorGestor:function(){let a=$("#selectnodo").val(),e=$("#selectGestor").val(),t=$("#selectYear").val(),o=$("#selectActivity").val();""==a||null==a?(Swal.fire("Error","Por favor selecciona un nodo","error"),$("#selectGestor").empty(),$("#selectGestor").append('<option value="">Seleccione un Gestor</option>')):""==e||null==e?(Swal.fire("Error","Por favor selecciona un gestor","error"),$("#selectYear").empty(),$("#selectYear").append('<option value="">Seleccione un año</option>'),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):""==t||null==t?(Swal.fire("Error","Por favor selecciona un año","error"),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):""==o||null==o?(Swal.fire("Error","Por favor selecciona una actividad","error"),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):($("#usoinfraestructura_administrador_table").dataTable().fnDestroy(),$("#usoinfraestructura_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usoinfraestructura/actividades/datatable/"+e+"/"+t+"/"+o},columns:[{data:"fecha",name:"fecha"},{data:"actividad",name:"actividad"},{data:"fase",name:"fase"},{data:"asesoria_directa",name:"asesoria_directa"},{data:"asesoria_indirecta",name:"asesoria_indirecta"},{data:"detail",name:"detail",orderable:!1}]}))}};$(document).ready(function(){$("#usoinfraestructura_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var usoinfraestructura={ListActividadesPorGestor:function(){let a=$("#selectGestor").val(),e=$("#selectYear").val(),t=$("#selectActivity").val();""==a||null==a?Swal.fire("Error","Por favor selecciona un gestor","error"):""==e||null==e?Swal.fire("Error","Por favor selecciona un año","error"):""==t||null==t?Swal.fire("Error","Por favor selecciona una actividad","error"):($("#usoinfraestructura_dinamizador_table").dataTable().fnDestroy(),$("#usoinfraestructura_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usoinfraestructura/actividades/datatable/"+a+"/"+e+"/"+t},columns:[{data:"fecha",name:"fecha"},{data:"actividad",name:"actividad"},{data:"fase",name:"fase"},{data:"asesoria_directa",name:"asesoria_directa"},{data:"asesoria_indirecta",name:"asesoria_indirecta"},{data:"detail",name:"detail",orderable:!1}]}))},queryActivitiesByGestor:function(){let a=$("#selectGestor").val(),e=$("#selectYear").val();null==a||""==a?($("#selectYear").empty(),$("#selectActivity").empty()):null==e||""==e?$("#selectActivity").empty():$.ajax({type:"GET",url:"/usoinfraestructura/actividades/"+a+"/"+e,contentType:!1,dataType:"json",processData:!1,success:function(a){$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione la Actividad</option>'),$.each(a.actividades,function(a,e){$("#selectActivity").append('<option  value="'+a+'">'+e+"</option>")}),$("#selectActivity").material_select()},error:function(a,e,t){alert("Error: "+t)}})}},UsoInfraestructuraGestor={queryActivitiesByGestor:function(a){let e=$("#selectYear").val();null==e||""==e?($("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):$.ajax({type:"GET",url:"/usoinfraestructura/actividades/"+a+"/"+e,contentType:!1,dataType:"json",processData:!1,success:function(a){$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione la Actividad</option>'),$.each(a.actividades,function(a,e){$("#selectActivity").append('<option  value="'+a+'">'+e+"</option>")}),$("#selectActivity").material_select()},error:function(a,e,t){alert("Error: "+t)}})},ListActividadesPorGestor:function(a){let e=$("#selectYear").val(),t=$("#selectActivity").val();""==e||null==e?(Swal.fire("Error","Por favor selecciona un año","error"),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):""==t||null==t?(Swal.fire("Error","Por favor selecciona una actividad","error"),$("#selectActivity").empty(),$("#selectActivity").append('<option value="">Seleccione una Actividad</option>')):($("#usoinfraestructura_table").dataTable().fnDestroy(),$("#usoinfraestructura_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/usoinfraestructura/actividades/datatable/"+a+"/"+e+"/"+t},columns:[{data:"fecha",name:"fecha"},{data:"actividad",name:"actividad"},{data:"fase",name:"fase"},{data:"asesoria_directa",name:"asesoria_directa"},{data:"asesoria_indirecta",name:"asesoria_indirecta"},{data:"detail",name:"detail",orderable:!1}]}))}};$(document).ready(function(){$("#usoinfraestructura_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1})});var usoinfraestructuraIndex={selectProyectListDatatables:function(){let a=$("#selecProyecto").val();$("#usoinfraestructura_table").dataTable().fnDestroy(),""!=a?$("#usoinfraestructura_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,ajax:{url:"/usoinfraestructura/projectsforuser/"+a,type:"get"},columns:[{data:"fecha",name:"fecha"},{data:"actividad",name:"actividad"},{data:"fase",name:"fase"},{data:"asesoria_directa",name:"asesoria_directa"},{data:"asesoria_indirecta",name:"asesoria_indirecta"},{data:"detail",name:"detail",orderable:!1}]}):$("#usoinfraestructura_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw()},destroyUsoInfraestructura:function(a){Swal.fire({title:"¿Estas seguro de eliminar este uso de infraestructura?",text:"Recuerde que si lo elimina no lo podrá recuperar.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"si, elminar uso",cancelButtonText:"No, cancelar"}).then(e=>{if(e.value){let e=$("meta[name='csrf-token']").attr("content");$.ajax({url:"/usoinfraestructura/"+a,type:"DELETE",data:{id:a,_token:e},success:function(a){"success"==a.usoinfraestructura&&(Swal.fire("Eliminado!","Su uso de infraestructura ha sido eliminado satisfactoriamente.","success"),location.href=a.route)},error:function(a,e,t){alert("Error: "+t)}})}else e.dismiss===Swal.DismissReason.cancel&&swalWithBootstrapButtons.fire("Cancelado","Tu uso de infraestructura está a salvo","error")})}};function datatableVisitantesPorNodo_Ingreso(){$("#visitantesRedTecnoparque_table").dataTable().fnDestroy(),$("#visitantesRedTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/visitante/consultarVisitantesRedTecnoparque",type:"get"},columns:[{width:"15%",data:"documento",name:"documento"},{data:"tipo_documento",name:"tipo_documento"},{data:"tipo_visitante",name:"tipo_visitante"},{data:"visitante",name:"visitante"},{data:"email",name:"email"},{data:"contacto",name:"contacto"},{width:"8%",data:"edit",name:"edit",orderable:!1}]})}function datatableVisitantesPorNodo_DinamizadorAdministrador(){$("#visitantesRedTecnoparque_table").dataTable().fnDestroy(),$("#visitantesRedTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/visitante/consultarVisitantesRedTecnoparque",type:"get"},columns:[{width:"15%",data:"documento",name:"documento"},{data:"tipo_documento",name:"tipo_documento"},{data:"tipo_visitante",name:"tipo_visitante"},{data:"visitante",name:"visitante"},{data:"email",name:"email"},{data:"contacto",name:"contacto"}]})}function consultarIngresosDeUnNodo(a){$("#ingresosDeUnNodo_table").dataTable().fnDestroy(),$("#ingresosDeUnNodo_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/ingreso/consultarIngresosDeUnNodoTecnoparque/"+a,type:"get"},columns:[{width:"15%",data:"fecha_ingreso",name:"fecha_ingreso"},{width:"15%",data:"hora_salida",name:"hora_salida"},{data:"visitante",name:"visitante"},{data:"servicio",name:"servicio"},{data:"descripcion",name:"descripcion"},{width:"8%",data:"edit",name:"edit",orderable:!1}]})}function consultarVisitanteTecnoparque(){let a=$("#txtdocumento").val();""==a?Swal.fire({title:"Advertencia!",text:"Digite un número de documento!",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}):$.ajax({dataType:"json",type:"get",url:"/visitante/consultarVisitantePorDocumento/"+a,success:function(a){null==a.visitante?(divVisitanteRegistrado.hide(),divRegistrarVisitante.show()):($("#nombrePersona").val(a.visitante.visitante),$("#tipoPersona").val(a.visitante.tipovisitante),$("#contactoReg").val(a.visitante.contacto),$("#correoReg").val(a.visitante.email),divRegistrarVisitante.hide(),divVisitanteRegistrado.show())},error:function(a,e,t){alert("Error: "+t)}})}function consultarDetallesDeUnaCharlaInformativa(a){$.ajax({dataType:"json",type:"get",url:"/charla/consultarDetallesDeUnaCharlaInformativa/"+a,success:function(a){$("#modalDetalleDeUnaCharlaInformativa_titulo").empty(),$("#modalDetalleDeUnaCharlaInformativa_detalle_charla").empty(),$("#modalDetalleDeUnaCharlaInformativa_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Charla Informativa </span><br>"),$("#modalDetalleDeUnaCharlaInformativa_detalle_charla").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código de la Charla Informativa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.codigo_charla+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Fecha de la Charla Informativa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.fecha+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Encargado de la Charla Informativa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.encargado+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Número de Asistentens: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.nro_asistentes+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Observaciones: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.observacion+'</span></div></div><div class="divider"></div><h5 class="center">Evidencias</h5><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Programación de la Charla (Pantallazo del Envío de Correos): </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.programacion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Evidencias Fotográficas: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.evidencia_fotografica+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Listado de Asistencia: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.charla.listado_asistentes+'</span></div></div><div class="divider"></div>'),$("#detalleDeUnaCharlaInformativa_modal").openModal()},error:function(a,e,t){alert("Error: "+t)}})}$(document).ready(function(){});var ano=(new Date).getFullYear(),graficosId={grafico1:"graficoArticulacionesPorGestorYNodoPorFecha_stacked",grafico2:"graficoArticulacionesPorGestorYFecha_stacked",grafico3:"graficoArticulacionesPorLineaYFecha_stacked",grafico4:"graficoArticulacionesPorNodoYAnho_variablepie"},graficosEdtId={grafico1:"graficosEdtsPorGestorNodoYFecha_stacked",grafico2:"graficosEdtsPorGestorYFecha_stacked",grafico3:"graficoEdtsPorLineaYFecha_stacked",grafico4:"graficoEdtsPorNodoYAnho_variablepie"},graficosProyectoId={grafico1:"graficosProyectoPorMesYNodo_combinate",grafico2:"graficosProyectoConEmpresaPorMesYNodo_combinate",grafico3:"graficoProyectosPorTipoNodoYFecha_column",grafico4:"graficoProyectosFinalizadosPorNodoYAnho_column",grafico5:"graficoProyectosFinalizadosPorTipoNodoYFecha_column"};function alertaNodoNoValido(){Swal.fire("Advertencia!","Seleccione un nodo","warning")}function alertaGestorNoValido(){Swal.fire("Advertencia!","Seleccione un gestor(a)","warning")}function alertaLineaNoValido(){Swal.fire("Advertencia!","Seleccione una Línea Tecnológica","warning")}function alertaFechasNoValidas(){Swal.fire("Advertencia!","Seleccione fechas válidas!","warning")}function generarExcelGrafico3Edt(a){let e=0,t=$("#txtlinea_id_edtGrafico3").val(),o=$("#txtfecha_inicio_GraficoEdt3").val(),n=$("#txtfecha_fin_GraficoEdt3").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():""===t?alertaLineaNoValido():location.href="/excel/excelEdtsFinalizadasPorLineaNodoYFecha/"+e+"/"+t+"/"+o+"/"+n}function generarExcelGrafico2Edt(a){let e=0;0==a&&(e=$("#txtgestor_id_edtGrafico2").val());let t=$("#txtfecha_inicio_edtGrafico2").val(),o=$("#txtfecha_fin_edtGrafico2").val();""===e?alertaGestorNoValido():location.href="/excel/excelEdtsFinalizadasPorGestorYFecha/"+e+"/"+t+"/"+o}function generarExcelGrafico1Edt(a){let e=0,t=$("#txtfecha_inicio_edtGrafico1").val(),o=$("#txtfecha_fin_edtGrafico1").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():location.href="/excel/excelEdtsFinalizadasPorFechaYNodo/"+e+"/"+t+"/"+o}function generarExcelGrafico1Articulacion(a){let e=0,t=$("#txtfecha_inicio_Grafico1").val(),o=$("#txtfecha_fin_Grafico1").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():location.href="/excel/excelArticulacionFinalizadasPorFechaYNodo/"+e+"/"+t+"/"+o}function generarExcelGrafico3Articulacion(a){let e=0,t=$("#txtlinea_tecnologica").val(),o=$("#txtfecha_inicio_Grafico1").val(),n=$("#txtfecha_fin_Grafico1").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():""===t?alertaLineaNoValido():location.href="/excel/excelArticulacionFinalizadasPorFechaNodoYLinea/"+e+"/"+t+"/"+o+"/"+n}function generarExcelGrafico2Articulacion(){let a=$("#txtgestor_id").val(),e=$("#txtfecha_inicio_Grafico2").val(),t=$("#txtfecha_fin_Grafico2").val();""===a?alertaGestorNoValido():location.href="/excel/excelArticulacionFinalizadasPorGestorYFecha/"+a+"/"+e+"/"+t}function generarExcelGrafico4Articulacion(a){let e=0,t=$("#txtanho_Grafico4").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():location.href="/excel/excelArticulacionFinalizadasPorNodoYAnho/"+e+"/"+t}function generarExcelGrafico1Proyecto(a){let e=0,t=$("#txtanho_GraficoProyecto1").val();1==a&&(e=$("#txtnodo_excelGrafico1Proyecto").val()),location.href="/excel/excelProyectosInscritosPorAnho/"+e+"/"+t}function generarExcelGrafico2Proyecto(a){let e=0,t=$("#txtanho_GraficoProyecto2").val();1==a&&(e=$("#txtnodo_excelGrafico2Proyecto").val()),location.href="/excel/excelProyectosInscritosConEmpresasPorAnho/"+e+"/"+t}function graficosProyectosPromedioCantidadesMeses(a,e){let t=a.proyectos.cantidades.length,o={cantidades:[],meses:[],promedios:[]};for(let e=0;e<t;e++)o.cantidades.push(a.proyectos.cantidades[e]);for(let e=0;e<t;e++)o.meses.push(a.proyectos.meses[e]);for(let e=0;e<t;e++)o.promedios.push(a.proyectos.promedios[e]);Highcharts.chart(e,{title:{text:"Proyectos Inscritos"},yAxis:{title:{text:"Cantidad/Promedio"}},xAxis:{categories:o.meses,title:{text:"Meses"}},series:[{type:"column",name:"Proyectos Inscritos",data:o.cantidades},{type:"spline",name:"Proyectos Inscritos",data:o.cantidades,dataLabels:{enabled:!0},marker:{lineWidth:2,lineColor:"#008981",fillColor:"#008981"}}]})}function graficosProyectosAgrupados(a,e,t){let o=a.proyectos.cantidades.length,n={cantidades:[],labels:[]};for(let e=0;e<o;e++)n.cantidades.push(a.proyectos.cantidades[e]);for(let e=0;e<o;e++)n.labels.push(a.proyectos.labels[e]);Highcharts.chart(e,{title:{text:"Proyectos Inscritos"},yAxis:{title:{text:"Cantidad"}},xAxis:{categories:n.labels,title:{text:t}},series:[{type:"column",name:"Proyectos Inscritos",data:n.cantidades},{type:"spline",name:"Proyectos Inscritos",data:n.cantidades,dataLabels:{enabled:!0},marker:{lineWidth:2,lineColor:"#008981",fillColor:"#008981"}}]})}function consultarProyectosFinalizadosPorTipoNodoYFecha_column(a){let e=0,t=$("#txtfecha_inicio_GraficoProyecto5").val(),o=$("#txtfecha_fin_GraficoProyecto5").val();1==a&&(e=$("#txtnodo_id").val()),t>o?alertaFechasNoValidas():$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosFinalizadosPorTipoNodoYFecha/"+e+"/"+t+"/"+o,success:function(a){graficosProyectosAgrupados(a,graficosProyectoId.grafico5,"Tipo de Proyecto")},error:function(a,e,t){alert("Error: "+t)}})}function consultarProyectosInscritosPorTipoNodoYFecha_column(a){let e=0,t=$("#txtfecha_inicio_GraficoProyecto3").val(),o=$("#txtfecha_fin_GraficoProyecto3").val();1==a&&(e=$("#txtnodo_id").val()),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosInscritosPorTipoNodoYFecha/"+e+"/"+t+"/"+o,success:function(a){graficosProyectosAgrupados(a,graficosProyectoId.grafico3,"Tipo de Proyecto")},error:function(a,e,t){alert("Error: "+t)}})}function consultarProyectosFinalizadosPorAnho_combinate(a){id=0;let e=$("#txtanho_GraficoProyecto4").val();1==a&&(id=$("#txtnodo_id").val()),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosFinalzadosPorAnho/"+id+"/"+e,success:function(a){graficosProyectosPromedioCantidadesMeses(a,graficosProyectoId.grafico4)},error:function(a,e,t){alert("Error: "+t)}})}function consultarProyectosInscritosConEmpresasPorAnho_combinate(a,e){id=0,1==a&&(id=$("#txtnodo_proyectoGrafico1")),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosInscritosConEmpresasPorAnho/"+id+"/"+e,success:function(a){graficosProyectosPromedioCantidadesMeses(a,graficosProyectoId.grafico2)},error:function(a,e,t){alert("Error: "+t)}})}function consultarProyectosInscritosPorAnho_combinate(a,e){id=0,1==a&&(id=$("#txtnodo_proyectoGrafico1")),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosInscritosPorAnho/"+id+"/"+e,success:function(a){graficosProyectosPromedioCantidadesMeses(a,graficosProyectoId.grafico1)},error:function(a,e,t){alert("Error: "+t)}})}function consultarEdtsDelNodoPorAnho_variablepie(a){let e=$("#txtanho_GraficoEdt4").val(),t=0;1==a&&(t=$("#txtnodo_id").val()),""===t?Swal.fire("Advertencia!","Seleccione un nodo","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorNodoYAnho/"+t+"/"+e,success:function(a){Highcharts.chart(graficosEdtId.grafico4,{chart:{type:"variablepie"},title:{text:"Tipos de Edt's."},plotOptions:{variablepie:{allowPointSelect:!0,cursor:"pointer",dataLabels:{enabled:!0,format:"<b>{point.name}</b>: {point.y:.0f}",connectorColor:"silver"}}},tooltip:{headerFormat:"",pointFormat:'<span style="color:{point.color}">●</span> <b> {point.name}</b><br/>Cantidad: <b>{point.y}</b><br/>'},series:[{minPointSize:10,innerSize:"20%",zMin:0,name:"",data:[{name:"Tipo 1",y:a.consulta.tipo1,z:15},{name:"Tipo 2",y:a.consulta.tipo2,z:15},{name:"Tipo 3",y:a.consulta.tipo3,z:15}]}]})},error:function(a,e,t){alert("Error: "+t)}})}function consultarEdtsPorLineaYFecha_stacked(a){let e=0;1==a&&(e=$("#txtnodo_id").val());let t=$("#txtfecha_inicio_GraficoEdt3").val(),o=$("#txtfecha_fin_GraficoEdt3").val(),n=$("#txtlinea_id_edtGrafico3").val();""==n?Swal.fire("Advertencia!","Selecciona una Línea Tecnológica!","warning"):t>o?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorLineaYFecha/"+n+"/"+e+"/"+t+"/"+o,success:function(a){Highcharts.chart(graficosEdtId.grafico3,{chart:{type:"column"},title:{text:"Tipos de Edt's"},xAxis:{categories:["Tipo 1","Tipo 2","Tipo 3"],title:{text:"Tipos de Edt's"}},yAxis:{min:0,title:{text:"Número de Edt's"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:a.consulta.lineatecnologica,data:[a.consulta.tipo1,a.consulta.tipo2,a.consulta.tipo3]}]})},error:function(a,e,t){alert("Error: "+t)}})}function consultarEdtsPorGestorYFecha_stacked(a){let e=0;1==a&&(e=$("#txtnodo_id").val());let t=$("#txtfecha_inicio_edtGrafico2").val(),o=$("#txtfecha_fin_edtGrafico2").val(),n=$("#txtgestor_id_edtGrafico2").val();""==n?Swal.fire("Advertencia!","Selecciona un Gestor!","warning"):t>o?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorGestorYFecha/"+n+"/"+e+"/"+t+"/"+o,success:function(a){Highcharts.chart(graficosEdtId.grafico2,{chart:{type:"column"},title:{text:"Tipos de Edt's"},xAxis:{categories:["Tipo 1","Tipo 2","Tipo 3"],title:{text:"Tipos de Edt's"}},yAxis:{min:0,title:{text:"Número de Edt's"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:a.consulta.gestor,data:[a.consulta.tipo1,a.consulta.tipo2,a.consulta.tipo3]}]})},error:function(a,e,t){alert("Error: "+t)}})}function consultarEdtsPorNodoGestorYFecha_stacked(a){let e=$("#txtfecha_inicio_edtGrafico1").val(),t=$("#txtfecha_fin_edtGrafico1").val(),o=0;1==a&&(o=$("#txtnodo_id").val()),e>t?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorNodoGestorYFecha/"+o+"/"+e+"/"+t,success:function(a){for(var o=a.consulta.length,n={gestores:[],tipo1Array:[],tipo2Array:[],tipo3Array:[]},i=0;i<o;i++)null!=a.consulta[i].gestor&&n.gestores.push(a.consulta[i].gestor);for(i=0;i<o;i++)null!=a.consulta[i].tipos1&&n.tipo1Array.push(a.consulta[i].tipos1);for(i=0;i<o;i++)null!=a.consulta[i].tipos2&&n.tipo2Array.push(a.consulta[i].tipos2);for(i=0;i<o;i++)null!=a.consulta[i].tipos3&&n.tipo3Array.push(a.consulta[i].tipos3);var s=[];for(i=0;i<o;i++){let a='{"name": "'+n.gestores[i]+'", "data": ['+n.tipo1Array[i]+", "+n.tipo2Array[i]+", "+n.tipo3Array[i]+"]}";a=JSON.parse(a),s.push(a)}Highcharts.chart(graficosEdtId.grafico1,{chart:{type:"column"},title:{text:"Edt's entre "+e+" y "+t},xAxis:{categories:["Tipo 1","Tipo 2","Tipo 3"],title:{text:"Tipos de Edt's"}},yAxis:{min:0,title:{text:"Número de Edts's"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:s})},error:function(a,e,t){alert("Error: "+t)}})}function consultarTiposDeArticulacionesDelAnho_variablepie(a){let e=$("#txtanho_Grafico4").val(),t=0;1==a&&(t=$("#txtnodo_id").val()),""===t?Swal.fire("Advertencia!","Seleccione un nodo","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarArticulacionesPorNodoYAnho/"+t+"/"+e,success:function(a){Highcharts.chart(graficosId.grafico4,{chart:{type:"variablepie"},title:{text:"Tipos de Articulación."},plotOptions:{variablepie:{allowPointSelect:!0,cursor:"pointer",dataLabels:{enabled:!0,format:"<b>{point.name}</b>: {point.y:.0f}",connectorColor:"silver"}}},tooltip:{headerFormat:"",pointFormat:'<span style="color:{point.color}">●</span> <b> {point.name}</b><br/>Cantidad: <b>{point.y}</b><br/>'},series:[{minPointSize:10,innerSize:"20%",zMin:0,name:"",data:[{name:"Grupos de Investigación",y:a.consulta.grupos,z:15},{name:"Empresas",y:a.consulta.empresas,z:15},{name:"Emprendedores",y:a.consulta.emprendedores,z:15}]}]})},error:function(a,e,t){alert("Error: "+t)}})}function articulacionesGrafico1Ajax(a,e,t){$.ajax({dataType:"json",type:"get",url:"/grafico/consultarArticulacionesPorNodo/"+a+"/"+e+"/"+t,success:function(a){for(var o=a.consulta.length,n={gestores:[],gruposArray:[],empresasArray:[],emprendedoresArray:[]},i=0;i<o;i++)null!=a.consulta[i].gestor&&n.gestores.push(a.consulta[i].gestor);for(i=0;i<o;i++)null!=a.consulta[i].grupos&&n.gruposArray.push(a.consulta[i].grupos);for(i=0;i<o;i++)null!=a.consulta[i].empresas&&n.empresasArray.push(a.consulta[i].empresas);for(i=0;i<o;i++)null!=a.consulta[i].emprendedores&&n.emprendedoresArray.push(a.consulta[i].emprendedores);var s=[];for(i=0;i<o;i++){let a='{"name": "'+n.gestores[i]+'", "data": ['+n.gruposArray[i]+", "+n.empresasArray[i]+", "+n.emprendedoresArray[i]+"]}";a=JSON.parse(a),s.push(a)}Highcharts.chart(graficosId.grafico1,{chart:{type:"column"},title:{text:"Articulaciones entre "+e+" y "+t},xAxis:{categories:["Grupos de Investigación","Empresas","Emprendedores"],title:{text:"Tipos de Articulaciones"}},yAxis:{min:0,title:{text:"Número de Articulaciones"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:s})},error:function(a,e,t){alert("Error: "+t)}})}function consultaArticulacionesDelGestorPorNodoYFecha_stacked(a){articulacionesGrafico1Ajax(a,$("#txtfecha_inicio_Grafico1").val(),$("#txtfecha_fin_Grafico1").val())}function consultaArticulacionesDelGestorPorNodoYFecha_stackedAdministrador(){let a=$("#txtnodo_id").val();if(""==a)Swal.fire("Advertencia!","Seleccione un Nodo!","warning");else{articulacionesGrafico1Ajax(a,$("#txtfecha_inicio_Grafico1").val(),$("#txtfecha_fin_Grafico1").val())}}function consultarArticulacionesDeUnGestorPorFecha_stacked(){let a=$("#txtfecha_inicio_Grafico2").val(),e=$("#txtfecha_fin_Grafico2").val(),t=$("#txtgestor_id").val();""==t?Swal.fire("Advertencia!","Selecciona un Gestor!","warning"):a>e?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarArticulacionesPorGestorYFecha/"+t+"/"+a+"/"+e,success:function(a){Highcharts.chart(graficosId.grafico2,{chart:{type:"column"},title:{text:"Articulaciones"},xAxis:{categories:["Grupos de Investigación","Empresas","Emprendedores"],title:{text:"Tipos de Articulaciones"}},yAxis:{min:0,title:{text:"Número de Articulaciones"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:a.consulta.gestor,data:[a.consulta.grupos,a.consulta.empresas,a.consulta.emprendedores]}]})},error:function(a,e,t){alert("Error: "+t)}})}function consultarArticulacionesDeUnaLineaDelNodoPorFechas_stacked(a){let e="";e=0==a?0:$("#txtnodo_id").val();let t=$("#txtlinea_tecnologica").val();if(""==t)Swal.fire("Advertencia!","Selecciona una Línea Tecnológica!","warning");else{let a=$("#txtfecha_inicio_Grafico3").val(),o=$("#txtfecha_fin_Grafico3").val();a>o?Swal.fire("Advertencia!","Debes seleccionar fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/"+e+"/"+t+"/"+a+"/"+o,error:function(a,e,t){alert("Error: "+t)},success:function(a){Highcharts.chart(graficosId.grafico3,{chart:{type:"column"},title:{text:"Articulaciones"},xAxis:{categories:["Grupos de Investigación","Empresas","Emprendedores"],title:{text:"Tipos de Articulaciones"}},yAxis:{min:0,title:{text:"Número de Articulaciones"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:a.consulta.lineatecnologica,data:[a.consulta.grupos,a.consulta.empresas,a.consulta.emprendedores]}]})}})}}var graficosSeguimiento={gestor:"graficoSeguimientoPorGestorDeUnNodo_column",nodo:"graficoSeguimientoDeUnNodo_column",nodo_fases:"graficoSeguimientoDeUnNodoFases_column",gestor_fases:"graficoSeguimientoPorGestorFases_column"};function alertaLineaNoValido(){Swal.fire("Advertencia!","Seleccione una Línea Tecnológica","warning")}function alertaGestorNoValido(){Swal.fire("Advertencia!","Seleccione un Gestor","warning")}function alertaFechasNoValidas(){Swal.fire("Advertencia!","Seleccione fechas válidas","warning")}function alertaNodoNoValido(){Swal.fire("Advertencia!","Seleccione un nodo","warning")}function consultarSeguimientoDeUnGestor(a){let e=0,t=$("#txtfecha_inicio_Gestor").val(),o=$("#txtfecha_fin_Gestor").val();1==a&&(e=$("#txtgestor_id").val()),""===e?alertaGestorNoValido():t>o?alertaFechasNoValidas():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoDeUnGestor/"+e+"/"+t+"/"+o,success:function(a){graficoSeguimiento(a,graficosSeguimiento.gestor)},error:function(a,e,t){alert("Error: "+t)}})}function consultarSeguimientoDeUnGestorFase(a){let e=0;1==a&&(e=$("#txtgestor_id_actual").val()),""===e?alertaGestorNoValido():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoDeUnGestorFases/"+e,success:function(a){graficoSeguimientoFases(a,graficosSeguimiento.gestor_fases)},error:function(a,e,t){alert("Error: "+t)}})}function consultarSeguimientoDeUnNodo(a){let e=0,t=$("#txtfecha_inicio_Nodo").val(),o=$("#txtfecha_fin_Nodo").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():t>o?alertaFechasNoValidas():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoDeUnNodo/"+e+"/"+t+"/"+o,success:function(a){graficoSeguimiento(a,graficosSeguimiento.nodo)},error:function(a,e,t){alert("Error: "+t)}})}function consultarSeguimientoDeUnNodoFases(a){let e=0;1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoDeUnNodoFases/"+e,success:function(a){graficoSeguimientoFases(a,graficosSeguimiento.nodo_fases)},error:function(a,e,t){alert("Error: "+t)}})}function generarExcelSeguimentoNodo(a){let e=0,t=$("#txtfecha_inicio_Nodo").val(),o=$("#txtfecha_fin_Nodo").val();1==a&&(e=$("#txtnodo_id").val()),""===e?alertaNodoNoValido():t>o?alertaFechasNoValidas():location.href="/excel/excelSeguimientoDeUnNodo/"+e+"/"+t+"/"+o}function generarExcelSeguimentoDeUnGestor(a){let e=0,t=$("#txtfecha_inicio_Gestor").val(),o=$("#txtfecha_fin_Gestor").val();1==a&&(e=$("#txtgestor_id").val()),""===e?alertaGestorNoValido():t>o?alertaFechasNoValidas():location.href="/excel/excelSeguimientoDeUnGestor/"+e+"/"+t+"/"+o}function graficoSeguimiento(a,e){Highcharts.chart(e,{chart:{type:"column"},title:{text:"Seguimiento"},yAxis:{title:{text:"Cantidad"}},xAxis:{type:"category"},legend:{enabled:!1},tooltip:{headerFormat:'<span style="font-size:11px">Cantidad</span><br>',pointFormat:'<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'},series:[{colorByPoint:!0,dataLabels:{enabled:!0},data:[{name:"Proyectos Inscritos",y:a.datos.Inscritos},{name:"TRL 6 esperados",y:a.datos.Esperado6},{name:"TRL 7 - 8 esperados",y:a.datos.Esperado7_8},{name:"Proyectos Cerrados",y:a.datos.Cerrados},{name:"TRL 6 obtenidos",y:a.datos.Obtenido6},{name:"TRL 7 obtenidos",y:a.datos.Obtenido7_8},{name:"TRL 8 obtenidos",y:a.datos.Obtenido8},{name:"Articulaciones con G.I Inscritas",y:a.datos.ArticulacionesInscritas},{name:"Articulaciones con G.I Cerradas",y:a.datos.ArticulacionesCerradas}]}]})}function graficoSeguimientoFases(a,e){Highcharts.chart(e,{chart:{type:"column"},title:{text:"Seguimiento (Fases)"},yAxis:{title:{text:"Cantidad"}},xAxis:{type:"category"},legend:{enabled:!1},tooltip:{headerFormat:'<span style="font-size:11px">Cantidad</span><br>',pointFormat:'<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'},series:[{colorByPoint:!0,dataLabels:{enabled:!0},data:[{name:"Proyectos en Inicio",y:a.datos.ProyectosInicio},{name:"Proyectos en Planeación",y:a.datos.ProyectosPlaneacion},{name:"Proyectos en Ejecución",y:a.datos.ProyectosEjecucion},{name:"Proyectos en Cierre",y:a.datos.ProyectosCierre},{name:"Articulaciones en Inicio",y:a.datos.ArticulacionesInicio},{name:"Articulaciones en Planeación",y:a.datos.ArticulacionesPlaneacion},{name:"Articulaciones en Ejecución",y:a.datos.ArticulacionesEjecucion},{name:"Articulaciones en Cierre",y:a.datos.ArticulacionesCierre}]}]})}var graficosCostos={actividad:"costosDeUnProyecto_column",proyectos:"costosDeProyectos_column",proyectos_ipe:"costosDeProyectos_ipe_column"};function setValueInput(a,e){$("#txtcosto_asesorias"+e).val(formatMoney(a.costosAsesorias)),$("label[for='txtcosto_asesorias"+e+"']").addClass("active",!0),$("#txtcostos_equipos"+e).val(formatMoney(a.costosEquipos)),$("label[for='txtcostos_equipos"+e+"']").addClass("active",!0),$("#txtcostos_materiales"+e).val(formatMoney(a.costosMateriales)),$("label[for='txtcostos_materiales"+e+"']").addClass("active",!0),$("#txtcostos_administrativos"+e).val(formatMoney(a.costosAdministrativos)),$("label[for='txtcostos_administrativos"+e+"']").addClass("active",!0),$("#txtcosto_total"+e).val(formatMoney(a.costosTotales)),$("label[for='txtcosto_total"+e+"']").addClass("active",!0),$("#txthoras_asesoria"+e).val(a.horasAsesorias),$("label[for='txthoras_asesoria"+e+"']").addClass("active",!0),$("#txthoras_uso"+e).val(a.horasEquipos),$("label[for='txthoras_uso"+e+"']").addClass("active",!0)}function consultarCostosDeProyectos(a,e){let t,o,n,i=0,s=[],r="";if(1==e?(r="_proyectos",t=$("input[name='estado']:checked").val(),o=$("#txtfecha_inicio_costosProyectos").val(),n=$("#txtfecha_fin_costosProyectos").val(),$("input[name='tipoProyecto[]']:checked").each(function(a,e){s.push($(this).val())})):(r="_proyectos_ipe",t=$("input[name='estado_ipe']:checked").val(),o=$("#txtfecha_inicio_costosProyectos_ipe").val(),n=$("#txtfecha_fin_costosProyectos_ipe").val(),$("input[name='tipoProyecto_ipe[]']:checked").each(function(a,e){s.push($(this).val())})),1==a&&(i=$("#txtnodo_id").val()),""===i)Swal.fire("Advertencia!","Seleccione un nodo","warning");else if(0==s.length)Swal.fire("Advertencia!","Seleccione por lo menos un tipo de proyecto","warning");else if(null==t)Swal.fire("Advertencia!","Seleccione un estado de proyecto","warning");else if(o>n)Swal.fire("Advertencia!","Seleccione fecha válidas","warning");else{let a=JSON.stringify(s);$.ajax({dataType:"json",type:"get",url:"/costos/costosDeProyectos/"+i+"/"+a+"/"+t+"/"+o+"/"+n+"/"+e,success:function(a){setValueInput(a,r),graficoCostos(a,1==e?graficosCostos.proyectos:graficosCostos.proyectos_ipe,"Proyectos")},error:function(a,e,t){alert("Error: "+t)}})}}function consultarCostoDeUnaActividad(){let a=$("#txtactividad_id").val();""===a?Swal.fire("Advertencia!","Seleccione una actividad","warning"):$.ajax({dataType:"json",type:"get",url:"/costos/costosDeUnaActividad/"+a,success:function(a){let e="_actividad";setValueInput(a,e),$("#txtgestor"+e).val(a.gestorActividad),$("label[for='txtgestor"+e+"']").addClass("active",!0),$("#txtlinea"+e).val(a.lineaActividad),$("label[for='txtlinea"+e+"']").addClass("active",!0),graficoCostos(a,graficosCostos.actividad,a.codigoActividad)},error:function(a,e,t){alert("Error: "+t)}})}function graficoCostos(a,e,t){Highcharts.chart(e,{exporting:{allowHTML:!0,chartOptions:{chart:{height:600,marginTop:110,events:{load:function(){this.renderer.image("http://drive.google.com/uc?export=view&id=1qLb9tjGI1hEnmEzQ6mPzxqv1zjMtxdMw",80,20,200,47).add(),this.renderer.image("http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C",290,20,200,47).add(),this.update({credits:{text:"Generado: "+Highcharts.dateFormat("%Y-%m-%d %H:%M:%S",Date.now())}})}}},legend:{y:-220},title:{align:"center",y:90}}},chart:{type:"column"},title:{text:"Costos - "+t},yAxis:{title:{text:"$ Pesos"},labels:{format:"$ {value}"}},xAxis:{type:"category"},legend:{enabled:!1,floating:!0},tooltip:{headerFormat:'<span style="font-size:11px">Costos</span><br>',pointFormat:'<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y}</b><br/>'},plotOptions:{series:{dataLabels:{enabled:!0},animationLimit:1e3}},series:[{colorByPoint:!0,data:[{name:"Costos de Asesorias",y:a.costosAsesorias},{name:"Costos de Equipos",y:a.costosEquipos},{name:"Costos de Materiales",y:a.costosMateriales},{name:"Costos Administrativos",y:a.costosAdministrativos},{name:"Total de Costos",y:a.costosTotales}]}]})}function setValueInput_indicadores(a,e){$("#"+e).val(a),$("label[for='"+e+"']").addClass("active",!0)}function setIdNodo_Indicadores(a){let e=0;return 1==a&&(e=$("#txtnodo_id").val()),e}function ajaxIndicadores_totales(a,e){$.ajax({dataType:"json",type:"get",url:a,success:function(a){setValueInput_indicadores(a,e)},error:function(a,e,t){alert("Error: "+t)}})}function dispararAjax_Fechas(a,e,t,o,n){""===a?Swal.fire("Error!","Seleccione un nodo","error"):e>t?Swal.fire("Error!","Seleccione fechas válidas","error"):ajaxIndicadores_totales(o,n)}function dispararAjax_NoFechas(a,e,t){""===a?Swal.fire("Error!","Seleccione un nodo","error"):ajaxIndicadores_totales(e,t)}function consultarProyectosInscritos_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind1").val(),o=$("#txtfecha_fin_ind1").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalProyectosInscritos/"+e+"/"+t+"/"+o,"txt_total_ind1")}function consultarProyectosEnEjecucion_total(a){let e=setIdNodo_Indicadores(a);dispararAjax_NoFechas(e,"/indicadores/totalProyectosEnEjecucion/"+e,"txt_total_ind2")}function consultarPFFfinalizados_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind3").val(),o=$("#txtfecha_fin_ind3").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPFFfinalizados/"+e+"/"+t+"/"+o,"txt_total_ind3")}function consultarProyectosInscritosAprendizInstructor_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind4").val(),o=$("#txtfecha_fin_ind4").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalInscritosSena/"+e+"/"+t+"/"+o,"txt_total_ind4")}function consultarProyectosEnEjecucionConSena_total(a){let e=setIdNodo_Indicadores(a);dispararAjax_NoFechas(e,"/indicadores/totalProyectosEnEjecucionSena/"+e,"txt_total_ind5")}function consultarProyectosPFFFinalizadosAprendizInstructor_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind6").val(),o=$("#txtfecha_fin_ind6").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPFFSena/"+e+"/"+t+"/"+o,"txt_total_ind6")}function consultarCostosPFFfinalizadosSena_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind7").val(),o=$("#txtfecha_fin_ind7").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalCostoPFFFinalizadoSena/"+e+"/"+t+"/"+o,"txt_total_ind7")}function consultarProyectosInscritosEmpresas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind8").val(),o=$("#txtfecha_fin_ind8").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalInscritosEmpresas/"+e+"/"+t+"/"+o,"txt_total_ind8")}function consultarProyectosEnEjecucionConEmpresas_total(a){let e=setIdNodo_Indicadores(a);dispararAjax_NoFechas(e,"/indicadores/totalProyectosEnEjecucionEmpresas/"+e,"txt_total_ind9")}function consultarProyectosPFFFinalizadosEmpresas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind10").val(),o=$("#txtfecha_fin_ind10").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPFFfinalizadosConEmpresas/"+e+"/"+t+"/"+o,"txt_total_ind10")}function consultarCostosPFFfinalizadosEmpresas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind11").val(),o=$("#txtfecha_fin_ind11").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalCostoPFFFinalizadoEmpresas/"+e+"/"+t+"/"+o,"txt_total_ind11")}function consultarTalentoEnAsocioProyectosConEmpresa_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind12").val(),o=$("#txtfecha_fin_ind12").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosConProyectosEnAsocioConEmpresas/"+e+"/"+t+"/"+o,"txt_total_ind12")}function consultarProyectosInscritosEmprendedoresInvetoresOtros_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind13").val(),o=$("#txtfecha_fin_ind13").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalProyectosInscritosEmprendedoresInvetoresOtro/"+e+"/"+t+"/"+o,"txt_total_ind13")}function consultarProyectosEnEjecucionConEmprendedoresInventoresOtros_total(a){let e=setIdNodo_Indicadores(a);dispararAjax_NoFechas(e,"/indicadores/totalProyectosEnEjecucionEmprendedoresInventoresOtros/"+e,"txt_total_ind14")}function consultarPFFFinalizadosEmprendedoresInvetoresOtros_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind15").val(),o=$("#txtfecha_fin_ind15").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPFFFinalizadosEmprendedoresInvetoresOtro/"+e+"/"+t+"/"+o,"txt_total_ind15")}function consultarCostosPFFfinalizadosEmprendedoresOtros_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind16").val(),o=$("#txtfecha_fin_ind16").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalCostoPFFFinalizadoEmprendedoresOtros/"+e+"/"+t+"/"+o,"txt_total_ind16")}function consultarPMVfinalizados_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind17").val(),o=$("#txtfecha_fin_ind17").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPMVfinalizados/"+e+"/"+t+"/"+o,"txt_total_ind17")}function consultarProyectosPMVFinalizadosAprendizInstructor_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind18").val(),o=$("#txtfecha_fin_ind18").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPMVSena/"+e+"/"+t+"/"+o,"txt_total_ind18")}function consultarCostosPMVfinalizadosSena_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind19").val(),o=$("#txtfecha_fin_ind19").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalCostoPMVFinalizadoSena/"+e+"/"+t+"/"+o,"txt_total_ind19")}function consultarProyectosPMVFinalizadosEmpresas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind20").val(),o=$("#txtfecha_fin_ind20").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPMVfinalizadosConEmpresas/"+e+"/"+t+"/"+o,"txt_total_ind20")}function consultarCostosPMVfinalizadosEmpresas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind21").val(),o=$("#txtfecha_fin_ind21").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalCostoPMVFinalizadoEmpresas/"+e+"/"+t+"/"+o,"txt_total_ind21")}function consultarPMVFinalizadosEmprendedoresInvetoresOtros_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind22").val(),o=$("#txtfecha_fin_ind22").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalPMVFinalizadosEmprendedoresInvetoresOtro/"+e+"/"+t+"/"+o,"txt_total_ind22")}function consultarCostosPMVfinalizadosEmprendedoresOtros_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind23").val(),o=$("#txtfecha_fin_ind23").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalCostoPMVFinalizadoEmprendedoresOtros/"+e+"/"+t+"/"+o,"txt_total_ind23")}function consultarProyectoConGruposInternos_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind24").val(),o=$("#txtfecha_fin_ind24").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalProyectoConGruposInternos/"+e+"/"+t+"/"+o,"txt_total_ind24")}function consultarProyectoConGruposInternosFinalizados_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind25").val(),o=$("#txtfecha_fin_ind25").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalProyectoConGruposInternosFinalizados/"+e+"/"+t+"/"+o,"txt_total_ind25")}function consultarProyectoConGruposExternos_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind26").val(),o=$("#txtfecha_fin_ind26").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalProyectoConGruposExternos/"+e+"/"+t+"/"+o,"txt_total_ind26")}function consultarProyectoConGruposExternosFinalizados_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind27").val(),o=$("#txtfecha_fin_ind27").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalProyectoConGruposExternosFinalizados/"+e+"/"+t+"/"+o,"txt_total_ind27")}function consultarTalentosConApoyoYProyectos_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind28").val(),o=$("#txtfecha_fin_ind28").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosConApoyoYProyectosAsociados/"+e+"/"+t+"/"+o,"txt_total_ind28")}function consultarTalentosSinApoyoYProyectos_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind29").val(),o=$("#txtfecha_fin_ind29").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosSinApoyoYProyectosAsociados/"+e+"/"+t+"/"+o,"txt_total_ind29")}function consultarAsesoriasIDiEmp_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind30").val(),o=$("#txtfecha_fin_ind30").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalAsesoriasIDiEmpresasYEmprendedores/"+e+"/"+t+"/"+o,"txt_total_ind30")}function consultarAsesoriasIDiEmpresasEmprendedoresEnEjecucion_total(a){let e=setIdNodo_Indicadores(a);dispararAjax_NoFechas(e,"/indicadores/totalAsesoriasIDiEmpresasEmprendedoresEnEjecucion/"+e,"txt_total_ind31")}function consultarAsesoriasIDiEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind32").val(),o=$("#txtfecha_fin_ind32").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalAsesoriasIDiEmpresasEmprendedoresFinalizadas/"+e+"/"+t+"/"+o,"txt_total_ind32")}function consultarVigilanciaEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind33").val(),o=$("#txtfecha_fin_ind33").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Vigilancia Tecnológica.","txt_total_ind33")}function consultarAnalisisEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind34").val(),o=$("#txtfecha_fin_ind34").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Análisis de Prospectiva.","txt_total_ind34")}function consultarReestructuracionEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind35").val(),o=$("#txtfecha_fin_ind35").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Reestructuración y diseño de planta.","txt_total_ind35")}function consultarEstrategiasPosicionamientoEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind36").val(),o=$("#txtfecha_fin_ind36").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Estrategias de creación y posicionamiento de marca.","txt_total_ind36")}function consultarPropiedadIntelectualEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind37").val(),o=$("#txtfecha_fin_ind37").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual","txt_total_ind37")}function consultarFormulacionProyectosEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind38").val(),o=$("#txtfecha_fin_ind38").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Formular proyectos I+D+i para convocatorias.","txt_total_ind38")}function consultarAsesoriaEmpresasEmprendedoresFinalizadas_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind39").val(),o=$("#txtfecha_fin_ind39").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/"+e+"/"+t+"/"+o+"/Asesoría a empresa o emprendedor.","txt_total_ind39")}function consultarEdts_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind40").val(),o=$("#txtfecha_fin_ind40").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalEdts/"+e+"/"+t+"/"+o,"txt_total_ind40")}function consultarTotalPersonasEnEdts_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind41").val(),o=$("#txtfecha_fin_ind41").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalAtendidosEnEdts/"+e+"/"+t+"/"+o+"/empleados+instructores+aprendices+publico","txt_total_ind41")}function consultarTotalPersonasSenaEnEdts_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind42").val(),o=$("#txtfecha_fin_ind42").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalAtendidosEnEdts/"+e+"/"+t+"/"+o+"/instructores+aprendices","txt_total_ind42")}function consultarTotalPersonasEmpleadosEnEdts_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind43").val(),o=$("#txtfecha_fin_ind43").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalAtendidosEnEdts/"+e+"/"+t+"/"+o+"/empleados","txt_total_ind43")}function consultarTotalPublicoGeneralEnEdts_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind44").val(),o=$("#txtfecha_fin_ind44").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalAtendidosEnEdts/"+e+"/"+t+"/"+o+"/publico","txt_total_ind44")}function consultarTotalTalentosEnProyecto_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind45").val(),o=$("#txtfecha_fin_ind45").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosEnProyecto/"+e+"/"+t+"/"+o,"txt_total_ind45")}function consultarTotalTalentosSenaEnProyecto_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind46").val(),o=$("#txtfecha_fin_ind46").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosSenaEnProyecto/"+e+"/"+t+"/"+o,"txt_total_ind46")}function consultarTotalTalentosMujerSenaEnProyecto_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind47").val(),o=$("#txtfecha_fin_ind47").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosMujeresSenaEnProyecto/"+e+"/"+t+"/"+o,"txt_total_ind47")}function consultarTotalTalentosEgresadosSenaEnProyecto_total(a){let e=setIdNodo_Indicadores(a),t=$("#txtfecha_inicio_ind48").val(),o=$("#txtfecha_fin_ind48").val();dispararAjax_Fechas(e,t,o,"/indicadores/totalTalentosEgresadosSenaEnProyecto/"+e+"/"+t+"/"+o,"txt_total_ind48")}function consultarPublicacionesOtros(){$("#tblnovedades_Otros").dataTable().fnDestroy(),$("#tblnovedades_Otros").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/publicacion/datatablePublicaciones",type:"get"},columns:[{width:"15%",data:"fecha_inicio",name:"fecha_inicio"},{data:"titulo",name:"titulo"},{width:"8%",data:"detalle",name:"detalle",orderable:!1}]})}function consultarPublicacionesDesarrollador(){$("#tblnovedades_Desarrollador").dataTable().fnDestroy(),$("#tblnovedades_Desarrollador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/publicacion/datatablePublicaciones",type:"get"},columns:[{width:"15%",data:"codigo_publicacion",name:"codigo_publicacion"},{data:"fecha_inicio",name:"fecha_inicio"},{data:"titulo",name:"titulo"},{data:"role",name:"role"},{width:"8%",data:"detalle",name:"detalle",orderable:!1},{width:"8%",data:"edit",name:"edit",orderable:!1},{width:"8%",data:"update",name:"update",orderable:!1}]})}$(document).ready(function(){consultarPublicacionesOtros(),consultarPublicacionesDesarrollador()}),$("#txtcontenido").summernote({lang:"es-ES",height:300}),$("#txtfecha_inicio").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$("#txtfecha_fin").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"});
>>>>>>> ecf88db75ddbcf75647d42169727a136461afe79
