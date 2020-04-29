$(document).ready(function() {
    $('#materiales_gestor_table').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/materiales",
            type: "get",
        },
        columns: [{
            data: 'fecha',
            name: 'fecha',
            width: '20%'
        },  {
            data: 'codigo_material',
            name: 'codigo_material',
            width: '30%'
        }, {
            data: 'nombre',
            name: 'nombre',
            width: '30%'
        }, {
            data: 'presentacion',
            name: 'presentacion',
            width: '15%'
        }, {
            data: 'medida',
            name: 'medida',
            width: '15%'
        }, {
            data: 'cantidad',
            name: 'cantidad',
            width: '15%'
        }, {
            data: 'valor_unitario',
            name: 'valor_unitario',
            width: '15%'
        }, {
            data: 'valor_compra',
            name: 'valor_compra',
            width: '15%'
        }, {
            data: 'detail',
            name: 'detail',
            width: '15%'
        },
         ],
    });
});

function getSelectMaterialMedida(){
    let medida = $('#txtmedida option:selected').text();
    let id_medida = $('#txtmedida').val();
    $("#txtcantidad").prop('disabled', true);
    $("label[for='txtcantidad']").empty();
     if(id_medida != ''){
        $('#txtmedida').val('');
        $("#txtcantidad").prop('disabled', false);
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete en '+medida);
    }
    else{
        $('#txtmedida').val('');
        $("#txtcantidad").prop('disabled', true);
        $("label[for='txtcantidad']").text('Tamaño presentacion o venta/paquete');
    }
}
