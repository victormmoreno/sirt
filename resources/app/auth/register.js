
var user = {
    checkedTypeUser: function(){
        let tipousuario = $('input:radio[name=txttipousuario]:checked').val();
        if (tipousuario == "talento") {
            $(".talento").show();
            $(".contratista").hide();
        }else if(tipousuario == "contratista"){
            $(".contratista").show();
            $(".talento").hide();
        }else{
            $(".talento").show();
            $(".contratista").hide();
        }
    },
    getCiudadExpedicion:function(){
        let id;
        id = $('#txtdepartamentoexpedicion').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/usuario/getciudad/'+id
        }).done(function(response){
            $('#txtciudadexpedicion').empty();
            $.each(response.ciudades, function(i, e) {
                $('#txtciudadexpedicion').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
            });
            $('#txtciudadexpedicion').material_select();
        });
    },
    getOtraEsp:function (ideps) {
        let id = $(ideps).val();
        let nombre = $("#txteps option:selected").text();
        if (id == 42) {
            $('.otraeps').removeAttr("style");
        }else{
            $('.otraeps').attr("style","display:none");
        }
    },
    getCiudad:function(){
        let id;
        id = $('#txtdepartamento').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/usuario/getciudad/'+id
        }).done(function(response){
            $('#txtciudad').empty();
            $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
            $.each(response.ciudades, function(i, e) {
                $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
            });
            $('#txtciudad').material_select();
        });
    },
    getGradoDiscapacidad(gradodiscapacidad){
        let grado = $(gradodiscapacidad).val();
        if (grado == 1) {
            $('.gradodiscapacidad').removeAttr("style");
        }else{
            $('.gradodiscapacidad').attr("style","display:none");
        }
    },
    getOtraOcupacion:function (idocupacion) {
        $('#otraocupacion').hide();
        let id = $(idocupacion).val();
        let nombre = $("#txtocupaciones option:selected").text();
        let resultado = nombre.match(/[A-Z][a-z]+/g);
        $('#otraocupacion').hide();
        if (resultado != null) {
            if (resultado.includes('Otra')) {
                $('#otraocupacion').show();
            }
        }
    }
}

var tipoTalento = {
    getSelectTipoTalento:function (tipotal) {
        let valor = $(tipotal).val();
        let nombreTipoTalento = $("#txttipotalento option:selected").text();
        
        if(valor == 1 || valor == 2){
            tipoTalento.showAprendizSena();
        }
        else if(valor == 3){
            tipoTalento.showEgresadoSena();
        }
        else if(valor == 4){
            tipoTalento.showInstructorSena();
        }
        else if(valor == 5){
            tipoTalento.showFuncionarioSena();
        }
        else if(valor == 6){
            tipoTalento.showPropietarioEmpresa();
        }
        else if(valor == 7){
            tipoTalento.showEmprendedor();
        }
        else if(valor == 8){
            tipoTalento.showUniversitario();
        }
        else if(valor == 9){
            tipoTalento.showFuncionarioEmpresa();
        }
        else{
            tipoTalento.ShowSelectTipoTalento();
        }
    },

    showAprendizSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".aprendizSena").css("display", "block");
        $(".aprendizSena").show();

    },
    showEgresadoSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".egresadoSena").show();

    },
    showInstructorSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".instructorSena").css("display", "block");

    },
    showFuncionarioSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".funcionarioSena").css("display", "block");

    },
    showPropietarioEmpresa: function (){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $('.otherUser').empty();
        $('.otherUser').append(`<div class="valign-wrapper" >
            <h5> Seleccionaste Propietario empresa</h5>
        </div>`);
    },
    showEmprendedor: function (){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $('.otherUser').empty();
        $('.otherUser').append(`<div class="valign-wrapper" >
            <h5> Seleccionaste Emprendedor</h5>
        </div>`);
    },
    showUniversitario: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideFuncionarioEmpresa();
        $(".universitario").css("display", "block");
    },
    showFuncionarioEmpresa: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideUniversitario();
        tipoTalento.hideEmprendedor();
        $(".funcionarioEmpresa").css("display", "block");
    },
    hideAprendizSena: function(){
        $(".aprendizSena").hide();
    },
    hideEgresadoSena: function(){
        $(".egresadoSena").hide();
    },
    hideInstructorSena: function(){
        $(".instructorSena").css("display", "none");
    },
    hideFuncionarioSena: function(){
        $(".funcionarioSena").css("display", "none");
    },
    hideSelectTipoTalento: function(){
        $(".selecttipotalento").css("display", "none");
    },
    hidePropietarioEmpresa: function(){
        $(".otherUser").css("display", "none");
    },
    hideUniversitario: function(){
        $(".universitario").css("display", "none");
    },
    hideFuncionarioEmpresa: function(){
        $(".funcionarioEmpresa").css("display", "none");
    },

    hideEmprendedor: function(){

        $(".otherUser").css("display", "none");
    },
    ShowSelectTipoTalento: function(){
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hidePropietarioEmpresa();
        $(".selecttipotalento").css("display", "block");
    },
    getCentroFormacionAprendiz:function (){
        let regional = $('#txtregional_aprendiz').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_aprendiz').empty();
            $('#txtcentroformacion_aprendiz').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_aprendiz').append('<option  value="'+id+'">'+nombre+'</option>');
                $('#txtcentroformacion_aprendiz').material_select();

            });
        });
    },
    getCentroFormacionEgresadoSena:function (){
        let regional = $('#txtregional_egresado').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_egresado').empty();
            $('#txtcentroformacion_egresado').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_egresado').append('<option  value="'+id+'">'+nombre+'</option>');
                $('#txtcentroformacion_egresado').material_select();
            });
        });
    },
    getCentroFormacionFuncionarioSena:function (){
        let regional = $('#txtregional_funcionarioSena').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_funcionarioSena').empty();
            $('#txtcentroformacion_funcionarioSena').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_funcionarioSena').append('<option  value="'+id+'">'+nombre+'</option>');
                $('#txtcentroformacion_funcionarioSena').material_select();
            });
        });
    },
    getCentroFormacionInstructorSena:function (){
        let regional = $('#txtregional_instructorSena').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_instructorSena').empty();
            $('#txtcentroformacion_instructorSena').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_instructorSena').append('<option  value="'+id+'">'+nombre+'</option>');
                $('#txtcentroformacion_instructorSena').material_select();
            });
        });
    },
}

$('button[type="reset"]').click(function() {       // apply to reset button's click event
            this.form.reset();                    // reset the for   
            $(".talento").show();
            $(".contratista").hide();
            $('#document').empty();
            $("#txtocupaciones").val();
            $('#document_type').val();
            $('#modalvalidationuser').openModal({
                opacity: 0.7,
                in_duration: 350,
                out_duration: 250,
                ready: undefined,
                complete: undefined,
                dismissible: false,
                starting_top: '10%',
                ending_top: '10%'
            });
            return false;                         // prevent reset button from resetting again
});

$('button[type="reset"]').click(function() {       // apply to reset button's click event
            this.form.reset();                    // reset the for   
            $(".talento").show();
            $(".contratista").hide();
            $('#document').empty();
            $("#txtocupaciones").val();
            $('#document_type').val();
            $('#modalvalidationuser').openModal({
                opacity: 0.7,
                in_duration: 350,
                out_duration: 250,
                ready: undefined,
                complete: undefined,
                dismissible: false,
                starting_top: '10%',
                ending_top: '10%'
            });
            
            $('small[class="error red-text"]').empty();
            
            return false;                         // prevent reset button from resetting again
});


//resgistro de usuarios.
$(document).on('submit', 'form#formRegisterUser', function (event) {

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
                console.log(data);
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            if (data.fail) {
                for (control in data.errors) {
                    $('#' + control + '-error').html(data.errors[control]);
                    $('#' + control + '-error').show();
                }
                createUser.printErroresFormulario(data);
            }
            if (data.state == 'error' && data.url == false) {
                Swal.fire({
                    title: 'Registro Erróneo, por favor inténtalo de nuevo',
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }
            if (data.state == 'success' && data.url != false) {
                Swal.fire({
                    title: 'Registro Exitoso',
                    icon: 'success',
                    type: 'success',
                    html: data.message,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                    backdrop: true,
                    allowOutsideClick: false,
                    footer: '<p class="red-text">Hemos enviado un correo electrónico  a ' + data.user.email + ' con las credenciales de ingreso a la plataforma.</p>'
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(function(){
                            window.location.href = data.url;
                        }, 50);
                    }
                    setTimeout(function(){
                        window.location.href = data.url;
                    }, 50);
                });
            }
        },
    });
});

var createUser = {
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