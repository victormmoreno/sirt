@push('script')
    <script>
        $(document).on('submit', 'form#formSearchIdeas', function (event) {
        event.preventDefault();
        $('#resultados_ideas').empty();
        let type = $('#txttype_search').val();
        let search = $('#txtidea_search').val();
        // let patronDocumento = new RegExp('^{5,11}$');
        console.log(search);
        if(type == null){
            Swal.fire(
                'Error',
                'Por favor selecciona una opción',
                'error'
            );
        }else if(search == '') {
            Swal.fire(
                'Error',
                'Por favor ingrese un criterio de búsqueda válido',
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
                success: function (data) {
                    if (data.ideas.length == 0) {
                        $('#resultados_ideas').append(`
                            <div class="row">
                                <ul class="collection with-header">
                                    <li class="collection-header"><h5>No se encontraron ideas</h5></li>
                                </ul>
                            </div>
                        `);
                    } else {
                        if (data.state == 'search') {
                            $('#resultados_ideas').append(`<div class="row">`);
                                $.each( data.ideas, function( key, idea ) {
                                let route = data.urls[key];
                                $('#resultados_ideas').append(`
                                    <ul class="collection">
                                        <li class="collection-item"><h5>`+idea.codigo_idea+` - `+idea.nombre_proyecto+`</h5></li>
                                        <li class="collection-item"><a href=`+route+`>Ver detalles</a></li>
                                    </ul>
                                `);
                            });
                            $('#resultados_ideas').append(`</div>`);
                        }
                    }
                    $('button[type="submit"]').removeAttr('disabled');
                    $('button[type="submit"]').prop("disabled", false);
                },
            });
        }
    });
    </script>
@endpush