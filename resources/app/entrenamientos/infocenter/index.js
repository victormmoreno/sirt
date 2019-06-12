$(document).ready(function() {
  $('#entrenamientos_nodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: "entrenamientos",
      type: "get",
    },
    columns: [
      {
        data: 'id',
        name: 'id',
      },
      {
        data: 'fecha_sesion1',
        name: 'fecha_sesion1',
      },
      {
        data: 'fecha_sesion2',
        name: 'fecha_sesion2',
      },
      {
        data: 'correos',
        name: 'correos',
      },
      {
        data: 'fotos',
        name: 'fotos',
      },
      {
        data: 'listado_asistencia',
        name: 'listado_asistencia',
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
        data: 'update_state',
        name: 'update_state',
        orderable: false
      },
    ],
  });
});

// function inhabilitarEntrenamientoPorId(id) {
//   $.ajax({
//      dataType:'json',
//      type:'get',
//      url:"entrenamientos/inhabilitarEntrenamiento/"+id,
//   }).done(function(respuesta){
//     // $("#ideasEntrenamiento").empty();
//     // if (respuesta != null ) {
//     //   $("#fechasEntrenamiento").empty();
//     //   $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Primera Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
//     //   $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha de la Segunda Sesion del Entrenamiento: </span>"+respuesta[0].fecha_sesion2+"");
//     //   $.each(respuesta, function(i, item) {
//     //     $("#ideasEntrenamiento").append("<tr><td>"+item.nombre_proyecto+
//     //       "</td><td>"+item.confirmacion+"</td><td>"+item.convocado+"</td><td>"+item.canvas+"</td><td>"+item.asistencia1+"</td><td>"+item.asistencia2+"</td></tr>");
//     //   });
//     //   $('#modalIdeasEntrenamiento').openModal();
//     // }
//   });
// }

function inhabilitarEntrenamientoPorId(id, e) {
  Swal.fire({
    title: '¿Desea inhabilitar elentrenamiento?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, inhabilitar'
  }).then((result) => {
    if (result.value) {
      console.log(result);
      Swal.fire({
        title: '¿Que desea hacer?',
        text: "Seleccione lo que ocurrirá con las ideas de proyecto que están asociasdas al entrenamiento",
        type: 'warning',
        footer: '<a onclick="Swal.close()" href="#">Cancelar</a>',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Inhabilitar las ideas',
        cancelButtonText: 'Regresar las ideas al estado de Inicio',
      }).then((result) => {

      })
    }
  })
  // e.preventDefault();
  //   {
  //     swal({
  //       title: "¿Desea inhabilitar elentrenamiento?",
  //       type: "warning",
  //       html: true,
  //       showCancelButton: true,
  //       confirmButtonColor: "#E57373",
  //       confirmButtonText: "Si",
  //       cancelButtonText: "Cancelar",
  //       closeOnConfirm: false
  //     },
  //     function(isConfirm){
  //       if (isConfirm) {
  //         $.ajax({
  //           url:"entrenamientos/inhabilitarEntrenamiento/"+id,
  //           dataType:'json',
  //           type:'get',
  //         }).done(function(response){
  //           setTimeout(function(){
  //           },1500 );
  //           if (response == true) {
  //             swal("Inhabilitar","La charla informativa se ha inhabilitado con éxito", "success");
  //             setTimeout(function(){
  //               window.location.href = uri + "charlas";
  //             },1500 );
  //           }
  //         }).fail(function(error) {
  //           swal("ups!!","El grupo de investigación no se ha inhabilitado.", "error");
  //         });
  //       } else {
  //         alert('Por otro lado');
  //       }
  //     });
  //   }
}
