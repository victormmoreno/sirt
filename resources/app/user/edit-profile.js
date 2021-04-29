$(document).on('submit', 'form#formEditProfile', function (event) {
    // $('button[type="submit"]').prop("disabled", true);
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
    
          $('button[type="submit"]').removeAttr('disabled');
          $('button[type="submit"]').prop("disabled", false);
          $('.error').hide();
          if (data.fail) {
  
            for (control in data.errors) {
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
  
            EditProfileUser.printErroresFormulario(data);
          }
          if (data.state == 'error') {
            Swal.fire({
              title: 'Tu perfil no se ha modificado, por favor inténtalo de nuevo',
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
                window.location.href = data.url;
              }, 1000);
          }
          if (data.state == 'success') {
            Swal.fire({
              title: 'Modifciación Exitosa',
              text: `Tu perfil ha sido actualizado exitosamente.`,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.href = data.url;
            }, 1000);
          }
        },
        
      });
});




var EditProfileUser = {
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