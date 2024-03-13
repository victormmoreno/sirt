$(document).ready(function() {
    let filter_year_support = $('#filter_year_support').val();
    let filter_state_support = $('#filter_state_support').val();
    let filter_request_support = $('#filter_request_support').val();

    if((filter_year_support == '' || filter_year_support == null) && (filter_state_support == '' || filter_state_support == null) && (filter_request_support == '' || filter_request_support == null)){
        support.fill_datatatables_actions_support(filter_year_support = null, filter_state_support= null, filter_request_support = null);
    }else if( (filter_year_support !='' || filter_year_support != null) && (filter_state_support != '' || filter_state_support != null) && (filter_request_support != '' || filter_request_support != null)){
        support.fill_datatatables_actions_support( filter_year_support, filter_state_support, filter_request_support);
    }else{
        $('#support_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_support').click(function () {
    let filter_year_support = $('#filter_year_support').val();
    let filter_state_support = $('#filter_state_support').val();
    let filter_request_support = $('#filter_request_support').val();
    $('#support_data_table').dataTable().fnDestroy();
    if((filter_year_support =='' || filter_year_support == null) && (filter_state_support == '' || filter_state_support == null) && (filter_request_support == '' || filter_request_support == null)){
        support.fill_datatatables_actions_support(filter_year_support = null, filter_state_support= null, filter_request_support = null);
        // idea.fill_datatatables_ideas(filter_year_support, filter_state_support, filter_request_support);
    }else if( (filter_year_support !='' || filter_year_support != null) && (filter_state_support != '' || filter_state_support != null) && (filter_request_support != '' || filter_request_support != null)){
        support.fill_datatatables_actions_support( filter_year_support, filter_state_support, filter_request_support);
        // idea.fill_datatatables_ideas( filter_year_support, filter_state_support, filter_request_support);
    }else{
        // $('#ideas_data_action_table').DataTable({
        //     language: {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //     },
        //     pageLength: 20,
        //     "lengthChange": false
        // }).clear().draw();
        $('#support_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

let support ={
    fill_datatatables_actions_support: function(filter_year_support = null,filter_state_support=null, filter_request_support=null){
        let datatable = $('#support_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/support",
                type: "get",
                data: {
                    filter_year_support: filter_year_support,
                    filter_state_support: filter_state_support,
                    filter_request_support: filter_request_support,
                }
            },
            columns: [
                {
                    data: 'ticket',
                    name: 'ticket',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'subject',
                    name: 'subject',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    destroySupport: function(ticket){
        Swal.fire({
            title: '¿Estas seguro de eliminar este caso?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminar caso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/support/"+ticket,
                    type: 'DELETE',
                    data: {
                        "id": ticket,
                        "_token": token,
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Eliminado!',
                                'El caso ha sido eliminado satisfactoriamente.',
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
                    'El caso está a salvo',
                    'error'
                )
            }
        })
    },
    updateSupport: function(ticket, status){
        Swal.fire({
            title: '¿Estas seguro de cambiar a '+ status + ' este caso?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, cambiar caso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/support/"+ticket,
                    type: 'PUT',
                    data: {
                        "id": ticket,
                        "_token": token,
                        "status": status
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Actualizado!',
                                'El caso ha sido eliminado satisfactoriamente.',
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
                    'El caso está a salvo',
                    'error'
                )
            }
        })
    }
}
