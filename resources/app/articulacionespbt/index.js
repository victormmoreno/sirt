$(document).ready(function() {
    let filter_nodo_art = $('#filter_nodo_art').val();
    let filter_year_art = $('#filter_year_art').val();
    let filter_phase = $('#filter_phase').val();
    let filter_tipo_articulacion = $('#filter_tipo_articulacion').val();
    let filter_alcance_articulacion = $('#filter_alcance_articulacion').val();

    if((filter_nodo_art == '' || filter_nodo_art == null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion == '' || filter_alcance_articulacion == null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art = null,filter_year_art  = null, filter_phase  = null, filter_tipo_articulacion  = null, filter_alcance_articulacion = null);
    }else if((filter_nodo_art != '' || filter_nodo_art != null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion != '' || filter_alcance_articulacion != null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art, filter_year_art, filter_phase, filter_tipo_articulacion, filter_alcance_articulacion);
    }else{
        
        $('#articulaciones_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_articulacion').click(function () {
    let filter_nodo_art = $('#filter_nodo_art').val();
    let filter_year_art = $('#filter_year_art').val();
    let filter_phase = $('#filter_phase').val();
    let filter_tipo_articulacion = $('#filter_tipo_articulacion').val();
    let filter_alcance_articulacion = $('#filter_alcance_articulacion').val();
   
    $('#articulaciones_data_table').dataTable().fnDestroy();
    if((filter_nodo_art == '' || filter_nodo_art == null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion == '' || filter_alcance_articulacion == null)){        
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art = null,filter_year_art, filter_phase, filter_tipo_articulacion, filter_alcance_articulacion = null);
    }else if((filter_nodo_art != '' || filter_nodo_art != null) && filter_year_art !='' && filter_phase != '' && filter_tipo_articulacion != '' && (filter_alcance_articulacion != '' || filter_alcance_articulacion != null)){
        articulacion_pbt.fill_datatatables_articulacion(filter_nodo_art, filter_year_art, filter_phase, filter_tipo_articulacion, filter_alcance_articulacion);
    }else{
        $('#articulaciones_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var articulacion_pbt ={
    fill_datatatables_articulacion: function(filter_nodo_art = null,filter_year_art=null, filter_phase=null,filter_tipo_articulacion=null, filter_alcance_articulacion = null){
        $('#articulaciones_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 5, "desc" ]],
            ajax:{
                url: "/articulaciones/datatable_filtros",
                type: "get",
                
                data: {
                    filter_nodo_art: filter_nodo_art,
                    filter_year_art: filter_year_art,
                    filter_phase: filter_phase,
                    filter_tipo_articulacion: filter_tipo_articulacion,
                    filter_alcance_articulacion: filter_alcance_articulacion,
                }
            },
            columns: [
                {
                    data: 'nodo',
                    name: 'nodo',
                },
                {
                    data: 'codigo_articulacion',
                    name: 'codigo_articulacion',
                },
                {
                    data: 'nombre_articulacion',
                    name: 'nombre_articulacion',
                },
                {
                    data: 'articulador',
                    name: 'articulador',
                },
                {
                    data: 'fase',
                    name: 'fase',
                },
                {
                    data: 'starDate',
                    name: 'starDate',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },

}

$('#download_archive_art').click(function(){
    let filter_nodo_art = $('#filter_nodo_art').val();
    let filter_year_art = $('#filter_year_art').val();
    let filter_phase = $('#filter_phase').val();
    let filter_tipo_articulacion = $('#filter_tipo_articulacion').val();
    let filter_alcance_articulacion = $('#filter_alcance_articulacion').val();
    var query = {
        filter_nodo: filter_nodo_art,
        filter_year: filter_year_art,
        filter_phase: filter_phase,
        filter_tipo_articulacion: filter_tipo_articulacion,
        filter_alcance_articulacion: filter_alcance_articulacion,
    }

    var url = "/articulaciones/export?" + $.param(query)

    window.location = url;
});