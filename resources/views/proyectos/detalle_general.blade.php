<div class="row col s12 m6 l6">
    <ul class="collection">
        <li class="collection-item">
            <span class="title black-text text-darken-3">
                Experto que asesora el proyecto
            </span>
            <p>
                {{$proyecto->present()->proyectoUserAsesor()}}
            </p>
        </li>
        <li class="collection-item">
            <span class="title black-text text-darken-3">
                Idea de Proyecto
            </span>
            <p>
                <a class="orange-text text-darken-1" onclick="detallesIdeaPorId({{$proyecto->idea->id}})">{{$proyecto->idea->present()->ideaCode()}} - {{$proyecto->idea->present()->ideaName()}}</a>
            </p>
        </li>
        <li class="collection-item">
            <span class="title black-text text-darken-3">
                ¿La idea viene de una convocatoria?
            </span>
            <p>
                {{$proyecto->idea->present()->ideaVieneConvocatoria()}}
            </p>
            <span class="title black-text text-darken-3">
                Nombre de convocatoria
            </span>
            <p>
                {{$proyecto->idea->present()->ideaNombreConvocatoria()}}
            </p>
        </li>
    </ul>
</div>
@include('ideas.modals')