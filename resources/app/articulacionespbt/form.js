$(document).on('submit', 'form#frmArticulacionpbt_FaseInicio', function (event) { 
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'registrada', 'Registro exitoso');
});

$(document).on('submit', 'form#frmUpdateArticulacion_FaseInicio', function (event) { 
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'actualizado', 'Modificación Exitosa');
});

$(document).on('submit', 'form#frmUpdateArticulacionMiembros', function (event) { 
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacion(form, data, url, 'actualizado', 'Modificación Exitosa');
});


$(document).on('submit', 'form#frmArticulacionFaseCierre', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormArticulacionFaseCierre(form, data, url);
});

function ajaxSendFormArticulacionFaseCierre(form, data, url) {
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
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            mensajesArticulacionCierre(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};


function printErroresFormulario(data) {
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

function mensajesArticulacionCierre(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa!',
            text: "La articulación ha sido modificado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/articulaciones/"+data.data.id);
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'La articulación no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};




function ajaxSendFormArticulacion(form, data, url, action, title) {
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
            printErroresFormulario(response);
            filter_project.messageArticulacion(response, action, title);
            
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};



$('#filter_code_project').click(function () {
    let filter_code_project = $('#filter_code').val();
    if((filter_code_project != '' || filter_code_project != null || filter_code_project.length  > 0)){
        filter_project.fill_code_project(filter_code_project);
    }
});

$('#filter_nit_company').click(function () {
    let filter_nit_company = $('#filter_nit').val();
    if((filter_nit_company != '' || filter_nit_company != null || filter_nit_company.length  > 0)){
        filter_project.fill_nit_company(filter_nit_company);
    }
});

$('#filter_project_advanced').click(function () {
    let filter_year_pro = $('#filter_year_pro').val();
    filter_project.queryProyectosFaseInicioTable(filter_year_pro);
});

$('#filter_project_modal').click(function () {
    let filter_year_pro = $('#filter_year_pro').val();
    filter_project.queryProyectosFaseInicioTable(filter_year_pro);
});

$('#filter_company_advanced').click(function () {
    
    filter_project.queryCompaniesTable();
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
                    $('#txtnombre_articulacion').val(activity.nombre);
                    $("label[for='txtnombre_articulacion']").addClass('active');
    
                    $('.alert-response').append(`
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent">
                                <div class="card-content">
                                    <span class="card-title p-h-lg p f-12"> `+activity.codigo_actividad+ ` - `+activity.nombre+`</span>
                                    <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: `+ filter_project.formatDate(activity.fecha_cierre)+`</div>
                                    <p>`+activity.objetivo_general+ `</p>
                                    <input type="hidden" name="txtpbt" value="`+response.data.proyecto.id+`"/>
                                </div>
                                <div class="card-action">
                                <a class="orange-text text-darken-1" target="_blank" href="/proyecto/detalle/`+data.proyecto.id+`">Ver más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
    
                    $('.collection-response').append(`
                    <li class="collection-item dismissable">
                        <a target="_blank" href="/proyecto/detalle/`+data.proyecto.id+`" class="secondary-content orange-text"><i class="material-icons">link</i></a>
                        <span class="title">PBT</span>
                        <p>`+activity.codigo_actividad+ `<br>
                            `+activity.nombre+ `
                        </p>
                    </li>
                    <li class="collection-item dismissable">
                        <a  onclick="detallesIdeaPorId(`+data.proyecto.idea.id+`)" class="secondary-content orange-text" >
                        
                            <i class="material-icons">link</i>
                        </a>
                        <span class="title">Idea:</span>
                        
                        <p>`+data.proyecto.idea.codigo_idea+ `<br>
                        `+data.proyecto.idea.nombre_proyecto+ `
                        </p>
                        
                    </li>
                    `);
    
                    if (data.proyecto.articulacion_proyecto.talentos.length != 0) {
                        $.each(data.proyecto.articulacion_proyecto.talentos, function(e, talento) {
                            
                            $('.alert-response-talents').append(`<div class="row card-talent`+talento.user.id+`">
                                    <div class="col s12 m12 l12">
                                        <div class="card bs-dark">
                                            <div class="card-content">
                                                <span class="card-title p-h-lg"> `+talento.user.documento+ ` - `+talento.user.nombres+ ` `+talento.user.apellidos+`</span>
                                                <input type="hidden" name="talentos[]" value="`+talento.id+`"/>
                                                <div class="p-h-lg">
                                                    <input type="radio" checked class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor`+talento.id+`" value="`+talento.id+`" /><label for ="radioInterlocutor`+talento.id+`">Talento Interlocutor</label>
                                                </div>
                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">  Acceso al sistema: `+ userSearch.state(talento.user.estado) +`</div>
                                                <p class="hide-on-med-and-down"> Miembro desde `+filter_project.formatDate(talento.user.created_at)+`</p>
                                            </div>
                                            <div class="card-action">
                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+talento.user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                                                <a onclick="filter_project.deleteTalent( `+talento.user.id+ `);" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
                                            </div>
                                        </div>   
                                    </div>
                                </div>`);
                        });
                    }else{
                        filter_project.notFound('alert-response-talents');
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
            $('.collection-response').append(`
                <li class="collection-item dismissable">
                    <span class="title">Sin resultados</span>                          
                </li>
            `);
        }
        
    },
    fill_nit_company:function(filter_code_company = null){
        
        filter_project.emptyResult('alert-response');
      
        filter_project.emptyResult('alert-response-sedes');
        // filter_project.emptyResult('alert-response-company');
          
        if(filter_code_company.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/empresas/filter-code/' + filter_code_company
            }).done(function (response) {    
                if(response.data.status_code == 200){   
                    let data = response.data;

    
                    if (data.empresa.sedes.length != 0) {
                        $.each(data.empresa.sedes, function(e, sede) {
                            
                            $('.alert-response-sedes').append(`<div class="row card-talent`+sede.id+`">
                                    <div class="col s12 m12 l12">
                                        <div class="card bs-dark">
                                            <div class="card-content">
                                                <span class="card-title p-h-lg"> `+sede.nombre_sede+ `</span>
                                                <input type="hidden" name="sedes" value="`+sede.id+`"/>
                                                
                                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Empresa: `+data.empresa.nit+` - `+data.empresa.nombre+`</div>
                                                
                                            </div>
                                            <div class="card-action">
                                                <a onclick="filter_project.addSedeArticulacionPbt( `+sede.id+ `);" class="waves-effect waves-red btn-flat m-b-xs orange-text">Agregar sede</a>
                                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/empresa/detalle/`+data.empresa.id+ `"><i class="material-icons left"> link</i>Ver más</a>
                                            </div>
                                        </div>   
                                    </div>
                                </div>`);
                        });
                    }else{
                        
                        filter_project.notFound('alert-response-sedes');
                        filter_project.notFound('alert-response-company');
                    }
    
                   
                    
                }else{
                    
                    filter_project.notFound('alert-response-sedes');
                    filter_project.notFound('alert-response-company');
                }
            });
        }else{
            filter_project.notFound('alert-response');
            filter_project.notFound('alert-response-sedes');
        }
        
    },
    sedesEmpresa: function(sedes) {
        let fila = "";
        sedes.forEach(element => {
            fila += `<li class="collection-item">
            ` + element.nombre_sede + ` - ` + element.direccion + `
            <a href="#!" class="secondary-content" onclick="filter_project.addSedeArticulacionPbt(`+element.id+`)">Asociar esta sede a la articulación</a></div>
          </li>`;
        });
        return fila;
    },
    addSedeArticulacionPbt: function(value){
        filter_project.printSede(value);
        $('#sedes_modal').closeModal(); 
        $('#company_modal').closeModal(); 
        
    },
    printSede: function(id){
        filter_project.emptyResult('alert-response-company');
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/empresas/sede/' + id
        }).done(function (response) {
            if(response.data.status_code == 200){   
            $('.alert-response-company').append(`
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card transparent bs-dark">
                            <div class="card-content">
                                <span class="card-title p-h-lg"> `+response.data.sede.nombre_sede+ `</span>
                                <input type="hidden" name="txtsede" value="`+response.data.sede.id+`"/>                   
                            </div>
                        </div>   
                    </div>
                </div>
                `);
            }else{
                filter_project.notFound('alert-response-company');
            }
        });
        
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
    queryCompaniesTable:function() {
        filter_project.emptyResult('alert-response-sedes');
        filter_project.emptyResult('alert-response-company');
        filter_project.notFound('alert-response-sedes');
        filter_project.notFound('alert-response-company');
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
    queryTalentos: function(){
        $('#datatable_talents_art').dataTable().fnDestroy();
        $('#datatable_talents_art').DataTable({
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
                    data: 'add_articulacion_pbt',
                    name: 'add_articulacion_pbt',
                    orderable: false
                },
            ]
        });
        $('#filter_talents_advanced_modal').openModal();
    },
    addProjectToArticulacion:function(code) {
        
        filter_project.fill_code_project(code); 
        filter_project.emptyResult('result-talents'); 
        $('#filter_project_advanced_modal').closeModal();     
    },
    searchUser:function(document){
        $('.result-talents').empty();
        if(document != null || document != null){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/usuarios/filtro-talento/' + document
            }).done(function (response) {
                if(response.data.status_code == 200){
                    let user = response.data.user;
                    $('.result-talents').append(`<div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent">
                                <div class="card-content">
                                    <span class="card-title p f-12 "> `+user.documento+ ` - `+user.nombres+ ` `+user.apellidos+`</span>
                                    <p class="position-top-right p f-12 mail-date hide-on-med-and-down"> Acceso al sistema: `+ userSearch.state(user.estado) +`</p>
                                    <div class="mailbox-text p f-12 hide-on-med-and-down">
                                                Miembro desde `+filter_project.formatDate(user.created_at)+`
                                        </div>
                                </div>
                                <div class="card-action">
                                <a onclick="filter_project.addTalentArticulacionPbt( `+user.talento.id+ `);" class="orange-text">Agregar</a>
                                </div>
                            </div>
                        </div>
                    </div>`);
                }else{
                    filter_project.notFound('result-talents');
                }
            
            });
        }        
    },
    formatDate: function(date){
        if(date == null){
            return "no registra";
        }else{
            return moment(date).format('LL');
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
    emptyResult: function(cl){
        if(cl != null){
            $('.'+ cl).empty();
        }
    },
    addTalentArticulacionPbt: function(talent){
        if (filter_project.noRepeat(talent) == false) {
            filter_project.talentAssociated();
        } else {
            filter_project.emptyResult('talent-empty');
            filter_project.printTalentoInTable(talent);
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
    printTalentoInTable: function(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/usuario/talento/consultarTalentoPorId/' + id
        }).done(function (response) {
            let fila = filter_project.prepareTableRowTalent(response);
            $('.alert-response-talents').append(fila);
        });
    },
    prepareTableRowTalent: function(response) { 
        let data = response;
        let fila =`<div class="row card-talent`+data.talento.id+`">
                        <div class="col s12 m12 l12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title"> `+data.talento.documento+ ` - `+data.talento.talento+ `</span>
                                    <input type="hidden" name="talentos[]" value="`+data.talento.id+`"/>
                                    <input type="radio" checked class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor`+data.talento.id+`" value="`+data.talento.id+`" /><label for ="radioInterlocutor`+data.talento.id+`">Talento Interlocutor</label>
                                </div>
                                <div class="card-action">
                                    <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="/usuario/usuarios/`+data.talento.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                                    <a onclick="filter_project.deleteTalent( `+data.talento.id+ `);" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
                                </div>
                            </div>   
                        </div>
                    </div>`;
        return fila;
    },
    messageArticulacion: function(data, action, title) {
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
        if (data.state == 404) {
            Swal.fire({
                title: 'La articulación no se ha '+action+', por favor inténtalo de nuevo',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            })
        }
    },
    showSeccionProject: function (){
        $('.section-projects').show();
    },
    hideSeccionProject: function (){
        $('.section-projects').hide();
    },
    showSeccionCompany: function (){
        $('.section-company').show();
    },
    hideSeccionCompany: function (){
        $('.section-company').hide();
    },
    showsectionCollapseTalent: function(collap,collapheader,el){
        
        collap[0].classList.remove('active');
        collap[1].classList.add('active');
        collapheader[0].classList.remove('active');
        collapheader[1].classList.add('active');
        el[1].setAttribute("style", "display: block; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;");
    },
    hidesectionCollapseTalent: function(collap,collapheader,el){
        collap[1].classList.remove('active');
        collap[0].classList.add('active');
        collapheader[1].classList.remove('active');
        collapheader[0].classList.add('active');
        el[1].setAttribute("style", "");
    },
    emptySectionProject: function(){
        filter_project.emptyResult('result-talents');
        filter_project.notFound('result-talents');
        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.emptyResult('alert-response-talents');
        $('#txtnombre_articulacion').val();
    }
}


function checkTipoVinculacion(val) {
    let collap =document.getElementsByClassName('collapsible-li');
    let collapheader =document.getElementsByClassName('collapsible-header grey lighten-2');
    let el = document.getElementsByClassName('collapsible-body');
   
    if ( $("#IsPbt").is(":checked") ) {
        filter_project.emptyResult('alert-response-sedes');
        filter_project.emptyResult('alert-response-company');
        filter_project.notFound('alert-response-sedes');
        filter_project.notFound('alert-response-company');
        filter_project.showSeccionProject();
        filter_project.hideSeccionCompany();
        filter_project.hidesectionCollapseTalent(collap,collapheader,el);
    } 
    else if ($("#IsSenaInnova").is(":checked") ) {
      
        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.hideSeccionProject();
        filter_project.showSeccionCompany();
        filter_project.showsectionCollapseTalent(collap,collapheader,el);
    } 
     else if( $("#IsColinnova").is(":checked")) {
        
        filter_project.emptyResult('alert-response');
        filter_project.emptyResult('collection-response');
        filter_project.hideSeccionProject();
        filter_project.showSeccionCompany();
        filter_project.showsectionCollapseTalent(collap,collapheader,el);
    }

}

function addCompanyArticulacion(id){
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
}
