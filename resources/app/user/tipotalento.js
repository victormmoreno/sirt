
$(document).ready(function() {
    tipoTalento.getSelectTipoTalento();
});

var tipoTalento = {
    getSelectTipoTalento:function (tipotal) {


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
}

