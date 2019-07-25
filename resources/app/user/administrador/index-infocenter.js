$(document).ready(function() {
    $('#infocenter_table').DataTable({
        language: {
             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
         },
    });
    // $('.dataTables_length select').addClass('browser-default');
});


 var UserAdministradorInfocenter = {
     selectInfocentersForNodo: function() {
         let nodo = $('#selectnodo').val();
         $('#infocenter_table').dataTable().fnDestroy();
         $('#infocenter_table').DataTable({
             language: {
                 "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
             },
             processing: true,
             serverSide: true,
             order: false,
             ajax: {
                 url: "/usuario/infocenter/getinfocenter/" + nodo,
                 type: "get",
             },
             columns: [
             {
                 data: 'tipodocumento',
                 name: 'tipodocumento',
             }, {
                 data: 'documento',
                 name: 'documento',
             }, {
                 data: 'nombre',
                 name: 'nombre',
             }, {
                 data: 'email',
                 name: 'email',
             }, {
                 data: 'telefono',
                 name: 'telefono',
             }, {
                 data: 'estado',
                 name: 'estado',
             }, {
                 data: 'detail',
                 name: 'detail',
                 orderable: false,
             }, 
             ],
         });
    },
    detalleInfocenter(id){
        $.ajax({
	        dataType:'json',
	        type:'get',
	        url:"/usuario/infocenter/"+id
	      }).done(function(respuesta){
	        $("#titulo_infocenter").empty();
	        if (respuesta == null) {
	          swal('Ups!!!', 'Ha ocurrido un error', 'warning');
	        } else {
	            let genero = respuesta.data.user.genero == 1 ? 'Masculino' : 'Femenino';
	            let otra_eps = respuesta.data.user.otra_eps != null ? respuesta.data.user.otra_eps : 'No registra';
	            let telefono = respuesta.data.user.telefono != null ? respuesta.data.user.telefono : 'No registra';
	            let celular = respuesta.data.user.celular != null ? respuesta.data.user.celular : 'No registra';
	          
	          $("#titulo_infocenter").append(`<div class="row">
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
		                                                                    `+respuesta.data.user.tipodocumento.nombre+`   
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
		                                                                       `+respuesta.data.user.eps.nombre+`   
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
		                                                                   `+respuesta.data.user.gruposanguineo.nombre+`   
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
		                                                                    `+respuesta.data.user.ciudad.nombre+` - `+respuesta.data.user.ciudad.departamento.nombre+`
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
		                                                <div class="right">
		                                                    <small>
		                                                        Información Último Estudio
		                                                    </small>
		                                                </div>
		                                                <div class="divider mailbox-divider">
		                                                </div>
		                                                <div class="mailbox-text">
		                                                    <div class="row">
		                                                        <div class="col s12 m6 l6">
		                                                            <ul class="collection">
		                                                                <li class="collection-item avatar">
		                                                                    <i class="material-icons circle teal darken-2">
		                                                                        assignment_ind
		                                                                    </i>
		                                                                    <span class="title">
		                                                                        Institución
		                                                                    </span>
		                                                                    <p>
		                                                                        `+respuesta.data.user.institucion+`
		                                                                    </p>
		                                                                </li>
		                                                                <li class="collection-item avatar">
		                                                                    <i class="material-icons circle teal darken-2">
		                                                                        assignment_ind
		                                                                    </i>
		                                                                    <span class="title">
		                                                                        Titulo obtenido
		                                                                    </span>
		                                                                    <p>
		                                                                         `+respuesta.data.user.titulo_obtenido+`
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
		                                                                        Grado de escolaridad
		                                                                    </span>
		                                                                    <p>
		                                                                         `+respuesta.data.user.gradoescolaridad.nombre+`
		                                                                    </p>
		                                                                </li>
		                                                                <li class="collection-item avatar">
		                                                                    <i class="material-icons circle teal darken-2">
		                                                                        assignment_ind
		                                                                    </i>
		                                                                    <span class="title">
		                                                                        Fecha de terminación
		                                                                    </span>
		                                                                    <p>
		                                                                         `+moment(respuesta.data.user.fecha_terminacion).format('LL')+`
		                                                                    </p>
		                                                                </li>
		                                                            </ul>
		                                                        </div>
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
	          $('#detalleinfocenter').openModal();
	        }
	        })
	    }
 }
