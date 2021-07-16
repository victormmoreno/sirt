$(document).ready(function() {

    usoinfraestructuraIndex.queryActivitiesByAnio();


    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_gestor = $('#filter_gestor').val();
    let filter_actividad = $('#filter_actividad').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null)  && (filter_gestor != '' || filter_gestor != null) && (filter_actividad != '' || filter_actividad != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo ,  filter_year, filter_gestor, filter_actividad);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined)  && (filter_gestor == '' || filter_gestor == null || filter_gestor == undefined) && (filter_actividad == '' || filter_actividad == null || filter_actividad == undefined)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_year = null, filter_gestor = null, filter_actividad = null);
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
    fillDatatatablesUsosInfraestructura: function(filter_nodo , filter_year, filter_gestor, filter_actividad){
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
                    filter_gestor: filter_gestor,
                    filter_actividad: filter_actividad,
                }
            },
            columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                    width: '10%',
                }, {
                    data: 'gestorEncargado',
                    name: 'gestorEncargado',
                    width: '20%',
                },{
                    data: 'actividad',
                    name: 'actividad',
                    width: '45%',
                }, {
                    data: 'fase',
                    name: 'fase',
                    width: '10%',
                },  {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                    width: '5%',
                },  {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                    width: '5%',
                },  {
                    data: 'detail',
                    name: 'detail',
                    width: '5%',
                    orderable: false,
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
                url: '/usuario/usuarios/gestores/nodo/'+ nodo,
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
                url: '/usoinfraestructura/actividades/'+ anio,
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

$('#filter_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_gestor = $('#filter_gestor').val();
    let filter_actividad = $('#filter_actividad').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null)  && (filter_gestor != '' || filter_gestor != null) && (filter_actividad != '' || filter_actividad != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo ,  filter_year, filter_gestor, filter_actividad);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined)  && (filter_gestor == '' || filter_gestor == null || filter_gestor == undefined) && (filter_actividad == '' || filter_actividad == null || filter_actividad == undefined)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_year = null, filter_gestor = null, filter_actividad = null);
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
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_gestor = $('#filter_gestor').val();
    let filter_actividad = $('#filter_actividad').val();
    var query = {
        filter_nodo: filter_nodo,
        filter_year: filter_year,
        filter_gestor: filter_gestor,
        filter_actividad: filter_actividad,
    }
    var url = "/usoinfraestructura/export?" + $.param(query)
    window.location = url;
});
