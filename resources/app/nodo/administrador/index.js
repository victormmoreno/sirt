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

// function eliminarNodoPorId(id, e) {
//     Swal.fire({
//         title: '¿Desea eliminar el nodo?',
//         text: "Al hacer esto, todo lo relacionado con este proyecto será eliminado de la base de datos, eso incluye usos de infraestructura y los archivos subidos al servidor!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#d33',
//         cancelButtonColor: '#3085d6',
//         cancelButtonText: 'No',
//         confirmButtonText: 'Sí, eliminar!'
//     }).then((result) => {
//         if (result.value) {
//             eliminarNodoId_moment(id);
//         }
//     })
// };

// function eliminarNodoId_moment(id) {

//     $.ajax({
//         dataType: "JSON",
//         type: 'POST',
//         data: {
//             '_token': $('meta[name=csrf-token]').attr("content"),
//             '_method': 'DELETE',
//             "id": id
//         },
//         success: function(data) {
//             // if (data.retorno) {
//             //     Swal.fire('Eliminación Exitosa!', 'El proyecto se ha eliminado completamente!', 'success');
//             //     location.href = '/nodo';
//             // } else {
//             //     Swal.fire('Eliminación Errónea!', 'El proyecto no se ha eliminado!', 'error');
//             // }
//         },
//         error: function(xhr, textStatus, errorThrown) {
//             alert("Error: " + errorThrown);
//         },
//     });
// }
