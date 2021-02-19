function consultarIdeasDelTalento () {
    $('#tbl_IdeasDelTalento').dataTable().fnDestroy();
    $('#tbl_IdeasDelTalento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: "/idea/datatableIdeasDeTalentos/",
      },
      columns: [
        {
          width: '15%',
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        {
          data: 'nodo',
          name: 'nodo',
        },
        {
          data: 'nombre_proyecto',
          name: 'nombre_proyecto',
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
        {
          width: '8%',
          data: 'edit',
          name: 'edit',
          orderable: false
        },
      ],
    });
}