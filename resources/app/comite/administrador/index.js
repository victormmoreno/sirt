// Ajax para consultar los comités de un nodo y mostrarlos en la tabla
function consultarCsibtPorNodo() {
  let id = $('#txtnodo').val();
  $('#comitesDelNodoAdministrador_table').dataTable().fnDestroy();
  $('#comitesDelNodoAdministrador_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "/csibt/"+id+"/consultarCsibtPorNodo",
      type: "get",
    },
    columns: [
      {
        data: 'codigo',
        name: 'codigo',
      },
      {
        data: 'fechacomite',
        name: 'fechacomite',
      },
      {
        data: 'observaciones',
        name: 'observaciones',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },

    ],
  });
}
