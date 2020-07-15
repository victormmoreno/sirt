$(document).ready(function() {

    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();
  
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_actions_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_actions_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        // $('#ideas_data_action_table').DataTable({
        //     language: {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //     },
        //     "lengthChange": false
        // }).clear().draw();
        // $('#ideas_data_table').DataTable({
        //     language: {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //     },
        //     "lengthChange": false
        // }).clear().draw();
    }
   

});

$('#filter_idea').click(function(){
    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();
    $('#ideas_data_action_table').dataTable().fnDestroy();
    
    $('#ideas_data_table').dataTable().fnDestroy();
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_actions_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_actions_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        // $('#ideas_data_action_table').DataTable({
        //     language: {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //     },
        //     "lengthChange": false
        // }).clear().draw();
        // $('#ideas_data_table').DataTable({
        //     language: {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //     },
        //     "lengthChange": false
        // }).clear().draw();
    }
});

$('#download_excel').click(function(){
        let filter_nodo = $('#filter_nodo').val();
        let filter_year = $('#filter_year').val();
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
            ajax:{
                url: "/idea",
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
                    data: 'edit',
                    name: 'edit',
                    orderable: false
                },
                {
                    data: 'soft_delete',
                    name: 'soft_delete',
                    orderable: false
                },
                {
                    data: 'dont_apply',
                    name: 'dont_apply',
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
            ajax:{
                url: "/idea",
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
    url:"/idea/detallesIdea/"+id
}).done(function(respuesta){

    $("#titulo").empty();
    $("#detalle_idea").empty();
    if (respuesta == null) {
    swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
    $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Proyecto: </span>"+respuesta.detalles.nombre_proyecto+"");
    $("#detalle_idea").append(
        '<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿Aprendiz SENA?: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.aprendiz_sena+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿En qué estado se encuentra la propuesta?: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.pregunta1String+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿Cómo está conformado el equipo de trabajo?: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.pregunta2String+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Descripcion: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.descripcion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Objetivo: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.objetivo+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Alcance: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.alcance+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">¿La idea viene de una convocatoria? </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+vieneConvocatoria(respuesta.detalles.viene_convocatoria)+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre de Convocatoria: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+nombreConvocatoria(respuesta.detalles.viene_convocatoria,respuesta.detalles.convocatoria)+'</span>'
        +'</div>'
        +'</div>'

    );
    $('#modal1').openModal();
    }
})
}

function vieneConvocatoria(value){
    if(value == 1){
        return "Si";
    }else{
        return "No";
    }
}

function nombreConvocatoria(value, convocatoria){
    if(value == 1){
        return convocatoria;
    }else{
        return "No Aplica";
    }
}