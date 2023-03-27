@push('script')
<script>
    @can('showDahsboardExperto', Illuminate\Database\Eloquent\Model::class)
        @if($ideas_sin_pbt > 0)
            consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', '{{request()->user()->id}}');
        @endif
    @endcan
    @can('showDahsboardDinamizador', Illuminate\Database\Eloquent\Model::class)
        @if($ideas_sin_pbt > 0)
            consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', null);
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
                strings += '<li class="collection-item">'
                    +'<div class="row"><b class="title green-text">Idea</b>'
                    +'<p>'+item.codigo_idea+' - '+item.nombre_proyecto+'</p></div>'
                    +'<div class="row"><div class="col s12 m6 l6"><b class="title green-text">Talento</b>'
                    +'<p>'+item.nombres_talento+'</p></div>'
                    +'<div class="col s12 m6 l6"><b class="title green-text">Experto</b>'
                    +'<p>'+item.experto+'</p></div></div>'
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