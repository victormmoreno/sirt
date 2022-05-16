$( document ).ready(function() {
    var form = $("#accompaniment-form");
    var validator = $("#accompaniment-form").validate({
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
                required: function(element){
                    return $("#articulation_yes").is(":checked")
                },
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
            projects: {
                required: function(element){
                    return $("#accompaniment_type_pbt").is(":checked");
                },
                number: true
            },
            talent: {
                required: function(element){
                    return $("#accompaniment_type_pbt").is(":checked");
                },
                number: true
            },
            sedes:{
                required: function(element){
                    return $("#accompaniment_type_company").is(":checked")
                },
                number: true
            },
            confidency_format: {
                required:true,
                accept: "application/pdf"
            },
            articulation: {
                required:true
            },
            articulation_type: {
                required:true,
            },
            start_date: {
                required:true,
                date: true
            },
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
            articulation:
            {
                required:"Por inidique si desea registrar una articulación",
            },
            articulation_type:
            {
                required:"Por favor seleccione el tipo de articulación",
            },
            start_date: {
                required:"Por favor ingrese la fecha de inicio de la articulación",
                date: "El valor permitido para este campo es una fecha"
            },
            scope_articulacion:
            {
                required:"Por favor selecciona el alcance de la articulación",
            },
            name_entity:
            {
                required:"La entidad es obligatoria",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            name_contact:
            {
                required:"El nombre del contacto es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            email:
            {
                required:"El correo electrónico es obligatorio",
                email:"Por favor, introduce una dirección de correo electrónico válida.",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            call_name:
            {
                required:"El nombre de la convocatoria es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            expected_date: {
                required:"Por favor ingrese la fecha esperada de finalización",
                date: "El valor permitido para este campo es una fecha"
            },
            objective:
            {
                required:"El objetivo es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            }

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
            if (currentIndex == 1) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
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

    $.validator.addMethod('accept', function (value, element, param) {
        return  (element.files[0].type == param)
    }, 'El archivo debe tener formato PDF');

    $.validator.addMethod('requireif', function (value, element, param) {
        return $('input:radio[name=accompaniment_type]:checked').val() == param;
    }, 'Este campo es oblogatorio');

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

    $('#search_talent').click(function () {
        let filter_user = $('#txtsearch_user').val();
        if(filter_user.length > 0 ){
            filter_project.searchUser(filter_user);
        }else{
            filter_project.emptyResult('result-talents');
            filter_project.notFound('result-talents');
        }

    });

    $('#filter_talents_advanced').click(function () {
        filter_project.queryTalentos();
    });

    $('#filter_company').click(function () {
        let filter_company = $('#filter_nit').val();
        if((filter_company != '' || filter_company != null || filter_company.length  > 0)){
            filter_project.fill_nit_company(filter_company);
        }
    });

    $('#filter_company_advanced').click(function () {

        filter_project.queryCompaniesTable();
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

const filter_project = {
    fill_code_project:function(filter_code_project = null){
        filter_project.emptyResult('result-projects');
        if(filter_code_project.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/actividades/filter-code/' + filter_code_project
            }).done(function (response) {
                if(response.data.status_code == 200){
                    filter_project.emptyResult('result-talents');
                    let activity = response.data.proyecto.articulacion_proyecto.actividad;
                    let data = response.data;
                    $('.result-projects').append(`
                        <div class="card card-transparent p f-12 m-t-lg">
                            <div class="card-content">
                                <span class="card-title p f-12">${activity.codigo_actividad} ${activity.nombre}</span>
                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">${filter_project.formatDate(activity.fecha_cierre)}</div>
                                <p>${activity.objetivo_general}</p>
                                <div class="input-field col m12 s12">
                                    <input type="hidden" name="projects" id="projects" style="display:none" value="${response.data.proyecto.id}"/>
                                </div>
                            </div>
                            <div class="card-action">
                                <a class="waves-effect waves-red btn-flat m-b-xs orange-text" target="_blank" href="/proyecto/detalle/${data.proyecto.id}"><i class="material-icons left">link</i>Ver más</a>
                            </div>
                        </div>`
                    );
                    if (data.proyecto.articulacion_proyecto.talentos.length != 0) {
                        $.each(data.proyecto.articulacion_proyecto.talentos, function(e, talento) {
                            if(talento.pivot.talento_lider == 1){
                                $('.result-talents').append(`
                                    <div class="card card-transparent p f-12 m-t-lg">
                                        <div class="card-content">
                                            <span class="card-title p f-12">${talento.user.documento} - ${talento.user.nombres} ${talento.user.apellidos}</span>
                                            <div class="input-field col m12 s12">
                                                <input type="hidden" name="talent" id="talent" style="display:none" value="${talento.user.id}"/>
                                            </div>
                                            <div class="position-top-right p f-12 mail-date hide-on-med-and-down">  Acceso al sistema: ${userSearch.state(talento.user.estado)}</div>
                                            <p class="hide-on-med-and-down"> Miembro desde ${filter_project.formatDate(talento.user.created_at)}</p>
                                        </div>
                                        <div class="card-action">
                                            <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/${talento.user.documento}"><i class="material-icons left">link</i>Ver más</a>
                                        </div>
                                    </div>`
                                );
                            }
                        });
                    }
                }else{
                    filter_project.notFound('result-projects', 'projects');
                    filter_project.notFound('result-talents', 'talent');
                }
            });
        }else{
            filter_project.emptyResult('result-projects');
            filter_project.emptyResult('result-talents');
            filter_project.notFound('result-projects', 'projects');
            filter_project.notFound('result-talents', 'talent');
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
    notFound: function(cl, value = null){
        if(cl != null){
            return $('.'+ cl).append(`
                <div class="col s12 m12 l12">
                    <div class="card card-transparent p f-12 m-t-lg">
                        <div class="card-content">
                            <span class="card-title p f-12 ">No se encontraron resultados</span>
                            <div class="input-field col m12 s12">
                            <input type="hidden" name="${value}" id="${value}" style="display:none"/>
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
    searchUser:function(document){
        if(document != null){
            filter_project.emptyResult('result-talents');
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/usuarios/filtro-talento/' + document
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let user = response.data.user;
                    $('.result-talents').append(
                        `<div class="card card-transparent p f-12 m-t-lg">
                            <div class="card-content">
                                <span class="card-title p f-12 ">${user.documento} - ${user.nombres} ${user.apellidos}</span>
                                <div class="input-field col m12 s12">
                                    <input type="hidden" name="talent" id="talent" style="display:none" value="${user.id}"/>
                                </div>
                                <p class="position-top-right p f-12 mail-date hide-on-med-and-down"> Acceso al sistema: `+ userSearch.state(user.estado) +`</p>
                                <div class="mailbox-text p f-12 hide-on-med-and-down">
                                    Miembro desde ${filter_project.formatDate(user.created_at)}
                                </div>
                            </div>
                            <div class="card-action">
                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                            </div>
                        </div>
                    `);
                }else{
                    filter_project.emptyResult('result-talents');
                    filter_project.notFound('result-talents', 'talent');
                }
            });
        }else{
            filter_project.emptyResult('result-talents');
            filter_project.notFound('result-talents', 'talent')
        }
    },
    queryTalentos: function(){
        $('#datatable_interlocutor_talents').dataTable().fnDestroy();
        $('#datatable_interlocutor_talents').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "/usuario/talento/getTalentosDeTecnoparque/",
                type: "get"
            },
            columns: [
                {
                    data: 'documento',
                    name: 'documento'
                }, {
                    data: 'talento',
                    name: 'talento'
                }, {
                    data: 'add_intertocutor_talent_articulation',
                    name: 'add_intertocutor_talent_articulation',
                    orderable: false
                },
            ]
        });
        $('#filter_talents_advanced_modal').openModal();
    },
    addInterlocutorTalentArticulacion: function(talent){
        if (filter_project.noRepeat(talent) == false) {
            filter_project.talentAssociated();
        } else {
            filter_project.emptyResult('talent-empty');
            filter_project.printInterlocutorTalentoInTable(talent);
        }
        $('#filter_talents_advanced_modal').closeModal();
    },
    noRepeat: function(id) {
        let idTalento = id;
        let retorno = true;
        let a = document.getElementsByName("talentos[]");
        for (x = 0; x < a.length; x ++) {
            if (a[x].value == idTalento) {
                retorno = false;
                break;
            }
        }
        return retorno;
    },
    talentAssociated: function() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'warning',
            title: 'El talento ya se encuentra asociado a la articulación!'
        });
    },
    printInterlocutorTalentoInTable: function(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/usuario/talento/consultarTalentoPorId/' + id
        }).done(function (response) {
            if(response != null){
                filter_project.searchUser(response.talento.documento);
            }else{
                filter_project.emptyResult('result-talents');
                filter_project.notFound('result-talents', 'talent')
            }
        });
    },
    fill_nit_company:function(filter_company = null){
        filter_project.emptyResult('result-companies');
        filter_project.emptyResult('result-sedes');
        if(filter_company.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/empresas/filter-code/' + filter_company
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let data = response.data;
                    if (data.empresa.sedes.length != 0) {
                        $.each(data.empresa.sedes, function(e, sede) {
                            $('.result-companies').append(`<div class="row card-talent`+sede.id+`">
                                    <div class="col s12 m12 l12">
                                        <div class="card bs-dark">
                                            <div class="card-content">
                                                <span class="card-title p-h-lg"> `+sede.nombre_sede+ `</span>
                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Empresa: `+data.empresa.nit+` - `+data.empresa.nombre+`</div>
                                            </div>
                                            <div class="card-action">
                                                <a onclick="filter_project.addSedeArticulacion( `+sede.id+ `);" class="waves-effect waves-red btn-flat m-b-xs orange-text">Agregar sede</a>
                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/empresa/detalle/`+data.empresa.id+ `"><i class="material-icons left"> link</i>Ver más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                        });
                        filter_project.notFound('result-sedes', 'sedes');
                    }else{
                        filter_project.notFound('result-companies');
                        filter_project.notFound('result-sedes', 'sedes');
                    }
                }else{
                    filter_project.notFound('result-companies');
                    filter_project.notFound('result-sedes', 'sedes');
                }
            });
        }else{
            filter_project.notFound('result-companies');
            filter_project.notFound('result-sedes', 'sedes');
        }
    },
    addSedeArticulacion: function(value){
        filter_project.printSede(value);
        $('#sedes_modal').closeModal();
        $('#company_modal').closeModal();
    },
    printSede: function(id){
        filter_project.emptyResult('result-sedes');
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/empresas/sede/' + id
        }).done(function (response) {
            if(response.data.status_code == 200){
            $('.result-sedes').append(`
                <div class="card card-transparent p f-12 m-t-lg">
                    <div class="card-content">
                        <span class="card-title p f-12 ">${response.data.sede.nombre_sede}</span>
                        <div class="input-field col m12 s12">
                            <input type="hidden" name="sedes" id="sedes" style="display:none" value="${response.data.sede.id}"/>
                        </div>
                    </div>
                    <div class="card-action">
                        <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                    </div>
                </div>
                `);
            }else{
                filter_project.notFound('result-sedes', 'sedes');
            }
        });
    },
    queryCompaniesTable:function() {
        filter_project.emptyResult('result-companies');
        filter_project.emptyResult('result-sedes');
        filter_project.notFound('result-sedes', 'sedes');
        filter_project.notFound('result-companies');
        $('#companies_table').dataTable().fnDestroy();
        $('#companies_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            // order: false,
            ajax: {
                url: "/empresa/datatableEmpresasDeTecnoparque",
                type: "get"
            },
            columns: [
                {
                    data: 'nit',
                    name: 'nit'
                }, {
                    data: 'nombre_empresa',
                    name: 'nombre_empresa'
                }, {
                    data: 'add_company_art',
                    name: 'add_company_art',
                    orderable: false
                },
            ]
        });
        $('#company_modal').openModal();
    },
    addCompanyArticulacion: function(id){
        $('#sedes_detail').empty();
        $.ajax({
            dataType: 'json',
            type: 'get',
            url : '/empresa/ajaxDetallesDeUnaEmpresa/'+id+'/id',
            success: function (response) {
                let filas_sedes = filter_project.sedesEmpresa(response.empresa.sedes);
                $('#sedes_detail').append(filas_sedes);
                $('#sedes_modal').openModal();
            },
            error: function (xhr, textStatus, errorThrown) {
              alert("Error: " + errorThrown);
            }
          })
    },
    sedesEmpresa: function(sedes) {
        let fila = "";
        sedes.forEach(element => {
            fila += `<li class="collection-item">
                ` + element.nombre_sede + ` - ` + element.direccion + `
                <a href="#!" class="secondary-content" onclick="filter_project.addSedeArticulacion(`+element.id+`)">Asociar esta sede a la articulación</a></div>
            </li>`;
        });
        return fila;
    },
}



