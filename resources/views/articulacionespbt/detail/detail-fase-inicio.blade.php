<div class="row">
    <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tipo Convocatoria
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtNameTipoVinculacion()}}
                        </p>
                    </li>
                    @if($articulacion->present()->articulacionPbtTipoVinculacion(App\Models\ArticulacionPbt::IsPbt()))
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Idea
                            </span>
                            <p>
                                <a class="orange-text text-darken-1" onclick="detallesIdeaPorId({{$articulacion->present()->articulacionPbtIdIdeaProyecto()}})">{{$articulacion->present()->articulacionPbtCodeIdeaProyecto()}} - {{$articulacion->present()->articulacionPbtNameIdeaProyecto()}}</a>
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Proyecto
                            </span>
                            <p>
                                <a class="orange-text text-darken-1" target="_blank" href="{{route('proyecto.detalle', $articulacion->present()->articulacionPbtIdProyecto())}}">{{$articulacion->present()->articulacionPbtCodeProyecto()}} - {{$articulacion->present()->articulacionPbtNameProyecto()}}</a>
                            </p>
                        </li>
                    @else
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Sede de la empresa
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtSedeEmpresa()}}
                        </p>
                    </li>
                    @endif
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtCode()}} - {{$articulacion->present()->articulacionPbtName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha Inicio de la Articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtstartDate()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha esperada de finalización de la Articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtFechaFinalizacion()}}
                        </p>
                    </li>

                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tipo Articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtNombreTipoArticulacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Alcance Articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtNombreAlcanceArticulacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de convocatoria
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtNombreConvocatoria()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo de la articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtObjetivo()}}
                        </p>
                    </li>

                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Entidad con la que se realiza la articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtEntidad()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de contacto
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtNombreContacto()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Mail institucional de contacto de la organización
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtEmail()}}
                        </p>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="center">
    <span class="mailbox-title orange-text">
        <i class="material-icons">group</i>
        Talentos que participan en la articulación.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card card-transparent">
            <div class="row card-talent">
            @forelse ($articulacion->talentos as $talento)
                <div class="col s12 m12 l4">
                    <div class="card bs-dark ">
                        <div class="card-content">
                            <span class="card-title p-h-lg"> {{$talento->user->present()->userDocumento()}} - {{$talento->user->present()->userFullName()}}</span>@if($talento->pivot->talento_lider == 1) <p class="orange-text p-h-lg">Talento Interlocutor</p>  @endif
                            <div class=" p-h-lg mail-date hide-on-med-and-down">  Acceso al sistema: {{$talento->user->present()->userAcceso()}}</div>

                            <p class="hide-on-med-and-down p-h-lg"> Miembro desde {{$talento->user->present()->userCreatedAtFormat()}}</p>
                        </div>
                        <div class="card-action">
                            <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="{{route('usuario.usuarios.show',$talento->user->documento)}}"><i class="material-icons left"> link</i>Ver más</a>

                        </div>
                    </div>
                </div>
            @empty
                <div class="row talent-empty">
                    <div class="col s12 m12 l12">
                        <div class="card card-transparent">
                            <div class="card-content">
                                <div class="search-result">
                                    <p class="search-result-description">Aún no se han agregado talentos</p>
                                </div>
                            </div>
                        </div>
                        <small id="talentos-error" class="error red-text"></small>
                    </div>
                </div>
            @endforelse
            </div>
        </div>
    </div>
</div>
<div class="center">
    <span class="mailbox-title orange-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de inicio.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    @include('articulacionespbt.table-archive-fase', ['fase' => 'inicio'])
</div>
