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

divRegistrarEmpresa = $('#divRegistrarEmpresa');
divIngresarEmpresaIdea = $('#divIngresarEmpresaIdea');
divEmpresaRegistrada = $('#divEmpresaRegistrada');
divIngresarEmpresaIdea.hide();
divRegistrarEmpresa.hide();
divEmpresaRegistrada.hide();

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
            url : host_url + '/empresa/ajaxDetallesDeUnaEmpresa/'+nit+'/'+field,
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
  $('#txt_sede_id').val('');
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
    url : host_url + '/empresa/ajaxDetalleDeUnaSede/'+sede_id,
    success: function (response) {
      $('#txt_sede_id').val(response.sede.id);
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
    if ($('#check_producto_parecido').is(':checked')) {
        divProductoParecido.show();
    } else {
        divProductoParecido.hide();
    }
}

function showInput_Reemplaza() {
    if ($('#check_reemplaza').is(':checked')) {
        divReemplaza.show();
    } else {
        divReemplaza.hide();
    }
}

function showInput_Packing() {
    if ($('#check_packing').is(':checked')) {
        divPacking.show();
    } else {
        divPacking.hide();
    }
}

function showInput_RequisitosLegales() {
    if ($('#check_requisitos_legales').is(':checked')) {
        divRequisitosLegales.show();
    } else {
        divRequisitosLegales.hide();
    }
}

function showInput_BuscarEmpresa() {
    if ($('#check_idea_empresa').is(':checked')) {
        divBuscarEmpresa.show();
    } else {
        divBuscarEmpresa.hide();
    }
}

function showInput_Certificaciones() {
    if ($('#check_requiere_certificaciones').is(':checked')) {
        divCertificaciones.show();
    } else {
        divCertificaciones.hide();
    }
}

function showInput_Recursos() {
    if ($('#check_recursos_necesarios').is(':checked')) {
        divRecursos.show();
    } else {
        divRecursos.hide();
    }
}

function showInput_Convocatoria() {
    if ($('#check_viene_convocatoria').is(':checked')) {
        divConvocatoria.show();
    } else {
        divConvocatoria.hide();
    }
}

function showInput_AvalEmpresa() {
    if ($('#check_aval_empresa').is(':checked')) {
        divAvalEmpresa.show();
    } else {
        divAvalEmpresa.hide();
    }
}

function banderaEmpresaIdea() {
  if ($('#bandera_empresa').is(':checked')) {
    divIngresarEmpresaIdea.show();
  } else {
    divIngresarEmpresaIdea.hide();
    divRegistrarEmpresa.hide();
    divEmpresaRegistrada.hide();
  }
}

function mensajesIdeaCreate(data) {
  if (data.state == 'registro') {
      Swal.fire({
          title: 'Registro Exitoso',
          text: "La idea de proyecto ha sido registrada satisfactoriamente",
          type: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      });
      setTimeout(function () {
          window.location.replace("/idea");
      }, 1000);
  }
  if (data.state == 'no_registro') {
      Swal.fire({
          title: 'La idea de proyecto no se ha registrado, por favor inténtalo de nuevo',
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      })
  }
};

function mensajesIdeaUpdate(data) {
  if (data.state == 'update') {
      Swal.fire({
          title: 'Modificación Exitosa',
          text: "La idea de proyecto ha sido modificada satisfactoriamente",
          type: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      });
      setTimeout(function () {
          window.location.replace("/idea");
      }, 1000);
  }
  if (data.state == 'no_update') {
      Swal.fire({
          title: 'La idea de proyecto no se ha modificado, por favor inténtalo de nuevo',
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      })
  }
};