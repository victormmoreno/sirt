$(document).ready(function() {

    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year_ideas').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();

    consultarIdeasDelTalento();
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
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
    // console.log(filter_nodo);
    let filter_year = $('#filter_year_ideas').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();
    $('#ideas_data_table').dataTable().fnDestroy();
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        $('#ideas_data_action_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
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

        var url = host_url + "/idea/export?" + $.param(query)

        window.location = url;
    });



var idea ={
    fill_datatatables_ideas: function(filter_nodo = null,filter_year='', filter_state='',filter_vieneConvocatoria='', filter_convocatoria = null){
        var datatable = $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            pageLength: 20,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/idea/datatable_filtros",
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
                    data: 'nodo',
                    name: 'nodo',
                },
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
                    data: 'info',
                    name: 'info',
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
        url: host_url + '/idea/updateEstadoIdea/'+id+'/'+estado,
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
        url: host_url + "/idea/modalIdeas/"+id
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

function consultarIdeasDelTalento() {
    // $('#ideas_talento').dataTable().fnDestroy();
    $('#ideas_talento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
      processing: true,
      serverSide: true,
      pageLength: 20,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: host_url + "/idea/datatable_filtros",
        type: "get",
        data: {
            filter_nodo: null,
            filter_year: null,
            filter_state: null,
            filter_vieneConvocatoria: null,
            filter_convocatoria: null,
        }
      },
      columns: [
        {
          width: '15%',
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        {
          width: '8%',
          data: 'nodo',
          name: 'nodo',
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
          width: '8%',
          data: 'info',
          name: 'info',
          orderable: false
        },
        {
          width: '8%',
          data: 'postular',
          name: 'postular',
          orderable: false
        },
        {
          width: '8%',
          data: 'edit',
          name: 'edit',
          orderable: false
        },
      ],
    });
}

function confirmacionPostulacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de postular esta idea de proyecto?',
  text: "Una vez que se postule la idea de proyecto, ya no se podrá cambiar los datos de esta.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmPostularIdea.submit();
    }
  })
}

function confirmacionInhabilitar(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de inhabilitar esta idea de proyecto?',
  text: "Esto quiere decir que esta idea de proyecto no se le podrá realizar un proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmInhabilitarIdea.submit();
    }
  })
}
