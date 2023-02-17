$(document).ready(function() {

    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();


    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null) && (filter_module != '' || filter_module != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo, filter_module,  filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined) && (filter_module == '' || filter_module == null || filter_module == undefined)  ){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_module = null, filter_year = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

});

var usoinfraestructuraIndex = {
    fillDatatatablesUsosInfraestructura: function(filter_nodo, filter_module, filter_year){
        var datatable = $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 0, "desc" ]],
            ajax:{
                url: host_url + "/usoinfraestructura",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_module: filter_module,
                    filter_year: filter_year
                }
            },
            columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                    width: '10%'
                }, {
                    data: 'gestorEncargado',
                    name: 'gestorEncargado',
                    width: '20%',
                    orderable: false
                },
                {
                    data: 'tipo_asesoria',
                    name: 'tipo_asesoria',
                    width: '10%'
                },
                {
                    data: 'actividad',
                    name: 'actividad',
                    width: '35%'
                }, {
                    data: 'fase',
                    name: 'fase',
                    width: '10%'
                },  {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                    width: '5%'
                },  {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                    width: '5%'
                },  {
                    data: 'detail',
                    name: 'detail',
                    width: '5%',
                    orderable: false
                },
            ],
        });
    },
    queryGestoresByNodo: function(){
        let nodo = $('#filter_nodo').val();

        if (nodo == null || nodo == '' || nodo == 'all' || nodo == undefined){
            $('#filter_gestor').empty();
            $('#filter_gestor').append('<option value="" selected>Seleccione un experto</option>');
        }else{
            $.ajax({
                type: 'GET',
                url: host_url + '/usuario/usuarios/gestores/nodo/'+ nodo,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {

                    $('#filter_gestor').empty();
                    $('#filter_gestor').append('<option value="all">todos</option>');
                    $.each(data.gestores, function(i, e) {
                        $('#filter_gestor').append('<option  value="'+i+'">'+e+'</option>');
                    })
                    $('#filter_gestor').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }
    },
    queryActivitiesByAnio: function(){

        let anio = $('#filter_year').val();

        if (anio == null || anio == '' || anio == undefined){

            $('#filter_actividad').empty();
            $('#filter_actividad').append('<option value="">Seleccione un año</option>');

        }else{
            $.ajax({
                type: 'GET',
                url: host_url + '/usoinfraestructura/actividades/'+ anio,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    $('#filter_actividad').empty();
                    $('#filter_actividad').append('<option value="all">Todas</option>');
                    $.each(data.actividades, function(i, e) {
                        $('#filter_actividad').append('<option  value="'+i+'">'+e+'</option>');
                    });
                    $('#filter_actividad').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }

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
                    url: host_url + "/usoinfraestructura/"+id,
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

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null) && (filter_module != '' || filter_module != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo, filter_module,  filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined) && (filter_module == '' || filter_module == null || filter_module == undefined)  ){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_module = null, filter_year = null);
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
    var query = {
        filter_nodo: filter_nodo,
        filter_year: filter_year,
        filter_module: filter_module,
    }
    var url = host_url + "/usoinfraestructura/export?" + $.param(query)
    window.location = url;
});
