$(document).ready(function() {
    $('#equipos_de_tecnoparque_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        "lengthChange": false,
    });

});

var selectEquipoPorNodo = {
    selectEquipoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#equipos_de_tecnoparque_administrador_table').dataTable().fnDestroy();
        if (nodo != '') {
            
            $('#equipos_de_tecnoparque_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                 fixedHeader: {
                    header: true,
                    footer: true
                },
                "pagingType": "full_numbers",
                ajax: {
                    url: "/equipos/getequipospornodo/" + nodo,
                    type: "get",
                },
                columns: [{
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '30%'
                }, {
                    data: 'nombre',
                    name: 'nombre',
                    width: '30%'
                }, {
                    data: 'referencia',
                    name: 'referencia',
                    width: '15%'
                }, {
                    data: 'marca',
                    name: 'marca',
                    width: '15%'
                },
                {
                    data: 'costo_adquisicion',
                    name: 'costo_adquisicion',
                    width: '15%'
                },
                {
                    data: 'vida_util',
                    name: 'vida_util',
                    width: '15%'
                },
                {
                    data: 'horas_uso_anio',
                    name: 'horas_uso_anio',
                    width: '15%'
                },
                {
                    data: 'anio_compra',
                    name: 'anio_compra',
                    width: '15%'
                },
                
                {
                    data: 'anio_fin_depreciacion',
                    name: 'anio_fin_depreciacion',
                    width: '15%'
                },
                {
                    data: 'depreciacion_por_anio',
                    name: 'depreciacion_por_anio',
                    width: '15%'
                },],
            });


        }else{
            $('#equipos_de_tecnoparque_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
        
    },
}
