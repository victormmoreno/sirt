

var usoinfraestructura = {
    
    queryActivitiesByGestor: function(){
        let gestor = $('#selectGestor').val();
        let anho = $('#selectYear').val();

        if (gestor == null || gestor == ''){
              
              $('#selectYear').empty();
              $('#selectActivity').empty();
          }
          else if(anho == null || anho == ''){
              $('#selectActivity').empty();
          }else{
            $.ajax({
                type: 'GET',
                url: '/usoinfraestructura/actividades/'+ gestor + '/' + anho,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    $('#selectActivity').empty();
                    $('#selectActivity').append('<option value="">Seleccione la Actividad</option>')
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
