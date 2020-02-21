var UserIndex = {
	detailUser(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: "/usuario/usuarios/" + id
        }).done(function(respuesta) {
            modalUser(respuesta);
        });
    }
}
