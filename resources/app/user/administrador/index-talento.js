$(document).ready(function() {
    $('#talento_history_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/usuario/talento",
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