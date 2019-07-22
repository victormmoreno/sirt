function consultarIdeasPorNodo() {
  let idNodo = $('#txtnodo').val();
  consultarIdeasEmprendedoresPorNodo(idNodo);
  consultarIdeasEmpresasGIPorNodo(idNodo);
}

function consultarIdeasEmprendedoresPorNodo(idNodo) {
  $('#ideasEmprendedoresPorNodo_table').dataTable().fnDestroy();
  $('#ideasEmprendedoresPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: "/idea/consultarIdeasEmprendedoresPorNodo/"+idNodo,
      type: "get",
    },
    columns: [
      {
        data: 'codigo_idea',
        name: 'codigo_idea',
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
      {
        data: 'details',
        name: 'details',
        orderable: false
      },

    ],
  });
}

function consultarIdeasEmpresasGIPorNodo(idNodo) {
  $('#ideasEmpresasGIPorNodo_table').dataTable().fnDestroy();
  $('#ideasEmpresasGIPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: "/idea/consultarIdeasEmpresasGIPorNodo/"+idNodo,
      type: "get",
    },
    columns: [
      {
        data: 'codigo_idea',
        name: 'codigo_idea',
      },
      {
        data: 'fecha_registro',
        name: 'fecha_registro',
      },
      {
        data: 'nit',
        name: 'nit',
      },
      {
        data: 'razon_social',
        name: 'razon_social',
      },
      {
        data: 'nombre_idea',
        name: 'nombre_idea',
      },
    ],
  });
}
