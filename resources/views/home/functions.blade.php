@push('script')
<script>
    @can('showAlertsForExperto', Illuminate\Database\Eloquent\Model::class)
        @if($ideas_sin_pbt > 0)
            consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', '{{request()->user()->id}}');
        @endif
    @endcan
    function consultarIdeasPendientes(nodo, user) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/idea/sin-registro/"+nodo+"/"+user,
        success: function (response) {
            let strings = "";
        $("#ideasSinProyecto_body").empty();
        $("#ideasSinProyecto_titulo").empty();
        $("#ideasSinProyecto_titulo").append("<span class='cyan-text text-darken-3'>Ideas sin registrar como proyecto</span>");
        strings = '<ul class="collection">';
            $.each(response.data.ideas, function(i, item) {
                console.log(item);
                strings += '<li class="collection-item">'
                    +'<b class="title green-text">Idea</b>'
                    +'<p>'+item.codigo_idea+' - '+item.nombre_proyecto+'</p>'
                    +'<span class="title">Talento</span>'
                    +'<p>'+item.nombres_talento+'</p>'
                    +'<span class="title">Experto</span>'
                    +'<p>'+item.experto+'</p>'
                +'</li>';
            });
        strings += '</ul>';
        $('#ideasSinProyecto_body').append(strings);
        $('#ideasSinProyecto_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
        }
    })
    }
</script>
@endpush