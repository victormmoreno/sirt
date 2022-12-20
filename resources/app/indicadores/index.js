function isset(variable) {
  if(typeof(variable) != "undefined" && variable !== null) {
    return true;
  }
  return false;
}

function sendListNodos(url) {
  let nodosSend = [];
  let nodosID = $('.nodos_list_select:checked').map(function(){
    return $(this).val();
  });
  if (nodosID.length == 0) {
    alertaNodoNoValido();
  } else {
    for (let i = 0; i < nodosID.length; i++) {
      nodosSend.push(nodosID[i]);
    }
    return $.ajax({
      dataType: 'json',
      type: 'get',
      data: {
        nodos: nodosSend
      },
      url: url,
      // success: function (data) { },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    });
  }
};

function consultarSeguimientoDeUnNodoFases(url) {
  let ajax = sendListNodos(url);
  ajax.success(function (data) {
    graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
  });
};

function consultarSeguimientoEsperadoDeUnNodo(url) {
  let ajax = sendListNodos(url);
  ajax.success(function (data) {
    graficoSeguimientoEsperado(data, graficosSeguimiento.nodo_esperado);
  });
}

function generarExcelConTodosLosIndicadores() {
  let idnodo = $('#txtnodo_id').val();
  let hoja = $('#txthoja_nombre').val();
  let fecha_inicio = $('#txtfecha_inicio_todos').val();
  let fecha_fin = $('#txtfecha_fin_todos').val();

  if (!isset(idnodo)) {
    idnodo = 0;
  }
  if (!isset(hoja)) {
    hoja = 'all';
  }

  if (fecha_inicio > fecha_fin) {
    Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
  } else {
    location.href = '/excel/export/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+hoja;
  }
}

function generarExcelConTodosLosIndicadoresActuales() {
  let idnodo = $('#txtnodo_id_actuales').val();
  let hoja = $('#txthoja_nombre_actuales').val();
  if (!isset(idnodo)) {
    idnodo = 0;
  }
  if (!isset(hoja)) {
    hoja = 'all';
  }

  location.href = '/excel/export_proyectos_actuales/'+idnodo+'/'+hoja;
}

function generarExcelConTodosLosIndicadoresFinalizados() {
  let idnodo = $('#txtnodo_id_finalizados').val();
  let hoja = $('#txthoja_nombre_finalizados').val();
  let fecha_inicio = $('#txtfecha_inicio_cerrados').val();
  let fecha_fin = $('#txtfecha_fin_cerrados').val();

  if (!isset(idnodo)) {
  idnodo = 0;
  }
  if (!isset(hoja)) {
  hoja = 'all';
  }

  if (fecha_inicio > fecha_fin) {
    Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
  } else {
    location.href = '/excel/export_proyectos_finalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+hoja;
  }
}

function generarExcelConTodosLosIndicadoresInscritos() {
  let idnodo = $('#txtnodo_id_inscritos').val();
  let hoja = $('#txthoja_nombre_inscritos').val();
  let fecha_inicio = $('#txtfecha_inicio_inscritos').val();
  let fecha_fin = $('#txtfecha_fin_inscritos').val();
  if (!isset(idnodo)) {
    idnodo = 0;
  }
  if (!isset(hoja)) {
    hoja = 'all';
  }

  if (fecha_inicio > fecha_fin) {
    Swal.fire('Error!', 'Seleccione un rango de fechas válido', 'error');
  } else {
    location.href = '/excel/export_proyectos_inscritos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+hoja;
  }

}

function selectAll(source, elementaName) {
  checkboxes = document.getElementsByClassName(elementaName);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function downloadMetas(e) {
  e.preventDefault();
  input = $("#txtnodo_metas_id").val();
  if (!validarSelect(input)) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
      // location.href = route + '/' + input;
      document.frmDescargarMetas.submit();
  }
}

function validarSelect(input) {
  // input = $(input).val();
  if (input == null) {
    return false;
  }
  return true;
}

function verificarChecks(source, padre) {
  clase = source.classList[0];
  checkboxes = document.getElementsByClassName(clase);
  padre = document.getElementById(padre);
  state = false;
  for(var i=0, n= checkboxes.length; i< n;i++) {
    if (checkboxes[i].checked) {
      state = true;
      break;
    }
  }
  for(var i=0, n= checkboxes.length; i< n;i++) {
    if (!checkboxes[i].checked) {
      state = false;
      break;
    }
  }
  padre.checked = state;
}

function validarChecks(elementaName) {
  checkboxes = document.getElementsByClassName(elementaName);
  for(var i=0, n=checkboxes.length;i<n;i++) {
      if (checkboxes[i].checked == false) {
        return false;
      }
    }
    return true;
}

function downloadIdeasIndicadores(e) {
  e.preventDefault();
  input = $("#txtnodo_ideas_download").val();
  if (!validarSelect(input)) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
      document.frmDescargarIdeas.submit();
  }
}