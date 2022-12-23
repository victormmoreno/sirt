$(document).on('submit', 'form#formRegisterCompany', function (event) {

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
        printErroresFormulario(data);
        if (data.state == 'error' && data.url == false) {
        Swal.fire({
            title: 'La empresa no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
        }
        if (data.state == 'success' && data.url != false) {
        Swal.fire({
            title: 'Registro Exitoso',
            text:  data.message,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
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

$(document).on('submit', 'form#formEditCompany', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formEditCompanyHq', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formAddCompanyHq', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'store') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formEditResponsable', function (event) {
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
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formSearchEmpresas', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    $('#empresas_encontradas').empty();
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
            if (data.empresas.length == 0) {
                $('#empresas_encontradas').append(`
                    <div class="row">
                        <ul class="collection with-header">
                            <li class="collection-header"><h5>No se encontraron empresas</h5></li>
                        </ul>
                    </div>
                `);
            } else {
                if (data.state == 'search') {
                    $('#empresas_encontradas').append(`<div class="row">`);
                        $.each( data.empresas, function( key, empresa ) {
                        let route = data.urls[key];
                        $('#empresas_encontradas').append(`
                            <ul class="collection">
                                <li class="collection-item"><h5>`+empresa.nit+` - `+empresa.nombre+`</h5></li>
                                <li class="collection-item"><a href=`+route+`>Ver detalles</a></li>
                            </ul>
                        `);
                    });
                    $('#empresas_encontradas').append(`</div>`);
                }
            }
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
        },
    });
});