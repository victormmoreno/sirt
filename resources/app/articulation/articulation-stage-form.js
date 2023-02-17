$( document ).ready(function() {
    const form = $("#articulation-stage-form");
    const validator = $("#articulation-stage-form").validate({
        rules: {
            name:{
                required:true,
                minlength: 2,
                maxlength: 600
            },
            description:{
                maxlength: 3000
            },
            scope:{
                required:true,
                minlength: 2,
                maxlength: 3000
            },
            projects: {
                required:true,
                number: true
            },
            talent: {
                required: true,
                number: true
            },
            confidency_format: {
                required:true,
                accept: "application/pdf"
            }
        },
        messages:
            {
                name:
                    {
                        required:"El nombre es obligatorio",
                        minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                        maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                    },
                description:
                    {
                        minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                        maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                    },
                scope:
                    {
                        required:"El alcalce es obligatorio",
                        minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                        maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                    },

                projects:
                    {
                        required:"Por favor agrega el proyecto",
                    },
                talent:
                    {
                        required:"Por favor agrega el talento interlocutor",
                    },
                confidency_format:
                    {
                        required: jQuery.validator.format("El campo formato confidencial es obligatorio"),
                        accept: jQuery.validator.format("El formato permitido es PDF"),
                    }
            },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") ){
                error.appendTo( element.parents('.container-error') );
            }
            else if ( element.is(":file") ){
                error.appendTo( element.parents('.container-error') );
            }
            else if ( element.is(":hidden") ){
                error.appendTo( element.parents('.container-error') );
            }
            else{
                element.after(error);
            }
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        labels: {
            cancel: "Cancelar",
            current: "current step:",
            pagination: "Paginación",
            finish: "Guardar",
            next: "Siguiente >",
            previous: "< Anterior",
            loading: "Cargando ..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex == 1) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            }else{
                form.validate().settings.ignore = ":disabled,:hidden";
            }

            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            if (currentIndex == 1) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            }else{
                form.validate().settings.ignore = ":disabled,:hidden";
            }
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            event.preventDefault();
            const data = new FormData(document.getElementById("articulation-stage-form"));
            const url = form.attr("action");
            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                cache: false,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (response) {
                    $('.error').hide();
                    $('button[type="submit"]').removeAttr('disabled');
                    printErrorsForm(response);

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
                error: function (xhr, textStatus, errorThrown) {
                    Swal.fire({
                        title: ' Error, vuelve a intentarlo',
                        html:  `${xhr.status} ${errorThrown}`,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                }
            });
        }
    });

    $(".wizard .actions ul li a").addClass("waves-effect waves-primary btn-flat");
    $(".wizard .steps ul").addClass("tabs z-depth-1");
    $(".wizard .steps ul li").addClass("tab");
    $('ul.tabs').tabs();
    $('select').material_select();
    $('.select-wrapper.initialized').prev( "ul" ).remove();
    $('.select-wrapper.initialized').prev( "input" ).remove();
    $('.select-wrapper.initialized').prev( "span" ).remove();

    $.validator.addMethod('accept', function (value, element, param) {
        return  (element.files[0].type == param)
    }, 'El archivo debe tener formato PDF');

    $('#filter_code_project').click(function () {
        let filter_code_project = $('#filter_code').val();
        if((filter_code_project != '' || filter_code_project != null || filter_code_project.length  > 0)){
            articulationStage.fill_code_project(filter_code_project);
        }
    });
    $('#filter_project_modal').click(function () {
        let filter_year_pro = $('#filter_year_pro').val();
        articulationStage.queryProyectosFaseInicioTable(filter_year_pro);
    });
    $('#filter_project_advanced').click(function () {
        let filter_year_pro = $('#filter_year_pro').val();
        articulationStage.queryProyectosFaseInicioTable(filter_year_pro);
    });
    $('#search_talent').click(function () {
        let filter_user = $('#txtsearch_user').val();
        if(filter_user.length > 0 ){
            articulationStage.searchUser(filter_user);
        }else{
            articulationStage.emptyResult('result-talents');
            articulationStage.notFound('result-talents');
        }
    });
    $('#filter_talents_advanced').click(function () {
        articulationStage.queryTalentos();
    });

    $('.datepicker_accompaniable_date').pickadate({
        selectMonths: true,
        selectYears: 10,
        labelMonthNext: 'Próximo Mes',
        labelMonthPrev: 'Mes anterior',
        labelMonthSelect: 'Selecione Mes',
        labelYearSelect: 'Selecione Año',
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        weekdaysLetter: ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'],
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        format: 'yyyy-mm-dd',
        onClose: function() {
            $(document.activeElement).blur()
        }
    });
    $('.datepicker_accompaniable_max_date').pickadate({
        selectMonths: true,
        selectYears: 10,
        labelMonthNext: 'Próximo Mes',
        labelMonthPrev: 'Mes anterior',
        labelMonthSelect: 'Selecione Mes',
        labelYearSelect: 'Selecione Año',
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        weekdaysLetter: ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'],
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        max: new Date(),
        format: 'yyyy-mm-dd',
        onClose: function() {
            $(document.activeElement).blur()
        }
    });
});
