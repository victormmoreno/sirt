$(document).ready(function () {
    // Contenedores
    divOtroAreaConocmiento = $('#otroAreaConocimiento_content');
    divEconomiaNaranja = $('#economiaNaranja_content');
    divDiscapacidad = $('#discapacidad_content');
    divNombreActorCTi = $('#nombreActorCTi_content');
    // Ocultar contenedores
    divOtroAreaConocmiento.hide();
    divEconomiaNaranja.hide();
    divDiscapacidad.hide();
    divNombreActorCTi.hide();
});


// Enviar formulario para registrar proyecto
$(document).on('submit', 'form#frmProyectos_FaseInicio', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'create');
});

// Enviar formulario para cambiar los talentos del proyecto
$(document).on('submit', 'form#frmUpdateTalentos', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'update');
});


// Enviar formulario para modificar datos del proyecto (Fase de Inicio)
$(document).on('submit', 'form#frmProyectos_FaseInicio_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'update');
});

function ajaxSendFormProyecto(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesProyectoCreate(data);
            } else {
                mensajesProyectoUpdate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesProyectoCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "El proyecto ha sido registrado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'El proyecto no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

function mensajesProyectoUpdate(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa',
            text: "El proyecto ha sido cambiado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'El proyecto no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

// Alerta que indica que el talento ya se encuentra asociado al proyecto
function talentoYaSeEncuentraAsociado() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El talento ya se encuentra asociado al proyecto!'
    });
}

// Alerta que indica que el talento ya se encuentra asociado al proyecto
function usuarioYaSeEncuentraAsociado_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El usuario ya se encuentra asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que la entidad ya se encuentra asociado al proyecto como dueña de la propiedad intelectual
function empresaYaSeEncuentraAsociado_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'Esta empresa/sede ya se encuentra asociada como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que el talento se asoció correctamente al proyecto
function talentoSeAsocioAlProyecto() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El talento se ha asociado al proyecto!'
    });
}

// Alerta que indica que la empresa se asoció correctamente al proyecto como propietario
function empresaSeAsocioAlProyecto_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La sede se ha asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que el grupo de investigación se asoció correctamente al proyecto como propietario
function grupoSeAsocioAlProyecto_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El grupo de investigación se ha asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que la idea de proyecto se asoció al proyecto
function ideaProyectoAsociadaConExito(codigo, nombre) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La siguiente idea se ha asociado al proyecto: ' + codigo + ' - ' + nombre
    });
}


// Prepara un string con la fila que se va a pintar en la tabla de los talentos que participaran en el proyecto
function prepararFilaEnLaTablaDeTalentos(ajax, isInterlocutor) {
    let talentInterlocutor = null;
    if(isInterlocutor){
        talentInterlocutor = "checked";
    }// El ajax.talento.id es el id del TALENTO, no del usuario
    let idTalento = ajax.talento.id;
    let fila = '<tr class="selected" id=talentoAsociadoAProyecto' + idTalento + '>' + '<td><input type="radio" '+ talentInterlocutor +' class="with-gap" name="radioTalentoLider" id="radioButton' + idTalento + '" value="' + idTalento + '" /><label for ="radioButton' + idTalento + '"></label></td>' + '<td><input type="hidden" name="talentos[]" value="' + idTalento + '">' + ajax.talento.documento + ' - ' + ajax.talento.nombres + ' '+ ajax.talento.apellidos +'</td>' + '<td><a class="waves-effect bg-danger btn" onclick="eliminarTalentoDeProyecto_FaseInicio(' + idTalento + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (users/persona) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Users(ajax) { // El ajax.user.id es el id del USER
    let idUser = ajax.talento.id;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Persona' + idUser + '>' + '<td><input type="hidden" name="propietarios_user[]" value="' + idUser + '">' + ajax.talento.documento + ' - ' + ajax.talento.nombres + ' ' + ajax.talento.apellidos + '</td>' + '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona(' + idUser + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}


// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (empresas) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Empresa(ajax) {
    let idSede = ajax.sede.id;
    let codigo = ajax.sede.empresa.nit;
    let nombre = ajax.sede.empresa.nombre;
    let nombre_sede = ajax.sede.nombre_sede;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Empresa' + idSede + '>' + '<td><input type="hidden" name="propietarios_sedes[]" value="' + idSede + '">' + codigo + ' - ' + nombre + ' ('+ nombre_sede +')</td>' + '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(' + idSede + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (grupos de investigación) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Grupos(ajax) { // El ajax.user.id es el id del USER
    let idGrupo = ajax.detalles.id;
    let codigo = ajax.detalles.codigo_grupo;
    let nombre = ajax.detalles.entidad.nombre;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Grupo' + idGrupo + '>' + '<td><input type="hidden" name="propietarios_grupos[]" value="' + idGrupo + '">' + codigo + ' - ' + nombre + '</td>' + '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(' + idGrupo + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Pinta el talento en la tabla de los talentos que participarán en el proyecto
function pintarTalentoEnTabla_Fase_Inicio(id, isInterlocutor) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: `${host_url}/usuarios/talento/consultarTalentoPorId/${id}`
    }).done(function (ajax) {

        let fila = prepararFilaEnLaTablaDeTalentos(ajax, isInterlocutor);
        $('#detalleTalentosDeUnProyecto_Create').append(fila);
        talentoSeAsocioAlProyecto();
    });
}

// Pinta el usuario en la tabla de los usuarios que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: `${host_url}/usuarios/talento/consultarTalentoPorId/${id}`
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Users(ajax);
        $('#propiedadIntelectual_Personas').append(fila);
        talentoSeAsocioAlProyecto();
    });
}

// Pinta el usuario en la tabla de las entidades (empresas) que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(sede_id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : `${host_url}/empresa/ajaxDetalleDeUnaSede/${sede_id}`,
        success: function (response) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'La sede '+response.sede.nombre_sede+' se asoció a la idea de proyecto!'
          });
          let fila = prepararFilaEnLaTablaDePropietarios_Empresa(response);
              $('#propiedadIntelectual_Empresas').append(fila);
              empresaSeAsocioAlProyecto_Propietario();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
}

// Pinta el usuario en la tabla de las entidades (grupos de investigacion) que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grupo/ajaxDetallesDeUnGrupoInvestigacion/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Grupos(ajax);
        // let fila = Grupos);
        $('#propiedadIntelectual_Grupos').append(fila);
        grupoSeAsocioAlProyecto_Propietario();
    });
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat(id) {
    let a = document.getElementsByName("talentos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == id) {
            return false;
        }
    }
    return true;
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat_Propiedad(id) {
    let idUser = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_user[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idUser) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que la sede no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Sede(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_sedes[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idEntidad) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que el grupo de investigación no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Grupo(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_grupos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idEntidad) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Elimina un talento que se encuentre asociado a un proyecto
function eliminarTalentoDeProyecto_FaseInicio(index) {
    $('#talentoAsociadoAProyecto' + index).remove();
}

// Elimina una persona que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Persona(index) {
    $('#propietarioAsociadoAlProyecto_Persona' + index).remove();
}

// Elimina una empresa que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(index) {
    $('#propietarioAsociadoAlProyecto_Empresa' + index).remove();
}

// Elimina una empresa que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(index) {
    $('#propietarioAsociadoAlProyecto_Grupo' + index).remove();
}

// Método para agregar talentos a un proyecto
// El parametro recibido es el id de la tabla talentos
function addTalentoProyecto(id, isInterloculor) {
    let unique = true;
    let a = document.getElementsByName("talentos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == id) {
            unique = false;
        }
    }
    if (!unique) {
        talentoYaSeEncuentraAsociado();
    } else {
        pintarTalentoEnTabla_Fase_Inicio(id, isInterloculor);
    }
}

// Método para agregar un talento como dueño de una ´rpíedad intelectual
// El id recibido es el id de la tabla users
function addPersonaPropiedad(user_id) {
    if (noRepeat_Propiedad(user_id) == false) {
        usuarioYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(user_id);
    }
}

function prepararSedesEmpresa(sedes) {
    let fila = "";
    sedes.forEach(element => {
        fila += `<li class="collection-item">
        ` + element.nombre_sede + ` - ` + element.direccion + ` ` + element.ciudad.nombre + ` (` + element.ciudad.departamento.nombre + `)
        <a href="#!" class="secondary-content" onclick="addSedePropietaria(`+element.id+`)">Asociar esta sede de la empresa al proyecto</a></div>
      </li>`;
    });
    return fila;
}

// Método para agregar una empresa como dueño de una propiedad intelectual
function addEntidadEmpresa(id) {
    $('#sedesPropietarias_Empresas_detalles').empty();
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : host_url + '/empresa/ajaxDetallesDeUnaEmpresa/'+id+'/id',
        success: function (response) {
            let filas_sedes = prepararSedesEmpresa(response.empresa.sedes);
            $('#sedesPropietarias_Empresas_detalles').append(filas_sedes);
            $('#sedesPropietarias_Empresas_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
}

function addSedePropietaria(id) {
    if (noRepeat_Sede(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(id);
    }
}

// Método para agregar un grupo de investigación como dueño de una propiedad intelectual
// El id recibido es el id de la tabla gruposinvestigacion
function addGrupoPropietario(id) {
    if (noRepeat_Grupo(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(id);
    }
}
//vaciar valores agregados en tablas
function dumpAggregateValuesIntoTables(){
    $('#detalleTalentosDeUnProyecto_Create').empty();
    $('#propiedadIntelectual_Personas').empty();
    $('#propiedadIntelectual_Empresas').empty();
    $('#propiedadIntelectual_Grupos').empty();
}

//agregar valor a campos
function addValueToFields(nombre, codigo, value){
    $('#txtnombreIdeaProyecto_Proyecto').val(codigo + " - " + nombre);
    $('#txtnombre').val(nombre);
    $("label[for='txtnombreIdeaProyecto_Proyecto']").addClass('active');
    $("label[for='txtnombre']").addClass('active');

    $('#txtobjetivo').val(value.objetivo);
    $('#txtobjetivo').trigger('autoresize');
    $("label[for='txtobjetivo']").addClass('active');

    $('#txtalcance_proyecto').val(value.alcance);
    $('#txtalcance_proyecto').trigger('autoresize');
    $("label[for='txtalcance_proyecto']").addClass('active');
}


// Asocia una idea de proyecto al registro de un proyecto
function asociarIdeaDeProyectoAProyecto(id, nombre, codigo) {
    $('#txtidea_id').val(id);

    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/idea/show/' + id
    }).done(function (response) {
        let value = response.data.idea;
        if(idea =! null){
            dumpAggregateValuesIntoTables();

            addValueToFields(nombre, codigo, value);
            ideaProyectoAsociadaConExito(codigo, nombre);

            if(response.data.talento != null){
                addTalentoProyecto(response.data.talento.id, true);
                addPersonaPropiedad(response.data.talento.id);
            }
            if(response.data.sede != null){
                addSedePropietaria(response.data.sede.id);
            }
            $('#ideasDeProyectoConEmprendedores_modal').closeModal();
        }

    }).fail(function( jqXHR, textStatus, errorThrown ) {
        errorAjax(jqXHR, textStatus, errorThrown);
    });

}

// Consultas las ideas de proyecto que fueron aprobadas en el comité
function consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio() {
    let nodo = 1;
    let id_experto = 1;
    if (isset($('#txtnodo_id').val()))
        nodo = $('#txtnodo_id').val();
    if (isset($('#txtexperto_id_proyecto').val()))
        id_experto = $('#txtexperto_id_proyecto').val();
    //id_experto = $('#txtexperto_id_proyecto').val();
    $('#ideasDeProyectoConEmprendedores_proyecto_table').dataTable().fnDestroy();
    $('#ideasDeProyectoConEmprendedores_proyecto_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [
            0, 'desc'
        ],
        ajax: {
            url: host_url + "/proyecto/ideasAsociadasAExperto/"+nodo+"/"+id_experto,
            type: "get"
        },
        select: true,
        columns: [
            {
                data: 'codigo_idea',
                name: 'codigo_idea'
            }, {
                data: 'nombre_proyecto',
                name: 'nombre_proyecto'
            }, {
                data: 'nombres_contacto',
                name: 'nombres_contacto'
            }, {
                width: '20%',
                data: 'checkbox',
                name: 'checkbox',
                orderable: false
            },
        ]
    });
    $('#ideasDeProyectoConEmprendedores_modal').openModal({dismissible: false});
}

// Datatable que muestra las empresas que hay en la base de datos para asociarlas como propietarios
function consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table() {
    $('#posiblesPropietarios_Empresas_table').dataTable().fnDestroy();
    $('#posiblesPropietarios_Empresas_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: host_url + "/empresa/datatableEmpresasDeTecnoparque",
            type: "get"
        },
        columns: [
            {
                data: 'nit',
                name: 'nit'
            }, {
                data: 'nombre_empresa',
                name: 'nombre_empresa'
            }, {
                data: 'add_propietario',
                name: 'add_propietario',
                orderable: false
            },
        ]
    });
    $('#posiblesPropietarios_Empresas_modal').openModal();
}

// Datatable que muestra los grupos de investigación que hay en la base de datos para asociarlas como propietarios
function consultarGruposDeTecnoparque_Proyecto_FaseInicio_table() {
    $('#posiblesPropietarios_Grupos_table').dataTable().fnDestroy();
    $('#posiblesPropietarios_Grupos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: host_url + "/grupo/datatableGruposInvestigacionDeTecnoparque",
            type: "get"
        },
        columns: [
            {
                data: 'codigo_grupo',
                name: 'codigo_grupo'
            }, {
                data: 'nombre',
                name: 'nombre'
            }, {
                data: 'add_propietario',
                name: 'add_propietario',
                orderable: false
            },
        ]
    });
    $('#posiblesPropietarios_Grupos_modal').openModal();
}

// Datatable que muestra los talentos que se encuentran registrados en Tecnoparque
function consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table(tableName, fieldName) {
    $(tableName).dataTable().fnDestroy();
    $(tableName).DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: `${host_url}/usuarios/talento/getTalentosDeTecnoparque/`,
            type: "get"
        },
        columns: [
            {
                data: 'documento',
                name: 'documento'
            }, {
                data: 'talento',
                name: 'talento'
            }, {
                data: fieldName,
                name: fieldName,
                orderable: false
            },
        ]
    });
    if (tableName == '#posiblesPropietarios_Personas_table') {
        $('#posiblesPropietarios_Personas_modal').openModal();
    }
}

function selectAreaConocimiento_Proyecto_FaseInicio() {
    let id = $("#txtareaconocimiento_id").val();
    let nombre = $("#txtareaconocimiento_id [value='" + id + "']").text();
    if (nombre == 'Otro') {
        divOtroAreaConocmiento.show();
    } else {
        divOtroAreaConocmiento.hide();
    }
}

function showInput_EconomiaNaranja() {
    if ($('#txteconomia_naranja').is(':checked')) {
        divEconomiaNaranja.show();
    } else {
        divEconomiaNaranja.hide();
    }
}

function showInput_Discapacidad() {
    if ($('#txtdirigido_discapacitados').is(':checked')) {
        divDiscapacidad.show();
    } else {
        divDiscapacidad.hide();
    }
}

function showInput_ActorCTi() {
    if ($('#txtarti_cti').is(':checked')) {
        divNombreActorCTi.show();
    } else {
        divNombreActorCTi.hide();
    }
}

function errorAjax(jqXHR, textStatus, errorThrown){
    if (jqXHR.status === 0) {

        alert('Not connect: Verify Network.');

      } else if (jqXHR.status == 404) {

        alert('Requested page not found [404]');

      } else if (jqXHR.status == 500) {

        alert('Internal Server Error [500].');

      } else if (textStatus === 'parsererror') {

        alert('Requested JSON parse failed.');

      } else if (textStatus === 'timeout') {

        alert('Time out error.');

      } else if (textStatus === 'abort') {

        alert('Ajax request aborted.');

      } else {

        alert('Uncaught Error: ' + jqXHR.responseText);

      }
}

function consultarExpertosDeUnNodo(nodo_id) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: `${host_url}/usuarios/gestores/nodo/${nodo_id}`
      }).done(function(response){
          $("#txtexperto_id_proyecto").empty();
          $('#txtexperto_id_proyecto').append('<option value="">Seleccione el experto</option>');
          $.each(response.gestores, function(i, e) {
            $('#txtexperto_id_proyecto').append('<option  value="'+e.user_id+'">'+e.nombre+'</option>');
          })
          $('#txtexperto_id_proyecto').material_select();
    });
}

function consultarInformacionExperto(user) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/usuario/consultarUserPorId/"+user
      }).done(function(response){
          printLinea(response);
          consultarSublineas(response.user.gestor.lineatecnologica.id);
    });
}

function consultarSublineas(linea) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/proyecto/sublineas_of/"+linea
    }).done(function (response) {
        printSublineas(response);
    });
}

function printSublineas(response) {
    $("#txtsublinea_id").empty();
    $('#txtsublinea_id').append('<option value="">Seleccione la sublinea</option>');
    $.each(response.sublineas, function(i, e) {
      $('#txtsublinea_id').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
    })
    $('#txtsublinea_id').material_select();
}

function printLinea(response) {
    $('#txtlinea').val(response.user.gestor.lineatecnologica.nombre);
}
