$( document ).ready(function() {
    let form = $("#articulation-form");
    const validator = $("#articulation-form").validate({
        rules: {
            articulation_type: {
                required:true,
            },
            articulation_subtype: {
                required:true,
            },
            start_date: {
                required:true,
                date: true
            },
            name:{
                required: true,
                minlength: 1,
                maxlength: 600
            },
            description:{
                required: true,
                minlength: 1,
                maxlength: 3000
            },
            scope:{
                required: true,
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
            email_entity:{
                required: true,
                email: true,
                maxlength: 191
            },
            summon_name:{
                maxlength: 100
            },
            expected_date: {
                required:true,
                date: true
            },
            objective:{
                required: true,
                maxlength: 3000
            }
        },
        messages:{
            articulation_type:{
                required:"Por favor selecciona el tipo de articulación",
            },
            articulation_subtype:{
                required:"Por favor selecciona el tipo de subarticulación",
            },
            start_date:{
                required:"Este campo es obligatorio",
                date: "Por favor introduzca una fecha válida"
            },
            name:{
                required:"Este campo es obligatorio",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            description:{
                required:"Este campo es obligatorio",
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            scope:{
                required:"Por favor seleccione un alcance",
            },

            talents:{
                required:"Por favor agrega por lo menos un talento participante",
            },
            name_entity:{
                required:"Este campo es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            name_contact: {
                required:"Este campo es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            email_entity:{
                required:"Este campo es obligatorio",
                email: "Por favor, introduce una dirección de correo electrónico válida."
            },
            summon_name:{
                minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
            expected_date:{
                required:"Este campo es obligatorio",
                date: "Por favor introduzca una fecha válida"
            },
            objective:{
                required:"Este campo es obligatorio",
                maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
            },
        },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.container-error'));
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
            next: "Siguiente >",
            previous: "< Anterior",
            loading: "Cargando ..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex == 3) {
                form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
            }else{
                form.validate().settings.ignore = ":disabled,:hidden";
            }
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden:not(input[type='hidden'])";
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
                    printErrorsForm(response.data);
                    filter_articulations.messageArticulation(response.data,  'registrada', 'Registro exitoso');
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
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

    $('#search_talents').click(function () {
        let filter_user = $('#txtsearch_user').val();
        if(filter_user.length > 0 ){
            filter_articulations.searchUser(filter_user);
        }else{
            filter_articulations.emptyResult('result-talents');
            filter_articulations.notFound('result-talents');
        }
    });
    $('#advanced_talent_filter').click(function () {
        filter_articulations.queryTalentos();
    });
    $('#show_type_articulations').click(function () {
        $('#type_articulations_modal').openModal();
    });
    filter_articulations.valueArticulationType();
    filter_articulations.changeLabelArticulationSubtype();
});

const filter_articulations = {
    searchUser:function(document){
        $('.result-talents').empty();
        if(document != null || document != null){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: `${host_url}/usuarios/filtro-talento/${document}`
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let user = response.data.user;
                    $('.result-talents').append(`<div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-panel card-transparent">
                                <div class="card-content">
                                    <span class="card-title p f-12 ">${user.documento} - ${user.nombres} ${user.apellidos}</span>
                                    <p class="position-top-right p f-12 mail-date hide-on-med-and-down"> Acceso al sistema: ${userSearch.state(user.estado)}</p>
                                    <div class="mailbox-text p f-12 hide-on-med-and-down">Miembro desde ${filter_articulations.formatDate(user.created_at)}</div>
                                </div>
                                <div class="card-action">
                                <a class="waves-effect waves-red btn-flat m-b-xs primary-text" onclick="filter_articulations.addTalentToArticulation(${user.id});" class="primary-text">Agregar</a>
                                </div>
                            </div>
                        </div>
                    </div>`);
                }else{
                    filter_articulations.notFound('result-talents');
                }

            });
        }
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
                    <div class="card card-panel card-transparent p f-12 m-t-lg">
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
    addTalentToArticulation: function(user){
        filter_articulations.emptyResult('alert-empty-talents');
        if (filter_articulations.noRepeat(user) == false) {
            filter_articulations.talentAssociated();
        } else {
            filter_articulations.emptyResult('talent-empty');
            filter_articulations.printTalentoInTable(user);
        }
        $('#filter_talents_advanced_modal').closeModal();
    },
    noRepeat: function(id) {
        let user = id;
        let retorno = true;
        let a = document.getElementsByName("talents[]");
        for (x = 0; x < a.length; x ++) {
            if (a[x].value == user) {
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
    printTalentoInTable: function(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: `${host_url}/usuarios/cliente/${id}`
        }).done(function (response) {
            let fila = filter_articulations.prepareTableRowTalent(response);
            $('.alert-response-talents').append(fila);
        });
    },
    printTalentoInTable: function(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: `${host_url}/usuarios/cliente/${id}`
        }).done(function (response) {
            let fila = filter_articulations.prepareTableRowTalent(response);
            $('.alert-response-talents').append(fila);
        });
    },
    prepareTableRowTalent: function(response) {
        let data = response;
        let fila =`<div class="row card-talent`+data.talento.id+`">
                        <div class="col s12 m12 l12">
                            <div class="card card-panel server-card">
                                <div class="card-content">
                                    <span class="card-title">${data.talento.documento} - ${data.talento.nombres} ${data.talento.apellidos}</span>
                                    <input type="hidden" id="talents" name="talents[]" value="${data.talento.id}"/>
                                </div>
                                <div class="card-action">
                                    <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs primary-text" href="/usuarios/${data.talento.documento}"><i class="material-icons left"> link</i>Ver más</a>
                                    <a onclick="filter_articulations.deleteTalent(${data.talento.id});" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>`;
        return fila;
    },
    deleteTalent:function(id){
        $('.card-talent'+ id).remove();
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'Talento eliminado.'
        });
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
                url: `${host_url}/usuarios/clientes`,
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
                    data: 'add_talents_articulation',
                    name: 'add_talents_articulation',
                    orderable: false
                },
            ]
        });
        $('#filter_talents_advanced_modal').openModal();
    },
    messageArticulation: function(data, action, title) {
        if (data.status_code == 201) {
            Swal.fire({
                title: title,
                text: "La articulación ha sido "+action+" satisfactoriamente",
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
            setTimeout(function () {
                window.location.replace(data.url);
            }, 1000);
        }
        else {
            Swal.fire({
                title: 'La articulación no se ha '+action+', por favor inténtalo de nuevo',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            })
        }
    },
    valueArticulationType: function (){
        $("#articulation_type").on('change', function () {
                let articulaciontype = $(this).val();
                if(articulaciontype !=null || articulaciontype != ''){
                    $.ajax({
                        dataType: 'json',
                        type: 'get',
                        url: `/tipoarticulaciones/${articulaciontype}/tiposubarticulaciones`
                    }).done(function (response) {
                        $("#articulation_subtype").empty();
                        $('#articulation_subtype').append('<option value="">Seleccione el tipo de subarticulación</option>');
                        $.each(response.data, function(i, element) {
                                $('#articulation_subtype').append(`<option  value="${element.id}">${element.name}</option>`);
                        });
                        $('#articulation_subtype').material_select();

                    });
                }
        });
    },
    changeLabelArticulationSubtype: function() {
        // $("#articulation_subtype").on('change', function () {
        //     if($(this).val() != null || $(this).val() != ''){
        //         $("label[for='program_description']").text( 'Nombre de ' + $('select[name="articulation_subtype"] option:selected').text());
        //     }else{
        //         $("label[for='program_description']").text("Nombre del programa");
        //     }
        // });
    },
    updateTalentsParticipants: function(form, data, url) {
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
                $('.error').hide();
                printErrorsForm(response.data);
                filter_articulations.messageArticulation(response.data, 'actualizado', 'Modificación Exitosa');
            },
            error: function (xhr, textStatus, errorThrown) {
                Swal.fire({
                    title: 'Error, vuelve a intentarlo',
                    html: "Error: " + textStatus,
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });
            }
        });
    },
    ajaxSendFormArticulationClosing: function(form, data, url) {
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
                $('.error').hide();
                printErrorsForm(response.data);
                filter_articulations.messageArticulation(response.data, 'registro guardado', 'registro guardado');
            },
            error: function (xhr, textStatus, errorThrown) {
                Swal.fire({
                    title: 'Error, vuelve a intentarlo',
                    html: "Error: " + textStatus,
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });
            }
        });
    },
    destroyArticulation: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar esta  articulación?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminar',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: `${host_url}/etapa-articulaciones/articulaciones/${id}`,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Eliminado!',
                                'La articulación ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }else{
                            Swal.fire(
                                'Error!',
                                'La fase de articulación no se ha eliminado.',
                                'warining'
                            );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error, vuelve a intentarlo',
                            html: "Error: " + textStatus,
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                        });
                    }
                });
            }
        })
    }
}

$(document).on('submit', 'form#talents-form', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    const form = $(this);
    const data = new FormData($(this)[0]);
    const url = form.attr("action");
    filter_articulations.updateTalentsParticipants(form, data, url);
});

$(document).on('submit', 'form#articulation-form-closing', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    const form = $(this);
    const data = new FormData($(this)[0]);
    const url = form.attr("action");
    filter_articulations.ajaxSendFormArticulationClosing(form, data, url);
});
