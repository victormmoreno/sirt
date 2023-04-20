<div class="row">
    <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s12 m12 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Código del Proyecto
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoCode()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre del Proyecto
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Linea Tecnológica
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoLinea()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Sublínea
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoSublinea()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Área de Conocimiento
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoAreaConocimiento()}} {{$proyecto->present()->proyectoOtroAreaConocimiento()}}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m12 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            TRL que se pretende realizar
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoTrlEsperado()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Recibido a través de fábrica de productividad?
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoFabricaProductividad()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Recibido a través del área de emprendimiento SENA?
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoRecibidoAreaEmprendimiento()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿El proyecto pertenece a la economía naranja?
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoEconomiaNaranja()}} - {{$proyecto->present()->proyectoTipoEconomiaNaranja()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿El proyecto está dirigido a discapacitados?
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoDirigidoDiscapacitados()}} - {{$proyecto->present()->proyectoDirigidoTipoDiscapacitados()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Articulado con CT+i?
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoActorCTi()}} - {{$proyecto->present()->proyectoNombreActorCTi()}}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m12 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Alcance del Proyecto
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoAlcance()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo General del Proyecto
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoObjetivoGeneral()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Primer objetivo específico
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoPrimerObjetivo()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Segundo objetivo específico
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoSegundoObjetivo()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tercer objetivo específico
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoTercerObjetivo()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Cuarto objetivo específico
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoCuartoObjetivo()}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="center">
    <span class="mailbox-title primary-text">
        <i class="material-icons">group</i>
        Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m8 l3 offset-m2 ">
        <div class="card-transparent">
            <h5 class="center secondary-text">Talentos que participan en el proyecto</h5>
            <table>
                <thead class="bg-primary white-text">
                    <tr>
                        <th style="width: 10%">Talento Interlocutor</th>
                        <th style="width: 90%">Talento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proyecto->talentos as $key => $value)
                        <tr>
                        <td>{{$value->pivot->talento_lider == 1 ? 'SI' : 'NO'}}</td>
                        <td>
                            <a target="_blank" href="{{route("usuario.usuarios.show", $value->documento)}}" class="info-text">
                                {{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}
                            </a>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-transparent col s12 m12 l9">
        <h5 class="center secondary-text">Dueño(s) de la propiedad intelectual</h5>
        <div class="col s12 m12 l4">
            <div class="card-transparent m-2">
                <ul class="collection with-header">
                    <li class="collection-header"><h5 class="secondary-text">Empresas</h5></li>
                    @if ($proyecto->sedes->count() > 0)
                    @foreach ($proyecto->sedes as $key => $value)
                    <li class="collection-item">
                        {{$value->empresa->nit}} - {{ $value->empresa->nombre }} ({{$value->nombre_sede}})
                    </li>
                    @endforeach
                    @else
                    <li class="collection-item">
                        No se han encontrado empresas dueña(s) de la propiedad intelectual.
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="col s12 m12 l4">
            <div class="card-transparent">
                <ul class="collection with-header">
                    <li class="collection-header"><h5 class="secondary-text">Personas (Talentos)</h5></li>
                    @if ($proyecto->users_propietarios->count() > 0)
                    @foreach ($proyecto->users_propietarios as $key => $value)
                    <li class="collection-item">
                        {{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}
                    </li>
                    @endforeach
                    @else
                    <li class="collection-item">
                        No se han encontrado talento(s) dueño(s) de la propiedad intelectual.
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="col s12 m12 l4">
            <div class="card-transparent">
                <ul class="collection with-header">
                    <li class="collection-header"><h5 class="secondary-text">Grupos de Investigación</h5></li>
                    @if ($proyecto->gruposinvestigacion->count() > 0)
                    @foreach ($proyecto->gruposinvestigacion as $key => $value)
                    <li class="collection-item">
                        {{$value->codigo_grupo}} - {{ $value->entidad->nombre }}
                    </li>
                    @endforeach
                    @else
                    <li class="collection-item">
                        No se han encontrado grupo(s) de investigación dueño(s) de la propiedad intelectual.
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="center">
    <span class="mailbox-title primary-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de inicio.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m6 l3">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->acc == 1 ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
            <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->doc_titular == 1 ? 'checked' : '' }} id="txtdoc_titular" name="txtdoc_titular" value="1">
            <label for="txtdoc_titular">Documento del Titular.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->manual_uso_inf == 1 ? 'checked' : '' }} id="txtmanual_uso_inf" name="txtmanual_uso_inf" value="1">
            <label for="txtmanual_uso_inf">Manual de uso de infraestructura.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->formulario_inicio == 1 ? 'checked' : '' }} id="txtformulario_inicio" name="txtformulario_inicio" value="1">
            <label for="txtformulario_inicio">Acta de Inicio.</label>
        </p>
    </div>
</div>
<div class="row">
    @include('proyectos.archivos_table_fase', ['fase' => 'inicio'])
</div>
