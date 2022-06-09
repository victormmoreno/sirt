function enviarNotificacionResultadosCSIBT(idea, comite) {
    $.ajax({
        type: 'get',
        url: host_url + '/csibt/notificar_resultado/' + idea + '/' + comite,
        dataType: 'json',
        processData: false,
        success: function (data) {
            if (data.state == 'notifica') {
                notificacionExitosaDelResultado(data);
            } else {
                notificacionFallidaDelResultado();
            }
            
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function notificacionExitosaDelResultado(data) {
    Swal.fire({
        title: 'Notificación Exitosa!',
        text: "Se ha enviado un mensaje a la dirección: " + data.idea + " con los resultados del comité.",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}

function notificacionFallidaDelResultado() {
    Swal.fire({
        title: 'Notificación Fallida!',
        text: "No se ha logrado enviar una mensaje con los resultados del comité al talento.",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}