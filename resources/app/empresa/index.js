$(document).ready(function() {
    var datatableEmpresas = $('#empresasDeTecnoparque_tableNoGestor').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax:{
        url: "/empresa/datatableEmpresasDeTecnoparque",
        type: "get",
        },
        deferRender: true,
        columns: [
        {
            data: 'nit',
            name: 'nit',
        },
        {
            data: 'nombre_empresa',
            name: 'nombre_empresa',
        },
        {
            data: 'sector_empresa',
            name: 'sector_empresa',
        },
        {
            data: 'ciudad',
            name: 'ciudad',
        },
        {
            data: 'direccion',
            name: 'direccion',
        },
        {
            data: 'details',
            name: 'details',
            orderable: false
        },
        {
            data: 'edit',
            name: 'edit',
            orderable: false
        },
        ],
        initComplete: function () {
        this.api().columns().every( function () {
            var column = this;
            var select = $('<select><option value=""></option></select>')
            .appendTo( $(column.footer()).empty() )
            .on( 'change', function () {
            var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
            );

            column
            .search( val ? '^'+val+'$' : '', true, false )
            .draw();
            } );

            column.data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        },
    });
    $('#empresasDeTecnoparque_table').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax:{
        url: "/empresa/datatableEmpresasDeTecnoparque",
        type: "get",
        },
        columns: [
        {
            data: 'nit',
            name: 'nit',
        },
        {
            data: 'nombre_empresa',
            name: 'nombre_empresa',
        },
        {
            data: 'sector_empresa',
            name: 'sector_empresa',
        },
        {
            data: 'ciudad',
            name: 'ciudad',
        },
        {
            data: 'direccion',
            name: 'direccion',
        },
        {
            data: 'contacts',
            name: 'contacts',
            orderable: false
        },
        {
            data: 'details',
            name: 'details',
            orderable: false
        }
        ],
    });
});
var empresaIndex = {
    consultarDetallesDeUnaEmpresa:function(id){
        $.ajax({
        dataType:'json',
        type:'get',
        url:"/empresa/ajaxDetallesDeUnaEmpresa/"+id+"/"+'id'
        }).done(function(respuesta){
        $("#modalDetalleDeUnaEmpresaTecnoparque_titulo").empty();
        $("#modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa").empty();
        if (respuesta == null) {
            swal('Ups!!', 'Ha ocurrido un error', 'warning');
        } else {
            $("#modalDetalleDeUnaEmpresaTecnoparque_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>");
            $("#modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa").append("<div class='row'>"
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Nit de la Empresa: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.empresa.nit+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Nombre de la Empresa: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.empresa.entidad.nombre+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Dirección de la Empresa: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.empresa.direccion+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Ciudad de la Empresa: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.empresa.entidad.ciudad.nombre+'</span>'
            +'</div>'
            +'</div>'
            +'<div class="divider"></div>'
            +'<div class="row">'
            +'<div class="col s12 m6 l6">'
            +'<span class="cyan-text text-darken-3">Email de la Empresa: </span>'
            +'</div>'
            +'<div class="col s12 m6 l6">'
            +'<span class="black-text">'+respuesta.empresa.entidad.email_entidad+'</span>'
            +'</div>'
            +'</div>'
        );
        $('#detalleDeUnaEmpresaTecnoparque').openModal();
        }
    });
    },
}



