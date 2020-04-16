$(document).ready(function() {
  
  $('#talento_activosByGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    "lengthChange": false,
  });

  $('#talento_inactivosByGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    "lengthChange": false,
  });


});

// Ajax que muestra los usuarios talentos con proyectos  por año de un determinado gestor
function consultarTalentosByGestor() {
    
    let anho = $('#anio_proyecto_talento').val();

    $('#talento_activosByGestor_table').dataTable().fnDestroy();
    $('#talento_activosByGestor_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/usuario/getuserstalentosbydatatables/"+anho,
      },
      columns: [{
        data: 'tipodocumento',
        name: 'tipodocumento',
    }, {
        data: 'documento',
        name: 'documento',
    }, {
        data: 'nombre',
        name: 'nombre',
    }, {
        data: 'email',
        name: 'email',
    }, {
        data: 'celular',
        name: 'celular',
    },  {
        data: 'detail',
        name: 'detail',
        orderable: false,
    }, ],
    });
  }

  function consultarTalentosByGestorTrash() {
    
    let anho = $('#anio_proyecto_talento').val();

    $('#talento_inactivosByGestor_table').dataTable().fnDestroy();
    $('#talento_inactivosByGestor_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/usuario/getuserstalentosbydatatables/papelera/"+anho,
      },
      columns: [{
        data: 'tipodocumento',
        name: 'tipodocumento',
    }, {
        data: 'documento',
        name: 'documento',
    }, {
        data: 'nombre',
        name: 'nombre',
    }, {
        data: 'email',
        name: 'email',
    }, {
        data: 'celular',
        name: 'celular',
    },  {
        data: 'detail',
        name: 'detail',
        orderable: false,
    }, ],
    });   
}
var UserTalentoByGestor = {
    downloadTalento: function(state){

        let anio = $('#anio_proyecto_talento').val();
        if(anio == null || anio == 0){
            Swal.fire({
                title: 'Por favor selecciona un año',

                confirmButtonText: 'Ok',
            });
        }else if(state !== null &&(anio !== null || anio !== 0)) {
            let nodo = 0;
            location.href = '/usuario/excel/talento/'+ state+'/'+nodo+'/'+anio;
        }else{
            Swal.fire({
                title: 'Error al descagar el archivo, intentalo de nuevo',
                confirmButtonText: 'Ok',

            });
        }
    },
}

  
  
 