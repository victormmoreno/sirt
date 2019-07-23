$(document).ready(function() {

  consultarIdeasEmprendedoresPorNodo(0);
  consultarIdeasEmpresasGIPorNodo(0);
  consultaIdeasEmprendedoresTodosPorNodo(0);

});

function consultaIdeasEmprendedoresTodosPorNodo(idNodo) {
  $('#tbl_TodasLasIdeasDeProyecto').dataTable().fnDestroy();
  $('#tbl_TodasLasIdeasDeProyecto').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: "/idea/consultarIdeasTodosPorNodo/"+idNodo,
      type: "get",
    },
    columns: [
      { data: 'codigo_idea', name: 'codigo_idea' },
      { data: 'fecha_registro', name: 'fecha_registro' },
      { data: 'persona', name: 'persona' },
      { data: 'correo', name: 'correo' },
      { data: 'contacto', name: 'contacto' },
      { data: 'nombre_idea', name: 'nombre_idea' },
      { data: 'fecha_sesion1', name: 'fecha_sesion1' },
      { data: 'fecha_sesion2', name: 'fecha_sesion2' },
      { data: 'fecha_comite', name: 'fecha_comite' },
      { data: 'hora', name: 'hora' },
      { data: 'admitido', name: 'admitido' },
    ],
  });
}
