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
