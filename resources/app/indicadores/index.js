function setValueInput_indicadores(data, name_input) {
  $('#'+name_input).val(data);
  $("label[for='"+name_input+"']").addClass("active", true);
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

function consultarProyectosEnEjecucionConSena_total(bandera) {
  let idnodo = 0;

  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    let url = '/indicadores/totalProyectosEnEjecucionSena/'+idnodo;
    ajaxIndicadores_totales(url, 'txt_total_ind5');
  }
}

function consultarProyectosInscritosEmpresas_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind8').val();
  let fecha_fin = $('#txtfecha_fin_ind8').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalInscritosEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind8');
    }
  }
}

function consultarProyectosInscritosAprendizInstructor_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind4').val();
  let fecha_fin = $('#txtfecha_fin_ind4').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalInscritosSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind4');
    }
  }
}

function consultarProyectosPFFFinalizadosAprendizInstructor_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind6').val();
  let fecha_fin = $('#txtfecha_fin_ind6').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPFFSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind6');
    }
  }
}

function consultarProyectosPMVFinalizadosAprendizInstructor_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind18').val();
  let fecha_fin = $('#txtfecha_fin_ind18').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPMVSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind18');
    }
  }
}

function consultarCostosPFFfinalizadosSena_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind7').val();
  let fecha_fin = $('#txtfecha_fin_ind7').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalCostoPFFFinalizadoSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind7');
    }
  }
}

function consultarCostosPMVfinalizadosSena_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind19').val();
  let fecha_fin = $('#txtfecha_fin_ind19').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalCostoPMVFinalizadoSena/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind19');
    }
  }
}

function consultarCostosPMVfinalizadosEmprendedoresOtros_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind23').val();
  let fecha_fin = $('#txtfecha_fin_ind23').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalCostoPMVFinalizadoEmprendedoresOtros/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind23');
    }
  }
}

function consultarCostosPFFfinalizadosEmprendedoresOtros_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind16').val();
  let fecha_fin = $('#txtfecha_fin_ind16').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalCostoPFFFinalizadoEmprendedoresOtros/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind16');
    }
  }
}

function consultarCostosPFFfinalizadosEmpresas_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind11').val();
  let fecha_fin = $('#txtfecha_fin_ind11').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalCostoPFFFinalizadoEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind11');
    }
  }
}

function consultarCostosPMVfinalizadosEmpresas_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind21').val();
  let fecha_fin = $('#txtfecha_fin_ind21').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalCostoPMVFinalizadoEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind21');
    }
  }
}

function consultarTalentoEnAsocioProyectosConEmpresa_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind12').val();
  let fecha_fin = $('#txtfecha_fin_ind12').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalTalentosConProyectosEnAsocioConEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind12');
    }
  }
}

function consultarProyectosInscritosEmprendedoresInvetoresOtros_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind13').val();
  let fecha_fin = $('#txtfecha_fin_ind13').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalProyectosInscritosEmprendedoresInvetoresOtro/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind13');
    }
  }
}

function consultarPFFFinalizadosEmprendedoresInvetoresOtros_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind15').val();
  let fecha_fin = $('#txtfecha_fin_ind15').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPFFFinalizadosEmprendedoresInvetoresOtro/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind15');
    }
  }
}

function consultarPMVFinalizadosEmprendedoresInvetoresOtros_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind22').val();
  let fecha_fin = $('#txtfecha_fin_ind22').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPMVFinalizadosEmprendedoresInvetoresOtro/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind22');
    }
  }
}

function consultarPFFfinalizados_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind3').val();
  let fecha_fin = $('#txtfecha_fin_ind3').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPFFfinalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind3');
    }
  }
}

function consultarPMVfinalizados_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind17').val();
  let fecha_fin = $('#txtfecha_fin_ind17').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPMVfinalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind17');
    }
  }
}

function consultarProyectosPFFFinalizadosEmpresas_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind10').val();
  let fecha_fin = $('#txtfecha_fin_ind10').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPFFfinalizadosConEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind10');
    }
  }
}

function consultarProyectosPMVFinalizadosEmpresas_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind20').val();
  let fecha_fin = $('#txtfecha_fin_ind20').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalPMVfinalizadosConEmpresas/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind20');
    }
  }
}

function consultarProyectosInscritos_total(bandera) {
  let idnodo = 0;
  let fecha_inicio = $('#txtfecha_inicio_ind1').val();
  let fecha_fin = $('#txtfecha_fin_ind1').val();
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
    } else {
      let url = '/indicadores/totalProyectosInscritos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
      ajaxIndicadores_totales(url, 'txt_total_ind1');
    }
  }
}

function consultarProyectosEnEjecucion_total(bandera) {
  let idnodo = 0;

  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    let url = '/indicadores/totalProyectosEnEjecucion/'+idnodo;
    ajaxIndicadores_totales(url, 'txt_total_ind2');
  }
}

function consultarProyectosEnEjecucionConEmprendedoresInventoresOtros_total(bandera) {
  let idnodo = 0;

  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    let url = '/indicadores/totalProyectosEnEjecucionEmprendedoresInventoresOtros/'+idnodo;
    ajaxIndicadores_totales(url, 'txt_total_ind14');
  }
}

function consultarProyectosEnEjecucionConEmpresas_total(bandera) {
  let idnodo = 0;

  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (idnodo === '') {
    Swal.fire('Error!', 'Seleccione un nodo', 'error');
  } else {
    let url = '/indicadores/totalProyectosEnEjecucionEmpresas/'+idnodo;
    ajaxIndicadores_totales(url, 'txt_total_ind9');
  }
}
