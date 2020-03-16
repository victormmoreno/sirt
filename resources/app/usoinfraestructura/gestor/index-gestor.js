
var UsoInfraestructuraGestor = {
    queryActivitiesByGestor: function(gestor){
        
        let anho = $('#selectYear').val();
       
        

        if(anho == null || anho == ''){
            
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
    ListActividadesPorGestor: function (gestor){
        console.log(gestor);
        let anho = $('#selectYear').val();
        let actividad = $('#selectActivity').val();
    
        if(anho == '' || anho == null){
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
        $('#usoinfraestructura_table').dataTable().fnDestroy();
        $('#usoinfraestructura_table').DataTable({
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

