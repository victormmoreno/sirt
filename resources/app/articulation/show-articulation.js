$( document ).ready(function() {
    var form = $("#articulation-form-closing");
    var validator = $("#articulation-form-closing").validate({
        rules: {
            articulation_type: {
                required: true,
            },
            articulation_subtype: {
                required: true,
            },
            start_date: {
                required: true,
                date: true
            },
            name_articulation: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            description_articulation: {
                maxlength: 3000
            },
            scope: {
                required: true,
                minlength: 2,
                maxlength: 1000
            },
            scope_articulation: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            talents: {
                required: true,
                number: true
            },
            name_entity: {
                required: true,
                maxlength: 100
            },
            name_contact: {
                required: true,
                maxlength: 100
            },
            call_name: {
                maxlength: 100
            },
            expected_date: {
                required: true,
                date: true
            },
            objective: {
                required: true,
                maxlength: 2500
            }
        },
        messages: {
            articulation_type: {
                required: "Por favor selecciona el tipo de subarticulación",
            },
            articulation_type: {
                required: "Por favor selecciona el tipo de articulación",
            },
            start_date: {
                required: "Este campo es obligatorio",
                date: "Por favor introduzca una fecha válida"
            },
            name_articulationStage:
                {
                    required: "Este campo es obligatorio",
                    minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            description_articulationStage:
                {
                    minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            scope_articulation:
                {
                    required: "Por favor seleccione un alcance",
                },
            name_articulation:
                {
                    required: "Este campo es obligatorio",
                    minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            scope:
                {
                    required: "Este campo es obligatorio",
                    minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            name_entity:
                {
                    required: "Este campo es obligatorio",
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            name_contact:
                {
                    required: "Este campo es obligatorio",
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            email: {
                required: "Este campo es obligatorio",
                email: "Por favor, introduce una dirección de correo electrónico válida."
            },
            call_name:
                {
                    minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                    maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                },
            expected_date: {
                required: "Este campo es obligatorio",
                date: "Por favor introduzca una fecha válida"
            },
            objective: {
                required: "Este campo es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            talents:
                {
                    required: "Por favor agrega por lo menos un talento participante",
                }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents('.container-error'));
            } else if (element.is(":file")) {
                error.appendTo(element.parents('.container-error'));
            } else if (element.is(":hidden")) {
                error.appendTo(element.parents('.container-error'));
            } else {
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
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex == 3) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            } else {
                form.validate().settings.ignore = ":disabled,:hidden";
            }
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
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
                    printErroresFormulario(response.data);
                    filter_articulations.messageArticulation(response.data, 'registrada', 'Registro exitoso');
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
    $('.select-wrapper.initialized').prev("ul").remove();
    $('.select-wrapper.initialized').prev("input").remove();
    $('.select-wrapper.initialized').prev("span").remove();
});
