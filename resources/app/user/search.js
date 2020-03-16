var userSearch = {
    queryUserByDocumento:function () {
        var inputSearch = $("#search_user").val();
        var patron=new RegExp('^[0-9]{6,11}$')

        if (inputSearch == null || inputSearch == '' || !patron.test(inputSearch)){
            Swal.fire(
                'Error',
                'Por favor ingrese un número de documento válido',
                'error'
              );
        }else{
            $.ajax({
                type: 'GET',
                url: '/usuario/usuarios/consultarusuariopordocumento/'+ inputSearch,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function (data) {
                    userSearch.responseAlertHtml(data, inputSearch);
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        }


    },
    responseAlertHtml:function (response, inputSearch){
        $('#response-alert').empty();
        if(response.message == 'error'){
            $('#response-alert').append(`
            <div class="mailbox-list">
                <ul>
                    <li >
                        <a  class="mail-active">

                            <h4 class="center-align">no se encontraron resultados</h4>

                            <a class="grey-text text-darken-3 green accent-1 center-align" href="`+response.url+`/`+inputSearch+`">Registrar nuevo usuario</a>



                        </a>
                    </li>
                </ul>
            </div>
            `);
        }else if(response.message == 'success'){
            $('#response-alert').append(`
            <div class="mailbox-list">
                <ul>
                    <li >
                        <a href="`+response.url+`" class="mail-active">

                            <h5 class="mail-author">`+response.data.user.documento+` - `+response.data.user.nombres +` `+ response.data.user.apellidos+`</h5>
                            <h4 class="mail-title">`+response.data.roles+`</h4>
                            <p class="hide-on-small-and-down mail-text">Miembro desde `+moment(response.data.user.created_at).format('LL')+`</p>
                            <div class="position-top-right p f-12 mail-date"> Acceso al sistema: `+ userSearch.state(response.data.user.estado) +`</div>
                        </a>
                    </li>
                </ul>
            </div>
            `);
        }

    },
    responseSweetAlert: function (response){
        if(response.message == 'success'){

            Swal.fire({
                title: 'Usuario Registrado',
                html: '<strong>El Usuario '+response.data.user.nombres+ ' ' +response.data.user.apellidos+'</u> ya existe en nuestros registros</strong>',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Editar información usuario',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.value) {
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                }
              })
        }else{
            $('.search-users').hide();
            Swal.fire({
                title: '<strong>No se encontraron resultados</strong>',
                icon: 'info',
                html:
                    'You can use <b>bold text</b>, ' +
                    '<a href="//sweetalert2.github.io">links</a> ' +
                    'and other HTML tags',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Great!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText:
                    '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            });
        }

    },
    state: function (state){
        if(state){
            return 'Si';
        }else{
            return 'No';
        }
    }
}
