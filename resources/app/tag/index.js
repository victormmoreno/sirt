function consultarTagsTecnoparque(type) {
    $('#tags_table').dataTable().fnDestroy();
    let data = {
      type: type,
    }
    $('#tags_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: host_url + "/tag/tagsList?" + $.param(data),
        type: "get",
      },
      // ajax:{
      //   url: host_url + "/tag/tagsList",
      //       data: function (data) {
      //           data.type = type
      //       }
      //   },
      columns: [
        {
          width: '15%',
          data: 'type',
          name: 'type',
        },
        {
          width: '40%',
          data: 'name',
          name: 'name',
        },
        {
          data: 'state',
          name: 'state',
        },
        {
          data: 'edit',
          name: 'edit',
          orderable: false
        },
        {
          data: 'delete',
          name: 'delete',
          orderable: false
        },
      ],
    });
  }