$(document).ready(function() {
    $('#empresasDeTecnoparque_table').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax:{
        url: host_url + "/empresa/datatableEmpresasDeTecnoparque",
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
            data: 'details',
            name: 'details',
            orderable: false
        }
        ],
    });
});