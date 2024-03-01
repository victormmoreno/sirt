<div class="row col s12 m6 l6">
    <ul class="collection">
        <li class="collection-item">
            <span class="title secondary-text">
                Experto que asesora el proyecto
            </span>
            <p>
                {{$proyecto->present()->proyectoUserAsesor()}}
            </p>
            <a target="_blank" href="{{route("usuario.show", $proyecto->asesor->documento)}}" class="info-text">
                Ver mas información del usuario.
            </a>
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
        <li class="collection-item">
            <span class="title black-text text-darken-3">
                Fecha de inicio del proyecto
            </span>
            <p>
                {{$proyecto->present()->proyectoFechaInicio()}}
            </p>
        </li>
        @if ($proyecto->tags()->exists())
        <li class="collection-item">
            <span class="title black-text text-darken-3">
                Caracterización del proyecto
            </span>
            <p>
                @foreach ($proyecto->tags as $tag)
                    <a class="waves-effect waves-light btn-flat btn-small primary-text xs tooltipped" data-position="bottom" data-tooltip="{{$tag->description}}">{{$tag->name}}</a>
                @endforeach
            </p>
        </li>
        @endif
    </ul>
</div>
@include('ideas.modals')
