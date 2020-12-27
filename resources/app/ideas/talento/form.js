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
    // Ocultar contenedores
    divProductoParecido.hide();
    divReemplaza.hide();
    divPacking.hide();
    divRequisitosLegales.hide();
    divCertificaciones.hide();
    divRecursos.hide();
    divConvocatoria.hide();
    divAvalEmpresa.hide();
});

// Enviar formulario para registrar la idea de proyecto
$(document).on('submit', 'form#frmIdea_Inicio', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormIdea(form, data, url, 'create');
});

function ajaxSendFormIdea(form, data, url, fase) {
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
        text: text,
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
    if (data.state == 'registro') {
        title = "Registro Exitoso";
        text = "La idea de proyecto ha sido registrada satisfactoriamente";
        type = "success";
        pintarMensajeIdeaForm(title, text, type);
        setTimeout(function () {
            window.location.replace("/idea");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        title = "Registro Erróneo";
        text = "La idea de proyecto no se ha registrado, por favor inténtalo de nuevo";
        type = "warning";
        pintarMensajeIdeaForm(title, text, type);
    }
    if (data.state == 'update') {
        title = "Modificación Exitosa";
        text = "La idea de proyecto ha sido modificada satisfactoriamente";
        type = "success";
        pintarMensajeIdeaForm(title, text, type);
        setTimeout(function () {
            window.location.replace("/idea");
        }, 1000);
    }
    if (data.state == 'no_update') {
        title = "Modificación Errónea";
        text = "La idea de proyecto no ha sido modificada, por favor intentalo de nuevo";
        type = "warning";
        pintarMensajeIdeaForm(title, text, type);
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