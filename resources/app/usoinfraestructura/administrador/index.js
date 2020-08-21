$

var UsoInfraestructuraAdministrador = {
    
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
}