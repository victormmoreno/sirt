function preguntaRechazarAprobacionProyecto(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de no aprobar esta fase del proyecto?',
        input: 'text',
        icon: 'warning',
        inputValidator: (value) => {
            if (!value) {
                return 'Las observaciones deben ser obligatorias!'
            } else {
                $('#decision').val('rechazado');
                $('#motivosNoAprueba').val(value);
            }
        },
        inputAttributes: {
        maxlength: 100,
        placeHolder: '¿Por qué?'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
        if (result.value) {
            document.frmAprobacionProyecto.submit();
        }
    })
}

function preguntaAprobacion(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de aprobar esta fase del proyecto?',
        text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase, los documento adjuntos y las asesorias recibidas.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
    }).then((result) => {
        if (result.value) {
            $('#decision').val('aceptado');
            document.frmAprobacionProyecto.submit();
        }
    })
}