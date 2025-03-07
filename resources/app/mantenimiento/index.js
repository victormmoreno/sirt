$(document).ready(function() {
    // $('#mantenimientosequipos_table').DataTable({
    //     language: {
    //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    //     },
    //     "pagingType": "full_numbers",
    //     "lengthChange": false,
    // });
    selectMantenimientosEquiposPorNodo.selectMantenimientosEquipoForNodo();
});

var selectMantenimientosEquiposPorNodo = {
    selectMantenimientosEquipoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#mantenimientosequipos_table').dataTable().fnDestroy();
        if (!isset(nodo)) {
            nodo = 0;
        }
        $('#mantenimientosequipos_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            retrieve: true,
            "lengthChange": false,
             fixedHeader: {
                header: true,
                footer: true
            },
            "pagingType": "full_numbers",
            ajax: {
                url: host_url + "/mantenimientos/getmantenimientosequipospornodo/" + nodo,
                type: "get",
            },
            columns: [
                {
                    data: 'nodo',
                    name: 'nodo',
                    width: '30%'
                }, 
                {
                    data: 'lineatecnologica',
                    name: 'lineatecnologica',
                    width: '30%'
                }, 
                {
                    data: 'equipo',
                    name: 'equipo',
                    width: '30%'
                }, 
                {
                    data: 'ultimo_anio_mantenimiento',
                    name: 'ultimo_anio_mantenimiento',
                    width: '15%'
                }, 
                {
                    data: 'valor_mantenimiento',
                    name: 'valor_mantenimiento',
                    width: '15%'
                }, 
                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                }, 
                {
                    data: 'edit',
                    name: 'edit',
                    width: '15%'
                }, 
            ],
        });
        // if (nodo != '') {
            


        // }else{
        //     $('#mantenimientosequipos_table').DataTable({
        //         language: {
        //             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //         },
        //         "lengthChange": false,
        //         "pagingType": "full_numbers",
        //     }).clear().draw();
        // }
        
    },
}