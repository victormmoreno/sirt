$(document).ready(function() {
    //var groupColumn = 0;
    var table = $('#articulation_data_table').DataTable({
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
    //$('button[type="submit"]').attr('disabled', true);
    Swal.fire({
        title: '¿Está seguro(a) de aprobar el aval?',
        text: 'Al hacerlo estás aceptando y aprobando toda la información de esta etapa de articulación, los documento adjuntos y las asesorias recibidas.',
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
            document.frmEndorsementArticulationStage.submit();
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


