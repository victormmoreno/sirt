$(document).ready(function() {
    $('#laboratorio_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
    });
    // $('.dataTables_length select').addClass('browser-default');
});
var selectLaboratorioNodo = {
    selectLaboraotrioForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#laboratorio_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#laboratorio_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: "/laboratorio/nodo/" + nodo,
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
                },
                {
                    data: 'estado',
                    name: 'estado',
                    width: '10%'
                },
                 {
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
        }else{
            $('#laboratorio_administrador_table').DataTable().clear().draw();
        }
        
    },
}