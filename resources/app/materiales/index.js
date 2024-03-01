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
                    width: '15%'
                },
                {
                    data: 'nombrelinea',
                    name: 'nombrelinea',
                    width: '15%'
                },{
                    data: 'codigo_material',
                    name: 'codigo_material',
                    width: '20%'
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
                    data: 'estado_material',
                    name: 'estado_material',
                    width: '15%'
                },
                {
                    data: 'detail',
                    name: 'detail',
                    width: '15%'
                },
                {
                    data: 'changeStatus',
                    name: 'changeStatus',
                    width: '15%'
                },  ],
            });
        }
        
    },

    changeStatus: function(id){
        Swal.fire({
            title: '¿Estas seguro de cambiar el estado a este material?',
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
                    url: host_url + `/materiales/cambiar-estado/${id}`,
                    type: 'GET',
                    success: function (response){
                        if(response.statusCode == 200){
                            Swal.fire(
                                'Estado cambiado!',
                                'El material ha cambiado de estado.',
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
                    'Tu material está a salvo',
                    'error'
                )
            }
        })
    },
}