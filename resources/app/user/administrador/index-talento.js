$(document).ready(function() {
  $('#talentoByDinamizador_table_activos').DataTable({
      language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
  });
  $('#talentoByDinamizador_table_inactivos').DataTable({
    language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    "lengthChange": false,
});
  

});
  
  var usuarios = {
    consultarTalentosByTecnoparque: function (){
      let anho = $('#txt_anio_user').val();
      let nodo = $('#txtnodo').val();

      if(nodo == '' || nodo == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un nodo',
          'error'
        );
      }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un año',
          'error'
        );
      }else{
        $('#talentoByDinamizador_table_activos').dataTable().fnDestroy();
        $('#talentoByDinamizador_table_activos').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usuario/getuserstalentosbynodo/"+nodo+"/"+anho,
            
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
        },  ],
        });
  
      }
      
      
      
    },

    consultarTalentosByTecnoparqueTrash: function (){
      let anho = $('#txt_anio_user').val();
      let nodo = $('#txtnodo').val();

      if(nodo == '' || nodo == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un nodo',
          'error'
        );
      }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un año',
          'error'
        );
      }else{
        $('#talentoByDinamizador_table_inactivos').dataTable().fnDestroy();
        $('#talentoByDinamizador_table_inactivos').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usuario/getuserstalentosbynodo/papelera/"+nodo+"/"+anho,
            
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
        },  ],
        });
      }      
    },
    downloadTalento: function(state){

        let nodo = $('#selectnodo').val();

        let anio = $('#txt_anio_user').val();
        if(nodo == null || nodo == 0){
            Swal.fire({
                title: 'Por favor selecciona un nodo',

                confirmButtonText: 'Ok',
            });
        }else if(nodo == null || nodo == 0){
            Swal.fire({
                title: 'Por favor selecciona un año',

                confirmButtonText: 'Ok',
            });
        }else if(state !== null && (nodo !== null || nodo !== 0) &&(anio !== null || anio !== 0)) {
            location.href = '/usuario/excel/talento/'+ state+'/'+nodo+'/'+anio;
        }else{
            Swal.fire({
                title: 'Error al descagar el archivo, intentalo de nuevo',
                confirmButtonText: 'Ok',

            });
        }
    },
    downloadAllTalentos:function (state){
        location.href = '/usuario/excel/talento/'+ state;
    }
    
  }
  
    
    