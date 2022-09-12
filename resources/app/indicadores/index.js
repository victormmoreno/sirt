function isset(variable) {
  if(typeof(variable) != "undefined" && variable !== null) {
    return true;
  }
  return false;
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
  if (!validarChecks("metas_down")) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
      document.frmDescargarMetas.submit();
  }
}

// function checkSelectMultipleOptions(source) {
//   if (source.value == 'all') {
//     // $('#txtnodo_id_inscritos > option').prop('selected', true);
//     // $('#txtnodo_id_inscritos').attr('selected', 'selected');
//     // source.options.length
//     // $("$#"+source.id+" > option").each(function() {
//       $('#txtnodo_id_inscritos > option').each(function(i, element) {
//         console.log(element);
//         // $('#txtnodo_id_inscritos').attr('selected', 'selected');
//         // $(this).prop('selected', true);
//         // $(this).attr('selected', true);
//     });
//   }
//   // options = document.getElementsByClassName(source);
//   // $('#txtnodo_id_inscritos').find("all").each(function() {
//   //   $('#txtnodo_id_inscritos').attr('selected', 'selected');
//   // });
//   // for(var i=0, n=options.length;i<n;i++) {
//   //   options[i].checked = source.checked;
//   // }
// }

function verificarChecks(source, padre) {
  clase = source.classList[0];
  checkboxes = document.getElementsByClassName(clase);
  padre = document.getElementById(padre);
  state = true;
  for(var i=0, n=checkboxes.length;i<n;i++) {
    if (checkboxes[i].checked == source.checked) {
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
  if (!validarChecks("ideas_download")) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
      document.frmDescargarIdeas.submit();
  }
}