$(document).ready(function() {
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();

    $('#users_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_role !='' || filter_role != null) && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo , filter_role, filter_state, filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_role == '' || filter_role == null || filter_role == undefined) && filter_state != '' && (filter_year == '' || filter_year == null || filter_year == undefined)){
        UserIndex.fillDatatatablesUsers(filter_nodo = null , filter_role = null, filter_state, filter_year = null);
    }else{
        $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

const UserIndex = {
    fillDatatatablesUsers(filter_nodo ,filter_role, filter_state, filter_year){
        let datatable = $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            responsive: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: `${host_url}/usuarios`,
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_role: filter_role,
                    filter_state: filter_state,
                    filter_year: filter_year,
                }
            },
            columns: [
                {
                    data: 'nodo',
                    name: 'nodo',
                },
                {
                    data: 'tipodocumento',
                    name: 'tipodocumento',
                }, {
                    data: 'documento',
                    name: 'documento',
                }, {
                    data: 'nombrecompleto',
                    name: 'nombrecompleto',
                }, {
                    data: 'email',
                    name: 'email',
                }, {
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'rols',
                    name: 'rols'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
                    searchable: false,
                    orderable: false,
                },
            ],
        });
    }
}

$('#filter_user').click(function(){
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();
    $('#users_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo , filter_role, filter_state, filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo = null , filter_role, filter_state, filter_year);
    }else{
        $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_users').click(function(){
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();
    let query = {
        filter_nodo: filter_nodo,
        filter_role: filter_role,
        filter_state: filter_state,
        filter_year: filter_year,
    }
    let url = `${host_url}/usuarios/export?${$.param(query)}`
    window.location = url;
});




