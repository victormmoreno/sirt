$(document).ready(function() {
    let filter_nodo_type_art = $('#filter_nodo_type_art').val();
    let filter_state_type_art = $('#filter_state_type_art').val();

    if((filter_nodo_type_art == '' || filter_nodo_type_art == null)  &&  (filter_state_type_art == '' || filter_state_type_art == null)){
        typeArticulacion.fillDatatatablesTypeArt(filter_nodo_type_art = null, filter_state_type_art = null);
    }else if((filter_nodo_type_art != '' || filter_nodo_type_art != null)  && (filter_state_type_art != '' || filter_state_type_art != null)){
        typeArticulacion.fillDatatatablesTypeArt(filter_nodo_type_art,  filter_state_type_art);
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
    let filter_nodo_type_art = $('#filter_nodo_type_art').val();
    let filter_state_type_art = $('#filter_state_type_art').val();

    $('#type_art_data_table').dataTable().fnDestroy();
    if((filter_nodo_type_art == '' || filter_nodo_type_art == null)  &&  (filter_state_type_art == '' || filter_state_type_art == null)){
        typeArticulacion.fillDatatatablesTypeArt(filter_nodo_type_art = null, filter_state_type_art = null);
    }else if((filter_nodo_type_art != '' || filter_nodo_type_art != null)  && (filter_state_type_art != '' || filter_state_type_art != null)){
        typeArticulacion.fillDatatatablesTypeArt(filter_nodo_type_art,  filter_state_type_art);
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
    fillDatatatablesTypeArt: function(filter_nodo_type_art = null,filter_state_type_art = null){
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
                url: "/articulaciones/tipoarticulaciones",
                type: "get",

                data: {
                    filter_nodo_type_art: filter_nodo_type_art,
                    filter_state_type_art: filter_state_type_art,
                }
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                },
                {
                    data: 'descripcion',
                    name: 'descripcion',
                },
                {
                    data: 'entidad',
                    name: 'entidad',
                },
                {
                    data: 'estado',
                    name: 'estado',
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
