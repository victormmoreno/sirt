$(document).ready(function() {
    $('#infocenter_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
    });
    // $('.dataTables_length select').addClass('browser-default');
});
var UserAdministradorInfocenter = {
    selectInfocentersForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#infocenter_table').dataTable().fnDestroy();
        $('#infocenter_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax: {
                url: "/usuario/infocenter/getinfocenter/" + nodo,
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
            }, ],
        });
    },
    
}