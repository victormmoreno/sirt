$(document).ready(function() {
    $('#ingreso_table_activos').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false
    });

    $('#ingreso_table_inactivos').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false
    });
});
var UserAdministradorIngreso = {
    selectIngresoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#ingreso_table_activos').dataTable().fnDestroy();
        if (nodo != '') {
            $('#ingreso_table_activos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usuario/ingreso/getingreso/" + nodo,
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
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                },  ],
            });
        } else {
            $('#ingreso_table_activos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },

    selectIngresoForNodoTrash: function() {
        let nodo = $('#selectnodo').val();
        $('#ingreso_table_inactivos').dataTable().fnDestroy();
        if (nodo != '') {
            $('#ingreso_table_inactivos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usuario/ingreso/getingreso/papelera/" + nodo,
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
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                },  ],
            });
        } else {
            $('#ingreso_table_inactivos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },
}