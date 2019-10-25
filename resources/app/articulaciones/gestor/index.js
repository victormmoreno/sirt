function consultarArticulacionesDelGestor(anho) {
  $('#articulacionesGestor_table').dataTable().fnDestroy();
  $('#articulacionesGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: "/articulacion/datatableArticulacionesDelGestor/"+0+"/"+anho,
      // type: "get",
      data: function (d) {
        d.codigo_articulacion = $('#codigo_articulacion_GestorTable').val(),
        d.nombre = $('#nombre_GestorTable').val(),
        d.tipo_articulacion = $('#tipo_articulacion_GestorTable').val(),
        d.estado = $('#estado_GestorTable').val(),
        d.search = $('input[type="search"]').val()
      }
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
}

$("#codigo_articulacion_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});

$("#nombre_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});

$("#tipo_articulacion_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});

$("#estado_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});
