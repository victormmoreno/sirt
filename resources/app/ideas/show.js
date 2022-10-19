function confirmacionAceptacionPostulacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aceptar la postulación de esta idea de proyecto?',
    input: 'textarea',
    inputPlaceholder: 'Puedes dejar algunas observaciones para el talento',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Se necesitan unas observaciones!'
      } else {
        $('#txtobservacionesAceptacion').val(value);
      }
    },
    inputAttributes: {
      maxlength: 2100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        document.frmAceptarPostulacionIdea.submit();
        // window.location.href = "{{ route('idea.aceptar.postulacion', $idea->id) }}";
      }
    })
  }

  function confirmacionRechazoPostulacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de devolver la postulación de esta idea de proyecto?',
    input: 'textarea',
    inputPlaceholder: 'Por favor, escriba los motivos por los cuales se está devolviendo la postulación de la idea de proyecto',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Los motivos por los cuales se devuelve la idea deben ser obligatorios!'
      } else {
        $('#txtmotivosRechazo').val(value);
      }
    },
    inputAttributes: {
      maxlength: 2100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
      if (result.value) {
        document.frmRechazarPostulacionIdea.submit();
      }
    })
  }