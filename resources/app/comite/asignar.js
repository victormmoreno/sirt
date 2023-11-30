$(document).on('submit', 'form#formComiteAsignarCreate', function (event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        text: "No podrás revertir estos cambios!",
        // text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los expertos puedes cambiar esta información",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteAsignar(form, data, url, 'create');
        }
    });
});

function confirmacionDuplicidad(e, route){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de duplicar esta idea de proyecto?',
    text: "Debes tener en cuenta que a partir de esta idea se va a registrar mas de un TRL.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        Swal.fire({
            title: 'Verificación. ¿Está seguro(a) de duplicar esta idea de proyecto?',
            text: "Esta acción no se podrá revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Continuar!'
            }).then((result) => {
              if (result.value) {
                  location.href = route;
              }
            })
      }
    })
  }

function ajaxSendFormComiteAsignar(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesComiteAsignarCreate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesComiteAsignarCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La asignación de ideas de proyecto del comité ha sido registrada satisfactoriamente",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/csibt");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'La asignación de ideas de proyecto del comité no se ha registrado, por favor inténtalo de nuevo',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};