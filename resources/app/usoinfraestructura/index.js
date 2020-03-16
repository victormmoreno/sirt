$(document).ready(function() {

    $('#usoinfraestructura_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
    });

    
    
});

var usoinfraestructuraIndex = {
    selectProyectListDatatables: function (){
        let proyecto = $('#selecProyecto').val();
        $('#usoinfraestructura_table').dataTable().fnDestroy();
        if (proyecto != '') {
            $('#usoinfraestructura_table').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                ajax: {
                    url: "/usoinfraestructura/projectsforuser/" + proyecto,
                    type: "get",
                },
                columns: [{
                            data: 'fecha',
                            name: 'fecha',
                        },  {
                            data: 'actividad',
                            name: 'actividad',
                        }, {
                            data: 'fase',
                            name: 'fase',
                        },
                        {
                            data: 'asesoria_directa',
                            name: 'asesoria_directa',
                        }, {
                            data: 'asesoria_indirecta',
                            name: 'asesoria_indirecta',
                        },{
                            data: 'detail',
                            name: 'detail',
                            orderable: false,
                        },],    
                });
            }else{
                $('#usoinfraestructura_table').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "lengthChange": false
                }).clear().draw();
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
                confirmButtonText: 'si, elminar uso',
                cancelButtonText: 'No, cancelar',
              }).then((result) => {
                if (result.value) {

                    let token = $("meta[name='csrf-token']").attr("content");
                    $.ajax(
                    {
                        url: "/usoinfraestructura/"+id,
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
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    )
                  }
              })
                
          
        }
}