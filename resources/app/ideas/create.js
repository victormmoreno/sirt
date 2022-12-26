divRegistrarEmpresa = $('#divRegistrarEmpresa');
divIngresarEmpresaIdea = $('#divIngresarEmpresaIdea');
divEmpresaRegistrada = $('#divEmpresaRegistrada');
divIngresarEmpresaIdea.hide();
divRegistrarEmpresa.hide();
divEmpresaRegistrada.hide();



function banderaEmpresaIdea() {
  if ($('#bandera_empresa').is(':checked')) {
    divIngresarEmpresaIdea.show();
  } else {
    divIngresarEmpresaIdea.hide();
    divRegistrarEmpresa.hide();
    divEmpresaRegistrada.hide();
  }
}

// Enviar formulario para registrar proyecto
$(document).on('submit', 'form#frmIdeas_Inicio', function (event) {
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
          if (fase == 'create') {
              mensajesIdeaCreate(data);
          } else {
              mensajesIdeaUpdate(data);
          }
      },
      error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
      }
  });
};

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