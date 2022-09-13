$('#check-all-nodes').click(function() {
    if ($(this).prop('checked')) {
        $('.filled-in-node').prop('checked', true);
    } else {
        $('.filled-in-node').prop('checked', false);
    }
});

$("#formTypeArticulation").on('submit', function(e){
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
            typeArticulacion.printErrors(response);
            if(!response.fail && response.errors == null){
                Swal.fire({
                    title: response.message,
                    type: 'success',
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
                title: 'Error, vuelve a intentarlo',
                html: ajaxContext.status + ' - ' + ajaxContext.responseJSON.message,
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
            });
        }
    });
});
