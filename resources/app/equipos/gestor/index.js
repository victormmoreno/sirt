$(document).ready(function() {
    $('#equipo_tecnoparque_gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
       	processing: true,
        serverSide: true,
        ajax: {
            url: "/equipos",
            type: "get",
        },
        columns: [{
            data: 'nombrelinea',
            name: 'nombrelinea',
            width: '30%'
        }, {
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'referencia',
            name: 'referencia',
            width: '15%'
        }, {
            data: 'marca',
            name: 'marca',
            width: '15%'
        },
        {
            data: 'costo_adquisicion',
            name: 'costo_adquisicion',
            width: '15%'
        },
        {
            data: 'vida_util',
            name: 'vida_util',
            width: '15%'
        },
        {
            data: 'anio_compra',
            name: 'anio_compra',
            width: '15%'
        },
        {
            data: 'anio_fin_depreciacion',
            name: 'anio_fin_depreciacion',
            width: '15%'
        },
        {
            data: 'depreciacion_por_anio',
            name: 'depreciacion_por_anio',
            width: '15%'
        },
         ],

    });
});