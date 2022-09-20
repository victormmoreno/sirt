$(document).ready(function() {
    let filter_state_type_art = $('#filter_state_type_art').val();
    if(filter_state_type_art == '' || filter_state_type_art == null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art = null);
    }else if(filter_state_type_art != '' || filter_state_type_art != null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art);
    }else{
        $('#type_art_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

});

$('#filter_type_art').click(function () {
    let filter_state_type_art = $('#filter_state_type_art').val();
    $('#type_art_data_table').dataTable().fnDestroy();
    if(filter_state_type_art == '' || filter_state_type_art == null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art = null);
    }else if(filter_state_type_art != '' || filter_state_type_art != null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art);
    }else{
        $('#type_art_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

let typeArticulacion ={
    fillDatatatablesTypeArt: function(filter_state_type_art = null){
        $('#type_art_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/tipoarticulaciones",
                type: "get",

                data: {
                    filter_state_type_art: filter_state_type_art,
                }
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'description',
                    name: 'descripcion',
                },
                {
                    data: 'state',
                    name: 'state',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    destroyTypeArticulation: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este tipo de articulación?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminar',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/tipoarticulaciones/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Eliminado!',
                                'El tipo de articulación ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }else{
                            Swal.fire(
                                'No se puede eliminar!',
                                'El tipo de articulación tiene asociadas tipos de subarticulaciones.',
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
                    'El tipo de articulación está a salvo',
                    'error'
                )
            }
        })
    }
}
