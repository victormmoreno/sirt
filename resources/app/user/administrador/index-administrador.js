$(document).ready(function() {
    
    $('#administrador_table').DataTable({
        language: {
           
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "/usuario/administrador",
            type: "get",
        },
        columns: [
        	{
        		data: 'tipodocumento',
        		name: 'tipodocumento',
        	},
        	{
        		data: 'documento',
        		name: 'documento',
        	},
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
            {
                data: 'email',
                name: 'email',
            },
        	{
        		data: 'telefono',
        		name: 'telefono',
        	},
            {
                data: 'estado',
                name: 'estado',
            },
            {
                data: 'detail',
                name: 'detail',
                orderable: false,
            },
            {
                data: 'edit',
                name: 'edit',
                orderable: false,
            },

        ],
    });
});

function detalleAdministrador(id){
  $.ajax({
    dataType:'json',
    type:'get',
    url:"/usuario/administrador/"+id
  }).done(function(respuesta){
    $("#titulo_administrador").empty();
    $("#detalle_administrador").empty();

    console.log(respuesta);
    if (respuesta == null) {
      swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
      $("#titulo_administrador").append("<span class='cyan-text text-darken-3'>Usuario </span>"+respuesta.user.nombre);
            $("#detalle_administrador").append('<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Nombre Completo: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.nombre+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Tipo Documento: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.tipodocumento+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Documento</span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.documento+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Descripcion: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.user.rol+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
          );
      $('#modal1').openModal();
    }
    })
}


 var UserAdministrador = {
        getCiudad:function(e){
            let id = $(e).val();
           
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/usuario/getciudad/'+id
            }).done(function(response){
                $('#txtciudad').empty();
                $('#txtciudad').append('<option value="">Seleccione Ciudad</option>')
                $.each(response.ciudades, function(i, e) {
                    console.log(e.id);
                    $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                })
                $('#txtciudad').material_select();
            });
        },
 }