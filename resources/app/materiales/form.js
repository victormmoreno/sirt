function consultarLineasNodo(nodo_id) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/lineas/getlineasnodo/"+nodo_id
      }).done(function(response){
          $("#txtlineatecnologica").empty();
          $('#txtlineatecnologica').append('<option value="">Seleccione la línea tecnológica donde se registrará el material de formación</option>');
          $.each(response.lineasForNodo.lineas, function(i, e) {
            $('#txtlineatecnologica').append('<option  value="'+e.id+'">'+e.abreviatura+' - '+e.nombre+'</option>');
          })
          $('#txtlineatecnologica').material_select();
    });
}
function getSelectMaterialMedida(){
    let medida = $('#txtmedida option:selected').text();
    let id_medida = $('#txtmedida').val();
    $("#txtcantidad").prop('disabled', true);
    $("label[for='txtcantidad']").empty();
     if(id_medida != ''){
        $("#txtcantidad").prop('disabled', false);
        $("#txtcantidad").val('');
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete en '+medida);
    }
    else{

        $("#txtcantidad").prop('disabled', true);
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete');
    }
}

var materialFormacion = {
    destroyMaterial: function(id){

        Swal.fire({
            title: '¿Estas seguro de eliminar este material de formación?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, elminar material',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {

                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/materiales/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(data.status == 200){
                            Swal.fire(
                                'Eliminado!',
                                'El material de formación ha sido eliminado satisfactoriamente.',
                                'success'
                              );
                            location.href = data.route;

                        }else if(data.status == 226){
                            Swal.fire(
                                'No se puede elimnar!',
                                data.message,
                                'error'
                              );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                  'Cancelado',
                  'Tu material de formación está a salvo',
                  'error'
                )
            }
        })
    }
}