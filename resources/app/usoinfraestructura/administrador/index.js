$(document).ready(function() {
    $('#usoinfraestructura_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });
});

var UsoInfraestructuraAdministrador = {
    selectUsoInfraestructuraPorNodo: function() {
        let nodo = $('#selectnodo').val();
        console.log(nodo);
        $('#usoinfraestructura_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            $('#usoinfraestructura_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/usoinfraestructura/usoinfraestructurapornodo/" + nodo,
                    type: "get",
                },
                columns: [{
                    data: 'fecha',
                    name: 'fecha',
                },  {
                    data: 'actividad',
                    name: 'actividad',
                }, {
                    data: 'asesoria_directa',
                    name: 'asesoria_directa',
                }, {
                    data: 'asesoria_indirecta',
                    name: 'asesoria_indirecta',
                },{
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                }, ],
            });
        }else{
            $('#usoinfraestructura_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false
            }).clear().draw();
        }
    },
}