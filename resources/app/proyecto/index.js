$(document).ready(function() {
  consultarProyectosDelGestorPorAnho();
})
function consultarProyectosDelGestorPorAnho() {
  let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
  $('#tblproyectosGestorPorAnho').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/proyecto/datatableProyectosDelGestorPorAnho/"+0+"/"+anho,
      type: "get",
    },
    columns: [
      {
        data: 'codigo_proyecto',
        name: 'codigo_proyecto',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'sublinea_nombre',
        name: 'sublinea_nombre',
      },
      {
        data: 'estado_nombre',
        name: 'estado_nombre',
      },
      {
        data: 'revisado_final',
        name: 'revisado_final',
      },
      {
        data: 'talentos',
        name: 'talentos',
        orderable: false
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
      {
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
    ],
  });
}
