$(document).on('submit', 'form#formValidateCredentials', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (response) {
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            if (response.fail) {
                for (control in response.errors) {
                    $('#' + control + '-error').html(response.errors[control]);
                    $('#' + control + '-error').show();
                }
                printErroresFormulario(response);
            }else{
                if (response.data.user) {
                    Swal.fire({
                        title: 'Atención!',
                        html: 'Este usuario ya existe. Por favor ingrese utilizando las credenciales de usuario. Recuerde que si no recuerda su contraseña también la puede restablecer.',
                        type: 'error',
                        position: 'top',
                        toast: true,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        timer: 10000,
                        timerProgressBar: true,
                    });
                }else{
                    $('#modalvalidationuser').closeModal();
                    $('#documento').val(data.get('document'));
                    $("label[for='documento']").addClass('active');
                    $("#tipo_documento option[value='" +data.get("document_type") + "']").attr("selected",true);
                    $("#tipo_documento").val(data.get("document_type"));
                    $("#tipo_documento option[value='"+ data.get('document_type') +"']").addClass("active selected",true);
                    $('#tipo_documento').material_select();
                }
            }
        }
    });
});

const user = {
    getCiudadExpedicion: function() {
        let id = $("#departamentoexpedicion").val();
        $.ajax({
            dataType: "json",
            type: "get",
            url: `${host_url}/help/getciudades/${id}`
        }).done(function(response) {
            $("#ciudadexpedicion").empty();
            $.each(response.ciudades, function(i, e) {
                $("#ciudadexpedicion").append(
                    '<option  value="' + e.id + '">' + e.nombre + "</option>"
                );
            });
            $("#ciudadexpedicion").material_select();
        });
    },
    getOtraEsp: function(ideps) {
        if ($(ideps).val() == 42) {
            $(".otraeps").removeAttr("style");
        } else {
            $(".otraeps").attr("style", "display:none");
        }
    },
    getCiudad: function() {
        let id;
        id = $("#departamento").val();
        $.ajax({
            dataType: "json",
            type: "get",
            url: `${host_url}/help/getciudades/${id}`
        }).done(function(response) {
            $("#ciudad").empty();
            $("#ciudad").append(
                '<option value="">Seleccione la Ciudad</option>'
            );
            $.each(response.ciudades, function(i, e) {
                $("#ciudad").append(
                    '<option  value="' + e.id + '">' + e.nombre + "</option>"
                );
            });
            $("#ciudad").material_select();
        });
    },
    getGradoDiscapacidad(gradodiscapacidad) {
        if ($(gradodiscapacidad).val() == 1) {
            $(".gradodiscapacidad").removeAttr("style");
        } else {
            $(".gradodiscapacidad").attr("style", "display:none");
        }
    },
    getOtraOcupacion: function(idocupacion) {
        $("#otraocupacion").hide();
        let nombre = $("#ocupaciones option:selected").text();
        let resultado = nombre.match(/[A-Z][a-z]+/g);
        $("#otraocupacion").hide();
        if (resultado != null) {
            if (resultado.includes("Otra")) {
                $("#otraocupacion").show();
            }
        }
    }
};


$('button[type="reset"]').click(function() {
    this.form.reset();
    $("#modalvalidationuser").openModal({
        opacity: 0.7,
        in_duration: 350,
        out_duration: 250,
        ready: undefined,
        complete: undefined,
        dismissible: false,
        starting_top: "10%",
        ending_top: "10%"
    });
    $('small[class="error red-text"]').empty();
    return false;
});

//resgistro de usuarios.
$(document).on("submit", "form#formRegisterUser", function(event) {
    $('button[type="submit"]').attr("disabled", "disabled");
    event.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    $.ajax({
        type: form.attr("method"),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: "json",
        processData: false,
        success: function(data) {
            $('button[type="submit"]').prop("disabled", false);
            $(".error").hide();
            if (data.fail) {
                for (control in data.errors) {
                    $("#" + control + "-error").html(data.errors[control]);
                    $("#" + control + "-error").show();
                }
                printErroresFormulario(data);
            }
            if (data.state == "error" && data.url == false) {
                Swal.fire({
                    title: "Registro Erróneo, por favor inténtalo de nuevo",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                });
            }
            if (data.state == "success" && data.url != false) {
                Swal.fire({
                    title: "Registro Exitoso",
                    type: "success",
                    type: "success",
                    html: data.message,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok",
                    backdrop: true,
                    allowOutsideClick: false,
                    footer: `<p class="red-text">Hemos enviado un correo electrónico a ${data.user.email} con las credenciales de ingreso al sistema.</p>`
                }).then(result => {
                    if (result.isConfirmed) {
                        setTimeout(function() {
                            window.location.href = data.url;
                        }, 50);
                    }
                    setTimeout(function() {
                        window.location.href = data.url;
                    }, 50);
                });
            }
        }
    });
});

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