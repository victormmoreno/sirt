$(document).on('submit', 'form#formValidateCredentials', function (event) {

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
        success: function (response) {
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            if (response.fail) {
                
                for (control in response.errors) {
                    $('#' + control + '-error').html(response.errors[control]);
                    $('#' + control + '-error').show();
                }
                verificationUser.printErroresFormulario(response);
            }else{
                if (response.data.user) {
                
                    Swal.fire({
                        title: 'Atención!',
                        html: 'Este usuario ya existe. Por favor ingrese utilizando las credenciales de usuario. Recuerde que si no recuerda su contraseña también la puede restablecer.',
                        type: 'error',
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
                    $('#txtdocumento').val(data.get('document'));
                    $("label[for='txtdocumento']").addClass('active');
                    $("#txttipo_documento option[value='"+ data.get('document_type') +"']").addClass("active selected",true);
                    $('#txttipo_documento').material_select();
                    
                }
                
            }
            
        }
    });
});

var verificationUser = {
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
