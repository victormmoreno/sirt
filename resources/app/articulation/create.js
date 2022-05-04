$( document ).ready(function() {
    var form = $("#articulation-form");
    var validator = $("#articulation-form").validate({
        onfocusout: false,
        rules: {
            // confirm: {
            //     equalTo: "#password"
            // },
            accompaniment_type:{ required:true },
            name_accompaniment:{
                required:true,
                minlength: 2,
                maxlength: 255
            },
            description_accompaniment:{
                minlength: 0,
                maxlength: 3000
            },
            scope_accompaniment:{
                required:true,
                minlength: 2,
                maxlength: 3000
            },
            name_articulation:{
                required:true,
                minlength: 2,
                maxlength: 255
            },
            scope_articulation:{
                required:true,
                minlength: 2,
                maxlength: 1000
            },
        },
        messages:
        {
            accompaniment_type:
            {
                required:"</br>Por favor selecciona el tipo de acompañamiento<br/>",
            },
            name_accompaniment:
            {
                required:"</br>El nombre del acompañamiento es obligatorio<br/>",
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
                required:"</br>El alcalce del acompañamiento es obligatorio<br/>",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            name_articulation:
            {
                required:"</br>El nombre de la articulación es obligatorio<br/>",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            scope_articulation:
            {
                required:"</br>El alcalce de la articulación es obligatorio<br/>",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            }
        },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
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
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
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
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });


    document.querySelectorAll('input[name="accompaniment_type"]').forEach((elem) => {
        elem.addEventListener("click", function(event){
            let item = event.target.value;

            if(item == 'pbt'){
                $('.section-company').hide();
                $('.section-project').show();
                $('.section-talent').show();
            }else if(item == 'empresa'){
                $('.section-project').hide();
                $('.section-company').show();
                $('.section-talent').hide();
            }else{
                $('.section-project').hide();
                $('.section-company').hide();
                $('.section-talent').hide();
            }
        });
    });

    document.querySelectorAll('input[name="articulation"]').forEach((elem) => {
        elem.addEventListener("click", function(event){
            let item = event.target.value;

            if(item == 'si'){
                $('.section-articulation').show();
            }else if(item == 'no'){
                $('.section-articulation').hide();
            }else{
                $('.section-articulation').hide();
            }
        });
    });


});
