$(document).ready(function() {
    $('#dinamizador_table_activos').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });

    $('#dinamizador_table_inactivos').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });



});
var UserAdministradorDinamizador = {
    selectDinamizadoresPorNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#dinamizador_table_activos').dataTable().fnDestroy();
        if (nodo != '') {
            $('#dinamizador_table_activos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usuario/dinamizador/getDinamizador/" + nodo,
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
            $('#dinamizador_table_activos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },
    selectDinamizadoresPorNodoTrash: function() {
        let nodo = $('#selectnodo').val();
        $('#dinamizador_table_inactivos').dataTable().fnDestroy();
        if (nodo != '') {
            $('#dinamizador_table_inactivos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usuario/dinamizador/getDinamizador/papelera/" + nodo,
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
            $('#dinamizador_table_inactivos').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },

    downloadDinamizador: function(state){

        let nodo = $('#selectnodo').val();
        if(nodo == null || nodo == 0){
            Swal.fire({
                title: 'Por favor selecciona un nodo',

                confirmButtonText: 'Ok',
            });
        }else if(state !== null && (nodo !== null || nodo !== 0)) {
            location.href = '/usuario/excel/dinamizador/'+ state+'/'+nodo;
        }else{
            Swal.fire({
                title: 'Error al descagar el archivo, intentalo de nuevo',
                confirmButtonText: 'Ok',

            });
        }
    },
    downloadAllDinamizador:function (state){
        location.href = '/usuario/excel/dinamizador/'+ state;
    }
}


