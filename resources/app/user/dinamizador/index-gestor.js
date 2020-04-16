$(document).ready(function() {
    $('#gestores_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": false,
        ajax: {
            url: "/usuario/gestor/getgestor",
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
        },  {
            data: 'detail',
            name: 'detail',
            orderable: false,
        }, ],
    });

    $('#gestores_dinamizador_inactivos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": false,
        ajax: {
            url: "/usuario/gestor/getgestor/papelera",
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
        },  {
            data: 'detail',
            name: 'detail',
            orderable: false,
        }, ],
    });
});

var UserDinamizadorGestor = {
    downloadGestor: function(state){

        if(state !== null) {
            location.href = '/usuario/excel/gestor/'+ state;
        }else{
            Swal.fire({
                title: 'Error al descagar el archivo, intentalo de nuevo',
                confirmButtonText: 'Ok',

            });
        }
    },
}


