$(document).ready(function() {
    let filter_node = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_status = $('#filter_status').val();


    if((filter_node == '' || filter_node == null) && filter_year !='' && filter_status != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node = null,filter_year  = null, filter_status  = null);
    }else if((filter_node != '' || filter_node != null) && filter_year !='' && filter_status != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node, filter_year, filter_status);
    }else{

        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_articulacion').click(function () {
    let filter_node = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_status = $('#filter_status').val();

    $('#accompaniment_data_table').dataTable().fnDestroy();
    if((filter_node == '' || filter_node == null) && filter_year !='' && filter_status != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node = null,filter_year, filter_status);
    }else if((filter_node != '' || filter_node != null) && filter_year !='' && filter_status != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node, filter_year, filter_status);
    }else{
        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var accompaniment ={
    filtersDatatableAccompanibles: function(filter_node = null,filter_year=null, filter_status=null){
        $('#accompaniment_data_table').DataTable({
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
                    filter_node: filter_node,
                    filter_year: filter_year,
                    filter_status: filter_status,
                }
            },
            columns: [
                {
                    data: 'node',
                    name: 'node',
                },
                {
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'count_articulations',
                    name: 'count_articulations',
                },
                {
                    data: 'status',
                    name: 'status',
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
