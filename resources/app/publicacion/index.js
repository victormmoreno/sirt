$(document).ready(function() {
  consultarPublicacionesOtros();
  consultarPublicacionesDesarrollador();
})

function consultarPublicacionesOtros() {
  $('#tblnovedades_Otros').dataTable().fnDestroy();
  $('#tblnovedades_Otros').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/publicacion/datatablePublicaciones",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        data: 'titulo',
        name: 'titulo',
      },
      {
        width: '8%',
        data: 'detalle',
        name: 'detalle',
        orderable: false
      },
    ],
  });
}

function consultarPublicacionesDesarrollador() {
  $('#tblnovedades_Desarrollador').dataTable().fnDestroy();
  $('#tblnovedades_Desarrollador').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/publicacion/datatablePublicaciones",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'codigo_publicacion',
        name: 'codigo_publicacion',
      },
      {
        // width: '15%',
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        data: 'titulo',
        name: 'titulo',
      },
      {
        data: 'role',
        name: 'role',
      },
      {
        width: '8%',
        data: 'detalle',
        name: 'detalle',
        orderable: false
      },
      {
        width: '8%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        width: '8%',
        data: 'update',
        name: 'update',
        orderable: false
      },
    ],
  });
}
