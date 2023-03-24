$(document).ready(function() {
    $('#linea_administrador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax: {
            url: host_url + "/lineas",
        },
        columns: [{
            data: 'abreviatura',
            name: 'abreviatura',
        }, {
            data: 'nombre',
            name: 'nombre',
        },
        {
            data: 'show',
            name: 'show',
            orderable: false
        },{
            data: 'action',
            name: 'action',
            orderable: false
        }]
    });
});

$(document).ready(function() {
    $('#linea_dinamizador_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax: {
            url: host_url + "/lineas",
        },
        columns: [{
            data: 'abreviatura',
            name: 'abreviatura',
        }, {
            data: 'nombre',
            name: 'nombre',
        }, {
            data: 'action',
            name: 'action',
            orderable: false
        }, ],
    });
});

$(document).ready(function() {
    $('#nodos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        "lengthChange": true,
        "responsive": true,
        "bSort": false,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'csv',
            text: 'exportar csv',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'excel',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'pdf',
            exportOptions: {
                columns: ':visible'
            }
        }, ],
        ajax: {
            url: host_url + "/nodo",
        },
        columns: [{
            data: 'centro',
            name: 'centro',
        }, {
            data: 'nodos',
            name: 'nodos',
        }, {
            data: 'direccion',
            name: 'direccion',
        }, {
            data: 'ubicacion',
            name: 'ubicacion',
        }, {
            data: 'detail',
            name: 'detail',
            orderable: false
        },
        ],
    });
});

$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            activeColor: 'blue',
            perPage: 10,
            showPrevNext: false,
            nextText: '',
            prevText: '',
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);

    //$this.addClass('initialized');

    var listElement = $this.find("tbody");
    var perPage = settings.perPage;
    var children = listElement.children();
    var pager = $('.pager');
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }

    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }

    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);
    // $("#total_reg").html(numItems+" Entradas en total");

    pager.data("curr",0);

    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link" title="'+settings.prevText+'"><i class="material-icons">chevron_left</i></a></li>').appendTo(pager);
    }

    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li class="waves-effect"><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }

    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link"  title="'+settings.nextText+'"><i class="material-icons">chevron_right</i></a></li>').appendTo(pager);
    }

    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
  	pager.children().eq(1).addClass("active "+settings.activeColor);

    children.hide();
    children.slice(0, perPage).show();

    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });

    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }

    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }

    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;

        children.css('display','none').slice(startAt, endOn).show();

        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }

        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }

        pager.data("curr",page);
      	pager.children().removeClass("active "+settings.activeColor);
        pager.children().eq(page+1).addClass("active "+settings.activeColor);

    }
};

function inhabilitarFuncionarios(e, rt) {
    e.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de inhabilitar los funcionarios de este nodo?',
        text: 'Al hacerlo estás bloqueando el acceso al sistema de todos los funcionarios de este nodo, luego los deberás volver a inhabilitar desde el menú de usuarios.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, inhabilitar funcionarios!'
    }).then((result) => {
        if (result.value) {
            location.href = rt;
        }
    })
}

function detallesIdeasDelEntrenamiento(id){
  $.ajax({
     dataType:'json',
     type:'get',
     url: host_url + "/taller/"+id,
     data: {
       identrenamiento: id,
     }
  }).done(function(respuesta){
    $("#ideasEntrenamiento").empty();
    if (respuesta != null ) {
      $("#fechasEntrenamiento").empty();
      $("#fechasEntrenamiento").append("<span class='cyan-text text-darken-3'>Fecha del taller de fortalecimiento: </span>"+respuesta[0].fecha_sesion1+"<br>");
      $.each(respuesta, function(i, item) {
        $("#ideasEntrenamiento").append("<tr><td>"+item.codigo_idea+" - "+item.nombre_proyecto+
          "</td><td>"+item.confirmacion+"</td><td>"+item.asistencia1+"</td></tr>");
      });
      $('#modalIdeasEntrenamiento').openModal();
    }
  });
}

function consultarEntrenamientosPorNodo(nodo) {
  $('#entrenamientosPorNodo_table').dataTable().fnDestroy();
  $('#entrenamientosPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    ajax:{
      url: host_url + "/taller/consultarEntrenamientosPorNodo/" + nodo,
      type: "get",
      data: {
        filter_nodo: $('#filter_nodo').val(),
      }
    },
    columns: [
      {
        title: 'Código del Entrenamiento',
        data: 'codigo_entrenamiento',
        name: 'codigo_entrenamiento',
      },
      {
        data: 'fecha_sesion1',
        name: 'fecha_sesion1',
      },
      {
        width: '8%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '8%',
        data: 'evidencias',
        name: 'evidencias',
        orderable: false
      },
    ],
  });
}

$(document).ready(function() {
  $('#txtfecha_sesion1').bootstrapMaterialDatePicker({
    time:false,
    date:true,
    shortTime:true,
    format: 'YYYY-MM-DD',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
  }).on('change', function(e, date)
  {
    $('#txtsegundasesion').bootstrapMaterialDatePicker('setMinDate', date);
  });
});

$(document).on('submit', 'form#formEntrenamientosCreate', function (event) { // $('button[type="submit"]').prop("disabled", true);
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormEntrenamiento(form, data, url, 'create');
        }
    });
});

function ajaxSendFormEntrenamiento(form, data, url, fase) {
  $.ajax({
      type: form.attr('method'),
      url: url,
      data: data,
      cache: false,
      contentType: false,
      dataType: 'json',
      processData: false,
      success: function (data) {
          $('button[type="submit"]').removeAttr('disabled');
          $('.error').hide();
          printErroresFormulario(data);
          mensajesEntrenamientoCreate(data);
      },
      error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
      }
  });
};

function mensajesEntrenamientoCreate(data) {
  if (data.state != 'error_form') {
    Swal.fire({
      title: data.title,
      html: data.msg,
      type: data.type,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    });
  }
  if (data.state == 'registro') {
    setTimeout(function () {
        window.location.href = data.url;
    }, 1500);
  }

  if (data.state == 'update') {
    setTimeout(function () {
        window.location.href = data.url;
    }, 1500);
  }
};

function noRepeatIdeasTaller(id) {
  let idIdea = id;
  let retorno = true;
  let a = document.getElementsByName("ideas_taller[]");
  for (x = 0; x < a.length; x ++) {
      if (a[x].value == idIdea) {
          retorno = false;
          break;
      }
  }
  return retorno;
};

function getValorConfirmacion() {
  if ($('#txtconfirmacion').is(':checked')) {
    return 1;
  } else {
    return 0;
  }
}

function getValorAsistencia() {
  if ($('#txtasistencia').is(':checked')) {
    return 1;
  } else {
    return 0;
  }
}

function addIdeaToEntrenamiento() {
  let id = $('#txtidea_taller').val();
  let confirmacion = getValorConfirmacion();
  let asistencia = getValorAsistencia();
  if (id == 0) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'error',
      title: 'Estás ingresando mal los datos'
  })
  } else {
      if (noRepeatIdeasTaller(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'La idea de proyecto ya se encuentra asociada al taller!'
      });
      } else {
          pintarIdeaEnLaTablaTaller(id, confirmacion, asistencia);
      }
  }
};

function pintarIdeaEnLaTablaTaller(id, confirmacion, asistencia) {
  $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/idea/detallesIdea/' + id
  }).done(function (ajax) {
      let fila = prepararFilaEnLaTablaDeIdeasTaller(ajax, confirmacion, asistencia);
      $('#tblIdeasEntrenamientoForm').append(fila);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'La idea de proyecto se asoció con éxito al taller'
      });
      reiniciarCamposTaller();
  });
}

function reiniciarCamposTaller() {
  $("#txtidea_taller").val('0');
  $("#txtidea_taller").select2();
  }

function prepararFilaEnLaTablaDeIdeasTaller(ajax, confirmacion, asistencia) {
  let idIdea = ajax.detalles.id;
  let fila = '<tr class="selected" id=ideaAsociadaTaller' + idIdea + '>' +
      '<td><input type="hidden" name="ideas_taller[]" value="' + idIdea + '">' + ajax.detalles.codigo_idea + ' - ' + ajax.detalles.nombre_proyecto + '</td>' +
      '<td><input type="hidden" name="confirmaciones[]" value="' + confirmacion + '">' + getYesOrNot(confirmacion) + '</td>' +
      '<td><input type="hidden" name="asistencias[]" value="' + asistencia + '">' + getYesOrNot(asistencia) + '</td>' +
      '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarIdeaDelTaller(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' +
      '</tr>';
  return fila;
}

function eliminarIdeaDelTaller(index) {
  $('#ideaAsociadaTaller' + index).remove();
}

function getYesOrNot(value) {
  if (value == 0) {
    return 'No';
  } else {
    return 'Si';
  }
}

$(document).ready(function() {

    let filter_nodo = $('#filter_nodo').val();
    let filter_year = $('#filter_year_ideas').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();

    consultarIdeasDelTalento();
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }


});

$('#filter_idea').click(function () {
    let filter_nodo = $('#filter_nodo').val();
    // console.log(filter_nodo);
    let filter_year = $('#filter_year_ideas').val();
    let filter_state = $('#filter_state').val();
    let filter_vieneconvocatoria = $('#filter_vieneconvocatoria').val();
    let filter_convocatoria = $('#filter_convocatoria').val();
    $('#ideas_data_table').dataTable().fnDestroy();
    if((filter_nodo == '' || filter_nodo == null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria == '' || filter_convocatoria == null)){
        idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo != '' || filter_nodo != null) && filter_year !='' && filter_state != '' && filter_vieneconvocatoria != '' && (filter_convocatoria != '' || filter_convocatoria != null)){
        idea.fill_datatatables_ideas(filter_nodo, filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria);
    }else{
        $('#ideas_data_action_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false
        }).clear().draw();
        $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_excel').click(function(){
        let filter_nodo = $('#filter_nodo').val();
        let filter_year = $('#filter_year_ideas').val();
        let filter_state = $('#filter_state').val();
        let filter_vieneConvocatoria = $('#filter_vieneconvocatoria').val();
        let filter_convocatoria = $('#filter_convocatoria').val();
        var query = {
            filter_nodo: filter_nodo,
            filter_year: filter_year,
            filter_state: filter_state,
            filter_vieneConvocatoria: filter_vieneConvocatoria,
            filter_convocatoria: filter_convocatoria,
        }
        var url = host_url + "/idea/export?" + $.param(query)
        window.location = url;
});



var idea ={
    fill_datatatables_ideas: function(filter_nodo = null,filter_year='', filter_state='',filter_vieneConvocatoria='', filter_convocatoria = null){
        var datatable = $('#ideas_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            pageLength: 20,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/idea/datatable_filtros",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_year: filter_year,
                    filter_state: filter_state,
                    filter_vieneConvocatoria: filter_vieneConvocatoria,
                    filter_convocatoria: filter_convocatoria,
                }
            },
            columns: [
                {
                    data: 'nodo',
                    name: 'nodo',
                },
                {
                    data: 'codigo_idea',
                    name: 'codigo_idea',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'persona',
                    name: 'persona',
                },
                {
                    data: 'correo_contacto',
                    name: 'correo_contacto',
                },
                {
                    data: 'telefono_contacto',
                    name: 'telefono_contacto',
                },
                {
                    data: 'nombre_proyecto',
                    name: 'nombre_proyecto',
                },
                {
                    data: 'estado',
                    name: 'estado',
                },
                {
                    data: 'info',
                    name: 'info',
                    orderable: false
                },
            ],
        });
    },
    getSelectConvocatoria: function (){
        let convocatoria = $('#txtconvocatoria').val();
        $('#txtnombreconvocatoria').attr("disabled", "disabled");
        if(convocatoria == 1){
            $('#txtnombreconvocatoria').removeAttr("disabled").focus().val('');
        }else if(convocatoria == 0){
            $('#txtnombreconvocatoria').val('');
            $('#txtnombreconvocatoria').attr("disabled", "disabled");
        }else{
            $('#txtnombreconvocatoria').val('');
            $('#txtnombreconvocatoria').attr("disabled", "disabled");
        }
    },

    getSelectAvalEmpresa: function (){
        let avalaEmpresa = $('#txtavalempresa').val();
        $('#txtempresa').attr("disabled", "disabled");
        if(avalaEmpresa == 1){
            $('#txtempresa').removeAttr("disabled").focus().val('');
        }else if(avalaEmpresa == 0){
            $('#txtempresa').val('');
            $('#txtempresa').attr("disabled", "disabled");
        }else{
            $('#txtempresa').val('');
            $('#txtempresa').attr("disabled", "disabled");
        }
    },
    vieneConvocatoria: function(value){
        if(value == 1){
            return "Si";
        }else{
            return "No";
        }
    },
     nombreConvocatoria: function(value, convocatoria){
        if(value == 1){
            return convocatoria;
        }else{
            return "No Aplica";
        }
    },
    avalEmpresa: function(value){
        if(value == 1){
            return "Si";
        }else{
            return "No";
        }
    },
    nombreEmpresa: function(value, empresa){
        if(value == 1){
            return empresa;
        }else{
            return "No Aplica";
        }
    }
}


function cambiarEstadoIdeaDeProyecto(id, estado) {
Swal.fire({
    title: '¿Desea cambiar el estado de la idea de proyecto a '+estado+'?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí'
}).then((result) => {
    if (result.value) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + '/idea/updateEstadoIdea/'+id+'/'+estado,
        success: function (data) {
        Swal.fire({
            title: 'El estado de la idea se ha cambiado exitosamente!',
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Sí'
        }).then((result) => {
            window.location.replace(data.route);
        })
        },
        error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
        }
    })
    }
})

}

function detallesIdeaPorId(id){
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/idea/modalIdeas/"+id
    }).done(function(respuesta){
        $("#detalle_idea").empty();
        if (respuesta == null) {
        swal('Ups!!!', 'Ha ocurrido un error', 'warning');
        } else {
        $("#detalle_idea").append(respuesta.view);
        $('#modalInformacionIdea').openModal();
        }
    })
}

function consultarIdeasDelTalento() {
    // $('#ideas_talento').dataTable().fnDestroy();
    $('#ideas_talento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      "lengthChange": false,
      processing: true,
      serverSide: true,
      pageLength: 20,
      order: [ 0, 'desc' ],
      "lengthChange": false,
      ajax:{
        url: host_url + "/idea/datatable_filtros",
        type: "get",
        data: {
            filter_nodo: null,
            filter_year: null,
            filter_state: null,
            filter_vieneConvocatoria: null,
            filter_convocatoria: null,
        }
      },
      columns: [
        {
          width: '15%',
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        {
          width: '8%',
          data: 'nodo',
          name: 'nodo',
        },
        {
          data: 'nombre_proyecto',
          name: 'nombre_proyecto',
        },
        {
          data: 'estado',
          name: 'estado',
        },
        {
          width: '8%',
          data: 'info',
          name: 'info',
          orderable: false
        },
        {
          width: '8%',
          data: 'postular',
          name: 'postular',
          orderable: false
        },
        {
          width: '8%',
          data: 'edit',
          name: 'edit',
          orderable: false
        },
      ],
    });
}

function confirmacionPostulacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de postular esta idea de proyecto?',
  text: "Una vez que se postule la idea de proyecto, ya no se podrá cambiar los datos de esta.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmPostularIdea.submit();
    }
  })
}

function confirmacionInhabilitar(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de inhabilitar esta idea de proyecto?',
  text: "Esto quiere decir que esta idea de proyecto no se le podrá realizar un proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmInhabilitarIdea.submit();
    }
  })
}

$(document).ready(function () {
    // Contenedores
    divProductoParecido = $('#productoParecido_content');
    divReemplaza = $('#reemplaza_content');
    divPacking = $('#packing_content');
    divRequisitosLegales = $('#requisitosLegales_content');
    divCertificaciones = $('#certificaciones_content');
    divRecursos = $('#recursos_content');
    divConvocatoria = $('#convocatoria_content');
    divAvalEmpresa = $('#avalEmpresa_content');
    divBuscarEmpresa = $('#buscarEmpresa_content');
    divRegistrarEmpresa = $('#registrarEmpresa_content');
    divEmpresaRegistrada = $('#consultarEmpresa_content');
    // Ocultar contenedores
    divProductoParecido.hide();
    divReemplaza.hide();
    divPacking.hide();
    divRequisitosLegales.hide();
    divCertificaciones.hide();
    divRecursos.hide();
    divConvocatoria.hide();
    divAvalEmpresa.hide();
    divBuscarEmpresa.hide();
    divRegistrarEmpresa.hide();
    divEmpresaRegistrada.hide();

    showInput_ProductoParecido();
    showInput_Reemplaza();
    showInput_Packing();
    showInput_RequisitosLegales();
    showInput_Certificaciones();
    showInput_Recursos();
    showInput_Convocatoria();
    showInput_AvalEmpresa();
    showInput_BuscarEmpresa();
});

divRegistrarEmpresa = $('#divRegistrarEmpresa');
divIngresarEmpresaIdea = $('#divIngresarEmpresaIdea');
divEmpresaRegistrada = $('#divEmpresaRegistrada');
divIngresarEmpresaIdea.hide();
divRegistrarEmpresa.hide();
divEmpresaRegistrada.hide();

function consultarEmpresaTecnoparque() {
    let nit = $('#txtnit').val();
    let field = 'nit';
    if (nit.length < 9 || nit.length > 13) {
        Swal.fire({
            title: 'Advertencia!',
            text: "El nit de la empresa debe tener entre 9 y 13 dígitos!",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
    } else {
        if (nit == "") {
          Swal.fire({
            title: 'Advertencia!',
            text: "Digite el nit de la empresa!",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        } else {
          $.ajax({
            dataType: 'json',
            type: 'get',
            url : host_url + '/empresa/ajaxDetallesDeUnaEmpresa/'+nit+'/'+field,
            success: function (response) {
              if (response.empresa == null) {
                divEmpresaRegistrada.hide();
                divRegistrarEmpresa.show();
                $('#txtnit_empresa').val(nit);
                $("label[for='txtnit_empresa']").addClass('active');
              } else {
                let registros;
                asignarValoresFRMIdeas(response);
                divEmpresaRegistrada.show();
                divRegistrarEmpresa.hide();
                reiniciarSede();
                registros = mostrarSedesEmpresa(response);
                $('#sedesEmpresaFormIdea').append(registros);
              }
            },
            error: function (xhr, textStatus, errorThrown) {
              alert("Error: " + errorThrown);
            }
          })
        }
    }
}

function reiniciarSede() {
  $('#sedesEmpresaFormIdea').empty();
  $('#txtsede_id').val('');
  $('#txtnombre_sede_disabled').val('Primero debes seleccionar una sede');
}

function mostrarSedesEmpresa(ajax) {
  let fila = "";
  ajax.empresa.sedes.forEach(element => {
    fila += `<li class="collection-item">
      ` + element.nombre_sede + ` - ` + element.direccion + ` ` + element.ciudad.nombre + ` (` + element.ciudad.departamento.nombre + `)
      <a href="#!" class="secondary-content" onclick="asociarSedeAIdeaProyecto(`+element.id+`)">Asociar esta sede de la empresa a la idea de proyecto</a></div>
    </li>`;
  });
  return fila
}

function asociarSedeAIdeaProyecto(sede_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url : host_url + '/empresa/ajaxDetalleDeUnaSede/'+sede_id,
    success: function (response) {
      $('#txtsede_id').val(response.sede.id);
      $('#txtnombre_sede_disabled').val(response.sede.nombre_sede + ' - ' + response.sede.direccion + ' ' + response.sede.ciudad.nombre + ' (' + response.sede.ciudad.departamento.nombre + ')');
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La sede '+response.sede.nombre_sede+' se asoció a la idea de proyecto!'
    });
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    }
  })
}

  $(document).on('click', '.btnModalIdeaCancelar', function(event) {
    Swal.close();
  });

  $(document).on('click', '.btnModalIdeaGuardar', function(event) {
    $('#txtopcionRegistro').val('guardar');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'create');
  });

  $(document).on('click', '.btnModalIdeaModificar', function(event) {
    $('#txtopcionRegistro').val('guardar');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'update');
  });
  
  $(document).on('click', '.btnModalIdeaPostular', function(event) {
    $('#txtopcionRegistro').val('postular');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'create');
  });
  
  $(document).on('click', '.btnModalIdeaPostularModificar', function(event) {
    $('#txtopcionRegistro').val('postular');
    Swal.clickConfirm();
    enviarIdeaRegistro(event, 'update');
  });

  function modalOpcionesFormulario(e) {
    e.preventDefault();
    Swal.fire({
    title: 'Guardar información',
    html: "¿Qué desea hacer?" +
        "<br>" +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaGuardar swal2-guardar-custom">' + 'Guardar' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaPostular swal2-postular-custom">' + 'Postular' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaCancelar swal2-cancelar-custom">' + 'Cancelar' + '</button>',
    showCancelButton: false,
    showConfirmButton: false,
    type: 'warning',
    })
  }

  function modalOpcionesFormularioModificar(e) {
    e.preventDefault();
    Swal.fire({
    title: 'Modificar información',
    html: "¿Qué desea hacer?" +
        "<br>" +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaModificar swal2-guardar-custom">' + 'Modificar' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaPostularModificar swal2-postular-custom">' + 'Postular' + '</button>' +
        '<button type="button" role="button" tabindex="0" class="btnModalIdeaCancelar swal2-cancelar-custom">' + 'Cancelar' + '</button>',
    showCancelButton: false,
    showConfirmButton: false,
    type: 'warning',
    })
  }

function enviarIdeaRegistro(event, tipo) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = null;
    var data = null;
    
    if (tipo == 'create') {
        form = $('#frmIdea_Inicio');
        data = new FormData($('#frmIdea_Inicio')[0]);
    } else {
        form = $('#frmIdea_Update');
        data = new FormData($('#frmIdea_Update')[0]);
    }
    var url = form.attr("action");
    ajaxSendFormIdea(form, data, url);
}

function asignarValoresFRMIdeas(response) {
    $('#txtnombre_empresa_det').val(response.empresa.nombre);
    $("label[for='txtnombre_empresa_det']").addClass('active');
    $('#txttipo_empresa_det').val(response.empresa.tipoempresa.nombre);
    $("label[for='txttipo_empresa_det']").addClass('active');
    $('#txttamanho_empresa_det').val(response.empresa.tamanhoempresa.nombre);
    $("label[for='txttamanho_empresa_det']").addClass('active');
    $('#txtsector_empresa_det').val(response.empresa.sector.nombre);
    $("label[for='txtsector_empresa_det']").addClass('active');
    $('#txtnit_empresa').val(response.empresa.nit);
  }

function ajaxSendFormIdea(form, data, url) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            mensajesIdeaForm(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function pintarMensajeIdeaForm(title, text, type) {
    Swal.fire({
        title: title,
        html: text,
        type: type,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}

function mensajesIdeaForm(data) {
    let title = "error";
    let text = "error";
    let type = "error";
    title = data.title;
    text = data.msg;
    type = data.type;
    
    if (data.state != 'error_form') {
        pintarMensajeIdeaForm(title, text, type);
    }
    
    if (data.state == 'registro') {
        setTimeout(function () {
            window.location.href = data.url;
        }, 5000);
    }

    if (data.state == 'update') {
        setTimeout(function () {
            window.location.href = data.url;
        }, 5000);
    }
};


function showInput_ProductoParecido() {
    if ($('#txtproducto_parecido').is(':checked')) {
        divProductoParecido.show();
    } else {
        divProductoParecido.hide();
    }
}

function showInput_Reemplaza() {
    if ($('#txtreemplaza').is(':checked')) {
        divReemplaza.show();
    } else {
        divReemplaza.hide();
    }
}

function showInput_Packing() {
    if ($('#txtpacking').is(':checked')) {
        divPacking.show();
    } else {
        divPacking.hide();
    }
}

function showInput_RequisitosLegales() {
    if ($('#txtrequisitos_legales').is(':checked')) {
        divRequisitosLegales.show();
    } else {
        divRequisitosLegales.hide();
    }
}

function showInput_BuscarEmpresa() {
    if ($('#txtidea_empresa').is(':checked')) {
        divBuscarEmpresa.show();
    } else {
        divBuscarEmpresa.hide();
    }
}

function showInput_Certificaciones() {
    if ($('#txtrequiere_certificaciones').is(':checked')) {
        divCertificaciones.show();
    } else {
        divCertificaciones.hide();
    }
}

function showInput_Recursos() {
    if ($('#txtrecursos_necesarios').is(':checked')) {
        divRecursos.show();
    } else {
        divRecursos.hide();
    }
}

function showInput_Convocatoria() {
    if ($('#txtviene_convocatoria').is(':checked')) {
        divConvocatoria.show();
    } else {
        divConvocatoria.hide();
    }
}

function showInput_AvalEmpresa() {
    if ($('#txtaval_empresa').is(':checked')) {
        divAvalEmpresa.show();
    } else {
        divAvalEmpresa.hide();
    }
}

function banderaEmpresaIdea() {
  if ($('#bandera_empresa').is(':checked')) {
    divIngresarEmpresaIdea.show();
  } else {
    divIngresarEmpresaIdea.hide();
    divRegistrarEmpresa.hide();
    divEmpresaRegistrada.hide();
  }
}

function mensajesIdeaCreate(data) {
  if (data.state == 'registro') {
      Swal.fire({
          title: 'Registro Exitoso',
          text: "La idea de proyecto ha sido registrada satisfactoriamente",
          type: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      });
      setTimeout(function () {
          window.location.replace("/idea");
      }, 1000);
  }
  if (data.state == 'no_registro') {
      Swal.fire({
          title: 'La idea de proyecto no se ha registrado, por favor inténtalo de nuevo',
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      })
  }
};

function mensajesIdeaUpdate(data) {
  if (data.state == 'update') {
      Swal.fire({
          title: 'Modificación Exitosa',
          text: "La idea de proyecto ha sido modificada satisfactoriamente",
          type: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      });
      setTimeout(function () {
          window.location.replace("/idea");
      }, 1000);
  }
  if (data.state == 'no_update') {
      Swal.fire({
          title: 'La idea de proyecto no se ha modificado, por favor inténtalo de nuevo',
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
      })
  }
};
function confirmacionDuplicacion(e){
  e.preventDefault();
  Swal.fire({
  title: '¿Está seguro(a) de duplicar esta idea de proyecto?',
  text: "Esto se recomienda hacer en caso de que se quiera continuar con el proceso en tecnoparque.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Sí!'
  }).then((result) => {
    if (result.value) {
      document.frmDuplicarIdea.submit();
    }
  })
}

function confirmacionAceptacionPostulacion(e) {
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aceptar la postulación de esta idea de proyecto?',
    input: 'textarea',
    inputPlaceholder: 'Puedes dejar algunas observaciones para el talento',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Se necesitan unas observaciones!'
      } else {
        $('#txtobservacionesAceptacion').val(value);
      }
    },
    inputAttributes: {
      maxlength: 2100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        document.frmAceptarPostulacionIdea.submit();
        // window.location.href = "{{ route('idea.aceptar.postulacion', $idea->id) }}";
      }
    })
  }

  function confirmacionRechazoPostulacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de devolver la postulación de esta idea de proyecto?',
    input: 'textarea',
    inputPlaceholder: 'Por favor, escriba los motivos por los cuales se está devolviendo la postulación de la idea de proyecto',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Los motivos por los cuales se devuelve la idea deben ser obligatorios!'
      } else {
        $('#txtmotivosRechazo').val(value);
      }
    },
    inputAttributes: {
      maxlength: 2100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
      if (result.value) {
        document.frmRechazarPostulacionIdea.submit();
      }
    })
  }
function enviarNotificacionResultadosCSIBT(idea, comite) {
    $.ajax({
        type: 'get',
        url: host_url + '/csibt/notificar_resultado/' + idea + '/' + comite,
        dataType: 'json',
        processData: false,
        success: function (data) {
            if (data.state == 'notifica') {
                notificacionExitosaDelResultado(data);
            } else {
                notificacionFallidaDelResultado();
            }
            
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function notificacionExitosaDelResultado(data) {
    Swal.fire({
        title: 'Notificación Exitosa!',
        text: "Se ha enviado un mensaje a la dirección: " + data.idea + " con los resultados del comité.",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}

function notificacionFallidaDelResultado() {
    Swal.fire({
        title: 'Notificación Fallida!',
        text: "No se ha logrado enviar una mensaje con los resultados del comité al talento.",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
}
$(document).on('submit', 'form#formComiteAsignarCreate', function (event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        text: "No podrás revertir estos cambios!",
        // text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los expertos puedes cambiar esta información",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteAsignar(form, data, url, 'create');
        }
    });
});

function confirmacionDuplicidad(e, route){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de duplicar esta idea de proyecto?',
    text: "Debes tener en cuenta que a partir de esta idea se va a registrar mas de un TRL.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        Swal.fire({
            title: 'Verificación. ¿Está seguro(a) de duplicar esta idea de proyecto?',
            text: "Esta acción no se podrá revertir.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Continuar!'
            }).then((result) => {
              if (result.value) {
                  location.href = route;
              }
            })
      }
    })
  }

function ajaxSendFormComiteAsignar(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesComiteAsignarCreate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesComiteAsignarCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La asignación de ideas de proyecto del comité ha sido registrada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/csibt");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'La asignación de ideas de proyecto del comité no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};
function addIdeaComite() {
    let id = $('#txtideaproyecto').val();
    let hora = $('#txthoraidea').val();
    let direccion = $('#txtdireccion').val();
    if (id == 0 || hora == '' || direccion == '') {
        datosIncompletosAgendamiento();
    } else {
        if (noRepeatIdeasAgendamiento(id) == false) {
            ideaYaSeEncuentraAsociadaAgendamiento();
        } else {
            pintarIdeaEnLaTabla(id, hora, direccion);
        }
    }
}

function addGestorComite2(value) {
    if ($('#gestor-' + value).is(':checked')) {
        // $('#gestorFila'+value).addClass('grey darken-2');
        $('#txthorainiciogestor-' + value).removeAttr('disabled');
        $('#txthorafingestor-' + value).removeAttr('disabled');
    } else {
        $('#gestorFila'+value).removeClass();
        $('#txthorainiciogestor-' + value).attr('disabled', 'disabled');
        $('#txthorainiciogestor-' + value).val(null);
        $('#txthorafingestor-' + value).attr('disabled', 'disabled');
        $('#txthorafingestor-' + value).val(null);
    }
}

$('#txthoraidea').bootstrapMaterialDatePicker({
    time:true,
    date:false,
    shortTime:true,
    format: 'HH:mm',
    // minDate : new Date(),
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
});

$('input[name*="horas_fin"]').bootstrapMaterialDatePicker({
    time:true,
    date:false,
    shortTime:true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
});

$('input[name*="horas_inicio"]').bootstrapMaterialDatePicker({
    time:true,
    date:false,
    shortTime: true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
 });

$('#txthorafingestor').bootstrapMaterialDatePicker({
    time:true,
    date:false,
    shortTime: true,
    format: 'HH:mm',
    language: 'es',
    weekStart : 1, cancelText : 'Cancelar',
    okText: 'Guardar'
 });

$(document).on('submit', 'form#formComiteAgendamientoCreate', function (event) { // $('button[type="submit"]').prop("disabled", true);
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteAgendamiento(form, data, url, 'create');
        }
    });
});

$(document).on('submit', 'form#formComiteAgendamientoUpdate', function (event) { // $('button[type="submit"]').prop("disabled", true);
event.preventDefault();
Swal.fire({
    title: '¿Está seguro(a) de guardar esta información?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí, guardar'
  }).then((result) => {
    if (result.value) {
        $('button[type="submit"]').attr('disabled', 'disabled');
        event.preventDefault();
        var form = $(this);
        var data = new FormData($(this)[0]);
        var url = form.attr("action");
        ajaxSendFormComiteAgendamiento(form, data, url, 'update');
    }
  })
});

// Elimina una idea de proyecto agendada en un comité
function eliminarIdeaDelAgendamiento(index) {
    $('#ideaAsociadaAgendamiento' + index).remove();
}

// Elimina un experto agendado en un comité
function eliminarGestorDelAgendamiento(index) {
    $('#gestorAsociadoAgendamiento' + index).remove();
}

function ajaxSendFormComiteAgendamiento(form, data, url, fase) {
$.ajax({
    type: form.attr('method'),
    url: url,
    data: data,
    cache: false,
    contentType: false,
    dataType: 'json',
    processData: false,
    success: function (data) {
        $('button[type="submit"]').removeAttr('disabled');
        $('.error').hide();
        printErroresFormulario(data);
        if (fase == 'create') {
            mensajesComiteAgendamientoCreate(data);
        } else {
            mensajesComiteAgendamientoUpdate(data);
        }
    },
    error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
    }
});
};

function mensajesComiteAgendamientoCreate(data) {
if (data.state == 'registro') {
    Swal.fire({
        title: 'Registro Exitoso',
        text: "El comité ha sido registrado satisfactoriamente",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
    setTimeout(function () {
        window.location.replace("/csibt");
    }, 1000);
}
if (data.state == 'no_registro') {
    Swal.fire({
        title: 'El comité no se ha registrado, por favor inténtalo de nuevo',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}
};

function mensajesComiteAgendamientoUpdate(data) {
if (data.state == 'update') {
    Swal.fire({
        title: 'Modificación Exitosa',
        text: "El comité se ha modificado satisfactoriamente",
        type: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
    setTimeout(function () {
        window.location.replace("/csibt");
    }, 1000);
}
if (data.state == 'no_update') {
    Swal.fire({
        title: 'El comité no se ha modificado, por favor inténtalo de nuevo',
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}
};

function pintarIdeaEnLaTabla(id, hora, direccion) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/idea/detallesIdea/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDeIdeas(ajax, hora, direccion);
        $('#tblIdeasComiteCreate').append(fila);
        ideaSeAsocioAlAgendamiento();
        reiniciarCamposAgendamiento();
    });
}

function prepararFilaEnLaTablaDeIdeas(ajax, hora, direccion) {
let idIdea = ajax.detalles.id;
let fila = '<tr class="selected" id=ideaAsociadaAgendamiento' + idIdea + '>' +
    '<td><input type="hidden" name="ideas[]" value="' + idIdea + '">' + ajax.detalles.nombre_proyecto + '</td>' +
    '<td><input type="hidden" name="horas[]" value="' + hora + '">' + hora + '</td>' +
    '<td><input type="hidden" name="direcciones[]" value="' + direccion + '">' + direccion + '</td>' +
    '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarIdeaDelAgendamiento(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' +
    '</tr>';
return fila;
}

function datosIncompletosAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    type: 'error',
    title: 'Estás ingresando mal los datos'
})
}


function ideaSeAsocioAlAgendamiento() {
Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'La idea de proyecto se asoció con éxito al comité'
        })
}

function ideaYaSeEncuentraAsociadaAgendamiento() {
Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'warning',
    title: 'La idea de proyecto ya se encuentra asociada al comité!'
});
}

function noRepeatIdeasAgendamiento(id) {
let idIdea = id;
let retorno = true;
let a = document.getElementsByName("ideas[]");
for (x = 0; x < a.length; x ++) {
    if (a[x].value == idIdea) {
        retorno = false;
        break;
    }
}
return retorno;
}

function reiniciarCamposAgendamiento() {
$("#txtideaproyecto").val('0');
$("#txtideaproyecto").select2();
$('#txthoraidea').val('');
$("#txtobservacionesidea").val('');
$('#txtdireccion').val('');
$("label[for='txtdireccion']").removeClass('active');
$("label[for='txthoraidea']").removeClass('active');
}

$(document).on('submit', 'form#formComiteRealizadoCreate', function (event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de guardar esta información?',
        // text: "You won't be able to revert this!",
        text: "Debes tener en cuenta mientras el dinamizador no asigne las ideas de proyectos a los expertos puedes cambiar esta información",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, guardar'
    }).then((result) => {
        if (result.value) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            ajaxSendFormComiteRealizado(form, data, url, 'create');
        }
    });
});

function ajaxSendFormComiteRealizado(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesComiteRealizadoCreate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesComiteRealizadoCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "La calificación del comité ha sido registrada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace("/csibt");
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'La calificación del comité no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};
// Ajax para consultar los comités de un nodo y mostrarlos en la tabla
function consultarCsibtPorNodo() {
  let id = $('#txtnodo').val();
  $('#comitesDelNodo_table').dataTable().fnDestroy();
  $('#comitesDelNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: host_url + "/csibt/"+id+"/consultarCsibtPorNodo",
      type: "get",
    },
    columns: [
      {
        data: 'codigo',
        name: 'codigo',
      },
      {
        data: 'fechacomite',
        name: 'fechacomite',
      },
      {
        data: 'estadocomite',
        name: 'estadocomite',
      },
      {
        data: 'observaciones',
        name: 'observaciones',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
    ],
  });
}

$(document).ready(function() {
    $('#empresasDeTecnoparque_table').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax:{
        url: host_url + "/empresa/datatableEmpresasDeTecnoparque",
        type: "get",
        },
        columns: [
        {
            data: 'nit',
            name: 'nit',
        },
        {
            data: 'nombre_empresa',
            name: 'nombre_empresa',
        },
        {
            data: 'sector_empresa',
            name: 'sector_empresa',
        },
        {
            data: 'details',
            name: 'details',
            orderable: false
        }
        ],
    });
});
$(document).on('submit', 'form#formRegisterCompany', function (event) {

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
        $('button[type="submit"]').prop("disabled", false);
        $('.error').hide();
        printErroresFormulario(data);
        if (data.state == 'error' && data.url == false) {
        Swal.fire({
            title: 'La empresa no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
        }
        if (data.state == 'success' && data.url != false) {
        Swal.fire({
            title: 'Registro Exitoso',
            text:  data.message,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
        });
        setTimeout(function(){
            window.location.href = data.url;
        }, 1000);
        }
    },
    });
});

$(document).on('submit', 'form#formEditCompany', function (event) {
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
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formEditCompanyHq', function (event) {
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
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formAddCompanyHq', function (event) {
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
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'store') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formEditResponsable', function (event) {
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
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                Swal.fire({
                    title: data.title,
                    html: data.msg,
                    type: data.type,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }

            if (data.state == 'update') {
                setTimeout(function () {
                    window.location.href = data.url;
                }, 1500);
            }
        },
    });
});

$(document).on('submit', 'form#formSearchEmpresas', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    $('#empresas_encontradas').empty();
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
            if (data.empresas.length == 0) {
                $('#empresas_encontradas').append(`
                    <div class="row">
                        <ul class="collection with-header">
                            <li class="collection-header"><h5>No se encontraron empresas</h5></li>
                        </ul>
                    </div>
                `);
            } else {
                if (data.state == 'search') {
                    $('#empresas_encontradas').append(`<div class="row">`);
                        $.each( data.empresas, function( key, empresa ) {
                        let route = data.urls[key];
                        $('#empresas_encontradas').append(`
                            <ul class="collection">
                                <li class="collection-item"><h5>`+empresa.nit+` - `+empresa.nombre+`</h5></li>
                                <li class="collection-item"><a href=`+route+`>Ver detalles</a></li>
                            </ul>
                        `);
                    });
                    $('#empresas_encontradas').append(`</div>`);
                }
            }
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
        },
    });
});

$('#txttipogrupo').change(function () {
  let idtipo = $('#txttipogrupo').val();
  if (idtipo == 1) {
    $('#txtinstitucion').val('SENA');
    $('#labelins').addClass('active', true)
  } else if (idtipo == 0) {
    $('#txtinstitucion').val('');
    $('#labelins').removeClass('active')
  }
});

$(document).ready(function() {
  $('#grupoDeInvestigacionTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    // order: false,
    ajax:{
      url: host_url + "/grupo/datatableGruposInvestigacionDeTecnoparque",
      type: "get",
    },
    columns: [
      {
        data: 'codigo_grupo',
        name: 'codigo_grupo',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'ciudad',
        name: 'ciudad',
      },
      {
        data: 'tipo_grupo',
        name: 'tipo_grupo',
      },
      {
        data: 'institucion',
        name: 'institucion',
      },
      {
        data: 'clasificacioncolciencias',
        name: 'clasificacioncolciencias',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
});

var grupoInvestigacionIndex = {
  consultarDetallesDeUnGrupoInvestigacion:function(id){
    $.ajax({
      dataType:'json',
      type:'get',
      url: host_url + "/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+id
    }).done(function(respuesta){
      $("#modalDetalleDeUnGrupoDeInvestigacion_titulo").empty();
      $("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").empty();
      if (respuesta == null) {
        swal('Ups!!', 'Ha ocurrido un error', 'warning');
      } else {
        let tipo_grupo = "Interno";
        if (respuesta.detalles.tipogrupo == 0) {
          tipo_grupo = 'Externo';
        }
        $("#modalDetalleDeUnGrupoDeInvestigacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>");
        $("#modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa").append("<div class='row'>"
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.codigo_grupo+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.entidad.nombre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.entidad.email_entidad+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.entidad.ciudad.nombre+' - '+respuesta.detalles.entidad.ciudad.departamento.nombre+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+tipo_grupo+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.institucion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.clasificacioncolciencias.nombre+'</span>'
        +'</div>'
        +'</div>'
      );
      $('#detalleDeUnGrupoDeInvestigacion').openModal();
    }
  });
  },
}

//Enviar formulario
$(document).on('submit', 'form#formSearchUser', function (event) {
    event.preventDefault();
    $('#response-alert').empty();
    let type = $('#txttype_search').val();
    let search = $('#txtsearch_user').val();
    let patronDocumento=new RegExp('^[0-9]{6,11}$');
    let patronEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(type == ''){
        Swal.fire(
            'Error',
            'Por favor selecciona una opción',
            'error'
          );
    }else if(type == 1 && (search == null || search == '' || !patronDocumento.test(search))){
        Swal.fire(
            'Error',
            'Por favor ingrese un número de documento válido',
            'error'
          );
    }else if(type == 2 && (search == null || search == '' || !patronEmail.test(search))){
        Swal.fire(
            'Error',
            'Por favor ingrese un correo electrónico válido',
            'error'
          );
    }else{
        var form = $(this);
        let data = new FormData($(this)[0]);
        var url = form.attr("action");
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                $('button[type="submit"]').removeAttr('disabled');
                $('.error').hide();
                $('#response-alert').empty();

                if (data.fail) {
                    Swal.fire({
                        title: 'Registro Erróneo',
                        html: "Estas ingresando mal los datos. " + errores,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }

                if(data.status == 202){
                    if(type == 1){
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a class="primary-text center-align" href="`+data.url+`">Registrar nuevo usuario</a>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }else{
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a target="_blank" class="primary-text center-align" href="`+data.url+`">Registrar nuevo usuario</a>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }

                }else if(data.status == 200){
                    $('#response-alert').append(`
                    <div class="mailbox-list">
                        <ul>
                            <li >
                                <a href="`+data.url+`" class="mail-active">

                                    <h5 class="mail-author">`+data.user.documento+` - `+data.user.nombres +` `+ data.user.apellidos+`</h5>
                                    <h4 class="mail-title">`+data.roles+`</h4>
                                    <p class="hide-on-small-and-down mail-text">Miembro desde `+userSearch.userCreated(data.user.created_at)+`</p>
                                    <div class="position-top-right p f-12 mail-date"> Acceso al sistema: `+ userSearch.state(data.user.estado) +`</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    `);
                }
            }
        });
    }
});
var userSearch = {
    state: function (state){
        if(state){
            return 'Si';
        }else{
            return 'No';
        }
    },
    userCreated: function (date){
        if(date == null){
            return "no registra";
        }else{
            return moment(date).format('LL');
        }
    },
    changetextLabel: function(){
        let option = $('#txttype_search').val();
        $("#txtsearch_user").val('');
        if(option == 1){
            $("label[for='txtsearch_user']").text('Número de documento');
        }else if(option == 2){
            $("label[for='txtsearch_user']").text('Correo Electrónico');
        }
    }
}


var user = {
    getCiudadExpedicion:function(){
        let id;
        id = $('#txtdepartamentoexpedicion').val();
        $.ajax({
          dataType:'json',
          type:'get',
          url: host_url + '/usuario/getciudad/'+id
        }).done(function(response){
          $('#txtciudadexpedicion').empty();
        //   $('#txtciudadexpedicion').append('<option value="">Seleccione la Ciudad</option>')
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
            // $('.otraeps').css("display:block");
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
          url: host_url + '/usuario/getciudad/'+id
        }).done(function(response){
          $('#txtciudad').empty();
          $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
          $.each(response.ciudades, function(i, e) {
            $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
          })
          
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
    }
}


$(document).ready(function() {
    $('#txtocupaciones').select2({
        language: "es",
        isMultiple: true
    });
    estudios.getOtraOcupacion();
});

var estudios = {
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

$(document).ready(function() {
    // $(".aprendizSena").hide();
    tipoTalento.getSelectTipoTalento();
});

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
        // $(".aprendizSena").css("display", "none");
        $(".aprendizSena").hide();

    },
    hideEgresadoSena: function(){
        // $(".egresadoSena").css("display", "none");
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
            url: host_url + '/centro-formacion/getcentrosregional/'+regional
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
            url: host_url + '/centro-formacion/getcentrosregional/'+regional
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
            url: host_url + '/centro-formacion/getcentrosregional/'+regional
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
            url: host_url + '/centro-formacion/getcentrosregional/'+regional
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
            title: 'El Usuario no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        }
        if (data.state == 'success' && data.url != false) {
          Swal.fire({
            title: 'Registro Exitoso',
            text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido creado satisfactoriamente`,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
            footer: '<p class="red-text">Hemos enviado un correo electrónico al  usuario ' + data.user.nombres + ' '+ data.user.apellidos+ ' con las credenciales de ingreso a la plataforma.</p>'
          });
          setTimeout(function(){
            window.location.href = data.url;
          }, 1000);
        }
      },
      // error: function (xhr, textStatus, errorThrown) {
      //   alert("Error: " + errorThrown);
      // }
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

$(document).on('submit', 'form#formEditUser', function (event) {
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
    
          $('button[type="submit"]').removeAttr('disabled');
          $('button[type="submit"]').prop("disabled", false);
          $('.error').hide();
          if (data.fail) {
  
            for (control in data.errors) {
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
  
            EditUser.printErroresFormulario(data);
          }
          if (data.state == 'error') {
            Swal.fire({
              title: 'La cuenta del usuario no se ha modificado, por favor inténtalo de nuevo',
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
                window.location.href = data.url;
              }, 1000);
          }
          if (data.state == 'success') {
            Swal.fire({
                title: 'Modifciación Exitosa',
                text: `La cuenta del usuario ha sido modificada satisfactoriamente`,
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.href = data.url;
            }, 1000);
          }
        },
        
      });
});


var EditUser = {
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

$(document).on('submit', 'form#FormConfirmUser', function (event) {
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
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            if (data.fail) {
                for (control in data.errors) {
                    $('#' + control + '-error').html(data.errors[control]);
                    $('#' + control + '-error').show();
                }
            EditUser.printErroresFormulario(data);
            }
            if (data.state == 'error' && data.url == false) {
                Swal.fire({
                    title: 'El Usuario no se ha modificado, por favor inténtalo de nuevo',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }
            if (data.state == 'success' && data.url != false) {
                Swal.fire({
                    title: 'Modifciación Exitosa',
                    text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido modificado satisfactoriamente`,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                setTimeout(function(){
                    window.location.href = data.url;
                }, 1000);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    });
});



var changeNode = {
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
    },
}

$(document).on('submit', 'form#FormChangeNodo', function (event) {
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

            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').prop("disabled", false);
            $('.error').hide();
            if (data.fail) {
                for (control in data.errors) {
                    $('#' + control + '-error').html(data.errors[control]);
                    $('#' + control + '-error').show();
                }
                changeNode.printErroresFormulario(data);
            }
            if (data.state == 'error' && data.url == false)
            {
                Swal.fire({
                    title: 'El Usuario no se ha modificado, por favor inténtalo de nuevo',
                    text: "Recuerde que si lo elimina no lo podrá recuperar.",
                    type: 'warning',
                    text: data.message,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ok',
                    cancelButtonText: 'Ver actividades sin finalzar',
                }).then((result) => {
                    if (result.value) {

                    }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                        let activitiesFinalizar ="";
                        $.each( data.activities, function( key, val ) {
                            activitiesFinalizar += '</br><b> ' + key + ' - ' + val + ' </b> ';
                        });
                        Swal.fire({
                            title: 'actividades sin finalzar',
                            html: activitiesFinalizar,
                            type: 'info',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });

                    }
                })
            }
            if (data.state == 'success' && data.url != false) {
                Swal.fire({
                    title: 'Modifciación Exitosa',
                    text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido modificado satisfactoriamente`,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                setTimeout(function(){
                    window.location.href = data.url;
                }, 1000);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    });
});

$(document).ready(function() {
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();

    $('#users_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null) && (filter_role !='' || filter_role != null) && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo , filter_role, filter_state, filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_role == '' || filter_role == null || filter_role == undefined) && filter_state != '' && (filter_year == '' || filter_year == null || filter_year == undefined)){
        UserIndex.fillDatatatablesUsers(filter_nodo = null , filter_role = null, filter_state, filter_year = null);
    }else{
        $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

    $('#mytalento_data_table').dataTable().fnDestroy();
    if(filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_year, filter_state);
    }else{
        $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var UserIndex = {
    fillDatatatablesUsers(filter_nodo ,filter_role, filter_state, filter_year){
        var datatable = $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            responsive: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/usuario",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_role: filter_role,
                    filter_state: filter_state,
                    filter_year: filter_year,
                }
            },
            columns: [
                {
                    data: 'tipodocumento',
                    name: 'tipodocumento',
                }, {
                    data: 'documento',
                    name: 'documento',
                }, {
                    data: 'nombrecompleto',
                    name: 'nombrecompleto',
                }, {
                    data: 'email',
                    name: 'email',
                }, {
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
                    searchable: false,
                    orderable: false,
                },
            ],
        });
    },
    fillDatatatablesTalentos(filter_year,filter_state){
        var datatable = $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/usuario/mistalentos",
                type: "get",
                data: {
                    filter_year: filter_year,
                    filter_state: filter_state
                }
            },
            columns: [
                {
                    data: 'tipodocumento',
                    name: 'tipodocumento',
                }, {
                    data: 'documento',
                    name: 'documento',
                }, {
                    data: 'nombrecompleto',
                    name: 'nombrecompleto',
                }, {
                    data: 'email',
                    name: 'email',
                }, {
                    data: 'celular',
                    name: 'celular',
                },  {
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'login',
                    name: 'login',
                }, {
                    data: 'state',
                    name: 'state',
                }, {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                },
            ],
        });
    }
}

$('#filter_user').click(function(){

    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();


    $('#users_data_table').dataTable().fnDestroy();


    if((filter_nodo != '' || filter_nodo != null) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo , filter_role, filter_state, filter_year);
        //idea.fill_datatatables_ideas(filter_nodo = null,filter_year, filter_state, filter_vieneconvocatoria, filter_convocatoria = null);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && filter_role !='' && filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesUsers(filter_nodo = null , filter_role, filter_state, filter_year);
    }else{
        $('#users_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();

    }

});

$('#filter_talentos').click(function(){
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();
    $('#mytalento_data_table').dataTable().fnDestroy();
    if(filter_state != '' && filter_year !=''){
        UserIndex.fillDatatatablesTalentos(filter_year, filter_state);
    }else{
        $('#mytalento_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_users').click(function(){
    let filter_role = $('#filter_rol').val();
    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();
    let filter_year = $('#filter_year').val();
    var query = {
        filter_nodo: filter_nodo,
        filter_role: filter_role,
        filter_state: filter_state,
        filter_year: filter_year,
    }

    var url = host_url + "/usuario/export?" + $.param(query)
    window.location = url;
});





$(document).on('submit', 'form#formEditProfile', function (event) {
    // $('button[type="submit"]').prop("disabled", true);
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
    
          $('button[type="submit"]').removeAttr('disabled');
          $('button[type="submit"]').prop("disabled", false);
          $('.error').hide();
          if (data.fail) {
  
            for (control in data.errors) {
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
  
            EditProfileUser.printErroresFormulario(data);
          }
          if (data.state == 'error') {
            Swal.fire({
              title: 'Tu perfil no se ha modificado, por favor inténtalo de nuevo',
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
                window.location.href = data.url;
              }, 1000);
          }
          if (data.state == 'success') {
            Swal.fire({
              title: 'Modifciación Exitosa',
              text: `Tu perfil ha sido actualizado exitosamente.`,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.href = data.url;
            }, 1000);
          }
        },
        
      });
});




var EditProfileUser = {
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
var roleUserSession = {
    setRoleSession:function (role) {
        let nameRole = $(role).val();
        let nombre = $("#change-role option:selected").val();
        $.ajax({
            dataType:'json',
            type:'POST',
            data: {
        	    'role': nombre,
        	    '_token'  : $('meta[name="csrf-token"]').attr('content'),
            },
            url: host_url+'/cambiar-role'
        }).done(function(response){
        	if (response.role != null) {
        		location.href= response.url;
        	}else{
        		Swal.fire('Error!', 'Por favor, cierre sesión y vuelve a ingresar al sistema!', 'error');
        	}
      }); 
   }
};


$(document).ready(function() {

	$('#sublineas_table').DataTable({
        language: {
           
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
        	url: host_url + "/sublineas",
            type: "get",
        },
        columns: [
        	{
        		data: 'nombre',
        		name: 'nombre',
        	},
        	{
        		data: 'linea',
        		name: 'linea',
        	},
            {
                data: 'edit',
                name: 'edit',
                orderable: false,
            },

        ],
    });
});
function consultarIntervencionesEmpresaDelGestor(anho) {
  $('#IntervencionGestor_table').dataTable().fnDestroy();
  $('#IntervencionGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: host_url + "/intervencion/datatableIntervencionEmpresaDelGestor/"+0+"/"+anho,
      // type: "get",
      data: function (d) {
        d.codigo_articulacion = $('#codigo_articulacion_GestorTable').val(),
        d.nombre = $('#nombre_GestorTable').val(),
        d.estado = $('#estado_GestorTable').val(),
        d.search = $('input[type="search"]').val()
      }
    },
    columns: [
      {
        data: 'codigo_articulacion',
        name: 'codigo_articulacion',
      },
      {
        data: 'nombre',
        name: 'nombre',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
      {
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
}

$("#codigo_articulacion_GestorTable").keyup(function(){
  $('#IntervencionGestor_table').DataTable().draw();
});

$("#nombre_GestorTable").keyup(function(){
  $('#IntervencionGestor_table').DataTable().draw();
});


$("#estado_GestorTable").keyup(function(){
  $('#IntervencionGestor_table').DataTable().draw();
});

function detallesDeUnaIntervencion(id){
    $.ajax({
       dataType:'json',
       type:'get',
       url: host_url + "/intervencion/ajaxDetallesDeUnaArticulacion/"+id,
    }).done(function(respuesta){
      $("#articulacionDetalle_titulo").empty();
      $("#detalleArticulacion").empty();
      if (respuesta.detalles == null) {
        Swal.fire(
          'Ups!!',
          'Ha ocurrido un error',
          'error'
        );
      } else {
        $("#articulacionDetalle_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaArticulacion/"+id+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='teal-text text-darken-3'>Código de la Intervención: </span><b>"+respuesta.detalles.codigo_articulacion+"</b>");
        $("#detalleArticulacion").append(
          '<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Nombre de la Articulación: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.nombre+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Experto a cargo: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.gestor+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Fecha de Inicio: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.fecha_inicio+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Estado de la Articulación: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.estado+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Tipo de Articulación: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text">'+respuesta.detalles.tipoArticulacion+'</span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
  
          +'<div class="row">'
          +'<div class="col s12 m6 l6">'
          +'<span class="teal-text text-darken-3">Entregables: </span>'
          +'</div>'
          +'<div class="col s12 m6 l6">'
          +'<span class="black-text"><a onclick="verDetallesDeLosEntregablesDeUnaIntervencionEmpresa('+respuesta.detalles.id+')" class="btn btn-small teal darken-3">Pulse aquí para ver los entregables</a></span>'
          +'</div>'
          +'</div>'
          +'<div class="divider"></div>'
        );
      $('#articulacionDetalle').openModal();
      }
    });
  }

  function verDetalleDeLaEntidadAsocidadALaArticulacion(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url: host_url + "/articulacion/consultarEntidadDeLaArticulacion/"+id
  }).done(function(respuesta){
    $("#detalleDeUnaArticulacion_titulo").empty();
    $("#detalleArticulacion_body").empty();
    if (respuesta.detalles == null) {
      Swal.fire(
        'Ups!!',
        'Ha ocurrido un error',
        'error'
      );
    } else {
      if (respuesta.articulacion.tipo_articulacion == 'Empresa') {
        $("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Empresa </span><br>");
        $("#detalleArticulacion_body").append("<div class='row'>"
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nit de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nit+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Nombre de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.nombre_empresa+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Dirección de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.direccion+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Ciudad de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.ciudad+'</span>'
        +'</div>'
        +'</div>'
        +'<div class="divider"></div>'
        +'<div class="row">'
        +'<div class="col s12 m6 l6">'
        +'<span class="cyan-text text-darken-3">Email de la Empresa: </span>'
        +'</div>'
        +'<div class="col s12 m6 l6">'
        +'<span class="black-text">'+respuesta.detalles.email_entidad+'</span>'
        +'</div>'
        +'</div>'
      );
      $('#detalleArticulacion_modal').openModal();
    } else if (respuesta.articulacion.tipo_articulacion == 'Grupo de Investigación') {
      $("#detalleDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos del Grupo de Investigación </span><br>");
      $("#detalleArticulacion_body").append("<div class='row'>"
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código del Grupo de Investigacion: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.codigo_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Nombre del Grupo de Investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.nombre_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Correo del Grupo de Investigacion: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.correo_grupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Ciudad del Grupo de Investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.ciudad+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Tipo de Grupo de Investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.tipogrupo+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Institución que avala el grupo de investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.institucion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Clasificación Colciencias del Grupo de Investigación: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+respuesta.detalles.nombre_clasificacion+'</span>'
      +'</div>'
      +'</div>'
    );
    $('#detalleArticulacion_modal').openModal();
  } else {
    $("#talentosDeUnaArticulacion_titulo").empty();
    $("#talentosDeUnaArticulacion_table").empty();
    $("#talentosDeUnaArticulacion_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Talentos </span><br>");
    $.each(respuesta.detalles, function( index, value ) {
      let rol = "Autor";
      if (value.talento_lider == 1) {
        rol = "Talento Líder";
      }
      $("#talentosDeUnaArticulacion_table").append('<tr><td>'+rol+'</td><td>'+value.talento+'</td></tr>'
      );
    });
    $('#talentosDeUnaArticulacion_modal').openModal();
  }
  }
});
}

  function eliminarIntervencionEmpresaPorId_event(id, e) {
    Swal.fire({
      title: '¿Desea eliminar la Intervención a Empresa?',
      text: "Al hacer esto, todo lo relacionado con esta Intervención a Empresa será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      cancelButtonText: 'No',
      confirmButtonText: 'Sí, eliminar!'
    }).then((result) => {
      if (result.value) {
        eliminarIntervencionEmpresaPorId_moment(id);
      }
    })
  }
  
  function eliminarIntervencionEmpresaPorId_moment(id) {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/intervencion/eliminarArticulacion/'+id,
      success: function (data) {
        if (data.retorno) {
          Swal.fire('Eliminación Exitosa!', 'La Intervención a Empresa se ha eliminado completamente!', 'success');
          location.href = '/intervencion';
        } else {
          Swal.fire('Eliminación Errónea!', 'La Intervención a Empresa no se ha eliminado!', 'error');
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
$(document).ready(function() {
    // consultarProyectosDelGestorPorAnho();
    consultarProyectosUnNodoPorAnho();
});

function verHorasDeExpertosEnProyecto(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url: host_url + "/proyecto/consultarHorasExpertos/"+id
  }).done(function(respuesta){
    $("#horasAsesoriasExpertosPorProyeto_table").empty();
    if (respuesta.horas.length == 0 ) {
      Swal.fire({
        title: 'Ups!!',
        text: "No se encontraron horas de asesorías de los expertos en este proyecto!",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
      })
    } else {
      $("#horasAsesoriasExpertosPorProyeto_titulo").empty();
      $("#horasAsesoriasExpertosPorProyeto_titulo").append("<span class='cyan-text text-darken-3'>Horas de los experto en el proyecto</span>");
      $.each(respuesta.horas, function (i, item) {
        $("#horasAsesoriasExpertosPorProyeto_table").append(
          '<tr>'
          +'<td>'+item.experto+'</td>'
          +'<td>'+item.horas_directas+'</td>'
          +'<td>'+item.horas_indirectas+'</td>'
          +'</tr>'
        );
      });
      $('#horasAsesoriasExpertosPorProyeto_modal').openModal();
    }
  });
}

function consultarProyectosDeTalentos() {

    $('#tblProyectos_Master').dataTable().fnDestroy();
    $('#tblProyectos_Master').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        "lengthChange": false,
        ajax:{
            url: host_url + "/proyecto/datatableProyectosDelTalento/",
            data: function (d) {
                d.codigo_proyecto = $('.codigo_proyecto').val(),
                d.nombre = $('.nombre').val(),
                d.nombre_fase = $('.nombre_fase').val(),
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            {
                width: '15%',
                data: 'codigo_proyecto',
                name: 'codigo_proyecto',
            },
            {
                data: 'nombre_gestor',
                name: 'nombre_gestor',
            },
            {
                data: 'nombre',
                name: 'nombre',
            },
            {
                data: 'nombre_fase',
                name: 'nombre_fase',
            },
            {
                width: '8%',
                data: 'info',
                name: 'info',
                orderable: false
            },
            {
                width: '8%',
                data: 'proceso',
                name: 'proceso',
                orderable: false
            },
        ],
    });
}

/**
* Consulta los talentos que tiene un proyecto
*/
function verTalentosDeUnProyecto(id){
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/proyecto/ajaxConsultarTalentosDeUnProyecto/"+id
    }).done(function(respuesta){
        $("#talentosAsociadosAUnProyecto_table").empty();
        if (respuesta.talentos.length != 0 ) {
        $("#talentosAsociadosAUnProyecto_titulo").empty();
        $("#talentosAsociadosAUnProyecto_titulo").append("<span class='cyan-text text-darken-3'>Código de Proyecto: </span>"+respuesta.proyecto+"");
        $.each(respuesta.talentos, function(i, item) {
            let icon = "";
            let celular = item.celular;
            if (item.rol == 'Talento Líder') {
                icon = '<i class="material-icons green-text left">face</i>'
            }
            if (item.celular == null) {
                celular = "";
            }
            $("#talentosAsociadosAUnProyecto_table").append(
                '<tr>'
                +'<td>'+icon+' '+item.rol+'</td>'
                +'<td>'+item.talento+'</td>'
                +'<td>'+item.email+'</td>'
                +'<td>'+celular+'</td>'
                +'</tr>'
            );
        });
        $('#talentosAsociadosAUnProyecto_modal').openModal();
        } else {
        Swal.fire({
            title: 'Ups!!',
            text: "No se encontraron talentos asociados a este proyecto!",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
        }
    });
}

// Ajax que muestra los proyectos de un experto por año
// function consultarProyectosDelGestorPorAnho() {
//     let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
//     $('#tblproyectosGestorPorAnho').dataTable().fnDestroy();
//     $('#tblproyectosGestorPorAnho').DataTable({
//         language: {
//             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
//         },
//         pageLength: 20,
//         processing: true,
//         serverSide: true,
//         order: [ 0, 'desc' ],
//         "lengthChange": false,
//         ajax:{
//             url: host_url + "/proyecto/datatableProyectosDelGestorPorAnho/"+0+"/"+anho,
//             data: function (d) {
//                 d.codigo_proyecto = $('.codigo_proyecto').val(),
//                 d.nombre = $('.nombre').val(),
//                 d.nombre_fase = $('.nombre_fase').val(),
//                 d.search = $('input[type="search"]').val()
//             }
//         },
//         columns: [
//             {
//                 width: '15%',
//                 data: 'codigo_proyecto',
//                 name: 'codigo_proyecto',
//             },
//             {
//                 data: 'nombre',
//                 name: 'nombre',
//             },
//             {
//                 data: 'nombre_fase',
//                 name: 'nombre_fase',
//             },
//             {
//                 width: '8%',
//                 data: 'info',
//                 name: 'info',
//                 orderable: false
//             },
//             {
//                 width: '8%',
//                 data: 'proceso',
//                 name: 'proceso',
//                 orderable: false
//             },
//         ],
//     });
// }
// $(".codigo_proyecto").keyup(function(){
//     $('#tblproyectosGestorPorAnho').DataTable().draw();
// });

// $(".nombre").keyup(function(){
//     $('#tblproyectosGestorPorAnho').DataTable().draw();
// });

// $(".nombre_fase").keyup(function(){
//     $('#tblproyectosGestorPorAnho').DataTable().draw();
// });

// $("#codigo_proyecto_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#gestor_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#nombre_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#sublinea_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

// $("#fase_nombre_tblProyectosDelNodoPorAnho").keyup(function(){
//     $('#tblproyectosDelNodoPorAnho').DataTable().draw();
// });

function preguntaReversar(e, id, fase){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de reversar este proyecto a la fase de '+fase+'?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
        if (result.value) {
            sendReversarProyecto(id, fase);
        }
    })
}

function sendReversarProyecto(id, fase) {
    $.ajax({
        type: 'get',
        url: host_url + '/proyecto/reversar/'+id+'/'+fase,
        dataType: 'json',
        success: function (data) {
            Swal.fire({
                title: data.msg,
                type: data.type_alert,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Ok!'
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
}

var infoActividad = {
    infoDetailActivityModal : function(code){
        if(typeof code === 'string'){
            $.ajax({
                dataType:'json',
                type:'get',
                url: host_url + '/actividad/detalle/'+code
            }).done(function (response) {
                $("#actividad_titulo").empty();
                $("#detalleActividad").empty();
                $("#actividad_titulo").append("<span class='primary-text'>"+response.data.actividad.codigo_actividad +' - '+ response.data.actividad.nombre+" </span><br>");
                if(response.data.actividad.articulacion_proyecto.proyecto !== null){
                    infoActividad.openIsProyect(response);
                }else if(response.data.actividad.articulacion_proyecto.articulacion !== null){
                    infoActividad.openIsArticulacion(response);
                }
                $('#info_actividad_modal').openModal();
            });
        }
    },
    openIsProyect: function(response){
        $("#detalleActividad").append(`
            <table class="striped centered">
                <TR>
                    <TH class="secondary-text" width="25%">Código Proyecto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                    <TH class="secondary-text" width="25%" >Nombre Proyecto</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
                </TR>
                <TR>
                    <TH class="secondary-text" width="25%">Experto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.asesor.user.documento)} - ${response.data.actividad.articulacion_proyecto.proyecto.asesor.user.nombres} ${response.data.actividad.articulacion_proyecto.proyecto.asesor.user.apellidos}</TD>
                    <TH class="secondary-text" width="25%">Correo Electrónico</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.proyecto.asesor.user.email)}</TD>
                </TR>
            </table>
            <div class="right">
                <small>
                    <b class="secondary-text">Cantidad de usos de infraestructura:  </b>
                    ${infoActividad.showInfoNull(response.data.total_usos)}
                </small>
            </div>
            <div class="divider mailbox-divider"></div>
            <div class="center">
                <span class="mailbox-title primary-text">
                    <i class="material-icons">group</i>
                    Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.
                </span>
            </div>
            <div class="divider mailbox-divider"></div>
                <div class="row">
                <div class="col s12 m12 l12">
                        <div class="card-transparent">
                            <h5 class="center primary-text">Talentos que participan en el proyecto</h5>
                            <table>
                                <thead class="bg-primary white-text">
                                    <tr>
                                        <th style="width: 10%">Talento Interlocutor</th>
                                        <th style="width: 40%">Talento</th>
                                        <th style="width: 20%">Correo</th>
                                        <th style="width: 15%">Telefono</th>
                                        <th style="width: 15%">Celular</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleTalentos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-transparent col s12 m12 l12">
                        <h5 class="center primary-text">Dueño(s) de la propiedad intelectual</h5>
                        <div class="row">
                            <div class="col s12 m4 l4">
                                <div class="card-transparent">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5 class="secondary-text">Empresas</h5></li>
                                        <div id="detalleEmpresas"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-transparent">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5 class="secondary-text">Personas (Talentos)</h5></li>
                                        <div id="detallePropiedadTalentos"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-transparent">
                                    <ul class="collection with-header">
                                        <li class="collection-header"><h5 class="secondary-text">Grupos de Investigación</h5></li>
                                        <div id="detallePropiedadGrupo"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
            infoActividad.showTalentos(response.data.actividad.articulacion_proyecto.talentos);
            infoActividad.showPropiedadIntelectualEmpresas(response.data.actividad.articulacion_proyecto.proyecto.sedes);
            infoActividad.showPropiedadIntelectualTalentos(response.data.actividad.articulacion_proyecto.proyecto.users_propietarios);
            infoActividad.showPropiedadIntelectualGrupo(response.data.actividad.articulacion_proyecto.proyecto.gruposinvestigacion);
    },
    openIsArticulacion: function(response){
        $("#detalleActividad").append(`
            <table class="striped centered">
                <TR>
                    <TH width="25%">Código Articulación</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.codigo_actividad)}</TD>
                    <TH width="25%" >Nombre de Articulación</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.nombre)}</TD>
                </TR>
                <TR>
                    <TH width="25%">Experto</TH>
                    <TD width="25%">${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.asesor.documento)} - ${response.data.actividad.articulacion_proyecto.articulacion.asesor.nombres} ${response.data.actividad.articulacion_proyecto.articulacion.asesor.apellidos}</TD>
                    <TH width="25%">Correo Electrónico</TH>
                    <TD width="25%" COLSPAN=3>${infoActividad.showInfoNull(response.data.actividad.articulacion_proyecto.articulacion.asesor.email)}</TD>
                </TR>
            </table>
            <div class="right">
                <small>
                    <b>Cantidad de usos de infraestructura:  </b>
                    ${infoActividad.showInfoNull(response.data.total_usos)}
                </small>
            </div>
            <div class="divider mailbox-divider"></div>
            <div class="center">
                <span class="mailbox-title">
                    <i class="material-icons">group</i>
                    Talentos que participan en la articulación.
                </span>
            </div>
            <div class="divider mailbox-divider"></div>
                <div class="row">
                <div class="col s12 m12 l12">
                        <div class="card-panel blue lighten-5">
                            <h5 class="center">Talentos que participan en la Articulación</h5>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Talento Interlocutor</th>
                                        <th style="width: 40%">Talento</th>
                                        <th style="width: 20%">Correo</th>
                                        <th style="width: 15%">Telefono</th>
                                        <th style="width: 15%">Celular</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleTalentos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`);
                infoActividad.showTalentos(response.data.actividad.articulacion_proyecto.talentos);
    },
    showDateActivity: function(date){
        if(date === null || date === ''){
            return "El proceso no se ha cerrado";
        }else{
            return date;
        }
    },
    showInfoNull: function(info){
        if(info === null || info === ''){
            return "No se encontraron resultados";
        }else{

            return info;
        }
    },
    validateDataIsTRL: function(data){
        return data == 0 ? 'TRL 6' : 'TRL 7 - TRL 8';
    },
    validateDataIsBoolean: function(data){
        return data == 0 ? 'NO' : 'SI';
    },
    dataPerteneceEconomiaNaranja: function(data){
        return data.economia_naranja == 0 ? 'NO' :  data.economia_naranja == 1 ? ' SI (' + data.tipo_economianaranja +')' : '';
    },
    dataDirigidoDiscapacitados: function(data){
        return data.dirigido_discapacitados == 0 ? 'NO' :  data.dirigido_discapacitados == 1 ? 'SI (' + data.tipo_discapacitados +')' : '';
    },
    dataArticuladaCTI: function(data){
        return data.art_cti == 0 ? 'NO' :  data.art_cti == 1 ? ' SI (' + data.nom_act_cti +')' : '';
    },
    showTalentos: function (data){
        let fila = "";

        if(data.length > 0){
            fila = data.map(function(el){
                return `<tr class="selected">
                            <td> ${infoActividad.validateDataIsBoolean(el.pivot.talento_lider)}</td>
                            <td>${infoActividad.showInfoNull(el.user.documento)} - ${infoActividad.showInfoNull(el.user.nombres)} ${infoActividad.showInfoNull(el.user.apellidos)}</td>
                            <td>${infoActividad.showInfoNull(el.user.email)}</td>
                            <td>${infoActividad.showInfoNull(el.user.telefono)}</td>
                            <td>${infoActividad.showInfoNull(el.user.celular)}</td>
                        </tr>`;
            });

        }else{
            fila = `<tr class="selected">
                        <td COLSPAN=4>No se encontraron resultados</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>`;
        }
        document.getElementById("detalleTalentos").innerHTML = fila;

    },
    showPropiedadIntelectualEmpresas: function(data){
        let info = "";

        if(data.length > 0){
            info = data.map(function(el){
                    return `
                        <li class="collection-item">
                        ${infoActividad.showInfoNull(el.empresa.nit)} - ${infoActividad.showInfoNull(el.empresa.nombre)} (${infoActividad.showInfoNull(el.nombre_sede)})
                        </li>`;
            });

        }else{
            info = `<li class="collection-item">
                    No se han encontrado empresas dueña(s) de la propiedad intelectual.
                </li>`;
        }
        document.getElementById("detalleEmpresas").innerHTML = info;
    },
    showPropiedadIntelectualTalentos: function(data){
        let info = "";

        if(data.length > 0){
            info = data.map(function(el){
                return `<li class="collection-item">
                        ${infoActividad.showInfoNull(el.documento)} - ${infoActividad.showInfoNull(el.nombres)} ${infoActividad.showInfoNull(el.apellidos)}
                        </li>`;
            });
        }else{
            info = `<li class="collection-item">
                    No se han encontrado talento(s) dueño(s) de la propiedad intelectual.
                </li>`;
        }
        document.getElementById("detallePropiedadTalentos").innerHTML = info;
    },
    showPropiedadIntelectualGrupo: function(data){
        let info = "";

        if(data.length > 0){
            info = data.map(function(el){
                return `<li class="collection-item">
                        ${infoActividad.showInfoNull(el.codigo_grupo)} - ${infoActividad.showInfoNull(el.entidad.nombre)}
                        </li>`;
            });
        }else{
            info = `<li class="collection-item">
            No se han encontrado grupo(s) de investigación dueño(s) de la propiedad intelectual.
                </li>`;
        }
        document.getElementById("detallePropiedadGrupo").innerHTML = info;
    },

}

$("#codigo_proyecto_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#gestor_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#nombre_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#sublinea_nombre_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

$("#estado_nombre_tblProyectos_Master").keyup(function(){
    $('#tblProyectos_Master').DataTable().draw();
});

/**
 * Consulta los proyectos de un nodo por año (Este método es para el dinamizador)
 */
function consultarProyectosUnNodoPorAnho() {
let anho_proyectos_nodo = $('#anho_proyectoPorNodoYAnho').val();
let nodo = $('#nodo_proyectoPorNodoYAnho').val();

$('#tblProyectos_Master').dataTable().fnDestroy();
$('#tblProyectos_Master').DataTable({
    language: {
    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    "lengthChange": false,
    ajax:{
    url: host_url + "/proyecto/datatableProyectosAnho/"+nodo+"/"+anho_proyectos_nodo,
    data: function (d) {
        d.codigo_proyecto = $('#codigo_proyecto_tblProyectos_Master').val(),
        d.gestor = $('#gestor_tblProyectos_Master').val(),
        d.nombre = $('#nombre_tblProyectos_Master').val(),
        d.sublinea_nombre = $('#sublinea_nombre_tblProyectos_Master').val(),
        d.nombre_fase = $('#estado_nombre_tblProyectos_Master').val(),
        d.search = $('input[type="search"]').val()
    }
    },
    columns: [
    {
        width: '15%',
        data: 'codigo_proyecto',
        name: 'codigo_proyecto',
    },
    {
        data: 'gestor',
        name: 'gestor',
    },
    {
        data: 'nombre',
        name: 'nombre',
    },
    {
        data: 'sublinea_nombre',
        name: 'sublinea_nombre',
    },
    {
        data: 'nombre_fase',
        name: 'nombre_fase',
    },
    {
        width: '8%',
        data: 'info',
        name: 'info',
        orderable: false
    },
    {
        width: '8%',
        data: 'proceso',
        name: 'proceso',
        orderable: false
    },
    ],
    });
}
function preguntaRechazarAprobacionProyecto(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de no aprobar esta fase del proyecto?',
        input: 'text',
        type: 'warning',
        inputValidator: (value) => {
            if (!value) {
                return 'Las observaciones deben ser obligatorias!'
            } else {
                $('#decision').val('rechazado');
                $('#motivosNoAprueba').val(value);
            }
        },
        inputAttributes: {
        maxlength: 100,
        placeHolder: '¿Por qué?'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
        if (result.value) {
            document.frmAprobacionProyecto.submit();
        }
    })
}

function preguntaAprobacion(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de aprobar esta fase del proyecto?',
        text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase, los documento adjuntos y las asesorias recibidas.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
    }).then((result) => {
        if (result.value) {
            $('#decision').val('aceptado');
            document.frmAprobacionProyecto.submit();
        }
    })
}
$(document).ready(function () {
    // Contenedores
    divOtroAreaConocmiento = $('#otroAreaConocimiento_content');
    divEconomiaNaranja = $('#economiaNaranja_content');
    divDiscapacidad = $('#discapacidad_content');
    divNombreActorCTi = $('#nombreActorCTi_content');
    // Ocultar contenedores
    divOtroAreaConocmiento.hide();
    divEconomiaNaranja.hide();
    divDiscapacidad.hide();
    divNombreActorCTi.hide();
});


// Enviar formulario para registrar proyecto
$(document).on('submit', 'form#frmProyectos_FaseInicio', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'create');
});

// Enviar formulario para cambiar los talentos del proyecto
$(document).on('submit', 'form#frmUpdateTalentos', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'update');
});


// Enviar formulario para modificar datos del proyecto (Fase de Inicio)
$(document).on('submit', 'form#frmProyectos_FaseInicio_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto(form, data, url, 'update');
});

function ajaxSendFormProyecto(form, data, url, fase) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (fase == 'create') {
                mensajesProyectoCreate(data);
            } else {
                mensajesProyectoUpdate(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesProyectoCreate(data) {
    if (data.state == 'registro') {
        Swal.fire({
            title: 'Registro Exitoso',
            text: "El proyecto ha sido registrado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    }
    if (data.state == 'no_registro') {
        Swal.fire({
            title: 'El proyecto no se ha registrado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

function mensajesProyectoUpdate(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa',
            text: "El proyecto ha sido cambiado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'El proyecto no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

// Alerta que indica que el talento ya se encuentra asociado al proyecto
function talentoYaSeEncuentraAsociado() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El talento ya se encuentra asociado al proyecto!'
    });
}

// Alerta que indica que el talento ya se encuentra asociado al proyecto
function usuarioYaSeEncuentraAsociado_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El usuario ya se encuentra asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que la entidad ya se encuentra asociado al proyecto como dueña de la propiedad intelectual
function empresaYaSeEncuentraAsociado_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'Esta empresa/sede ya se encuentra asociada como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que el talento se asoció correctamente al proyecto
function talentoSeAsocioAlProyecto() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El talento se ha asociado al proyecto!'
    });
}

// Alerta que indica que la empresa se asoció correctamente al proyecto como propietario
function empresaSeAsocioAlProyecto_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La sede se ha asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que el grupo de investigación se asoció correctamente al proyecto como propietario
function grupoSeAsocioAlProyecto_Propietario() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El grupo de investigación se ha asociado como dueño de la propiedad intelectual!'
    });
}

// Alerta que indica que la idea de proyecto se asoció al proyecto
function ideaProyectoAsociadaConExito(codigo, nombre) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La siguiente idea se ha asociado al proyecto: ' + codigo + ' - ' + nombre
    });
}


// Prepara un string con la fila que se va a pintar en la tabla de los talentos que participaran en el proyecto
function prepararFilaEnLaTablaDeTalentos(ajax, isInterlocutor) {
    let talentInterlocutor = null;
    if(isInterlocutor){
        talentInterlocutor = "checked";
    }// El ajax.talento.id es el id del TALENTO, no del usuario
    let idTalento = ajax.talento.id;
    let fila = '<tr class="selected" id=talentoAsociadoAProyecto' + idTalento + '>' + '<td><input type="radio" '+ talentInterlocutor +' class="with-gap" name="radioTalentoLider" id="radioButton' + idTalento + '" value="' + idTalento + '" /><label for ="radioButton' + idTalento + '"></label></td>' + '<td><input type="hidden" name="talentos[]" value="' + idTalento + '">' + ajax.talento.documento + ' - ' + ajax.talento.talento + '</td>' + '<td><a class="waves-effect bg-danger btn" onclick="eliminarTalentoDeProyecto_FaseInicio(' + idTalento + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (users/persona) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Users(ajax) { // El ajax.user.id es el id del USER
    let idUser = ajax.user.id;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Persona' + idUser + '>' + '<td><input type="hidden" name="propietarios_user[]" value="' + idUser + '">' + ajax.user.documento + ' - ' + ajax.user.nombres + ' ' + ajax.user.apellidos + '</td>' + '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona(' + idUser + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}


// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (empresas) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Empresa(ajax) {
    let idSede = ajax.sede.id;
    let codigo = ajax.sede.empresa.nit;
    let nombre = ajax.sede.empresa.nombre;
    let nombre_sede = ajax.sede.nombre_sede;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Empresa' + idSede + '>' + '<td><input type="hidden" name="propietarios_sedes[]" value="' + idSede + '">' + codigo + ' - ' + nombre + ' ('+ nombre_sede +')</td>' + '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(' + idSede + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Prepara un string con la fila que se va a pintar en la tabla de los propietarios (grupos de investigación) que son dueños de la propiedad intelectual
function prepararFilaEnLaTablaDePropietarios_Grupos(ajax) { // El ajax.user.id es el id del USER
    let idGrupo = ajax.detalles.id;
    let codigo = ajax.detalles.codigo_grupo;
    let nombre = ajax.detalles.entidad.nombre;
    let fila = '<tr class="selected" id=propietarioAsociadoAlProyecto_Grupo' + idGrupo + '>' + '<td><input type="hidden" name="propietarios_grupos[]" value="' + idGrupo + '">' + codigo + ' - ' + nombre + '</td>' + '<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(' + idGrupo + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

// Pinta el talento en la tabla de los talentos que participarán en el proyecto
function pintarTalentoEnTabla_Fase_Inicio(id, isInterlocutor) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/usuario/talento/consultarTalentoPorId/' + id
    }).done(function (ajax) {

        let fila = prepararFilaEnLaTablaDeTalentos(ajax, isInterlocutor);
        $('#detalleTalentosDeUnProyecto_Create').append(fila);
        talentoSeAsocioAlProyecto();
    });
}

// Pinta el usuario en la tabla de los usuarios que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/usuario/consultarUserPorId/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Users(ajax);
        $('#propiedadIntelectual_Personas').append(fila);
        talentoSeAsocioAlProyecto();
    });
}

// Pinta el usuario en la tabla de las entidades (empresas) que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(sede_id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : host_url + '/empresa/ajaxDetalleDeUnaSede/'+sede_id,
        success: function (response) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'La sede '+response.sede.nombre_sede+' se asoció a la idea de proyecto!'
          });
          let fila = prepararFilaEnLaTablaDePropietarios_Empresa(response);
              $('#propiedadIntelectual_Empresas').append(fila);
              empresaSeAsocioAlProyecto_Propietario();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
}

// Pinta el usuario en la tabla de las entidades (grupos de investigacion) que son dueños de la propiedad intelectual
function pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(id) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grupo/ajaxDetallesDeUnGrupoInvestigacion/' + id
    }).done(function (ajax) {
        let fila = prepararFilaEnLaTablaDePropietarios_Grupos(ajax);
        // let fila = Grupos);
        $('#propiedadIntelectual_Grupos').append(fila);
        grupoSeAsocioAlProyecto_Propietario();
    });
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat(id) {
    // console.log('fff');
    // let retorno = true;
    let a = document.getElementsByName("talentos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == id) {
            return false;
        }
    }
    return true;
}

// Valida que el talento no se encuentre asociado al proyecto
function noRepeat_Propiedad(id) {
    let idUser = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_user[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idUser) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que la sede no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Sede(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_sedes[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idEntidad) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Valida que el grupo de investigación no se encuentre asociado al proyecto como dueño de la propiedad intelectual
function noRepeat_Grupo(id) {
    let idEntidad = id;
    let retorno = true;
    let a = document.getElementsByName("propietarios_grupos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idEntidad) {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Elimina un talento que se encuentre asociado a un proyecto
function eliminarTalentoDeProyecto_FaseInicio(index) {
    $('#talentoAsociadoAProyecto' + index).remove();
}

// Elimina una persona que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Persona(index) {
    $('#propietarioAsociadoAlProyecto_Persona' + index).remove();
}

// Elimina una empresa que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Empresa(index) {
    $('#propietarioAsociadoAlProyecto_Empresa' + index).remove();
}

// Elimina una empresa que se encuentre asociado a un proyecto como propietario
function eliminarPropietarioDeUnProyecto_FaseInicio_Grupo(index) {
    $('#propietarioAsociadoAlProyecto_Grupo' + index).remove();
}

// Método para agregar talentos a un proyecto
// El parametro recibido es el id de la tabla talentos
function addTalentoProyecto(id, isInterloculor) {
    let unique = true;
    let a = document.getElementsByName("talentos[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == id) {
            unique = false;
        }
    }
    if (!unique) {
        talentoYaSeEncuentraAsociado();
    } else {
        pintarTalentoEnTabla_Fase_Inicio(id, isInterloculor);
    }
}

// Método para agregar un talento como dueño de una ´rpíedad intelectual
// El id recibido es el id de la tabla users
function addPersonaPropiedad(user_id) {
    if (noRepeat_Propiedad(user_id) == false) {
        usuarioYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual(user_id);
    }
}

function prepararSedesEmpresa(sedes) {
    let fila = "";
    sedes.forEach(element => {
        fila += `<li class="collection-item">
        ` + element.nombre_sede + ` - ` + element.direccion + ` ` + element.ciudad.nombre + ` (` + element.ciudad.departamento.nombre + `)
        <a href="#!" class="secondary-content" onclick="addSedePropietaria(`+element.id+`)">Asociar esta sede de la empresa al proyecto</a></div>
      </li>`;
    });
    return fila;
}

// Método para agregar una empresa como dueño de una propiedad intelectual
function addEntidadEmpresa(id) {
    $('#sedesPropietarias_Empresas_detalles').empty();
    $.ajax({
        dataType: 'json',
        type: 'get',
        url : host_url + '/empresa/ajaxDetallesDeUnaEmpresa/'+id+'/id',
        success: function (response) {
            let filas_sedes = prepararSedesEmpresa(response.empresa.sedes);
            $('#sedesPropietarias_Empresas_detalles').append(filas_sedes);
            $('#sedesPropietarias_Empresas_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      })
}

function addSedePropietaria(id) {
    if (noRepeat_Sede(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Sede(id);
    }
}

// Método para agregar un grupo de investigación como dueño de una propiedad intelectual
// El id recibido es el id de la tabla gruposinvestigacion
function addGrupoPropietario(id) {
    if (noRepeat_Grupo(id) == false) {
        empresaYaSeEncuentraAsociado_Propietario();
    } else {
        pintarPropietarioEnTabla_Fase_Inicio_PropiedadIntelectual_Grupo(id);
    }
}
//vaciar valores agregados en tablas
function dumpAggregateValuesIntoTables(){
    $('#detalleTalentosDeUnProyecto_Create').empty();
    $('#propiedadIntelectual_Personas').empty();
    $('#propiedadIntelectual_Empresas').empty();
    $('#propiedadIntelectual_Grupos').empty();
}

//agregar valor a campos
function addValueToFields(nombre, codigo, value){
    $('#txtnombreIdeaProyecto_Proyecto').val(codigo + " - " + nombre);
    $('#txtnombre').val(nombre);
    $("label[for='txtnombreIdeaProyecto_Proyecto']").addClass('active');
    $("label[for='txtnombre']").addClass('active');

    $('#txtobjetivo').val(value.objetivo);
    $('#txtobjetivo').trigger('autoresize');
    $("label[for='txtobjetivo']").addClass('active');

    $('#txtalcance_proyecto').val(value.alcance);
    $('#txtalcance_proyecto').trigger('autoresize');
    $("label[for='txtalcance_proyecto']").addClass('active');
}


// Asocia una idea de proyecto al registro de un proyecto
function asociarIdeaDeProyectoAProyecto(id, nombre, codigo) {
    $('#txtidea_id').val(id);

    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/idea/show/' + id
    }).done(function (response) {
        let value = response.data.idea;
        if(idea =! null){
            dumpAggregateValuesIntoTables();

            addValueToFields(nombre, codigo, value);
            ideaProyectoAsociadaConExito(codigo, nombre);

            if(response.data.talento != null){

                addTalentoProyecto(response.data.talento.id, true);
                addPersonaPropiedad(response.data.talento.user.id);
            }
            if(response.data.sede != null){
                addSedePropietaria(response.data.sede.id);
            }
            $('#ideasDeProyectoConEmprendedores_modal').closeModal();
        }

    }).fail(function( jqXHR, textStatus, errorThrown ) {
        errorAjax(jqXHR, textStatus, errorThrown);
    });

}

// Consultas las ideas de proyecto que fueron aprobadas en el comité
function consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio() {
    let nodo = 1;
    let id_experto = 1;
    if (isset($('#txtnodo_id').val()))
        nodo = $('#txtnodo_id').val();
    if (isset($('#txtexperto_id_proyecto').val()))
        id_experto = $('#txtexperto_id_proyecto').val();
    //id_experto = $('#txtexperto_id_proyecto').val();
    $('#ideasDeProyectoConEmprendedores_proyecto_table').dataTable().fnDestroy();
    $('#ideasDeProyectoConEmprendedores_proyecto_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [
            0, 'desc'
        ],
        ajax: {
            url: host_url + "/proyecto/ideasAsociadasAExperto/"+nodo+"/"+id_experto,
            type: "get"
        },
        select: true,
        columns: [
            {
                data: 'codigo_idea',
                name: 'codigo_idea'
            }, {
                data: 'nombre_proyecto',
                name: 'nombre_proyecto'
            }, {
                data: 'nombres_contacto',
                name: 'nombres_contacto'
            }, {
                width: '20%',
                data: 'checkbox',
                name: 'checkbox',
                orderable: false
            },
        ]
    });
    $('#ideasDeProyectoConEmprendedores_modal').openModal({dismissible: false});
}

// Datatable que muestra las empresas que hay en la base de datos para asociarlas como propietarios
function consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table() {
    $('#posiblesPropietarios_Empresas_table').dataTable().fnDestroy();
    $('#posiblesPropietarios_Empresas_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: host_url + "/empresa/datatableEmpresasDeTecnoparque",
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
                data: 'add_propietario',
                name: 'add_propietario',
                orderable: false
            },
        ]
    });
    $('#posiblesPropietarios_Empresas_modal').openModal();
}

// Datatable que muestra los grupos de investigación que hay en la base de datos para asociarlas como propietarios
function consultarGruposDeTecnoparque_Proyecto_FaseInicio_table() {
    $('#posiblesPropietarios_Grupos_table').dataTable().fnDestroy();
    $('#posiblesPropietarios_Grupos_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: host_url + "/grupo/datatableGruposInvestigacionDeTecnoparque",
            type: "get"
        },
        columns: [
            {
                data: 'codigo_grupo',
                name: 'codigo_grupo'
            }, {
                data: 'nombre',
                name: 'nombre'
            }, {
                data: 'add_propietario',
                name: 'add_propietario',
                orderable: false
            },
        ]
    });
    $('#posiblesPropietarios_Grupos_modal').openModal();
}

// Datatable que muestra los talentos que se encuentran registrados en Tecnoparque
function consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table(tableName, fieldName) {
    $(tableName).dataTable().fnDestroy();
    $(tableName).DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax: {
            url: host_url + "/usuario/talento/getTalentosDeTecnoparque/",
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
                data: fieldName,
                name: fieldName,
                orderable: false
            },
        ]
    });
    if (tableName == '#posiblesPropietarios_Personas_table') {
        $('#posiblesPropietarios_Personas_modal').openModal();
    }
}

function selectAreaConocimiento_Proyecto_FaseInicio() {
    let id = $("#txtareaconocimiento_id").val();
    let nombre = $("#txtareaconocimiento_id [value='" + id + "']").text();
    if (nombre == 'Otro') {
        divOtroAreaConocmiento.show();
    } else {
        divOtroAreaConocmiento.hide();
    }
}

function showInput_EconomiaNaranja() {
    if ($('#txteconomia_naranja').is(':checked')) {
        divEconomiaNaranja.show();
    } else {
        divEconomiaNaranja.hide();
    }
}

function showInput_Discapacidad() {
    if ($('#txtdirigido_discapacitados').is(':checked')) {
        divDiscapacidad.show();
    } else {
        divDiscapacidad.hide();
    }
}

function showInput_ActorCTi() {
    if ($('#txtarti_cti').is(':checked')) {
        divNombreActorCTi.show();
    } else {
        divNombreActorCTi.hide();
    }
}

function errorAjax(jqXHR, textStatus, errorThrown){
    if (jqXHR.status === 0) {

        alert('Not connect: Verify Network.');

      } else if (jqXHR.status == 404) {

        alert('Requested page not found [404]');

      } else if (jqXHR.status == 500) {

        alert('Internal Server Error [500].');

      } else if (textStatus === 'parsererror') {

        alert('Requested JSON parse failed.');

      } else if (textStatus === 'timeout') {

        alert('Time out error.');

      } else if (textStatus === 'abort') {

        alert('Ajax request aborted.');

      } else {

        alert('Uncaught Error: ' + jqXHR.responseText);

      }
}

function consultarExpertosDeUnNodo(nodo_id) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/usuario/usuarios/gestores/nodo/"+nodo_id
      }).done(function(response){
          $("#txtexperto_id_proyecto").empty();
          $('#txtexperto_id_proyecto').append('<option value="">Seleccione el experto</option>');
          $.each(response.gestores, function(i, e) {
            $('#txtexperto_id_proyecto').append('<option  value="'+e.user_id+'">'+e.nombre+'</option>');
          })
          $('#txtexperto_id_proyecto').material_select();
    });
}

function consultarInformacionExperto(user) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/usuario/consultarUserPorId/"+user
      }).done(function(response){
          printLinea(response);
          consultarSublineas(response.user.gestor.lineatecnologica.id);
    });
}

function consultarSublineas(linea) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/proyecto/sublineas_of/"+linea
    }).done(function (response) {
          console.log(response);
        printSublineas(response);
    });
}

function printSublineas(response) {
    $("#txtsublinea_id").empty();
    $('#txtsublinea_id').append('<option value="">Seleccione la sublinea</option>');
    $.each(response.sublineas, function(i, e) {
      $('#txtsublinea_id').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
    })
    $('#txtsublinea_id').material_select();
}

function printLinea(response) {
    $('#txtlinea').val(response.user.gestor.lineatecnologica.nombre);
}

// Enviar formulario para modificar el proyecto en fase de cierre
$(document).on('submit', 'form#frmProyectos_FaseCierre_Update', function (event) { // $('button[type="submit"]').prop("disabled", true);
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormProyecto_FaseCierre(form, data, url);
});

function ajaxSendFormProyecto_FaseCierre(form, data, url) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            mensajesProyectoCierre(data);
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

function mensajesProyectoCierre(data) {
    if (data.state == 'update') {
        Swal.fire({
            title: 'Modificación Exitosa!',
            text: "El proyecto ha sido modificado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    }
    if (data.state == 'no_update') {
        Swal.fire({
            title: 'El proyecto no se ha modificado, por favor inténtalo de nuevo',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

$(document).ready(function() {
  $('#empresasDeTecnoparque_modEdt_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
    processing: true,
    serverSide: true,
    ajax:{
      url: host_url + "/empresa/datatableEmpresasDeTecnoparque",
      type: "get",
    },
    deferRender: true,
    columns: [
      { data: 'nit', name: 'nit' },
      { data: 'nombre_empresa', name: 'nombre_empresa' },
      { data: 'add_empresa_a_edt', name: 'add_empresa_a_edt' }
    ],
  });
});

divFechaCierreEdt = $('#divFechaCierreEdt');
divFechaCierreEdt.hide();

function actiarFechaFinDeLaEdt() {
  if ( $('#txtestado').is(':checked') ) {
    divFechaCierreEdt.show();
  } else {
    divFechaCierreEdt.hide();
  }
}

function noRepeat(id) {
  let idEntidad = id;
  let retorno = true;
  let a = document.getElementsByName("entidades[]");
  for (x=0;x<a.length;x++){
    if (a[x].value == idEntidad) {
      retorno = false;
      break;
    }
  }
  return retorno;
}

function addEmpresaAEdt(id) {
  if (noRepeat(id) == false) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      type: 'warning',
      title: 'La empresa ya se encuentra asociada a la edt!'
    });
  } else {
    $.ajax({
      dataType:'json',
      type:'get',
      url: host_url + '/empresa/ajaxConsultarEmpresaPorIdEntidad/'+id,
    }).done(function(ajax){
      let idEntidad = ajax.detalles.entidad_id;
      let fila = '<tr class="selected" id=entidadAsociadaAEdt'+idEntidad+'>'
      +'<td><input type="hidden" name="entidades[]" value="'+idEntidad+'">'+ajax.detalles.nit+'</td>'
      +'<td>'+ajax.detalles.nombre+'</td>'
      +'<td><a class="waves-effect bg-danger white-text btn" onclick="eliminarEntidadAsociadaAEdt('+idEntidad+');"><i class="material-icons">delete_sweep</i></a></td>'
      +'</tr>';
      $('#detalleEntidadesAsociadasAEdt').append(fila);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La empresa se ha asociado a la edt!'
      });
    });
  }
}

function eliminarEntidadAsociadaAEdt(index){
  $('#entidadAsociadaAEdt'+index).remove();
  Swal.fire({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    type: 'success',
    title: 'Se ha removido la empresa de la edt!'
  });
}

$(document).ready(function() {
  consultarEdtsDeUnGestor(0);
})


// Ajax que muestra los proyectos de un gestor por año
function consultarEdtsDeUnGestor(id) {
  let anho = $('#txtanho_edts_Gestor').val();
  // let gestor = $('#txtgestor_id').val();
  $('#edtPorGestor_table').dataTable().fnDestroy();
  $('#edtPorGestor_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: host_url + "/edt/consultarEdtsDeUnGestor/"+id+"/"+anho,
      type: "get",
    },
    columns: [
      {
        width: '10%',
        data: 'codigo_edt',
        name: 'codigo_edt',
      },
      {
        width: '15%',
        data: 'nombre',
        name: 'nombre',
      },
      {
        width: '15%',
        data: 'gestor',
        name: 'gestor',
      },
      {
        width: '6%',
        data: 'area_conocimiento',
        name: 'area_conocimiento',
      },
      {
        width: '6%',
        data: 'tipo_edt',
        name: 'tipo_edt',
      },
      {
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        data: 'estado',
        name: 'estado',
      },
      {
        width: '6%',
        data: 'business',
        name: 'business',
        orderable: false
      },
      {
        width: '6%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '6%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        width: '6%',
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
    ],
  });
}

$(document).ready(function() {
  datatableEdtsPorNodo(0);
});

function eliminarEdtPorId_event(id, event) {
  Swal.fire({
    title: '¿Desea eliminar la edt?',
    text: "Al hacer esto, todo lo relacionado con esta edt será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    cancelButtonText: 'No',
    confirmButtonText: 'Sí, eliminar!'
  }).then((result) => {
    if (result.value) {
      eliminarEdtPorId_moment(id);
    }
  })
}

function eliminarEdtPorId_moment(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/edt/eliminarEdt/'+id,
    success: function (data) {
      if (data.retorno) {
        Swal.fire('Eliminación Exitosa!', 'La edt se ha eliminado completamente!', 'success');
        location.href = '/edt';
      } else {
        Swal.fire('Eliminación Errónea!', 'La edt no se ha eliminado!', 'error');
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function datatableEdtsPorNodo(id) {
  let anho = $('#txtanho_edts_Nodo').val();
  $('#edtPorNodo_table').dataTable().fnDestroy();
  $('#edtPorNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: host_url + "/edt/consultarEdtsDeUnNodo/"+id+"/"+anho,
      type: "get",
    },
    columns: [
      {
        width: '10%',
        data: 'codigo_edt',
        name: 'codigo_edt',
      },
      {
        width: '15%',
        data: 'nombre',
        name: 'nombre',
      },
      {
        width: '15%',
        data: 'gestor',
        name: 'gestor',
      },
      {
        width: '6%',
        data: 'area_conocimiento',
        name: 'area_conocimiento',
      },
      {
        width: '6%',
        data: 'tipo_edt',
        name: 'tipo_edt',
      },
      {
        width: '8%',
        data: 'fecha_inicio',
        name: 'fecha_inicio',
      },
      {
        width: '8%',
        data: 'estado',
        name: 'estado',
      },
      {
        width: '5%',
        data: 'business',
        name: 'business',
        orderable: false
      },
      {
        width: '5%',
        data: 'details',
        name: 'details',
        orderable: false
      },
      {
        width: '5%',
        data: 'entregables',
        name: 'entregables',
        orderable: false
      },
      {
        width: '5%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
      {
        width: '5%',
        data: 'delete',
        name: 'delete',
        orderable: false
      },
    ],
  });
}
/**
* Mostrar la entidades registradas en una por el id de la edt
*/
function verEntidadesDeUnaEdt(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url: host_url + "/edt/consultarDetallesDeUnaEdt/"+id+"/"+1,
    success: function (response) {
      $("#entidadesEdt_table").empty();
      if (response.entidades.length != 0 ) {
        $("#entidadesEdt_titulo").empty();
        $("#entidadesEdt_titulo").append("<span class='cyan-text text-darken-3'>Código de la Edt: </span>"+response.edt.codigo_edt+"");
        $.each(response.entidades, function(i, item) {
          $("#entidadesEdt_table").append(
            '<tr>'
            +'<td>'+item.nit+'</td>'
            +'<td>'+item.nombre+'</td>'
            +'</tr>'
          );
        });
        $('#entidadesEdt_modal').openModal();
      } else {
        Swal.fire({
          title: 'Ups!!',
          text: "No se encontraron empresas asociadas a esta Edt!",
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
        })
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    }
  })
}

/**
* Muestra el detalle de una edt
*/
function detallesDeUnaEdt(id) {
  $.ajax({
    dataType:'json',
    type:'get',
    url: host_url + '/edt/consultarDetallesDeUnaEdt/'+id+"/"+0,
    success: function (response) {
      /**
      * Limpiando el modal
      */
      $('#detalleEdt_titulo').empty();
      $('#detalleEdt_detalle').empty();
      /**
      * Pintando datos en el modal
      */
      let fecha_cierre = "";
      response.edt.estado == 'Inactiva' ? fecha_cierre = response.edt.fecha_cierre : fecha_cierre = 'La Edt aún se encuentra activa!';
      $("#detalleEdt_titulo").append("<div class='valign-wrapper left material-icons'><a href='/excel/excelDeUnaEdt/"+id+"'><img class='btn btn-flat' src='https://img.icons8.com/color/48/000000/ms-excel.png'></a></div><span class='cyan-text text-darken-3'>Código de la Edt: </span>"+response.edt.codigo_edt+"");
      $("#detalleEdt_detalle").append('<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código de la Edt: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.codigo_edt+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Nombre de la Edt: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.nombre+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Área de Conocimiento: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.areaconocimiento+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Tipo de Edt: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.tipoedt+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de Inicio: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.fecha_inicio+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de Cierre: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+fecha_cierre+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m12 l12">'
      +'<h6 class="cyan-text text-darken-3 center">Asistentes</h6>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Empleados: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.empleados+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Instructores: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.instructores+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Aprendices: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.aprendices+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Público: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.publico+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Observaciones: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+response.edt.observaciones+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>');
      /**
      * Abriendo modal
      */
      $('#detalleEdt_modal').openModal();
    },
    error: function (xhr, txtStatus, errorThrown){
      alert("Error: " + errorThrown);
    }
  })
}

var selectCostoAdministrativoNodo = {
	selectCostoAdministrativoNodo: function(rol, nodo_id) {
        let nodo = null;
        if (rol == 'Administrador' || rol == 'Activador') {
            nodo = $('#selectnodo').val();
            $('#costoadministrativo_administrador_table').dataTable().fnDestroy();
        } else {
            nodo = nodo_id;
        }
        if (nodo != '') {
            $('#costoadministrativo_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                "order": [[ 1, "asc" ]],
                fixedHeader: {
                    header: true,
                    footer: true
                },

                "pagingType": "full_numbers",
                ajax: {
                    url: host_url + "/costos-administrativos/costoadministrativo/" + nodo,
                    type: "get",
                },
                columns: [
                    {
                        data: 'entidad',
                        name: 'entidad',
                        width: '30%'
                    }, {
                        data: 'costoadministrativo',
                        name: 'costoadministrativo',
                        width: '30%'
                    }, {
                        data: 'valor',
                        name: 'valor',
                        width: '15%'
                    },
                    {
                        data: 'costosadministrativospordia',
                        name: 'costosadministrativospordia',
                        width: '15%'
                    },
                    {
                        data: 'costosadministrativosporhora',
                        name: 'costosadministrativosporhora',
                        width: '15%'
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        width: '15%'
                    },
			    ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    totalCostosHora = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    totalCostosDia = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    totalCostosMes = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Total over this page
                    pageTotalCostosHora = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalCostosDia = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalCostosMes = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        '$ '+pageTotalCostosHora +' ( $'+ totalCostosHora +' total)'
                    );

                    $( api.column( 3 ).footer() ).html(
                        '$ '+pageTotalCostosDia +' ( $'+ totalCostosDia +' total)'
                    );

                    $( api.column( 2 ).footer() ).html(
                        '$ '+pageTotalCostosMes +' ( $'+ totalCostosMes +' total)'
                    );
                }
            });
        }else{
            $('#costoadministrativo_administrador_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "lengthChange": false,
                "pagingType": "full_numbers",
            }).clear().draw();
        }
    },
}

$(document).ready(function() {

    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();


    $('#equipo_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquipos(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquipos(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

    $('#equipo_actions_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquiposActions(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquiposActions(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_actions_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

var equipo = {
    fillDatatatablesEquipos(filter_nodo , filter_state){
        var datatable = $('#equipo_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [[ 1, "desc" ]],
            processing: true,
            serverSide: true,
            "lengthChange": false,
                fixedHeader: {
                header: true,
                footer: true
            },
            "pagingType": "full_numbers",
            ajax:{
                url: host_url + "/equipos",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_state: filter_state,
                }
            },
            columns: [
                {
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '30%'
                }, {
                    data: 'nombre',
                    name: 'nombre',
                    width: '30%'
                }, {
                    data: 'referencia',
                    name: 'referencia',
                    width: '15%'
                }, {
                    data: 'marca',
                    name: 'marca',
                    width: '15%'
                },
                {
                    data: 'costo_adquisicion',
                    name: 'costo_adquisicion',
                    width: '15%'
                },
                {
                    data: 'vida_util',
                    name: 'vida_util',
                    width: '15%'
                },
                {
                    data: 'horas_uso_anio',
                    name: 'horas_uso_anio',
                    width: '15%'
                },
                {
                    data: 'anio_compra',
                    name: 'anio_compra',
                    width: '15%'
                },
                {
                    data: 'anio_fin_depreciacion',
                    name: 'anio_fin_depreciacion',
                    width: '15%'
                },
                {
                    data: 'depreciacion_por_anio',
                    name: 'depreciacion_por_anio',
                    width: '15%'
                },
                {
                    data: 'state',
                    name: 'state',
                    width: '15%'
                },
            ],
        });
    },
    fillDatatatablesEquiposActions(filter_nodo , filter_state){
        var datatable = $('#equipo_actions_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [[ 1, "desc" ]],
            processing: true,
            serverSide: true,
            "lengthChange": false,
                fixedHeader: {
                header: true,
                footer: true
            },
            "pagingType": "full_numbers",
            ajax:{
                url: host_url + "/equipos",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_state: filter_state,
                }
            },
            columns: [
                {
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '30%'
                }, {
                    data: 'nombre',
                    name: 'nombre',
                    width: '30%'
                }, {
                    data: 'referencia',
                    name: 'referencia',
                    width: '15%'
                }, {
                    data: 'marca',
                    name: 'marca',
                    width: '15%'
                },
                {
                    data: 'costo_adquisicion',
                    name: 'costo_adquisicion',
                    width: '15%'
                },
                {
                    data: 'vida_util',
                    name: 'vida_util',
                    width: '15%'
                },
                {
                    data: 'state',
                    name: 'state',
                    width: '15%'
                },
                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                },
                {
                    data: 'destacar',
                    name: 'destacar',
                    width: '15%'
                },
                {
                    data: 'edit',
                    name: 'edit',
                    width: '15%',
                    orderable: false
                },
                {
                    data: 'changeState',
                    name: 'changeState',
                    width: '15%',
                    orderable: false
                },
            ],
        });
    },
    detail(id){
        $.ajax({
            dataType:'json',
            type:'get',
            url: host_url + `/equipos/${id}`
        }).done(function(response){

            $("#titulo").empty();
            $("#detalle_equipo").empty();
            if (response.statusCode == 404) {
                swal('Ups!!!', 'No se encontraron resultados', 'error');
            }else{
                let information = response.data.equipo;
                $("#titulo").append("<span class='cyan-text text-darken-3'>Nombre de Equipo: </span>"+information.nombre+"");
                $("#detalle_equipo").append(`
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Linea Tecnológica: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.lineatecnologica.abreviatura} - ${information.lineatecnologica.nombre}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Referencia: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.referencia}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Marca: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.marca}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Costo Adquisición: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">$ ${information.costo_adquisicion}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Año de compra: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.anio_compra}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Vida Util: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${information.vida_util}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Año de depreciación: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${response.data.aniodepreciacion}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span class="cyan-text text-darken-3">Valor depreciación por año: </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span class="black-text">${response.data.depreciacion}</span>
                        </div>
                    </div>
                    `);
                $('.modal-equipo').openModal();
            }
        })
    },
    // deleteEquipo: function(id){
    //     Swal.fire({
    //         title: '¿Estas seguro de eliminar este equipo?',
    //         text: "Recuerde que si lo elimina no lo podrá recuperar.",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'si, elminar equipo',
    //         cancelButtonText: 'No, cancelar',
    //       }).then((result) => {
    //         if (result.value) {
    //             let token = $("meta[name='csrf-token']").attr("content");
    //             $.ajax(
    //             {
    //                 url: host_url + `/equipos/${id}`,
    //                 type: 'DELETE',
    //                 data: {
    //                     "id": id,
    //                     "_token": token,
    //                 },
    //                 success: function (response){
    //                     if(response.statusCode == 200){
    //                         Swal.fire(
    //                             'Eliminado!',
    //                             'El equipo ha sido eliminado satisfactoriamente.',
    //                             'success'
    //                         );
    //                         location.href = response.route;
    //                     }else if(response.statusCode == 226){
    //                         Swal.fire(
    //                             'No se puede elimnar!',
    //                             response.message,
    //                             'error'
    //                         );
    //                     }
    //                 },
    //                 error: function (xhr, textStatus, errorThrown) {
    //                     alert("Error: " + errorThrown);
    //                 }
    //             });
    //         }else if ( result.dismiss === Swal.DismissReason.cancel ) {
    //             swalWithBootstrapButtons.fire(
    //                 'Cancelado',
    //                 'Tu equipo está a salvo',
    //                 'error'
    //             )
    //         }
    //     })
    // },
    changeState: function(id){
        Swal.fire({
            title: '¿Estas seguro de cambiar el estado a este equipo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar estado',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {
                $.ajax(
                {
                    url: host_url + `/equipos/cambiar-estado/${id}`,
                    type: 'GET',
                    success: function (response){
                        if(response.statusCode == 200){
                            Swal.fire(
                                'Estado cambiado!',
                                'El equipo ha cambiado de estado.',
                                'success'
                            );
                            location.href = response.route;
                        }else {
                            Swal.fire(
                                'No se puede cambiar estado!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });
            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Tu equipo está a salvo',
                    'error'
                )
            }
        })
    },
    destacarEquipo: function(id, destacado, limite) {
        let estado = destacado == 0 ? 'destacar' : 'dejar de destacar'
        Swal.fire({
            title: '¿Estás seguro de '+estado+' este equipo?',
            text: 'Solo puede haber un límite de '+limite+' equipos destacados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: destacado == 0 ? 'Sí, destacar equipo' : 'Sí, dejar de destacar equipo',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {
                $.ajax(
                {
                    url: host_url + `/equipos/destacar/${id}`,
                    type: 'GET',
                    success: function (response){
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type
                        );
                        if(response.state){
                            $('#equipo_actions_data_table').DataTable().ajax.reload();
                            // location.href = response.route;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });
            }
        })
    }
}


$('#filter_equipo').click(function(){


    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();


    $('#equipo_data_table').dataTable().fnDestroy();

    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquipos(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquipos(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();

    }

    $('#equipo_actions_data_table').dataTable().fnDestroy();

    if((filter_nodo != '' || filter_nodo != null)){
        equipo.fillDatatatablesEquiposActions(filter_nodo , filter_state);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined)  && (filter_state == '' || filter_state == null || filter_state == undefined)   ){
        equipo.fillDatatatablesEquiposActions(filter_nodo = null , filter_state = null);
    }else{
        $('#equipo_actions_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();

    }
});

$('#download_equipos').click(function(){

    let filter_nodo = $('#filter_nodo').val();
    let filter_state = $('#filter_state').val();

    var query = {
        filter_nodo: filter_nodo,
        filter_state: filter_state,
    }

    var url = host_url + "/equipos/export?" + $.param(query)
    window.location = url;
});

$(document).on('submit', 'form#frmMantenimientoEquipo', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormMantenimiento(form, data, url);
});

$(document).on('submit', 'form#frmMantenimientoEquipoEdit', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxSendFormMantenimiento(form, data, url);
});

function ajaxSendFormMantenimiento(form, data, url) {
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (data) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErroresFormulario(data);
            if (data.state != 'error_form') {
                mensajesFormMantenimiento(data);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
};

function mensajesFormMantenimiento(data) {
    if (data.state) {
        Swal.fire({
            title: data.title,
            text: data.msj,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
        setTimeout(function () {
            window.location.replace(data.url);
        }, 1000);
    } else {
        Swal.fire({
            title: data.title,
            text: data.msj,
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        })
    }
};

var mantenimiento = {
    getEquipoPorLinea:function(){
        let lineatecnologica = $('#txtlineatecnologica').val();
        let nodo = $('#txtnodo_id').val();
        if (!isset(nodo)) {
            nodo = 0;
        }
        if (!isset(lineatecnologica)) {
            lineatecnologica = 0;
        }
        $.ajax({
            dataType:'json',
            type:'get',
            url: host_url + '/equipos/getequiposporlinea/'+nodo+'/'+lineatecnologica
        }).done(function(response){
            $('#txtequipo').empty();
            if (response.equipos == '' && response.equipos.length == 0) {
                $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
            }else{
                $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                $.each(response.equipos, function(i, e) {
                    $('#txtequipo').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                });
            }
            $('#txtequipo').select2();
        });
    },
}

function getEquipoPorLineaEdit(nodo, linea, equipo){
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + '/equipos/getequiposporlinea/'+nodo+'/'+linea
    }).done(function(response){
        $('#txtequipo').empty();
        if (response.equipos == '' && response.equipos.length == 0) {
            $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
        }else{
            $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
            $.each(response.equipos, function(i, e) {
                if (e.id == equipo) {
                    $('#txtequipo').append('<option selected value="'+e.id+'">'+e.nombre+'</option>');
                } else {
                    $('#txtequipo').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                }
            });
        }
        $('#txtequipo').select2();
    });
}

function consultarLineasNodoMantenimiento(nodo_id, linea_id) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/lineas/getlineasnodo/"+nodo_id
    }).done(function(response){
        $("#txtlineatecnologica").empty();
        $('#txtlineatecnologica').append('<option value="">Seleccione la línea tecnológica</option>');
        $.each(response.lineasForNodo.lineas, function(i, e) {
            if (e.id == linea_id) {
                $('#txtlineatecnologica').append('<option value="'+e.id+'" selected>'+e.abreviatura+' - '+e.nombre+'</option>');
            } else {
                $('#txtlineatecnologica').append('<option value="'+e.id+'">'+e.abreviatura+' - '+e.nombre+'</option>');
            }
        })
        $('#txtlineatecnologica').select2();
    });
}


$(document).ready(function() {
    // $('#mantenimientosequipos_table').DataTable({
    //     language: {
    //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    //     },
    //     "pagingType": "full_numbers",
    //     "lengthChange": false,
    // });
    selectMantenimientosEquiposPorNodo.selectMantenimientosEquipoForNodo();
});

var selectMantenimientosEquiposPorNodo = {
    selectMantenimientosEquipoForNodo: function() {
        let nodo = $('#selectnodo').val();
        $('#mantenimientosequipos_table').dataTable().fnDestroy();
        if (!isset(nodo)) {
            nodo = 0;
        }
        $('#mantenimientosequipos_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            retrieve: true,
            "lengthChange": false,
             fixedHeader: {
                header: true,
                footer: true
            },
            "pagingType": "full_numbers",
            ajax: {
                url: host_url + "/mantenimientos/getmantenimientosequipospornodo/" + nodo,
                type: "get",
            },
            columns: [
                {
                    data: 'nodo',
                    name: 'nodo',
                    width: '30%'
                }, 
                {
                    data: 'lineatecnologica',
                    name: 'lineatecnologica',
                    width: '30%'
                }, 
                {
                    data: 'equipo',
                    name: 'equipo',
                    width: '30%'
                }, 
                {
                    data: 'ultimo_anio_mantenimiento',
                    name: 'ultimo_anio_mantenimiento',
                    width: '15%'
                }, 
                {
                    data: 'valor_mantenimiento',
                    name: 'valor_mantenimiento',
                    width: '15%'
                }, 
                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                }, 
                {
                    data: 'edit',
                    name: 'edit',
                    width: '15%'
                }, 
            ],
        });
        // if (nodo != '') {
            


        // }else{
        //     $('#mantenimientosequipos_table').DataTable({
        //         language: {
        //             "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //         },
        //         "lengthChange": false,
        //         "pagingType": "full_numbers",
        //     }).clear().draw();
        // }
        
    },
}
function consultarLineasNodo(nodo_id) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/lineas/getlineasnodo/"+nodo_id
      }).done(function(response){
          $("#txtlineatecnologica").empty();
          $('#txtlineatecnologica').append('<option value="">Seleccione la línea tecnológica</option>');
          $.each(response.lineasForNodo.lineas, function(i, e) {
            $('#txtlineatecnologica').append('<option  value="'+e.id+'">'+e.abreviatura+' - '+e.nombre+'</option>');
          })
          $('#txtlineatecnologica').material_select();
    });
}
function getSelectMaterialMedida(){
    let medida = $('#txtmedida option:selected').text();
    let id_medida = $('#txtmedida').val();
    $("#txtcantidad").prop('disabled', true);
    $("label[for='txtcantidad']").empty();
     if(id_medida != ''){
        $("#txtcantidad").prop('disabled', false);
        $("#txtcantidad").val('');
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete en '+medida);
    }
    else{

        $("#txtcantidad").prop('disabled', true);
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete');
    }
}

var materialFormacion = {
    destroyMaterial: function(id){

        Swal.fire({
            title: '¿Estas seguro de eliminar este material de formación?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, elminar material',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {

                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/materiales/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(data.status == 200){
                            Swal.fire(
                                'Eliminado!',
                                'El material de formación ha sido eliminado satisfactoriamente.',
                                'success'
                              );
                            location.href = data.route;

                        }else if(data.status == 226){
                            Swal.fire(
                                'No se puede elimnar!',
                                data.message,
                                'error'
                              );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                  'Cancelado',
                  'Tu material de formación está a salvo',
                  'error'
                )
            }
        })
    }
}
var selectMaterialesPorNodo = {
    selectMaterialesForNodo: function() {
        let nodo = $('#selectnodo').val();
        if (!isset(nodo)) {
            nodo = 0;
        }
        
        $('#materiales_table').dataTable().fnDestroy();
        if (isset(nodo)) {
            $('#materiales_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                retrieve: true,
                "lengthChange": false,
                 fixedHeader: {
                    header: true,
                    footer: true
                },
                "pagingType": "full_numbers",
                ajax: {
                    url: host_url + "/materiales/getmaterialespornodo/" + nodo,
                    type: "get",
                },
                columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                    width: '20%'
                },
                {
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '30%'
                },{
                    data: 'codigo_material',
                    name: 'codigo_material',
                    width: '30%'
                },
                {
                    data: 'material',
                    name: 'material',
                    width: '30%'
                }, {
                    data: 'presentacion',
                    name: 'presentacion',
                    width: '15%'
                }, {
                    data: 'medida',
                    name: 'medida',
                    width: '15%'
                },
                {
                    data: 'cantidad',
                    name: 'cantidad',
                    width: '15%'
                },
                {
                    data: 'valor_unitario',
                    name: 'valor_unitario',
                    width: '15%'
                },
                {
                    data: 'valor_compra',
                    name: 'valor_compra',
                    width: '15%'
                },
                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                }, ],
            });
        }
        
    },
    
}
$(document).ready(function() {

    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();


    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null) && (filter_module != '' || filter_module != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo, filter_module,  filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined) && (filter_module == '' || filter_module == null || filter_module == undefined)  ){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_module = null, filter_year = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

});

var usoinfraestructuraIndex = {
    fillDatatatablesUsosInfraestructura: function(filter_nodo, filter_module, filter_year){
        var datatable = $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 0, "desc" ]],
            ajax:{
                url: host_url + "/usoinfraestructura",
                type: "get",
                data: {
                    filter_nodo: filter_nodo,
                    filter_module: filter_module,
                    filter_year: filter_year
                }
            },
            columns: [
                {
                    data: 'fecha',
                    name: 'fecha',
                    width: '10%'
                }, {
                    data: 'gestorEncargado',
                    name: 'gestorEncargado',
                    width: '20%',
                    orderable: false
                },
                {
                    data: 'tipo_asesoria',
                    name: 'tipo_asesoria',
                    width: '10%'
                },
                {
                    data: 'actividad',
                    name: 'actividad',
                    width: '35%'
                }, {
                    data: 'fase',
                    name: 'fase',
                    width: '10%'
                },  {
                    data: 'detail',
                    name: 'detail',
                    width: '5%',
                    orderable: false
                },
            ],
        });
    },
    queryGestoresByNodo: function(){
        let nodo = $('#filter_nodo').val();

        if (nodo == null || nodo == '' || nodo == 'all' || nodo == undefined){
            $('#filter_gestor').empty();
            $('#filter_gestor').append('<option value="" selected>Seleccione un experto</option>');
        }else{
            $.ajax({
                type: 'GET',
                url: host_url + '/usuario/usuarios/gestores/nodo/'+ nodo,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {

                    $('#filter_gestor').empty();
                    $('#filter_gestor').append('<option value="all">todos</option>');
                    $.each(data.gestores, function(i, e) {
                        $('#filter_gestor').append('<option  value="'+i.id+'">'+e.nombre+'</option>');
                    })
                    $('#filter_gestor').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }
    },
    queryActivitiesByAnio: function(){

        let anio = $('#filter_year').val();

        if (anio == null || anio == '' || anio == undefined){

            $('#filter_actividad').empty();
            $('#filter_actividad').append('<option value="">Seleccione un año</option>');

        }else{
            $.ajax({
                type: 'GET',
                url: host_url + '/usoinfraestructura/actividades/'+ anio,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    $('#filter_actividad').empty();
                    $('#filter_actividad').append('<option value="all">Todas</option>');
                    $.each(data.actividades, function(i, e) {
                        $('#filter_actividad').append('<option  value="'+i+'">'+e+'</option>');
                    });
                    $('#filter_actividad').material_select();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }

    },

    destroyUsoInfraestructura: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este uso de infraestructura?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminar uso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/usoinfraestructura/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(data.usoinfraestructura == 'success'){
                            Swal.fire(
                                'Eliminado!',
                                'Su uso de infraestructura ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.route;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Tu uso de infraestructura está a salvo',
                    'error'
                )
            }
        })
    }
}

$('#filter_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();

    $('#usoinfraestructa_data_table').dataTable().fnDestroy();
    if((filter_nodo != '' || filter_nodo != null)  && (filter_year != '' || filter_year != null) && (filter_module != '' || filter_module != null)){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo, filter_module,  filter_year);
    }else if((filter_nodo == '' || filter_nodo == null || filter_nodo == undefined) && (filter_year == '' || filter_year == null || filter_year == undefined) && (filter_module == '' || filter_module == null || filter_module == undefined)  ){
        usoinfraestructuraIndex.fillDatatatablesUsosInfraestructura(filter_nodo = null , filter_module = null, filter_year = null);
    }else{
        $('#usoinfraestructa_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#download_usoinfraestructura').click(function(){
    let filter_nodo = $('#filter_node').val();
    let filter_year = $('#filter_year').val();
    let filter_module = $('#filter_module').val();
    var query = {
        filter_nodo: filter_nodo,
        filter_year: filter_year,
        filter_module: filter_module,
    }
    var url = host_url + "/usoinfraestructura/export?" + $.param(query)
    window.location = url;
});

function datatableVisitantesPorNodo_Ingreso() {
  $('#visitantesRedTecnoparque_table').dataTable().fnDestroy();
  $('#visitantesRedTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: host_url + "/visitante/consultarVisitantesRedTecnoparque",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'documento',
        name: 'documento',
      },
      {
        data: 'tipo_documento',
        name: 'tipo_documento',
      },
      {
        data: 'tipo_visitante',
        name: 'tipo_visitante',
      },
      {
        data: 'visitante',
        name: 'visitante',
      },
      {
        data: 'email',
        name: 'email',
      },
      {
        data: 'contacto',
        name: 'contacto'
      },
      {
        width: '8%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
}

function datatableVisitantesPorNodo_DinamizadorAdministrador() {
  $('#visitantesRedTecnoparque_table').dataTable().fnDestroy();
  $('#visitantesRedTecnoparque_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: host_url + "/visitante/consultarVisitantesRedTecnoparque",
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'documento',
        name: 'documento',
      },
      {
        data: 'tipo_documento',
        name: 'tipo_documento',
      },
      {
        data: 'tipo_visitante',
        name: 'tipo_visitante',
      },
      {
        data: 'visitante',
        name: 'visitante',
      },
      {
        data: 'email',
        name: 'email',
      },
      {
        data: 'contacto',
        name: 'contacto'
      },
    ],
  });
}

function consultarIngresosDeUnNodo(id) {
  let start_date = $('#txtstart_date_ingresos').val();
  let end_date = $('#txtend_date_ingresos').val();
  $('#ingresosDeUnNodo_table').dataTable().fnDestroy();
  $('#ingresosDeUnNodo_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: [ 0, 'desc' ],
    ajax:{
      url: host_url + "/ingreso/consultarIngresosDeUnNodoTecnoparque/"+id+"/"+start_date+"/"+end_date,
      type: "get",
    },
    columns: [
      {
        width: '15%',
        data: 'fecha_ingreso',
        name: 'fecha_ingreso',
      },
      {
        width: '15%',
        data: 'hora_salida',
        name: 'hora_salida',
      },
      {
        data: 'visitante',
        name: 'visitante',
      },
      {
        data: 'servicio',
        name: 'servicio'
      },
      {
        data: 'quien_autoriza',
        name: 'quien_autoriza'
      },
      {
        data: 'descripcion',
        name: 'descripcion'
      },
      // {
      //   width: '8%',
      //   data: 'details',
      //   name: 'details',
      //   orderable: false
      // },
      {
        width: '8%',
        data: 'edit',
        name: 'edit',
        orderable: false
      },
    ],
  });
}

// var _0xb196=['servicio','descripcion','details','edit','log','Hello\x20World!','dataTable','fnDestroy','#ingresosDeUnNodo_table','DataTable','desc','/ingreso/consultarIngresosDeUnNodoTecnoparque/','15%','fecha_ingreso','hora_salida','visitante'];(function(_0x239bcc,_0xfc3fc5){var _0x78714b=function(_0x9b5eeb){while(--_0x9b5eeb){_0x239bcc['push'](_0x239bcc['shift']());}};_0x78714b(++_0xfc3fc5);}(_0xb196,0x114));var _0x3ac4=function(_0x3532ff,_0x21a970){_0x3532ff=_0x3532ff-0x0;var _0xbac0fa=_0xb196[_0x3532ff];return _0xbac0fa;};function hi(){console[_0x3ac4('0x0')](_0x3ac4('0x1'));}function consultarIngresosDeUnNodo(_0x2984c9){$('#ingresosDeUnNodo_table')[_0x3ac4('0x2')]()[_0x3ac4('0x3')]();$(_0x3ac4('0x4'))[_0x3ac4('0x5')]({'language':{'url':'//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'},'processing':!![],'serverSide':!![],'order':[0x0,_0x3ac4('0x6')],'ajax':{'url':_0x3ac4('0x7')+_0x2984c9,'type':'get'},'columns':[{'width':_0x3ac4('0x8'),'data':_0x3ac4('0x9'),'name':_0x3ac4('0x9')},{'width':_0x3ac4('0x8'),'data':_0x3ac4('0xa'),'name':_0x3ac4('0xa')},{'data':_0x3ac4('0xb'),'name':_0x3ac4('0xb')},{'data':_0x3ac4('0xc'),'name':'servicio'},{'data':_0x3ac4('0xd'),'name':_0x3ac4('0xd')},{'width':'8%','data':_0x3ac4('0xe'),'name':'details','orderable':![]},{'width':'8%','data':_0x3ac4('0xf'),'name':_0x3ac4('0xf'),'orderable':![]}]});}hi();

function consultarVisitanteTecnoparque() {
  let doc = $('#txtdocumento').val();
  if (doc == "") {
    Swal.fire({
      title: 'Advertencia!',
      text: "Digite un número de documento!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    })
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url : host_url + '/visitante/consultarVisitantePorDocumento/'+doc,
      success: function (response) {
        if (response.visitante == null) {
          divVisitanteRegistrado.hide();
          divRegistrarVisitante.show();
        } else {
          $('#nombrePersona').val(response.visitante.visitante);
          $('#tipoPersona').val(response.visitante.tipovisitante);
          $('#contactoReg').val(response.visitante.contacto);
          $('#correoReg').val(response.visitante.email);
          $("label[for='nombrePersona']").addClass('active', true);
          $("label[for='tipoPersona']").addClass('active', true);
          $("label[for='contactoReg']").addClass('active', true);
          $("label[for='correoReg']").addClass('active', true);
          divRegistrarVisitante.hide();
          divVisitanteRegistrado.show();
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    })
  }
}

function consultarDetallesDeUnaCharlaInformativa(id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/charla/consultarDetallesDeUnaCharlaInformativa/'+id,
    success: function (data) {
      $("#modalDetalleDeUnaCharlaInformativa_titulo").empty();
      $("#modalDetalleDeUnaCharlaInformativa_detalle_charla").empty();
      $("#modalDetalleDeUnaCharlaInformativa_titulo").append("<span class='cyan-text text-darken-3'>Datos de la Charla Informativa </span><br>");
      $("#modalDetalleDeUnaCharlaInformativa_detalle_charla").append("<div class='row'>"
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Código de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.codigo_charla+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Fecha de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.fecha+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Encargado de la Charla Informativa: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.encargado+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Número de Asistentens: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.nro_asistentes+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Observaciones: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.observacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<h5 class="center">Evidencias</h5>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Programación de la Charla (Pantallazo del Envío de Correos): </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.programacion+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Evidencias Fotográficas: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.evidencia_fotografica+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'

      +'<div class="row">'
      +'<div class="col s12 m6 l6">'
      +'<span class="cyan-text text-darken-3">Listado de Asistencia: </span>'
      +'</div>'
      +'<div class="col s12 m6 l6">'
      +'<span class="black-text">'+data.charla.listado_asistentes+'</span>'
      +'</div>'
      +'</div>'
      +'<div class="divider"></div>'
    );
    $('#detalleDeUnaCharlaInformativa_modal').openModal();
  },
  error: function (xhr, textStatus, errorThrown) {
    alert("Error: " + errorThrown);
  }
})
}

$(document).ready(function(){});
var ano = (new Date).getFullYear();

var graficosId = {
  grafico1: 'graficoArticulacionesPorGestorYNodoPorFecha_stacked',
  grafico2: 'graficoArticulacionesPorGestorYFecha_stacked',
  grafico3: 'graficoArticulacionesPorLineaYFecha_stacked',
  grafico4: 'graficoArticulacionesPorNodoYAnho_variablepie'
};

var graficosEdtId = {
  grafico1: 'graficosEdtsPorGestorNodoYFecha_stacked',
  grafico2: 'graficosEdtsPorGestorYFecha_stacked',
  grafico3: 'graficoEdtsPorLineaYFecha_stacked',
  grafico4: 'graficoEdtsPorNodoYAnho_variablepie'
};

var graficosProyectoId = {
  grafico1: 'graficosProyectoPorMesYNodo_combinate',
  grafico2: 'graficosProyectoConEmpresaPorMesYNodo_combinate',
  grafico3: 'graficoProyectosPorTipoNodoYFecha_column',
  grafico4: 'graficoProyectosFinalizadosPorNodoYAnho_column',
  grafico5: 'graficoProyectosFinalizadosPorTipoNodoYFecha_column'
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
}

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un experto', 'warning');
}

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una Línea Tecnológica', 'warning');
}

function alertaFechasNoValidas() {
  Swal.fire('Advertencia!', 'Seleccione fechas válidas!', 'warning');
}

function generarExcelGrafico3Edt(bandera) {
  let idnodo = 0;
  let idlinea = $('#txtlinea_id_edtGrafico3').val();
  let fecha_inicio = $('#txtfecha_inicio_GraficoEdt3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoEdt3').val();

  if ( bandera == 1 ) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    alertaNodoNoValido();
  } else {
    if ( idlinea === '' ) {
      alertaLineaNoValido();
    } else {
      location.href = '/excel/excelEdtsFinalizadasPorLineaNodoYFecha/'+idnodo+'/'+idlinea+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }

}

function generarExcelGrafico2Edt(bandera) {
  let id = 0;

  if (bandera == 0) {
    id = $('#txtgestor_id_edtGrafico2').val();
  }

  let fecha_inicio = $('#txtfecha_inicio_edtGrafico2').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico2').val();

  if (id === '') {
    alertaGestorNoValido();
  } else {
    location.href = '/excel/excelEdtsFinalizadasPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico1Edt(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico1').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelEdtsFinalizadasPorFechaYNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}


function generarExcelGrafico1Articulacion(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorFechaYNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico3Articulacion(bandera) {
  let id = 0;
  let linea = $('#txtlinea_tecnologica').val();
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    if (linea === '') {
      alertaLineaNoValido();
    } else {
      location.href = '/excel/excelArticulacionFinalizadasPorFechaNodoYLinea/'+id+'/'+linea+'/'+fecha_inicio+'/'+fecha_fin;
    }
  }

}

function generarExcelGrafico2Articulacion() {
  let id = $('#txtgestor_id').val();
  let fecha_inicio = $('#txtfecha_inicio_Grafico2').val();
  let fecha_fin = $('#txtfecha_fin_Grafico2').val();

  if (id === '') {
    alertaGestorNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin;
  }

}

function generarExcelGrafico4Articulacion(bandera) {
  let id = 0;
  let anho = $('#txtanho_Grafico4').val();

  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if (id === '') {
    alertaNodoNoValido();
  } else {
    location.href = '/excel/excelArticulacionFinalizadasPorNodoYAnho/'+id+'/'+anho;
  }

}

function generarExcelGrafico1Proyecto(bandera) {
  let id = 0;
  let anho = $('#txtanho_GraficoProyecto1').val();
  if (bandera == 1) {
    id = $('#txtnodo_excelGrafico1Proyecto').val();
  }
  location.href = '/excel/excelProyectosInscritosPorAnho/'+id+'/'+anho
}

function generarExcelGrafico2Proyecto(bandera) {
  let id = 0;
  let anho = $('#txtanho_GraficoProyecto2').val();
  if (bandera == 1) {
    id = $('#txtnodo_excelGrafico2Proyecto').val();
  }
  location.href = '/excel/excelProyectosInscritosConEmpresasPorAnho/'+id+'/'+anho
}

function graficosProyectosPromedioCantidadesMeses(data, name) {
  let tamanho = data.proyectos.cantidades.length;
  let datos = {
    cantidades: [],
    meses: [],
    promedios: []
  };
  for (let i = 0; i < tamanho; i++) {
    datos.cantidades.push(data.proyectos.cantidades[i]);
  }
  for (let i = 0; i < tamanho; i++) {
    datos.meses.push(data.proyectos.meses[i]);
  }
  for (let i = 0; i < tamanho; i++) {
    datos.promedios.push(data.proyectos.promedios[i]);
  }
  Highcharts.chart(name, {
    title: {
      text: 'Proyectos Inscritos'
    },
    yAxis: {
      title: {
        text: 'Cantidad/Promedio'
      }
    },
    xAxis: {
      categories: datos.meses,
      title: {
        text: 'Meses'
      }
    },
    series: [{
      type: 'column',
      name: 'Proyectos Inscritos',
      data: datos.cantidades
    }, {
      type: 'spline',
      name: 'Proyectos Inscritos',
      data: datos.cantidades,
      dataLabels: {
        enabled: true
      },
      marker: {
        lineWidth: 2,
        lineColor: '#008981',
        fillColor: '#008981'
      }
    }]
  });
}

function graficosProyectosAgrupados(data, name, name_label) {
  let tamanho = data.proyectos.cantidades.length;
  let datos = {
    cantidades: [],
    labels: [],
  };
  for (let i = 0; i < tamanho; i++) {
    datos.cantidades.push(data.proyectos.cantidades[i]);
  }

  for (let i = 0; i < tamanho; i++) {
    datos.labels.push(data.proyectos.labels[i]);
  }

  Highcharts.chart(name, {
    title: {
      text: 'Proyectos Inscritos'
    },
    yAxis: {
      title: {
        text: 'Cantidad'
      }
    },
    xAxis: {
      categories: datos.labels,
      title: {
        text: name_label
      }
    },
    series: [{
      type: 'column',
      name: 'Proyectos Inscritos',
      data: datos.cantidades
    }, {
      type: 'spline',
      name: 'Proyectos Inscritos',
      data: datos.cantidades,
      dataLabels: {
        enabled: true
      },
      marker: {
        lineWidth: 2,
        lineColor: '#008981',
        fillColor: '#008981'
      }
    }]
  });
}

function consultarProyectosFinalizadosPorTipoNodoYFecha_column(bandera) {
  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_GraficoProyecto5').val();
  let fecha_fin = $('#txtfecha_fin_GraficoProyecto5').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }

  if ( fecha_inicio > fecha_fin ) {
    alertaFechasNoValidas();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarProyectosFinalizadosPorTipoNodoYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
      success: function (data) {
        graficosProyectosAgrupados(data, graficosProyectoId.grafico5, 'Tipo de Proyecto');
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function consultarProyectosInscritosPorTipoNodoYFecha_column(bandera) {

  let id = 0;
  let fecha_inicio = $('#txtfecha_inicio_GraficoProyecto3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoProyecto3').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosInscritosPorTipoNodoYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      graficosProyectosAgrupados(data, graficosProyectoId.grafico3, 'Tipo de Proyecto');
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })

}


function consultarProyectosFinalizadosPorAnho_combinate(bandera) {
  id = 0;
  let anho = $('#txtanho_GraficoProyecto4').val();
  if (bandera == 1) {
    id = $('#txtnodo_id').val();
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosFinalzadosPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico4);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosConEmpresasPorAnho_combinate(bandera, anho) {
  id = 0;
  if (bandera == 1) {
    id = $('#txtnodo_proyectoGrafico1');
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosInscritosConEmpresasPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico2);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosPorAnho_combinate(bandera, anho) {
  id = 0;
  if (bandera == 1) {
    id = $('#txtnodo_proyectoGrafico1');
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarProyectosInscritosPorAnho/'+id+'/'+anho,
    success: function (data) {
      graficosProyectosPromedioCantidadesMeses(data, graficosProyectoId.grafico1);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarEdtsDelNodoPorAnho_variablepie(bandera) {
  let anho = $('#txtanho_GraficoEdt4').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarEdtsPorNodoYAnho/'+idnodo+'/'+anho,
      success: function (data) {
        Highcharts.chart(graficosEdtId.grafico4, {
          chart: {
            type: 'variablepie'
          },
          title: {
            text: 'Tipos de Edt\'s.'
          },
          plotOptions: {
            variablepie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                connectorColor: 'silver'
              }
            }
          },
          tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad: <b>{point.y}</b><br/>'
          },
          series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: '',
            data: [
              { name: 'Tipo 1', y: data.consulta.tipo1, z: 15 },
              { name: 'Tipo 2', y: data.consulta.tipo2, z: 15 },
              { name: 'Tipo 3', y: data.consulta.tipo3, z: 15 }
            ]
          }]
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })

  }
}

function consultarEdtsPorLineaYFecha_stacked(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  let fecha_inicio = $('#txtfecha_inicio_GraficoEdt3').val();
  let fecha_fin = $('#txtfecha_fin_GraficoEdt3').val();
  let id = $('#txtlinea_id_edtGrafico3').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona una Línea Tecnológica!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarEdtsPorLineaYFecha/'+id+'/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          Highcharts.chart(graficosEdtId.grafico3, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Tipos de Edt\'s'
            },
            xAxis: {
              categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
              title: {
                text: 'Tipos de Edt\'s'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Edt\'s'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.lineatecnologica, data: [data.consulta.tipo1, data.consulta.tipo2, data.consulta.tipo3]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

function consultarEdtsPorGestorYFecha_stacked(bandera) {
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico2').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico2').val();
  let id = $('#txtgestor_id_edtGrafico2').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona un experto!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarEdtsPorGestorYFecha/'+id+'/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          Highcharts.chart(graficosEdtId.grafico2, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Tipos de Edt\'s'
            },
            xAxis: {
              categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
              title: {
                text: 'Tipos de Edt\'s'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Edt\'s'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.gestor, data: [data.consulta.tipo1, data.consulta.tipo2, data.consulta.tipo3]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

function consultarEdtsPorNodoGestorYFecha_stacked(bandera) {
  let fecha_inicio = $('#txtfecha_inicio_edtGrafico1').val();
  let fecha_fin = $('#txtfecha_fin_edtGrafico1').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }
  if (fecha_inicio > fecha_fin) {
    Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarEdtsPorNodoGestorYFecha/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin,
      success: function (data) {
        var tamanho = data.consulta.length;
        var datos = {
          gestores: [],
          tipo1Array: [],
          tipo2Array: [],
          tipo3Array: []
        };
        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].gestor != null) {
            datos.gestores.push(data.consulta[i].gestor);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos1 != null) {
            datos.tipo1Array.push(data.consulta[i].tipos1);
          }
        }

        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos2 != null) {
            datos.tipo2Array.push(data.consulta[i].tipos2);
          }
        }
        for (var i = 0; i < tamanho; i++) {
          if (data.consulta[i].tipos3 != null) {
            datos.tipo3Array.push(data.consulta[i].tipos3);
          }
        }

        var dataGraphic = [];

        for (var i = 0; i < tamanho; i++) {
          let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.tipo1Array[i]+', '+datos.tipo2Array[i]+', '+datos.tipo3Array[i]+']}';
          array = JSON.parse(array);
          dataGraphic.push(array);
        }
        Highcharts.chart(graficosEdtId.grafico1, {
          chart: {
            type: 'column'
            // renderTo: ''
          },
          title: {
            text: 'Edt\'s entre ' + fecha_inicio + ' y ' + fecha_fin
          },
          xAxis: {
            categories: ['Tipo 1', 'Tipo 2', 'Tipo 3'],
            title: {
              text: 'Tipos de Edt\'s'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Número de Edts\'s'
            }
          },
          legend: {
            reversed: true
          },
          plotOptions: {
            series: {
              stacking: 'normal'
            }
          },
          series: dataGraphic
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    });
  }
}


function consultarTiposDeArticulacionesDelAnho_variablepie(bandera) {
  let anho = $('#txtanho_Grafico4').val();
  let idnodo = 0;
  if (bandera == 1) {
    idnodo = $('#txtnodo_id').val();
  }

  if (idnodo === '') {
    Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/grafico/consultarArticulacionesPorNodoYAnho/'+idnodo+'/'+anho,
      success: function (data) {
        Highcharts.chart(graficosId.grafico4, {
          chart: {
            type: 'variablepie'
          },
          title: {
            text: 'Tipos de Articulación.'
          },
          plotOptions: {
            variablepie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                connectorColor: 'silver'
              }
            }
          },
          tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad: <b>{point.y}</b><br/>'
            // 'Population density (people per square km): <b>{point.z}</b><br/>'
          },
          series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: '',
            data: [
              { name: 'Grupos de Investigación', y: data.consulta.grupos, z: 15 },
              { name: 'Empresas', y: data.consulta.empresas, z: 15 },
              { name: 'Emprendedores', y: data.consulta.emprendedores, z: 15 }
            ]
          }]
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })

  }
}

function articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/grafico/consultarArticulacionesPorNodo/'+id+'/'+fecha_inicio+'/'+fecha_fin,
    success: function (data) {
      var tamanho = data.consulta.length;
      var datos = {
        gestores: [],
        gruposArray: [],
        empresasArray: [],
        emprendedoresArray: []
      };
      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].gestor != null) {
          datos.gestores.push(data.consulta[i].gestor);
        }
      }

      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].grupos != null) {
          datos.gruposArray.push(data.consulta[i].grupos);
        }
      }

      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].empresas != null) {
          datos.empresasArray.push(data.consulta[i].empresas);
        }
      }
      for (var i = 0; i < tamanho; i++) {
        if (data.consulta[i].emprendedores != null) {
          datos.emprendedoresArray.push(data.consulta[i].emprendedores);
        }
      }

      var dataGraphic = [];

      for (var i = 0; i < tamanho; i++) {
        let array = '{"name": "'+datos.gestores[i]+'", "data": ['+datos.gruposArray[i]+', '+datos.empresasArray[i]+', '+datos.emprendedoresArray[i]+']}';
        array = JSON.parse(array);
        dataGraphic.push(array);
      }
      Highcharts.chart(graficosId.grafico1, {
        chart: {
          type: 'column'
          // renderTo: ''
        },
        title: {
          text: 'Articulaciones entre ' + fecha_inicio + ' y ' + fecha_fin
        },
        xAxis: {
          categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
          title: {
            text: 'Tipos de Articulaciones'
          }
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Número de Articulaciones'
          }
        },
        legend: {
          reversed: true
        },
        plotOptions: {
          series: {
            stacking: 'normal'
          }
        },
        series: dataGraphic
      });
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  });
}

function consultaArticulacionesDelGestorPorNodoYFecha_stacked(id) {
  let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
  let fecha_fin = $('#txtfecha_fin_Grafico1').val();
  articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin);
}

function consultaArticulacionesDelGestorPorNodoYFecha_stackedAdministrador() {
  let id = $('#txtnodo_id').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Seleccione un Nodo!', 'warning');
  } else {
    let fecha_inicio = $('#txtfecha_inicio_Grafico1').val();
    let fecha_fin = $('#txtfecha_fin_Grafico1').val();
    articulacionesGrafico1Ajax(id, fecha_inicio, fecha_fin);
  }
}

function consultarArticulacionesDeUnGestorPorFecha_stacked() {
  let fecha_inicio = $('#txtfecha_inicio_Grafico2').val();
  let fecha_fin = $('#txtfecha_fin_Grafico2').val();
  let id = $('#txtgestor_id').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona un experto!', 'warning');
  } else {
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Selecciona fecha válidas!', 'warning');
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarArticulacionesPorGestorYFecha/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        success: function (data) {
          Highcharts.chart(graficosId.grafico2, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones'
            },
            xAxis: {
              categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
              title: {
                text: 'Tipos de Articulaciones'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Articulaciones'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.gestor, data: [data.consulta.grupos, data.consulta.empresas, data.consulta.emprendedores]}]
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
      });
    }
  }
}

/**
* Consulta la cantidad de arituclaciones por tipo según la línea tecnológica de un nodo y parametrizado entre fechas (estas fecha son de cierre)
*/
function consultarArticulacionesDeUnaLineaDelNodoPorFechas_stacked(bandera) {
  let idnodo = "";
  if (bandera == 0) {
    idnodo = 0;
  } else {
    idnodo = $('#txtnodo_id').val();
  }
  let id = $('#txtlinea_tecnologica').val();
  if (id == '') {
    Swal.fire('Advertencia!', 'Selecciona una Línea Tecnológica!', 'warning')
  } else {
    let fecha_inicio = $('#txtfecha_inicio_Grafico3').val();
    let fecha_fin = $('#txtfecha_fin_Grafico3').val();
    if (fecha_inicio > fecha_fin) {
      Swal.fire('Advertencia!', 'Debes seleccionar fecha válidas!', 'warning')
    } else {
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/grafico/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/'+idnodo+'/'+id+'/'+fecha_inicio+'/'+fecha_fin,
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        },
        success: function (data) {
          Highcharts.chart(graficosId.grafico3, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Articulaciones'
            },
            xAxis: {
              categories: ['Grupos de Investigación', 'Empresas', 'Emprendedores'],
              title: {
                text: 'Tipos de Articulaciones'
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Número de Articulaciones'
              }
            },
            legend: {
              reversed: true
            },
            plotOptions: {
              series: {
                stacking: 'normal'
              }
            },
            series: [{name: data.consulta.lineatecnologica, data: [data.consulta.grupos, data.consulta.empresas, data.consulta.emprendedores]}]
          });
        }
      })
    }
  }
}

var graficosSeguimiento = {
  gestor: 'graficoSeguimientoEsperadoPorGestorDeUnNodo_column',
  nodo_esperado: 'graficoSeguimientoDeUnNodo_column',
  tecnoparque_esperado: 'graficoSeguimientoTecnoparque_column',
  nodo_fases: 'graficoSeguimientoDeUnNodoFases_column',
  tecnoparque_fases: 'graficoSeguimientoTecnoparqueFases_column',
  gestor_fases: 'graficoSeguimientoPorGestorFases_column',
  linea_esperado: 'graficoSeguimientoEsperadoPorLineaDeUnNodo_column',
  linea_actual: 'graficoSeguimientoActualPorLineaDeUnNodo_column',
  inscritos_mes: 'graficoSeguimientoInscritosPorMes_column'
};

function alertaLineaNoValido() {
  Swal.fire('Advertencia!', 'Seleccione una línea tecnológica', 'warning');
};

function alertaGestorNoValido() {
  Swal.fire('Advertencia!', 'Seleccione un experto', 'warning');
};

function alertaNodoNoValido() {
  Swal.fire('Advertencia!', 'Seleccione por lo menos un nodo', 'warning');
};
// 0 para cuando el Dinamizador consultar
// 1 para cuando el experto consulta

function consultarSeguimientoDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoEsperadoDeUnGestor/'+gestor_id,
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.gestor);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

// Bandera
// 0 para dinamizadores y expertos
// 1 para administradores
function consultarSeguimientoEsperadoDeUnaLinea(bandera) {
  let nodo_id = null;
  let linea_id = null;
  if (bandera == 0) {
    linea_id = $('#txtlinea_esperado').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
  } else {
    linea_id = $('#txtlinea_esperado').val();
    nodo_id = $('#txtnodo_linea_esperado').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
    if (nodo_id == '') {
      return alertaNodoNoValido();
    }
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoEsperadoDeUnaLinea/'+linea_id+'/'+nodo_id,
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.linea_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarProyectosInscritosPorMes(gestor_id) {
  if (gestor_id == null) {
      alertaGestorNoValido();
  } else {
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: host_url + '/seguimiento/seguimientoInscritosPorMesExperto/'+gestor_id,
      success: function (data) {
        graficoSeguimientoPorMes(data, graficosSeguimiento.inscritos_mes);
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      },
    })
  }
}

function consultarSeguimientoActualDeUnaLinea(bandera) {
  let nodo_id = null;
  let linea_id = null;
  if (bandera == 0) {
    linea_id = $('#txtlinea_actual').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
  } else {
    linea_id = $('#txtlinea_actual').val();
    nodo_id = $('#txtnodo_linea_actual').val();
    if (linea_id == '') {
      return alertaLineaNoValido();
    }
    if (nodo_id == '') {
      return alertaNodoNoValido();
    }
  }
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoActualDeUnaLinea/'+linea_id+'/'+nodo_id,
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.linea_actual);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
}

function consultarSeguimientoActualDeUnGestor(gestor_id) {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoActualDeUnGestor/'+gestor_id,
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.gestor_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoEsperadoDeTecnoparque() {

  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoEsperadoDeTecnoparque/',
    success: function (data) {
      graficoSeguimientoEsperado(data, graficosSeguimiento.tecnoparque_esperado);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function consultarSeguimientoDeTecnoparqueFases() {
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: host_url + '/seguimiento/seguimientoDeTecnoparqueFases/',
    success: function (data) {
      graficoSeguimientoFases(data, graficosSeguimiento.tecnoparque_fases);
    },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  })
};

function graficoSeguimientoEsperado(data, name) {
  let nodos = [];
  let trl6 = [];
  let trl7_8 = [];
  data.datos.forEach(element => {
    nodos.push(element.nodo);
    trl6.push(element.trl6);
    trl7_8.push(element.trl7_8);
  });
  Highcharts.chart(name, {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Proyectos que se encuentran activos'
    },
    yAxis: {
      min: 0,
      title: {
          text: 'Cantidad de proyectos'
      },
      stackLabels: {
          enabled: true,
          style: {
              fontWeight: 'bold',
              color: ( // theme
                  Highcharts.defaultOptions.title.style &&
                  Highcharts.defaultOptions.title.style.color
              ) || 'gray',
              textOutline: 'none'
          }
      }
    },
    xAxis: {
      title: {
        text: 'Nodos'
      },
      categories: nodos
    },
    legend: {
      align: 'left',
      x: 70,
      verticalAlign: 'top',
      y: 20,
      floating: true,
      backgroundColor:
          Highcharts.defaultOptions.legend.backgroundColor || 'white',
      borderColor: '#CCC',
      borderWidth: 1,
      shadow: false
    },
    plotOptions: {
      column: {
          stacking: 'normal',
          dataLabels: {
              enabled: true
          }
      }
    },
    series: [{
        name: 'TRL 6 esperado',
        data: trl6
    }, {
        name: 'TRL 7 y 8 esperado',
        data: trl7_8
    }]
  });
}

function graficoSeguimientoPorMes(data, name) {
  Highcharts.chart(name, {
    title: {
      text: 'Proyectos inscritos por mes en el año actual'
    },
    subtitle: {
      text: 'Cuando el mes no aparece es porque el valor es cero(0)'
    },
    yAxis: {
      title: {
        text: 'Cantidad de proyectos'
      }
    },
    xAxis: {
      categories: data.datos.meses,
      accessibility: {
        rangeDescription: 'Mes'
      }
    },
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    },
    series: [{
      name: 'Proyectos inscritos',
      data: data.datos.cantidades
    }],

    responsive: {
      rules: [{
        condition: {
          maxWidth: 500
        },
        chartOptions: {
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
          }
        }
      }]
    }
  });
}

function graficoSeguimientoFases(data, name) {
  let nodos = [];
  let inicio = [];
  let planeacion = [];
  let ejecucion = [];
  let cierre = [];
  let finalizado = [];
  let suspendido = [];
  data.datos.forEach(element => {
    nodos.push(element.nodo);
    inicio.push(element.inicio);
    planeacion.push(element.planeacion);
    ejecucion.push(element.ejecucion);
    cierre.push(element.cierre);
    finalizado.push(element.finalizado);
    suspendido.push(element.suspendido);
  });
  Highcharts.chart(name, {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Proyectos actuales y finalizados en el año actual'
    },
    xAxis: {
        title: {
          text: 'Nodos'
        },
        categories: nodos
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Cantidad de proyectos'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray',
                textOutline: 'none'
            }
        }
    },
    legend: {
        align: 'left',
        x: 70,
        verticalAlign: 'top',
        y: 20,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    series: [{
        name: 'Inicio',
        data: inicio
    }, {
        name: 'Planeación',
        data: planeacion
    }, {
        name: 'Ejecución',
        data: ejecucion
    }, {
      name: 'Cierre',
      data: cierre
    }, {
      name: 'Finalizado',
      data: finalizado
    }, {
      name: 'Suspendido',
      data: suspendido
    }]
});
}

var graficosCostos = {
    actividad: 'costosDeUnProyecto_column',
    proyectos: 'costosDeProyectos_column',
    proyectos_ipe: 'costosDeProyectos_ipe_column'
};

function setValueInput(data, chart) {
    $('#txtcosto_asesorias' + chart).val(formatMoney(data.costosAsesorias));
    $("label[for='txtcosto_asesorias"+chart+"']").addClass("active", true);
    $('#txtcostos_equipos' + chart).val(formatMoney(data.costosEquipos));
    $("label[for='txtcostos_equipos"+chart+"']").addClass("active", true);
    $('#txtcostos_materiales' + chart).val(formatMoney(data.costosMateriales));
    $("label[for='txtcostos_materiales"+chart+"']").addClass("active", true);
    $('#txtcostos_administrativos' + chart).val(formatMoney(data.costosAdministrativos));
    $("label[for='txtcostos_administrativos"+chart+"']").addClass("active", true);
    $('#txtcosto_total' + chart).val(formatMoney(data.costosTotales));
    $("label[for='txtcosto_total"+chart+"']").addClass("active", true);
    $('#txthoras_asesoria' + chart).val(data.horasAsesorias);
    $("label[for='txthoras_asesoria"+chart+"']").addClass("active", true);
    $('#txthoras_uso' + chart).val(data.horasEquipos);
    $("label[for='txthoras_uso"+chart+"']").addClass("active", true);
}

function consultarCostosDeProyectos(bandera, tipo) {
    let idnodo = 0;
    let tipos = [];
    let estado;
    let fecha_inicio;
    let fecha_fin;
    let chart = '';

    if (tipo == 1) {
        chart = '_proyectos';
        estado = $("input[name='estado']:checked").val();
        fecha_inicio = $('#txtfecha_inicio_costosProyectos').val();
        fecha_fin = $('#txtfecha_fin_costosProyectos').val();
        $("input[name='tipoProyecto[]']:checked").each(function (index, obj) {
        tipos.push($(this).val());
        });
    } else {
        chart = '_proyectos_ipe';
        estado = $("input[name='estado_ipe']:checked").val();
        fecha_inicio = $('#txtfecha_inicio_costosProyectos_ipe').val();
        fecha_fin = $('#txtfecha_fin_costosProyectos_ipe').val();
        $("input[name='tipoProyecto_ipe[]']:checked").each(function (index, obj) {
            tipos.push($(this).val());
        });
    }

  // En caso de que sea el Administrador el que consulta los costos
    if (bandera == 1) {
        idnodo = $('#txtnodo_id').val();
    }

    if (idnodo === '') {
        Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
    } else {
        if (tipos.length == 0) {
        Swal.fire('Advertencia!', 'Seleccione por lo menos un tipo de proyecto', 'warning');
        } else {
        if (estado == null) {
            Swal.fire('Advertencia!', 'Seleccione un estado de proyecto', 'warning');
        } else {
            if (fecha_inicio > fecha_fin) {
            Swal.fire('Advertencia!', 'Seleccione fecha válidas', 'warning');
            } else {
            let tiposArr = JSON.stringify(tipos);
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: host_url + '/costos/costosDeProyectos/'+idnodo+'/'+tiposArr+'/'+estado+'/'+fecha_inicio+'/'+fecha_fin+'/'+tipo,
                success: function (data) {
                setValueInput(data, chart);
                graficoCostos(data, tipo == 1 ? graficosCostos.proyectos : graficosCostos.proyectos_ipe, 'Proyectos');
                },
                error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
                },
            })
            }
        }
        }
    }
}

function consultarCostoDeUnaActividad() {
    let id = $('#txtactividad_id').val();
    if (id === '') {
        Swal.fire('Advertencia!', 'Seleccione una actividad', 'warning');
    } else {
        $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/costos/proyecto/'+id,
        success: function (data) {
            let chart = '_actividad';
            setValueInput(data, chart);
            $('#txtgestor' + chart).val(data.gestorActividad);
            $("label[for='txtgestor"+chart+"']").addClass("active", true);
            $('#txtlinea' + chart).val(data.lineaActividad);
            $("label[for='txtlinea"+chart+"']").addClass("active", true);
            graficoCostos(data, graficosCostos.actividad, data.codigoActividad);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
        })
    }
}

function graficoCostos(data, name, title) {
  Highcharts.chart(name, {
    exporting: {
      allowHTML: true,
      chartOptions: {
        chart: {
          height: 600,
          marginTop: 110,
          events: {
            load: function() {
              this.renderer.image('http://drive.google.com/uc?export=view&id=1qLb9tjGI1hEnmEzQ6mPzxqv1zjMtxdMw', 80, 20, 200, 47).add();
              this.renderer.image('http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C', 290, 20, 200, 47).add();
              this.update({
                credits: {
                  text: 'Generado: ' + Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', Date.now())
                }
              });
            }
          }
        },
        legend: {
          y: -220
        },
        title: {
          align: 'center',
          y: 90
        },

      }
    },
    chart: {
      type: 'column',
    },
    title: {
      text: 'Costos - ' + title
    },
    yAxis: {
      title: {
        text: '$ Pesos'
      },
      labels: {
        format: '$ {value}'
      }
    },
    xAxis: {
        type: 'category'
    },
    legend: {
        enabled: false,
        floating: true,
    },
    tooltip: {
      headerFormat: '<span style="font-size:11px">Costos</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y}</b><br/>'
    },
    plotOptions: {
      series: {
        dataLabels: {
          enabled: true
        },
        animationLimit: 1000
      },
    },
    series: [
      {
        colorByPoint: true,
        data: [
          {
            name: "Costos de Asesorias",
            y: data.costosAsesorias,
          },
          {
            name: "Costos de Equipos",
            y: data.costosEquipos,
          },
          {
            name: "Costos de Materiales",
            y: data.costosMateriales,
          },
          {
            name: "Costos Administrativos",
            y: data.costosAdministrativos,
          },
          {
            name: "Total de Costos",
            y: data.costosTotales,
          },
        ]
      }
    ],
  });
}

$(document).ready(function() {

    let filter_node_articulationStage = $('#filter_node_articulationStage').val();
    let filter_year_articulationStage = $('#filter_year_articulationStage').val();
    let filter_status_articulationStage = $('#filter_status_articulationStage').val();
    if((filter_node_articulationStage == '' || filter_node_articulationStage == null) && (filter_year_articulationStage =='' || filter_year_articulationStage == null) && (filter_status_articulationStage == '' || filter_status_articulationStage == null)){
        articulationStage.filtersDatatableAccompanibles(filter_node_articulationStage = null,filter_year_articulationStage = null, filter_status_articulationStage = null);
    }else if((filter_node_articulationStage != '' || filter_node_articulationStage != null) || filter_year_articulationStage !='' && filter_status_articulationStage != ''){
        articulationStage.filtersDatatableAccompanibles(filter_node_articulationStage, filter_year_articulationStage, filter_status_articulationStage);
    }else{

        $('#articulationStage_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "pageLength": 10,
            "lengthChange": false,
        }).clear().draw();
    }
});

$('#filter_articulationStage').click(function () {
    let filter_node_articulationStage = $('#filter_node_articulationStage').val();
    let filter_year_articulationStage = $('#filter_year_articulationStage').val();
    let filter_status_articulationStage = $('#filter_status_articulationStage').val();
    $('#articulationStage_data_table').dataTable().fnDestroy();
    if((filter_node_articulationStage == '' || filter_node_articulationStage == null) && filter_year_articulationStage !='' && filter_status_articulationStage != ''){
        articulationStage.filtersDatatableAccompanibles(filter_node_articulationStage = null,filter_year_articulationStage, filter_status_articulationStage);
    }else if((filter_node_articulationStage != '' || filter_node_articulationStage != null) && filter_year_articulationStage !='' && filter_status_articulationStage != ''){
        articulationStage.filtersDatatableAccompanibles(filter_node_articulationStage, filter_year_articulationStage, filter_status_articulationStage);
    }else{
        $('#articulationStage_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "pageLength": 10,
            "lengthChange": false,
        }).clear().draw();
    }
});

$('#download_articulationStage').click(function(){
    let filter_node_articulationStage = $('#filter_node_articulationStage').val();
    let filter_year_articulationStage = $('#filter_year_articulationStage').val();
    let filter_status_articulationStage= $('#filter_status_articulationStage').val();
    const query = {
        filter_node_articulationStage: filter_node_articulationStage,
        filter_year_articulationStage: filter_year_articulationStage,
        filter_status_articulationStage: filter_status_articulationStage
    }
    const url = "/etapa-articulaciones/export?" + $.param(query)
    window.location = url;
});

const articulationStage = {
    filtersDatatableAccompanibles: function(filter_node_articulationStage,filter_year_articulationStage, filter_status_articulationStage){
        let groupColumn = 1;
        let table = $('#articulationStage_data_table').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar Entradas _MENU_",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            lengthMenu: [
                [5, 10, 25,50, 100, -1],
                [5, 10,25, 50, 100, 'Todos'],
            ],
            "pageLength": 10,
            "lengthChange": false,
            processing: false,
            serverSide: false,

            ajax:{
                url: "/etapa-articulaciones/datatable_filtros",
                type: "get",
                data: {
                    filter_node_articulationStage: filter_node_articulationStage,
                    filter_year_articulationStage: filter_year_articulationStage,
                    filter_status_articulationStage: filter_status_articulationStage,
                }
            },
            columns: [
                {
                    data: 'node',
                    name: 'node',
                },
                {
                    data: 'articulationstate_name',
                    name: 'articulationstate_name',
                },
                {
                    data: 'articulation_name',
                    name: 'articulation_name',
                },{
                    data: 'description',
                    name: 'description',
                },
                {
                    data: 'phase',
                    name: 'phase',
                },
                {
                    data: 'starDate',
                    name: 'starDate',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
            columnDefs: [{ visible: false, targets: groupColumn }],
            displayLength: 25,
            drawCallback: function (settings) {
                let api = this.api();
                let rows = api.rows({ page: 'current' }).nodes();
                let last = null;
                api
                    .column(groupColumn, { page: 'current' })
                    .data()
                    .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(`${group}`);
                    last = group;
                    }
                    });
            },
        });
    },
    fill_code_project:function(filter_code_project = null){
        articulationStage.emptyResult('result-projects');
        if(filter_code_project.length > 0){
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: '/actividades/filter-code/' + filter_code_project
            }).done(function (response) {
                if(response.data.status_code == 200){
                    articulationStage.emptyResult('result-talents');
                    let activity = response.data.proyecto.articulacion_proyecto.actividad;
                    let data = response.data;
                    $('.result-projects').append(`
                        <div class="card card-transparent p f-12 m-t-lg">
                            <div class="card-content">
                                <span class="card-title p f-12">${activity.codigo_actividad} ${activity.nombre}</span>
                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down">${articulationStage.formatDate(activity.fecha_cierre)}</div>
                                <p>${activity.objetivo_general}</p>
                                <div class="input-field col m12 s12">
                                    <input type="hidden" name="projects" id="projects" style="display:none" value="${response.data.proyecto.id}"/>
                                </div>
                            </div>
                            <div class="card-action">
                                <a class="waves-effect waves-red btn-flat m-b-xs primary-text" target="_blank" href="/proyecto/detalle/${data.proyecto.id}"><i class="material-icons left">link</i>Ver más</a>
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
                                            <p class="hide-on-med-and-down"> Miembro desde ${articulationStage.formatDate(talento.user.created_at)}</p>
                                        </div>
                                        <div class="card-action">
                                            <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs primary-text" href="/usuario/usuarios/${talento.user.documento}"><i class="material-icons left">link</i>Ver más</a>
                                        </div>
                                    </div>`
                                );
                            }
                        });
                    }
                }else{
                    articulationStage.notFound('result-projects', 'projects');
                    articulationStage.notFound('result-talents', 'talent');
                }
            });
        }else{
            articulationStage.emptyResult('result-projects');
            articulationStage.emptyResult('result-talents');
            articulationStage.notFound('result-projects', 'projects');
            articulationStage.notFound('result-talents', 'talent');
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
        articulationStage.fill_code_project(code);
        articulationStage.emptyResult('result-talents');
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
            articulationStage.emptyResult('result-talents');
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
                                    Miembro desde ${articulationStage.formatDate(user.created_at)}
                                </div>
                            </div>
                            <div class="card-action">
                                <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs primary-text" href="/usuario/usuarios/`+user.documento+ `"><i class="material-icons left"> link</i>Ver más</a>
                            </div>
                        </div>
                    `);
                }else{
                    articulationStage.emptyResult('result-talents');
                    articulationStage.notFound('result-talents', 'talent');
                }
            });
        }else{
            articulationStage.emptyResult('result-talents');
            articulationStage.notFound('result-talents', 'talent')
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
        if (articulationStage.noRepeat(talent) == false) {
            articulationStage.talentAssociated();
        } else {
            articulationStage.emptyResult('talent-empty');
            articulationStage.printInterlocutorTalentoInTable(talent);
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
                articulationStage.searchUser(response.talento.documento);
            }else{
                articulationStage.emptyResult('result-talents');
                articulationStage.notFound('result-talents', 'talent')
            }
        });
    },
    messageAccompaniable: function(data, action, title) {
        if (data.status_code == 201) {
            Swal.fire({
                title: title,
                text: "La fase de articulación  ha sido "+action+" satisfactoriamente",
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
                title: 'La fase de articulación  no se ha '+action+', por favor inténtalo de nuevo',
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
                articulationStage.messageAccompaniable(response.data, 'actualizado', 'Modificación Exitosa');
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
    destroyArticulationStage: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar esta fase de articulación?',
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
                    url: host_url + "/etapa-articulaciones/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Eliminado!',
                                'La fase de articulación ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }else{
                            Swal.fire(
                                'Cuidado!',
                                'La fase de articulación no se ha eliminado, ya que continene articulaciones.',
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
    },
    changeStateArticulationStage: function(code){
        Swal.fire({
            title: '¿Estas seguro de cambiar el estado de esta fase de articulación?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, cambiar',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: `${host_url}/etapa-articulaciones/${code}/cambiar-estado`,
                    type: 'PUT',
                    data: {
                        "_token": token,
                    },
                    success: function (data){
                        console.log(data);
                        if(!data.fail){
                            Swal.fire(
                                'Actialización exitosa!',
                                'La etapa de articulación ha sido actualizada satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }else{
                            Swal.fire(
                                'Cuidado!',
                                'La etapa de articulación no se ha eliminado, ya que continene articulaciones.',
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
    },
}

$(document).on('submit', 'form#interlocutor-form', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    const form = $(this);
    const data = new FormData($(this)[0]);
    const url = form.attr("action");
    articulationStage.updateInterlocutor(form, data, url);
});





$(document).ready(function() {
    const table = $('#articulation_data_table').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar Entradas _MENU_",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        lengthMenu: [
            [5, 10, -1],
            [5, 10, 'Todos'],
        ],
        autoWidth: false,
        columnDefs: [
            {
                targets: ['_all'],
                className: 'mdc-data-table__cell',
            },
        ]
    });
});

function endorsementQuestionArticulationStage(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de aprobar el aval?',
        text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase de articulación, los documento adjuntos y las asesorias recibidas.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
    }).then((result) => {
        $('button[type="submit"]').attr('disabled', false);
        if (result.value) {
            $('#decision').val('aceptado');
            document.frmEndorsementArticulationStage.submit();
        }
    });
}

function questionRejectEndorsementArticulationStage(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Está seguro(a) de no aprobar el aval?',
        input: 'text',
        type: 'warning',
        inputValidator: (value) => {
            if (!value) {
                return 'Las observaciones deben ser obligatorias!'
            } else {
                $('#decision').val('rechazado');
                $('#motivosNoAprueba').val(value);
            }
        },
        inputAttributes: {
            maxlength: 100,
            placeHolder: '¿Por qué?'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
        if (result.value) {
            document.frmEndorsementArticulationStage.submit();
        }
    })
}
function endorsementQuestionArticulation(e) {
    e.preventDefault();
    //$('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de aprobar el aval?',
        text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase de articulación, los documento adjuntos y las asesorias recibidas.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
    }).then((result) => {
        $('button[type="submit"]').attr('disabled', false);
        if (result.value) {
            $('#decision').val('aceptado');
            document.getElementById("frmApprovalArticulations").submit();
        }
    });
}

function questionRejectEndorsementArticulation(e) {
    e.preventDefault();
    //$('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de no aprobar el aval?',
        input: 'text',
        type: 'warning',
        inputValidator: (value) => {
            if (!value) {
                return 'Las observaciones deben ser obligatorias!'
            } else {
                $('#decision').val('rechazado');
                $('#motivosNoAprueba').val(value);
            }
        },
        inputAttributes: {
            maxlength: 100,
            placeHolder: '¿Por qué?'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
        if (result.value) {
            document.getElementById("frmApprovalArticulations").submit();
        }
    })
}

function changeNextPhaseArticulation(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de continuar a la siguiente fase?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
    }).then((result) => {
        $('button[type="submit"]').attr('disabled', false);
        if (result.value) {
            document.frmChangeNextPhase.submit();
        }
    });
}

function changePreviusPhaseArticulation(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de volver a la anterior fase?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
    }).then((result) => {
        $('button[type="submit"]').attr('disabled', false);
        if (result.value) {
            document.frmChangePreviusPhase.submit();
        }
    });
}



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
                required:true,
                maxlength: 3000,
            },
            expected_results:{
                required:true,
                maxlength: 3000,
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
            }
        },
        messages:
            {
                name:
                    {
                        required:"El campo nombre es obligatorio",
                        minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                        maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                    },
                description:
                    {
                        required:"El campo descripción es obligatorio",
                        minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                        maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                    },
                expected_results:
                    {
                        required:"El campo es obligatorio",
                        minlength: jQuery.validator.format("Necesitamos por lo menos {0} caracteres"),
                        maxlength: jQuery.validator.format("Por favor ingrese no más de {0} caracteres"),
                    },
                scope:
                    {
                        required:"El campo alcalce es obligatorio",
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
                url: '/usuarios/filtro-talento/' + document
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
                                <a class="waves-effect waves-red btn-flat m-b-xs primary-text" onclick="filter_articulations.addTalentToArticulation(${user.talento.id});" class="primary-text">Agregar</a>
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
            url: '/usuario/talento/consultarTalentoPorId/' + id
        }).done(function (response) {
            let fila = filter_articulations.prepareTableRowTalent(response);
            $('.alert-response-talents').append(fila);
        });
    },
    printTalentoInTable: function(id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/usuario/talento/consultarTalentoPorId/' + id
        }).done(function (response) {
            let fila = filter_articulations.prepareTableRowTalent(response);
            $('.alert-response-talents').append(fila);
        });
    },
    prepareTableRowTalent: function(response) {
        let data = response;
        let fila =`<div class="row card-talent`+data.talento.user_id+`">
                        <div class="col s12 m12 l12">
                            <div class="card card-panel server-card">
                                <div class="card-content">
                                    <span class="card-title">${data.talento.documento} - ${data.talento.talento}</span>
                                    <input type="hidden" id="talents" name="talents[]" value="${data.talento.user_id}"/>
                                </div>
                                <div class="card-action">
                                    <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs primary-text" href="/usuario/usuarios/${data.talento.documento}"><i class="material-icons left"> link</i>Ver más</a>
                                    <a onclick="filter_articulations.deleteTalent( ${data.talento.user_id});" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
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

$(document).ready(function() {
    let filter_state_type_art = $('#filter_state_type_art').val();
    if(filter_state_type_art == '' || filter_state_type_art == null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art = null);
    }else if(filter_state_type_art != '' || filter_state_type_art != null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art);
    }else{
        $('#type_art_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }

});

$('#filter_type_art').click(function () {
    let filter_state_type_art = $('#filter_state_type_art').val();
    $('#type_art_data_table').dataTable().fnDestroy();
    if(filter_state_type_art == '' || filter_state_type_art == null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art = null);
    }else if(filter_state_type_art != '' || filter_state_type_art != null){
        typeArticulacion.fillDatatatablesTypeArt(filter_state_type_art);
    }else{
        $('#type_art_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

let typeArticulacion ={
    fillDatatatablesTypeArt: function(filter_state_type_art = null){
        $('#type_art_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/tipoarticulaciones",
                type: "get",

                data: {
                    filter_state_type_art: filter_state_type_art,
                }
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'description',
                    name: 'descripcion',
                },
                {
                    data: 'state',
                    name: 'state',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    destroyTypeArticulation: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este tipo de articulación?',
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
                $.ajax(
                {
                    url: host_url + "/tipoarticulaciones/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Eliminado!',
                                'El tipo de articulación ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }else{
                            Swal.fire(
                                'No se puede eliminar!',
                                'El tipo de articulación tiene asociadas tipos de subarticulaciones.',
                                'error'
                            );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El tipo de articulación está a salvo',
                    'error'
                )
            }
        })
    }
}

$('#check-all-nodes').click(function() {
    if ($(this).prop('checked')) {
        $('.filled-in-node').prop('checked', true);
    } else {
        $('.filled-in-node').prop('checked', false);
    }
});

$("#formTypeArticulation").on('submit', function(e){
    e.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            $('.error').hide();
        },
        success: function(response){
            $('.error').hide();
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
        error: function (ajaxContext) {
            Swal.fire({
                title: 'Error, vuelve a intentarlo',
                html: ajaxContext.status + ' - ' + ajaxContext.responseJSON.message,
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
            });
        }
    });
});

$(document).ready(function() {
    let filter_node_artuculation_subtype = $('#filter_node_artuculation_subtype').val();
    let filter_state_artuculation_subtype = $('#filter_state_artuculation_subtype').val();

    if((filter_node_artuculation_subtype == '' || filter_node_artuculation_subtype == null)  &&  (filter_state_artuculation_subtype == '' || filter_state_artuculation_subtype == null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype = null, filter_state_artuculation_subtype = null);
    }else if((filter_node_artuculation_subtype != '' || filter_node_artuculation_subtype != null)  && (filter_state_artuculation_subtype != '' || filter_state_artuculation_subtype != null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype,  filter_state_artuculation_subtype);
    }else{

        $('#articulation_subtype_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});



$('#filter_articulation_subtype').click(function () {
    let filter_node_artuculation_subtype = $('#filter_node_artuculation_subtype').val();
    let filter_state_artuculation_subtype = $('#filter_state_artuculation_subtype').val();

    $('#articulation_subtype_data_table').dataTable().fnDestroy();
    if((filter_node_artuculation_subtype == '' || filter_node_artuculation_subtype == null)  &&  (filter_state_artuculation_subtype == '' || filter_state_artuculation_subtype == null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype = null, filter_state_artuculation_subtype = null);
    }else if((filter_node_artuculation_subtype != '' || filter_node_artuculation_subtype != null)  && (filter_state_artuculation_subtype != '' || filter_state_artuculation_subtype != null)){
        articulationSubtype.fillDatatatablesArticulationSubtype(filter_node_artuculation_subtype,  filter_state_artuculation_subtype);
    }else{

        $('#articulation_subtype_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

let articulationSubtype ={
    fillDatatatablesArticulationSubtype: function(filter_node_artuculation_subtype = null,filter_state_artuculation_subtype = null){
        $('#articulation_subtype_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false,
            processing: false,
            serverSide: false,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/tiposubarticulaciones",
                type: "get",
                data: {
                    filter_node_artuculation_subtype: filter_node_artuculation_subtype,
                    filter_state_artuculation_subtype: filter_state_artuculation_subtype
                }
            },
            columns: [
                {
                    data: 'articulation_subtype_created_at',
                    name: 'articulation_subtype_created_at'
                },
                {
                    data: 'articulation_type_name',
                    name: 'articulation_type_name'
                },
                {
                    data: 'articulation_subtype_name',
                    name: 'articulation_subtype_name'
                },
                {
                    data: 'articulation_subtype_description',
                    name: 'articulation_subtype_description'
                },
                {
                    data: 'articulation_subtype_entity',
                    name: 'articulation_subtype_entity'
                },
                {
                    data: 'articulation_subtype_state',
                    name: 'articulation_subtype_state'
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    destroyArticulationSubtype: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este tipo de subarticulación?',
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
                $.ajax(
                    {
                        url: host_url + "/tiposubarticulaciones/"+id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (data){
                            if(!data.fail){
                                Swal.fire(
                                    'Eliminado!',
                                    'El tipo de articulación ha sido eliminado satisfactoriamente.',
                                    'success'
                                );
                                location.href = data.redirect_url;
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            alert("Error: " + errorThrown);
                        }
                    });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El tipo de articulación está a salvo',
                    'error'
                )
            }
        })
    },
}

$("#formArticualtionSubtype").on('submit', function(e){
    e.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            $('.error').hide();
        },
        success: function(response){
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
        error: function (ajaxContext) {
            Swal.fire({
                title: ' Registro erróneo, vuelve a intentarlo',
                html: ajaxContext.status + ' - ' + ajaxContext.responseJSON.message,
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
            });
        }
    });
});

function isset(variable) {
  if(typeof(variable) != "undefined" && variable !== null) {
    return true;
  }
  return false;
}

function sendListNodos(url, input) {
  let nodosSend = input;
  return $.ajax({
    dataType: 'json',
    type: 'get',
    data: {
      nodos: nodosSend
    },
    url: url,
    // success: function (data) { },
    error: function (xhr, textStatus, errorThrown) {
      alert("Error: " + errorThrown);
    },
  });
};

function consultarSeguimientoDeUnNodoFases(e, url) {
  e.preventDefault();
  input = $("#txtnodo_select_actual").val();
  if (!validarSelect(input)) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
    let ajax = sendListNodos(url, input);
      ajax.success(function (data) {
        graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
      });
  }
};

function consultarSeguimientoEsperado(e, url) {
  e.preventDefault();
  input = $("#txtnodo_select_list").val();
  if (!validarSelect(input)) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
    let ajax = sendListNodos(url, input);
      ajax.success(function (data) {
        graficoSeguimientoEsperado(data, graficosSeguimiento.nodo_esperado);
      });
  }
}

function generarExcelConTodosLosIndicadores() {
  let idnodo = $('#txtnodo_id').val();
  let hoja = $('#txthoja_nombre').val();
  let fecha_inicio = $('#txtfecha_inicio_todos').val();
  let fecha_fin = $('#txtfecha_fin_todos').val();

  if (!isset(idnodo)) {
    idnodo = 0;
  }
  if (!isset(hoja)) {
    hoja = 'all';
  }

  if (fecha_inicio > fecha_fin) {
    Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
  } else {
    location.href = '/excel/export/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+hoja;
  }
}

function generarExcelConTodosLosIndicadoresActuales() {
  let idnodo = $('#txtnodo_id_actuales').val();
  let hoja = $('#txthoja_nombre_actuales').val();
  if (!isset(idnodo)) {
    idnodo = 0;
  }
  if (!isset(hoja)) {
    hoja = 'all';
  }

  location.href = '/excel/export_proyectos_actuales/'+idnodo+'/'+hoja;
}

function generarExcelConTodosLosIndicadoresFinalizados() {
  let idnodo = $('#txtnodo_id_finalizados').val();
  let hoja = $('#txthoja_nombre_finalizados').val();
  let fecha_inicio = $('#txtfecha_inicio_cerrados').val();
  let fecha_fin = $('#txtfecha_fin_cerrados').val();

  if (!isset(idnodo)) {
  idnodo = 0;
  }
  if (!isset(hoja)) {
  hoja = 'all';
  }

  if (fecha_inicio > fecha_fin) {
    Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
  } else {
    location.href = '/excel/export_proyectos_finalizados/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+hoja;
  }
}

function generarExcelConTodosLosIndicadoresInscritos() {
  let idnodo = $('#txtnodo_id_inscritos').val();
  let hoja = $('#txthoja_nombre_inscritos').val();
  let fecha_inicio = $('#txtfecha_inicio_inscritos').val();
  let fecha_fin = $('#txtfecha_fin_inscritos').val();
  if (!isset(idnodo)) {
    idnodo = 0;
  }
  if (!isset(hoja)) {
    hoja = 'all';
  }

  if (fecha_inicio > fecha_fin) {
    Swal.fire('Error!', 'Seleccione un rango de fechas válido', 'error');
  } else {
    location.href = '/excel/export_proyectos_inscritos/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin+'/'+hoja;
  }

}

function selectAll(source, elementaName) {
  checkboxes = document.getElementsByClassName(elementaName);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function downloadMetas(e) {
  e.preventDefault();
  input = $("#txtnodo_metas_id").val();
  if (!validarSelect(input)) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
      // location.href = route + '/' + input;
      document.frmDescargarMetas.submit();
  }
}

function validarSelect(input) {
  // input = $(input).val();
  if (input == null) {
    return false;
  }
  return true;
}

function verificarChecks(source, padre) {
  clase = source.classList[0];
  checkboxes = document.getElementsByClassName(clase);
  padre = document.getElementById(padre);
  state = false;
  for(var i=0, n= checkboxes.length; i< n;i++) {
    if (checkboxes[i].checked) {
      state = true;
      break;
    }
  }
  for(var i=0, n= checkboxes.length; i< n;i++) {
    if (!checkboxes[i].checked) {
      state = false;
      break;
    }
  }
  padre.checked = state;
}

function validarChecks(elementaName) {
  checkboxes = document.getElementsByClassName(elementaName);
  for(var i=0, n=checkboxes.length;i<n;i++) {
      if (checkboxes[i].checked == false) {
        return false;
      }
    }
    return true;
}

function downloadIdeasIndicadores(e) {
  e.preventDefault();
  input = $("#txtnodo_ideas_download").val();
  if (!validarSelect(input)) {
      Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
      return false;
  } else {
      document.frmDescargarIdeas.submit();
  }
}
$('#txtcontenido').summernote({
  lang: 'es-ES',
  height: 300
});

$('#txtfecha_inicio').bootstrapMaterialDatePicker({
  time:false,
  date:true,
  shortTime:true,
  format: 'YYYY-MM-DD',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});

$('#txtfecha_fin').bootstrapMaterialDatePicker({
  time:false,
  date:true,
  shortTime:true,
  format: 'YYYY-MM-DD',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});


    $("#formSupport").on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let data = new FormData($(this)[0]);
        let url = form.attr("action");
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.error').hide();
                $('#formSupport').css("opacity",".5");
            },
            success: function(response){
                $('.error').hide();
                printErrorsForm(response);
                if(!response.fail && response.errors == null){
                    Swal.fire({
                        title: 'Registro Exitoso',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                    // $('#formSupport')[0].reset();
                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 1500);
                }
            },
            error: function (ajaxContext) {
                Swal.fire({
                    title: ' Registro erróneo, vuelve a intentarlo',
                    html: ajaxContext.status + ' - ' + ajaxContext.responseJSON.message,
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });
            }
        });
    });


$(document).ready(function() {
    let filter_year_support = $('#filter_year_support').val();
    let filter_state_support = $('#filter_state_support').val();
    let filter_request_support = $('#filter_request_support').val();

    if((filter_year_support == '' || filter_year_support == null) && (filter_state_support == '' || filter_state_support == null) && (filter_request_support == '' || filter_request_support == null)){
        support.fill_datatatables_actions_support(filter_year_support = null, filter_state_support= null, filter_request_support = null);
    }else if( (filter_year_support !='' || filter_year_support != null) && (filter_state_support != '' || filter_state_support != null) && (filter_request_support != '' || filter_request_support != null)){
        support.fill_datatatables_actions_support( filter_year_support, filter_state_support, filter_request_support);
    }else{
        $('#support_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

$('#filter_support').click(function () {
    let filter_year_support = $('#filter_year_support').val();
    let filter_state_support = $('#filter_state_support').val();
    let filter_request_support = $('#filter_request_support').val();
    $('#support_data_table').dataTable().fnDestroy();
    if((filter_year_support =='' || filter_year_support == null) && (filter_state_support == '' || filter_state_support == null) && (filter_request_support == '' || filter_request_support == null)){
        support.fill_datatatables_actions_support(filter_year_support = null, filter_state_support= null, filter_request_support = null);
        // idea.fill_datatatables_ideas(filter_year_support, filter_state_support, filter_request_support);
    }else if( (filter_year_support !='' || filter_year_support != null) && (filter_state_support != '' || filter_state_support != null) && (filter_request_support != '' || filter_request_support != null)){
        support.fill_datatatables_actions_support( filter_year_support, filter_state_support, filter_request_support);
        // idea.fill_datatatables_ideas( filter_year_support, filter_state_support, filter_request_support);
    }else{
        // $('#ideas_data_action_table').DataTable({
        //     language: {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        //     },
        //     pageLength: 20,
        //     "lengthChange": false
        // }).clear().draw();
        $('#support_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "lengthChange": false
        }).clear().draw();
    }
});

let support ={
    fill_datatatables_actions_support: function(filter_year_support = null,filter_state_support=null, filter_request_support=null){
        let datatable = $('#support_data_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            pageLength: 20,
            "lengthChange": false,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            ajax:{
                url: host_url + "/support",
                type: "get",
                data: {
                    filter_year_support: filter_year_support,
                    filter_state_support: filter_state_support,
                    filter_request_support: filter_request_support,
                }
            },
            columns: [
                {
                    data: 'ticket',
                    name: 'ticket',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'subject',
                    name: 'subject',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'show',
                    name: 'show',
                    orderable: false
                },
            ],
        });
    },
    destroySupport: function(ticket){
        Swal.fire({
            title: '¿Estas seguro de eliminar este caso?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminar caso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/support/"+ticket,
                    type: 'DELETE',
                    data: {
                        "id": ticket,
                        "_token": token,
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Eliminado!',
                                'El caso ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El caso está a salvo',
                    'error'
                )
            }
        })
    },
    updateSupport: function(ticket, status){
        Swal.fire({
            title: '¿Estas seguro de cambiar a '+ status + ' este caso?',
            // text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, cambiar caso',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: host_url + "/support/"+ticket,
                    type: 'PUT',
                    data: {
                        "id": ticket,
                        "_token": token,
                        "status": status
                    },
                    success: function (data){
                        if(!data.fail){
                            Swal.fire(
                                'Actualizado!',
                                'El caso ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = data.redirect_url;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Error: " + errorThrown);
                    }
                });

            }else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El caso está a salvo',
                    'error'
                )
            }
        })
    }
}
