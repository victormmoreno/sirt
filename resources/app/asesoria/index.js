$(document).ready(function() {

    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null) && (filter_module != '' || filter_module != null) && (start_date != '' || start_date != null) && (end_date != '' || end_date != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo, filter_module,  filter_year, start_date, end_date);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined) && (filter_module == '' || filter_module == null || filter_module == undefined)  ){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_module = null, filter_year = null, start_date = null, end_date = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});



const usoinfraestructuraIndex = {
    fillDatatatablesUsosInfraestructura: function(filter_nodo, filter_module, filter_year, start_date, end_date){
        let datatable = $('#usoinfraestructa_data_table').DataTable({
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
                    start_date: start_date,
                    end_date: end_date
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
    destroyUsoInfraestructura: function(id){
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

$('#filter_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();


    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null) && (filter_module != '' || filter_module != null) && (start_date != '' || start_date != null) && (end_date != '' || end_date != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo, filter_module,  filter_year, start_date, end_date);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined) && (filter_module == '' || filter_module == null || filter_module == undefined)  ){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_module = null, filter_year = null, start_date = null, end_date = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();
    let query = {
        filter_module: filter_module,
        filter_nodo: filter_nodo
    }
    let url = `${host_url}/asesorias/exportar?` + $.param(query)
    window.location = url;
});
