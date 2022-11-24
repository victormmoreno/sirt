$(document).ready(function() {
    let filter_node_artuculation_subtype = $('#filter_node_artuculation_subtype').val();
    let filter_state_artuculation_subtype = $('#filter_state_artuculation_subtype').val();

    if((filter_node_artuculation_subtype == '' || filter_node_artuculation_subtype == null)  &&  (filter_state_artuculation_subtype == '' || filter_state_artuculation_subtype == null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype = null, filter_state_artuculation_subtype = null);
    }else if((filter_node_artuculation_subtype != '' || filter_node_artuculation_subtype != null)  && (filter_state_artuculation_subtype != '' || filter_state_artuculation_subtype != null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype,  filter_state_artuculation_subtype);
    }else{

        $('#articulation_subtype_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_articulation_subtype').click(function () {
    let filter_node_artuculation_subtype = $('#filter_node_artuculation_subtype').val();
    let filter_state_artuculation_subtype = $('#filter_state_artuculation_subtype').val();

    $('#articulation_subtype_data_table').dataTable().fnDestroy();
    if((filter_node_artuculation_subtype == '' || filter_node_artuculation_subtype == null)  &&  (filter_state_artuculation_subtype == '' || filter_state_artuculation_subtype == null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype = null, filter_state_artuculation_subtype = null);
    }else if((filter_node_artuculation_subtype != '' || filter_node_artuculation_subtype != null)  && (filter_state_artuculation_subtype != '' || filter_state_artuculation_subtype != null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype,  filter_state_artuculation_subtype);
    }else{

        $('#articulation_subtype_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

let articulationSubtype ={
    fillDatatatablesArticulationSubtype: function(filter_node_artuculation_subtype = null,filter_state_artuculation_subtype = null){
        $('#articulation_subtype_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/tiposubarticulaciones",
                type: "get",
                data: {
                    filter_node_artuculation_subtype: filter_node_artuculation_subtype,
                    filter_state_artuculation_subtype: filter_state_artuculation_subtype
                }
            },
            columns: [
                {
                    data: 'articulation_subtype_created_at',
                    name: 'articulation_subtype_created_at'
                },
                {
                    data: 'articulation_type_name',
                    name: 'articulation_type_name'
                },
                {
                    data: 'articulation_subtype_name',
                    name: 'articulation_subtype_name'
                },
                {
                    data: 'articulation_subtype_description',
                    name: 'articulation_subtype_description'
                },
                {
                    data: 'articulation_subtype_entity',
                    name: 'articulation_subtype_entity'
                },
                {
                    data: 'articulation_subtype_state',
                    name: 'articulation_subtype_state'
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    destroyArticulationSubtype: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este tipo de subarticulación?',
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
                        url: host_url + "/tiposubarticulaciones/"+id,
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
    },
}
