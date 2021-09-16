
    $("#formSupport").on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let data = new FormData($(this)[0]);
        let url = form.attr("action");
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.error').hide();
                $('#formSupport').css("opacity",".5");
            },
            success: function(response){
                $('.error').hide();
                printErrorsForm(response);
                if(!response.fail && response.errors == null){
                    Swal.fire({
                        title: 'Registro Exitoso',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                    // $('#formSupport')[0].reset();
                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 1500);
                }
            },
            error: function (ajaxContext) {
                Swal.fire({
                    title: 'Registro erróneo, vuelve a intentarlo',
                    html: ajaxContext.responseText,
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });
            }
        });
    });

function printErrorsForm(data) {
    if (data.fail) {
        let errores = "";
        for (control in data.errors) {
            errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
        }
        Swal.fire({
            title: 'Advertencia!',
            html: 'Estas ingresando mal los datos.',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    }
}
