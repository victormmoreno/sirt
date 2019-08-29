$(document).ready(function() {
    $('#linea_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "lineas",
        },
        columns: [{
            data: 'abreviatura',
            name: 'abreviatura',
        }, {
            data: 'nombre',
            name: 'nombre',
        }, {
            data: 'descripcion',
            name: 'descripcion',
        }, {
            data: 'action',
            name: 'action',
            orderable: false
        }, ],
    });
});