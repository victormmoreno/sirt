function sendTokenEncuesta(route, fase, contador, e) {
    e.preventDefault();
    if (fase == "Planeación" && contador == 0) {
        Swal.fire({
            title: "¿Está seguro(a) de enviar la solicitud de aprobación?",
            text: "Para continuar se necesita ingresar la fecha de finalización de ejecución del proyecto según el cronograma adjunto en esta fase. En el formato YYYY-MM-DD",
            type: "warning",
            input: "text",
        }).then((result) => {
            console.log(result);
            // if (result.value) {
            //     location.href = route + "/" + result.value;
            // }
        });
    } else {
        // location.href = route;
    }
}
