$(document).ready(function() {
    $('#laboratorio_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "/laboratorio",
            type: "get",
        },
        columns: [{
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'lineatecnologica',
            name: 'lineatecnologica',
            width: '30%'
        }, {
            data: 'participacion_costos',
            name: 'participacion_costos',
            width: '15%'
        }, {
            data: 'estado',
            name: 'estado',
            width: '10%'
        }, {
            data: 'materiales',
            name: 'materiales',
            orderable: false,
            width: '8%'
        }, {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],
    });
});