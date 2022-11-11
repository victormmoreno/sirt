<div class="row col s12 m6 l6">
    <ul class="collection">
        <li class="collection-item">
            <span class="title secondary-text">
                Experto que asesora el proyecto
            </span>
            <p>
                {{$proyecto->present()->proyectoUserAsesor()}}
            </p>
        </li>
        <li class="collection-item">
            <span class="title secondary-text">
                Idea de Proyecto
            </span>
            <p>
                <a class="primary-text" onclick="detallesIdeaPorId({{$proyecto->idea->id}})">{{$proyecto->idea->present()->ideaCode()}} - {{$proyecto->idea->present()->ideaName()}}</a>
            </p>
        </li>
        <li class="collection-item">
            <span class="title secondary-text">
                ¿La idea viene de una convocatoria?
            </span>
            <p>
                {{$proyecto->idea->present()->ideaVieneConvocatoria()}}
            </p>
            <span class="title secondary-text">
                Nombre de convocatoria
            </span>
            <p>
                {{$proyecto->idea->present()->ideaNombreConvocatoria()}}
            </p>
        </li>
    </ul>
</div>
@include('ideas.modals')
