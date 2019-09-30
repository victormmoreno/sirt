$(document).ready(function() {
    $('#costoadministrativo_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "pagingType": "full_numbers",
        dom: 'Bfrtip',
        buttons: [
            {
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'EXCEL',
                className: 'waves-effect waves-light btn',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            },
            {
                text: 'PDF',
                className: 'waves-effect waves-light btn red',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ],

    });

});

var selectCostoAdministrativoNodo = {
	selectCostoAdministrativoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#costoadministrativo_administrador_table').dataTable().fnDestroy();
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
                
    
                // "paging":   false,
                // "ordering": false,
                // "info":     false,
                // "dom": '<"top"i>rt<"bottom"flp><"clear">',
                // stateSave: true,
                // "scrollY":        "200px",
                // // "scrollCollapse": true,
                "pagingType": "full_numbers",
                ajax: {
                    url: "/costos-administrativos/costoadministrativo/" + nodo,
                    type: "get",
                },
                
 
         
                columns: [{
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
			    ],

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