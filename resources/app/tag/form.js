$(document).on('submit', 'form#frmEtiquetas_Create', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormTag(form, data, url);
});

function ajaxSendFormTag(form, data, url) {
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
            mensajesTagForm(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesTagForm(data) {
    console.log(data);
    let title = "error";
    let text = "error";
    let type = "error";
    title = data.title;
    text = data.msg;
    type = data.type;
    
    if (data.state != 'error_form') {
        Swal.fire({
            title: title,
            html: text,
            type: type,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    }
    
    if (data.state == true) {
        setTimeout(function () {
            window.location.href = data.url;
        }, 1500);
    }

    // if (data.state == 'update') {
    //     setTimeout(function () {
    //         window.location.href = data.url;
    //     }, 5000);
    // }
};