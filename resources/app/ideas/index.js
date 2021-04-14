$(document).ready(function() {

    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year_ideas').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();

    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_actions_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
        idea.fill_datatatables_actions_ideas_articulador(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_actions_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
        idea.fill_datatatables_actions_ideas_articulador(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        $('#ideas_data_action_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
        $('#ideas_data_action_table_articulador').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
        $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }


});

$('#filter_idea').click(function () {
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year_ideas').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();
    $('#ideas_data_action_table').dataTable().fnDestroy();
    $('#ideas_data_action_table_articulador').dataTable().fnDestroy();
    $('#ideas_data_table').dataTable().fnDestroy();
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_actions_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
        idea.fill_datatatables_actions_ideas_articulador(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_actions_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
        idea.fill_datatatables_actions_ideas_articulador(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        $('#ideas_data_action_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
        $('#ideas_data_action_table_articulador').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
        $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_excel').click(function(){
        let filter_nodo = $('#filter_nodo').val();
        let filter_year = $('#filter_year_ideas').val();
        let filter_state = $('#filter_state').val();
        let filter_vieneConvocatoria = $('#filter_vieneconvocatoria').val();
        let filter_convocatoria = $('#filter_convocatoria').val();
        var query = {
            filter_nodo: filter_nodo,
            filter_year: filter_year,
            filter_state: filter_state,
            filter_vieneConvocatoria: filter_vieneConvocatoria,
            filter_convocatoria: filter_convocatoria,
        }

        var url = "/idea/export?" + $.param(query)

        window.location = url;
    });



var idea ={
    fill_datatatables_actions_ideas: function(filter_nodo = null,filter_year='', filter_state='',filter_vieneConvocatoria='', filter_convocatoria = null){
        var datatable = $('#ideas_data_action_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: "/idea/datatable_filtros",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_year: filter_year,
                    filter_state: filter_state,
                    filter_vieneConvocatoria: filter_vieneConvocatoria,
                    filter_convocatoria: filter_convocatoria,
                }
            },
            columns: [
                {
                    data: 'codigo_idea',
                    name: 'codigo_idea',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'persona',
                    name: 'persona',
                },
                {
                    data: 'correo_contacto',
                    name: 'correo_contacto',
                },
                {
                    data: 'telefono_contacto',
                    name: 'telefono_contacto',
                },
                {
                    data: 'nombre_proyecto',
                    name: 'nombre_proyecto',
                },
                {
                    data: 'estado',
                    name: 'estado',
                },
                {
                    data: 'details',
                    name: 'details',
                    orderable: false
                },
                {
                    data: 'info',
                    name: 'info',
                    orderable: false
                },

            ],
        });
    },
    fill_datatatables_actions_ideas_articulador: function(filter_nodo = null,filter_year='', filter_state='',filter_vieneConvocatoria='', filter_convocatoria = null){
        var datatable = $('#ideas_data_action_table_articulador').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: "/idea/datatable_filtros",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_year: filter_year,
                    filter_state: filter_state,
                    filter_vieneConvocatoria: filter_vieneConvocatoria,
                    filter_convocatoria: filter_convocatoria,
                }
            },
            columns: [
                {
                    data: 'codigo_idea',
                    name: 'codigo_idea',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'persona',
                    name: 'persona',
                },
                {
                    data: 'correo_contacto',
                    name: 'correo_contacto',
                },
                {
                    data: 'telefono_contacto',
                    name: 'telefono_contacto',
                },
                {
                    data: 'nombre_proyecto',
                    name: 'nombre_proyecto',
                },
                {
                    data: 'estado',
                    name: 'estado',
                },
                {
                    data: 'details',
                    name: 'details',
                    orderable: false
                },
                {
                    data: 'info',
                    name: 'info',
                    orderable: false
                },

            ],
        });
    },
    fill_datatatables_ideas: function(filter_nodo = null,filter_year='', filter_state='',filter_vieneConvocatoria='', filter_convocatoria = null){
        var datatable = $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: "/idea/datatable_filtros",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_year: filter_year,
                    filter_state: filter_state,
                    filter_vieneConvocatoria: filter_vieneConvocatoria,
                    filter_convocatoria: filter_convocatoria,
                }
            },
            columns: [
                {
                    data: 'codigo_idea',
                    name: 'codigo_idea',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'persona',
                    name: 'persona',
                },
                {
                    data: 'correo_contacto',
                    name: 'correo_contacto',
                },
                {
                    data: 'telefono_contacto',
                    name: 'telefono_contacto',
                },
                {
                    data: 'nombre_proyecto',
                    name: 'nombre_proyecto',
                },
                {
                    data: 'estado',
                    name: 'estado',
                },
                {
                    data: 'details',
                    name: 'details',
                    orderable: false
                },

            ],
        });
    },
    getSelectConvocatoria: function (){
        let convocatoria = $('#txtconvocatoria').val();
        $('#txtnombreconvocatoria').attr("disabled", "disabled");
        if(convocatoria == 1){
            $('#txtnombreconvocatoria').removeAttr("disabled").focus().val('');
        }else if(convocatoria == 0){
            $('#txtnombreconvocatoria').val('');
            $('#txtnombreconvocatoria').attr("disabled", "disabled");
        }else{
            $('#txtnombreconvocatoria').val('');
            $('#txtnombreconvocatoria').attr("disabled", "disabled");
        }
    },

    getSelectAvalEmpresa: function (){
        let avalaEmpresa = $('#txtavalempresa').val();
        $('#txtempresa').attr("disabled", "disabled");
        if(avalaEmpresa == 1){
            $('#txtempresa').removeAttr("disabled").focus().val('');
        }else if(avalaEmpresa == 0){
            $('#txtempresa').val('');
            $('#txtempresa').attr("disabled", "disabled");
        }else{
            $('#txtempresa').val('');
            $('#txtempresa').attr("disabled", "disabled");
        }
    },
    vieneConvocatoria: function(value){
        if(value == 1){
            return "Si";
        }else{
            return "No";
        }
    },
     nombreConvocatoria: function(value, convocatoria){
        if(value == 1){
            return convocatoria;
        }else{
            return "No Aplica";
        }
    },
    avalEmpresa: function(value){
        if(value == 1){
            return "Si";
        }else{
            return "No";
        }
    },
    nombreEmpresa: function(value, empresa){
        if(value == 1){
            return empresa;
        }else{
            return "No Aplica";
        }
    }
}


function cambiarEstadoIdeaDeProyecto(id, estado) {
Swal.fire({
    title: '¿Desea cambiar el estado de la idea de proyecto a '+estado+'?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí'
}).then((result) => {
    if (result.value) {
    $.ajax({
        dataType:'json',
        type:'get',
        url:'/idea/updateEstadoIdea/'+id+'/'+estado,
        success: function (data) {
        Swal.fire({
            title: 'El estado de la idea se ha cambiado exitosamente!',
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Sí'
        }).then((result) => {
            window.location.replace(data.route);
        })
        },
        error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
        }
    })
    }
})

}

function detallesIdeaPorId(id){
    $.ajax({
        dataType:'json',
        type:'get',
        url:"/idea/modalIdeas/"+id
    }).done(function(respuesta){
        $("#detalle_idea").empty();
        if (respuesta == null) {
        swal('Ups!!!', 'Ha ocurrido un error', 'warning');
        } else {
        $("#detalle_idea").append(respuesta.view);
        $('#modalInformacionIdea').openModal();
        }
    })
}
