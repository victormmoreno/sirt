$(document).ready(function() {
    let filter_node_accompaniment = $('#filter_node_accompaniment').val();
    let filter_year_accompaniment = $('#filter_year_accompaniment').val();
    let filter_status_accompaniment = $('#filter_status_accompaniment').val();
    if((filter_node_accompaniment == '' || filter_node_accompaniment == null) && (filter_year_accompaniment =='' || filter_year_accompaniment == null) && (filter_status_accompaniment == '' || filter_status_accompaniment == null)){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment = null,filter_year_accompaniment = null, filter_status_accompaniment = null);
    }else if((filter_node_accompaniment != '' || filter_node_accompaniment != null) || filter_year_accompaniment !='' && filter_status_accompaniment != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment, filter_year_accompaniment, filter_status_accompaniment);
    }else{

        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_accompaniment').click(function () {
    let filter_node_accompaniment = $('#filter_node_accompaniment').val();
    let filter_year_accompaniment = $('#filter_year_accompaniment').val();
    let filter_status_accompaniment = $('#filter_status_accompaniment').val();

    $('#accompaniment_data_table').dataTable().fnDestroy();
    if((filter_node_accompaniment == '' || filter_node_accompaniment == null) && filter_year_accompaniment !='' && filter_status_accompaniment != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment = null,filter_year_accompaniment, filter_status_accompaniment);
    }else if((filter_node_accompaniment != '' || filter_node_accompaniment != null) && filter_year_accompaniment !='' && filter_status_accompaniment != ''){
        accompaniment.filtersDatatableAccompanibles(filter_node_accompaniment, filter_year_accompaniment, filter_status_accompaniment);
    }else{
        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_accompaniment').click(function(){
    let filter_node_accompaniment = $('#filter_node_accompaniment').val();
    let filter_year_accompaniment = $('#filter_year_accompaniment').val();
    let filter_status_accompaniment = $('#filter_status_accompaniment').val();
    const query = {
        filter_node_accompaniment: filter_node_accompaniment,
        filter_year_accompaniment: filter_year_accompaniment,
        filter_status_accompaniment: filter_status_accompaniment
    }
    const url = "/articulaciones/export?" + $.param(query)
    window.location = url;
});

const accompaniment ={
    filtersDatatableAccompanibles: function(filter_node_accompaniment,filter_year_accompaniment, filter_status_accompaniment){
        $('#accompaniment_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 5, "desc" ]],
            ajax:{
                url: "/articulaciones/datatable_filtros",
                type: "get",
                data: {
                    filter_node_accompaniment: filter_node_accompaniment,
                    filter_year_accompaniment: filter_year_accompaniment,
                    filter_status_accompaniment: filter_status_accompaniment,
                }
            },
            columns: [
                {
                    data: 'node',
                    name: 'node',
                },
                {
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'count_articulations',
                    name: 'count_articulations',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'starDate',
                    name: 'starDate',
                },
                {
                    data: 'accompanimentBy',
                    name: 'accompanimentBy',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    fill_code_project:function(filter_code_project = null){
        accompaniment.emptyResult('result-projects');
        if(filter_code_project.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/actividades/filter-code/' + filter_code_project
            }).done(function (response) {
                if(response.data.status_code == 200){
                    accompaniment.emptyResult('result-talents');
                    let activity = response.data.proyecto.articulacion_proyecto.actividad;
                    let data = response.data;
                    $('.result-projects').append(`
                        <div class="card card-transparent p f-12 m-t-lg">
                            <div class="card-content">
                                <span class="card-title p f-12">${activity.codigo_actividad} ${activity.nombre}</span>
                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">${accompaniment.formatDate(activity.fecha_cierre)}</div>
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
                                            <p class="hide-on-med-and-down"> Miembro desde ${accompaniment.formatDate(talento.user.created_at)}</p>
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
                    accompaniment.notFound('result-projects', 'projects');
                    accompaniment.notFound('result-talents', 'talent');
                }
            });
        }else{
            accompaniment.emptyResult('result-projects');
            accompaniment.emptyResult('result-talents');
            accompaniment.notFound('result-projects', 'projects');
            accompaniment.notFound('result-talents', 'talent');
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

        accompaniment.fill_code_project(code);
        accompaniment.emptyResult('result-talents');
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
            accompaniment.emptyResult('result-talents');
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
                                    Miembro desde ${accompaniment.formatDate(user.created_at)}
                                </div>
                            </div>
                            <div class="card-action">
                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                            </div>
                        </div>
                    `);
                }else{
                    accompaniment.emptyResult('result-talents');
                    accompaniment.notFound('result-talents', 'talent');
                }
            });
        }else{
            accompaniment.emptyResult('result-talents');
            accompaniment.notFound('result-talents', 'talent')
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
                url: "/usuario/talento/getTalentosDeTecnoparque",
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
        if (accompaniment.noRepeat(talent) == false) {
            accompaniment.talentAssociated();
        } else {
            accompaniment.emptyResult('talent-empty');
            accompaniment.printInterlocutorTalentoInTable(talent);
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
                accompaniment.searchUser(response.talento.documento);
            }else{
                accompaniment.emptyResult('result-talents');
                accompaniment.notFound('result-talents', 'talent')
            }
        });
    },
    messageAccompaniable: function(data, action, title) {
        if (data.status_code == 201) {
            Swal.fire({
                title: title,
                text: "La etapa de articulación  ha sido "+action+" satisfactoriamente",
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
            setTimeout(function () {
                window.location.replace(data.url);
            }, 1000);
        }
        if (data.state == 404) {
            Swal.fire({
                title: 'La etapa de articulación  no se ha '+action+', por favor inténtalo de nuevo',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            })
        }
    },
    updateInterlocutor: function(form, data, url) {
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
                printErroresFormulario(response.data);
                accompaniment.messageAccompaniable(response.data, 'actualizado', 'Modificación Exitosa');
            },
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            }
        });
    }

}

$(document).on('submit', 'form#interlocutor-form', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    const form = $(this);
    const data = new FormData($(this)[0]);
    const url = form.attr("action");
    accompaniment.updateInterlocutor(form, data, url);
});

