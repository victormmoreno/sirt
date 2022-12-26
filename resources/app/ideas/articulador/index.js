function consultarIdeasEnviadasAlNodo () {
    $('#tbl_IdeasEnviadasDelNodo').dataTable().fnDestroy();
    $('#tbl_IdeasEnviadasDelNodo').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: host_url + "/idea/datatableIdeasDeTalentos/",
      },
      columns: [
        {
            width: '15%',
            data: 'codigo_idea',
            name: 'codigo_idea',
        },
        {
            data: 'nombre_proyecto',
            name: 'nombre_proyecto',
        },
        {
            data: 'nombre_talento',
            name: 'nombre_talento',
        },
        {
            data: 'estado',
            name: 'estado',
        },
        {
            width: '8%',
            data: 'info',
            name: 'info',
            orderable: false
        },
        // {
        //     width: '8%',
        //     data: 'edit',
        //     name: 'edit',
        //     orderable: false
        // },
      ],
    });
}