
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
    
}

