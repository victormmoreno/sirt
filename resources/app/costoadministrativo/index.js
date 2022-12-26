var selectCostoAdministrativoNodo = {
	selectCostoAdministrativoNodo: function(rol, nodo_id) {
        let nodo = null;
        if (rol == 'Administrador' || rol == 'Activador') {
            nodo = $('#selectnodo').val();
            $('#costoadministrativo_administrador_table').dataTable().fnDestroy();
        } else {
            nodo = nodo_id;
        }
        if (nodo != '') {
            $('#costoadministrativo_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                "order": [[ 1, "asc" ]],
                fixedHeader: {
                    header: true,
                    footer: true
                },

                "pagingType": "full_numbers",
                ajax: {
                    url: host_url + "/costos-administrativos/costoadministrativo/" + nodo,
                    type: "get",
                },
                columns: [
                    {
                        data: 'entidad',
                        name: 'entidad',
                        width: '30%'
                    }, {
                        data: 'costoadministrativo',
                        name: 'costoadministrativo',
                        width: '30%'
                    }, {
                        data: 'valor',
                        name: 'valor',
                        width: '15%'
                    },
                    {
                        data: 'costosadministrativospordia',
                        name: 'costosadministrativospordia',
                        width: '15%'
                    },
                    {
                        data: 'costosadministrativosporhora',
                        name: 'costosadministrativosporhora',
                        width: '15%'
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        width: '15%'
                    },
			    ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    totalCostosHora = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    totalCostosDia = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    totalCostosMes = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Total over this page
                    pageTotalCostosHora = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalCostosDia = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalCostosMes = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        '$ '+pageTotalCostosHora +' ( $'+ totalCostosHora +' total)'
                    );

                    $( api.column( 3 ).footer() ).html(
                        '$ '+pageTotalCostosDia +' ( $'+ totalCostosDia +' total)'
                    );

                    $( api.column( 2 ).footer() ).html(
                        '$ '+pageTotalCostosMes +' ( $'+ totalCostosMes +' total)'
                    );
                }
            });
        }else{
            $('#costoadministrativo_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
    },
}