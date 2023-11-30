$(document).on('submit', 'form#formValidateCredentials', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (response) {
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            if (response.fail) {
                for (control in response.errors) {
                    $('#' + control + '-error').html(response.errors[control]);
                    $('#' + control + '-error').show();
                }
                printErroresFormulario(response);
            }else{
                if (response.data.user) {
                    Swal.fire({
                        title: 'Atención!',
                        html: 'Este usuario ya existe. Por favor ingrese utilizando las credenciales de usuario. Recuerde que si no recuerda su contraseña también la puede restablecer.',
                        icon: 'error',
                        position: 'top',
                        toast: true,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        timer: 10000,
                        timerProgressBar: true,
                    });
                }else{
                    $('#modalvalidationuser').closeModal();
                    $('#documento').val(data.get('document'));
                    $("label[for='documento']").addClass('active');
                    $("#tipo_documento option[value='" +data.get("document_type") + "']").attr("selected",true);
                    $("#tipo_documento").val(data.get("document_type"));
                    $("#tipo_documento option[value='"+ data.get('document_type') +"']").addClass("active selected",true);
                    $('#tipo_documento').material_select();
                }
            }
        }
    });
});
