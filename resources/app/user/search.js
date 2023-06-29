//Enviar formulario
$(document).on('submit', 'form#formSearchUser', function (event) {
    event.preventDefault();
    $('#response-alert').empty();
    let type = $('#txttype_search').val();
    let search = $('#txtsearch_user').val();
    let patronDocumento=new RegExp('^[0-9]{6,11}$');
    let patronEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(type == ''){
        Swal.fire(
            'Error',
            'Por favor selecciona una opción',
            'error'
        );
    }else if(type == 1 && (search == null || search == '' || !patronDocumento.test(search))){
        Swal.fire(
            'Error',
            'Por favor ingrese un número de documento válido',
            'error'
        );
    }else if(type == 2 && (search == null || search == '' || !patronEmail.test(search))){
        Swal.fire(
            'Error',
            'Por favor ingrese un correo electrónico válido',
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
const userSearch = {
    state: function (state){
        if(state){
            return 'Si';
        }else{
            return 'No';
        }
    },
    userCreated: function (date){
        if(date == null){
            return "no registra";
        }else{
            return moment(date).format('LL');
        }
    },
    changetextLabel: function(){
        let option = $('#txttype_search').val();
        $("#txtsearch_user").val('');
        if(option == 1){
            $("label[for='txtsearch_user']").text('Número de documento');
        }else if(option == 2){
            $("label[for='txtsearch_user']").text('Correo Electrónico');
        }
    }
}
