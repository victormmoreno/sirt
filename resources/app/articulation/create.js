$( document ).ready(function() {
    var form = $("#articulation-form");
    var validator = $("#articulation-form").validate({
        onfocusout: false,
        rules: {

            accompaniment_type:{ required:true },
            name_accompaniment:{
                required:true,
                minlength: 2,
                maxlength: 255
            },
            description_accompaniment:{
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
            projects: {
                required:true,
                number: true
            },
            talent: {
                required:true,
                number: true
            }
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
            },
            projects:
            {
                required:"</br>Por favor agrega el proyecto<br/>",

            },
            talent:
            {
                required:"</br>Por favor agrega el talento interlocutor<br/>",
            }
        },
        errorPlacement: function(error, element)
        {

            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.container-error') );
            }
            else if ( element.is(":hidden") )
            {
                error.appendTo( element.parents('.container-error') );
                console.log(element.after(error))
            }
            else
            {
                element.after(error);
                // console.log(element.after(error))

            }
        }
    });

    console.log("V1: ", validator.settings.ignore);
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

            // console.log(currentIndex´== 1);
            if (currentIndex == 1) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            }else{
                form.validate().settings.ignore = ":hidden";
            }

            // if (currentIndex < newIndex) {

            //     $(".body:eq(" + newIndex + ") label.error", form).remove();
            //     $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
            // }


            // form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";

            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":hidden";
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

    $('#filter_code_project').click(function () {
        let filter_code_project = $('#filter_code').val();

        if((filter_code_project != '' || filter_code_project != null || filter_code_project.length  > 0)){
            filter_project.fill_code_project(filter_code_project);
        }
    });


    $('#filter_project_modal').click(function () {
        let filter_year_pro = $('#filter_year_pro').val();
        filter_project.queryProyectosFaseInicioTable(filter_year_pro);
    });


    $('#filter_project_advanced').click(function () {
        let filter_year_pro = $('#filter_year_pro').val();
        filter_project.queryProyectosFaseInicioTable(filter_year_pro);
    });

});




var filter_project = {
    fill_code_project:function(filter_code_project = null){

        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.emptyResult('alert-response-talents');
        filter_project.emptyResult('txtnombre_articulacion');
        if(filter_code_project.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/actividades/filter-code/' + filter_code_project
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let activity = response.data.proyecto.articulacion_proyecto.actividad;
                    let data = response.data;

                    $('.alert-response').append(`
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="card card-transparent p f-12">
                                    <div class="card-content">
                                        <span class="card-title p f-12">`+activity.codigo_actividad+ ` - `+activity.nombre+`</span>
                                        <div class="position-top-right p f-12 mail-date hide-on-med-and-down">`+ filter_project.formatDate(activity.fecha_cierre)+`</div>
                                        <p>`+activity.objetivo_general+`</p>
                                        <div class="input-field col m12 s12">
                                            <input type="hidden" name="projects" id="projects" style="display:none" value="`+response.data.proyecto.id+`"/>
                                        </div>
                                    </div>
                                    <div class="card-action">
                                    <a class="orange-text text-darken-1" target="_blank" href="/proyecto/detalle/`+data.proyecto.id+`">Ver más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    if (data.proyecto.articulacion_proyecto.talentos.length != 0) {
                        $.each(data.proyecto.articulacion_proyecto.talentos, function(e, talento) {
                            if(talento.pivot.talento_lider == 1){
                                $('.alert-response-talents').append(`<div class="row card-talent`+talento.user.id+ `">
                                    <div class="col s12 m12 l12">
                                        <div class="card bs-dark">
                                            <div class="card-content">
                                                <span class="card-title p-h-lg"> `+talento.user.documento+ ` - `+talento.user.nombres+ ` `+talento.user.apellidos+`</span>
                                                <div class="input-field col m12 s12">
                                                    <input type="hidden" name="talent" id="talent" style="display:none" value="`+talento.id+`"/>
                                                </div>
                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">  Acceso al sistema: `+ userSearch.state(talento.user.estado) +`</div>
                                                <p class="hide-on-med-and-down"> Miembro desde `+filter_project.formatDate(talento.user.created_at)+`</p>
                                            </div>
                                            <div class="card-action">
                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+talento.user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                            }
                        });
                    }
                }else{
                    filter_project.notFound('alert-response');
                    filter_project.notFound('alert-response-talents');

                    $('.collection-response').append(`
                        <li class="collection-item dismissable">
                            <span class="title">Sin resultados</span>
                        </li>
                    `);
                }
            });
        }else{
            filter_project.notFound('alert-response');
            filter_project.notFound('alert-response-talents');

        }
    },
    queryProyectosFaseInicioTable:function(filter_year_pro=null) {
        $('#datatable_projects_finalizados').dataTable().fnDestroy();
        $('#datatable_projects_finalizados').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "/proyecto/datatableproyectosfinalizados",
                type: "get",
                data: {
                    filter_year_pro: filter_year_pro,
                }
            },
            columns: [
                {
                    data: 'codigo_proyecto',
                    name: 'codigo_proyecto'
                }, {
                    data: 'nombre',
                    name: 'nombre'
                }, {
                    data: 'fase',
                    name: 'fase'
                },{
                    data: 'add_proyecto',
                    name: 'add_proyecto',
                    orderable: false
                },
            ]
        });
        $('#filter_project_advanced_modal').openModal();
    },
    addProjectToArticulacion:function(code) {

        filter_project.fill_code_project(code);
        filter_project.emptyResult('result-talents');
        $('#filter_project_advanced_modal').closeModal();
    },
    emptyResult: function(cl){
        if(cl != null){
            $('.'+ cl).empty();
        }
    },
    notFound: function(cl){
        if(cl != null){
            return $('.'+ cl).append(`<div class="row">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent">
                        <div class="card-content">
                            <div class="search-result">
                                <p class="search-result-description">No se encontraron resultados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`);
        }
    },
    formatDate: function(date){
        if(date == null){
            return "no registra";
        }else{
            return moment(date).format('LL');
        }
    },

}



