$(document).ready(function() {
    let filter_node_accompaniment = $('#filter_node_accompaniment').val();
    let filter_year_accompaniment = $('#filter_year_accompaniment').val();
    let filter_status_accompaniment = $('#filter_status_accompaniment').val();



    if((filter_node_accompaniment == '' || filter_node_accompaniment == null) && (filter_year_accompaniment =='' || filter_year_accompaniment == null) && (filter_status_accompaniment == '' || filter_status_accompaniment == null)){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment = null,filter_year_accompaniment = null, filter_status_accompaniment = null);
    }else if((filter_node_accompaniment != '' || filter_node_accompaniment != null) || filter_year_accompaniment !='' && filter_status_accompaniment != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment, filter_year_accompaniment, filter_status_accompaniment);
    }else{

        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_accompaniment').click(function () {
    let filter_node_accompaniment = $('#filter_node_accompaniment').val();
    let filter_year_accompaniment = $('#filter_year_accompaniment').val();
    let filter_status_accompaniment = $('#filter_status_accompaniment').val();

    $('#accompaniment_data_table').dataTable().fnDestroy();
    if((filter_node_accompaniment == '' || filter_node_accompaniment == null) && filter_year_accompaniment !='' && filter_status_accompaniment != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment = null,filter_year_accompaniment, filter_status_accompaniment);
    }else if((filter_node_accompaniment != '' || filter_node_accompaniment != null) && filter_year_accompaniment !='' && filter_status_accompaniment != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment, filter_year_accompaniment, filter_status_accompaniment);
    }else{
        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_accompaniment').click(function(){
    let filter_node_accompaniment = $('#filter_node_accompaniment').val();
    let filter_year_accompaniment = $('#filter_year_accompaniment').val();
    let filter_status_accompaniment = $('#filter_status_accompaniment').val();
    const query = {
        filter_node_accompaniment: filter_node_accompaniment,
        filter_year_accompaniment: filter_year_accompaniment,
        filter_status_accompaniment: filter_status_accompaniment
    }

    const url = "/acompanamientos/export?" + $.param(query)

    window.location = url;
});




let accompaniment ={
    filtersDatatableAccompanibles: function(filter_node_accompaniment,filter_year_accompaniment, filter_status_accompaniment){
        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 5, "desc" ]],
            ajax:{
                url: "/acompanamientos/datatable_filtros",
                type: "get",
                data: {
                    filter_node_accompaniment: filter_node_accompaniment,
                    filter_year_accompaniment: filter_year_accompaniment,
                    filter_status_accompaniment: filter_status_accompaniment,
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
                    data: 'accompanimentBy',
                    name: 'accompanimentBy',
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
