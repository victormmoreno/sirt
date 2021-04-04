$(document).on('submit', 'form#formRegisterUser', function (event) {

    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: data,
      cache: false,
      contentType: false,
      dataType: 'json',
      processData: false,
      success: function (data) {
        $('button[type="submit"]').prop("disabled", false);
        $('.error').hide();
        if (data.fail) {
            
          for (control in data.errors) {
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
          }

          createUser.printErroresFormulario(data);
        }
        if (data.state == 'error' && data.url == false) {
          Swal.fire({
            title: 'El Usuario no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        }
        if (data.state == 'success' && data.url != false) {
          Swal.fire({
            title: 'Registro Exitoso',
            text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido creado satisfactoriamente`,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
            footer: '<p class="red-text">Hemos enviado un correo electrónico al  usuario ' + data.user.nombres + ' '+ data.user.apellidos+ ' con las credenciales de ingreso a la plataforma.</p>'
          });
          setTimeout(function(){
            window.location.href = data.url;
          }, 1000);
        }
      },
      // error: function (xhr, textStatus, errorThrown) {
      //   alert("Error: " + errorThrown);
      // }
    });
  });

var createUser = {
    printErroresFormulario: function (data){
        if (data.state == 'error_form') {
            let errores = "";
            for (control in data.errors) {
                errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
                $('#' + control + '-error').html(data.errors[control]);
                $('#' + control + '-error').show();
            }
            Swal.fire({
                title: 'Advertencia!',
                html: 'Estas ingresando mal los datos.' + errores,
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
        }
    }
}  