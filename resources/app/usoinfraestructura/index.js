$(document).ready(function() {
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo ,  filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_year = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

    // $('#mytalento_data_table').dataTable().fnDestroy();
    // if((filter_nodo != '' || filter_nodo != null) && (filter_role !='' || filter_role != null) && filter_state != '' && filter_year !=''){
    //     usoinfraestructuraIndex.fillDatatatablesTalentos(filter_nodo , filter_role, filter_state, filter_year);
    // }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_role == '' || filter_role == null || filter_role == undefined) && filter_state != '' && (filter_year == '' || filter_year == null || filter_year == undefined)){
    //     usoinfraestructuraIndex.fillDatatatablesTalentos(filter_nodo = null , filter_role = null, filter_state, filter_year = null);
    // }else{
    //     $('#mytalento_data_table').DataTable({
    //         language: {
    //             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    //         },
    //         "lengthChange": false
    //     }).clear().draw();
    // }
});

var usoinfraestructuraIndex = {
    fillDatatatablesUsosInfraestructura: function(filter_nodo , filter_year){
        var datatable = $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 2, "desc" ]],
            ajax:{
                url: "/usoinfraestructura",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_year: filter_year,
                }
            },
            columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                }, {
                    data: 'gestorEncargado',
                    name: 'gestorEncargado',
                },{
                    data: 'actividad',
                    name: 'actividad',
                    width: '50%',
                }, {
                    data: 'fase',
                    name: 'fase',
                    width: '15%',
                },  {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                    width: '15%',
                },  {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                    width: '15%',
                },  {
                    data: 'detail',
                    name: 'detail',
                    width: '15%',
                    orderable: false,
                }, 
            ],
        });
    },
        
    destroyUsoInfraestructura: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este uso de infraestructura?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, elminar uso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: "/usoinfraestructura/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(data.usoinfraestructura == 'success'){
                            Swal.fire(
                                'Eliminado!',
                                'Su uso de infraestructura ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.route;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Tu uso de infraestructura está a salvo',
                    'error'
                )
            }
        })
    }
}
