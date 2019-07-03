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
    console.log(respuesta.data);
    if (respuesta == null) {
      swal('Ups!!!', 'Ha ocurrido un error', 'warning');
    } else {
        let genero = respuesta.data.user.genero == 1 ? 'Masculino' : 'Femenino';
        let otra_eps = respuesta.data.user.otra_eps != null ? respuesta.data.user.otra_eps : 'No registra';
        let telefono = respuesta.data.user.telefono != null ? respuesta.data.user.telefono : 'No registra';
        let celular = respuesta.data.user.celular != null ? respuesta.data.user.celular : 'No registra';
      // $("#titulo_administrador").append("<span class='cyan-text text-darken-3'>Usuario </span>"+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos)
      //       $("#detalle_administrador").append('<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Nombre Completo: </span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //       +'<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Tipo Documento: </span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.tipodocumento+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //       +'<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Documento</span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.user.documento+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //       +'<div class="row">'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="cyan-text text-darken-3">Descripcion: </span>'
      //       +'</div>'
      //       +'<div class="col s12 m6 l6">'
      //       +'<span class="black-text">'+respuesta.data.role+'</span>'
      //       +'</div>'
      //       +'</div>'
      //       +'<div class="divider"></div>'
      //     );
      //     
      
      $("#titulo_administrador").append(`<div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                        
                                    <div class="col s12 m12 l12">
                                        
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    
                                                    <div class="left">
                                                        <span class="mailbox-title ">
                                                            `+respuesta.data.user.nombres+" "+respuesta.data.user.apellidos+`
                                                        </span>

                                                        <span class="mailbox-author black-text text-darken-2">
                                                            
                                                            `+respuesta.data.role+`<br>
                                                            Miembro desde `+moment(respuesta.data.user.created_at).format('LL')+` <br>
                                                        </span>
                                                    </div>
                                                </div>
                                                

                                                <div class="right mailbox-buttons">
                                                    
                                                </div>
                                            </div>
                                            <div class="right">
                                                <small>`+ genero+`</small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    credit_card
                                                                </i>
                                                                <span class="title">
                                                                    Tipo Documento
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.tipodocumento+`   
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    perm_contact_calendar
                                                                </i>
                                                                <span class="title">
                                                                    Fecha de Nacimiento
                                                                </span>
                                                                <p>
                                                                    `+moment(respuesta.data.user.fechanacimiento).format('LL')+`
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    local_hospital
                                                                </i>
                                                                <div class="left">
                                                                   <span class="title">
                                                                        Eps
                                                                    </span>
                                                                    <p>
                                                                       `+respuesta.data.eps+`   
                                                                    </p> 
                                                                </div>
                                                               
                                                                <div class="right">
                                                                   <span class="title">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                       `+otra_eps+` 
                                                                    </p> 
                                                                </div>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <div class="left">
                                                                    <span class="title">
                                                                       Dirección
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.direccion+`
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Barrio
                                                                    </span>
                                                                    <p>
                                                                        `+respuesta.data.user.barrio+` 
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    email
                                                                </i>
                                                                <span class="title">
                                                                   Correo Electrónico
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.user.email+`
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    Documento
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.user.documento+` 
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    details
                                                                </i>
                                                                <span class="title">
                                                                    Grupo Sanguineo
                                                                </span>
                                                                <p>
                                                                   `+respuesta.data.gruposanguineo+`   
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    filter_6
                                                                </i>
                                                                <span class="title">
                                                                    Estrato Social
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.user.estrato+`                                                                    
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <span class="title">
                                                                    Lugar de Residencia
                                                                </span>
                                                                <p>
                                                                    `+respuesta.data.ciudad+` - `+respuesta.data.departamento+`
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                
                                                                <div class="center">
                                                                    <span class="title">
                                                                       Datos contacto
                                                                    </span>
                                                                </div>
                                                                <div class="left">
                                                                    <i class="material-icons circle teal darken-2">
                                                                    phone
                                                                </i>
                                                                    <p>
                                                                        Telefono <br>
                                                                        `+telefono+` 
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Celular
                                                                    </span>
                                                                    <p>
                                                                        `+celular+` 
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
      $('#modal1').openModal();
    }
    })
}

