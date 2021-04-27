function consultarIdeasDelTalento () {
    $('#tbl_IdeasDelTalento').dataTable().fnDestroy();
    $('#tbl_IdeasDelTalento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: "/idea/datatableIdeasDeTalentos/",
      },
      columns: [
        {
          width: '15%',
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        {
          width: '8%',
          data: 'nodo',
          name: 'nodo',
        },
        {
          data: 'nombre_proyecto',
          name: 'nombre_proyecto',
        },
        {
          data: 'estado',
          name: 'estado',
        },
        {
          width: '8%',
          data: 'info',
          name: 'info',
          orderable: false
        },
        {
          width: '8%',
          data: 'postular',
          name: 'postular',
          orderable: false
        },
        {
          width: '8%',
          data: 'edit',
          name: 'edit',
          orderable: false
        },
      ],
    });
}

function confirmacionPostulacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de postular esta idea de proyecto?',
  text: "Una vez que se postule la idea de proyecto, ya no se podrá cambiar los datos de esta.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmEnviarIdeaTalento.submit();
    }
  })
}

function confirmacionDuplicacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de duplicar esta idea de proyecto?',
  text: "Esto se recomienda hacer en caso de que se quiera continuar con el proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmDuplicarIdea.submit();
    }
  })
}

function confirmacionInhabilitar(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de inhabilitar esta idea de proyecto?',
  text: "Esto quiere decir que esta idea de proyecto no se le podrá realizar un proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmInhabilitarIdea.submit();
    }
  })
}