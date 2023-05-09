const user = {
    getCiudadExpedicion: function() {
        let id;
        id = $("#departamentoexpedicion").val();
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
        let id = $(ideps).val();
        if (id == 42) {
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
        let grado = $(gradodiscapacidad).val();
        if (grado == 1) {
            $(".gradodiscapacidad").removeAttr("style");
        } else {
            $(".gradodiscapacidad").attr("style", "display:none");
        }
    },
    getOtraOcupacion: function(idocupacion) {
        $("#otraocupacion").hide();
        let id = $(idocupacion).val();
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
    $("#document").empty();
    $("#ocupaciones").val();
    $("#document_type").val();
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
    return false;
});

$('button[type="reset"]').click(function() {
    this.form.reset();
    $("#document").empty();
    $("#ocupaciones").val();
    $("#document_type").val();
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
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
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
                    icon: "success",
                    type: "success",
                    html: data.message,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok",
                    backdrop: true,
                    allowOutsideClick: false,
                    footer:
                        '<p class="red-text">Hemos enviado un correo electrónico  a ' +
                        data.user.email +
                        " con las credenciales de ingreso a la plataforma.</p>"
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
