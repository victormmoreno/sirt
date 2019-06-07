function detallesIdeasDelEntrenamiento(id){
  $.ajax({
     dataType:'json',
     type:'get',
     url:"entrenamientos/"+id,
     data: {
       identrenamiento: id,
     }
  }).done(function(respuesta){
    $("#ideasEntrenamiento").empty();
    if (respuesta != null ) {
      $("#fechasEntrenamiento").empty();
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Primera Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Segunda Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion2+"");
      $.each(respuesta, function(i, item) {
        $("#ideasEntrenamiento").append("<tr><td>"+item.nombre_proyecto+
          "</td><td>"+item.confirmacion+"</td><td>"+item.convocado+"</td><td>"+item.canvas+"</td><td>"+item.asistencia1+"</td><td>"+item.asistencia2+"</td></tr>");
      });
      $('#modalIdeasEntrenamiento').openModal();
    }
  });
}
