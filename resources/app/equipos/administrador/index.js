$(document).ready(function() {
    $('#equipos_de_tecnoparque_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        // dom: 'Bfrtip',
        // buttons: [
        //     {
        //         text:      '<i class="fa fa-files-o"></i>',
        //         titleAttr: 'EXCEL',
        //         className: 'waves-effect waves-light btn',
        //         action: function ( e, dt, node, config ) {
        //             alert( 'Button activated' );
        //         }
        //     },
        //     {
        //         text: 'PDF',
        //         className: 'waves-effect waves-light btn red',
        //         action: function ( e, dt, node, config ) {
        //             alert( 'Button activated' );
        //         }
        //     }
        // ],

    });

});
