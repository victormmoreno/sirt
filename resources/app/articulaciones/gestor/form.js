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