function modalUser(respuesta) {
    $(".titulo_users").empty();
    let genero = respuesta.data.user.genero == 1 ? 'Masculino' : 'Femenino';
    let otra_eps = respuesta.data.user.otra_eps != null ? respuesta.data.user.otra_eps : 'No registra';
    let telefono = respuesta.data.user.telefono != null ? respuesta.data.user.telefono : 'No registra';
    let celular = respuesta.data.user.celular != null ? respuesta.data.user.celular : 'No registra';
 
    $(".titulo_users").append(`<div class="row">
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
                                                        ` + (respuesta.data.user.nombres != null ? respuesta.data.user.nombres : 'No registra') + " " + (respuesta.data.user.apellidos != null ? respuesta.data.user.apellidos : 'No registra') + `
                                                    </span>

                                                    <span class="mailbox-author black-text text-darken-2">
                                                        
                                                        ` + (respuesta.data.role != null ? respuesta.data.role  : 'No registra' ) + `<br>
                                                        Miembro desde ` + (respuesta.data.user.created_at != null ? moment(respuesta.data.user.created_at).format('LL') : 'No registra') + ` <br>
                                                    </span>
                                                </div>
                                            </div>
                                            

                                            <div class="right mailbox-buttons">
                                                
                                            </div>
                                        </div>
                                        <div class="right">
                                            <small>` + genero + `</small>
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
                                                                ` + (respuesta.data.user.tipodocumento.nombre != null ? respuesta.data.user.tipodocumento.nombre : 'No registra') + `   
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
                                                                ` + (respuesta.data.user.fechanacimiento != null ? moment(respuesta.data.user.fechanacimiento).format('LL') : 'No registra') + `
                                                            </p>
                                                            
                                                        </li>
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle teal darken-2">
                                                                credit_card
                                                            </i>
                                                            <span class="title">
                                                                Ciudad Expedición documento de identidad
                                                            </span>
                                                            <p>
                                                                ` + (respuesta.data.user.ciudadexpedicion.nombre != null ? respuesta.data.user.ciudadexpedicion.nombre : 'No registra') + `   
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
                                                                   ` + (respuesta.data.user.eps.nombre != null ? respuesta.data.user.eps.nombre : 'No registra') + `   
                                                                </p> 
                                                            </div>
                                                           
                                                            <div class="right">
                                                               <span class="title">
                                                                    Otra Eps
                                                                </span>
                                                                <p>
                                                                   ` + otra_eps + ` 
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
                                                                    ` + (respuesta.data.user.direccion != null ? respuesta.data.user.direccion : 'No registra') + `
                                                                </p>
                                                            </div>
                                                            <div class="right">
                                                                <span class="title">
                                                                   Barrio
                                                                </span>
                                                                <p>
                                                                    ` + (respuesta.data.user.barrio != null || respuesta.data.user.barrio != ' '   ? respuesta.data.user.barrio : 'No registra') + ` 
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
                                                                ` + (respuesta.data.user.email != null ? respuesta.data.user.email : 'No registra') + `
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
                                                                ` + (respuesta.data.user.documento != null ? respuesta.data.user.documento : 'No registra') + ` 
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
                                                               ` + (respuesta.data.user.gruposanguineo.nombre != null ? respuesta.data.user.gruposanguineo.nombre : 'No registra') + `   
                                                            </p>
                                                        </li>
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle teal darken-2">
                                                                credit_card
                                                            </i>
                                                            <span class="title">
                                                                Deparamento Expedición documento de identidad
                                                            </span>
                                                            <p>
                                                                ` + (respuesta.data.user.ciudadexpedicion.departamento.nombre != null ? respuesta.data.user.ciudadexpedicion.departamento.nombre : 'No registra') + `
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
                                                                ` + (respuesta.data.user.estrato != null ? respuesta.data.user.estrato : 'No registra') + `                                                                    
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
                                                                ` + ( respuesta.data.user.ciudad.nombre != null &&  respuesta.data.user.ciudad.departamento.nombre != null ?  respuesta.data.user.ciudad.nombre + ` - ` + respuesta.data.user.ciudad.departamento.nombre : 'No registra') + `
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
                                                                    ` + telefono + ` 
                                                                </p>
                                                            </div>
                                                            <div class="right">
                                                                <span class="title">
                                                                   Celular
                                                                </span>
                                                                <p>
                                                                    ` + celular + ` 
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
                                                                    ` + (respuesta.data.user.institucion != null ? respuesta.data.user.institucion : 'No registra') + `
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
                                                                     ` + (respuesta.data.user.titulo_obtenido != null ? respuesta.data.user.titulo_obtenido : 'No registra') + `
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
                                                                     ` + (respuesta.data.user.gradoescolaridad.nombre != null ? respuesta.data.user.gradoescolaridad.nombre : 'No registra') + `
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
                                                                     ` + (respuesta.data.user.fecha_terminacion != null ? moment(respuesta.data.user.fecha_terminacion).format('LL') : 'No registra') + `
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
    if (respuesta.data.user.dinamizador != null) {
        $(".titulo_users").append(`<div class="row">
                 <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                    
                                <div class="col s12 m12 l12">
                                    
                                    <div class="mailbox-view">
                                        
                                        <div class="mailbox-text">
                                            
                                            <div class="right">
                                                <small>
                                                    Información Dinamizador
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6 offset-l3 m-3">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    Nodo
                                                                </span>
                                                                <p>
                                                                    Tecnoparque nodo ` + (respuesta.data.user.dinamizador.nodo.entidad.nombre != null ? respuesta.data.user.dinamizador.nodo.entidad.nombre : 'No registra') + `
                                                                    <br>
                                                                        <small>
                                                                            <b>Dirección:</b>
                                                                            ` + (respuesta.data.user.dinamizador.nodo.direccion != null ? respuesta.data.user.dinamizador.nodo.direccion : 'No registra') + `
                                                                        </small> 
                                                                    <br>
                                                                </p>    
                                                            </li>
                                                           
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>`);
    }
    if (respuesta.data.user.gestor) {
        $(".titulo_users").append(`<div class="row">
                 <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                    
                                <div class="col s12 m12 l12">
                                    
                                    <div class="mailbox-view">
                                        
                                        <div class="mailbox-text">
                                            
                                            <div class="right">
                                                <small>
                                                    Información Gestor
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m8 l8 offset-l2 m-2">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    <b class="teal-text darken-2">
                                                                        Nodo del Gestor:
                                                                    </b>
                                                                    Tecnoparque Nodo ` + (respuesta.data.user.gestor.nodo.entidad.nombre != null ? respuesta.data.user.gestor.nodo.entidad.nombre : 'No registra') + `
                                                                    <br> 
                                                                    <b class="teal-text darken-2">
                                                                        Linea del Gestor:
                                                                    </b>
                                                                     ` + (respuesta.data.user.gestor.lineatecnologica.nombre != null ? respuesta.data.user.gestor.lineatecnologica.nombre : 'No registra') + `
                                                                    <br> 
                                                                    <b class="teal-text darken-2">
                                                                        Honorario del Gestor:
                                                                    </b>
                                                                    $ ` + (respuesta.data.user.gestor.honorarios != null ? respuesta.data.user.gestor.honorarios : null) + `
                                                                </span>
                                                                                                                                               
                                                            </li>
                                                           
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>`);
    }
    if (respuesta.data.user.infocenter) {
        $(".titulo_users").append(`<div class="row">
                 <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                    
                                <div class="col s12 m12 l12">
                                    
                                    <div class="mailbox-view">
                                        
                                        <div class="mailbox-text">
                                            
                                            <div class="right">
                                                <small>
                                                    Información Infocenter
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m8 l8 offset-l2 m-2">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    <b class="teal-text darken-2">
                                                                        Nodo del Infocenter:
                                                                    </b>
                                                                    ` + (respuesta.data.user.infocenter.nodo.entidad.nombre != null ? 'Tecnoparque Nodo ' + respuesta.data.user.infocenter.nodo.entidad.nombre : 'No registra') + `
                                                                    <br> 
                                                                    <b class="teal-text darken-2">
                                                                        Extensión del Infocenter:
                                                                    </b>
                                                                     ` + (respuesta.data.user.infocenter.extension != null ? respuesta.data.user.infocenter.extension : 'No registra') + `
                                                                    
                                                                </span>
                                                                                                                                               
                                                            </li>
                                                           
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>`);
    }
    if (respuesta.data.user.talento) {
        let entidadTalento = respuesta.data.user.talento.entidad.nombre ? respuesta.data.user.talento.entidad.nombre : 'NO REGISTRA';
        let universidadTalento = respuesta.data.user.talento.universidad ? respuesta.data.user.talento.universidad : 'NO REGISTRA';
        let perfil = respuesta.data.user.talento.perfil.nombre == 'Aprendiz SENA sin apoyo de sostenimiento' ? entidadTalento : respuesta.data.user.talento.perfil.nombre == 'Aprendiz SENA con apoyo de sostenimiento' ? entidadTalento : respuesta.data.user.talento.perfil.nombre == 'Egresado SENA' ? entidadTalento : respuesta.data.user.talento.perfil.nombre == 'Funcionario empresa púbilca' ? respuesta.data.user.talento.empresa ? respuesta.data.user.talento.empresa : 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Estudiante Universitario de Pregrado' ? respuesta.data.user.talento.universidad ? respuesta.data.user.talento.universidad : 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Estudiante Universitario de Postgrado' ? respuesta.data.user.talento.universidad ? respuesta.data.user.talento.universidad : 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Funcionario microempresa' ? respuesta.data.user.talento.empresa ? respuesta.data.user.talento.empresa : 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Funcionario mediana empresa' ? respuesta.data.user.talento.empresa ? respuesta.data.user.talento.empresa : 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Funcionario grande empresa' ? respuesta.data.user.talento.empresa ? respuesta.data.user.talento.empresa : 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Emprendedor independiente' ? 'NO REGISTRA' : respuesta.data.user.talento.perfil.nombre == 'Investigador' ? entidadTalento : respuesta.data.user.talento.perfil.nombre == 'Otro' ? respuesta.data.user.talento.otro_tipo_talento ? respuesta.data.user.talento.otro_tipo_talento : 'NO REGISTRA' : 'NO REGISTRA'
        $(".titulo_users").append(`<div class="row">
                 <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                    
                                <div class="col s12 m12 l12">
                                    
                                    <div class="mailbox-view">
                                        
                                        <div class="mailbox-text">
                                            
                                            <div class="right">
                                                <small>
                                                    Información Talento
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m12 l12">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <div class="row">
                                                                    <div class="col s12 m6 l6">
                                                                        <span class="title">
                                                                            <b class="teal-text darken-2">
                                                                                Perfil
                                                                            </b>
                                                                            <br>                                                                                        
                                                                        </span>
                                                                        <p>
                                                                        ` + (respuesta.data.user.talento.perfil.nombre != null ? respuesta.data.user.talento.perfil.nombre : null) + `
                                                                        </p>
                                                                    </div>
                                                                    <div class="col s12 m6 l6">
                                                                        <span class="title">
                                                                            <b class="teal-text darken-2">
                                                                                Entidad asociada
                                                                            </b>
                                                                        </span>
                                                                        <p>
                                                                         ` + perfil + `
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                                                                                            
                                                            </li>  
                                                        </ul>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>`);
    }
    if (respuesta.data.user.ingreso) {
        $(".titulo_users").append(`<div class="row">
                 <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                    
                                <div class="col s12 m12 l12">
                                    
                                    <div class="mailbox-view">
                                        
                                        <div class="mailbox-text">
                                            
                                            <div class="right">
                                                <small>
                                                    Información Ingreso
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6 offset-l3 m-3">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    Nodo
                                                                </span>
                                                                <p>
                                                                     ` + (respuesta.data.user.ingreso.nodo.entidad.nombre != null ? 'Tecnoparque nodo' + respuesta.data.user.ingreso.nodo.entidad.nombre : 'No registra') + `
                                                                    <br>
                                                                        <small>
                                                                            <b>Dirección:</b>
                                                                            ` + (respuesta.data.user.ingreso.nodo.direccion != null ? respuesta.data.user.ingreso.nodo.direccion : 'No registra') + `
                                                                        </small> 
                                                                    <br>
                                                                </p>    
                                                            </li>
                                                           
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>`);
    }
    $('.detalleUsers').openModal();
}