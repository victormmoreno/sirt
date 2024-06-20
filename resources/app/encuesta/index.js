const sendTokenEncuesta = (route, fase, e) => {
    e.preventDefault();
    if (fase == "Ejecución") {
        Swal.fire({
            title: "¿Está seguro(a) de enviar la encuesta de percepción?",
            text: "Esta encuesta es obligatoria para poder avanzar a la siguiente fase.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sí, enviar",
        }).then((result) => {
            if (result.value) {
                setTimeout(function() {
                    location.href = route;
                }, 50);
            } else {
                Swal.fire("Encuesta no enviada", "", "info");
            }
        });
    } else {
        Swal.fire("En esta fase no esta permitida enviar la encuesta", "", "error");
        location.href = route;
    }
};
