var EmpresaCreate = {
    getCiudad: function() {
        let id;
        id = $('#txtdepartamento_empresa').val();
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/usuario/getciudad/' + id
        }).done(function(response) {
            $('#txtciudad_id_empresa').empty();
            $('#txtciudad_id_empresa').append('<option value="">Seleccione la Ciudad</option>')
            $.each(response.ciudades, function(i, e) {
                $('#txtciudad_id_empresa').append('<option  value="' + e.id + '">' + e.nombre + '</option>');
            })
            $('#txtciudad_id_empresa').material_select();
        });
    },
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
        if (data.fail) {
            
        for (control in data.errors) {
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
        }
        EmpresaCreate.printErroresFormulario(data);
        }
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
            if (data.fail) {

                for (control in data.errors) {
                    $('#' + control + '-error').html(data.errors[control]);
                    $('#' + control + '-error').show();
                }
                EmpresaCreate.printErroresFormulario(data);
            }
            if (data.state == 'error' && data.url == false) {
                Swal.fire({
                    title: 'La empresa no se ha modificado, por favor inténtalo de nuevo',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }
            if (data.state == 'success' && data.url != false) {
                Swal.fire({
                    title: 'Modifciación Exitosa',
                    text: `La empresa ha sido modificado satisfactoriamente`,
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
        // error: function (xhr, textStatus, errorThrown) {
        //   alert("Error: " + errorThrown);
        // }
    });
});