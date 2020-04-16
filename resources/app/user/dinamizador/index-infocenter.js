$(document).ready(function() {
    $('#infocenters_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": false,
        ajax: {
            url: "/usuario/infocenter/getinfocenter",
            type: "get",
        },
        columns: [{
            data: 'tipodocumento',
            name: 'tipodocumento',
        }, {
            data: 'documento',
            name: 'documento',
        }, {
            data: 'nombre',
            name: 'nombre',
        }, {
            data: 'email',
            name: 'email',
        }, {
            data: 'celular',
            name: 'celular',
        }, {
            data: 'detail',
            name: 'detail',
            orderable: false,
        }, ],
    });

    $('#infocenters_dinamizador_inactivos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": false,
        ajax: {
            url: "/usuario/infocenter/getinfocenter/papelera",
            type: "get",
        },
        columns: [{
            data: 'tipodocumento',
            name: 'tipodocumento',
        }, {
            data: 'documento',
            name: 'documento',
        }, {
            data: 'nombre',
            name: 'nombre',
        }, {
            data: 'email',
            name: 'email',
        }, {
            data: 'celular',
            name: 'celular',
        }, {
            data: 'detail',
            name: 'detail',
            orderable: false,
        }, ],
    });
});

var UserDinamizadorInfocenter = {
    downloadInfocenter: function(state){

        if(state !== null) {
            location.href = '/usuario/excel/infocenter/'+ state;
        }else{
            Swal.fire({
                title: 'Error al descagar el archivo, intentalo de nuevo',
                confirmButtonText: 'Ok',

            });
        }
    },
}