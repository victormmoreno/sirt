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
            data: 'nombre_estado',
            name: 'estado',
        },{
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

const nodo = {
    changeStatus: function(id){
        Swal.fire({
            title: '¿Estas seguro de cambiar el estado a este nodo?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar estado',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {
                $.ajax(
                {
                    url: host_url + `/nodo/cambiar-estado/${id}`,
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
                    'error'
                )
            }
        })
    }
}

