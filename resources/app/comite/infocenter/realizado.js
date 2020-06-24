$(document).on('submit', 'form#formComiteRealizadoCreate', function (event) { // $('button[type="submit"]').prop("disabled", true);
$('button[type="submit"]').attr('disabled', 'disabled');
event.preventDefault();
var form = $(this);
var data = new FormData($(this)[0]);
var url = form.attr("action");
ajaxSendFormComiteRealizado(form, data, url, 'create');
});

function ajaxSendFormComiteRealizado(form, data, url, fase) {
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
                mensajesComiteRealizadoCreate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesComiteRealizadoCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La calificación del comité ha sido registrada satisfactoriamente",
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
            title: 'La calificación del comité no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};