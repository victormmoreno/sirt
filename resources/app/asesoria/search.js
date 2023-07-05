//Enviar formulario
$(document).on('submit', 'form#formSearchAsesorie', function (event) {
    event.preventDefault();
    $('#response-alert').empty();
    let type = $('#type_search').val();
    let search = $('#search_asesorie').val();
    let patronDocumento=new RegExp('^[0-9]{6,11}$');

    if(type == ''){
        Swal.fire(
            'Error',
            'Por favor selecciona una opción',
            'error'
        );
    }else if(type == 'code_asesorie' && (search == null || search == '')){
        Swal.fire(
            'Error',
            'Por favor ingrese un número de documento válido',
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
                        html: "Estas ingresando mal los datos. " + errores,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
                if (response.users.length == 0) {
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
                        $.each( response.users, function( key, user ) {
                            let route = response.urls[key];
                            $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a href="`+route+`" class="mail-active">
                                            <h5 class="mail-author">`+user.documento+` - `+user.nombres +` `+ user.apellidos+`</h5>
                                            <p class="hide-on-small-and-down mail-text">Miembro desde `+userSearch.userCreated(user.created_at)+`</p>
                                            <div class="position-top-right p f-12 mail-date"> Acceso al sistema: `+ userSearch.state(user.estado) +`</div>
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

const asesorieSearch = {
    changetextLabel: function(){
        let option = $('#type_search').val();
        console.log(option);
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
