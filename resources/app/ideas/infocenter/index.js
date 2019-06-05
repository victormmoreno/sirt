$(document).ready(function() {
    $('#ideas_emprendedores_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
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

        ],
    });




});
