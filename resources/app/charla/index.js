function consultarDetallesDeUnaCharlaInformativa(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: '/charla/consultarDetallesDeUnaCharlaInformativa/'+id,
    success: function (data) {
      $("#modalDetalleDeUnaCharlaInformativa_titulo").empty();
      $("#modalDetalleDeUnaCharlaInformativa_detalle_charla").empty();
      $("#modalDetalleDeUnaCharlaInformativa_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Charla Informativa </span><br>");
      $("#modalDetalleDeUnaCharlaInformativa_detalle_charla").append("<div class='row'>"
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.codigo_charla+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.fecha+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Encargado de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.encargado+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Número de Asistentens: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.nro_asistentes+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Observaciones: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.observacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<h5 class="center">Evidencias</h5>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Programación de la Charla (Pantallazo del Envío de Correos): </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.programacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Evidencias Fotográficas: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.evidencia_fotografica+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Listado de Asistencia: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.listado_asistentes+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
    );
    $('#detalleDeUnaCharlaInformativa_modal').openModal();
  },
  error: function (xhr, textStatus, errorThrown) {
    alert("Error: " + errorThrown);
  }
})
}
