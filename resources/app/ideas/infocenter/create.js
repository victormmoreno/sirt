$(document).ready(function() {
  $('#txtfecha_sesion2').bootstrapMaterialDatePicker({
    time:false,
    date:true,
    shortTime:true,
    format: 'YYYY-MM-DD',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
  });

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
  $("#formValidate").on('submit',function(event){
    event.preventDefault();
    entrenamiento.registrar();
  });
});

var cont = 0;

// Valida que el talento agregado a la articulación no exista
function noRepeat() {
  let idIdea = $("#txtidea").val();
  let retorno = true;
  let a = document.getElementsByName("idideas[]");
  for (x=0;x<a.length;x++){
    if (a[x].value == idIdea) {
      retorno = false;
      break;
    }
  }
  return retorno;
}

// Quita al talento de la lista de los talentos que harán parte de la articulación
function eliminar(index){
  $('#fila'+ index).remove();
}

// Método para agregar talentos a una articulación
function agregar() {
  if (noRepeat() == false) {
    swal("Error!", "La idea de proyecto ya está asociada al entrenamiento!", "warning");
  } else {
    let idIdea = $("#txtidea").val();
    $.ajax({
      url:uri+"idea/detalle_idea/" + idIdea,
      dataType:'json',
      type:'get',
      // data: idIdea,
    }).done(function(response){
      var a = document.getElementsByName("idideas[]");
      if (idIdea != 0) {
        let fila = '<tr class="selected" id="fila'+cont+'">'
        +'<td><input type="hidden" name="idideas[]" value="'+response.ididea+'">'+response.nombreproyecto+'</td>'
        +'<td>'+ response.nombrec + ' ' + response.apellidoc + '</td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="confirm_asist'+response.ididea+'" id="confirm_asist'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="canvas'+response.ididea+'" id="canvas'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="first_sesion'+response.ididea+'" id="first_sesion'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="second_sesion'+response.ididea+'" id="second_sesion'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><div class="switch m-b-md"><label>No<input type="checkbox" name="csbit'+response.ididea+'" id="csbit'+cont+'" value="1"><span class="lever"></span>Si</label></div></td>'
        +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+cont+');"><i class="material-icons">delete_sweep</i></a></td>'
        +'</tr>';
        cont++;
        $('#detalles').append(fila);
      } else {
        swal('Ups!!', 'Por favor seleccione por lo menos un talento', 'warning');
      }
    })
  }

}
