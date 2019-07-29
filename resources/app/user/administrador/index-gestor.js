$(document).ready(function() {
    $('#gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
    });
    // $('.dataTables_length select').addClass('browser-default');
});
var UserAdministradorGestor = {
    selectGestoresPorNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#gestor_table').dataTable().fnDestroy();
        $('#gestor_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax: {
                url: "/usuario/gestor/getGestor/" + nodo,
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