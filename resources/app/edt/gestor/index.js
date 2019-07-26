$(document).ready(function() {
  consultarEdtsDeUnGestor(0);
})


// Ajax que muestra los proyectos de un gestor por año
function consultarEdtsDeUnGestor(id) {
  // console.log('event');
  // let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
  // let gestor = $('#txtgestor_id').val();
  $('#edtPorGestor_table').dataTable().fnDestroy();
  $('#edtPorGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/edt/consultarEdtsDeUnGestor/"+id,
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'codigo_edt',
        name: 'codigo_edt',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'gestor',
        name: 'gestor',
      },
      {
        data: 'area_conocimiento',
        name: 'area_conocimiento',
      },
      {
        data: 'tipo_edt',
        name: 'tipo_edt',
      },
      {
        width: '8%',
        data: 'business',
        name: 'business',
        orderable: false
      },
      {
        width: '8%',
        data: 'details',
        name: 'details',
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
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
    ],
  });
}
