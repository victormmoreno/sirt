function addIdeaComite() {
    let id = $('#txtideaproyecto').val();
    let hora = $('#txthoraidea').val();
    let direccion = $('#txtdireccion').val();
    if (id == 0 || hora == '' || direccion == '') {
        datosIncompletosAgendamiento();
    } else {
        if (noRepeatIdeasAgendamiento(id) == false) {
            ideaYaSeEncuentraAsociadaAgendamiento();
        } else {
            pintarIdeaEnLaTabla(id, hora, direccion);
        }
    }
}


function addGestorComite() {
    let id = $('#txtidgestor').val();
    let hora_inicio = $('#txthorainiciogestor').val();
    let hora_fin = $('#txthorafingestor').val();
    if (id == 0 || hora_inicio == '' || hora_fin == '') {
        datosIncompletosGestorAgendamiento();
    } else {
        if (noRepeatGestoresAgendamiento(id) == false) {
            gestorYaSeEncuentraAsociadoAgendamiento();
        } else {
            pintarGestorEnLaTabla(id, hora_inicio, hora_fin);
        }
    }
}

$('#txthoraidea').bootstrapMaterialDatePicker({
    time:true,
    date:false,
    shortTime:true,
    format: 'HH:mm',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
});
  
$('#txthorafingestor').bootstrapMaterialDatePicker({ 
    time:true,
    date:false,
    shortTime:true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
});
 
$('#txthorainiciogestor').bootstrapMaterialDatePicker({ 
    time:true,
    date:false,
    shortTime: true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
 });
 
$('#txthorafingestor').bootstrapMaterialDatePicker({ 
    time:true,
    date:false,
    shortTime: true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
 });

$(document).on('submit', 'form#formComiteAgendamientoCreate', function (event) { // $('button[type="submit"]').prop("disabled", true);
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteAgendamiento(form, data, url, 'create');
        }
    });
});

$(document).on('submit', 'form#formComiteAgendamientoUpdate', function (event) { // $('button[type="submit"]').prop("disabled", true);
event.preventDefault();
Swal.fire({
    title: '¿Está seguro(a) de guardar esta información?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, guardar'
  }).then((result) => {
    if (result.value) {
        $('button[type="submit"]').attr('disabled', 'disabled');
        event.preventDefault();
        var form = $(this);
        var data = new FormData($(this)[0]);
        var url = form.attr("action");
        ajaxSendFormComiteAgendamiento(form, data, url, 'update');
    }
  })
});

// Elimina una idea de proyecto agendada en un comité
function eliminarIdeaDelAgendamiento(index) {
    $('#ideaAsociadaAgendamiento' + index).remove();
}

// Elimina un gestor agendada en un comité
function eliminarGestorDelAgendamiento(index) {
    $('#gestorAsociadoAgendamiento' + index).remove();
}

function ajaxSendFormComiteAgendamiento(form, data, url, fase) {
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
            mensajesComiteAgendamientoCreate(data);
        } else {
            mensajesComiteAgendamientoUpdate(data);
        }
    },
    error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
    }
});
};

function mensajesComiteAgendamientoCreate(data) {
if (data.state == 'registro') {
    Swal.fire({
        title: 'Registro Exitoso',
        text: "El comité ha sido registrado satisfactoriamente",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
    setTimeout(function () {
        window.location.replace("/csibt");
    }, 1000);
}
if (data.state == 'no_registro') {
    Swal.fire({
        title: 'El comité no se ha registrado, por favor inténtalo de nuevo',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}
};

function mensajesComiteAgendamientoUpdate(data) {
if (data.state == 'update') {
    Swal.fire({
        title: 'Modificación Exitosa',
        text: "El comité se ha modificado satisfactoriamente",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
    setTimeout(function () {
        window.location.replace("/csibt");
    }, 1000);
}
if (data.state == 'no_update') {
    Swal.fire({
        title: 'El comité no se ha modificado, por favor inténtalo de nuevo',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}
};

function pintarIdeaEnLaTabla(id, hora, direccion) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/idea/detallesIdea/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDeIdeas(ajax, hora, direccion);
        $('#tblIdeasComiteCreate').append(fila);
        ideaSeAsocioAlAgendamiento();
        reiniciarCamposAgendamiento();
    });
}

function pintarGestorEnLaTabla(id, hora_inicio, hora_fin) {
$.ajax({
    dataType: 'json',
    type: 'get',
    url: '/usuario/consultarUserPorId/' + id
}).done(function (ajax) {
    let fila = prepararFilaEnLaTablaDeGestores(ajax, hora_inicio, hora_fin);
    $('#tblGestoresComiteCreate').append(fila);
    gestorSeAsocioAlAgendamiento();
    reiniciarCamposGestorAgendamiento();
});
}

function prepararFilaEnLaTablaDeIdeas(ajax, hora, direccion) {
let idIdea = ajax.detalles.id;
let fila = '<tr class="selected" id=ideaAsociadaAgendamiento' + idIdea + '>' + 
    '<td><input type="hidden" name="ideas[]" value="' + idIdea + '">' + ajax.detalles.nombre_proyecto + '</td>' +
    '<td><input type="hidden" name="horas[]" value="' + hora + '">' + hora + '</td>' +
    '<td><input type="hidden" name="direcciones[]" value="' + direccion + '">' + direccion + '</td>' +
    '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelAgendamiento(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' + 
    '</tr>';
return fila;
}

function prepararFilaEnLaTablaDeGestores(ajax, hora_inicio, hora_fin) {
let idGestor = ajax.user.gestor.id;
let fila = '<tr class="selected" id=gestorAsociadoAgendamiento' + idGestor + '>' + 
    '<td><input type="hidden" name="gestores[]" value="' + idGestor + '">' + ajax.user.documento + ' - ' + ajax.user.nombres + ' ' + ajax.user.apellidos + '</td>' +
    '<td><input type="hidden" name="horas_inicio[]" value="' + hora_inicio + '">' + hora_inicio + '</td>' +
    '<td><input type="hidden" name="horas_fin[]" value="' + hora_fin + '">' + hora_fin + '</td>' +
    '<td><a class="waves-effect red lighten-3 btn" onclick="eliminarGestorDelAgendamiento(' + idGestor + ');"><i class="material-icons">delete_sweep</i></a></td>' + 
    '</tr>';
return fila;
}

function datosIncompletosAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    type: 'error',
    title: 'Estás ingresando mal los datos'
})
}

function datosIncompletosGestorAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    type: 'error',
    title: 'Estás ingresando mal los datos del gestor'
})
}

function ideaSeAsocioAlAgendamiento() {
Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'La idea de proyecto se asoció con éxito al comité'
        })
}

function gestorSeAsocioAlAgendamiento() {
Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'El gestor se asoció con éxito al comité'
        })
}

function ideaYaSeEncuentraAsociadaAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'warning',
    title: 'La idea de proyecto ya se encuentra asociada al comité!'
});
}

function gestorYaSeEncuentraAsociadoAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'warning',
    title: 'El gestor ya se encuentra asociado en este comité!'
});
}


function noRepeatIdeasAgendamiento(id) {
let idIdea = id;
let retorno = true;
let a = document.getElementsByName("ideas[]");
for (x = 0; x < a.length; x ++) {
    if (a[x].value == idIdea) {
        retorno = false;
        break;
    }
}
return retorno;
}

function noRepeatGestoresAgendamiento(id) {
let idGestor = id;
let retorno = true;
let a = document.getElementsByName("gestores[]");
for (x = 0; x < a.length; x ++) {
    if (a[x].value == idGestor) {
        retorno = false;
        break;
    }
}
return retorno;
}

function reiniciarCamposAgendamiento() {
$("#txtideaproyecto").val('0');
$("#txtideaproyecto").select2();
$('#txthoraidea').val('');
$("#txtobservacionesidea").val('');
$('#txtdireccion').val('');
$("label[for='txtdireccion']").removeClass('active');
$("label[for='txthoraidea']").removeClass('active');
}

function reiniciarCamposGestorAgendamiento() {
$("#txtidgestor").val('0');
$("#txtidgestor").select2();
$('#txthorainiciogestor').val('');
$("label[for='txthorainiciogestor']").removeClass('active');
$('#txthorafingestor').val('');
$("label[for='txthorafingestor']").removeClass('active');
}