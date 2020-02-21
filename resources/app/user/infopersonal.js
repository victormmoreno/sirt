
var user = {
    getCiudadExpedicion:function(){
        let id;
        id = $('#txtdepartamentoexpedicion').val();
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/getciudad/'+id
        }).done(function(response){
          $('#txtciudadexpedicion').empty();
        //   $('#txtciudadexpedicion').append('<option value="">Seleccione la Ciudad</option>')
          $.each(response.ciudades, function(i, e) {
            $('#txtciudadexpedicion').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
          });
          $('#txtciudadexpedicion').material_select();
        });
      },

      getOtraEsp:function (ideps) {
        let id = $(ideps).val();
        let nombre = $("#txteps option:selected").text();
      
        if (id == 42) {
            // $('.otraeps').css("display:block");
            $('.otraeps').removeAttr("style");
             
        }else{
            $('.otraeps').attr("style","display:none");
        }
    },
    getCiudad:function(){
        let id;
        id = $('#txtdepartamento').val();
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/getciudad/'+id
        }).done(function(response){
          $('#txtciudad').empty();
          $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
          $.each(response.ciudades, function(i, e) {
            $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
          })
          
          $('#txtciudad').material_select();
        });
    },
    getGradoEscolaridad(gradoescolaridad){
        let grado = $(gradoescolaridad).val();
       
      
        if (grado == 1) {
        
            $('.gradodiscapacidad').removeAttr("style");
             
        }else{
            $('.gradodiscapacidad').attr("style","display:none");
        }
    }
}

