$(document).ready(function() {
    // $('.input-field label').addClass('active');

    let filter_nodo = $('#filter_node').val();
    let filter_module = $('#filter_module').val();
    let filter_start_date = $('#filter_start_date').val();
    let filter_end_date = $('#filter_end_date').val();

    $('#asesorie_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_module != '' || filter_module != null) && (filter_start_date != '' || filter_start_date != null) && (filter_end_date != '' || filter_end_date != null)){
        asesorieIndex.fillDatatatablesAsesorie(filter_nodo, filter_module, filter_start_date, filter_end_date);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_module == '' || filter_module == null || filter_module == undefined) && (filter_start_date == '' || filter_start_date == null || filter_start_date == undefined) && (filter_end_date == '' || filter_end_date == null || filter_end_date == undefined)){
        asesorieIndex.fillDatatatablesAsesorie(filter_nodo = null , filter_module = null, start_date = null, end_date = null);
    }else{
        $('#asesorie_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});



const asesorieIndex = {
    fillDatatatablesAsesorie: function(filter_nodo, filter_module, filter_start_date, filter_end_date){
        $('#asesorie_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 2, "desc" ]],
            ajax:{
                url: `${host_url}/asesorias/datatable_filtros`,
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_module: filter_module,
                    filter_start_date: filter_start_date,
                    filter_end_date: filter_end_date
                }
            },
            columnDefs: [ {
                targets: 1,
                type: "date"
            } ],

            columns: [
                {
                    data: 'nodo',
                    type: 'nodo'
                },
                {
                    data: 'codigo',
                    type: 'codigo'
                },
                {
                    data: 'fecha',
                    type: 'date'
                },
                {
                    data: 'asesores',
                    name: 'asesores',
                    width: '20%',
                    orderable: false
                },
                {
                    data: 'tipo_asesoria',
                    name: 'tipo_asesoria',
                    width: '10%'
                },
                {
                    data: 'asesorable',
                    name: 'asesorable',
                    width: '35%'
                }, {
                    data: 'fase',
                    name: 'fase',
                    width: '10%'
                },  {
                    data: 'detail',
                    name: 'detail',
                    width: '5%',
                    orderable: false
                },
            ],
        });
    },
    destroyAsesorie: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este uso de infraestructura?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminar uso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: `${host_url}/asesorias/${id}`,
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

$('#filter_asesories').click(function(){
    let filter_nodo = $('#filter_node').val();
    let filter_module = $('#filter_module').val();
    let filter_start_date = $('#filter_start_date').val();
    let filter_end_date = $('#filter_end_date').val();


    $('#asesorie_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_module != '' || filter_module != null) && (filter_start_date != '' || filter_start_date != null) && (filter_end_date != '' || filter_end_date != null)){
        asesorieIndex.fillDatatatablesAsesorie(filter_nodo, filter_module, filter_start_date, filter_end_date);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_module == '' || filter_module == null || filter_module == undefined) && (filter_start_date == '' || filter_start_date == null || filter_start_date == undefined) && (filter_end_date == '' || filter_end_date == null || filter_end_date == undefined)){
        asesorieIndex.fillDatatatablesAsesorie(filter_nodo = null , filter_module = null, start_date = null, end_date = null);
    }else{
        $('#asesorie_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_asesories').click(function(){
    let filter_nodo = $('#filter_node').val();
    let filter_module = $('#filter_module').val();
    let filter_start_date = $('#filter_start_date').val();
    let filter_end_date = $('#filter_end_date').val();
    let query = {
        filter_nodo: filter_nodo,
        filter_module: filter_module,
        filter_start_date: filter_start_date,
        filter_end_date: filter_end_date
    }
    let url = `${host_url}/asesorias/exportar?` + $.param(query)
    window.location = url;
});
