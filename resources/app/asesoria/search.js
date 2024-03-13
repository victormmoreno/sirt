//Enviar formulario
$(document).on('submit', 'form#formSearchAsesorie', function (event) {
    event.preventDefault();
    $('#response-alert').empty();
    if(!validar("#type_search")){
        Swal.fire(
            'Error',
            'Por favor selecciona una opción',
            'error'
        );
    }else if(!validar("#search_asesorie")){
        Swal.fire(
            'Error',
            'Por favor ingrese un código válido',
            'error'
        );
    }else{
        let form = $(this);
        let data = new FormData($(this)[0]);
        let url = form.attr("action");
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                $('button[type="submit"]').removeAttr('disabled');
                $('.error').hide();
                $('#response-alert').empty();
                if (response.fail) {
                    Swal.fire({
                        title: 'Registro Erróneo',
                        html: "Estas ingresando mal los datos. ",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
                if (response.asesories.length == 0) {
                    $('#response-alert').append(`
                        <div class="mailbox-list">
                            <ul>
                                <li>
                                    <a class="mail-active">
                                        <h4 class="center-align">no se encontraron resultados</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>`);
                }else{
                    if(response.status == 200){
                        $('#response-alert').append(`
                            <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                <div class="col s12 m6 l6 left-align search-stats">


                                        <span class="m-r-sm text-mailbox">${response.message}</span>


                                </div>
                                <div class="col s12 m6 l6 right-align search-stats">
                                    <span class="m-r-sm">Resultados</span>
                                    <span class="secondary-stats"></span>
                                </div>
                            </div>`);
                        $.each( response.asesories, function( key, asesorie ) {
                            let route = response.urls[key];
                            $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a href="`+route+`" class="mail-active">
                                            <h5 class="mail-author">`+asesorie.codigo+` - `+asesorie.nombre+`</h5>
                                            <p class="hide-on-small-and-down mail-text"> `+asesorie.fecha+`</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>`);
                        });
                    }
                }
            }
        });
    }
});

const validar = ( selector, num = 4 ) => {
    if ( typeof selector !== "string" )
      return false;

    let text = document.querySelector( selector );
    if ( text === null )
      return false;

    if ( ! (text.value.trim().length < num) )
      return true;

    return false;
};

const asesorieSearch = {
    changetextLabel: function(){
        let option = $('#type_search').val();
        $("#search_asesorie").val('');
        if(option == 'UsoInfraestructura'){
            $("label[for='search_asesorie']").text('Ingrese código de asesoria');
        }else if(option == 'Proyecto'){
            $("label[for='search_asesorie']").text('Ingrese código de proyecto');
        }else if(option == 'Articulation'){
            $("label[for='search_asesorie']").text('Ingrese código de la articulación');
        }else if(option == 'Idea'){
            $("label[for='search_asesorie']").text('Ingrese código de la Idea');
        }
    }
}
