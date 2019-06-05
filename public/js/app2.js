$(document).ready(function() {
    
    $('#linea_table').DataTable({
        language: {
            // "sProcessing": "Procesando...",
            // "sLengthMenu": "Mostrar _MENU_ registros",
            // "sZeroRecords": "No se encontraron resultados",
            // "sEmptyTable": "Ningún dato disponible en esta tabla",
            // "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            // "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            // "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            // "sInfoPostFix": "",
            // "sSearch": "Buscar:",
            // "sUrl": "",
            // "sInfoThousands": ",",
            // "sLoadingRecords": "Cargando...",
            // "oPaginate": {
            //     "sFirst": "Primero",
            //     "sLast": "Último",
            //     "sNext": "Siguiente",
            //     "sPrevious": "Anterior"
            // },
            // "oAria": {
            //     "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            // }
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "lineas",
        },
        columns: [
        	{
        		data: 'abreviatura',
        		name: 'abreviatura',
        	},
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
        	{
        		data: 'descripcion',
        		name: 'descripcion',
        	},
        	{
        		data: 'action',
        		name: 'action',
        		orderable: false
        	},

        ],
    });


            

});


$(document).ready(function() {
<<<<<<< HEAD
    
    $('#nodos_table').DataTable({
        language: {
            // "sProcessing": "Procesando...",
            // "sLengthMenu": "Mostrar _MENU_ registros",
            // "sZeroRecords": "No se encontraron resultados",
            // "sEmptyTable": "Ningún dato disponible en esta tabla",
            // "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            // "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            // "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            // "sInfoPostFix": "",
            // "sSearch": "Buscar:",
            // "sUrl": "",
            // "sInfoThousands": ",",
            // "sLoadingRecords": "Cargando...",
            // "oPaginate": {
            //     "sFirst": "Primero",
            //     "sLast": "Último",
            //     "sNext": "Siguiente",
            //     "sPrevious": "Anterior"
            // },
            // "oAria": {
            //     "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            // }
=======
    $('#ideas_emprendedores_table').DataTable({
        language: {
>>>>>>> 8bcc5064af569d4172d238c0a3ae7a48356c5d39
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
<<<<<<< HEAD
        	url: "nodo",
        },
        columns: [
        	{
        		data: 'centro',
        		name: 'centro',
        	},
        	{
        		data: 'nodos',
        		name: 'nodos',
        	},
        	{
        		data: 'direccion',
        		name: 'direccion',
        	},
            {
                data: 'ubicacion',
                name: 'ubicacion',
            },
        	{
        		data: 'detail',
        		name: 'detail',
        		orderable: false
        	},
            {
                data: 'edit',
                name: 'edit',
                orderable: false
            },
=======
        	url: "idea",
          type: "get",
        },
        columns: [
        	{
        		data: 'consecutivo',
        		name: 'consecutivo',
        	},
        	{
        		data: 'fecha_registro',
        		name: 'fecha_registro',
        	},
        	{
        		data: 'persona',
        		name: 'persona',
        	},
        	{
        		data: 'correo',
        		name: 'correo',
        	},
        	{
        		data: 'contacto',
        		name: 'contacto',
        	},
        	{
        		data: 'nombre_idea',
        		name: 'nombre_idea',
        	},
        	{
        		data: 'estado',
        		name: 'estado',
        	},
        	// {
        	// 	data: 'action',
        	// 	name: 'action',
        	// 	orderable: false
        	// },
>>>>>>> 8bcc5064af569d4172d238c0a3ae7a48356c5d39

        ],
    });


<<<<<<< HEAD
            

});
=======


});
>>>>>>> 8bcc5064af569d4172d238c0a3ae7a48356c5d39
