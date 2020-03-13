$(document).ready(function() {
    $('#usoinfraestructura_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });
});

var UsoInfraestructuraAdministrador = {
    selectUsoInfraestructuraPorNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#usoinfraestructura_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            $('#usoinfraestructura_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usoinfraestructura/usoinfraestructurapornodo/" + nodo,
                    type: "get",
                },
                columns: [{
                    data: 'fecha',
                    name: 'fecha',
                },  {
                    data: 'actividad',
                    name: 'actividad',
                }, {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                }, {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                },{
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                }, ],
            });
        }else{
            $('#usoinfraestructura_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },
    queryGestoresByNodo: function(){
        let nodo = $('#selectnodo').val();

        if (nodo == null || nodo == ''){
              $('#selectGestor').empty();
              $('#selectGestor').append('<option value="" selected>Seleccione un Gestor</option>');
        }else{
            $.ajax({
                type: 'GET',
                url: '/usuario/usuarios/gestores/nodo/'+ nodo,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    
                    $('#selectGestor').empty();
                    $('#selectGestor').append('<option value="">Seleccione un Gestor</option>')
                    $.each(data.gestores, function(i, e) {
                        $('#selectGestor').append('<option  value="'+i+'">'+e+'</option>');
                    })
          
                    $('#selectGestor').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }
    },

    queryActivitiesByGestor: function(){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        let nodo = $('#selectnodo').val();
        

        if (nodo == null || nodo == ''){
            
            $('#selectGestor').empty();
            $('#selectGestor').append('<option value="">Seleccione un Gestor</option>');
            $('#selectYear').empty();
            $('#selectYear').append('<option value="">Seleccione un año</option>');
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else if (gestor == null || gestor == ''){
            
            $('#selectYear').empty();
            $('#selectYear').append('<option value="">Seleccione un año</option>');
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else if(anho == null || anho == ''){
            
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }
        else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ gestor + '/' + anho,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                  
                  $('#selectActivity').empty();
                  $('#selectActivity').append('<option value="">Seleccione la Actividad</option>');
                  $.each(data.actividades, function(i, e) {
                    $('#selectActivity').append('<option  value="'+i+'">'+e+'</option>');
                  });
            
                  $('#selectActivity').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }

    },
    ListActividadesPorGestor: function (){
        let nodo = $('#selectnodo').val();
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        let actividad = $('#selectActivity').val();
    
        if(nodo == '' || nodo == null){
            Swal.fire(
              'Error',
              'Por favor selecciona un nodo',
              'error'
            );
            $('#selectGestor').empty();
            $('#selectGestor').append('<option value="">Seleccione un Gestor</option>');
            
        }
        else if(gestor == '' || gestor == null){
            Swal.fire(
            'Error',
            'Por favor selecciona un gestor',
            'error'
            );
            $('#selectYear').empty();
            $('#selectYear').append('<option value="">Seleccione un año</option>');
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
        }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un año',
          'error'
        );
        
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>');
      }else if(actividad == '' || actividad == null){
        Swal.fire(
            'Error',
            'Por favor selecciona una actividad',
            'error'
            
        );
            $('#selectActivity').empty();
            $('#selectActivity').append('<option value="">Seleccione una Actividad</option>')
      }
      else{
        $('#usoinfraestructura_administrador_table').dataTable().fnDestroy();
        $('#usoinfraestructura_administrador_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usoinfraestructura/actividades/datatable/"+gestor+"/"+anho+"/"+ actividad,
            
          },
          columns: [{
            data: 'fecha',
            name: 'fecha',
        },  {
            data: 'actividad',
            name: 'actividad',
        }, {
            data: 'fase',
            name: 'fase',
        },
        {
            data: 'asesoria_directa',
            name: 'asesoria_directa',
        }, {
            data: 'asesoria_indirecta',
            name: 'asesoria_indirecta',
        },{
            data: 'detail',
            name: 'detail',
            orderable: false,
        },],  
        });
      }
    },
}