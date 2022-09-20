$(document).ready(function() {
    //var groupColumn = 0;
    var table = $('#articulation_data_table').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar Entradas _MENU_",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        lengthMenu: [
            [5, 10, -1],
            [5, 10, 'Todos'],
        ],
        autoWidth: false,
        columnDefs: [
            {
                targets: ['_all'],
                className: 'mdc-data-table__cell',
            },
        ],
        // columnDefs: [{ visible: false, targets: groupColumn }],
        // order: [[groupColumn, 'asc']],
        // displayLength: 25,
        // drawCallback: function (settings) {
        //     var api = this.api();
        //     var rows = api.rows({ page: 'current' }).nodes();
        //     var last = null;

        //     api
        //         .column(groupColumn, { page: 'current' })
        //         .data()
        //         .each(function (group, i) {
        //             if (last !== group) {
        //                 $(rows)
        //                     .eq(i)
        //                     .before('<tr class="group teal lighten-2"><td colspan="6">' + group + '</td><td><button class="waves-effect waves-light btn-large">Hola mundo</button></td></tr>');

        //                 last = group;
        //             }
        //         });
        // },

    });

    // Order by the grouping
    // $('#articulation_data_table tbody').on('click', 'tr.group', function () {
    //     var currentOrder = table.order()[0];
    //     if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
    //         table.order([groupColumn, 'desc']).draw();
    //     } else {
    //         table.order([groupColumn, 'asc']).draw();
    //     }
    // });
});
