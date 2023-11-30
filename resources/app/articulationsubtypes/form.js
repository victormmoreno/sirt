$("#formArticualtionSubtype").on('submit', function(e){
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
        },
        success: function(response){
            $('.error').hide();
            $('button[type="submit"]').removeAttr('disabled');
            printErrorsForm(response);
            if(!response.fail && response.errors == null){
                Swal.fire({
                    title: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });
                setTimeout(function () {
                    window.location.href = response.redirect_url;
                }, 1500);
            }
        },
        error: function (ajaxContext) {
            Swal.fire({
                title: ' Registro erróneo, vuelve a intentarlo',
                html: ajaxContext.status + ' - ' + ajaxContext.responseJSON.message,
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
            });
        }
    });
});
