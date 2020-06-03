const deconvocatoria = 1;
const noconvocatoria = 0;
var idea ={
    getSelectConvocatoria: function (){
        let convocatoria = $('#txtconvocatoria').val();
        $('#txtnombreconvocatoria').attr("disabled", "disabled");
        if(convocatoria == deconvocatoria){
            $('#txtnombreconvocatoria').removeAttr("disabled").focus().val('');
        }else if(convocatoria == noconvocatoria){
            $('#txtnombreconvocatoria').val('');
            $('#txtnombreconvocatoria').attr("disabled", "disabled");
        }else{
            $('#txtnombreconvocatoria').val('');
            $('#txtnombreconvocatoria').attr("disabled", "disabled");
        }
    }
}