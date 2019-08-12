$(document).ready(function() {
    $('#nodos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": true,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            text: 'copiar',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'csv',
        
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'excel',
        
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdf',
        
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'print',
        
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'colvis',
        
            exportOptions: {
                columns: ':visible'
            }
        },
    ],
        ajax: {
            url: "/nodo",
        },
        columns: [{
            data: 'centro',
            name: 'centro',
        }, {
            data: 'nodos',
            name: 'nodos',
        }, {
            data: 'direccion',
            name: 'direccion',
        }, {
            data: 'ubicacion',
            name: 'ubicacion',
        }, {
            data: 'detail',
            name: 'detail',
            orderable: false
        }, {
            data: 'edit',
            name: 'edit',
            orderable: false
        }, ],
    });
});