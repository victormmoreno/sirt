$( document ).ready(function() {
    var form = $("#articulation-form");
    var validator = $("#articulation-form").validate({
        rules: {
            articulation_type: {
                required:true,
            },
            name_articulation:{
                required: true,
                minlength: 2,
                maxlength: 255
            },
            description_articulation:{
                maxlength: 3000
            },
            scope_articulation:{
                required: function(element){
                    return $("#articulation_yes").is(":checked")
                },
                minlength: 2,
                maxlength: 1000
            },

            talents: {
                required: true,
                number: true
            },

            // start_date: {
            //     required:true,
            //     date: true
            // },
            scope_articulacion:{
                required:true,
            },
            name_entity: {
                required: true,
                maxlength: 100
            },
            name_contact: {
                required: true,
                maxlength: 100
            },
            email: {
                required: true,
                maxlength: 100,
                email: true
            },
            call_name: {
                required: false,
                maxlength: 80
            },
            expected_date: {
                required:true,
                date: true
            },
            objective:{
                required: true,
                maxlength: 2500
            }

        },
        messages:
        {
            accompaniment_type:
            {
                required:"Por favor selecciona el tipo de acompañamiento",
            },
            name_accompaniment:
            {
                required:"El nombre del acompañamiento es obligatorio",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            description_accompaniment:
            {
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            scope_accompaniment:
            {
                required:"El alcalce del acompañamiento es obligatorio",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            name_articulation:
            {
                required:"El nombre de la articulación es obligatorio",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            scope_articulation:
            {
                required:"El alcalce de la articulación es obligatorio",
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
            sedes:
            {
                required:"Por favor agrega la sede",
            },
            confidency_format:
            {
                required: jQuery.validator.format("El campo formato confidencial es obligatorio"),
                accept: jQuery.validator.format("El formato permitido es PDF"),
            },

        },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.container-error') );
            }
            else if ( element.is(":file") )
            {
                error.appendTo( element.parents('.container-error') );
            }
            else if ( element.is(":hidden") )
            {
                error.appendTo( element.parents('.container-error') );
            }
            else
            {
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
            next: "Siguiente",
            previous: "Anterior",
            loading: "Cargando ..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex == 2) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            }else{
                form.validate().settings.ignore = ":disabled,:hidden";
            }

            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":hidden";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            event.preventDefault();
            const data = new FormData(document.getElementById("articulation-form"));
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
                    $('button[type="submit"]').removeAttr('disabled');
                    console.log(response);
                    printErroresFormulario(response.data);
                    //filter_project.messageAccompaniable(response.data,  'registrada', 'Registro exitoso');
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }
    });

    $(".wizard .actions ul li a").addClass("waves-effect waves-blue btn-flat");
    $(".wizard .steps ul").addClass("tabs z-depth-1");
    $(".wizard .steps ul li").addClass("tab");
    $('ul.tabs').tabs();
    $('select').material_select();
    $('.select-wrapper.initialized').prev( "ul" ).remove();
    $('.select-wrapper.initialized').prev( "input" ).remove();
    $('.select-wrapper.initialized').prev( "span" ).remove();

    $('.datepicker_articulation_date').pickadate({
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
    $('.datepicker_articulation_max_date').pickadate({
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
