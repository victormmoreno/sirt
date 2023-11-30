$(document).on('submit', 'form#frmMantenimientoEquipo', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormMantenimiento(form, data, url);
});

$(document).on('submit', 'form#frmMantenimientoEquipoEdit', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormMantenimiento(form, data, url);
});

function ajaxSendFormMantenimiento(form, data, url) {
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
            if (data.state != 'error_form') {
                mensajesFormMantenimiento(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesFormMantenimiento(data) {
    if (data.state) {
        Swal.fire({
            title: data.title,
            text: data.msj,
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    } else {
        Swal.fire({
            title: data.title,
            text: data.msj,
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

var mantenimiento = {
    getEquipoPorLinea:function(){
        let lineatecnologica = $('#txtlineatecnologica').val();
        let nodo = $('#txtnodo_id').val();
        if (!isset(nodo)) {
            nodo = 0;
        }
        if (!isset(lineatecnologica)) {
            lineatecnologica = 0;
        }
        $.ajax({
            dataType:'json',
            type:'get',
            url: host_url + '/equipos/getequiposporlinea/'+nodo+'/'+lineatecnologica
        }).done(function(response){
            $('#txtequipo').empty();
            if (response.equipos == '' && response.equipos.length == 0) {
                $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
            }else{
                $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                $.each(response.equipos, function(i, e) {
                    $('#txtequipo').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                });
            }
            $('#txtequipo').select2();
        });
    },
}

function getEquipoPorLineaEdit(nodo, linea, equipo){
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + '/equipos/getequiposporlinea/'+nodo+'/'+linea
    }).done(function(response){
        $('#txtequipo').empty();
        if (response.equipos == '' && response.equipos.length == 0) {
            $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
        }else{
            $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
            $.each(response.equipos, function(i, e) {
                if (e.id == equipo) {
                    $('#txtequipo').append('<option selected value="'+e.id+'">'+e.nombre+'</option>');
                } else {
                    $('#txtequipo').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                }
            });
        }
        $('#txtequipo').select2();
    });
}

function consultarLineasNodoMantenimiento(nodo_id, linea_id) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/lineas/getlineasnodo/"+nodo_id
    }).done(function(response){
        $("#txtlineatecnologica").empty();
        $('#txtlineatecnologica').append('<option value="">Seleccione la línea tecnológica</option>');
        $.each(response.lineasForNodo.lineas, function(i, e) {
            if (e.id == linea_id) {
                $('#txtlineatecnologica').append('<option value="'+e.id+'" selected>'+e.abreviatura+' - '+e.nombre+'</option>');
            } else {
                $('#txtlineatecnologica').append('<option value="'+e.id+'">'+e.abreviatura+' - '+e.nombre+'</option>');
            }
        })
        $('#txtlineatecnologica').select2();
    });
}

