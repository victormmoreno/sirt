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
        d.fase = $('#fase_GestorTable').val(),
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
        data: 'nombre_fase',
        name: 'nombre_fase',
      },
      {
        data: 'proceso',
        name: 'proceso',
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

$("#fase_GestorTable").keyup(function(){
  $('#articulacionesGestor_table').DataTable().draw();
});
