$(document).ready(function() {

    $('#talentoByDinamizador_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
    });

    $('#talentoByDinamizador_inactivos_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
      });
  
  
  
  });
  
  var userTalentoByDinamizador = {
    consultarTalentosByTecnoparque: function (){
      let anho = $('#anio_proyecto_talento').val();
  
      $('#talentoByDinamizador_table').dataTable().fnDestroy();
        $('#talentoByDinamizador_table').DataTable({
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
        },  ],
        });
    },
    consultarTalentosByTecnoparqueTrash: function (){
        let anho = $('#anio_proyecto_talento').val();
    
        $('#talentoByDinamizador_inactivos_table').dataTable().fnDestroy();
          $('#talentoByDinamizador_inactivos_table').DataTable({
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
          },  ],
          });
      },
    getUserTalentosByGestor: function(){
      let anho = $('#txtanho_user_talento').val();
      let gestor = $('#txtgestor_id').val();
  
      if(gestor == '' || gestor == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un gestor',
          'error'
        );
      }else if(anho == '' || anho == null){
        Swal.fire(
          'Error',
          'Por favor selecciona un gestor',
          'error'
        );
      }else{
        $('#talentoByGestor_table').dataTable().fnDestroy();
        $('#talentoByGestor_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          "lengthChange": false,
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/usuario/getuserstalentosbygestordatatables/"+gestor+"/"+anho,
            
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
    getUserTalentosByGestorTrash: function(){
        let anho = $('#txtanho_user_talento').val();
        let gestor = $('#txtgestor_id').val();
    
        if(gestor == '' || gestor == null){
          Swal.fire(
            'Error',
            'Por favor selecciona un gestor',
            'error'
          );
        }else if(anho == '' || anho == null){
          Swal.fire(
            'Error',
            'Por favor selecciona un gestor',
            'error'
          );
        }else{
          $('#talentoByGestor_inactivos_table').dataTable().fnDestroy();
          $('#talentoByGestor_inactivos_table').DataTable({
            language: {
              "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            order: [ 0, 'desc' ],
            ajax:{
                url: "/usuario/getuserstalentosbygestordatatables/papelera/"+gestor+"/"+anho,
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
    }
  }
  