function detallesIdeasDelEntrenamiento(id){
  $.ajax({
     dataType:'json',
     type:'get',
     url: host_url + "/taller/"+id,
     data: {
       identrenamiento: id,
     }
  }).done(function(respuesta){
    $("#ideasEntrenamiento").empty();
    if (respuesta != null ) {
      $("#fechasEntrenamiento").empty();
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha del taller de fortalecimiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
      $.each(respuesta, function(i, item) {
        $("#ideasEntrenamiento").append("<tr><td>"+item.codigo_idea+" - "+item.nombre_proyecto+
          "</td><td>"+item.confirmacion+"</td><td>"+item.asistencia1+"</td></tr>");
      });
      $('#modalIdeasEntrenamiento').openModal();
    }
  });
}

function consultarEntrenamientosPorNodo(nodo) {
  $('#entrenamientosPorNodo_table').dataTable().fnDestroy();
  $('#entrenamientosPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: host_url + "/taller/consultarEntrenamientosPorNodo/" + nodo,
      type: "get",
      data: {
        filter_nodo: $('#filter_nodo').val(),
      }
    },
    columns: [
      {
        title: 'Código del taller',
        data: 'codigo_entrenamiento',
        name: 'codigo_entrenamiento',
      },
      {
        data: 'fecha_sesion1',
        name: 'fecha_sesion1',
      },
      {
        width: '8%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '8%',
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },
    ],
  });
}
