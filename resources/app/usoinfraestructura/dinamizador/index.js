
$(document).ready(function() {

  $('#usoinfraestructura_dinamizador_table').DataTable({
      language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
  });
  
});

var usoinfraestructura = {
    ListActividadesPorGestor: function (){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        let actividad = $('#selectActivity').val();

      if(gestor == '' || gestor == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un gestor',
          'error'
        );
      }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un año',
          'error'
        );
      }else if(actividad == '' || actividad == null){
        Swal.fire(
            'Error',
            'Por favor selecciona una actividad',
            'error'
        );
      }
      else{
        $('#usoinfraestructura_dinamizador_table').dataTable().fnDestroy();
        $('#usoinfraestructura_dinamizador_table').DataTable({
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
    queryActivitiesByGestor: function(){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();
        // console.log('gestor: ', gestor);
        // console.log('anho: ', anho);

        if (gestor == null || gestor == ''){
            // $('#selectYear').select2('val','null');
        }else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ gestor + '/' + anho,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                  console.log('data: ', data);
                  $('#selectActivity').empty();
                  $('#selectActivity').append('<option value="">Seleccione la Ciudad</option>')
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

    }


}
