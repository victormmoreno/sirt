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
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha del taller de fortalecimiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
      $.each(respuesta, function(i, item) {
        $("#ideasEntrenamiento").append("<tr><td>"+item.codigo_idea+" - "+item.nombre_proyecto+
          "</td><td>"+item.confirmacion+"</td><td>"+item.asistencia1+"</td></tr>");
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
        width: '8%',
        data: 'details',
        name: 'details',
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
  $('#entrenamientos_nodo_table_articulador').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/entrenamientos/consultarEntrenamientosPorNodo",
      type: "get",
      data: {
        nodo: null,
      }
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
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },
    ],
  });
});

$(document).ready(function () {
    // Contenedores
    divProductoParecido = $('#productoParecido_content');
    divReemplaza = $('#reemplaza_content');
    divPacking = $('#packing_content');
    divRequisitosLegales = $('#requisitosLegales_content');
    divCertificaciones = $('#certificaciones_content');
    divRecursos = $('#recursos_content');
    divConvocatoria = $('#convocatoria_content');
    divAvalEmpresa = $('#avalEmpresa_content');
    divBuscarEmpresa = $('#buscarEmpresa_content');
    divRegistrarEmpresa = $('#registrarEmpresa_content');
    divEmpresaRegistrada = $('#consultarEmpresa_content');
    // Ocultar contenedores
    divProductoParecido.hide();
    divReemplaza.hide();
    divPacking.hide();
    divRequisitosLegales.hide();
    divCertificaciones.hide();
    divRecursos.hide();
    divConvocatoria.hide();
    divAvalEmpresa.hide();
    divBuscarEmpresa.hide();
    divRegistrarEmpresa.hide();
    divEmpresaRegistrada.hide();

    showInput_ProductoParecido();
    showInput_Reemplaza();
    showInput_Packing();
    showInput_RequisitosLegales();
    showInput_Certificaciones();
    showInput_Recursos();
    showInput_Convocatoria();
    showInput_AvalEmpresa();
    showInput_BuscarEmpresa();
});

function consultarEmpresaTecnoparque() {
    let nit = $('#txtnit').val();
    let field = 'nit';
    if (nit.length < 9 || nit.length > 13) {
        Swal.fire({
            title: 'Advertencia!',
            text: "El nit de la empresa debe tener entre 9 y 13 dígitos!",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
    } else {
        if (nit == "") {
          Swal.fire({
            title: 'Advertencia!',
            text: "Digite el nit de la empresa!",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        } else {
          $.ajax({
            dataType: 'json',
            type: 'get',
            url : '/empresa/ajaxDetallesDeUnaEmpresa/'+nit+'/'+field,
            success: function (response) {
              if (response.empresa == null) {
                divEmpresaRegistrada.hide();
                divRegistrarEmpresa.show();
                $('#txtnit_empresa').val(nit);
                $("label[for='txtnit_empresa']").addClass('active');
              } else {
                let registros;
                asignarValoresFRMIdeas(response);
                divEmpresaRegistrada.show();
                divRegistrarEmpresa.hide();
                reiniciarSede();
                registros = mostrarSedesEmpresa(response);
                $('#sedesEmpresaFormIdea').append(registros);
              }
            },
            error: function (xhr, textStatus, errorThrown) {
              alert("Error: " + errorThrown);
            }
          })
        }
    }
}

function reiniciarSede() {
  $('#sedesEmpresaFormIdea').empty();
  $('#txtsede_id').val('');
  $('#txtnombre_sede_disabled').val('Primero debes seleccionar una sede');
}

function mostrarSedesEmpresa(ajax) {
  let fila = "";
  ajax.empresa.sedes.forEach(element => {
    fila += `<li class="collection-item">
      ` + element.nombre_sede + ` - ` + element.direccion + ` ` + element.ciudad.nombre + ` (` + element.ciudad.departamento.nombre + `)
      <a href="#!" class="secondary-content" onclick="asociarSedeAIdeaProyecto(`+element.id+`)">Asociar esta sede de la empresa a la idea de proyecto</a></div>
    </li>`;
  });
  return fila
}

function asociarSedeAIdeaProyecto(sede_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url : '/empresa/ajaxDetalleDeUnaSede/'+sede_id,
    success: function (response) {
      $('#txtsede_id').val(response.sede.id);
      $('#txtnombre_sede_disabled').val(response.sede.nombre_sede + ' - ' + response.sede.direccion + ' ' + response.sede.ciudad.nombre + ' (' + response.sede.ciudad.departamento.nombre + ')');
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La sede '+response.sede.nombre_sede+' se asoció a la idea de proyecto!'
    });
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    }
  })
}

  $(document).on('click', '.btnModalIdeaCancelar', function(event) {
    Swal.close();
  });

  $(document).on('click', '.btnModalIdeaGuardar', function(event) {
    $('#txtopcionRegistro').val('guardar');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'create');
  });

  $(document).on('click', '.btnModalIdeaModificar', function(event) {
    $('#txtopcionRegistro').val('guardar');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'update');
  });
  
  $(document).on('click', '.btnModalIdeaPostular', function(event) {
    $('#txtopcionRegistro').val('postular');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'create');
  });
  
  $(document).on('click', '.btnModalIdeaPostularModificar', function(event) {
    $('#txtopcionRegistro').val('postular');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'update');
  });

  function modalOpcionesFormulario(e) {
    e.preventDefault();
    Swal.fire({
    title: 'Guardar información',
    html: "¿Qué desea hacer?" +
        "<br>" +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaGuardar swal2-guardar-custom">' + 'Guardar' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaPostular swal2-postular-custom">' + 'Postular' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaCancelar swal2-cancelar-custom">' + 'Cancelar' + '</button>',
    showCancelButton: false,
    showConfirmButton: false,
    type: 'warning',
    })
  }

  function modalOpcionesFormularioModificar(e) {
    e.preventDefault();
    Swal.fire({
    title: 'Modificar información',
    html: "¿Qué desea hacer?" +
        "<br>" +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaModificar swal2-guardar-custom">' + 'Modificar' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaPostularModificar swal2-postular-custom">' + 'Postular' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaCancelar swal2-cancelar-custom">' + 'Cancelar' + '</button>',
    showCancelButton: false,
    showConfirmButton: false,
    type: 'warning',
    })
  }

function enviarIdeaRegistro(event, tipo) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = null;
    var data = null;
    if (tipo == 'create') {
        form = $('#frmIdea_Inicio');
        data = new FormData($('#frmIdea_Inicio')[0]);
    } else {
        form = $('#frmIdea_Update');
        data = new FormData($('#frmIdea_Update')[0]);
    }
    var url = form.attr("action");
    ajaxSendFormIdea(form, data, url);
}

function asignarValoresFRMIdeas(response) {
    $('#txtnombre_empresa_det').val(response.empresa.nombre);
    $("label[for='txtnombre_empresa_det']").addClass('active');
    $('#txttipo_empresa_det').val(response.empresa.tipoempresa.nombre);
    $("label[for='txttipo_empresa_det']").addClass('active');
    $('#txttamanho_empresa_det').val(response.empresa.tamanhoempresa.nombre);
    $("label[for='txttamanho_empresa_det']").addClass('active');
    $('#txtsector_empresa_det').val(response.empresa.sector.nombre);
    $("label[for='txtsector_empresa_det']").addClass('active');
    $('#txtnit_empresa').val(response.empresa.nit);
  }

function ajaxSendFormIdea(form, data, url) {
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
            mensajesIdeaForm(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function pintarMensajeIdeaForm(title, text, type) {
    Swal.fire({
        title: title,
        html: text,
        type: type,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}

function mensajesIdeaForm(data) {
    let title = "error";
    let text = "error";
    let type = "error";
    title = data.title;
    text = data.msg;
    type = data.type;
    if (data.state != 'error_form') {
        pintarMensajeIdeaForm(title, text, type);
    }

    if (data.state == 'registro') {
        setTimeout(function () {
            window.location.href = data.url;
        }, 5000);
    }

    if (data.state == 'update') {
        setTimeout(function () {
            window.location.href = data.url;
        }, 5000);
    }
};


function showInput_ProductoParecido() {
    if ($('#txtproducto_parecido').is(':checked')) {
        divProductoParecido.show();
    } else {
        divProductoParecido.hide();
    }
}

function showInput_Reemplaza() {
    if ($('#txtreemplaza').is(':checked')) {
        divReemplaza.show();
    } else {
        divReemplaza.hide();
    }
}

function showInput_Packing() {
    if ($('#txtpacking').is(':checked')) {
        divPacking.show();
    } else {
        divPacking.hide();
    }
}

function showInput_RequisitosLegales() {
    if ($('#txtrequisitos_legales').is(':checked')) {
        divRequisitosLegales.show();
    } else {
        divRequisitosLegales.hide();
    }
}

function showInput_BuscarEmpresa() {
    if ($('#txtidea_empresa').is(':checked')) {
        divBuscarEmpresa.show();
    } else {
        divBuscarEmpresa.hide();
    }
}

function showInput_Certificaciones() {
    if ($('#txtrequiere_certificaciones').is(':checked')) {
        divCertificaciones.show();
    } else {
        divCertificaciones.hide();
    }
}

function showInput_Recursos() {
    if ($('#txtrecursos_necesarios').is(':checked')) {
        divRecursos.show();
    } else {
        divRecursos.hide();
    }
}

function showInput_Convocatoria() {
    if ($('#txtviene_convocatoria').is(':checked')) {
        divConvocatoria.show();
    } else {
        divConvocatoria.hide();
    }
}

function showInput_AvalEmpresa() {
    if ($('#txtaval_empresa').is(':checked')) {
        divAvalEmpresa.show();
    } else {
        divAvalEmpresa.hide();
    }
}

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
function consultarIdeasDelTalento () {
    $('#tbl_IdeasDelTalento').dataTable().fnDestroy();
    $('#tbl_IdeasDelTalento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: "/idea/datatableIdeasDeTalentos/",
      },
      columns: [
        {
          width: '15%',
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        {
          width: '8%',
          data: 'nodo',
          name: 'nodo',
        },
        {
          data: 'nombre_proyecto',
          name: 'nombre_proyecto',
        },
        {
          data: 'estado',
          name: 'estado',
        },
        {
          width: '8%',
          data: 'info',
          name: 'info',
          orderable: false
        },
        {
          width: '8%',
          data: 'postular',
          name: 'postular',
          orderable: false
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

function confirmacionPostulacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de postular esta idea de proyecto?',
  text: "Una vez que se postule la idea de proyecto, ya no se podrá cambiar los datos de esta.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmEnviarIdeaTalento.submit();
    }
  })
}

function confirmacionDuplicacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de duplicar esta idea de proyecto?',
  text: "Esto se recomienda hacer en caso de que se quiera continuar con el proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmDuplicarIdea.submit();
    }
  })
}

function confirmacionInhabilitar(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de inhabilitar esta idea de proyecto?',
  text: "Esto quiere decir que esta idea de proyecto no se le podrá realizar un proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmInhabilitarIdea.submit();
    }
  })
}
function consultarIdeasEnviadasAlNodo () {
    $('#tbl_IdeasEnviadasDelNodo').dataTable().fnDestroy();
    $('#tbl_IdeasEnviadasDelNodo').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: "/idea/datatableIdeasDeTalentos/",
      },
      columns: [
        {
            width: '15%',
            data: 'codigo_idea',
            name: 'codigo_idea',
        },
        {
            data: 'nombre_proyecto',
            name: 'nombre_proyecto',
        },
        {
            data: 'nombre_talento',
            name: 'nombre_talento',
        },
        {
            data: 'estado',
            name: 'estado',
        },
        {
            width: '8%',
            data: 'info',
            name: 'info',
            orderable: false
        },
        // {
        //     width: '8%',
        //     data: 'edit',
        //     name: 'edit',
        //     orderable: false
        // },
      ],
    });
}
function consultarEntrenamientosPorNodo_Administrador(id) {
  $('#entrenamientosPorNodo_tableAdministrador').dataTable().fnDestroy();
  $('#entrenamientosPorNodo_tableAdministrador').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "/entrenamientos/consultarEntrenamientosPorNodo/",
      type: "get",
      data: {
        filter_nodo: id.value,
      }
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
        width: '8%',
        data: 'details',
        name: 'details',
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

$(document).on('submit', 'form#formEntrenamientosCreate', function (event) { // $('button[type="submit"]').prop("disabled", true);
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
            ajaxSendFormEntrenamiento(form, data, url, 'create');
        }
    });
});

function ajaxSendFormEntrenamiento(form, data, url, fase) {
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
          mensajesEntrenamientoCreate(data);
      },
      error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
      }
  });
};

function mensajesEntrenamientoCreate(data) {
  if (data.state != 'error_form') {
    Swal.fire({
      title: data.title,
      html: data.msg,
      type: data.type,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    });
  }
  if (data.state == 'registro') {
    setTimeout(function () {
        window.location.href = data.url;
    }, 1500);
  }

  if (data.state == 'update') {
    setTimeout(function () {
        window.location.href = data.url;
    }, 1500);
  }
};

function noRepeatIdeasTaller(id) {
  let idIdea = id;
  let retorno = true;
  let a = document.getElementsByName("ideas_taller[]");
  for (x = 0; x < a.length; x ++) {
      if (a[x].value == idIdea) {
          retorno = false;
          break;
      }
  }
  return retorno;
};

function getValorConfirmacion() {
  if ($('#txtconfirmacion').is(':checked')) {
    return 1;
  } else {
    return 0;
  }
}

function getValorAsistencia() {
  if ($('#txtasistencia').is(':checked')) {
    return 1;
  } else {
    return 0;
  }
}

function addIdeaToEntrenamiento() {
  let id = $('#txtidea_taller').val();
  let confirmacion = getValorConfirmacion();
  let asistencia = getValorAsistencia();
  if (id == 0) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'error',
      title: 'Estás ingresando mal los datos'
  })
  } else {
      if (noRepeatIdeasTaller(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'La idea de proyecto ya se encuentra asociada al taller!'
      });
      } else {
          pintarIdeaEnLaTablaTaller(id, confirmacion, asistencia);
      }
  }
};

function pintarIdeaEnLaTablaTaller(id, confirmacion, asistencia) {
  $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/idea/detallesIdea/' + id
  }).done(function (ajax) {
      let fila = prepararFilaEnLaTablaDeIdeasTaller(ajax, confirmacion, asistencia);
      $('#tblIdeasEntrenamientoForm').append(fila);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'La idea de proyecto se asoció con éxito al taller'
      });
      reiniciarCamposTaller();
  });
}

function reiniciarCamposTaller() {
  $("#txtidea_taller").val('0');
  $("#txtidea_taller").select2();
  }

function prepararFilaEnLaTablaDeIdeasTaller(ajax, confirmacion, asistencia) {
  let idIdea = ajax.detalles.id;
  let fila = '<tr class="selected" id=ideaAsociadaTaller' + idIdea + '>' + 
      '<td><input type="hidden" name="ideas_taller[]" value="' + idIdea + '">' + ajax.detalles.codigo_idea + ' - ' + ajax.detalles.nombre_proyecto + '</td>' +
      '<td><input type="hidden" name="confirmaciones[]" value="' + confirmacion + '">' + getYesOrNot(confirmacion) + '</td>' +
      '<td><input type="hidden" name="asistencias[]" value="' + asistencia + '">' + getYesOrNot(asistencia) + '</td>' +
      '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelTaller(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' + 
      '</tr>';
  return fila;
}

function eliminarIdeaDelTaller(index) {
  $('#ideaAsociadaTaller' + index).remove();
}

function getYesOrNot(value) {
  if (value == 0) {
    return 'No';
  } else {
    return 'Si';
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
        text: "Se ha enviado un mensaje a la dirección: " + data.idea + " con los resultados del comité.",
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
        type: 'error',
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
        // text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los expertos puedes cambiar esta información",
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

function confirmacionDuplicidad(e, route){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de duplicar esta idea de proyecto?',
    text: "Debes tener en cuenta que a partir de esta idea se va a registrar mas de un TRL.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        Swal.fire({
            title: 'Verificación. ¿Está seguro(a) de duplicar esta idea de proyecto?',
            text: "Esta acción no se podrá revertir.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Continuar!'
            }).then((result) => {
              if (result.value) {
                  location.href = route;
              }
            })
      }
    })
  }

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


function addGestorComite() {
    let id = $('#txtidgestor').val();
    let hora_inicio = $('#txthorainiciogestor').val();
    let hora_fin = $('#txthorafingestor').val();
    if (id == 0 || hora_inicio == '' || hora_fin == '') {
        datosIncompletosGestorAgendamiento();
    } else {
        if (noRepeatGestoresAgendamiento(id) == false) {
            gestorYaSeEncuentraAsociadoAgendamiento();
        } else {
            pintarGestorEnLaTabla(id, hora_inicio, hora_fin);
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
  
$('#txthorafingestor').bootstrapMaterialDatePicker({ 
    time:true,
    date:false,
    shortTime:true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
});
 
$('#txthorainiciogestor').bootstrapMaterialDatePicker({ 
    time:true,
    date:false,
    shortTime: true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
 });
 
$('#txthorafingestor').bootstrapMaterialDatePicker({ 
    time:true,
    date:false,
    shortTime: true,
    format: 'HH:mm',
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

// Elimina un experto agendado en un comité
function eliminarGestorDelAgendamiento(index) {
    $('#gestorAsociadoAgendamiento' + index).remove();
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

function pintarGestorEnLaTabla(id, hora_inicio, hora_fin) {
$.ajax({
    dataType: 'json',
    type: 'get',
    url: '/usuario/consultarUserPorId/' + id
}).done(function (ajax) {
    let fila = prepararFilaEnLaTablaDeGestores(ajax, hora_inicio, hora_fin);
    $('#tblGestoresComiteCreate').append(fila);
    gestorSeAsocioAlAgendamiento();
    reiniciarCamposGestorAgendamiento();
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

function prepararFilaEnLaTablaDeGestores(ajax, hora_inicio, hora_fin) {
let idGestor = ajax.user.gestor.id;
let fila = '<tr class="selected" id=gestorAsociadoAgendamiento' + idGestor + '>' + 
    '<td><input type="hidden" name="gestores[]" value="' + idGestor + '">' + ajax.user.documento + ' - ' + ajax.user.nombres + ' ' + ajax.user.apellidos + '</td>' +
    '<td><input type="hidden" name="horas_inicio[]" value="' + hora_inicio + '">' + hora_inicio + '</td>' +
    '<td><input type="hidden" name="horas_fin[]" value="' + hora_fin + '">' + hora_fin + '</td>' +
    '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarGestorDelAgendamiento(' + idGestor + ');"><i class="material-icons">delete_sweep</i></a></td>' + 
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

function datosIncompletosGestorAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    type: 'error',
    title: 'Estás ingresando mal los datos del experto'
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

function gestorSeAsocioAlAgendamiento() {
Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'El experto se asoció con éxito al comité'
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

function gestorYaSeEncuentraAsociadoAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'warning',
    title: 'El experto ya se encuentra asociado en este comité!'
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

function noRepeatGestoresAgendamiento(id) {
let idGestor = id;
let retorno = true;
let a = document.getElementsByName("gestores[]");
for (x = 0; x < a.length; x ++) {
    if (a[x].value == idGestor) {
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
}

function reiniciarCamposGestorAgendamiento() {
$("#txtidgestor").val('0');
$("#txtidgestor").select2();
$('#txthorainiciogestor').val('');
$("label[for='txthorainiciogestor']").removeClass('active');
$('#txthorafingestor').val('');
$("label[for='txthorafingestor']").removeClass('active');
}
$(document).on('submit', 'form#formComiteRealizadoCreate', function (event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los expertos puedes cambiar esta información",
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
    $('#empresasDeTecnoparque_table').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
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
            data: 'details',
            name: 'details',
            orderable: false
        }
        ],
    });
});
$(document).on('submit', 'form#formRegisterCompany', function (event) {

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
        printErroresFormulario(data);
        if (data.state == 'error' && data.url == false) {
        Swal.fire({
            title: 'La empresa no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
        }
        if (data.state == 'success' && data.url != false) {
        Swal.fire({
            title: 'Registro Exitoso',
            text:  data.message,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
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

$(document).on('submit', 'form#formEditCompany', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formEditCompanyHq', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formAddCompanyHq', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'store') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formEditResponsable', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formSearchEmpresas', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    $('#empresas_encontradas').empty();
    let nit = $('#txtnit_search').val();
    let patronNit=new RegExp('^[0-9]{9,13}$');
    if (!patronNit.test(nit)) {
        Swal.fire(
            'Estás ingresando mal los datos!',
            'Por favor ingrese un nit válido entre 6 y 13 dígitos (no se permiten puntos ni código de verificación)',
            'error'
        );
        $('button[type="submit"]').removeAttr('disabled');
        $('button[type="submit"]').prop("disabled", false);
    } else {
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
                if (data.empresas.length == 0) {
                    $('#empresas_encontradas').append(`
                        <div class="row">
                            <ul class="collection with-header">
                                <li class="collection-header"><h5>No se encontraron empresas</h5></li>
                            </ul>
                        </div>
                    `);
                } else {
                    if (data.state == 'search') {
                        $('#empresas_encontradas').append(`<div class="row">`);
                            $.each( data.empresas, function( key, empresa ) {
                            let route = data.urls[key];
                            $('#empresas_encontradas').append(`
                                <ul class="collection">
                                    <li class="collection-item"><h5>`+empresa.nit+` - `+empresa.nombre+`</h5></li>
                                    <li class="collection-item"><a href=`+route+`>Ver detalles</a></li>
                                </ul>
                            `);
                        });
                        $('#empresas_encontradas').append(`</div>`);
                    }
                }
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').prop("disabled", false);
            },
        });
    }
});
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
                                        <a class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="`+data.url+`">Registrar nuevo usuario</a>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }else{
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a target="_blank" class="grey-text text-darken-3 green accent-1 center-align" href="`+data.url+`">Registrar nuevo usuario</a>
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
          if (data.state == 'error') {
            Swal.fire({
              title: 'La cuenta del usuario no se ha modificado, por favor inténtalo de nuevo',
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
                text: `La cuenta del usuario ha sido modificada satisfactoriamente`,
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

$(document).on('submit', 'form#FormConfirmUser', function (event) {
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
                });
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
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    });
});



var changeNode = {
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
    },
}

$(document).on('submit', 'form#FormChangeNodo', function (event) {
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
                changeNode.printErroresFormulario(data);
            }
            if (data.state == 'error' && data.url == false)
            {
                Swal.fire({
                    title: 'El Usuario no se ha modificado, por favor inténtalo de nuevo',
                    text: "Recuerde que si lo elimina no lo podrá recuperar.",
                    type: 'warning',
                    text: data.message,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ok',
                    cancelButtonText: 'Ver actividades sin finalzar',
                }).then((result) => {
                    if (result.value) {

                    }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                        let activitiesFinalizar ="";
                        $.each( data.activities, function( key, val ) {
                            activitiesFinalizar += '</br><b> ' + key + ' - ' + val + ' </b> ';
                        });
                        Swal.fire({
                            title: 'actividades sin finalzar',
                            html: activitiesFinalizar,
                            type: 'info',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });

                    }
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
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    });
});

$(document).ready(function() {
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year_activo').val();

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
          +'<span class="teal-text text-darken-3">Experto a cargo: </span>'
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
        );
      $('#articulacionDetalle').openModal();
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

function verHorasDeExpertosEnProyecto(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/proyecto/consultarHorasExpertos/"+id
  }).done(function(respuesta){
    $("#horasAsesoriasExpertosPorProyeto_table").empty();
    if (respuesta.horas.length == 0 ) {
      Swal.fire({
        title: 'Ups!!',
        text: "No se encontraron horas de asesorías de los expertos en este proyecto!",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
      })
    } else {
      $("#horasAsesoriasExpertosPorProyeto_titulo").empty();
      $("#horasAsesoriasExpertosPorProyeto_titulo").append("<span class='cyan-text text-darken-3'>Horas de los experto en el proyecto</span>");
      $.each(respuesta.horas, function (i, item) {
        // console.log(item.experto);
        $("#horasAsesoriasExpertosPorProyeto_table").append(
          '<tr>'
          +'<td>'+item.experto+'</td>'
          +'<td>'+item.horas_directas+'</td>'
          +'<td>'+item.horas_indirectas+'</td>'
          +'</tr>'
        );
      });
      $('#horasAsesoriasExpertosPorProyeto_modal').openModal();
    }
  });
}

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

// Ajax que muestra los proyectos de un experto por año
function consultarProyectosDelGestorPorAnho() {
    let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
    $('#tblproyectosGestorPorAnho').dataTable().fnDestroy();
    $('#tblproyectosGestorPorAnho').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        pageLength: 20,
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
    title: '¿Está seguro(a) de reversar este proyecto a la fase de Inicio?',
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

function preguntaReversarPlaneacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de reversar este proyecto a la fase de Planeación?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
        if (result.value) {
            document.frmReversarFasePlaneacion.submit();
        }
    })
}

function preguntaReversarEjecucion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de reversar este proyecto a la fase de Ejecución?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
        if (result.value) {
            document.frmReversarFaseEjecucion.submit();
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
        width: '6%',
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
      {
        width: '6%',
        data: 'download_trazabilidad',
        name: 'download_trazabilidad',
        orderable: false
      },
      {
        width: '6%',
        data: 'ver_horas',
        name: 'ver_horas',
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
                    <TH width="25%">Experto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.asesor.user.documento)} - ${response.data.actividad.articulacion_proyecto.proyecto.asesor.user.nombres} ${response.data.actividad.articulacion_proyecto.proyecto.asesor.user.apellidos}</TD>
                    <TH width="25%">Correo Electrónico</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.asesor.user.email)}</TD>
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
            infoActividad.showPropiedadIntelectualEmpresas(response.data.actividad.articulacion_proyecto.proyecto.sedes);
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
                    <TH width="25%">Experto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.asesor.documento)} - ${response.data.actividad.articulacion_proyecto.articulacion.asesor.nombres} ${response.data.actividad.articulacion_proyecto.articulacion.asesor.apellidos}</TD>
                    <TH width="25%">Correo Electrónico</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.asesor.email)}</TD>
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
                        ${infoActividad.showInfoNull(el.empresa.nit)} - ${infoActividad.showInfoNull(el.empresa.nombre)} (${infoActividad.showInfoNull(el.nombre_sede)})
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
            window.location.replace(data.url);
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
            window.location.replace(data.url);
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
        title: 'Esta empresa/sede ya se encuentra asociada como dueño de la propiedad intelectual!'
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
        title: 'La sede se ha asociado como dueño de la propiedad intelectual!'
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
function prepararFilaEnLaTablaDeTalentos(ajax, isInterlocutor) {
    let talentInterlocutor = null;
    if(isInterlocutor){
        talentInterlocutor = "checked";
    }// El ajax.talento.id es el id del TALENTO, no del usuario
    let idTalento = ajax.talento.id;
    let fila = '<tr class="selected" id=talentoAsociadoAProyecto' + idTalento + '>' + '<td><input type="radio" '+ talentInterlocutor +' class="with-gap" name="radioTalentoLider" id="radioButton' + idTalento + '" value="' + idTalento + '" /><label for ="radioButton' + idTalento + '"></label></td>' + '<td><input type="hidden" name="talentos[]" value="' + idTalento + '">' + ajax.talento.documento + ' - ' + ajax.talento.talento + '</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio(' + idTalento + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
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
    let idSede = ajax.sede.id;
    let codigo = ajax.sede.empresa.nit;
    let nombre = ajax.sede.empresa.nombre;
    let nombre_sede = ajax.sede.nombre_sede;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Empresa' + idSede + '>' + '<td><input type="hidden" name="propietarios_sedes[]" value="' + idSede + '">' + codigo + ' - ' + nombre + ' ('+ nombre_sede +')</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(' + idSede + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
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
function pintarTalentoEnTabla_Fase_Inicio(id, isInterlocutor) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/usuario/talento/consultarTalentoPorId/' + id
    }).done(function (ajax) {

        let fila = prepararFilaEnLaTablaDeTalentos(ajax, isInterlocutor);
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
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(sede_id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : '/empresa/ajaxDetalleDeUnaSede/'+sede_id,
        success: function (response) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'La sede '+response.sede.nombre_sede+' se asoció a la idea de proyecto!'
          });
          let fila = prepararFilaEnLaTablaDePropietarios_Empresa(response);
              $('#propiedadIntelectual_Empresas').append(fila);
              empresaSeAsocioAlProyecto_Propietario();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
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

// Valida que la sede no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Sede(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_sedes[]");
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
function addTalentoProyecto(id, isInterloculor) {
    if (noRepeat(id) == false) {
        talentoYaSeEncuentraAsociado();
    } else {
        pintarTalentoEnTabla_Fase_Inicio(id, isInterloculor);
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

function prepararSedesEmpresa(sedes) {
    let fila = "";
    sedes.forEach(element => {
        fila += `<li class="collection-item">
        ` + element.nombre_sede + ` - ` + element.direccion + ` ` + element.ciudad.nombre + ` (` + element.ciudad.departamento.nombre + `)
        <a href="#!" class="secondary-content" onclick="addSedePropietaria(`+element.id+`)">Asociar esta sede de la empresa al proyecto</a></div>
      </li>`;
    });
    return fila;
}

// Método para agregar una empresa como dueño de una propiedad intelectual
function addEntidadEmpresa(id) {
    $('#sedesPropietarias_Empresas_detalles').empty();
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : '/empresa/ajaxDetallesDeUnaEmpresa/'+id+'/id',
        success: function (response) {
            let filas_sedes = prepararSedesEmpresa(response.empresa.sedes);
            $('#sedesPropietarias_Empresas_detalles').append(filas_sedes);
            $('#sedesPropietarias_Empresas_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
}

function addSedePropietaria(id) {
    if (noRepeat_Sede(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(id);
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
//vaciar valores agregados en tablas
function dumpAggregateValuesIntoTables(){
    $('#detalleTalentosDeUnProyecto_Create').empty();
    $('#propiedadIntelectual_Personas').empty();
    $('#propiedadIntelectual_Empresas').empty();
    $('#propiedadIntelectual_Grupos').empty();
}

//agregar valor a campos
function addValueToFields(nombre, codigo, value){
    $('#txtnombreIdeaProyecto_Proyecto').val(codigo + " - " + nombre);
    $('#txtnombre').val(nombre);
    $("label[for='txtnombreIdeaProyecto_Proyecto']").addClass('active');
    $("label[for='txtnombre']").addClass('active');

    $('#txtobjetivo').val(value.objetivo);
    $('#txtobjetivo').trigger('autoresize');
    $("label[for='txtobjetivo']").addClass('active');

    $('#txtalcance_proyecto').val(value.alcance);
    $('#txtalcance_proyecto').trigger('autoresize');
    $("label[for='txtalcance_proyecto']").addClass('active');
}


// Asocia una idea de proyecto al registro de un proyecto
function asociarIdeaDeProyectoAProyecto(id, nombre, codigo) {
    $('#txtidea_id').val(id);
    
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/idea/show/' + id
    }).done(function (response) {
        let value = response.data.idea;
        if(idea =! null){
            console.log(response);
            dumpAggregateValuesIntoTables();
            
            addValueToFields(nombre, codigo, value);
            ideaProyectoAsociadaConExito(codigo, nombre);

            if(response.data.talento != null){

                addTalentoProyecto(response.data.talento.id, true);
                addPersonaPropiedad(response.data.talento.user.id);
            }
            if(response.data.sede != null){
                addSedePropietaria(response.data.sede.id);
            }
            $('#ideasDeProyectoConEmprendedores_modal').closeModal();
        }
        
    }).fail(function( jqXHR, textStatus, errorThrown ) {
        errorAjax(jqXHR, textStatus, errorThrown);
    });
    
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

function errorAjax(jqXHR, textStatus, errorThrown){
    if (jqXHR.status === 0) {

        alert('Not connect: Verify Network.');

      } else if (jqXHR.status == 404) {

        alert('Requested page not found [404]');

      } else if (jqXHR.status == 500) {

        alert('Internal Server Error [500].');

      } else if (textStatus === 'parsererror') {

        alert('Requested JSON parse failed.');

      } else if (textStatus === 'timeout') {

        alert('Time out error.');

      } else if (textStatus === 'abort') {

        alert('Ajax request aborted.');

      } else {

        alert('Uncaught Error: ' + jqXHR.responseText);

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
            window.location.replace(data.url);
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
    let filter_nodo_art = $('#filter_nodo_art').val();
    let filter_year_art = $('#filter_year_art').val();
    let filter_phase = $('#filter_phase').val();
    let filter_tipo_articulacion = $('#filter_tipo_articulacion').val();
    let filter_alcance_articulacion = $('#filter_alcance_articulacion').val();

    if((filter_nodo_art == '' || filter_nodo_art == null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion == '' || filter_alcance_articulacion == null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art = null,filter_year_art  = null, filter_phase  = null, filter_tipo_articulacion  = null, filter_alcance_articulacion = null);
    }else if((filter_nodo_art != '' || filter_nodo_art != null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion != '' || filter_alcance_articulacion != null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art, filter_year_art, filter_phase, filter_tipo_articulacion, filter_alcance_articulacion);
    }else{

        $('#articulaciones_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_articulacion').click(function () {
    let filter_nodo_art = $('#filter_nodo_art').val();
    let filter_year_art = $('#filter_year_art').val();
    let filter_phase = $('#filter_phase').val();
    let filter_tipo_articulacion = $('#filter_tipo_articulacion').val();
    let filter_alcance_articulacion = $('#filter_alcance_articulacion').val();

    $('#articulaciones_data_table').dataTable().fnDestroy();
    if((filter_nodo_art == '' || filter_nodo_art == null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion == '' || filter_alcance_articulacion == null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art = null,filter_year_art, filter_phase, filter_tipo_articulacion, filter_alcance_articulacion = null);
    }else if((filter_nodo_art != '' || filter_nodo_art != null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion != '' || filter_alcance_articulacion != null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art, filter_year_art, filter_phase, filter_tipo_articulacion, filter_alcance_articulacion);
    }else{
        $('#articulaciones_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var articulacion_pbt ={
    fill_datatatables_articulacion: function(filter_nodo_art = null,filter_year_art=null, filter_phase=null,filter_tipo_articulacion=null, filter_alcance_articulacion = null){
        $('#articulaciones_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 5, "desc" ]],
            ajax:{
                url: "/articulaciones/datatable_filtros",
                type: "get",

                data: {
                    filter_nodo_art: filter_nodo_art,
                    filter_year_art: filter_year_art,
                    filter_phase: filter_phase,
                    filter_tipo_articulacion: filter_tipo_articulacion,
                    filter_alcance_articulacion: filter_alcance_articulacion,
                }
            },
            columns: [
                {
                    data: 'nodo',
                    name: 'nodo',
                },
                {
                    data: 'codigo_articulacion',
                    name: 'codigo_articulacion',
                },
                {
                    data: 'nombre_articulacion',
                    name: 'nombre_articulacion',
                },
                {
                    data: 'articulador',
                    name: 'articulador',
                },
                {
                    data: 'fase',
                    name: 'fase',
                },
                {
                    data: 'starDate',
                    name: 'starDate',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },

}

$('#download_archive_art').click(function(){
    let filter_nodo_art = $('#filter_nodo_art').val();
    let filter_year_art = $('#filter_year_art').val();
    let filter_phase = $('#filter_phase').val();
    let filter_tipo_articulacion = $('#filter_tipo_articulacion').val();
    let filter_alcance_articulacion = $('#filter_alcance_articulacion').val();
    var query = {
        filter_nodo: filter_nodo_art,
        filter_year: filter_year_art,
        filter_phase: filter_phase,
        filter_tipo_articulacion: filter_tipo_articulacion,
        filter_alcance_articulacion: filter_alcance_articulacion,
    }

    var url = "/articulaciones/export?" + $.param(query)

    window.location = url;
});

function preguntaReversarArticulacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de reversar esta articulación a la fase de Inicio?',
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

$(document).on('submit', 'form#frmArticulacionpbt_FaseInicio', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'registrada', 'Registro exitoso');
});

$(document).on('submit', 'form#frmUpdateArticulacion_FaseInicio', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'actualizado', 'Modificación Exitosa');
});

$(document).on('submit', 'form#frmUpdateArticulacionMiembros', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'actualizado', 'Modificación Exitosa');
});


$(document).on('submit', 'form#frmArticulacionFaseCierre', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacionFaseCierre(form, data, url);
});

function ajaxSendFormArticulacionFaseCierre(form, data, url) {
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
            window.location.replace("/articulaciones/"+data.data.id);
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




function ajaxSendFormArticulacion(form, data, url, action, title) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (response) {

            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(response);
            filter_project.messageArticulacion(response, action, title);

        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};



$('#filter_code_project').click(function () {
    let filter_code_project = $('#filter_code').val();
    if((filter_code_project != '' || filter_code_project != null || filter_code_project.length  > 0)){
        filter_project.fill_code_project(filter_code_project);
    }
});

$('#filter_nit_company').click(function () {
    let filter_nit_company = $('#filter_nit').val();
    if((filter_nit_company != '' || filter_nit_company != null || filter_nit_company.length  > 0)){
        filter_project.fill_nit_company(filter_nit_company);
    }
});

$('#filter_project_advanced').click(function () {
    let filter_year_pro = $('#filter_year_pro').val();
    filter_project.queryProyectosFaseInicioTable(filter_year_pro);
});

$('#filter_project_modal').click(function () {
    let filter_year_pro = $('#filter_year_pro').val();
    filter_project.queryProyectosFaseInicioTable(filter_year_pro);
});

$('#filter_company_advanced').click(function () {

    filter_project.queryCompaniesTable();
});

$('#search_talent').click(function () {
    let filter_user = $('#txtsearch_user').val();
    if(filter_user.length > 0 ){
        filter_project.searchUser(filter_user);
    }else{
        filter_project.emptyResult('result-talents');
        filter_project.notFound('result-talents');
    }
});


$('#filter_talents_advanced').click(function () {
    filter_project.queryTalentos();
});


var filter_project = {
    fill_code_project:function(filter_code_project = null){

        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.emptyResult('alert-response-talents');
        filter_project.emptyResult('txtnombre_articulacion');
        if(filter_code_project.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/actividades/filter-code/' + filter_code_project
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let activity = response.data.proyecto.articulacion_proyecto.actividad;
                    let data = response.data;
                    $('#txtnombre_articulacion').val(activity.nombre);
                    $("label[for='txtnombre_articulacion']").addClass('active');

                    $('.alert-response').append(`
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent">
                                <div class="card-content">
                                    <span class="card-title p-h-lg p f-12"> `+activity.codigo_actividad+ ` - `+activity.nombre+`</span>
                                    <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: `+ filter_project.formatDate(activity.fecha_cierre)+`</div>
                                    <p>`+activity.objetivo_general+ `</p>
                                    <input type="hidden" name="txtpbt" value="`+response.data.proyecto.id+`"/>
                                </div>
                                <div class="card-action">
                                <a class="orange-text text-darken-1" target="_blank" href="/proyecto/detalle/`+data.proyecto.id+`">Ver más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);

                    $('.collection-response').append(`
                    <li class="collection-item dismissable">
                        <a target="_blank" href="/proyecto/detalle/`+data.proyecto.id+`" class="secondary-content orange-text"><i class="material-icons">link</i></a>
                        <span class="title">PBT</span>
                        <p>`+activity.codigo_actividad+ `<br>
                            `+activity.nombre+ `
                        </p>
                    </li>
                    <li class="collection-item dismissable">
                        <a  onclick="detallesIdeaPorId(`+data.proyecto.idea.id+`)" class="secondary-content orange-text" >

                            <i class="material-icons">link</i>
                        </a>
                        <span class="title">Idea:</span>

                        <p>`+data.proyecto.idea.codigo_idea+ `<br>
                        `+data.proyecto.idea.nombre_proyecto+ `
                        </p>

                    </li>
                    `);

                    if (data.proyecto.articulacion_proyecto.talentos.length != 0) {
                        $.each(data.proyecto.articulacion_proyecto.talentos, function(e, talento) {

                            $('.alert-response-talents').append(`<div class="row card-talent`+talento.user.id+`">
                                    <div class="col s12 m12 l12">
                                        <div class="card bs-dark">
                                            <div class="card-content">
                                                <span class="card-title p-h-lg"> `+talento.user.documento+ ` - `+talento.user.nombres+ ` `+talento.user.apellidos+`</span>
                                                <input type="hidden" name="talentos[]" value="`+talento.id+`"/>
                                                <div class="p-h-lg">
                                                    <input type="radio" checked class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor`+talento.id+`" value="`+talento.id+`" /><label for ="radioInterlocutor`+talento.id+`">Talento Interlocutor</label>
                                                </div>
                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">  Acceso al sistema: `+ userSearch.state(talento.user.estado) +`</div>
                                                <p class="hide-on-med-and-down"> Miembro desde `+filter_project.formatDate(talento.user.created_at)+`</p>
                                            </div>
                                            <div class="card-action">
                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+talento.user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                                                <a onclick="filter_project.deleteTalent( `+talento.user.id+ `);" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                        });
                    }else{
                        filter_project.notFound('alert-response-talents');
                    }

                }else{
                    filter_project.notFound('alert-response');
                    filter_project.notFound('alert-response-talents');

                    $('.collection-response').append(`
                        <li class="collection-item dismissable">
                            <span class="title">Sin resultados</span>
                        </li>
                    `);
                }
            });
        }else{
            filter_project.notFound('alert-response');
            filter_project.notFound('alert-response-talents');
            $('.collection-response').append(`
                <li class="collection-item dismissable">
                    <span class="title">Sin resultados</span>
                </li>
            `);
        }

    },
    fill_nit_company:function(filter_code_company = null){

        filter_project.emptyResult('alert-response');

        filter_project.emptyResult('alert-response-sedes');
        // filter_project.emptyResult('alert-response-company');

        if(filter_code_company.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/empresas/filter-code/' + filter_code_company
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let data = response.data;


                    if (data.empresa.sedes.length != 0) {
                        $.each(data.empresa.sedes, function(e, sede) {

                            $('.alert-response-sedes').append(`<div class="row card-talent`+sede.id+`">
                                    <div class="col s12 m12 l12">
                                        <div class="card bs-dark">
                                            <div class="card-content">
                                                <span class="card-title p-h-lg"> `+sede.nombre_sede+ `</span>
                                                <input type="hidden" name="sedes" value="`+sede.id+`"/>

                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Empresa: `+data.empresa.nit+` - `+data.empresa.nombre+`</div>

                                            </div>
                                            <div class="card-action">
                                                <a onclick="filter_project.addSedeArticulacionPbt( `+sede.id+ `);" class="waves-effect waves-red btn-flat m-b-xs orange-text">Agregar sede</a>
                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/empresa/detalle/`+data.empresa.id+ `"><i class="material-icons left"> link</i>Ver más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                        });
                    }else{

                        filter_project.notFound('alert-response-sedes');
                        filter_project.notFound('alert-response-company');
                    }



                }else{

                    filter_project.notFound('alert-response-sedes');
                    filter_project.notFound('alert-response-company');
                }
            });
        }else{
            filter_project.notFound('alert-response');
            filter_project.notFound('alert-response-sedes');
        }

    },
    sedesEmpresa: function(sedes) {
        let fila = "";
        sedes.forEach(element => {
            fila += `<li class="collection-item">
            ` + element.nombre_sede + ` - ` + element.direccion + `
            <a href="#!" class="secondary-content" onclick="filter_project.addSedeArticulacionPbt(`+element.id+`)">Asociar esta sede a la articulación</a></div>
          </li>`;
        });
        return fila;
    },
    addSedeArticulacionPbt: function(value){
        filter_project.printSede(value);
        $('#sedes_modal').closeModal();
        $('#company_modal').closeModal();

    },
    printSede: function(id){
        filter_project.emptyResult('alert-response-company');
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/empresas/sede/' + id
        }).done(function (response) {
            if(response.data.status_code == 200){
            $('.alert-response-company').append(`
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card transparent bs-dark">
                            <div class="card-content">
                                <span class="card-title p-h-lg"> `+response.data.sede.nombre_sede+ `</span>
                                <input type="hidden" name="txtsede" value="`+response.data.sede.id+`"/>
                            </div>
                        </div>
                    </div>
                </div>
                `);
            }else{
                filter_project.notFound('alert-response-company');
            }
        });

    },

    deleteTalent:function(id){
        $('.card-talent'+ id).remove();
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'Talento eliminado.'
        });
    },
    queryProyectosFaseInicioTable:function(filter_year_pro=null) {
        $('#datatable_projects_finalizados').dataTable().fnDestroy();
        $('#datatable_projects_finalizados').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "/proyecto/datatableproyectosfinalizados",
                type: "get",
                data: {
                    filter_year_pro: filter_year_pro,
                }
            },
            columns: [
                {
                    data: 'codigo_proyecto',
                    name: 'codigo_proyecto'
                }, {
                    data: 'nombre',
                    name: 'nombre'
                }, {
                    data: 'fase',
                    name: 'fase'
                },{
                    data: 'add_proyecto',
                    name: 'add_proyecto',
                    orderable: false
                },
            ]
        });
        $('#filter_project_advanced_modal').openModal();
    },
    queryCompaniesTable:function() {
        filter_project.emptyResult('alert-response-sedes');
        filter_project.emptyResult('alert-response-company');
        filter_project.notFound('alert-response-sedes');
        filter_project.notFound('alert-response-company');
        $('#companies_table').dataTable().fnDestroy();
        $('#companies_table').DataTable({
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
                    data: 'add_company_art',
                    name: 'add_company_art',
                    orderable: false
                },
            ]
        });
        $('#company_modal').openModal();
    },
    queryTalentos: function(){
        $('#datatable_talents_art').dataTable().fnDestroy();
        $('#datatable_talents_art').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
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
                    data: 'add_articulacion_pbt',
                    name: 'add_articulacion_pbt',
                    orderable: false
                },
            ]
        });
        $('#filter_talents_advanced_modal').openModal();
    },
    addProjectToArticulacion:function(code) {

        filter_project.fill_code_project(code);
        filter_project.emptyResult('result-talents');
        $('#filter_project_advanced_modal').closeModal();
    },
    searchUser:function(document){
        $('.result-talents').empty();
        if(document != null || document != null){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/usuarios/filtro-talento/' + document
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let user = response.data.user;
                    $('.result-talents').append(`<div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent">
                                <div class="card-content">
                                    <span class="card-title p f-12 "> `+user.documento+ ` - `+user.nombres+ ` `+user.apellidos+`</span>
                                    <p class="position-top-right p f-12 mail-date hide-on-med-and-down"> Acceso al sistema: `+ userSearch.state(user.estado) +`</p>
                                    <div class="mailbox-text p f-12 hide-on-med-and-down">
                                                Miembro desde `+filter_project.formatDate(user.created_at)+`
                                        </div>
                                </div>
                                <div class="card-action">
                                <a onclick="filter_project.addTalentArticulacionPbt( `+user.talento.id+ `);" class="orange-text">Agregar</a>
                                </div>
                            </div>
                        </div>
                    </div>`);
                }else{
                    filter_project.notFound('result-talents');
                }

            });
        }
    },
    formatDate: function(date){
        if(date == null){
            return "no registra";
        }else{
            return moment(date).format('LL');
        }
    },
    notFound: function(cl){
        if(cl != null){
            return $('.'+ cl).append(`<div class="row">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent">
                        <div class="card-content">
                            <div class="search-result">
                                <p class="search-result-description">No se encontraron resultados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`);
        }
    },
    emptyResult: function(cl){
        if(cl != null){
            $('.'+ cl).empty();
        }
    },
    addTalentArticulacionPbt: function(talent){
        if (filter_project.noRepeat(talent) == false) {
            filter_project.talentAssociated();
        } else {
            filter_project.emptyResult('talent-empty');
            filter_project.printTalentoInTable(talent);
        }
        $('#filter_talents_advanced_modal').closeModal();
    },
    noRepeat: function(id) {
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
    },
    talentAssociated: function() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'warning',
            title: 'El talento ya se encuentra asociado a la articulación!'
        });
    },
    printTalentoInTable: function(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/usuario/talento/consultarTalentoPorId/' + id
        }).done(function (response) {
            let fila = filter_project.prepareTableRowTalent(response);
            $('.alert-response-talents').append(fila);
        });
    },
    prepareTableRowTalent: function(response) {
        let data = response;
        let fila =`<div class="row card-talent`+data.talento.id+`">
                        <div class="col s12 m12 l12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title"> `+data.talento.documento+ ` - `+data.talento.talento+ `</span>
                                    <input type="hidden" name="talentos[]" value="`+data.talento.id+`"/>
                                    <input type="radio" checked class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor`+data.talento.id+`" value="`+data.talento.id+`" /><label for ="radioInterlocutor`+data.talento.id+`">Talento Interlocutor</label>
                                </div>
                                <div class="card-action">
                                    <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+data.talento.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                                    <a onclick="filter_project.deleteTalent( `+data.talento.id+ `);" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>`;
        return fila;
    },
    messageArticulacion: function(data, action, title) {
        if (data.status_code == 201) {
            Swal.fire({
                title: title,
                text: "La articulación ha sido "+action+" satisfactoriamente",
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
            setTimeout(function () {
                window.location.replace(data.url);
            }, 1000);
        }
        if (data.state == 404) {
            Swal.fire({
                title: 'La articulación no se ha '+action+', por favor inténtalo de nuevo',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            })
        }
    },
    showSeccionProject: function (){
        $('.section-projects').show();
    },
    hideSeccionProject: function (){
        $('.section-projects').hide();
    },
    showSeccionCompany: function (){
        $('.section-company').show();
    },
    hideSeccionCompany: function (){
        $('.section-company').hide();
    },
    showsectionCollapseTalent: function(collap,collapheader,el){

        collap[0].classList.remove('active');
        collap[1].classList.add('active');
        collapheader[0].classList.remove('active');
        collapheader[1].classList.add('active');
        el[1].setAttribute("style", "display: block; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;");
    },
    hidesectionCollapseTalent: function(collap,collapheader,el){
        collap[1].classList.remove('active');
        collap[0].classList.add('active');
        collapheader[1].classList.remove('active');
        collapheader[0].classList.add('active');
        el[1].setAttribute("style", "");
    },
    emptySectionProject: function(){
        filter_project.emptyResult('result-talents');
        filter_project.notFound('result-talents');
        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.emptyResult('alert-response-talents');
        $('#txtnombre_articulacion').val();
    }
}


function checkTipoVinculacion(val) {
    let collap =document.getElementsByClassName('collapsible-li');
    let collapheader =document.getElementsByClassName('collapsible-header grey lighten-2');
    let el = document.getElementsByClassName('collapsible-body');

    if ( $("#IsPbt").is(":checked") ) {
        filter_project.emptyResult('alert-response-sedes');
        filter_project.emptyResult('alert-response-company');
        filter_project.notFound('alert-response-sedes');
        filter_project.notFound('alert-response-company');
        filter_project.showSeccionProject();
        filter_project.hideSeccionCompany();
        filter_project.hidesectionCollapseTalent(collap,collapheader,el);
    }
    else if ($("#IsSenaInnova").is(":checked") ) {

        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.hideSeccionProject();
        filter_project.showSeccionCompany();
        filter_project.showsectionCollapseTalent(collap,collapheader,el);
    }
     else if( $("#IsColinnova").is(":checked")) {

        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.hideSeccionProject();
        filter_project.showSeccionCompany();
        filter_project.showsectionCollapseTalent(collap,collapheader,el);
    }

}

function addCompanyArticulacion(id){
    $('#sedes_detail').empty();
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : '/empresa/ajaxDetallesDeUnaEmpresa/'+id+'/id',
        success: function (response) {
            let filas_sedes = filter_project.sedesEmpresa(response.empresa.sedes);
            $('#sedes_detail').append(filas_sedes);
            $('#sedes_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
}

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

    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();


    $('#equipo_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquipos(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquipos(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

    $('#equipo_actions_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquiposActions(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquiposActions(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_actions_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var equipo = {
    fillDatatatablesEquipos(filter_nodo , filter_state){
        var datatable = $('#equipo_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [[ 1, "desc" ]],
            processing: true,
            serverSide: true,
            "lengthChange": false,
                fixedHeader: {
                header: true,
                footer: true
            },
            "pagingType": "full_numbers",
            ajax:{
                url: "/equipos",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_state: filter_state,
                }
            },
            columns: [
                {
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
                    data: 'state',
                    name: 'state',
                    width: '15%'
                },
            ],
        });
    },
    fillDatatatablesEquiposActions(filter_nodo , filter_state){
        var datatable = $('#equipo_actions_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [[ 1, "desc" ]],
            processing: true,
            serverSide: true,
            "lengthChange": false,
                fixedHeader: {
                header: true,
                footer: true
            },
            "pagingType": "full_numbers",
            ajax:{
                url: "/equipos",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_state: filter_state,
                }
            },
            columns: [
                {
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
                    data: 'state',
                    name: 'state',
                    width: '15%'
                },
                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                },
                {
                    data: 'edit',
                    name: 'edit',
                    width: '15%',
                    orderable: false
                },
                {
                    data: 'changeState',
                    name: 'changeState',
                    width: '15%',
                    orderable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    width: '15%',
                    orderable: false
                },

            ],
        });
    },
    detail(id){
        $.ajax({
            dataType:'json',
            type:'get',
            url:`/equipos/${id}`
        }).done(function(response){

            $("#titulo").empty();
            $("#detalle_equipo").empty();
            if (response.statusCode == 404) {
                swal('Ups!!!', 'No se encontraron resultados', 'error');
            }else{
                let information = response.data.equipo;
                $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Equipo: </span>"+information.nombre+"");
                $("#detalle_equipo").append(`
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Linea Tecnológica: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.lineatecnologica.abreviatura} - ${information.lineatecnologica.nombre}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Referencia: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.referencia}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Marca: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.marca}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Costo Adquisición: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">$ ${information.costo_adquisicion}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Año de compra: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.anio_compra}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Vida Util: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.vida_util}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Año de depreciación: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${response.data.aniodepreciacion}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Valor depreciación por año: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">$ ${response.data.depreciacion}</span>
                        </div>
                    </div>
                    `);
                $('.modal-equipo').openModal();
            }
        })
    },
    deleteEquipo: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este equipo?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, elminar equipo',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: `/equipos/${id}`,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (response){
                        if(response.statusCode == 200){
                            Swal.fire(
                                'Eliminado!',
                                'El equipo ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = response.route;
                        }else if(response.statusCode == 226){
                            Swal.fire(
                                'No se puede elimnar!',
                                response.message,
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
                    'Tu equipo está a salvo',
                    'error'
                )
            }
        })
    },
    changeState: function(id){
        Swal.fire({
            title: '¿Estas seguro de cambiar el estado a  este equipo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, cambiar estado',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {

                $.ajax(
                {
                    url: `/equipos/cambiar-estado/${id}`,
                    type: 'GET',

                    success: function (response){
                        if(response.statusCode == 200){
                            Swal.fire(
                                'Estado cambiado!',
                                'El equipo ha cambiado de estado.',
                                'success'
                            );
                            location.href = response.route;
                        }else {
                            Swal.fire(
                                'No se puede cambiar estado!',
                                response.message,
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
                    'Tu equipo está a salvo',
                    'error'
                )
            }
        })
    }
}


$('#filter_equipo').click(function(){


    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();


    $('#equipo_data_table').dataTable().fnDestroy();

    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquipos(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquipos(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();

    }

    $('#equipo_actions_data_table').dataTable().fnDestroy();

    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquiposActions(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquiposActions(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_actions_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();

    }
});

$('#download_equipos').click(function(){

    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();

    var query = {
        filter_nodo: filter_nodo,
        filter_state: filter_state,
    }

    var url = "/equipos/export?" + $.param(query)
    window.location = url;
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

    usoinfraestructuraIndex.queryActivitiesByAnio();


    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_gestor = $('#filter_gestor').val();
    let filter_actividad = $('#filter_actividad').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null)  && (filter_gestor != '' || filter_gestor != null) && (filter_actividad != '' || filter_actividad != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo ,  filter_year, filter_gestor, filter_actividad);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined)  && (filter_gestor == '' || filter_gestor == null || filter_gestor == undefined) && (filter_actividad == '' || filter_actividad == null || filter_actividad == undefined)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_year = null, filter_gestor = null, filter_actividad = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

});

var usoinfraestructuraIndex = {
    fillDatatatablesUsosInfraestructura: function(filter_nodo , filter_year, filter_gestor, filter_actividad){
        var datatable = $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 0, "desc" ]],
            ajax:{
                url: "/usoinfraestructura",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_year: filter_year,
                    filter_gestor: filter_gestor,
                    filter_actividad: filter_actividad,
                }
            },
            columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                    width: '10%',
                    orderable: false,
                }, {
                    data: 'gestorEncargado',
                    name: 'gestorEncargado',
                    width: '20%',
                },
                {
                    data: 'tipo_asesoria',
                    name: 'tipo_asesoria',
                    width: '10%',
                },
                {
                    data: 'actividad',
                    name: 'actividad',
                    width: '35%',
                }, {
                    data: 'fase',
                    name: 'fase',
                    width: '10%',
                },  {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                    width: '5%',
                },  {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                    width: '5%',
                },  {
                    data: 'detail',
                    name: 'detail',
                    width: '5%',
                    orderable: false,
                },
            ],
        });
    },
    queryGestoresByNodo: function(){
        let nodo = $('#filter_nodo').val();

        if (nodo == null || nodo == '' || nodo == 'all' || nodo == undefined){
            $('#filter_gestor').empty();
            $('#filter_gestor').append('<option value="" selected>Seleccione un experto</option>');
        }else{
            $.ajax({
                type: 'GET',
                url: '/usuario/usuarios/gestores/nodo/'+ nodo,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {

                    $('#filter_gestor').empty();
                    $('#filter_gestor').append('<option value="all">todos</option>');
                    $.each(data.gestores, function(i, e) {
                        $('#filter_gestor').append('<option  value="'+i+'">'+e+'</option>');
                    })
                    $('#filter_gestor').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }
    },
    queryActivitiesByAnio: function(){

        let anio = $('#filter_year').val();

        if (anio == null || anio == '' || anio == undefined){

            $('#filter_actividad').empty();
            $('#filter_actividad').append('<option value="">Seleccione un año</option>');

        }else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ anio,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    $('#filter_actividad').empty();
                    $('#filter_actividad').append('<option value="all">Todas</option>');
                    $.each(data.actividades, function(i, e) {
                        $('#filter_actividad').append('<option  value="'+i+'">'+e+'</option>');
                    });
                    $('#filter_actividad').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
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
            confirmButtonText: 'si, eliminar uso',
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

$('#filter_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_gestor = $('#filter_gestor').val();
    let filter_actividad = $('#filter_actividad').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null)  && (filter_gestor != '' || filter_gestor != null) && (filter_actividad != '' || filter_actividad != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo ,  filter_year, filter_gestor, filter_actividad);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined)  && (filter_gestor == '' || filter_gestor == null || filter_gestor == undefined) && (filter_actividad == '' || filter_actividad == null || filter_actividad == undefined)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_year = null, filter_gestor = null, filter_actividad = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

});

$('#download_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_gestor = $('#filter_gestor').val();
    let filter_actividad = $('#filter_actividad').val();
    var query = {
        filter_nodo: filter_nodo,
        filter_year: filter_year,
        filter_gestor: filter_gestor,
        filter_actividad: filter_actividad,
    }
    var url = "/usoinfraestructura/export?" + $.param(query)
    window.location = url;
});

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
  Swal.fire('Advertencia!', 'Seleccione un experto', 'warning');
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
    Swal.fire('Advertencia!', 'Selecciona un experto!', 'warning');
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
        var datos = {
          gestores: [],
          tipo1Array: [],
          tipo2Array: [],
          tipo3Array: []
        };
        for (var i = 0; i < tamanho; i++) {
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
    Swal.fire('Advertencia!', 'Selecciona un experto!', 'warning');
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
  gestor: 'graficoSeguimientoEsperadoPorGestorDeUnNodo_column',
  nodo_esperado: 'graficoSeguimientoDeUnNodo_column',
  tecnoparque_esperado: 'graficoSeguimientoTecnoparque_column',
  nodo_fases: 'graficoSeguimientoDeUnNodoFases_column',
  tecnoparque_fases: 'graficoSeguimientoTecnoparqueFases_column',
  gestor_fases: 'graficoSeguimientoPorGestorFases_column',
  linea_esperado: 'graficoSeguimientoEsperadoPorLineaDeUnNodo_column',
  linea_actual: 'graficoSeguimientoActualPorLineaDeUnNodo_column',
  inscritos_mes: 'graficoSeguimientoInscritosPorMes_column'
};

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una línea tecnológica', 'warning');
};

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un experto', 'warning');
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
};
// 0 para cuando el Dinamizador consultar
// 1 para cuando el experto consulta

function consultarSeguimientoDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoEsperadoDeUnGestor/'+gestor_id,
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.gestor);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

// Bandera
// 0 para dinamizadores y expertos
// 1 para administradores
function consultarSeguimientoEsperadoDeUnaLinea(bandera) {
  let nodo_id = null;
  let linea_id = null;
  if (bandera == 0) {
    linea_id = $('#txtlinea_esperado').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
  } else {
    linea_id = $('#txtlinea_esperado').val();
    nodo_id = $('#txtnodo_linea_esperado').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
    if (nodo_id == '') {
      return alertaNodoNoValido();
    }
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoEsperadoDeUnaLinea/'+linea_id+'/'+nodo_id,
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.linea_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosPorMes(gestor_id) {
  if (gestor_id == null) {
      alertaGestorNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoInscritosPorMesExperto/'+gestor_id,
      success: function (data) {
        console.log(data.datos.meses);
        graficoSeguimientoPorMes(data, graficosSeguimiento.inscritos_mes);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function consultarSeguimientoActualDeUnaLinea(bandera) {
  let nodo_id = null;
  let linea_id = null;
  if (bandera == 0) {
    linea_id = $('#txtlinea_actual').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
  } else {
    linea_id = $('#txtlinea_actual').val();
    nodo_id = $('#txtnodo_linea_actual').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
    if (nodo_id == '') {
      return alertaNodoNoValido();
    }
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoActualDeUnaLinea/'+linea_id+'/'+nodo_id,
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.linea_actual);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarSeguimientoActualDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoActualDeUnGestor/'+gestor_id,
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.gestor_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoEsperadoDeTecnoparque() {
  
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoEsperadoDeTecnoparque/',
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.tecnoparque_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoEsperadoDeUnNodo(nodo_id) {

  if ( nodo_id === "" ) {
    alertaNodoNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoEsperadoDeUnNodo/'+nodo_id,
      success: function (data) {
        graficoSeguimientoEsperado(data, graficosSeguimiento.nodo_esperado);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

function consultarSeguimientoDeUnNodoFases(nodo_id) {
  if ( nodo_id === "" ) {
    alertaNodoNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: '/seguimiento/seguimientoDeUnNodoFases/'+nodo_id,
      success: function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
};

function consultarSeguimientoDeTecnoparqueFases() {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/seguimiento/seguimientoDeTecnoparqueFases/',
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.tecnoparque_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function graficoSeguimientoEsperado(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos que se encuentran activos'
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
            name: "TRL 6 esperados",
            y: data.datos.Esperado6,
          },
          {
            name: "TRL 7 - 8 esperados",
            y: data.datos.Esperado7_8,
          },
          {
            name: "Total de proyectos activos",
            y: data.datos.Activos,
          },
        ]
      }
    ],
  });
}

function graficoSeguimientoPorMes(data, name) {
  Highcharts.chart(name, {
    title: {
      text: 'Proyectos inscritos por mes en el año actual'
    },
    subtitle: {
      text: 'Cuando el mes no aparece es porque el valor es cero(0)'
    },
    yAxis: {
      title: {
        text: 'Cantidad de proyectos'
      }
    },
  
    xAxis: {
      categories: data.datos.meses,
      accessibility: {
        rangeDescription: 'Mes'
      }
    },
  
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    },
  
    // plotOptions: {
    //   series: {
    //     label: {
    //       connectorAllowed: false
    //     },
    //     pointStart: 2010
    //   }
    // },
  
    series: [{
      name: 'Proyectos inscritos',
      data: data.datos.cantidades
    }],
  
    responsive: {
      rules: [{
        condition: {
          maxWidth: 500
        },
        chartOptions: {
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
          }
        }
      }]
    }
  });
}

function graficoSeguimientoFases(data, name) {
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos actuales y finalizados en el año actual'
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
            name: "Proyectos en inicio",
            y: data.datos.Inicio,
          },
          {
            name: "Proyectos en planeación",
            y: data.datos.Planeacion,
          },
          {
            name: "Proyectos en ejecución",
            y: data.datos.Ejecucion,
          },
          {
            name: "Proyectos en cierre",
            y: data.datos.Cierre,
          },
          {
            name: "Proyectos finalizados",
            y: data.datos.Finalizado,
          },
          {
            name: "Proyectos suspendidos",
            y: data.datos.Suspendido,
          },
          {
            name: "Total de proyecto en el año actual",
            y: data.datos.Total,
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
        url: '/costos/proyecto/'+id,
        success: function (data) {
            let chart = '_actividad';
            console.log(data);
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
function detallesIdeasDelEntrenamiento(e){$.ajax({dataType:"json",type:"get",url:"entrenamientos/"+e,data:{identrenamiento:e}}).done(function(e){$("#ideasEntrenamiento").empty(),null!=e&&($("#fechasEntrenamiento").empty(),$("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha del taller de fortalecimiento: </span>"+e[0].fecha_sesion1+"<br>"),$.each(e,function(e,a){$("#ideasEntrenamiento").append("<tr><td>"+a.codigo_idea+" - "+a.nombre_proyecto+"</td><td>"+a.confirmacion+"</td><td>"+a.asistencia1+"</td></tr>")}),$("#modalIdeasEntrenamiento").openModal())})}function consultarEmpresaTecnoparque(){let e=$("#txtnit").val();e.length<9||e.length>13?Swal.fire({title:"Advertencia!",text:"El nit de la empresa debe tener entre 9 y 13 dígitos!",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}):""==e?Swal.fire({title:"Advertencia!",text:"Digite el nit de la empresa!",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}):$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetallesDeUnaEmpresa/"+e+"/nit",success:function(a){if(null==a.empresa)divEmpresaRegistrada.hide(),divRegistrarEmpresa.show(),$("#txtnit_empresa").val(e),$("label[for='txtnit_empresa']").addClass("active");else{let e;asignarValoresFRMIdeas(a),divEmpresaRegistrada.show(),divRegistrarEmpresa.hide(),reiniciarSede(),e=mostrarSedesEmpresa(a),$("#sedesEmpresaFormIdea").append(e)}},error:function(e,a,t){alert("Error: "+t)}})}function reiniciarSede(){$("#sedesEmpresaFormIdea").empty(),$("#txtsede_id").val(""),$("#txtnombre_sede_disabled").val("Primero debes seleccionar una sede")}function mostrarSedesEmpresa(e){let a="";return e.empresa.sedes.forEach(e=>{a+='<li class="collection-item">\n      '+e.nombre_sede+" - "+e.direccion+" "+e.ciudad.nombre+" ("+e.ciudad.departamento.nombre+')\n      <a href="#!" class="secondary-content" onclick="asociarSedeAIdeaProyecto('+e.id+')">Asociar esta sede de la empresa a la idea de proyecto</a></div>\n    </li>'}),a}function asociarSedeAIdeaProyecto(e){$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetalleDeUnaSede/"+e,success:function(e){$("#txtsede_id").val(e.sede.id),$("#txtnombre_sede_disabled").val(e.sede.nombre_sede+" - "+e.sede.direccion+" "+e.sede.ciudad.nombre+" ("+e.sede.ciudad.departamento.nombre+")"),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La sede "+e.sede.nombre_sede+" se asoció a la idea de proyecto!"})},error:function(e,a,t){alert("Error: "+t)}})}function modalOpcionesFormulario(e){e.preventDefault(),Swal.fire({title:"Guardar información",html:'¿Qué desea hacer?<br><button type="button" role="button" tabindex="0" class="btnModalIdeaGuardar swal2-guardar-custom">Guardar</button><button type="button" role="button" tabindex="0" class="btnModalIdeaPostular swal2-postular-custom">Postular</button><button type="button" role="button" tabindex="0" class="btnModalIdeaCancelar swal2-cancelar-custom">Cancelar</button>',showCancelButton:!1,showConfirmButton:!1,type:"warning"})}function modalOpcionesFormularioModificar(e){e.preventDefault(),Swal.fire({title:"Modificar información",html:'¿Qué desea hacer?<br><button type="button" role="button" tabindex="0" class="btnModalIdeaModificar swal2-guardar-custom">Modificar</button><button type="button" role="button" tabindex="0" class="btnModalIdeaPostularModificar swal2-postular-custom">Postular</button><button type="button" role="button" tabindex="0" class="btnModalIdeaCancelar swal2-cancelar-custom">Cancelar</button>',showCancelButton:!1,showConfirmButton:!1,type:"warning"})}function enviarIdeaRegistro(e,a){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var t=null,o=null;"create"==a?(t=$("#frmIdea_Inicio"),o=new FormData($("#frmIdea_Inicio")[0])):(t=$("#frmIdea_Update"),o=new FormData($("#frmIdea_Update")[0]));var n=t.attr("action");ajaxSendFormIdea(t,o,n)}function asignarValoresFRMIdeas(e){$("#txtnombre_empresa_det").val(e.empresa.nombre),$("label[for='txtnombre_empresa_det']").addClass("active"),$("#txttipo_empresa_det").val(e.empresa.tipoempresa.nombre),$("label[for='txttipo_empresa_det']").addClass("active"),$("#txttamanho_empresa_det").val(e.empresa.tamanhoempresa.nombre),$("label[for='txttamanho_empresa_det']").addClass("active"),$("#txtsector_empresa_det").val(e.empresa.sector.nombre),$("label[for='txtsector_empresa_det']").addClass("active"),$("#txtnit_empresa").val(e.empresa.nit)}function ajaxSendFormIdea(e,a,t){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),mensajesIdeaForm(e)},error:function(e,a,t){alert("Error: "+t)}})}function pintarMensajeIdeaForm(e,a,t){Swal.fire({title:e,html:a,type:t,showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesIdeaForm(e){let a="error",t="error",o="error";a=e.title,t=e.msg,o=e.type,"error_form"!=e.state&&pintarMensajeIdeaForm(a,t,o),"registro"==e.state&&setTimeout(function(){window.location.href=e.url},5e3),"update"==e.state&&setTimeout(function(){window.location.href=e.url},5e3)}function showInput_ProductoParecido(){$("#txtproducto_parecido").is(":checked")?divProductoParecido.show():divProductoParecido.hide()}function showInput_Reemplaza(){$("#txtreemplaza").is(":checked")?divReemplaza.show():divReemplaza.hide()}function showInput_Packing(){$("#txtpacking").is(":checked")?divPacking.show():divPacking.hide()}function showInput_RequisitosLegales(){$("#txtrequisitos_legales").is(":checked")?divRequisitosLegales.show():divRequisitosLegales.hide()}function showInput_BuscarEmpresa(){$("#txtidea_empresa").is(":checked")?divBuscarEmpresa.show():divBuscarEmpresa.hide()}function showInput_Certificaciones(){$("#txtrequiere_certificaciones").is(":checked")?divCertificaciones.show():divCertificaciones.hide()}function showInput_Recursos(){$("#txtrecursos_necesarios").is(":checked")?divRecursos.show():divRecursos.hide()}function showInput_Convocatoria(){$("#txtviene_convocatoria").is(":checked")?divConvocatoria.show():divConvocatoria.hide()}function showInput_AvalEmpresa(){$("#txtaval_empresa").is(":checked")?divAvalEmpresa.show():divAvalEmpresa.hide()}function consultarProyectosDeTalentos(){$("#tblProyectoDelTalento").dataTable().fnDestroy(),$("#tblProyectoDelTalento").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelTalento/",data:function(e){e.codigo_proyecto=$(".codigo_proyecto").val(),e.nombre=$(".nombre").val(),e.nombre_fase=$(".nombre_fase").val(),e.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"nombre_gestor",name:"nombre_gestor"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"8%",data:"proceso",name:"proceso",orderable:!1}]})}function consultarIdeasDelTalento(){$("#tbl_IdeasDelTalento").dataTable().fnDestroy(),$("#tbl_IdeasDelTalento").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/idea/datatableIdeasDeTalentos/"},columns:[{width:"15%",data:"codigo_idea",name:"codigo_idea"},{width:"8%",data:"nodo",name:"nodo"},{data:"nombre_proyecto",name:"nombre_proyecto"},{data:"estado",name:"estado"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"8%",data:"postular",name:"postular",orderable:!1},{width:"8%",data:"edit",name:"edit",orderable:!1}]})}function confirmacionPostulacion(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de postular esta idea de proyecto?",text:"Una vez que se postule la idea de proyecto, ya no se podrá cambiar los datos de esta.",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmEnviarIdeaTalento.submit()})}function confirmacionDuplicacion(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de duplicar esta idea de proyecto?",text:"Esto se recomienda hacer en caso de que se quiera continuar con el proceso en tecnoparque.",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmDuplicarIdea.submit()})}function confirmacionInhabilitar(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de inhabilitar esta idea de proyecto?",text:"Esto quiere decir que esta idea de proyecto no se le podrá realizar un proceso en tecnoparque.",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmInhabilitarIdea.submit()})}function consultarIdeasEnviadasAlNodo(){$("#tbl_IdeasEnviadasDelNodo").dataTable().fnDestroy(),$("#tbl_IdeasEnviadasDelNodo").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/idea/datatableIdeasDeTalentos/"},columns:[{width:"15%",data:"codigo_idea",name:"codigo_idea"},{data:"nombre_proyecto",name:"nombre_proyecto"},{data:"nombre_talento",name:"nombre_talento"},{data:"estado",name:"estado"},{width:"8%",data:"info",name:"info",orderable:!1}]})}function consultarEntrenamientosPorNodo_Administrador(e){$("#entrenamientosPorNodo_tableAdministrador").dataTable().fnDestroy(),$("#entrenamientosPorNodo_tableAdministrador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/entrenamientos/consultarEntrenamientosPorNodo/",type:"get",data:{filter_nodo:e.value}},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{width:"8%",data:"details",name:"details",orderable:!1},{width:"8%",data:"evidencias",name:"evidencias",orderable:!1}]})}function noSeEncontraronResultados(){Swal.fire({title:"¿Desea inhabilitar elentrenamiento?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, inhabilitar"})}function inhabilitarEntrenamientoPorId(e,a){Swal.fire({title:"¿Desea inhabilitar el entrenamiento?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, inhabilitar"}).then(a=>{a.value&&Swal.fire({title:"¿Qué desea hacer?",text:"Seleccione lo que ocurrirá con las ideas de proyecto que están asociasdas al entrenamiento",type:"warning",footer:'<a onclick="Swal.close()" href="#">Cancelar</a>',confirmButtonText:'<a class="white-text" onclick="cambiarEstadoDeIdeasDeProyectoDeEntrenamiento('+e+', \'Inhabilitado\'); Swal.close()" href="#">Inhabilitar las ideas de proyecto</a>',cancelButtonColor:"#d33",showCancelButton:!0,cancelButtonText:'<a class="white-text" onclick="cambiarEstadoDeIdeasDeProyectoDeEntrenamiento('+e+', \'Inicio\'); Swal.close()" href="#">Regresar las ideas de proyecto al estado de Inicio</a>',focusConfirm:!1})})}function cambiarEstadoDeIdeasDeProyectoDeEntrenamiento(e,a){$.ajax({dataType:"json",type:"get",url:"/entrenamientos/inhabilitarEntrenamiento/"+e+"/"+a,success:function(e){console.log(e),"true"==e.update&&Swal.fire({title:"El entrenamiento se ha inhabilitado!",html:"Las ideas de proyecto del entrenamiento han cambiado su estado a: "+e.estado,type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok!"}),"1"==e.update&&Swal.fire({title:"No se puede inhabilitar el entrenamiento!",html:"Al parecer, las siguientes ideas de proyecto se encuentran registradas en un comité: </br> <b> "+e.ideas+"</b></br>Si deseas hacer esto, las ideas de proyecto asociadas al entrenamiento no pueden estar en proyecto ó CSIBT",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Entiendo!"})},error:function(e,a,t){alert("Error: "+t)}})}function ajaxSendFormEntrenamiento(e,a,t,o){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),mensajesEntrenamientoCreate(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesEntrenamientoCreate(e){"error_form"!=e.state&&Swal.fire({title:e.title,html:e.msg,type:e.type,showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"registro"==e.state&&setTimeout(function(){window.location.href=e.url},1500),"update"==e.state&&setTimeout(function(){window.location.href=e.url},1500)}function noRepeatIdeasTaller(e){let a=e,t=!0,o=document.getElementsByName("ideas_taller[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function getValorConfirmacion(){return $("#txtconfirmacion").is(":checked")?1:0}function getValorAsistencia(){return $("#txtasistencia").is(":checked")?1:0}function addIdeaToEntrenamiento(){let e=$("#txtidea_taller").val(),a=getValorConfirmacion(),t=getValorAsistencia();0==e?Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"error",title:"Estás ingresando mal los datos"}):0==noRepeatIdeasTaller(e)?Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"La idea de proyecto ya se encuentra asociada al taller!"}):pintarIdeaEnLaTablaTaller(e,a,t)}function pintarIdeaEnLaTablaTaller(e,a,t){$.ajax({dataType:"json",type:"get",url:"/idea/detallesIdea/"+e}).done(function(e){let o=prepararFilaEnLaTablaDeIdeasTaller(e,a,t);$("#tblIdeasEntrenamientoForm").append(o),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"success",title:"La idea de proyecto se asoció con éxito al taller"}),reiniciarCamposTaller()})}function reiniciarCamposTaller(){$("#txtidea_taller").val("0"),$("#txtidea_taller").select2()}function prepararFilaEnLaTablaDeIdeasTaller(e,a,t){let o=e.detalles.id;return'<tr class="selected" id=ideaAsociadaTaller'+o+'><td><input type="hidden" name="ideas_taller[]" value="'+o+'">'+e.detalles.codigo_idea+" - "+e.detalles.nombre_proyecto+'</td><td><input type="hidden" name="confirmaciones[]" value="'+a+'">'+getYesOrNot(a)+'</td><td><input type="hidden" name="asistencias[]" value="'+t+'">'+getYesOrNot(t)+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelTaller('+o+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function eliminarIdeaDelTaller(e){$("#ideaAsociadaTaller"+e).remove()}function getYesOrNot(e){return 0==e?"No":"Si"}function enviarNotificacionResultadosCSIBT(e,a){$.ajax({type:"get",url:"/csibt/notificar_resultado/"+e+"/"+a,dataType:"json",processData:!1,success:function(e){"notifica"==e.state?notificacionExitosaDelResultado(e):notificacionFallidaDelResultado()},error:function(e,a,t){alert("Error: "+t)}})}function notificacionExitosaDelResultado(e){Swal.fire({title:"Notificación Exitosa!",text:"Se ha enviado un mensaje a la dirección: "+e.idea+" con los resultados del comité.",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function notificacionFallidaDelResultado(){Swal.fire({title:"Notificación Fallida!",text:"No se ha logrado enviar una mensaje con los resultados del comité al talento.",type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function confirmacionDuplicidad(e,a){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de duplicar esta idea de proyecto?",text:"Debes tener en cuenta que a partir de esta idea se va a registrar mas de un TRL.",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&Swal.fire({title:"Verificación. ¿Está seguro(a) de duplicar esta idea de proyecto?",text:"Esta acción no se podrá revertir.",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Continuar!"}).then(e=>{e.value&&(location.href=a)})})}function ajaxSendFormComiteAsignar(e,a,t,o){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),"create"==o&&mensajesComiteAsignarCreate(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesComiteAsignarCreate(e){"registro"==e.state&&(Swal.fire({title:"Registro Exitoso",text:"La asignación de ideas de proyecto del comité ha sido registrada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_registro"==e.state&&Swal.fire({title:"La asignación de ideas de proyecto del comité no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function addIdeaComite(){let e=$("#txtideaproyecto").val(),a=$("#txthoraidea").val(),t=$("#txtdireccion").val();0==e||""==a||""==t?datosIncompletosAgendamiento():0==noRepeatIdeasAgendamiento(e)?ideaYaSeEncuentraAsociadaAgendamiento():pintarIdeaEnLaTabla(e,a,t)}function addGestorComite(){let e=$("#txtidgestor").val(),a=$("#txthorainiciogestor").val(),t=$("#txthorafingestor").val();0==e||""==a||""==t?datosIncompletosGestorAgendamiento():0==noRepeatGestoresAgendamiento(e)?gestorYaSeEncuentraAsociadoAgendamiento():pintarGestorEnLaTabla(e,a,t)}function eliminarIdeaDelAgendamiento(e){$("#ideaAsociadaAgendamiento"+e).remove()}function eliminarGestorDelAgendamiento(e){$("#gestorAsociadoAgendamiento"+e).remove()}function ajaxSendFormComiteAgendamiento(e,a,t,o){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),"create"==o?mensajesComiteAgendamientoCreate(e):mensajesComiteAgendamientoUpdate(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesComiteAgendamientoCreate(e){"registro"==e.state&&(Swal.fire({title:"Registro Exitoso",text:"El comité ha sido registrado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_registro"==e.state&&Swal.fire({title:"El comité no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesComiteAgendamientoUpdate(e){"update"==e.state&&(Swal.fire({title:"Modificación Exitosa",text:"El comité se ha modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_update"==e.state&&Swal.fire({title:"El comité no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function pintarIdeaEnLaTabla(e,a,t){$.ajax({dataType:"json",type:"get",url:"/idea/detallesIdea/"+e}).done(function(e){let o=prepararFilaEnLaTablaDeIdeas(e,a,t);$("#tblIdeasComiteCreate").append(o),ideaSeAsocioAlAgendamiento(),reiniciarCamposAgendamiento()})}function pintarGestorEnLaTabla(e,a,t){$.ajax({dataType:"json",type:"get",url:"/usuario/consultarUserPorId/"+e}).done(function(e){let o=prepararFilaEnLaTablaDeGestores(e,a,t);$("#tblGestoresComiteCreate").append(o),gestorSeAsocioAlAgendamiento(),reiniciarCamposGestorAgendamiento()})}function prepararFilaEnLaTablaDeIdeas(e,a,t){let o=e.detalles.id;return'<tr class="selected" id=ideaAsociadaAgendamiento'+o+'><td><input type="hidden" name="ideas[]" value="'+o+'">'+e.detalles.nombre_proyecto+'</td><td><input type="hidden" name="horas[]" value="'+a+'">'+a+'</td><td><input type="hidden" name="direcciones[]" value="'+t+'">'+t+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelAgendamiento('+o+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDeGestores(e,a,t){let o=e.user.gestor.id;return'<tr class="selected" id=gestorAsociadoAgendamiento'+o+'><td><input type="hidden" name="gestores[]" value="'+o+'">'+e.user.documento+" - "+e.user.nombres+" "+e.user.apellidos+'</td><td><input type="hidden" name="horas_inicio[]" value="'+a+'">'+a+'</td><td><input type="hidden" name="horas_fin[]" value="'+t+'">'+t+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarGestorDelAgendamiento('+o+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function datosIncompletosAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"error",title:"Estás ingresando mal los datos"})}function datosIncompletosGestorAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"error",title:"Estás ingresando mal los datos del experto"})}function ideaSeAsocioAlAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"success",title:"La idea de proyecto se asoció con éxito al comité"})}function gestorSeAsocioAlAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"success",title:"El experto se asoció con éxito al comité"})}function ideaYaSeEncuentraAsociadaAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"La idea de proyecto ya se encuentra asociada al comité!"})}function gestorYaSeEncuentraAsociadoAgendamiento(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El experto ya se encuentra asociado en este comité!"})}function noRepeatIdeasAgendamiento(e){let a=e,t=!0,o=document.getElementsByName("ideas[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function noRepeatGestoresAgendamiento(e){let a=e,t=!0,o=document.getElementsByName("gestores[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function reiniciarCamposAgendamiento(){$("#txtideaproyecto").val("0"),$("#txtideaproyecto").select2(),$("#txthoraidea").val(""),$("#txtobservacionesidea").val(""),$("#txtdireccion").val(""),$("label[for='txtdireccion']").removeClass("active"),$("label[for='txthoraidea']").removeClass("active")}function reiniciarCamposGestorAgendamiento(){$("#txtidgestor").val("0"),$("#txtidgestor").select2(),$("#txthorainiciogestor").val(""),$("label[for='txthorainiciogestor']").removeClass("active"),$("#txthorafingestor").val(""),$("label[for='txthorafingestor']").removeClass("active")}function ajaxSendFormComiteRealizado(e,a,t,o){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),"create"==o&&mensajesComiteRealizadoCreate(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesComiteRealizadoCreate(e){"registro"==e.state&&(Swal.fire({title:"Registro Exitoso",text:"La calificación del comité ha sido registrada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/csibt")},1e3)),"no_registro"==e.state&&Swal.fire({title:"La calificación del comité no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function consultarCsibtPorNodo(){let e=$("#txtnodo").val();$("#comitesDelNodoAdministrador_table").dataTable().fnDestroy(),$("#comitesDelNodoAdministrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:!1,ajax:{url:"/csibt/"+e+"/consultarCsibtPorNodo",type:"get"},columns:[{data:"codigo",name:"codigo"},{data:"fechacomite",name:"fechacomite"},{data:"estadocomite",name:"estadocomite"},{data:"observaciones",name:"observaciones"},{data:"details",name:"details",orderable:!1}]})}$(document).ready(function(){$("#linea_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"lineas"},columns:[{data:"abreviatura",name:"abreviatura"},{data:"nombre",name:"nombre"},{data:"show",name:"show",orderable:!1},{data:"action",name:"action",orderable:!1}]})}),$(document).ready(function(){$("#linea_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"lineas"},columns:[{data:"abreviatura",name:"abreviatura"},{data:"nombre",name:"nombre"},{data:"action",name:"action",orderable:!1}]})}),$(document).ready(function(){$("#nodos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!0,responsive:!0,bSort:!1,dom:"Bfrtip",buttons:[{extend:"csv",text:"exportar csv",exportOptions:{columns:":visible"}},{extend:"excel",exportOptions:{columns:":visible"}},{extend:"pdf",exportOptions:{columns:":visible"}}],ajax:{url:"/nodo"},columns:[{data:"centro",name:"centro"},{data:"nodos",name:"nodos"},{data:"direccion",name:"direccion"},{data:"ubicacion",name:"ubicacion"},{data:"detail",name:"detail",orderable:!1}]})}),$(document).ready(function(){$("#entrenamientosPorNodo_tableDinamizador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/entrenamientos/consultarEntrenamientosPorNodo",type:"get"},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{width:"8%",data:"details",name:"details",orderable:!1},{width:"8%",data:"evidencias",name:"evidencias",orderable:!1}]}),$("#entrenamientos_nodo_table_articulador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/entrenamientos/consultarEntrenamientosPorNodo",type:"get",data:{nodo:null}},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{width:"8%",data:"details",name:"details",orderable:!1},{width:"8%",data:"edit",name:"edit",orderable:!1},{width:"8%",data:"evidencias",name:"evidencias",orderable:!1}]})}),$(document).ready(function(){divProductoParecido=$("#productoParecido_content"),divReemplaza=$("#reemplaza_content"),divPacking=$("#packing_content"),divRequisitosLegales=$("#requisitosLegales_content"),divCertificaciones=$("#certificaciones_content"),divRecursos=$("#recursos_content"),divConvocatoria=$("#convocatoria_content"),divAvalEmpresa=$("#avalEmpresa_content"),divBuscarEmpresa=$("#buscarEmpresa_content"),divRegistrarEmpresa=$("#registrarEmpresa_content"),divEmpresaRegistrada=$("#consultarEmpresa_content"),divProductoParecido.hide(),divReemplaza.hide(),divPacking.hide(),divRequisitosLegales.hide(),divCertificaciones.hide(),divRecursos.hide(),divConvocatoria.hide(),divAvalEmpresa.hide(),divBuscarEmpresa.hide(),divRegistrarEmpresa.hide(),divEmpresaRegistrada.hide(),showInput_ProductoParecido(),showInput_Reemplaza(),showInput_Packing(),showInput_RequisitosLegales(),showInput_Certificaciones(),showInput_Recursos(),showInput_Convocatoria(),showInput_AvalEmpresa(),showInput_BuscarEmpresa()}),$(document).on("click",".btnModalIdeaCancelar",function(e){Swal.close()}),$(document).on("click",".btnModalIdeaGuardar",function(e){$("#txtopcionRegistro").val("guardar"),Swal.clickConfirm(),enviarIdeaRegistro(e,"create")}),$(document).on("click",".btnModalIdeaModificar",function(e){$("#txtopcionRegistro").val("guardar"),Swal.clickConfirm(),enviarIdeaRegistro(e,"update")}),$(document).on("click",".btnModalIdeaPostular",function(e){$("#txtopcionRegistro").val("postular"),Swal.clickConfirm(),enviarIdeaRegistro(e,"create")}),$(document).on("click",".btnModalIdeaPostularModificar",function(e){$("#txtopcionRegistro").val("postular"),Swal.clickConfirm(),enviarIdeaRegistro(e,"update")}),$(document).ready(function(){$("#entrenamientos_nodo_table").dataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,paging:!0,ajax:{url:"/entrenamientos",type:"get"},columns:[{title:"Código del Entrenamiento",data:"codigo_entrenamiento",name:"codigo_entrenamiento"},{data:"fecha_sesion1",name:"fecha_sesion1"},{data:"fecha_sesion2",name:"fecha_sesion2"},{data:"correos",name:"correos"},{data:"fotos",name:"fotos"},{data:"listado_asistencia",name:"listado_asistencia"},{width:"8%",data:"details",name:"details",orderable:!1},{width:"8%",data:"edit",name:"edit",orderable:!1},{width:"8%",data:"update_state",name:"update_state",orderable:!1},{width:"8%",data:"evidencias",name:"evidencias",orderable:!1}]}),$("a.toggle-vis").on("click",function(e){e.preventDefault();var a=table.column($(this).attr("data-column"));a.visible(!a.visible())})}),$(document).ready(function(){$("#txtfecha_sesion1").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}).on("change",function(e,a){$("#txtsegundasesion").bootstrapMaterialDatePicker("setMinDate",a)})}),$(document).on("submit","form#formEntrenamientosCreate",function(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(a=>{if(a.value){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormEntrenamiento(t,o,n,"create")}})}),$(document).on("submit","form#formComiteAsignarCreate",function(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",text:"No podrás revertir estos cambios!",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(a=>{if(a.value){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteAsignar(t,o,n,"create")}})}),$(document).ready(function(){$(".dataTables_length select").addClass("browser-default"),$("#comitesDelNodo_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:!1,ajax:{url:"/csibt",type:"get"},columns:[{data:"codigo",name:"codigo"},{data:"fechacomite",name:"fechacomite"},{data:"estadocomite",name:"estadocomite"},{data:"observaciones",name:"observaciones"},{data:"details",name:"details",orderable:!1}],initComplete:function(){this.api().columns().every(function(){var e=this,a=document.createElement("input");$(a).appendTo($(e.footer()).empty()).on("change",function(){e.search($(this).val(),!1,!1,!0).draw()})})}})}),csibt={consultarComitesPorNodo:function(e){$.ajax({dataType:"json",type:"get",url:"/csibt/"+e}).done(function(e){console.log(e),$("#ideasProyectoDeUnComite").empty(),null!=e&&($("#fechaComiteModal").empty(),$("#fechaComiteModal").append("<span class='cyan-text text-darken-3'>Fecha del Comité: </span>"+e.ideasDelComite[0].fechacomite),$.each(e.ideasDelComite,function(e,a){let t='<a class="btn cyan m-b-xs" onclick="csibt.consultarIdeaProyectoAsociadaAlEntrenamiento('+a.id+')"><i class="material-icons">library_books</i></a>',o='<a target="_blank" href="/idea/'+a.id+'/edit" class="waves-effect waves-light btn btn-info m-b-xs"><i class="material-icons">edit</i></a>';$("#ideasProyectoDeUnComite").append("<tr><td>"+a.nombre_proyecto+"</td><td>"+a.hora+"</td><td>"+a.asistencia+"</td><td>"+a.observaciones+"</td><td>"+a.admitido+"</td><td>"+o+"</td><td>"+t+"</td></tr>")}),$("#modalIdeasComite").openModal())})},consultarIdeaProyectoAsociadaAlEntrenamiento:function(e){$.ajax({dataType:"json",type:"get",url:"/idea/detallesIdea/"+e}).done(function(e){$("#titulo").empty(),$("#detalle_idea").empty(),null==e?swal("Ups!!","Ha ocurrido un error","warning"):($("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+e.detalles.nombre_proyecto),$("#detalle_idea").append('<div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.aprendiz_sena+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.pregunta1String+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.pregunta2String+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Descripcion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.descripcion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Objetivo: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.objetivo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Alcance: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.alcance+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">¿La idea viene de una convocatoria? </span></div><div class="col s12 m6 l6"><span class="black-text">'+vieneConvocatoria(e.detalles.viene_convocatoria)+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de Convocatoria: </span></div><div class="col s12 m6 l6"><span class="black-text">'+nombreConvocatoria(e.detalles.viene_convocatoria,e.detalles.convocatoria)+"</span></div></div>"),$("#ideaProyecto").openModal())})}},$("#txthoraidea").bootstrapMaterialDatePicker({time:!0,date:!1,shortTime:!0,format:"HH:mm",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$("#txthorafingestor").bootstrapMaterialDatePicker({time:!0,date:!1,shortTime:!0,format:"HH:mm",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$("#txthorainiciogestor").bootstrapMaterialDatePicker({time:!0,date:!1,shortTime:!0,format:"HH:mm",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$("#txthorafingestor").bootstrapMaterialDatePicker({time:!0,date:!1,shortTime:!0,format:"HH:mm",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$(document).on("submit","form#formComiteAgendamientoCreate",function(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(a=>{if(a.value){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteAgendamiento(t,o,n,"create")}})}),$(document).on("submit","form#formComiteAgendamientoUpdate",function(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(a=>{if(a.value){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteAgendamiento(t,o,n,"update")}})}),$(document).on("submit","form#formComiteRealizadoCreate",function(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de guardar esta información?",text:"Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los expertos puedes cambiar esta información",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí, guardar"}).then(a=>{if(a.value){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");ajaxSendFormComiteRealizado(t,o,n,"create")}})}),$(document).ready(function(){$("#comitesDelNodoGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:!1,ajax:{url:"/csibt",type:"get"},columns:[{data:"codigo",name:"codigo"},{data:"fechacomite",name:"fechacomite"},{data:"estadocomite",name:"estadocomite"},{data:"observaciones",name:"observaciones"},{data:"details",name:"details",orderable:!1}],initComplete:function(){this.api().columns().every(function(){var e=this,a=document.createElement("input");$(a).appendTo($(e.footer()).empty()).on("change",function(){e.search($(this).val(),!1,!1,!0).draw()})})}})}),$(document).ready(function(){$("#empresasDeTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"sector_empresa",name:"sector_empresa"},{data:"details",name:"details",orderable:!1}]})}),$(document).on("submit","form#formRegisterCompany",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),printErroresFormulario(e),"error"==e.state&&0==e.url&&Swal.fire({title:"La empresa no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"success"==e.state&&0!=e.url&&(Swal.fire({title:"Registro Exitoso",text:e.message,type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3))}})}),$(document).on("submit","form#formEditCompany",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),printErroresFormulario(e),"error_form"!=e.state&&Swal.fire({title:e.title,html:e.msg,type:e.type,showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"update"==e.state&&setTimeout(function(){window.location.href=e.url},1500)}})}),$(document).on("submit","form#formEditCompanyHq",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),printErroresFormulario(e),"error_form"!=e.state&&Swal.fire({title:e.title,html:e.msg,type:e.type,showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"update"==e.state&&setTimeout(function(){window.location.href=e.url},1500)}})}),$(document).on("submit","form#formAddCompanyHq",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),printErroresFormulario(e),"error_form"!=e.state&&Swal.fire({title:e.title,html:e.msg,type:e.type,showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"store"==e.state&&setTimeout(function(){window.location.href=e.url},1500)}})}),$(document).on("submit","form#formEditResponsable",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),printErroresFormulario(e),"error_form"!=e.state&&Swal.fire({title:e.title,html:e.msg,type:e.type,showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"update"==e.state&&setTimeout(function(){window.location.href=e.url},1500)}})}),$(document).on("submit","form#formSearchEmpresas",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault(),$("#empresas_encontradas").empty();let a=$("#txtnit_search").val();if(new RegExp("^[0-9]{9,13}$").test(a)){var t=$(this),o=new FormData($(this)[0]),n=t.attr("action");$.ajax({type:t.attr("method"),url:n,data:o,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){0==e.empresas.length?$("#empresas_encontradas").append('\n                        <div class="row">\n                            <ul class="collection with-header">\n                                <li class="collection-header"><h5>No se encontraron empresas</h5></li>\n                            </ul>\n                        </div>\n                    '):"search"==e.state&&($("#empresas_encontradas").append('<div class="row">'),$.each(e.empresas,function(a,t){let o=e.urls[a];$("#empresas_encontradas").append('\n                                <ul class="collection">\n                                    <li class="collection-item"><h5>'+t.nit+" - "+t.nombre+'</h5></li>\n                                    <li class="collection-item"><a href='+o+">Ver detalles</a></li>\n                                </ul>\n                            ")}),$("#empresas_encontradas").append("</div>")),$('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1)}})}else Swal.fire("Estás ingresando mal los datos!","Por favor ingrese un nit válido entre 6 y 13 dígitos (no se permiten puntos ni código de verificación)","error"),$('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1)}),$(document).ready(function(){$("#grupoDeInvestigacionTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{data:"ciudad",name:"ciudad"},{data:"tipo_grupo",name:"tipo_grupo"},{data:"institucion",name:"institucion"},{data:"clasificacioncolciencias",name:"clasificacioncolciencias"},{data:"details",name:"details",orderable:!1},{data:"contacts",name:"contacts",orderable:!1},{data:"edit",name:"edit",orderable:!1}]})}),$("#grupoDeInvestigacionTecnoparque_tableNoGestor").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{data:"ciudad",name:"ciudad"},{data:"tipo_grupo",name:"tipo_grupo"},{data:"institucion",name:"institucion"},{data:"clasificacioncolciencias",name:"clasificacioncolciencias"},{data:"details",name:"details",orderable:!1}]});var grupoInvestigacionIndex={consultarDetallesDeUnGrupoInvestigacion:function(e){$.ajax({dataType:"json",type:"get",url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+e}).done(function(e){if($("#modalDetalleDeUnGrupoDeInvestigacion_titulo").empty(),$("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").empty(),null==e)swal("Ups!!","Ha ocurrido un error","warning");else{let a="Interno";0==e.detalles.tipogrupo&&(a="Externo"),$("#modalDetalleDeUnGrupoDeInvestigacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>"),$("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.codigo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.entidad.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.entidad.email_entidad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.entidad.ciudad.nombre+" - "+e.detalles.entidad.ciudad.departamento.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.institucion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.clasificacioncolciencias.nombre+"</span></div></div>"),$("#detalleDeUnGrupoDeInvestigacion").openModal()}})}};$(document).on("submit","form#formSearchUser",function(e){e.preventDefault(),$("#response-alert").empty();let a=$("#txttype_search").val(),t=$("#txtsearch_user").val(),o=new RegExp("^[0-9]{6,11}$");if(""==a)Swal.fire("Error","Por favor selecciona una opción","error");else if(1!=a||null!=t&&""!=t&&o.test(t))if(2!=a||null!=t&&""!=t&&/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(t)){var n=$(this);let e=new FormData($(this)[0]);var i=n.attr("action");$.ajax({type:n.attr("method"),url:i,data:e,dataType:"json",cache:!1,dataType:"json",contentType:!1,processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),$("#response-alert").empty(),e.fail&&Swal.fire({title:"Registro Erróneo",html:"Estas ingresando mal los datos. "+errores,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),202==e.status?1==a?$("#response-alert").append('\n                            <div class="mailbox-list">\n                                <ul>\n                                    <li>\n                                        <a class="mail-active">\n                                            <h4 class="center-align">no se encontraron resultados</h4>\n                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="'+e.url+'">Registrar nuevo usuario</a>\n                                        </a>\n                                    </li>\n                                </ul>\n                            </div>\n                        '):$("#response-alert").append('\n                            <div class="mailbox-list">\n                                <ul>\n                                    <li>\n                                        <a class="mail-active">\n                                            <h4 class="center-align">no se encontraron resultados</h4>\n                                            <a target="_blank" class="grey-text text-darken-3 green accent-1 center-align" href="'+e.url+'">Registrar nuevo usuario</a>\n                                        </a>\n                                    </li>\n                                </ul>\n                            </div>\n                        '):200==e.status&&$("#response-alert").append('\n                    <div class="mailbox-list">\n                        <ul>\n                            <li >\n                                <a href="'+e.url+'" class="mail-active">\n\n                                    <h5 class="mail-author">'+e.user.documento+" - "+e.user.nombres+" "+e.user.apellidos+'</h5>\n                                    <h4 class="mail-title">'+e.roles+'</h4>\n                                    <p class="hide-on-small-and-down mail-text">Miembro desde '+userSearch.userCreated(e.user.created_at)+'</p>\n                                    <div class="position-top-right p f-12 mail-date"> Acceso al sistema: '+userSearch.state(e.user.estado)+"</div>\n                                </a>\n                            </li>\n                        </ul>\n                    </div>\n                    ")}})}else Swal.fire("Error","Por favor ingrese un correo electrónico válido","error");else Swal.fire("Error","Por favor ingrese un número de documento válido","error")});var userSearch={state:function(e){return e?"Si":"No"},userCreated:function(e){return null==e?"no registra":moment(e).format("LL")},changetextLabel:function(){let e=$("#txttype_search").val();$("#txtsearch_user").val(""),1==e?$("label[for='txtsearch_user']").text("Número de documento"):2==e&&$("label[for='txtsearch_user']").text("Correo Electrónico")}},user={getCiudadExpedicion:function(){let e;e=$("#txtdepartamentoexpedicion").val(),$.ajax({dataType:"json",type:"get",url:"/usuario/getciudad/"+e}).done(function(e){$("#txtciudadexpedicion").empty(),$.each(e.ciudades,function(e,a){$("#txtciudadexpedicion").append('<option  value="'+a.id+'">'+a.nombre+"</option>")}),$("#txtciudadexpedicion").material_select()})},getOtraEsp:function(e){let a=$(e).val();$("#txteps option:selected").text();42==a?$(".otraeps").removeAttr("style"):$(".otraeps").attr("style","display:none")},getCiudad:function(){let e;e=$("#txtdepartamento").val(),$.ajax({dataType:"json",type:"get",url:"/usuario/getciudad/"+e}).done(function(e){$("#txtciudad").empty(),$("#txtciudad").append('<option value="">Seleccione la Ciudad</option>'),$.each(e.ciudades,function(e,a){$("#txtciudad").append('<option  value="'+a.id+'">'+a.nombre+"</option>")}),$("#txtciudad").material_select()})},getGradoDiscapacidad(e){1==$(e).val()?$(".gradodiscapacidad").removeAttr("style"):$(".gradodiscapacidad").attr("style","display:none")}};$(document).ready(function(){$("#txtocupaciones").select2({language:"es",isMultiple:!0}),estudios.getOtraOcupacion()});var estudios={getOtraOcupacion:function(e){$("#otraocupacion").hide();$(e).val();let a=$("#txtocupaciones option:selected").text().match(/[A-Z][a-z]+/g);$("#otraocupacion").hide(),null!=a&&a.includes("Otra")&&$("#otraocupacion").show()}};$(document).ready(function(){tipoTalento.getSelectTipoTalento()});var tipoTalento={getSelectTipoTalento:function(e){let a=$(e).val();$("#txttipotalento option:selected").text();1==a||2==a?tipoTalento.showAprendizSena():3==a?tipoTalento.showEgresadoSena():4==a?tipoTalento.showInstructorSena():5==a?tipoTalento.showFuncionarioSena():6==a?tipoTalento.showPropietarioEmpresa():7==a?tipoTalento.showEmprendedor():8==a?tipoTalento.showUniversitario():9==a?tipoTalento.showFuncionarioEmpresa():tipoTalento.ShowSelectTipoTalento()},showAprendizSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".aprendizSena").css("display","block"),$(".aprendizSena").show()},showEgresadoSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".egresadoSena").show()},showInstructorSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".instructorSena").css("display","block")},showFuncionarioSena:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".funcionarioSena").css("display","block")},showPropietarioEmpresa:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".otherUser").empty(),$(".otherUser").append('<div class="valign-wrapper" >\n            <h5> Seleccionaste Propietario empresa</h5>\n        </div>')},showEmprendedor:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),$(".otherUser").empty(),$(".otherUser").append('<div class="valign-wrapper" >\n            <h5> Seleccionaste Emprendedor</h5>\n        </div>')},showUniversitario:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideEmprendedor(),tipoTalento.hideFuncionarioEmpresa(),$(".universitario").css("display","block")},showFuncionarioEmpresa:function(){tipoTalento.hideSelectTipoTalento(),tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideInstructorSena(),tipoTalento.hideFuncionarioSena(),tipoTalento.hidePropietarioEmpresa(),tipoTalento.hideUniversitario(),tipoTalento.hideEmprendedor(),$(".funcionarioEmpresa").css("display","block")},hideAprendizSena:function(){$(".aprendizSena").hide()},hideEgresadoSena:function(){$(".egresadoSena").hide()},hideInstructorSena:function(){$(".instructorSena").css("display","none")},hideFuncionarioSena:function(){$(".funcionarioSena").css("display","none")},hideSelectTipoTalento:function(){$(".selecttipotalento").css("display","none")},hidePropietarioEmpresa:function(){$(".otherUser").css("display","none")},hideUniversitario:function(){$(".universitario").css("display","none")},hideFuncionarioEmpresa:function(){$(".funcionarioEmpresa").css("display","none")},hideEmprendedor:function(){$(".otherUser").css("display","none")},ShowSelectTipoTalento:function(){tipoTalento.hideAprendizSena(),tipoTalento.hideEgresadoSena(),tipoTalento.hideEmprendedor(),tipoTalento.hideUniversitario(),tipoTalento.hideFuncionarioEmpresa(),tipoTalento.hideFuncionarioSena(),tipoTalento.hideInstructorSena(),tipoTalento.hidePropietarioEmpresa(),$(".selecttipotalento").css("display","block")},getCentroFormacionAprendiz:function(){let e=$("#txtregional_aprendiz").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+e}).done(function(e){$("#txtcentroformacion_aprendiz").empty(),$("#txtcentroformacion_aprendiz").append('<option value="">Seleccione el centro de formación</option>'),$.each(e.centros,function(e,a){$("#txtcentroformacion_aprendiz").append('<option  value="'+e+'">'+a+"</option>"),$("#txtcentroformacion_aprendiz").material_select()})})},getCentroFormacionEgresadoSena:function(){let e=$("#txtregional_egresado").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+e}).done(function(e){$("#txtcentroformacion_egresado").empty(),$("#txtcentroformacion_egresado").append('<option value="">Seleccione el centro de formación</option>'),$.each(e.centros,function(e,a){$("#txtcentroformacion_egresado").append('<option  value="'+e+'">'+a+"</option>"),$("#txtcentroformacion_egresado").material_select()})})},getCentroFormacionFuncionarioSena:function(){let e=$("#txtregional_funcionarioSena").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+e}).done(function(e){$("#txtcentroformacion_funcionarioSena").empty(),$("#txtcentroformacion_funcionarioSena").append('<option value="">Seleccione el centro de formación</option>'),$.each(e.centros,function(e,a){$("#txtcentroformacion_funcionarioSena").append('<option  value="'+e+'">'+a+"</option>"),$("#txtcentroformacion_funcionarioSena").material_select()})})},getCentroFormacionInstructorSena:function(){let e=$("#txtregional_instructorSena").val();$.ajax({dataType:"json",type:"get",url:"/centro-formacion/getcentrosregional/"+e}).done(function(e){$("#txtcentroformacion_instructorSena").empty(),$("#txtcentroformacion_instructorSena").append('<option value="">Seleccione el centro de formación</option>'),$.each(e.centros,function(e,a){$("#txtcentroformacion_instructorSena").append('<option  value="'+e+'">'+a+"</option>"),$("#txtcentroformacion_instructorSena").material_select()})})}};$(document).on("submit","form#formRegisterUser",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){if($('button[type="submit"]').prop("disabled",!1),$(".error").hide(),e.fail){for(control in e.errors)$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();createUser.printErroresFormulario(e)}"error"==e.state&&0==e.url&&Swal.fire({title:"El Usuario no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"success"==e.state&&0!=e.url&&(Swal.fire({title:"Registro Exitoso",text:"El Usuario "+e.user.nombres+" "+e.user.apellidos+"  ha sido creado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok",footer:'<p class="red-text">Hemos enviado un correo electrónico al  usuario '+e.user.nombres+" "+e.user.apellidos+" con las credenciales de ingreso a la plataforma.</p>"}),setTimeout(function(){window.location.href=e.url},1e3))}})});var createUser={printErroresFormulario:function(e){if("error_form"==e.state){let a="";for(control in e.errors)a+=" </br><b> - "+e.errors[control]+" </b> ",$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+a,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}};$(document).on("submit","form#formEditUser",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){if($('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),e.fail){for(control in e.errors)$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();EditUser.printErroresFormulario(e)}"error"==e.state&&(Swal.fire({title:"La cuenta del usuario no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3)),"success"==e.state&&(Swal.fire({title:"Modifciación Exitosa",text:"La cuenta del usuario ha sido modificada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3))}})});var EditUser={printErroresFormulario:function(e){if("error_form"==e.state){let a="";for(control in e.errors)a+=" </br><b> - "+e.errors[control]+" </b> ",$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+a,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}};$(document).on("submit","form#FormConfirmUser",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){if($('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),e.fail){for(control in e.errors)$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();EditUser.printErroresFormulario(e)}"error"==e.state&&0==e.url&&Swal.fire({title:"El Usuario no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),"success"==e.state&&0!=e.url&&(Swal.fire({title:"Modifciación Exitosa",text:"El Usuario "+e.user.nombres+" "+e.user.apellidos+"  ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3))},error:function(e,a,t){alert("Error: "+t)}})});var changeNode={printErroresFormulario:function(e){if("error_form"==e.state){let a="";for(control in e.errors)a+=" </br><b> - "+e.errors[control]+" </b> ",$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+a,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}};$(document).on("submit","form#FormChangeNodo",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){if($('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),e.fail){for(control in e.errors)$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();changeNode.printErroresFormulario(e)}"error"==e.state&&0==e.url&&Swal.fire({title:"El Usuario no se ha modificado, por favor inténtalo de nuevo",text:"Recuerde que si lo elimina no lo podrá recuperar.",type:"warning",text:e.message,showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"ok",cancelButtonText:"Ver actividades sin finalzar"}).then(a=>{if(a.value);else if(a.dismiss===Swal.DismissReason.cancel){let a="";$.each(e.activities,function(e,t){a+="</br><b> "+e+" - "+t+" </b> "}),Swal.fire({title:"actividades sin finalzar",html:a,type:"info",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}),"success"==e.state&&0!=e.url&&(Swal.fire({title:"Modifciación Exitosa",text:"El Usuario "+e.user.nombres+" "+e.user.apellidos+"  ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3))},error:function(e,a,t){alert("Error: "+t)}})}),$(document).ready(function(){let e=$("#filter_rol").val(),a=$("#filter_nodo").val(),t=$("#filter_state").val(),o=$("#filter_year").val();$("#users_data_table").dataTable().fnDestroy(),""==a&&null==a||""==e&&null==e||""==t||""==o?""!=a&&null!=a&&null!=a||""!=e&&null!=e&&null!=e||""==t||""!=o&&null!=o&&null!=o?$("#users_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():UserIndex.fillDatatatablesUsers(a=null,e=null,t,o=null):UserIndex.fillDatatatablesUsers(a,e,t,o),$("#mytalento_data_table").dataTable().fnDestroy(),""==a&&null==a||""==e&&null==e||""==t||""==o?""!=a&&null!=a&&null!=a||""!=e&&null!=e&&null!=e||""==t||""!=o&&null!=o&&null!=o?$("#mytalento_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():UserIndex.fillDatatatablesTalentos(a=null,e=null,t,o=null):UserIndex.fillDatatatablesTalentos(a,e,t,o)});var UserIndex={showInputs(){"Talento"==$("#filter_rol").val()?($("#divyear").show(),$('#filter_year>option[value="all"]').attr("selected","selected")):($("#divyear").hide(),$('#filter_year>option[value="all"]').attr("selected","selected"))},fillDatatatablesUsers(e,a,t,o){$("#users_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[[1,"desc"]],ajax:{url:"/usuario",type:"get",data:{filter_nodo:e,filter_role:a,filter_state:t,filter_year:o}},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombrecompleto",name:"nombrecompleto"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"roles",name:"roles"},{data:"login",name:"login"},{data:"state",name:"state"},{data:"detail",name:"detail",orderable:!1}]})},fillDatatatablesTalentos(e,a,t,o){$("#mytalento_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[[1,"desc"]],ajax:{url:"/usuario/mistalentos",type:"get",data:{filter_nodo:e,filter_role:a,filter_state:t,filter_year:o}},columns:[{data:"tipodocumento",name:"tipodocumento"},{data:"documento",name:"documento"},{data:"nombrecompleto",name:"nombrecompleto"},{data:"email",name:"email"},{data:"celular",name:"celular"},{data:"roles",name:"roles"},{data:"login",name:"login"},{data:"state",name:"state"},{data:"detail",name:"detail",orderable:!1}]})}};$("#filter_user").click(function(){let e=$("#filter_rol").val(),a=$("#filter_nodo").val(),t=$("#filter_state").val(),o=$("#filter_year").val();$("#users_data_table").dataTable().fnDestroy(),""==a&&null==a||""==e||""==t||""==o?""!=a&&null!=a&&null!=a||""==e||""==t||""==o?$("#users_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():UserIndex.fillDatatatablesUsers(a=null,e,t,o):UserIndex.fillDatatatablesUsers(a,e,t,o)}),$("#filter_talentos").click(function(){let e=$("#filter_rol").val(),a=$("#filter_nodo").val(),t=$("#filter_state").val(),o=$("#filter_year").val();$("#mytalento_data_table").dataTable().fnDestroy(),""==a&&null==a||""==e||""==t||""==o?""!=a&&null!=a&&null!=a||""==e||""==t||""==o?$("#mytalento_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():UserIndex.fillDatatatablesTalentos(a=null,e,t,o):UserIndex.fillDatatatablesTalentos(a,e,t,o)}),$("#download_users").click(function(){let e=$("#filter_rol").val();var a={filter_nodo:$("#filter_nodo").val(),filter_role:e,filter_state:$("#filter_state").val(),filter_year:$("#filter_year").val()},t="/usuario/export?"+$.param(a);window.location=t}),$(document).on("submit","form#formEditProfile",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");$.ajax({type:a.attr("method"),url:o,data:t,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){if($('button[type="submit"]').removeAttr("disabled"),$('button[type="submit"]').prop("disabled",!1),$(".error").hide(),e.fail){for(control in e.errors)$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();EditProfileUser.printErroresFormulario(e)}"error"==e.state&&(Swal.fire({title:"Tu perfil no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3)),"success"==e.state&&(Swal.fire({title:"Modifciación Exitosa",text:"Tu perfil ha sido actualizado exitosamente.",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.href=e.url},1e3))}})});var EditProfileUser={printErroresFormulario:function(e){if("error_form"==e.state){let a="";for(control in e.errors)a+=" </br><b> - "+e.errors[control]+" </b> ",$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+a,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}},roleUserSession={setRoleSession:function(e){$(e).val();let a=$("#change-role option:selected").val();$.ajax({dataType:"json",type:"POST",data:{role:a,_token:$('meta[name="csrf-token"]').attr("content")},url:"/cambiar-role"}).done(function(e){null!=e.role&&(location.href=e.url)})}};function consultarArticulacionesDelGestor(e){$("#articulacionesGestor_table").dataTable().fnDestroy(),$("#articulacionesGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/articulacion/datatableArticulacionesDelGestor/0/"+e,data:function(e){e.codigo_articulacion=$("#codigo_articulacion_GestorTable").val(),e.gestor=$("#nombre_GestorAdministradorTable").val(),e.nombre=$("#nombre_GestorTable").val(),e.fase=$("#fase_GestorTable").val(),e.search=$('input[type="search"]').val()}},columns:[{data:"codigo_articulacion",name:"codigo_articulacion"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{data:"proceso",name:"proceso",orderable:!1}]})}function consultarGruposInvestigacion_FaseInicio_Articulaciones(){$("#gruposInvestigacion_articulacion_table").dataTable().fnDestroy(),$("#gruposInvestigacion_articulacion_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},select:!0,columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{width:"20%",data:"add_articulacion",name:"add_articulacion",orderable:!1}]}),$("#gruposDeInvestigacion_ArticulacionInicio_modal").openModal()}function addGrupoArticulacion(e){$.ajax({dataType:"json",type:"get",url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+e}).done(function(e){$("#txtgrupoInvestigacion").val(e.detalles.codigo_grupo+" - "+e.detalles.entidad.nombre),$("label[for='txtgrupoInvestigacion']").addClass("active"),$("#txtgrupo_id").val(e.detalles.id),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,type:"success",title:"El código del grupo de investigación con el que se realizará la articulación es: "+e.detalles.codigo_grupo}),$("#gruposDeInvestigacion_ArticulacionInicio_modal").closeModal()})}function consultarTalentosDeTecnoparque_Articulacion_FaseInicio_table(e,a){$(e).dataTable().fnDestroy(),$(e).DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/usuario/talento/getTalentosDeTecnoparque/",type:"get"},columns:[{data:"documento",name:"documento"},{data:"talento",name:"talento"},{data:a,name:a,orderable:!1}]})}function ajaxSendFormArticulacion(e,a,t,o){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),"create"==o?mensajesArticulacionCreate(e):mensajesArticulacionUpdate(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesArticulacionCreate(e){"registro"==e.state&&(Swal.fire({title:"Registro Exitoso",text:"La articulación ha sido registrada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulacion")},1e3)),"no_registro"==e.state&&Swal.fire({title:"La articulación no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesArticulacionUpdate(e){"update"==e.state&&(Swal.fire({title:"Modificación Exitosa",text:"La articulación ha sido modificada satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulacion")},1e3)),"no_update"==e.state&&Swal.fire({title:"La articulación no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function talentoYaSeEncuentraAsociado_Articulacion(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El talento ya se encuentra asociado a la articulación!"})}function talentoSeAsocioALaArticulacion(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"El talento se ha asociado a la articulación!"})}function prepararFilaEnLaTablaDeTalentos_Articulacion(e){let a=e.talento.id;return'<tr class="selected" id=talentoAsociadoALaArticulacion'+a+'><td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+a+'" value="'+a+'" /><label for ="radioButton'+a+'"></label></td><td><input type="hidden" name="talentos[]" value="'+a+'">'+e.talento.documento+" - "+e.talento.talento+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeArticulacion_FaseInicio('+a+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function pintarTalentoEnTabla_Fase_Inicio_Articulacion(e){$.ajax({dataType:"json",type:"get",url:"/usuario/talento/consultarTalentoPorId/"+e}).done(function(e){let a=prepararFilaEnLaTablaDeTalentos_Articulacion(e);$("#detalleTalentosDeUnaArticulacion_Create").append(a),talentoSeAsocioALaArticulacion()})}function noRepeat_Articulacion(e){let a=e,t=!0,o=document.getElementsByName("talentos[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function eliminarTalentoDeArticulacion_FaseInicio(e){$("#talentoAsociadoALaArticulacion"+e).remove()}function addTalentoArticulacion(e){0==noRepeat_Articulacion(e)?talentoYaSeEncuentraAsociado_Articulacion():pintarTalentoEnTabla_Fase_Inicio_Articulacion(e)}function ajaxSendFormArticulacion_FaseCierre(e,a,t){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),mensajesArticulacionCierre(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesArticulacionCierre(e){"update"==e.state&&(Swal.fire({title:"Modificación Exitosa!",text:"La articulación ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulacion")},1e3)),"no_update"==e.state&&Swal.fire({title:"La articulación no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function preguntaReversarArticulacion(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar esta articulación a la fase de inicio?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmReversarFaseArticulacion.submit()})}function verDetalleDeLaEntidadAsocidadALaArticulacion(e){$.ajax({dataType:"json",type:"get",url:"/articulacion/consultarEntidadDeLaArticulacion/"+e}).done(function(e){$("#detalleDeUnaArticulacion_titulo").empty(),$("#detalleArticulacion_body").empty(),null==e.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):"Empresa"==e.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nit de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nit+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre_empresa+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Dirección de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.direccion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Email de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.email_entidad+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):"Grupo de Investigación"==e.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.codigo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.correo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.tipogrupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.institucion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre_clasificacion+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):($("#talentosDeUnaArticulacion_titulo").empty(),$("#talentosDeUnaArticulacion_table").empty(),$("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>"),$.each(e.detalles,function(e,a){let t="Autor";1==a.talento_lider&&(t="Talento Líder"),$("#talentosDeUnaArticulacion_table").append("<tr><td>"+t+"</td><td>"+a.talento+"</td></tr>")}),$("#talentosDeUnaArticulacion_modal").openModal())})}function eliminarArticulacionPorId_event(e,a){Swal.fire({title:"¿Desea eliminar la articulación?",text:"Al hacer esto, todo lo relacionado con esta articulación será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(a=>{a.value&&eliminarArticulacionPorId_moment(e)})}function eliminarArticulacionPorId_moment(e){$.ajax({dataType:"json",type:"get",url:"/articulacion/eliminarArticulacion/"+e,success:function(e){e.retorno?(Swal.fire("Eliminación Exitosa!","La articulación se ha eliminado completamente!","success"),location.href="/articulacion"):Swal.fire("Eliminación Errónea!","La articulación no se ha eliminado!","error")},error:function(e,a,t){alert("Error: "+t)}})}function consultarIntervencionesEmpresaDelGestor(e){$("#IntervencionGestor_table").dataTable().fnDestroy(),$("#IntervencionGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/intervencion/datatableIntervencionEmpresaDelGestor/0/"+e,data:function(e){e.codigo_articulacion=$("#codigo_articulacion_GestorTable").val(),e.nombre=$("#nombre_GestorTable").val(),e.estado=$("#estado_GestorTable").val(),e.search=$('input[type="search"]').val()}},columns:[{data:"codigo_articulacion",name:"codigo_articulacion"},{data:"nombre",name:"nombre"},{data:"estado",name:"estado"},{data:"details",name:"details",orderable:!1},{data:"entregables",name:"entregables",orderable:!1},{data:"edit",name:"edit",orderable:!1}]})}function detallesDeUnaIntervencion(e){$.ajax({dataType:"json",type:"get",url:"/intervencion/ajaxDetallesDeUnaArticulacion/"+e}).done(function(a){$("#articulacionDetalle_titulo").empty(),$("#detalleArticulacion").empty(),null==a.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):($("#articulacionDetalle_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaArticulacion/"+e+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='teal-text text-darken-3'>Código de la Intervención: </span><b>"+a.detalles.codigo_articulacion+"</b>"),$("#detalleArticulacion").append('<div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Nombre de la Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Experto a cargo: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.gestor+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Fecha de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.fecha_inicio+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Estado de la Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.estado+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Tipo de Articulación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.detalles.tipoArticulacion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="teal-text text-darken-3">Entregables: </span></div><div class="col s12 m6 l6"><span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaIntervencionEmpresa('+a.detalles.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span></div></div><div class="divider"></div>'),$("#articulacionDetalle").openModal())})}function verDetalleDeLaEntidadAsocidadALaArticulacion(e){$.ajax({dataType:"json",type:"get",url:"/articulacion/consultarEntidadDeLaArticulacion/"+e}).done(function(e){$("#detalleDeUnaArticulacion_titulo").empty(),$("#detalleArticulacion_body").empty(),null==e.detalles?Swal.fire("Ups!!","Ha ocurrido un error","error"):"Empresa"==e.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nit de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nit+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre_empresa+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Dirección de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.direccion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Email de la Empresa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.email_entidad+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):"Grupo de Investigación"==e.articulacion.tipo_articulacion?($("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>"),$("#detalleArticulacion_body").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.codigo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.correo_grupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.ciudad+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.tipogrupo+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.institucion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.detalles.nombre_clasificacion+"</span></div></div>"),$("#detalleArticulacion_modal").openModal()):($("#talentosDeUnaArticulacion_titulo").empty(),$("#talentosDeUnaArticulacion_table").empty(),$("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>"),$.each(e.detalles,function(e,a){let t="Autor";1==a.talento_lider&&(t="Talento Líder"),$("#talentosDeUnaArticulacion_table").append("<tr><td>"+t+"</td><td>"+a.talento+"</td></tr>")}),$("#talentosDeUnaArticulacion_modal").openModal())})}function eliminarIntervencionEmpresaPorId_event(e,a){Swal.fire({title:"¿Desea eliminar la Intervención a Empresa?",text:"Al hacer esto, todo lo relacionado con esta Intervención a Empresa será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(a=>{a.value&&eliminarIntervencionEmpresaPorId_moment(e)})}function eliminarIntervencionEmpresaPorId_moment(e){$.ajax({dataType:"json",type:"get",url:"/intervencion/eliminarArticulacion/"+e,success:function(e){e.retorno?(Swal.fire("Eliminación Exitosa!","La Intervención a Empresa se ha eliminado completamente!","success"),location.href="/intervencion"):Swal.fire("Eliminación Errónea!","La Intervención a Empresa no se ha eliminado!","error")},error:function(e,a,t){alert("Error: "+t)}})}function verHorasDeExpertosEnProyecto(e){$.ajax({dataType:"json",type:"get",url:"/proyecto/consultarHorasExpertos/"+e}).done(function(e){$("#horasAsesoriasExpertosPorProyeto_table").empty(),0==e.horas.length?Swal.fire({title:"Ups!!",text:"No se encontraron horas de asesorías de los expertos en este proyecto!",type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}):($("#horasAsesoriasExpertosPorProyeto_titulo").empty(),$("#horasAsesoriasExpertosPorProyeto_titulo").append("<span class='cyan-text text-darken-3'>Horas de los experto en el proyecto</span>"),$.each(e.horas,function(e,a){$("#horasAsesoriasExpertosPorProyeto_table").append("<tr><td>"+a.experto+"</td><td>"+a.horas_directas+"</td><td>"+a.horas_indirectas+"</td></tr>")}),$("#horasAsesoriasExpertosPorProyeto_modal").openModal())})}function consultarProyectosDeTalentos(){$("#tblProyectoDelTalento").dataTable().fnDestroy(),$("#tblProyectoDelTalento").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelTalento/",data:function(e){e.codigo_proyecto=$(".codigo_proyecto").val(),e.nombre=$(".nombre").val(),e.nombre_fase=$(".nombre_fase").val(),e.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"nombre_gestor",name:"nombre_gestor"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"8%",data:"proceso",name:"proceso",orderable:!1}]})}function verTalentosDeUnProyecto(e){$.ajax({dataType:"json",type:"get",url:"/proyecto/ajaxConsultarTalentosDeUnProyecto/"+e}).done(function(e){$("#talentosAsociadosAUnProyecto_table").empty(),0!=e.talentos.length?($("#talentosAsociadosAUnProyecto_titulo").empty(),$("#talentosAsociadosAUnProyecto_titulo").append("<span class='cyan-text text-darken-3'>Código de Proyecto: </span>"+e.proyecto),$.each(e.talentos,function(e,a){let t="",o=a.celular;"Talento Líder"==a.rol&&(t='<i class="material-icons green-text left">face</i>'),null==a.celular&&(o=""),$("#talentosAsociadosAUnProyecto_table").append("<tr><td>"+t+" "+a.rol+"</td><td>"+a.talento+"</td><td>"+a.email+"</td><td>"+o+"</td></tr>")}),$("#talentosAsociadosAUnProyecto_modal").openModal()):Swal.fire({title:"Ups!!",text:"No se encontraron talentos asociados a este proyecto!",type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})})}function consultarProyectosDelGestorPorAnho(){let e=$("#anho_proyectoPorAnhoGestorNodo").val();$("#tblproyectosGestorPorAnho").dataTable().fnDestroy(),$("#tblproyectosGestorPorAnho").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pageLength:20,processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelGestorPorAnho/0/"+e,data:function(e){e.codigo_proyecto=$(".codigo_proyecto").val(),e.nombre=$(".nombre").val(),e.nombre_fase=$(".nombre_fase").val(),e.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"nombre",name:"nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"8%",data:"info",name:"info",orderable:!1},{width:"8%",data:"proceso",name:"proceso",orderable:!1}]})}function preguntaReversar(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar este proyecto a la fase de Inicio?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmReversarFase.submit()})}function preguntaReversarPlaneacion(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar este proyecto a la fase de Planeación?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmReversarFasePlaneacion.submit()})}function preguntaReversarEjecucion(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar este proyecto a la fase de Ejecución?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmReversarFaseEjecucion.submit()})}function consultarProyectosDelNodoPorAnho(){let e=$("#anho_proyectoPorNodoYAnho").val();$("#tblproyectosDelNodoPorAnho").dataTable().fnDestroy(),$("#tblproyectosDelNodoPorAnho").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],lengthChange:!1,ajax:{url:"/proyecto/datatableProyectosDelNodoPorAnho/0/"+e,data:function(e){e.codigo_proyecto=$("#codigo_proyecto_tblProyectosDelNodoPorAnho").val(),e.gestor=$("#gestor_tblProyectosDelNodoPorAnho").val(),e.nombre=$("#nombre_tblProyectosDelNodoPorAnho").val(),e.sublinea_nombre=$("#sublinea_nombre_tblProyectosDelNodoPorAnho").val(),e.nombre_fase=$("#fase_nombre_tblProyectosDelNodoPorAnho").val(),e.search=$('input[type="search"]').val()}},columns:[{width:"15%",data:"codigo_proyecto",name:"codigo_proyecto"},{data:"gestor",name:"gestor"},{data:"nombre",name:"nombre"},{data:"sublinea_nombre",name:"sublinea_nombre"},{data:"nombre_fase",name:"nombre_fase"},{width:"6%",data:"info",name:"info",orderable:!1},{width:"6%",data:"proceso",name:"proceso",orderable:!1},{width:"6%",data:"download_trazabilidad",name:"download_trazabilidad",orderable:!1},{width:"6%",data:"ver_horas",name:"ver_horas",orderable:!1}]})}function eliminarProyectoPorId_event(e,a){Swal.fire({title:"¿Desea eliminar el Proyecto?",text:"Al hacer esto, todo lo relacionado con este proyecto será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(a=>{a.value&&eliminarProyectoPorId_moment(e)})}function eliminarProyectoPorId_moment(e){$.ajax({dataType:"json",type:"get",url:"/proyecto/eliminarProyecto/"+e,success:function(e){e.retorno?(Swal.fire("Eliminación Exitosa!","El proyecto se ha eliminado completamente!","success"),location.href="/proyecto"):Swal.fire("Eliminación Errónea!","El proyecto no se ha eliminado!","error")},error:function(e,a,t){alert("Error: "+t)}})}$(document).ready(function(){$("#sublineas_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/sublineas",type:"get"},columns:[{data:"nombre",name:"nombre"},{data:"linea",name:"linea"},{data:"edit",name:"edit",orderable:!1}]})}),$("#codigo_articulacion_GestorTable").keyup(function(){$("#articulacionesGestor_table").DataTable().draw()}),$("#nombre_GestorTable").keyup(function(){$("#articulacionesGestor_table").DataTable().draw()}),$("#fase_GestorTable").keyup(function(){$("#articulacionesGestor_table").DataTable().draw()}),$(document).on("submit","form#frmArticulaciones_FaseInicio_Update",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacion(a,t,o,"update")}),$(document).on("submit","form#frmArticulacion_FaseInicio",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacion(a,t,o,"create")}),$(document).on("submit","form#frmArticulaciones_FaseCierre_Update",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacion_FaseCierre(a,t,o)}),$("#codigo_articulacion_GestorTable").keyup(function(){$("#IntervencionGestor_table").DataTable().draw()}),$("#nombre_GestorTable").keyup(function(){$("#IntervencionGestor_table").DataTable().draw()}),$("#estado_GestorTable").keyup(function(){$("#IntervencionGestor_table").DataTable().draw()}),$(document).ready(function(){consultarProyectosDelGestorPorAnho(),consultarProyectosDelNodoPorAnho()}),$(".codigo_proyecto").keyup(function(){$("#tblproyectosGestorPorAnho").DataTable().draw()}),$(".nombre").keyup(function(){$("#tblproyectosGestorPorAnho").DataTable().draw()}),$(".nombre_fase").keyup(function(){$("#tblproyectosGestorPorAnho").DataTable().draw()}),$("#codigo_proyecto_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#gestor_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#nombre_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#sublinea_nombre_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()}),$("#fase_nombre_tblProyectosDelNodoPorAnho").keyup(function(){$("#tblproyectosDelNodoPorAnho").DataTable().draw()});var infoActividad={infoDetailActivityModal:function(e){"string"==typeof e&&$.ajax({dataType:"json",type:"get",url:"/actividad/detalle/"+e}).done(function(e){$("#actividad_titulo").empty(),$("#detalleActividad").empty(),$("#actividad_titulo").append("<span class='cyan-text text-darken-3'>"+e.data.actividad.codigo_actividad+" - "+e.data.actividad.nombre+" </span><br>"),null!==e.data.actividad.articulacion_proyecto.proyecto?infoActividad.openIsProyect(e):null!==e.data.actividad.articulacion_proyecto.articulacion&&infoActividad.openIsArticulacion(e),$("#info_actividad_modal").openModal()})},openIsProyect:function(e){$("#detalleActividad").append(`\n            <table class="striped centered">\n                <TR>\n                    <TH width="25%">Código Proyecto</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(e.data.actividad.codigo_actividad)}</TD>\n                    <TH width="25%" >Nombre Proyecto</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(e.data.actividad.nombre)}</TD>\n                </TR>\n                <TR>\n                    <TH width="25%">Experto</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(e.data.actividad.articulacion_proyecto.proyecto.asesor.user.documento)} - ${e.data.actividad.articulacion_proyecto.proyecto.asesor.user.nombres} ${e.data.actividad.articulacion_proyecto.proyecto.asesor.user.apellidos}</TD>\n                    <TH width="25%">Correo Electrónico</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(e.data.actividad.articulacion_proyecto.proyecto.asesor.user.email)}</TD>\n                </TR>\n            </table>\n            <div class="right">\n                <small>\n                    <b>Cantidad de usos de infraestructura:  </b>\n                    ${infoActividad.showInfoNull(e.data.total_usos)}\n                </small>\n            </div>\n            <div class="divider mailbox-divider"></div>\n            <div class="center">\n                <span class="mailbox-title">\n                    <i class="material-icons">group</i>\n                    Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.\n                </span>\n            </div>\n            <div class="divider mailbox-divider"></div>\n                <div class="row">\n                <div class="col s12 m12 l12">\n                        <div class="card-panel blue lighten-5">\n                            <h5 class="center">Talentos que participan en el proyecto</h5>\n                            <table>\n                                <thead>\n                                    <tr>\n                                        <th style="width: 10%">Talento Interlocutor</th>\n                                        <th style="width: 40%">Talento</th>\n                                        <th style="width: 20%">Correo</th>\n                                        <th style="width: 15%">Telefono</th>\n                                        <th style="width: 15%">Celular</th>\n                                    </tr>\n                                </thead>\n                                <tbody id="detalleTalentos">\n                                </tbody>\n                            </table>\n                        </div>\n                    </div>\n                </div>\n                <div class="row">\n                    <div class="card-panel green lighten-5 col s12 m12 l12">\n                        <h5 class="center">Dueño(s) de la propiedad intelectual</h5>\n                        <div class="row">\n                            <div class="col s12 m4 l4">\n                                <div class="card-panel">\n                                    <ul class="collection with-header">\n                                        <li class="collection-header"><h5>Empresas</h5></li>\n                                        <div id="detalleEmpresas"></div>\n                                    </ul>\n                                </div>\n                            </div>\n                            <div class="col s12 m4 l4">\n                                <div class="card-panel">\n                                    <ul class="collection with-header">\n                                        <li class="collection-header"><h5>Personas (Talentos)</h5></li>\n                                        <div id="detallePropiedadTalentos"></div>\n                                    </ul>\n                                </div>\n                            </div>\n                            <div class="col s12 m4 l4">\n                                <div class="card-panel">\n                                    <ul class="collection with-header">\n                                        <li class="collection-header"><h5>Grupos de Investigación</h5></li>\n                                        <div id="detallePropiedadGrupo"></div>\n\n                                    </ul>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>`),infoActividad.showTalentos(e.data.actividad.articulacion_proyecto.talentos),infoActividad.showPropiedadIntelectualEmpresas(e.data.actividad.articulacion_proyecto.proyecto.sedes),infoActividad.showPropiedadIntelectualTalentos(e.data.actividad.articulacion_proyecto.proyecto.users_propietarios),infoActividad.showPropiedadIntelectualGrupo(e.data.actividad.articulacion_proyecto.proyecto.gruposinvestigacion)},openIsArticulacion:function(e){$("#detalleActividad").append(`\n            <table class="striped centered">\n                <TR>\n                    <TH width="25%">Código Articulación</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(e.data.actividad.codigo_actividad)}</TD>\n                    <TH width="25%" >Nombre de Articulación</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(e.data.actividad.nombre)}</TD>\n                </TR>\n                <TR>\n                    <TH width="25%">Experto</TH>\n                    <TD width="25%">${infoActividad.showInfoNull(e.data.actividad.articulacion_proyecto.articulacion.asesor.documento)} - ${e.data.actividad.articulacion_proyecto.articulacion.asesor.nombres} ${e.data.actividad.articulacion_proyecto.articulacion.asesor.apellidos}</TD>\n                    <TH width="25%">Correo Electrónico</TH>\n                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(e.data.actividad.articulacion_proyecto.articulacion.asesor.email)}</TD>\n                </TR>\n            </table>\n            <div class="right">\n                <small>\n                    <b>Cantidad de usos de infraestructura:  </b>\n                    ${infoActividad.showInfoNull(e.data.total_usos)}\n                </small>\n            </div>\n            <div class="divider mailbox-divider"></div>\n            <div class="center">\n                <span class="mailbox-title">\n                    <i class="material-icons">group</i>\n                    Talentos que participan en la articulación.\n                </span>\n            </div>\n            <div class="divider mailbox-divider"></div>\n                <div class="row">\n                <div class="col s12 m12 l12">\n                        <div class="card-panel blue lighten-5">\n                            <h5 class="center">Talentos que participan en la Articulación</h5>\n                            <table>\n                                <thead>\n                                    <tr>\n                                        <th style="width: 10%">Talento Interlocutor</th>\n                                        <th style="width: 40%">Talento</th>\n                                        <th style="width: 20%">Correo</th>\n                                        <th style="width: 15%">Telefono</th>\n                                        <th style="width: 15%">Celular</th>\n                                    </tr>\n                                </thead>\n                                <tbody id="detalleTalentos">\n                                </tbody>\n                            </table>\n                        </div>\n                    </div>\n                </div>`),infoActividad.showTalentos(e.data.actividad.articulacion_proyecto.talentos)},showDateActivity:function(e){return null===e||""===e?"El proceso no se ha cerrado":e},showInfoNull:function(e){return null===e||""===e?"No se encontraron resultados":e},validateDataIsTRL:function(e){return 0==e?"TRL 6":"TRL 7 - TRL 8"},validateDataIsBoolean:function(e){return 0==e?"NO":"SI"},dataPerteneceEconomiaNaranja:function(e){return 0==e.economia_naranja?"NO":1==e.economia_naranja?" SI ("+e.tipo_economianaranja+")":""},dataDirigidoDiscapacitados:function(e){return 0==e.dirigido_discapacitados?"NO":1==e.dirigido_discapacitados?"SI ("+e.tipo_discapacitados+")":""},dataArticuladaCTI:function(e){return 0==e.art_cti?"NO":1==e.art_cti?" SI ("+e.nom_act_cti+")":""},showTalentos:function(e){let a="";a=e.length>0?e.map(function(e){return`<tr class="selected">\n                            <td> ${infoActividad.validateDataIsBoolean(e.pivot.talento_lider)}</td>\n                            <td>${infoActividad.showInfoNull(e.user.documento)} - ${infoActividad.showInfoNull(e.user.nombres)} ${infoActividad.showInfoNull(e.user.apellidos)}</td>\n                            <td>${infoActividad.showInfoNull(e.user.email)}</td>\n                            <td>${infoActividad.showInfoNull(e.user.telefono)}</td>\n                            <td>${infoActividad.showInfoNull(e.user.celular)}</td>\n                        </tr>`}):'<tr class="selected">\n                        <td COLSPAN=4>No se encontraron resultados</td>\n                        <td></td>\n                        <td></td>\n                        <td></td>\n                        <td></td>\n                    </tr>',document.getElementById("detalleTalentos").innerHTML=a},showPropiedadIntelectualEmpresas:function(e){let a="";a=e.length>0?e.map(function(e){return`\n                        <li class="collection-item">\n                        ${infoActividad.showInfoNull(e.empresa.nit)} - ${infoActividad.showInfoNull(e.empresa.nombre)} (${infoActividad.showInfoNull(e.nombre_sede)})\n                        </li>`}):'<li class="collection-item">\n                    No se han encontrado empresas dueña(s) de la propiedad intelectual.\n                </li>',document.getElementById("detalleEmpresas").innerHTML=a},showPropiedadIntelectualTalentos:function(e){let a="";a=e.length>0?e.map(function(e){return`<li class="collection-item">\n                        ${infoActividad.showInfoNull(e.documento)} - ${infoActividad.showInfoNull(e.nombres)} ${infoActividad.showInfoNull(e.apellidos)}\n                        </li>`}):'<li class="collection-item">\n                    No se han encontrado talento(s) dueño(s) de la propiedad intelectual.\n                </li>',document.getElementById("detallePropiedadTalentos").innerHTML=a},showPropiedadIntelectualGrupo:function(e){let a="";a=e.length>0?e.map(function(e){return`<li class="collection-item">\n                        ${infoActividad.showInfoNull(e.codigo_grupo)} - ${infoActividad.showInfoNull(e.entidad.nombre)}\n                        </li>`}):'<li class="collection-item">\n            No se han encontrado grupo(s) de investigación dueño(s) de la propiedad intelectual.\n                </li>',document.getElementById("detallePropiedadGrupo").innerHTML=a}};function ajaxSendFormProyecto(e,a,t,o){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),"create"==o?mensajesProyectoCreate(e):mensajesProyectoUpdate(e)},error:function(e,a,t){alert("Error: "+t)}})}function mensajesProyectoCreate(e){"registro"==e.state&&(Swal.fire({title:"Registro Exitoso",text:"El proyecto ha sido registrado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/proyecto")},1e3)),"no_registro"==e.state&&Swal.fire({title:"El proyecto no se ha registrado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function mensajesProyectoUpdate(e){"update"==e.state&&(Swal.fire({title:"Modificación Exitosa",text:"El proyecto ha sido registrado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/proyecto")},1e3)),"no_update"==e.state&&Swal.fire({title:"El proyecto no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function talentoYaSeEncuentraAsociado(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El talento ya se encuentra asociado al proyecto!"})}function usuarioYaSeEncuentraAsociado_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El usuario ya se encuentra asociado como dueño de la propiedad intelectual!"})}function empresaYaSeEncuentraAsociado_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"Esta empresa/sede ya se encuentra asociada como dueño de la propiedad intelectual!"})}function talentoSeAsocioAlProyecto(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"El talento se ha asociado al proyecto!"})}function empresaSeAsocioAlProyecto_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La sede se ha asociado como dueño de la propiedad intelectual!"})}function grupoSeAsocioAlProyecto_Propietario(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"El grupo de investigación se ha asociado como dueño de la propiedad intelectual!"})}function ideaProyectoAsociadaConExito(e,a){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La siguiente idea se ha asociado al proyecto: "+e+" - "+a})}function prepararFilaEnLaTablaDeTalentos(e,a){let t=null;a&&(t="checked");let o=e.talento.id;return'<tr class="selected" id=talentoAsociadoAProyecto'+o+'><td><input type="radio" '+t+' class="with-gap" name="radioTalentoLider" id="radioButton'+o+'" value="'+o+'" /><label for ="radioButton'+o+'"></label></td><td><input type="hidden" name="talentos[]" value="'+o+'">'+e.talento.documento+" - "+e.talento.talento+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio('+o+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDePropietarios_Users(e){let a=e.user.id;return'<tr class="selected" id=propietarioAsociadoAlProyecto_Persona'+a+'><td><input type="hidden" name="propietarios_user[]" value="'+a+'">'+e.user.documento+" - "+e.user.nombres+" "+e.user.apellidos+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona('+a+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDePropietarios_Empresa(e){let a=e.sede.id;return'<tr class="selected" id=propietarioAsociadoAlProyecto_Empresa'+a+'><td><input type="hidden" name="propietarios_sedes[]" value="'+a+'">'+e.sede.empresa.nit+" - "+e.sede.empresa.nombre+" ("+e.sede.nombre_sede+')</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa('+a+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function prepararFilaEnLaTablaDePropietarios_Grupos(e){let a=e.detalles.id;return'<tr class="selected" id=propietarioAsociadoAlProyecto_Grupo'+a+'><td><input type="hidden" name="propietarios_grupos[]" value="'+a+'">'+e.detalles.codigo_grupo+" - "+e.detalles.entidad.nombre+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo('+a+');"><i class="material-icons">delete_sweep</i></a></td></tr>'}function pintarTalentoEnTabla_Fase_Inicio(e,a){$.ajax({dataType:"json",type:"get",url:"/usuario/talento/consultarTalentoPorId/"+e}).done(function(e){let t=prepararFilaEnLaTablaDeTalentos(e,a);$("#detalleTalentosDeUnProyecto_Create").append(t),talentoSeAsocioAlProyecto()})}function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(e){$.ajax({dataType:"json",type:"get",url:"/usuario/consultarUserPorId/"+e}).done(function(e){let a=prepararFilaEnLaTablaDePropietarios_Users(e);$("#propiedadIntelectual_Personas").append(a),talentoSeAsocioAlProyecto()})}function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(e){$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetalleDeUnaSede/"+e,success:function(e){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La sede "+e.sede.nombre_sede+" se asoció a la idea de proyecto!"});let a=prepararFilaEnLaTablaDePropietarios_Empresa(e);$("#propiedadIntelectual_Empresas").append(a),empresaSeAsocioAlProyecto_Propietario()},error:function(e,a,t){alert("Error: "+t)}})}function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(e){$.ajax({dataType:"json",type:"get",url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+e}).done(function(e){let a=prepararFilaEnLaTablaDePropietarios_Grupos(e);$("#propiedadIntelectual_Grupos").append(a),grupoSeAsocioAlProyecto_Propietario()})}function noRepeat(e){let a=e,t=!0,o=document.getElementsByName("talentos[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function noRepeat_Propiedad(e){let a=e,t=!0,o=document.getElementsByName("propietarios_user[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function noRepeat_Sede(e){let a=e,t=!0,o=document.getElementsByName("propietarios_sedes[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function noRepeat_Grupo(e){let a=e,t=!0,o=document.getElementsByName("propietarios_grupos[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function eliminarTalentoDeProyecto_FaseInicio(e){$("#talentoAsociadoAProyecto"+e).remove()}function eliminarPropietarioDeUnProyecto_FaseInicio_Persona(e){$("#propietarioAsociadoAlProyecto_Persona"+e).remove()}function eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(e){$("#propietarioAsociadoAlProyecto_Empresa"+e).remove()}function eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(e){$("#propietarioAsociadoAlProyecto_Grupo"+e).remove()}function addTalentoProyecto(e,a){0==noRepeat(e)?talentoYaSeEncuentraAsociado():pintarTalentoEnTabla_Fase_Inicio(e,a)}function addPersonaPropiedad(e){0==noRepeat_Propiedad(e)?usuarioYaSeEncuentraAsociado_Propietario():pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(e)}function prepararSedesEmpresa(e){let a="";return e.forEach(e=>{a+='<li class="collection-item">\n        '+e.nombre_sede+" - "+e.direccion+" "+e.ciudad.nombre+" ("+e.ciudad.departamento.nombre+')\n        <a href="#!" class="secondary-content" onclick="addSedePropietaria('+e.id+')">Asociar esta sede de la empresa al proyecto</a></div>\n      </li>'}),a}function addEntidadEmpresa(e){$("#sedesPropietarias_Empresas_detalles").empty(),$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetallesDeUnaEmpresa/"+e+"/id",success:function(e){let a=prepararSedesEmpresa(e.empresa.sedes);$("#sedesPropietarias_Empresas_detalles").append(a),$("#sedesPropietarias_Empresas_modal").openModal()},error:function(e,a,t){alert("Error: "+t)}})}function addSedePropietaria(e){0==noRepeat_Sede(e)?empresaYaSeEncuentraAsociado_Propietario():pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(e)}function addGrupoPropietario(e){0==noRepeat_Grupo(e)?empresaYaSeEncuentraAsociado_Propietario():pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(e)}function dumpAggregateValuesIntoTables(){$("#detalleTalentosDeUnProyecto_Create").empty(),$("#propiedadIntelectual_Personas").empty(),$("#propiedadIntelectual_Empresas").empty(),$("#propiedadIntelectual_Grupos").empty()}function addValueToFields(e,a,t){$("#txtnombreIdeaProyecto_Proyecto").val(a+" - "+e),$("#txtnombre").val(e),$("label[for='txtnombreIdeaProyecto_Proyecto']").addClass("active"),$("label[for='txtnombre']").addClass("active"),$("#txtobjetivo").val(t.objetivo),$("#txtobjetivo").trigger("autoresize"),$("label[for='txtobjetivo']").addClass("active"),$("#txtalcance_proyecto").val(t.alcance),$("#txtalcance_proyecto").trigger("autoresize"),$("label[for='txtalcance_proyecto']").addClass("active")}function asociarIdeaDeProyectoAProyecto(e,a,t){$("#txtidea_id").val(e),$.ajax({dataType:"json",type:"get",url:"/idea/show/"+e}).done(function(e){let o=e.data.idea;(idea=!0)&&(console.log(e),dumpAggregateValuesIntoTables(),addValueToFields(a,t,o),ideaProyectoAsociadaConExito(t,a),null!=e.data.talento&&(addTalentoProyecto(e.data.talento.id,!0),addPersonaPropiedad(e.data.talento.user.id)),null!=e.data.sede&&addSedePropietaria(e.data.sede.id),$("#ideasDeProyectoConEmprendedores_modal").closeModal())}).fail(function(e,a,t){errorAjax(e,a,t)})}function consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio(){$("#ideasDeProyectoConEmprendedores_proyecto_table").dataTable().fnDestroy(),$("#ideasDeProyectoConEmprendedores_proyecto_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/proyecto/datatableIdeasConEmprendedores",type:"get"},select:!0,columns:[{data:"codigo_idea",name:"codigo_idea"},{data:"nombre_proyecto",name:"nombre_proyecto"},{data:"nombres_contacto",name:"nombres_contacto"},{width:"20%",data:"checkbox",name:"checkbox",orderable:!1}]}),$("#ideasDeProyectoConEmprendedores_modal").openModal({dismissible:!1})}function consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table(){$("#posiblesPropietarios_Empresas_table").dataTable().fnDestroy(),$("#posiblesPropietarios_Empresas_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"add_propietario",name:"add_propietario",orderable:!1}]}),$("#posiblesPropietarios_Empresas_modal").openModal()}function consultarGruposDeTecnoparque_Proyecto_FaseInicio_table(){$("#posiblesPropietarios_Grupos_table").dataTable().fnDestroy(),$("#posiblesPropietarios_Grupos_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/grupo/datatableGruposInvestigacionDeTecnoparque",type:"get"},columns:[{data:"codigo_grupo",name:"codigo_grupo"},{data:"nombre",name:"nombre"},{data:"add_propietario",name:"add_propietario",orderable:!1}]}),$("#posiblesPropietarios_Grupos_modal").openModal()}function consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table(e,a){$(e).dataTable().fnDestroy(),$(e).DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/usuario/talento/getTalentosDeTecnoparque/",type:"get"},columns:[{data:"documento",name:"documento"},{data:"talento",name:"talento"},{data:a,name:a,orderable:!1}]}),"#posiblesPropietarios_Personas_table"==e&&$("#posiblesPropietarios_Personas_modal").openModal()}function selectAreaConocimiento_Proyecto_FaseInicio(){let e=$("#txtareaconocimiento_id").val();"Otro"==$("#txtareaconocimiento_id [value='"+e+"']").text()?divOtroAreaConocmiento.show():divOtroAreaConocmiento.hide()}function showInput_EconomiaNaranja(){$("#txteconomia_naranja").is(":checked")?divEconomiaNaranja.show():divEconomiaNaranja.hide()}function showInput_Discapacidad(){$("#txtdirigido_discapacitados").is(":checked")?divDiscapacidad.show():divDiscapacidad.hide()}function showInput_ActorCTi(){$("#txtarti_cti").is(":checked")?divNombreActorCTi.show():divNombreActorCTi.hide()}function errorAjax(e,a,t){0===e.status?alert("Not connect: Verify Network."):404==e.status?alert("Requested page not found [404]"):500==e.status?alert("Internal Server Error [500]."):"parsererror"===a?alert("Requested JSON parse failed."):"timeout"===a?alert("Time out error."):"abort"===a?alert("Ajax request aborted."):alert("Uncaught Error: "+e.responseText)}function ajaxSendFormProyecto_FaseCierre(e,a,t){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),mensajesProyectoCierre(e)},error:function(e,a,t){alert("Error: "+t)}})}function printErroresFormulario(e){if("error_form"==e.state){let a="";for(control in e.errors)a+=" </br><b> - "+e.errors[control]+" </b> ",$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+a,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}function mensajesProyectoCierre(e){"update"==e.state&&(Swal.fire({title:"Modificación Exitosa!",text:"El proyecto ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/proyecto")},1e3)),"no_update"==e.state&&Swal.fire({title:"El proyecto no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function actiarFechaFinDeLaEdt(){$("#txtestado").is(":checked")?divFechaCierreEdt.show():divFechaCierreEdt.hide()}function noRepeat(e){let a=e,t=!0,o=document.getElementsByName("entidades[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t}function addEmpresaAEdt(e){0==noRepeat(e)?Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"La empresa ya se encuentra asociada a la edt!"}):$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxConsultarEmpresaPorIdEntidad/"+e}).done(function(e){let a=e.detalles.entidad_id,t='<tr class="selected" id=entidadAsociadaAEdt'+a+'><td><input type="hidden" name="entidades[]" value="'+a+'">'+e.detalles.nit+"</td><td>"+e.detalles.nombre+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarEntidadAsociadaAEdt('+a+');"><i class="material-icons">delete_sweep</i></a></td></tr>';$("#detalleEntidadesAsociadasAEdt").append(t),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"La empresa se ha asociado a la edt!"})})}function eliminarEntidadAsociadaAEdt(e){$("#entidadAsociadaAEdt"+e).remove(),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"Se ha removido la empresa de la edt!"})}function consultarEdtsDeUnGestor(e){let a=$("#txtanho_edts_Gestor").val();$("#edtPorGestor_table").dataTable().fnDestroy(),$("#edtPorGestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/edt/consultarEdtsDeUnGestor/"+e+"/"+a,type:"get"},columns:[{width:"10%",data:"codigo_edt",name:"codigo_edt"},{width:"15%",data:"nombre",name:"nombre"},{width:"15%",data:"gestor",name:"gestor"},{width:"6%",data:"area_conocimiento",name:"area_conocimiento"},{width:"6%",data:"tipo_edt",name:"tipo_edt"},{data:"fecha_inicio",name:"fecha_inicio"},{data:"estado",name:"estado"},{width:"6%",data:"business",name:"business",orderable:!1},{width:"6%",data:"details",name:"details",orderable:!1},{width:"6%",data:"edit",name:"edit",orderable:!1},{width:"6%",data:"entregables",name:"entregables",orderable:!1}]})}function eliminarEdtPorId_event(e,a){Swal.fire({title:"¿Desea eliminar la edt?",text:"Al hacer esto, todo lo relacionado con esta edt será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#3085d6",cancelButtonText:"No",confirmButtonText:"Sí, eliminar!"}).then(a=>{a.value&&eliminarEdtPorId_moment(e)})}function eliminarEdtPorId_moment(e){$.ajax({dataType:"json",type:"get",url:"/edt/eliminarEdt/"+e,success:function(e){e.retorno?(Swal.fire("Eliminación Exitosa!","La edt se ha eliminado completamente!","success"),location.href="/edt"):Swal.fire("Eliminación Errónea!","La edt no se ha eliminado!","error")},error:function(e,a,t){alert("Error: "+t)}})}function datatableEdtsPorNodo(e){let a=$("#txtanho_edts_Nodo").val();$("#edtPorNodo_table").dataTable().fnDestroy(),$("#edtPorNodo_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/edt/consultarEdtsDeUnNodo/"+e+"/"+a,type:"get"},columns:[{width:"10%",data:"codigo_edt",name:"codigo_edt"},{width:"15%",data:"nombre",name:"nombre"},{width:"15%",data:"gestor",name:"gestor"},{width:"6%",data:"area_conocimiento",name:"area_conocimiento"},{width:"6%",data:"tipo_edt",name:"tipo_edt"},{width:"8%",data:"fecha_inicio",name:"fecha_inicio"},{width:"8%",data:"estado",name:"estado"},{width:"5%",data:"business",name:"business",orderable:!1},{width:"5%",data:"details",name:"details",orderable:!1},{width:"5%",data:"entregables",name:"entregables",orderable:!1},{width:"5%",data:"edit",name:"edit",orderable:!1},{width:"5%",data:"delete",name:"delete",orderable:!1}]})}function verEntidadesDeUnaEdt(e){$.ajax({dataType:"json",type:"get",url:"/edt/consultarDetallesDeUnaEdt/"+e+"/1",success:function(e){$("#entidadesEdt_table").empty(),0!=e.entidades.length?($("#entidadesEdt_titulo").empty(),$("#entidadesEdt_titulo").append("<span class='cyan-text text-darken-3'>Código de la Edt: </span>"+e.edt.codigo_edt),$.each(e.entidades,function(e,a){$("#entidadesEdt_table").append("<tr><td>"+a.nit+"</td><td>"+a.nombre+"</td></tr>")}),$("#entidadesEdt_modal").openModal()):Swal.fire({title:"Ups!!",text:"No se encontraron empresas asociadas a esta Edt!",type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})},error:function(e,a,t){alert("Error: "+t)}})}function detallesDeUnaEdt(e){$.ajax({dataType:"json",type:"get",url:"/edt/consultarDetallesDeUnaEdt/"+e+"/0",success:function(a){$("#detalleEdt_titulo").empty(),$("#detalleEdt_detalle").empty();let t="";t="Inactiva"==a.edt.estado?a.edt.fecha_cierre:"La Edt aún se encuentra activa!",$("#detalleEdt_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaEdt/"+e+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='cyan-text text-darken-3'>Código de la Edt: </span>"+a.edt.codigo_edt),$("#detalleEdt_detalle").append('<div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código de la Edt: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.codigo_edt+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Nombre de la Edt: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.nombre+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Área de Conocimiento: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.areaconocimiento+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Tipo de Edt: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.tipoedt+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Fecha de Inicio: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.fecha_inicio+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Fecha de Cierre: </span></div><div class="col s12 m6 l6"><span class="black-text">'+t+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m12 l12"><h6 class="cyan-text text-darken-3 center">Asistentes</h6></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Empleados: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.empleados+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Instructores: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.instructores+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Aprendices: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.aprendices+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Público: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.publico+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Observaciones: </span></div><div class="col s12 m6 l6"><span class="black-text">'+a.edt.observaciones+'</span></div></div><div class="divider"></div>'),$("#detalleEdt_modal").openModal()},error:function(e,a,t){alert("Error: "+t)}})}$(document).ready(function(){divOtroAreaConocmiento=$("#otroAreaConocimiento_content"),divEconomiaNaranja=$("#economiaNaranja_content"),divDiscapacidad=$("#discapacidad_content"),divNombreActorCTi=$("#nombreActorCTi_content"),divOtroAreaConocmiento.hide(),divEconomiaNaranja.hide(),divDiscapacidad.hide(),divNombreActorCTi.hide()}),$(document).on("submit","form#frmProyectos_FaseInicio",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormProyecto(a,t,o,"create")}),$(document).on("submit","form#frmProyectos_FaseInicio_Update",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormProyecto(a,t,o,"update")}),$(document).on("submit","form#frmProyectos_FaseCierre_Update",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormProyecto_FaseCierre(a,t,o)}),$(document).ready(function(){$("#empresasDeTecnoparque_modEdt_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthMenu:[[5,25,50,-1],[5,25,50,"All"]],processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},deferRender:!0,columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"add_empresa_a_edt",name:"add_empresa_a_edt"}]})}),divFechaCierreEdt=$("#divFechaCierreEdt"),divFechaCierreEdt.hide(),$(document).ready(function(){consultarEdtsDeUnGestor(0)}),$(document).ready(function(){datatableEdtsPorNodo(0)}),$(document).ready(function(){let e=$("#filter_nodo_art").val(),a=$("#filter_year_art").val(),t=$("#filter_phase").val(),o=$("#filter_tipo_articulacion").val(),n=$("#filter_alcance_articulacion").val();""!=e&&null!=e||""==a||""==t||""==o||""!=n&&null!=n?""==e&&null==e||""==a||""==t||""==o||""==n&&null==n?$("#articulaciones_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():articulacion_pbt.fill_datatatables_articulacion(e,a,t,o,n):articulacion_pbt.fill_datatatables_articulacion(e=null,a=null,t=null,o=null,n=null)}),$("#filter_articulacion").click(function(){let e=$("#filter_nodo_art").val(),a=$("#filter_year_art").val(),t=$("#filter_phase").val(),o=$("#filter_tipo_articulacion").val(),n=$("#filter_alcance_articulacion").val();$("#articulaciones_data_table").dataTable().fnDestroy(),""!=e&&null!=e||""==a||""==t||""==o||""!=n&&null!=n?""==e&&null==e||""==a||""==t||""==o||""==n&&null==n?$("#articulaciones_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():articulacion_pbt.fill_datatatables_articulacion(e,a,t,o,n):articulacion_pbt.fill_datatatables_articulacion(e=null,a,t,o,n=null)});var articulacion_pbt={fill_datatatables_articulacion:function(e=null,a=null,t=null,o=null,n=null){$("#articulaciones_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!1,serverSide:!1,order:[[5,"desc"]],ajax:{url:"/articulaciones/datatable_filtros",type:"get",data:{filter_nodo_art:e,filter_year_art:a,filter_phase:t,filter_tipo_articulacion:o,filter_alcance_articulacion:n}},columns:[{data:"nodo",name:"nodo"},{data:"codigo_articulacion",name:"codigo_articulacion"},{data:"nombre_articulacion",name:"nombre_articulacion"},{data:"articulador",name:"articulador"},{data:"fase",name:"fase"},{data:"starDate",name:"starDate"},{data:"show",name:"show",orderable:!1}]})}};function preguntaReversarArticulacion(e){e.preventDefault(),Swal.fire({title:"¿Está seguro(a) de reversar esta articulación a la fase de Inicio?",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Sí!"}).then(e=>{e.value&&document.frmReversarFase.submit()})}function ajaxSendFormArticulacionFaseCierre(e,a,t){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),mensajesArticulacionCierre(e)},error:function(e,a,t){alert("Error: "+t)}})}function printErroresFormulario(e){if("error_form"==e.state){let a="";for(control in e.errors)a+=" </br><b> - "+e.errors[control]+" </b> ",$("#"+control+"-error").html(e.errors[control]),$("#"+control+"-error").show();Swal.fire({title:"Advertencia!",html:"Estas ingresando mal los datos."+a,type:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}}function mensajesArticulacionCierre(e){"update"==e.state&&(Swal.fire({title:"Modificación Exitosa!",text:"La articulación ha sido modificado satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace("/articulaciones/"+e.data.id)},1e3)),"no_update"==e.state&&Swal.fire({title:"La articulación no se ha modificado, por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})}function ajaxSendFormArticulacion(e,a,t,o,n){$.ajax({type:e.attr("method"),url:t,data:a,cache:!1,contentType:!1,dataType:"json",processData:!1,success:function(e){$('button[type="submit"]').removeAttr("disabled"),$(".error").hide(),printErroresFormulario(e),filter_project.messageArticulacion(e,o,n)},error:function(e,a,t){alert("Error: "+t)}})}$("#download_archive_art").click(function(){var e={filter_nodo:$("#filter_nodo_art").val(),filter_year:$("#filter_year_art").val(),filter_phase:$("#filter_phase").val(),filter_tipo_articulacion:$("#filter_tipo_articulacion").val(),filter_alcance_articulacion:$("#filter_alcance_articulacion").val()},a="/articulaciones/export?"+$.param(e);window.location=a}),$(document).on("submit","form#frmArticulacionpbt_FaseInicio",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacion(a,t,o,"registrada","Registro exitoso")}),$(document).on("submit","form#frmUpdateArticulacion_FaseInicio",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacion(a,t,o,"actualizado","Modificación Exitosa")}),$(document).on("submit","form#frmUpdateArticulacionMiembros",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacion(a,t,o,"actualizado","Modificación Exitosa")}),$(document).on("submit","form#frmArticulacionFaseCierre",function(e){$('button[type="submit"]').attr("disabled","disabled"),e.preventDefault();var a=$(this),t=new FormData($(this)[0]),o=a.attr("action");ajaxSendFormArticulacionFaseCierre(a,t,o)}),$("#filter_code_project").click(function(){let e=$("#filter_code").val();(""!=e||null!=e||e.length>0)&&filter_project.fill_code_project(e)}),$("#filter_nit_company").click(function(){let e=$("#filter_nit").val();(""!=e||null!=e||e.length>0)&&filter_project.fill_nit_company(e)}),$("#filter_project_advanced").click(function(){let e=$("#filter_year_pro").val();filter_project.queryProyectosFaseInicioTable(e)}),$("#filter_project_modal").click(function(){let e=$("#filter_year_pro").val();filter_project.queryProyectosFaseInicioTable(e)}),$("#filter_company_advanced").click(function(){filter_project.queryCompaniesTable()}),$("#search_talent").click(function(){let e=$("#txtsearch_user").val();e.length>0?filter_project.searchUser(e):(filter_project.emptyResult("result-talents"),filter_project.notFound("result-talents"))}),$("#filter_talents_advanced").click(function(){filter_project.queryTalentos()});var filter_project={fill_code_project:function(e=null){filter_project.emptyResult("alert-response"),filter_project.emptyResult("collection-response"),filter_project.emptyResult("alert-response-talents"),filter_project.emptyResult("txtnombre_articulacion"),e.length>0?$.ajax({dataType:"json",type:"get",url:"/actividades/filter-code/"+e}).done(function(e){if(200==e.data.status_code){let a=e.data.proyecto.articulacion_proyecto.actividad,t=e.data;$("#txtnombre_articulacion").val(a.nombre),$("label[for='txtnombre_articulacion']").addClass("active"),$(".alert-response").append('\n                    <div class="row">\n                        <div class="col s12 m12 l12">\n                            <div class="card card-transparent">\n                                <div class="card-content">\n                                    <span class="card-title p-h-lg p f-12"> '+a.codigo_actividad+" - "+a.nombre+'</span>\n                                    <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: '+filter_project.formatDate(a.fecha_cierre)+"</div>\n                                    <p>"+a.objetivo_general+'</p>\n                                    <input type="hidden" name="txtpbt" value="'+e.data.proyecto.id+'"/>\n                                </div>\n                                <div class="card-action">\n                                <a class="orange-text text-darken-1" target="_blank" href="/proyecto/detalle/'+t.proyecto.id+'">Ver más</a>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                    '),$(".collection-response").append('\n                    <li class="collection-item dismissable">\n                        <a target="_blank" href="/proyecto/detalle/'+t.proyecto.id+'" class="secondary-content orange-text"><i class="material-icons">link</i></a>\n                        <span class="title">PBT</span>\n                        <p>'+a.codigo_actividad+"<br>\n                            "+a.nombre+'\n                        </p>\n                    </li>\n                    <li class="collection-item dismissable">\n                        <a  onclick="detallesIdeaPorId('+t.proyecto.idea.id+')" class="secondary-content orange-text" >\n\n                            <i class="material-icons">link</i>\n                        </a>\n                        <span class="title">Idea:</span>\n\n                        <p>'+t.proyecto.idea.codigo_idea+"<br>\n                        "+t.proyecto.idea.nombre_proyecto+"\n                        </p>\n\n                    </li>\n                    "),0!=t.proyecto.articulacion_proyecto.talentos.length?$.each(t.proyecto.articulacion_proyecto.talentos,function(e,a){$(".alert-response-talents").append('<div class="row card-talent'+a.user.id+'">\n                                    <div class="col s12 m12 l12">\n                                        <div class="card bs-dark">\n                                            <div class="card-content">\n                                                <span class="card-title p-h-lg"> '+a.user.documento+" - "+a.user.nombres+" "+a.user.apellidos+'</span>\n                                                <input type="hidden" name="talentos[]" value="'+a.id+'"/>\n                                                <div class="p-h-lg">\n                                                    <input type="radio" checked class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor'+a.id+'" value="'+a.id+'" /><label for ="radioInterlocutor'+a.id+'">Talento Interlocutor</label>\n                                                </div>\n                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">  Acceso al sistema: '+userSearch.state(a.user.estado)+'</div>\n                                                <p class="hide-on-med-and-down"> Miembro desde '+filter_project.formatDate(a.user.created_at)+'</p>\n                                            </div>\n                                            <div class="card-action">\n                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/'+a.user.documento+'"><i class="material-icons left"> link</i>Ver más</a>\n                                                <a onclick="filter_project.deleteTalent( '+a.user.id+');" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>')}):filter_project.notFound("alert-response-talents")}else filter_project.notFound("alert-response"),filter_project.notFound("alert-response-talents"),$(".collection-response").append('\n                        <li class="collection-item dismissable">\n                            <span class="title">Sin resultados</span>\n                        </li>\n                    ')}):(filter_project.notFound("alert-response"),filter_project.notFound("alert-response-talents"),$(".collection-response").append('\n                <li class="collection-item dismissable">\n                    <span class="title">Sin resultados</span>\n                </li>\n            '))},fill_nit_company:function(e=null){filter_project.emptyResult("alert-response"),filter_project.emptyResult("alert-response-sedes"),e.length>0?$.ajax({dataType:"json",type:"get",url:"/empresas/filter-code/"+e}).done(function(e){if(200==e.data.status_code){let a=e.data;0!=a.empresa.sedes.length?$.each(a.empresa.sedes,function(e,t){$(".alert-response-sedes").append('<div class="row card-talent'+t.id+'">\n                                    <div class="col s12 m12 l12">\n                                        <div class="card bs-dark">\n                                            <div class="card-content">\n                                                <span class="card-title p-h-lg"> '+t.nombre_sede+'</span>\n                                                <input type="hidden" name="sedes" value="'+t.id+'"/>\n\n                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Empresa: '+a.empresa.nit+" - "+a.empresa.nombre+'</div>\n\n                                            </div>\n                                            <div class="card-action">\n                                                <a onclick="filter_project.addSedeArticulacionPbt( '+t.id+');" class="waves-effect waves-red btn-flat m-b-xs orange-text">Agregar sede</a>\n                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/empresa/detalle/'+a.empresa.id+'"><i class="material-icons left"> link</i>Ver más</a>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>')}):(filter_project.notFound("alert-response-sedes"),filter_project.notFound("alert-response-company"))}else filter_project.notFound("alert-response-sedes"),filter_project.notFound("alert-response-company")}):(filter_project.notFound("alert-response"),filter_project.notFound("alert-response-sedes"))},sedesEmpresa:function(e){let a="";return e.forEach(e=>{a+='<li class="collection-item">\n            '+e.nombre_sede+" - "+e.direccion+'\n            <a href="#!" class="secondary-content" onclick="filter_project.addSedeArticulacionPbt('+e.id+')">Asociar esta sede a la articulación</a></div>\n          </li>'}),a},addSedeArticulacionPbt:function(e){filter_project.printSede(e),$("#sedes_modal").closeModal(),$("#company_modal").closeModal()},printSede:function(e){filter_project.emptyResult("alert-response-company"),$.ajax({dataType:"json",type:"get",url:"/empresas/sede/"+e}).done(function(e){200==e.data.status_code?$(".alert-response-company").append('\n                <div class="row">\n                    <div class="col s12 m12 l12">\n                        <div class="card transparent bs-dark">\n                            <div class="card-content">\n                                <span class="card-title p-h-lg"> '+e.data.sede.nombre_sede+'</span>\n                                <input type="hidden" name="txtsede" value="'+e.data.sede.id+'"/>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                '):filter_project.notFound("alert-response-company")})},deleteTalent:function(e){$(".card-talent"+e).remove(),Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"success",title:"Talento eliminado."})},queryProyectosFaseInicioTable:function(e=null){$("#datatable_projects_finalizados").dataTable().fnDestroy(),$("#datatable_projects_finalizados").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/proyecto/datatableproyectosfinalizados",type:"get",data:{filter_year_pro:e}},columns:[{data:"codigo_proyecto",name:"codigo_proyecto"},{data:"nombre",name:"nombre"},{data:"fase",name:"fase"},{data:"add_proyecto",name:"add_proyecto",orderable:!1}]}),$("#filter_project_advanced_modal").openModal()},queryCompaniesTable:function(){filter_project.emptyResult("alert-response-sedes"),filter_project.emptyResult("alert-response-company"),filter_project.notFound("alert-response-sedes"),filter_project.notFound("alert-response-company"),$("#companies_table").dataTable().fnDestroy(),$("#companies_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/empresa/datatableEmpresasDeTecnoparque",type:"get"},columns:[{data:"nit",name:"nit"},{data:"nombre_empresa",name:"nombre_empresa"},{data:"add_company_art",name:"add_company_art",orderable:!1}]}),$("#company_modal").openModal()},queryTalentos:function(){$("#datatable_talents_art").dataTable().fnDestroy(),$("#datatable_talents_art").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,ajax:{url:"/usuario/talento/getTalentosDeTecnoparque/",type:"get"},columns:[{data:"documento",name:"documento"},{data:"talento",name:"talento"},{data:"add_articulacion_pbt",name:"add_articulacion_pbt",orderable:!1}]}),$("#filter_talents_advanced_modal").openModal()},addProjectToArticulacion:function(e){filter_project.fill_code_project(e),filter_project.emptyResult("result-talents"),$("#filter_project_advanced_modal").closeModal()},searchUser:function(e){$(".result-talents").empty(),null==e&&null==e||$.ajax({dataType:"json",type:"get",url:"/usuarios/filtro-talento/"+e}).done(function(e){if(200==e.data.status_code){let a=e.data.user;$(".result-talents").append('<div class="row">\n                        <div class="col s12 m12 l12">\n                            <div class="card card-transparent">\n                                <div class="card-content">\n                                    <span class="card-title p f-12 "> '+a.documento+" - "+a.nombres+" "+a.apellidos+'</span>\n                                    <p class="position-top-right p f-12 mail-date hide-on-med-and-down"> Acceso al sistema: '+userSearch.state(a.estado)+'</p>\n                                    <div class="mailbox-text p f-12 hide-on-med-and-down">\n                                                Miembro desde '+filter_project.formatDate(a.created_at)+'\n                                        </div>\n                                </div>\n                                <div class="card-action">\n                                <a onclick="filter_project.addTalentArticulacionPbt( '+a.talento.id+');" class="orange-text">Agregar</a>\n                                </div>\n                            </div>\n                        </div>\n                    </div>')}else filter_project.notFound("result-talents")})},formatDate:function(e){return null==e?"no registra":moment(e).format("LL")},notFound:function(e){if(null!=e)return $("."+e).append('<div class="row">\n                <div class="col s12 m12 l12">\n                    <div class="card card-transparent">\n                        <div class="card-content">\n                            <div class="search-result">\n                                <p class="search-result-description">No se encontraron resultados</p>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>')},emptyResult:function(e){null!=e&&$("."+e).empty()},addTalentArticulacionPbt:function(e){0==filter_project.noRepeat(e)?filter_project.talentAssociated():(filter_project.emptyResult("talent-empty"),filter_project.printTalentoInTable(e)),$("#filter_talents_advanced_modal").closeModal()},noRepeat:function(e){let a=e,t=!0,o=document.getElementsByName("talentos[]");for(x=0;x<o.length;x++)if(o[x].value==a){t=!1;break}return t},talentAssociated:function(){Swal.fire({toast:!0,position:"top-end",showConfirmButton:!1,timer:1500,type:"warning",title:"El talento ya se encuentra asociado a la articulación!"})},printTalentoInTable:function(e){$.ajax({dataType:"json",type:"get",url:"/usuario/talento/consultarTalentoPorId/"+e}).done(function(e){let a=filter_project.prepareTableRowTalent(e);$(".alert-response-talents").append(a)})},prepareTableRowTalent:function(e){let a=e;return'<div class="row card-talent'+a.talento.id+'">\n                        <div class="col s12 m12 l12">\n                            <div class="card">\n                                <div class="card-content">\n                                    <span class="card-title"> '+a.talento.documento+" - "+a.talento.talento+'</span>\n                                    <input type="hidden" name="talentos[]" value="'+a.talento.id+'"/>\n                                    <input type="radio" checked class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor'+a.talento.id+'" value="'+a.talento.id+'" /><label for ="radioInterlocutor'+a.talento.id+'">Talento Interlocutor</label>\n                                </div>\n                                <div class="card-action">\n                                    <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/'+a.talento.documento+'"><i class="material-icons left"> link</i>Ver más</a>\n                                    <a onclick="filter_project.deleteTalent( '+a.talento.id+');" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>\n                                </div>\n                            </div>\n                        </div>\n                    </div>'},messageArticulacion:function(e,a,t){201==e.status_code&&(Swal.fire({title:t,text:"La articulación ha sido "+a+" satisfactoriamente",type:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}),setTimeout(function(){window.location.replace(e.url)},1e3)),404==e.state&&Swal.fire({title:"La articulación no se ha "+a+", por favor inténtalo de nuevo",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"})},showSeccionProject:function(){$(".section-projects").show()},hideSeccionProject:function(){$(".section-projects").hide()},showSeccionCompany:function(){$(".section-company").show()},hideSeccionCompany:function(){$(".section-company").hide()},showsectionCollapseTalent:function(e,a,t){e[0].classList.remove("active"),e[1].classList.add("active"),a[0].classList.remove("active"),a[1].classList.add("active"),t[1].setAttribute("style","display: block; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;")},hidesectionCollapseTalent:function(e,a,t){e[1].classList.remove("active"),e[0].classList.add("active"),a[1].classList.remove("active"),a[0].classList.add("active"),t[1].setAttribute("style","")},emptySectionProject:function(){filter_project.emptyResult("result-talents"),filter_project.notFound("result-talents"),filter_project.emptyResult("alert-response"),filter_project.emptyResult("collection-response"),filter_project.emptyResult("alert-response-talents"),$("#txtnombre_articulacion").val()}};function checkTipoVinculacion(e){let a=document.getElementsByClassName("collapsible-li"),t=document.getElementsByClassName("collapsible-header grey lighten-2"),o=document.getElementsByClassName("collapsible-body");$("#IsPbt").is(":checked")?(filter_project.emptyResult("alert-response-sedes"),filter_project.emptyResult("alert-response-company"),filter_project.notFound("alert-response-sedes"),filter_project.notFound("alert-response-company"),filter_project.showSeccionProject(),filter_project.hideSeccionCompany(),filter_project.hidesectionCollapseTalent(a,t,o)):$("#IsSenaInnova").is(":checked")?(filter_project.emptyResult("alert-response"),filter_project.emptyResult("collection-response"),filter_project.hideSeccionProject(),filter_project.showSeccionCompany(),filter_project.showsectionCollapseTalent(a,t,o)):$("#IsColinnova").is(":checked")&&(filter_project.emptyResult("alert-response"),filter_project.emptyResult("collection-response"),filter_project.hideSeccionProject(),filter_project.showSeccionCompany(),filter_project.showsectionCollapseTalent(a,t,o))}function addCompanyArticulacion(e){$("#sedes_detail").empty(),$.ajax({dataType:"json",type:"get",url:"/empresa/ajaxDetallesDeUnaEmpresa/"+e+"/id",success:function(e){let a=filter_project.sedesEmpresa(e.empresa.sedes);$("#sedes_detail").append(a),$("#sedes_modal").openModal()},error:function(e,a,t){alert("Error: "+t)}})}$(document).ready(function(){$("#costoadministrativo_dinamizador_table1").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,ajax:{url:"/costos-administrativos",type:"get"},columns:[{data:"entidad",name:"entidad",width:"30%"},{data:"costoadministrativo",name:"costoadministrativo",width:"30%"},{data:"valor",name:"valor",width:"15%"},{data:"costosadministrativospordia",name:"costosadministrativospordia",width:"15%"},{data:"costosadministrativosporhora",name:"costosadministrativosporhora",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}],footerCallback:function(e,a,t,o,n){var i=this.api(),r=function(e){return"string"==typeof e?1*e.replace(/[\$,]/g,""):"number"==typeof e?e:0};totalCostosHora=i.column(4).data().reduce(function(e,a){return r(e)+r(a)},0),totalCostosDia=i.column(3).data().reduce(function(e,a){return r(e)+r(a)},0),totalCostosMes=i.column(2).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosHora=i.column(4,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosDia=i.column(3,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosMes=i.column(2,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),$(i.column(4).footer()).html("$ "+pageTotalCostosHora+" ( $"+totalCostosHora+" total)"),$(i.column(3).footer()).html("$ "+pageTotalCostosDia+" ( $"+totalCostosDia+" total)"),$(i.column(2).footer()).html("$ "+pageTotalCostosMes+" ( $"+totalCostosMes+" total)")}})}),$(document).ready(function(){$("#costoadministrativo_dinamizador_table1").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,ajax:{url:"/costos-administrativos",type:"get"},columns:[{data:"entidad",name:"entidad",width:"30%"},{data:"costoadministrativo",name:"costoadministrativo",width:"30%"},{data:"valor",name:"valor",width:"15%"},{data:"costosadministrativospordia",name:"costosadministrativospordia",width:"15%"},{data:"costosadministrativosporhora",name:"costosadministrativosporhora",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}],footerCallback:function(e,a,t,o,n){var i=this.api(),r=function(e){return"string"==typeof e?1*e.replace(/[\$,]/g,""):"number"==typeof e?e:0};totalCostosHora=i.column(4).data().reduce(function(e,a){return r(e)+r(a)},0),totalCostosDia=i.column(3).data().reduce(function(e,a){return r(e)+r(a)},0),totalCostosMes=i.column(2).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosHora=i.column(4,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosDia=i.column(3,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosMes=i.column(2,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),$(i.column(4).footer()).html("$ "+pageTotalCostosHora+" ( $"+totalCostosHora+" total)"),$(i.column(3).footer()).html("$ "+pageTotalCostosDia+" ( $"+totalCostosDia+" total)"),$(i.column(2).footer()).html("$ "+pageTotalCostosMes+" ( $"+totalCostosMes+" total)")}})}),$(document).ready(function(){let e=$("#filter_nodo").val(),a=$("#filter_state").val();$("#equipo_data_table").dataTable().fnDestroy(),""!=e||null!=e?equipo.fillDatatatablesEquipos(e,a):""!=e&&null!=e&&null!=e||""!=a&&null!=a&&null!=a?$("#equipo_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():equipo.fillDatatatablesEquipos(e=null,a=null),$("#equipo_actions_data_table").dataTable().fnDestroy(),""!=e||null!=e?equipo.fillDatatatablesEquiposActions(e,a):""!=e&&null!=e&&null!=e||""!=a&&null!=a&&null!=a?$("#equipo_actions_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():equipo.fillDatatatablesEquiposActions(e=null,a=null)});var equipo={fillDatatatablesEquipos(e,a){$("#equipo_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},order:[[1,"desc"]],processing:!0,serverSide:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/equipos",type:"get",data:{filter_nodo:e,filter_state:a}},columns:[{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"referencia",name:"referencia",width:"15%"},{data:"marca",name:"marca",width:"15%"},{data:"costo_adquisicion",name:"costo_adquisicion",width:"15%"},{data:"vida_util",name:"vida_util",width:"15%"},{data:"horas_uso_anio",name:"horas_uso_anio",width:"15%"},{data:"anio_compra",name:"anio_compra",width:"15%"},{data:"anio_fin_depreciacion",name:"anio_fin_depreciacion",width:"15%"},{data:"depreciacion_por_anio",name:"depreciacion_por_anio",width:"15%"},{data:"state",name:"state",width:"15%"}]})},fillDatatatablesEquiposActions(e,a){$("#equipo_actions_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},order:[[1,"desc"]],processing:!0,serverSide:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/equipos",type:"get",data:{filter_nodo:e,filter_state:a}},columns:[{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"referencia",name:"referencia",width:"15%"},{data:"marca",name:"marca",width:"15%"},{data:"costo_adquisicion",name:"costo_adquisicion",width:"15%"},{data:"vida_util",name:"vida_util",width:"15%"},{data:"state",name:"state",width:"15%"},{data:"detail",name:"detail",width:"15%"},{data:"edit",name:"edit",width:"15%",orderable:!1},{data:"changeState",name:"changeState",width:"15%",orderable:!1},{data:"delete",name:"delete",width:"15%",orderable:!1}]})},detail(e){$.ajax({dataType:"json",type:"get",url:`/equipos/${e}`}).done(function(e){if($("#titulo").empty(),$("#detalle_equipo").empty(),404==e.statusCode)swal("Ups!!!","No se encontraron resultados","error");else{let a=e.data.equipo;$("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Equipo: </span>"+a.nombre),$("#detalle_equipo").append(`\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Linea Tecnológica: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">${a.lineatecnologica.abreviatura} - ${a.lineatecnologica.nombre}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Referencia: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">${a.referencia}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Marca: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">${a.marca}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Costo Adquisición: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">$ ${a.costo_adquisicion}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Año de compra: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">${a.anio_compra}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Vida Util: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">${a.vida_util}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Año de depreciación: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">${e.data.aniodepreciacion}</span>\n                        </div>\n                    </div>\n                    <div class="divider"></div>\n                    <div class="row">\n                        <div class="col s12 m6 l6">\n                            <span class="cyan-text text-darken-3">Valor depreciación por año: </span>\n                        </div>\n                        <div class="col s12 m6 l6">\n                            <span class="black-text">$ ${e.data.depreciacion}</span>\n                        </div>\n                    </div>\n                    `),$(".modal-equipo").openModal()}})},deleteEquipo:function(e){Swal.fire({title:"¿Estas seguro de eliminar este equipo?",text:"Recuerde que si lo elimina no lo podrá recuperar.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"si, elminar equipo",cancelButtonText:"No, cancelar"}).then(a=>{if(a.value){let a=$("meta[name='csrf-token']").attr("content");$.ajax({url:`/equipos/${e}`,type:"DELETE",data:{id:e,_token:a},success:function(e){200==e.statusCode?(Swal.fire("Eliminado!","El equipo ha sido eliminado satisfactoriamente.","success"),location.href=e.route):226==e.statusCode&&Swal.fire("No se puede elimnar!",e.message,"error")},error:function(e,a,t){alert("Error: "+t)}})}else a.dismiss===Swal.DismissReason.cancel&&swalWithBootstrapButtons.fire("Cancelado","Tu equipo está a salvo","error")})},changeState:function(e){Swal.fire({title:"¿Estas seguro de cambiar el estado a  este equipo?",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"si, cambiar estado",cancelButtonText:"No, cancelar"}).then(a=>{a.value?$.ajax({url:`/equipos/cambiar-estado/${e}`,type:"GET",success:function(e){200==e.statusCode?(Swal.fire("Estado cambiado!","El equipo ha cambiado de estado.","success"),location.href=e.route):Swal.fire("No se puede cambiar estado!",e.message,"error")},error:function(e,a,t){alert("Error: "+t)}}):a.dismiss===Swal.DismissReason.cancel&&swalWithBootstrapButtons.fire("Cancelado","Tu equipo está a salvo","error")})}};$("#filter_equipo").click(function(){let e=$("#filter_nodo").val(),a=$("#filter_state").val();$("#equipo_data_table").dataTable().fnDestroy(),""!=e||null!=e?equipo.fillDatatatablesEquipos(e,a):""!=e&&null!=e&&null!=e||""!=a&&null!=a&&null!=a?$("#equipo_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():equipo.fillDatatatablesEquipos(e=null,a=null),$("#equipo_actions_data_table").dataTable().fnDestroy(),""!=e||null!=e?equipo.fillDatatatablesEquiposActions(e,a):""!=e&&null!=e&&null!=e||""!=a&&null!=a&&null!=a?$("#equipo_actions_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():equipo.fillDatatatablesEquiposActions(e=null,a=null)}),$("#download_equipos").click(function(){var e={filter_nodo:$("#filter_nodo").val(),filter_state:$("#filter_state").val()},a="/equipos/export?"+$.param(e);window.location=a}),$(document).ready(function(){$("#mantenimientosequipos_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers",lengthChange:!1})});var selectMantenimientosEquiposPorNodo={selectMantenimientosEquipoForNodo:function(){let e=$("#selectnodo").val();$("#mantenimientosequipos_administrador_table").dataTable().fnDestroy(),""!=e?$("#mantenimientosequipos_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,retrieve:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/mantenimientos/getmantenimientosequipospornodo/"+e,type:"get"},columns:[{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"equipo",name:"equipo",width:"30%"},{data:"ultimo_anio_mantenimiento",name:"ultimo_anio_mantenimiento",width:"15%"},{data:"valor_mantenimiento",name:"valor_mantenimiento",width:"15%"},{data:"detail",name:"detail",width:"15%"}]}):$("#mantenimientosequipos_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};$(document).ready(function(){$("#mantenimientosequipos_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/mantenimientos",type:"get"},columns:[{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"equipo",name:"equipo",width:"30%"},{data:"ultimo_anio_mantenimiento",name:"ultimo_anio_mantenimiento",width:"15%"},{data:"valor_mantenimiento",name:"valor_mantenimiento",width:"15%"},{data:"detail",name:"detail",width:"15%"},{data:"edit",name:"edit",orderable:!1,width:"8%"}]})}),$(document).ready(function(){$("#mantenimientosequipos_gestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/mantenimientos",type:"get"},columns:[{data:"lineatecnologica",name:"lineatecnologica",width:"30%"},{data:"equipo",name:"equipo",width:"30%"},{data:"ultimo_anio_mantenimiento",name:"ultimo_anio_mantenimiento",width:"15%"},{data:"valor_mantenimiento",name:"valor_mantenimiento",width:"15%"},{data:"detail",name:"detail",width:"15%"}]})}),$(document).ready(function(){$("#materiales_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers",lengthChange:!1})});var selectMaterialesPorNodo={selectMaterialesForNodo:function(){let e=$("#selectnodo").val();$("#materiales_administrador_table").dataTable().fnDestroy(),""!=e?$("#materiales_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,retrieve:!0,lengthChange:!1,fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/materiales/getmaterialespornodo/"+e,type:"get"},columns:[{data:"fecha",name:"fecha",width:"20%"},{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"codigo_material",name:"codigo_material",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"presentacion",name:"presentacion",width:"15%"},{data:"medida",name:"medida",width:"15%"},{data:"cantidad",name:"cantidad",width:"15%"},{data:"valor_unitario",name:"valor_unitario",width:"15%"},{data:"valor_compra",name:"valor_compra",width:"15%"},{data:"detail",name:"detail",width:"15%"}]}):$("#materiales_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};function getSelectMaterialMedida(){let e=$("#txtmedida option:selected").text(),a=$("#txtmedida").val();$("#txtcantidad").prop("disabled",!0),$("label[for='txtcantidad']").empty(),""!=a?($("#txtcantidad").prop("disabled",!1),$("#txtcantidad").val(""),$("label[for='txtcantidad']").text("Tamaño presentacion o venta/paquete en "+e)):($("#txtcantidad").prop("disabled",!0),$("label[for='txtcantidad']").text("Tamaño presentacion o venta/paquete"))}$(document).ready(function(){$("#materiales_dinamizador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/materiales",type:"get"},columns:[{data:"fecha",name:"fecha",width:"20%"},{data:"nombrelinea",name:"nombrelinea",width:"30%"},{data:"codigo_material",name:"codigo_material",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"presentacion",name:"presentacion",width:"15%"},{data:"medida",name:"medida",width:"15%"},{data:"cantidad",name:"cantidad",width:"15%"},{data:"valor_unitario",name:"valor_unitario",width:"15%"},{data:"valor_compra",name:"valor_compra",width:"15%"},{data:"detail",name:"detail",width:"15%"}]})}),$(document).ready(function(){$("#materiales_gestor_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,retrieve:!0,processing:!0,serverSide:!0,ajax:{url:"/materiales",type:"get"},columns:[{data:"fecha",name:"fecha",width:"20%"},{data:"codigo_material",name:"codigo_material",width:"30%"},{data:"nombre",name:"nombre",width:"30%"},{data:"presentacion",name:"presentacion",width:"15%"},{data:"medida",name:"medida",width:"15%"},{data:"cantidad",name:"cantidad",width:"15%"},{data:"valor_unitario",name:"valor_unitario",width:"15%"},{data:"valor_compra",name:"valor_compra",width:"15%"},{data:"detail",name:"detail",width:"15%"}]})});var materialFormacion={destroyMaterial:function(e){Swal.fire({title:"¿Estas seguro de eliminar este material de formación?",text:"Recuerde que si lo elimina no lo podrá recuperar.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"si, elminar material",cancelButtonText:"No, cancelar"}).then(a=>{if(a.value){let a=$("meta[name='csrf-token']").attr("content");$.ajax({url:"/materiales/"+e,type:"DELETE",data:{id:e,_token:a},success:function(e){200==e.status?(Swal.fire("Eliminado!","El material de formación ha sido eliminado satisfactoriamente.","success"),location.href=e.route):226==e.status&&Swal.fire("No se puede elimnar!",e.message,"error")},error:function(e,a,t){alert("Error: "+t)}})}else a.dismiss===Swal.DismissReason.cancel&&swalWithBootstrapButtons.fire("Cancelado","Tu material de formación está a salvo","error")})}};$(document).ready(function(){$("#costoadministrativo_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},pagingType:"full_numbers"})});var selectCostoAdministrativoNodo={selectCostoAdministrativoForNodo:function(){let e=$("#selectnodo").val();$("#costoadministrativo_administrador_table").dataTable().fnDestroy(),""!=e?$("#costoadministrativo_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,lengthChange:!1,order:[[1,"asc"]],fixedHeader:{header:!0,footer:!0},pagingType:"full_numbers",ajax:{url:"/costos-administrativos/costoadministrativo/"+e,type:"get"},columns:[{data:"entidad",name:"entidad",width:"30%"},{data:"costoadministrativo",name:"costoadministrativo",width:"30%"},{data:"valor",name:"valor",width:"15%"},{data:"costosadministrativospordia",name:"costosadministrativospordia",width:"15%"},{data:"costosadministrativosporhora",name:"costosadministrativosporhora",width:"15%"}],footerCallback:function(e,a,t,o,n){var i=this.api(),r=function(e){return"string"==typeof e?1*e.replace(/[\$,]/g,""):"number"==typeof e?e:0};totalCostosHora=i.column(4).data().reduce(function(e,a){return r(e)+r(a)},0),totalCostosDia=i.column(3).data().reduce(function(e,a){return r(e)+r(a)},0),totalCostosMes=i.column(2).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosHora=i.column(4,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosDia=i.column(3,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),pageTotalCostosMes=i.column(2,{page:"current"}).data().reduce(function(e,a){return r(e)+r(a)},0),$(i.column(4).footer()).html("$ "+pageTotalCostosHora+" ( $"+totalCostosHora+" total)"),$(i.column(3).footer()).html("$ "+pageTotalCostosDia+" ( $"+totalCostosDia+" total)"),$(i.column(2).footer()).html("$ "+pageTotalCostosMes+" ( $"+totalCostosMes+" total)")}}):$("#costoadministrativo_administrador_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,pagingType:"full_numbers"}).clear().draw()}};$(document).ready(function(){usoinfraestructuraIndex.queryActivitiesByAnio();let e=$("#filter_nodo").val(),a=$("#filter_year").val(),t=$("#filter_gestor").val(),o=$("#filter_actividad").val();$("#usoinfraestructa_data_table").dataTable().fnDestroy(),""==e&&null==e||""==a&&null==a||""==t&&null==t||""==o&&null==o?""!=e&&null!=e&&null!=e||""!=a&&null!=a&&null!=a||""!=t&&null!=t&&null!=t||""!=o&&null!=o&&null!=o?$("#usoinfraestructa_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(e=null,a=null,t=null,o=null):usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(e,a,t,o)});var usoinfraestructuraIndex={fillDatatatablesUsosInfraestructura:function(e,a,t,o){$("#usoinfraestructa_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1,processing:!0,serverSide:!0,order:[[0,"desc"]],ajax:{url:"/usoinfraestructura",type:"get",data:{filter_nodo:e,filter_year:a,filter_gestor:t,filter_actividad:o}},columns:[{data:"fecha",name:"fecha",width:"10%",orderable:!1},{data:"gestorEncargado",name:"gestorEncargado",width:"20%"},{data:"tipo_asesoria",name:"tipo_asesoria",width:"10%"},{data:"actividad",name:"actividad",width:"35%"},{data:"fase",name:"fase",width:"10%"},{data:"asesoria_directa",name:"asesoria_directa",width:"5%"},{data:"asesoria_indirecta",name:"asesoria_indirecta",width:"5%"},{data:"detail",name:"detail",width:"5%",orderable:!1}]})},queryGestoresByNodo:function(){let e=$("#filter_nodo").val();null==e||""==e||"all"==e||null==e?($("#filter_gestor").empty(),$("#filter_gestor").append('<option value="" selected>Seleccione un experto</option>')):$.ajax({type:"GET",url:"/usuario/usuarios/gestores/nodo/"+e,contentType:!1,dataType:"json",processData:!1,success:function(e){$("#filter_gestor").empty(),$("#filter_gestor").append('<option value="all">todos</option>'),$.each(e.gestores,function(e,a){$("#filter_gestor").append('<option  value="'+e+'">'+a+"</option>")}),$("#filter_gestor").material_select()},error:function(e,a,t){alert("Error: "+t)}})},queryActivitiesByAnio:function(){let e=$("#filter_year").val();null==e||""==e||null==e?($("#filter_actividad").empty(),$("#filter_actividad").append('<option value="">Seleccione un año</option>')):$.ajax({type:"GET",url:"/usoinfraestructura/actividades/"+e,contentType:!1,dataType:"json",processData:!1,success:function(e){$("#filter_actividad").empty(),$("#filter_actividad").append('<option value="all">Todas</option>'),$.each(e.actividades,function(e,a){$("#filter_actividad").append('<option  value="'+e+'">'+a+"</option>")}),$("#filter_actividad").material_select()},error:function(e,a,t){alert("Error: "+t)}})},destroyUsoInfraestructura:function(e){Swal.fire({title:"¿Estas seguro de eliminar este uso de infraestructura?",text:"Recuerde que si lo elimina no lo podrá recuperar.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"si, eliminar uso",cancelButtonText:"No, cancelar"}).then(a=>{if(a.value){let a=$("meta[name='csrf-token']").attr("content");$.ajax({url:"/usoinfraestructura/"+e,type:"DELETE",data:{id:e,_token:a},success:function(e){"success"==e.usoinfraestructura&&(Swal.fire("Eliminado!","Su uso de infraestructura ha sido eliminado satisfactoriamente.","success"),location.href=e.route)},error:function(e,a,t){alert("Error: "+t)}})}else a.dismiss===Swal.DismissReason.cancel&&swalWithBootstrapButtons.fire("Cancelado","Tu uso de infraestructura está a salvo","error")})}};function datatableVisitantesPorNodo_Ingreso(){$("#visitantesRedTecnoparque_table").dataTable().fnDestroy(),$("#visitantesRedTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/visitante/consultarVisitantesRedTecnoparque",type:"get"},columns:[{width:"15%",data:"documento",name:"documento"},{data:"tipo_documento",name:"tipo_documento"},{data:"tipo_visitante",name:"tipo_visitante"},{data:"visitante",name:"visitante"},{data:"email",name:"email"},{data:"contacto",name:"contacto"},{width:"8%",data:"edit",name:"edit",orderable:!1}]})}function datatableVisitantesPorNodo_DinamizadorAdministrador(){$("#visitantesRedTecnoparque_table").dataTable().fnDestroy(),$("#visitantesRedTecnoparque_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/visitante/consultarVisitantesRedTecnoparque",type:"get"},columns:[{width:"15%",data:"documento",name:"documento"},{data:"tipo_documento",name:"tipo_documento"},{data:"tipo_visitante",name:"tipo_visitante"},{data:"visitante",name:"visitante"},{data:"email",name:"email"},{data:"contacto",name:"contacto"}]})}function consultarIngresosDeUnNodo(e){$("#ingresosDeUnNodo_table").dataTable().fnDestroy(),$("#ingresosDeUnNodo_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/ingreso/consultarIngresosDeUnNodoTecnoparque/"+e,type:"get"},columns:[{width:"15%",data:"fecha_ingreso",name:"fecha_ingreso"},{width:"15%",data:"hora_salida",name:"hora_salida"},{data:"visitante",name:"visitante"},{data:"servicio",name:"servicio"},{data:"descripcion",name:"descripcion"},{width:"8%",data:"edit",name:"edit",orderable:!1}]})}function consultarVisitanteTecnoparque(){let e=$("#txtdocumento").val();""==e?Swal.fire({title:"Advertencia!",text:"Digite un número de documento!",type:"warning",showCancelButton:!1,confirmButtonColor:"#3085d6",confirmButtonText:"Ok"}):$.ajax({dataType:"json",type:"get",url:"/visitante/consultarVisitantePorDocumento/"+e,success:function(e){null==e.visitante?(divVisitanteRegistrado.hide(),divRegistrarVisitante.show()):($("#nombrePersona").val(e.visitante.visitante),$("#tipoPersona").val(e.visitante.tipovisitante),$("#contactoReg").val(e.visitante.contacto),$("#correoReg").val(e.visitante.email),divRegistrarVisitante.hide(),divVisitanteRegistrado.show())},error:function(e,a,t){alert("Error: "+t)}})}function consultarDetallesDeUnaCharlaInformativa(e){$.ajax({dataType:"json",type:"get",url:"/charla/consultarDetallesDeUnaCharlaInformativa/"+e,success:function(e){$("#modalDetalleDeUnaCharlaInformativa_titulo").empty(),$("#modalDetalleDeUnaCharlaInformativa_detalle_charla").empty(),$("#modalDetalleDeUnaCharlaInformativa_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Charla Informativa </span><br>"),$("#modalDetalleDeUnaCharlaInformativa_detalle_charla").append('<div class=\'row\'><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Código de la Charla Informativa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.codigo_charla+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Fecha de la Charla Informativa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.fecha+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Encargado de la Charla Informativa: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.encargado+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Número de Asistentens: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.nro_asistentes+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Observaciones: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.observacion+'</span></div></div><div class="divider"></div><h5 class="center">Evidencias</h5><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Programación de la Charla (Pantallazo del Envío de Correos): </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.programacion+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Evidencias Fotográficas: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.evidencia_fotografica+'</span></div></div><div class="divider"></div><div class="row"><div class="col s12 m6 l6"><span class="cyan-text text-darken-3">Listado de Asistencia: </span></div><div class="col s12 m6 l6"><span class="black-text">'+e.charla.listado_asistentes+'</span></div></div><div class="divider"></div>'),$("#detalleDeUnaCharlaInformativa_modal").openModal()},error:function(e,a,t){alert("Error: "+t)}})}$("#filter_usoinfraestructura").click(function(){let e=$("#filter_nodo").val(),a=$("#filter_year").val(),t=$("#filter_gestor").val(),o=$("#filter_actividad").val();$("#usoinfraestructa_data_table").dataTable().fnDestroy(),""==e&&null==e||""==a&&null==a||""==t&&null==t||""==o&&null==o?""!=e&&null!=e&&null!=e||""!=a&&null!=a&&null!=a||""!=t&&null!=t&&null!=t||""!=o&&null!=o&&null!=o?$("#usoinfraestructa_data_table").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},lengthChange:!1}).clear().draw():usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(e=null,a=null,t=null,o=null):usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(e,a,t,o)}),$("#download_usoinfraestructura").click(function(){var e={filter_nodo:$("#filter_nodo").val(),filter_year:$("#filter_year").val(),filter_gestor:$("#filter_gestor").val(),filter_actividad:$("#filter_actividad").val()},a="/usoinfraestructura/export?"+$.param(e);window.location=a}),$(document).ready(function(){});var ano=(new Date).getFullYear(),graficosId={grafico1:"graficoArticulacionesPorGestorYNodoPorFecha_stacked",grafico2:"graficoArticulacionesPorGestorYFecha_stacked",grafico3:"graficoArticulacionesPorLineaYFecha_stacked",grafico4:"graficoArticulacionesPorNodoYAnho_variablepie"},graficosEdtId={grafico1:"graficosEdtsPorGestorNodoYFecha_stacked",grafico2:"graficosEdtsPorGestorYFecha_stacked",grafico3:"graficoEdtsPorLineaYFecha_stacked",grafico4:"graficoEdtsPorNodoYAnho_variablepie"},graficosProyectoId={grafico1:"graficosProyectoPorMesYNodo_combinate",grafico2:"graficosProyectoConEmpresaPorMesYNodo_combinate",grafico3:"graficoProyectosPorTipoNodoYFecha_column",grafico4:"graficoProyectosFinalizadosPorNodoYAnho_column",grafico5:"graficoProyectosFinalizadosPorTipoNodoYFecha_column"};function alertaNodoNoValido(){Swal.fire("Advertencia!","Seleccione un nodo","warning")}function alertaGestorNoValido(){Swal.fire("Advertencia!","Seleccione un experto","warning")}function alertaLineaNoValido(){Swal.fire("Advertencia!","Seleccione una Línea Tecnológica","warning")}function alertaFechasNoValidas(){Swal.fire("Advertencia!","Seleccione fechas válidas!","warning")}function generarExcelGrafico3Edt(e){let a=0,t=$("#txtlinea_id_edtGrafico3").val(),o=$("#txtfecha_inicio_GraficoEdt3").val(),n=$("#txtfecha_fin_GraficoEdt3").val();1==e&&(a=$("#txtnodo_id").val()),""===a?alertaNodoNoValido():""===t?alertaLineaNoValido():location.href="/excel/excelEdtsFinalizadasPorLineaNodoYFecha/"+a+"/"+t+"/"+o+"/"+n}function generarExcelGrafico2Edt(e){let a=0;0==e&&(a=$("#txtgestor_id_edtGrafico2").val());let t=$("#txtfecha_inicio_edtGrafico2").val(),o=$("#txtfecha_fin_edtGrafico2").val();""===a?alertaGestorNoValido():location.href="/excel/excelEdtsFinalizadasPorGestorYFecha/"+a+"/"+t+"/"+o}function generarExcelGrafico1Edt(e){let a=0,t=$("#txtfecha_inicio_edtGrafico1").val(),o=$("#txtfecha_fin_edtGrafico1").val();1==e&&(a=$("#txtnodo_id").val()),""===a?alertaNodoNoValido():location.href="/excel/excelEdtsFinalizadasPorFechaYNodo/"+a+"/"+t+"/"+o}function generarExcelGrafico1Articulacion(e){let a=0,t=$("#txtfecha_inicio_Grafico1").val(),o=$("#txtfecha_fin_Grafico1").val();1==e&&(a=$("#txtnodo_id").val()),""===a?alertaNodoNoValido():location.href="/excel/excelArticulacionFinalizadasPorFechaYNodo/"+a+"/"+t+"/"+o}function generarExcelGrafico3Articulacion(e){let a=0,t=$("#txtlinea_tecnologica").val(),o=$("#txtfecha_inicio_Grafico1").val(),n=$("#txtfecha_fin_Grafico1").val();1==e&&(a=$("#txtnodo_id").val()),""===a?alertaNodoNoValido():""===t?alertaLineaNoValido():location.href="/excel/excelArticulacionFinalizadasPorFechaNodoYLinea/"+a+"/"+t+"/"+o+"/"+n}function generarExcelGrafico2Articulacion(){let e=$("#txtgestor_id").val(),a=$("#txtfecha_inicio_Grafico2").val(),t=$("#txtfecha_fin_Grafico2").val();""===e?alertaGestorNoValido():location.href="/excel/excelArticulacionFinalizadasPorGestorYFecha/"+e+"/"+a+"/"+t}function generarExcelGrafico4Articulacion(e){let a=0,t=$("#txtanho_Grafico4").val();1==e&&(a=$("#txtnodo_id").val()),""===a?alertaNodoNoValido():location.href="/excel/excelArticulacionFinalizadasPorNodoYAnho/"+a+"/"+t}function generarExcelGrafico1Proyecto(e){let a=0,t=$("#txtanho_GraficoProyecto1").val();1==e&&(a=$("#txtnodo_excelGrafico1Proyecto").val()),location.href="/excel/excelProyectosInscritosPorAnho/"+a+"/"+t}function generarExcelGrafico2Proyecto(e){let a=0,t=$("#txtanho_GraficoProyecto2").val();1==e&&(a=$("#txtnodo_excelGrafico2Proyecto").val()),location.href="/excel/excelProyectosInscritosConEmpresasPorAnho/"+a+"/"+t}function graficosProyectosPromedioCantidadesMeses(e,a){let t=e.proyectos.cantidades.length,o={cantidades:[],meses:[],promedios:[]};for(let a=0;a<t;a++)o.cantidades.push(e.proyectos.cantidades[a]);for(let a=0;a<t;a++)o.meses.push(e.proyectos.meses[a]);for(let a=0;a<t;a++)o.promedios.push(e.proyectos.promedios[a]);Highcharts.chart(a,{title:{text:"Proyectos Inscritos"},yAxis:{title:{text:"Cantidad/Promedio"}},xAxis:{categories:o.meses,title:{text:"Meses"}},series:[{type:"column",name:"Proyectos Inscritos",data:o.cantidades},{type:"spline",name:"Proyectos Inscritos",data:o.cantidades,dataLabels:{enabled:!0},marker:{lineWidth:2,lineColor:"#008981",fillColor:"#008981"}}]})}function graficosProyectosAgrupados(e,a,t){let o=e.proyectos.cantidades.length,n={cantidades:[],labels:[]};for(let a=0;a<o;a++)n.cantidades.push(e.proyectos.cantidades[a]);for(let a=0;a<o;a++)n.labels.push(e.proyectos.labels[a]);Highcharts.chart(a,{title:{text:"Proyectos Inscritos"},yAxis:{title:{text:"Cantidad"}},xAxis:{categories:n.labels,title:{text:t}},series:[{type:"column",name:"Proyectos Inscritos",data:n.cantidades},{type:"spline",name:"Proyectos Inscritos",data:n.cantidades,dataLabels:{enabled:!0},marker:{lineWidth:2,lineColor:"#008981",fillColor:"#008981"}}]})}function consultarProyectosFinalizadosPorTipoNodoYFecha_column(e){let a=0,t=$("#txtfecha_inicio_GraficoProyecto5").val(),o=$("#txtfecha_fin_GraficoProyecto5").val();1==e&&(a=$("#txtnodo_id").val()),t>o?alertaFechasNoValidas():$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosFinalizadosPorTipoNodoYFecha/"+a+"/"+t+"/"+o,success:function(e){graficosProyectosAgrupados(e,graficosProyectoId.grafico5,"Tipo de Proyecto")},error:function(e,a,t){alert("Error: "+t)}})}function consultarProyectosInscritosPorTipoNodoYFecha_column(e){let a=0,t=$("#txtfecha_inicio_GraficoProyecto3").val(),o=$("#txtfecha_fin_GraficoProyecto3").val();1==e&&(a=$("#txtnodo_id").val()),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosInscritosPorTipoNodoYFecha/"+a+"/"+t+"/"+o,success:function(e){graficosProyectosAgrupados(e,graficosProyectoId.grafico3,"Tipo de Proyecto")},error:function(e,a,t){alert("Error: "+t)}})}function consultarProyectosFinalizadosPorAnho_combinate(e){id=0;let a=$("#txtanho_GraficoProyecto4").val();1==e&&(id=$("#txtnodo_id").val()),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosFinalzadosPorAnho/"+id+"/"+a,success:function(e){graficosProyectosPromedioCantidadesMeses(e,graficosProyectoId.grafico4)},error:function(e,a,t){alert("Error: "+t)}})}function consultarProyectosInscritosConEmpresasPorAnho_combinate(e,a){id=0,1==e&&(id=$("#txtnodo_proyectoGrafico1")),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosInscritosConEmpresasPorAnho/"+id+"/"+a,success:function(e){graficosProyectosPromedioCantidadesMeses(e,graficosProyectoId.grafico2)},error:function(e,a,t){alert("Error: "+t)}})}function consultarProyectosInscritosPorAnho_combinate(e,a){id=0,1==e&&(id=$("#txtnodo_proyectoGrafico1")),$.ajax({dataType:"json",type:"get",url:"/grafico/consultarProyectosInscritosPorAnho/"+id+"/"+a,success:function(e){graficosProyectosPromedioCantidadesMeses(e,graficosProyectoId.grafico1)},error:function(e,a,t){alert("Error: "+t)}})}function consultarEdtsDelNodoPorAnho_variablepie(e){let a=$("#txtanho_GraficoEdt4").val(),t=0;1==e&&(t=$("#txtnodo_id").val()),""===t?Swal.fire("Advertencia!","Seleccione un nodo","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorNodoYAnho/"+t+"/"+a,success:function(e){Highcharts.chart(graficosEdtId.grafico4,{chart:{type:"variablepie"},title:{text:"Tipos de Edt's."},plotOptions:{variablepie:{allowPointSelect:!0,cursor:"pointer",dataLabels:{enabled:!0,format:"<b>{point.name}</b>: {point.y:.0f}",connectorColor:"silver"}}},tooltip:{headerFormat:"",pointFormat:'<span style="color:{point.color}">●</span> <b> {point.name}</b><br/>Cantidad: <b>{point.y}</b><br/>'},series:[{minPointSize:10,innerSize:"20%",zMin:0,name:"",data:[{name:"Tipo 1",y:e.consulta.tipo1,z:15},{name:"Tipo 2",y:e.consulta.tipo2,z:15},{name:"Tipo 3",y:e.consulta.tipo3,z:15}]}]})},error:function(e,a,t){alert("Error: "+t)}})}function consultarEdtsPorLineaYFecha_stacked(e){let a=0;1==e&&(a=$("#txtnodo_id").val());let t=$("#txtfecha_inicio_GraficoEdt3").val(),o=$("#txtfecha_fin_GraficoEdt3").val(),n=$("#txtlinea_id_edtGrafico3").val();""==n?Swal.fire("Advertencia!","Selecciona una Línea Tecnológica!","warning"):t>o?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorLineaYFecha/"+n+"/"+a+"/"+t+"/"+o,success:function(e){Highcharts.chart(graficosEdtId.grafico3,{chart:{type:"column"},title:{text:"Tipos de Edt's"},xAxis:{categories:["Tipo 1","Tipo 2","Tipo 3"],title:{text:"Tipos de Edt's"}},yAxis:{min:0,title:{text:"Número de Edt's"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:e.consulta.lineatecnologica,data:[e.consulta.tipo1,e.consulta.tipo2,e.consulta.tipo3]}]})},error:function(e,a,t){alert("Error: "+t)}})}function consultarEdtsPorGestorYFecha_stacked(e){let a=0;1==e&&(a=$("#txtnodo_id").val());let t=$("#txtfecha_inicio_edtGrafico2").val(),o=$("#txtfecha_fin_edtGrafico2").val(),n=$("#txtgestor_id_edtGrafico2").val();""==n?Swal.fire("Advertencia!","Selecciona un experto!","warning"):t>o?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorGestorYFecha/"+n+"/"+a+"/"+t+"/"+o,success:function(e){Highcharts.chart(graficosEdtId.grafico2,{chart:{type:"column"},title:{text:"Tipos de Edt's"},xAxis:{categories:["Tipo 1","Tipo 2","Tipo 3"],title:{text:"Tipos de Edt's"}},yAxis:{min:0,title:{text:"Número de Edt's"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:e.consulta.gestor,data:[e.consulta.tipo1,e.consulta.tipo2,e.consulta.tipo3]}]})},error:function(e,a,t){alert("Error: "+t)}})}function consultarEdtsPorNodoGestorYFecha_stacked(e){let a=$("#txtfecha_inicio_edtGrafico1").val(),t=$("#txtfecha_fin_edtGrafico1").val(),o=0;1==e&&(o=$("#txtnodo_id").val()),a>t?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarEdtsPorNodoGestorYFecha/"+o+"/"+a+"/"+t,success:function(e){for(var o=e.consulta.length,n={gestores:[],tipo1Array:[],tipo2Array:[],tipo3Array:[]},i=0;i<o;i++)null!=e.consulta[i].gestor&&n.gestores.push(e.consulta[i].gestor);for(i=0;i<o;i++)null!=e.consulta[i].tipos1&&n.tipo1Array.push(e.consulta[i].tipos1);for(i=0;i<o;i++)null!=e.consulta[i].tipos2&&n.tipo2Array.push(e.consulta[i].tipos2);for(i=0;i<o;i++)null!=e.consulta[i].tipos3&&n.tipo3Array.push(e.consulta[i].tipos3);var r=[];for(i=0;i<o;i++){let e='{"name": "'+n.gestores[i]+'", "data": ['+n.tipo1Array[i]+", "+n.tipo2Array[i]+", "+n.tipo3Array[i]+"]}";e=JSON.parse(e),r.push(e)}Highcharts.chart(graficosEdtId.grafico1,{chart:{type:"column"},title:{text:"Edt's entre "+a+" y "+t},xAxis:{categories:["Tipo 1","Tipo 2","Tipo 3"],title:{text:"Tipos de Edt's"}},yAxis:{min:0,title:{text:"Número de Edts's"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:r})},error:function(e,a,t){alert("Error: "+t)}})}function consultarTiposDeArticulacionesDelAnho_variablepie(e){let a=$("#txtanho_Grafico4").val(),t=0;1==e&&(t=$("#txtnodo_id").val()),""===t?Swal.fire("Advertencia!","Seleccione un nodo","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarArticulacionesPorNodoYAnho/"+t+"/"+a,success:function(e){Highcharts.chart(graficosId.grafico4,{chart:{type:"variablepie"},title:{text:"Tipos de Articulación."},plotOptions:{variablepie:{allowPointSelect:!0,cursor:"pointer",dataLabels:{enabled:!0,format:"<b>{point.name}</b>: {point.y:.0f}",connectorColor:"silver"}}},tooltip:{headerFormat:"",pointFormat:'<span style="color:{point.color}">●</span> <b> {point.name}</b><br/>Cantidad: <b>{point.y}</b><br/>'},series:[{minPointSize:10,innerSize:"20%",zMin:0,name:"",data:[{name:"Grupos de Investigación",y:e.consulta.grupos,z:15},{name:"Empresas",y:e.consulta.empresas,z:15},{name:"Emprendedores",y:e.consulta.emprendedores,z:15}]}]})},error:function(e,a,t){alert("Error: "+t)}})}function articulacionesGrafico1Ajax(e,a,t){$.ajax({dataType:"json",type:"get",url:"/grafico/consultarArticulacionesPorNodo/"+e+"/"+a+"/"+t,success:function(e){for(var o=e.consulta.length,n={gestores:[],gruposArray:[],empresasArray:[],emprendedoresArray:[]},i=0;i<o;i++)null!=e.consulta[i].gestor&&n.gestores.push(e.consulta[i].gestor);for(i=0;i<o;i++)null!=e.consulta[i].grupos&&n.gruposArray.push(e.consulta[i].grupos);for(i=0;i<o;i++)null!=e.consulta[i].empresas&&n.empresasArray.push(e.consulta[i].empresas);for(i=0;i<o;i++)null!=e.consulta[i].emprendedores&&n.emprendedoresArray.push(e.consulta[i].emprendedores);var r=[];for(i=0;i<o;i++){let e='{"name": "'+n.gestores[i]+'", "data": ['+n.gruposArray[i]+", "+n.empresasArray[i]+", "+n.emprendedoresArray[i]+"]}";e=JSON.parse(e),r.push(e)}Highcharts.chart(graficosId.grafico1,{chart:{type:"column"},title:{text:"Articulaciones entre "+a+" y "+t},xAxis:{categories:["Grupos de Investigación","Empresas","Emprendedores"],title:{text:"Tipos de Articulaciones"}},yAxis:{min:0,title:{text:"Número de Articulaciones"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:r})},error:function(e,a,t){alert("Error: "+t)}})}function consultaArticulacionesDelGestorPorNodoYFecha_stacked(e){articulacionesGrafico1Ajax(e,$("#txtfecha_inicio_Grafico1").val(),$("#txtfecha_fin_Grafico1").val())}function consultaArticulacionesDelGestorPorNodoYFecha_stackedAdministrador(){let e=$("#txtnodo_id").val();if(""==e)Swal.fire("Advertencia!","Seleccione un Nodo!","warning");else{articulacionesGrafico1Ajax(e,$("#txtfecha_inicio_Grafico1").val(),$("#txtfecha_fin_Grafico1").val())}}function consultarArticulacionesDeUnGestorPorFecha_stacked(){let e=$("#txtfecha_inicio_Grafico2").val(),a=$("#txtfecha_fin_Grafico2").val(),t=$("#txtgestor_id").val();""==t?Swal.fire("Advertencia!","Selecciona un experto!","warning"):e>a?Swal.fire("Advertencia!","Selecciona fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarArticulacionesPorGestorYFecha/"+t+"/"+e+"/"+a,success:function(e){Highcharts.chart(graficosId.grafico2,{chart:{type:"column"},title:{text:"Articulaciones"},xAxis:{categories:["Grupos de Investigación","Empresas","Emprendedores"],title:{text:"Tipos de Articulaciones"}},yAxis:{min:0,title:{text:"Número de Articulaciones"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:e.consulta.gestor,data:[e.consulta.grupos,e.consulta.empresas,e.consulta.emprendedores]}]})},error:function(e,a,t){alert("Error: "+t)}})}function consultarArticulacionesDeUnaLineaDelNodoPorFechas_stacked(e){let a="";a=0==e?0:$("#txtnodo_id").val();let t=$("#txtlinea_tecnologica").val();if(""==t)Swal.fire("Advertencia!","Selecciona una Línea Tecnológica!","warning");else{let e=$("#txtfecha_inicio_Grafico3").val(),o=$("#txtfecha_fin_Grafico3").val();e>o?Swal.fire("Advertencia!","Debes seleccionar fecha válidas!","warning"):$.ajax({dataType:"json",type:"get",url:"/grafico/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/"+a+"/"+t+"/"+e+"/"+o,error:function(e,a,t){alert("Error: "+t)},success:function(e){Highcharts.chart(graficosId.grafico3,{chart:{type:"column"},title:{text:"Articulaciones"},xAxis:{categories:["Grupos de Investigación","Empresas","Emprendedores"],title:{text:"Tipos de Articulaciones"}},yAxis:{min:0,title:{text:"Número de Articulaciones"}},legend:{reversed:!0},plotOptions:{series:{stacking:"normal"}},series:[{name:e.consulta.lineatecnologica,data:[e.consulta.grupos,e.consulta.empresas,e.consulta.emprendedores]}]})}})}}var graficosSeguimiento={gestor:"graficoSeguimientoEsperadoPorGestorDeUnNodo_column",nodo_esperado:"graficoSeguimientoDeUnNodo_column",tecnoparque_esperado:"graficoSeguimientoTecnoparque_column",nodo_fases:"graficoSeguimientoDeUnNodoFases_column",tecnoparque_fases:"graficoSeguimientoTecnoparqueFases_column",gestor_fases:"graficoSeguimientoPorGestorFases_column",linea_esperado:"graficoSeguimientoEsperadoPorLineaDeUnNodo_column",linea_actual:"graficoSeguimientoActualPorLineaDeUnNodo_column",inscritos_mes:"graficoSeguimientoInscritosPorMes_column"};function alertaLineaNoValido(){Swal.fire("Advertencia!","Seleccione una línea tecnológica","warning")}function alertaGestorNoValido(){Swal.fire("Advertencia!","Seleccione un experto","warning")}function alertaNodoNoValido(){Swal.fire("Advertencia!","Seleccione un nodo","warning")}function consultarSeguimientoDeUnGestor(e){$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoEsperadoDeUnGestor/"+e,success:function(e){graficoSeguimientoEsperado(e,graficosSeguimiento.gestor)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoEsperadoDeUnaLinea(e){let a=null,t=null;if(0==e){if(""==(t=$("#txtlinea_esperado").val()))return alertaLineaNoValido()}else{if(t=$("#txtlinea_esperado").val(),a=$("#txtnodo_linea_esperado").val(),""==t)return alertaLineaNoValido();if(""==a)return alertaNodoNoValido()}$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoEsperadoDeUnaLinea/"+t+"/"+a,success:function(e){graficoSeguimientoEsperado(e,graficosSeguimiento.linea_esperado)},error:function(e,a,t){alert("Error: "+t)}})}function consultarProyectosInscritosPorMes(e){null==e?alertaGestorNoValido():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoInscritosPorMesExperto/"+e,success:function(e){console.log(e.datos.meses),graficoSeguimientoPorMes(e,graficosSeguimiento.inscritos_mes)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoActualDeUnaLinea(e){let a=null,t=null;if(0==e){if(""==(t=$("#txtlinea_actual").val()))return alertaLineaNoValido()}else{if(t=$("#txtlinea_actual").val(),a=$("#txtnodo_linea_actual").val(),""==t)return alertaLineaNoValido();if(""==a)return alertaNodoNoValido()}$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoActualDeUnaLinea/"+t+"/"+a,success:function(e){graficoSeguimientoFases(e,graficosSeguimiento.linea_actual)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoActualDeUnGestor(e){$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoActualDeUnGestor/"+e,success:function(e){graficoSeguimientoFases(e,graficosSeguimiento.gestor_fases)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoEsperadoDeTecnoparque(){$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoEsperadoDeTecnoparque/",success:function(e){graficoSeguimientoEsperado(e,graficosSeguimiento.tecnoparque_esperado)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoEsperadoDeUnNodo(e){""===e?alertaNodoNoValido():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoEsperadoDeUnNodo/"+e,success:function(e){graficoSeguimientoEsperado(e,graficosSeguimiento.nodo_esperado)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoDeUnNodoFases(e){""===e?alertaNodoNoValido():$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoDeUnNodoFases/"+e,success:function(e){graficoSeguimientoFases(e,graficosSeguimiento.nodo_fases)},error:function(e,a,t){alert("Error: "+t)}})}function consultarSeguimientoDeTecnoparqueFases(){$.ajax({dataType:"json",type:"get",url:"/seguimiento/seguimientoDeTecnoparqueFases/",success:function(e){graficoSeguimientoFases(e,graficosSeguimiento.tecnoparque_fases)},error:function(e,a,t){alert("Error: "+t)}})}function graficoSeguimientoEsperado(e,a){Highcharts.chart(a,{chart:{type:"column"},title:{text:"Proyectos que se encuentran activos"},yAxis:{title:{text:"Cantidad"}},xAxis:{type:"category"},legend:{enabled:!1},tooltip:{headerFormat:'<span style="font-size:11px">Cantidad</span><br>',pointFormat:'<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'},series:[{colorByPoint:!0,dataLabels:{enabled:!0},data:[{name:"TRL 6 esperados",y:e.datos.Esperado6},{name:"TRL 7 - 8 esperados",y:e.datos.Esperado7_8},{name:"Total de proyectos activos",y:e.datos.Activos}]}]})}function graficoSeguimientoPorMes(e,a){Highcharts.chart(a,{title:{text:"Proyectos inscritos por mes en el año actual"},subtitle:{text:"Cuando el mes no aparece es porque el valor es cero(0)"},yAxis:{title:{text:"Cantidad de proyectos"}},xAxis:{categories:e.datos.meses,accessibility:{rangeDescription:"Mes"}},legend:{layout:"vertical",align:"right",verticalAlign:"middle"},series:[{name:"Proyectos inscritos",data:e.datos.cantidades}],responsive:{rules:[{condition:{maxWidth:500},chartOptions:{legend:{layout:"horizontal",align:"center",verticalAlign:"bottom"}}}]}})}function graficoSeguimientoFases(e,a){Highcharts.chart(a,{chart:{type:"column"},title:{text:"Proyectos actuales y finalizados en el año actual"},yAxis:{title:{text:"Cantidad"}},xAxis:{type:"category"},legend:{enabled:!1},tooltip:{headerFormat:'<span style="font-size:11px">Cantidad</span><br>',pointFormat:'<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'},series:[{colorByPoint:!0,dataLabels:{enabled:!0},data:[{name:"Proyectos en inicio",y:e.datos.Inicio},{name:"Proyectos en planeación",y:e.datos.Planeacion},{name:"Proyectos en ejecución",y:e.datos.Ejecucion},{name:"Proyectos en cierre",y:e.datos.Cierre},{name:"Proyectos finalizados",y:e.datos.Finalizado},{name:"Proyectos suspendidos",y:e.datos.Suspendido},{name:"Total de proyecto en el año actual",y:e.datos.Total}]}]})}var graficosCostos={actividad:"costosDeUnProyecto_column",proyectos:"costosDeProyectos_column",proyectos_ipe:"costosDeProyectos_ipe_column"};function setValueInput(e,a){$("#txtcosto_asesorias"+a).val(formatMoney(e.costosAsesorias)),$("label[for='txtcosto_asesorias"+a+"']").addClass("active",!0),$("#txtcostos_equipos"+a).val(formatMoney(e.costosEquipos)),$("label[for='txtcostos_equipos"+a+"']").addClass("active",!0),$("#txtcostos_materiales"+a).val(formatMoney(e.costosMateriales)),$("label[for='txtcostos_materiales"+a+"']").addClass("active",!0),$("#txtcostos_administrativos"+a).val(formatMoney(e.costosAdministrativos)),$("label[for='txtcostos_administrativos"+a+"']").addClass("active",!0),$("#txtcosto_total"+a).val(formatMoney(e.costosTotales)),$("label[for='txtcosto_total"+a+"']").addClass("active",!0),$("#txthoras_asesoria"+a).val(e.horasAsesorias),$("label[for='txthoras_asesoria"+a+"']").addClass("active",!0),$("#txthoras_uso"+a).val(e.horasEquipos),$("label[for='txthoras_uso"+a+"']").addClass("active",!0)}function consultarCostosDeProyectos(e,a){let t,o,n,i=0,r=[],s="";if(1==a?(s="_proyectos",t=$("input[name='estado']:checked").val(),o=$("#txtfecha_inicio_costosProyectos").val(),n=$("#txtfecha_fin_costosProyectos").val(),$("input[name='tipoProyecto[]']:checked").each(function(e,a){r.push($(this).val())})):(s="_proyectos_ipe",t=$("input[name='estado_ipe']:checked").val(),o=$("#txtfecha_inicio_costosProyectos_ipe").val(),n=$("#txtfecha_fin_costosProyectos_ipe").val(),$("input[name='tipoProyecto_ipe[]']:checked").each(function(e,a){r.push($(this).val())})),1==e&&(i=$("#txtnodo_id").val()),""===i)Swal.fire("Advertencia!","Seleccione un nodo","warning");else if(0==r.length)Swal.fire("Advertencia!","Seleccione por lo menos un tipo de proyecto","warning");else if(null==t)Swal.fire("Advertencia!","Seleccione un estado de proyecto","warning");else if(o>n)Swal.fire("Advertencia!","Seleccione fecha válidas","warning");else{let e=JSON.stringify(r);$.ajax({dataType:"json",type:"get",url:"/costos/costosDeProyectos/"+i+"/"+e+"/"+t+"/"+o+"/"+n+"/"+a,success:function(e){setValueInput(e,s),graficoCostos(e,1==a?graficosCostos.proyectos:graficosCostos.proyectos_ipe,"Proyectos")},error:function(e,a,t){alert("Error: "+t)}})}}function consultarCostoDeUnaActividad(){let e=$("#txtactividad_id").val();""===e?Swal.fire("Advertencia!","Seleccione una actividad","warning"):$.ajax({dataType:"json",type:"get",url:"/costos/proyecto/"+e,success:function(e){let a="_actividad";console.log(e),setValueInput(e,a),$("#txtgestor"+a).val(e.gestorActividad),$("label[for='txtgestor"+a+"']").addClass("active",!0),$("#txtlinea"+a).val(e.lineaActividad),$("label[for='txtlinea"+a+"']").addClass("active",!0),graficoCostos(e,graficosCostos.actividad,e.codigoActividad)},error:function(e,a,t){alert("Error: "+t)}})}function graficoCostos(e,a,t){Highcharts.chart(a,{exporting:{allowHTML:!0,chartOptions:{chart:{height:600,marginTop:110,events:{load:function(){this.renderer.image("http://drive.google.com/uc?export=view&id=1qLb9tjGI1hEnmEzQ6mPzxqv1zjMtxdMw",80,20,200,47).add(),this.renderer.image("http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C",290,20,200,47).add(),this.update({credits:{text:"Generado: "+Highcharts.dateFormat("%Y-%m-%d %H:%M:%S",Date.now())}})}}},legend:{y:-220},title:{align:"center",y:90}}},chart:{type:"column"},title:{text:"Costos - "+t},yAxis:{title:{text:"$ Pesos"},labels:{format:"$ {value}"}},xAxis:{type:"category"},legend:{enabled:!1,floating:!0},tooltip:{headerFormat:'<span style="font-size:11px">Costos</span><br>',pointFormat:'<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y}</b><br/>'},plotOptions:{series:{dataLabels:{enabled:!0},animationLimit:1e3}},series:[{colorByPoint:!0,data:[{name:"Costos de Asesorias",y:e.costosAsesorias},{name:"Costos de Equipos",y:e.costosEquipos},{name:"Costos de Materiales",y:e.costosMateriales},{name:"Costos Administrativos",y:e.costosAdministrativos},{name:"Total de Costos",y:e.costosTotales}]}]})}function consultarPublicacionesOtros(){$("#tblnovedades_Otros").dataTable().fnDestroy(),$("#tblnovedades_Otros").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/publicacion/datatablePublicaciones",type:"get"},columns:[{width:"15%",data:"fecha_inicio",name:"fecha_inicio"},{data:"titulo",name:"titulo"},{width:"8%",data:"detalle",name:"detalle",orderable:!1}]})}function consultarPublicacionesDesarrollador(){$("#tblnovedades_Desarrollador").dataTable().fnDestroy(),$("#tblnovedades_Desarrollador").DataTable({language:{url:"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"},processing:!0,serverSide:!0,order:[0,"desc"],ajax:{url:"/publicacion/datatablePublicaciones",type:"get"},columns:[{width:"15%",data:"codigo_publicacion",name:"codigo_publicacion"},{data:"fecha_inicio",name:"fecha_inicio"},{data:"titulo",name:"titulo"},{data:"role",name:"role"},{width:"8%",data:"detalle",name:"detalle",orderable:!1},{width:"8%",data:"edit",name:"edit",orderable:!1},{width:"8%",data:"update",name:"update",orderable:!1}]})}$(document).ready(function(){consultarPublicacionesOtros(),consultarPublicacionesDesarrollador()}),$("#txtcontenido").summernote({lang:"es-ES",height:300}),$("#txtfecha_inicio").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"}),$("#txtfecha_fin").bootstrapMaterialDatePicker({time:!1,date:!0,shortTime:!0,format:"YYYY-MM-DD",language:"es",weekStart:1,cancelText:"Cancelar",okText:"Guardar"});
>>>>>>> d2789af1ffab82b7e184e1aea201963a8d2ab53b
