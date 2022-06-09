$(document).ready(function() {
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year_activo').val();

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

    $('#mytalento_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_role !='' || filter_role != null) && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_nodo , filter_role, filter_state, filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_role == '' || filter_role == null || filter_role == undefined) && filter_state != '' && (filter_year == '' || filter_year == null || filter_year == undefined)){
        UserIndex.fillDatatatablesTalentos(filter_nodo = null , filter_role = null, filter_state, filter_year = null);
    }else{
        $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var UserIndex = {
    showInputs(){
        let filter_role = $('#filter_rol').val();
        if(filter_role == 'Talento'){
            $("#divyear").show();
            $('#filter_year>option[value="all"]').attr('selected', 'selected');
        }else{
            $("#divyear").hide();
            $('#filter_year>option[value="all"]').attr('selected', 'selected');
        }
        
    },
    fillDatatatablesUsers(filter_nodo ,filter_role, filter_state, filter_year){
        var datatable = $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/usuario",
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
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                }, 
            ],
        });
    },
    fillDatatatablesTalentos(filter_nodo ,filter_role, filter_state, filter_year){
        var datatable = $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/usuario/mistalentos",
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
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
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
        //idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
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

$('#filter_talentos').click(function(){

    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();


    $('#mytalento_data_table').dataTable().fnDestroy();


    if((filter_nodo != '' || filter_nodo != null) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_nodo , filter_role, filter_state, filter_year);
        
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_nodo = null , filter_role, filter_state, filter_year);
    }else{
        $('#mytalento_data_table').DataTable({
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
    var query = {
        filter_nodo: filter_nodo,
        filter_role: filter_role,
        filter_state: filter_state,
        filter_year: filter_year,
    }

    var url = host_url + "/usuario/export?" + $.param(query)
    window.location = url;
});




