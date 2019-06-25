$(document).ready(function() {

	$('#sublineas_table').DataTable({
        language: {
           
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: "/sublineas",
            type: "get",
        },
        columns: [
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
        	{
        		data: 'linea',
        		name: 'linea',
        	},
            {
                data: 'edit',
                name: 'edit',
                orderable: false,
            },

        ],
    });
});