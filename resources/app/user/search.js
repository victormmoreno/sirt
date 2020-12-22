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
        var form = $(this);
        let data = new FormData($(this)[0]);
        var url = form.attr("action");
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                $('button[type="submit"]').removeAttr('disabled');
                $('.error').hide();
                $('#response-alert').empty();

                if (data.fail) {
                    Swal.fire({
                        title: 'Registro Erróneo',
                        html: "Estas ingresando mal los datos. " + errores,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }

                if(data.status == 202){
                    if(type == 1){
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a class="grey-text text-darken-3 green accent-1 center-align" href="`+data.url+`">Registrar nuevo usuario</a>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }else{
                        $('#response-alert').append(`
                            <div class="mailbox-list">
                                <ul>
                                    <li>
                                        <a class="mail-active">
                                            <h4 class="center-align">no se encontraron resultados</h4>
                                            <a target="_blank" class="grey-text text-darken-3 green accent-1 center-align" href="`+data.url+`">Registrar nuevo usuario</a>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `);
                    }
                    
                }else if(data.status == 200){
                    $('#response-alert').append(`
                    <div class="mailbox-list">
                        <ul>
                            <li >
                                <a href="`+data.url+`" class="mail-active">

                                    <h5 class="mail-author">`+data.user.documento+` - `+data.user.nombres +` `+ data.user.apellidos+`</h5>
                                    <h4 class="mail-title">`+data.roles+`</h4>
                                    <p class="hide-on-small-and-down mail-text">Miembro desde `+userSearch.userCreated(data.user.created_at)+`</p>
                                    <div class="position-top-right p f-12 mail-date"> Acceso al sistema: `+ userSearch.state(data.user.estado) +`</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    `);
                }
            }
        });
    }
});
var userSearch = {
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
