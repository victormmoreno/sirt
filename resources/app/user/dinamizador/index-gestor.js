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
            data: 'telefono',
            name: 'telefono',
        }, {
            data: 'estado',
            name: 'estado',
        }, {
            data: 'detail',
            name: 'detail',
            orderable: false,
        }, {
            data: 'edit',
            name: 'edit',
            orderable: false,
        }, ],
    });
});