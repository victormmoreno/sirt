$(document).ready(function () {
    divInfocenter = $('#infocenter_content');
    divDinamizador = $('#dinamizador_content');
    divArticulador = $('#articulador_content');
    divArticuladorAcompanamiento = $('#articulador_acompanamiento_content');
    divCredenciales = $('#credenciales_content');
    divAlcanzaObjetivo = $('#alcanza_objetivo_content');
    divOtrosServicios = $('#otros_servicios_content');
    divInfocenter.hide();
    divDinamizador.hide();
    divArticulador.hide();
    divArticuladorAcompanamiento.hide();
    divCredenciales.hide();
    divAlcanzaObjetivo.show();
    divOtrosServicios.hide();
});

$(document).on('submit', 'form#formSaveSurvey', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    sendFormSurvey(form, data, url);
});

function sendFormSurvey(form, data, url) {
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
            if (data.state == 'error_form') {
                printErroresFormulario(data);
            }  else {
                mensajesResponderEncuesta(data);
                if (data.state) {
                    setTimeout(function () {
                        window.location.replace(data.url);
                    }, 1000);
                }
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesResponderEncuesta(data) {
    Swal.fire({
        title: data.title,
        text: data.msj,
        type: data.type,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
};

function showInput_Infocenter() {
    if ($('#conoce_infocenter').is(':checked')) {
        divInfocenter.show();
    } else {
        divInfocenter.hide();
    }
}

function showInput_Dinamizador() {
    if ($('#conoce_dinamizador').is(':checked')) {
        divDinamizador.show();
    } else {
        divDinamizador.hide();
    }
}

function showInput_Articulador() {
    if ($('#conoce_articulador').is(':checked')) {
        divArticulador.show();
    } else {
        divArticulador.hide();
    }
}

function showInput_CompartirCredenciales() {
    if ($('#comparte_credenciales').is(':checked')) {
        divCredenciales.show();
    } else {
        divCredenciales.hide();
    }
}

function showInput_AlcanzaObjetivos() {
    if (!$('#alcanza_objetivos').is(':checked')) {
        divAlcanzaObjetivo.show();
    } else {
        divAlcanzaObjetivo.hide();
    }
}

function showInput_OtrosServicios() {
    if ($('#usa_otros_servicios').is(':checked')) {
        divOtrosServicios.show();
    } else {
        divOtrosServicios.hide();
    }
}