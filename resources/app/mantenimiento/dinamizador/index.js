$(document).ready(function() {
    $('#mantenimientosequipos_dinamizador_table').DataTable({
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
            data: 'lineatecnologica',
            name: 'lineatecnologica',
            width: '30%'
        }, {
            data: 'equipo',
            name: 'equipo',
            width: '30%'
        }, {
            data: 'ultimo_anio_mantenimiento',
            name: 'ultimo_anio_mantenimiento',
            width: '15%'
        }, {
            data: 'valor_mantenimiento',
            name: 'valor_mantenimiento',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        }, {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],
    });
});