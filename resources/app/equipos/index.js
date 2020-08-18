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
                url: "/equipos",
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
                url: "/equipos",
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
                {
                    data: 'delete',
                    name: 'delete',
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
            url:`/equipos/${id}`
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
                            <span class="black-text">$ ${response.data.depreciacion}</span>
                        </div>
                    </div>
                    `);
                $('.modal-equipo').openModal();
            }
        })
    },
    deleteEquipo: function(id){
        Swal.fire({
            title: '¿Estas seguro de eliminar este equipo?',
            text: "Recuerde que si lo elimina no lo podrá recuperar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, elminar equipo',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: `/equipos/${id}`,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (response){
                        if(response.statusCode == 200){
                            Swal.fire(
                                'Eliminado!',
                                'El equipo ha sido eliminado satisfactoriamente.',
                                'success'
                            );
                            location.href = response.route;
                        }else if(response.statusCode == 226){
                            Swal.fire(
                                'No se puede elimnar!',
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
    changeState: function(id){
        Swal.fire({
            title: '¿Estas seguro de cambiar el estado a  este equipo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, cambiar estado',
            cancelButtonText: 'No, cancelar',
          }).then((result) => {
            if (result.value) {

                $.ajax(
                {
                    url: `/equipos/cambiar-estado/${id}`,
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

    var url = "/equipos/export?" + $.param(query)
    window.location = url;
});
