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
        icon: 'warning',
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
      icon: data.type,
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
      icon: 'error',
      title: 'Estás ingresando mal los datos'
  })
  } else {
      if (noRepeatIdeasTaller(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          icon: 'warning',
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
      url: host_url + '/idea/detallesIdea/' + id
  }).done(function (ajax) {
      let fila = prepararFilaEnLaTablaDeIdeasTaller(ajax, confirmacion, asistencia);
      $('#tblIdeasEntrenamientoForm').append(fila);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        icon: 'success',
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
      '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarIdeaDelTaller(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' +
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
