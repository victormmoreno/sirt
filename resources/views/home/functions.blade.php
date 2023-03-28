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
            if (response.data.ideas.length == 0) {
                strings += '<li class="collection-item">'
                        +'<div class="row"><b class="title green-text">No hay ideas sin registrar como proyecto</b>'
                    +'</li>';
            } else {
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
            }
            strings += '</ul>';
            $('#ideasSinProyecto_body').append(strings);
            $('#ideasSinProyecto_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
        }
    })
    }
    function consultarProyectosInicio(nodo, user) {
    $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/proyecto/limite-inicio/"+nodo+"/"+user,
        success: function (response) {
            let strings = "";
            $("#proyectoInicio_body").empty();
            $("#proyectoInicio_titulo").empty();
            $("#proyectoInicio_titulo").append("<span class='cyan-text text-darken-3'>Proyectos que llevan mucho tiempo en inicio</span>");
            strings = '<ul class="collection">';
                if (response.data.proyectos.length == 0) {
                strings += '<li class="collection-item">'
                        +'<div class="row"><b class="title green-text">No tienes proyectos atrasados en la fase de inicio</b>'
                    +'</li>';
            } else {
                $.each(response.data.proyectos, function(i, item) {
                    // console.log(item);
                    strings += '<li class="collection-item">'
                        +'<div class="row"><div class="col s12 m3 l3"><b class="title green-text">Proyecto</b>'
                        +'<p>'+item.codigo_proyecto+' - '+item.nombre+'</p></div>'
                        +'<div class="col s12 m3 l3"><b class="title green-text">Línea</b>'
                        +'<p>'+item.nombre_linea+'</p></div>'
                        +'<div class="col s12 m3 l3"><b class="title green-text">Experto</b>'
                        +'<p>'+item.gestor+'</p></div>'
                        +'<div class="col s12 m3 l3"><b class="title green-text">Fecha de inicio del proyecto</b>'
                        +'<p>'+item.fecha_inicio+'</p></div></div>'
                    +'</li>';
                });
            }
            strings += '</ul>';
            $('#proyectoInicio_body').append(strings);
            $('#proyectoInicio_modal').openModal();
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    })
    }
</script>
@endpush