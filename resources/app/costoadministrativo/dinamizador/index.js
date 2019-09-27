$(document).ready(function() {
    $('#costoadministrativo_dinamizador_table1').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
         retrieve: true,
       	processing: true,
        serverSide: true,
        ajax: {
            url: "/costos-administrativos",
            type: "get",
        },
        columns: [{
            data: 'entidad',
            name: 'entidad',
            width: '30%'
        }, {
            data: 'costoadministrativo',
            name: 'costoadministrativo',
            width: '30%'
        }, {
            data: 'valor',
            name: 'valor',
            width: '15%'
        }, {
            data: 'costosadministrativospordia',
            name: 'costosadministrativospordia',
            width: '15%'
        },
        {
            data: 'costosadministrativosporhora',
            name: 'costosadministrativosporhora',
            width: '15%'
        },
        {
            data: 'edit',
            name: 'edit',
            orderable: false,
            width: '8%'
        }, ],
    });
});