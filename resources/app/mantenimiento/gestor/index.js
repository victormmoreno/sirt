$(document).ready(function() {
    $('#mantenimientosequipos_gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/mantenimientos",
            type: "get",
        },
        columns: [{
            data: 'nombrelinea',
            name: 'nombrelinea',
            width: '30%'
        }, {
            data: 'equipo_nombre',
            name: 'equipo_nombre',
            width: '30%'
        }, {
            data: 'anio_mantenimiento',
            name: 'anio_mantenimiento',
            width: '15%'
        }, {
            data: 'valor_mantenimiento',
            name: 'valor_mantenimiento',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        }, ],
    });
});