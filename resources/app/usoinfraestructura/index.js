$(document).ready(function() {

    $('#usoinfraestructura_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });
    
});

var usoinfraestructuraIndex = {
    selectProyectListDatatables: function (){
        let proyecto = $('#selecProyecto').val();
        $('#usoinfraestructura_table').dataTable().fnDestroy();
        if (proyecto != '') {
            $('#usoinfraestructura_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                ajax: {
                    url: "/usoinfraestructura/projectsforuser/" + proyecto,
                    type: "get",
                },
                columns: [{
                            data: 'fecha',
                            name: 'fecha',
                        },  {
                            data: 'actividad',
                            name: 'actividad',
                        }, {
                            data: 'fase',
                            name: 'fase',
                        },
                        {
                            data: 'asesoria_directa',
                            name: 'asesoria_directa',
                        }, {
                            data: 'asesoria_indirecta',
                            name: 'asesoria_indirecta',
                        },{
                            data: 'detail',
                            name: 'detail',
                            orderable: false,
                        },],    
                });
            }else{
                $('#usoinfraestructura_table').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "lengthChange": false
                }).clear().draw();
            }
        }
        
}