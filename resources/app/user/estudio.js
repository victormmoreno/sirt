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