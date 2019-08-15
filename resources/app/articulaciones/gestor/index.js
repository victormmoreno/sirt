$(document).ready(function() {
  $('#articulacionesGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/articulacion/datatableArticulacionesDelGestor/"+0,
      type: "get",
    },
    columns: [
      {
        data: 'codigo_articulacion',
        name: 'codigo_articulacion',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'tipo_articulacion',
        name: 'tipo_articulacion',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        data: 'revisado_final',
        name: 'revisado_final',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
});
