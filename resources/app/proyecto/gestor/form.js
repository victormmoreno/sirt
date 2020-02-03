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
function prepararFilaEnLaTablaDeTalentos(ajax) {
  // El ajax.talento.id es el id del TALENTO, no del usuario
  let idTalento = ajax.talento.id;
  let fila = '<tr class="selected" id=talentoAsociadoAProyecto' + idTalento + '>' +
    '<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton' + idTalento + '" value="' + idTalento + '" onclick="edadTalentoLider(' + idTalento + ')" /><label for ="radioButton' + idTalento + '"></label></td>' +
    '<td><input type="hidden" name="talentos[]" value="' + idTalento + '">' + ajax.talento.documento + ' - ' + ajax.talento.talento + '</td>' +
    '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio(' + idTalento + ');"><i class="material-icons">delete_sweep</i></a></td>' +
    '</tr>';
  return fila;
}

// Pinta el talento en la tabla de los talentos que participarán en el proyecto
function pintarTalentoEnTabla_Fase_Inicio(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/usuario/talento/consultarTalentoPorId/' + id,
  }).done(function (ajax) {

    let fila = prepararFilaEnLaTablaDeTalentos(ajax);
    $('#detalleTalentosDeUnProyecto_Create').append(fila);
    talentoSeAsocioAlProyecto();
  });
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat(id) {
  let idTalento = id;
  let retorno = true;
  let a = document.getElementsByName("talentos[]");
  for (x = 0; x < a.length; x++) {
    if (a[x].value == idTalento) {
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

// Método para agregar talentos a un proyecto
function addTalentoProyecto(id) {
  if (noRepeat(id) == false) {
    talentoYaSeEncuentraAsociado();
  } else {
    pintarTalentoEnTabla_Fase_Inicio(id);
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
    order: [0, 'desc'],
    ajax: {
      url: "/proyecto/datatableIdeasConEmprendedores",
      type: "get",
    },
    select: true,
    columns: [{
      data: 'codigo_idea',
      name: 'codigo_idea',
    },
    {
      data: 'nombre_proyecto',
      name: 'nombre_proyecto',
    },
    {
      data: 'nombres_contacto',
      name: 'nombres_contacto',
    },
    {
      width: '20%',
      data: 'checkbox',
      name: 'checkbox',
      orderable: false,
    },
    ],
  });
  $('#ideasDeProyectoConEmprendedores_modal').openModal({
    dismissible: false,
  });
}

// Datatable que muestra los talentos que se encuentran registrados en Tecnoparque
function consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table() {
  $('#talentosDeTecnoparque_Proyecto_FaseInicio_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax: {
      url: "/usuario/talento/getTalentosDeTecnoparque/",
      type: "get",
    },
    columns: [{
      data: 'documento',
      name: 'documento',
    },
    {
      data: 'talento',
      name: 'talento',
    },
    {
      data: 'add_proyecto',
      name: 'add_proyecto',
      orderable: false,
    },
    ],
  });
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