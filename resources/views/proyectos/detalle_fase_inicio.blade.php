<a class="waves-effect waves-teal btn-flat" href="{{route('pdf.proyecto.acta.inicio', $proyecto->id)}}">Generar acta de inicio para categorización</a>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Idea de Proyecto
                        </span>
                        <p>
                            <a class="orange-text text-darken-1" onclick="detallesIdeaPorId({{$proyecto->idea->id}})">{{$proyecto->idea->codigo_idea}} - {{$proyecto->idea->nombre_proyecto}}</a>
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿La idea viene de una convocatoria?
                        </span>
                        <p>
                            {{$proyecto->idea->viene_convocatoria == 1 ? 'Si': 'No'}}
                        </p>
                        <span class="title black-text text-darken-3">
                            Nombre de convocatoria
                        </span>
                        <p>
                            {{$proyecto->idea->viene_convocatoria == 1 ? $proyecto->idea->convocatoria: 'No Aplica'}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Código del Proyecto
                        </span>
                        <p>
                            {{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre del Proyecto
                        </span>
                        <p>
                            {{$proyecto->articulacion_proyecto->actividad->nombre}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Linea Tecnológica
                        </span>
                        <p>
                            {{$proyecto->sublinea->linea->nombre}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Sublínea
                        </span>
                        <p>
                            {{$proyecto->sublinea->nombre}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Área de Conocimiento
                        </span>
                        <p>
                            {{$proyecto->areaconocimiento->nombre}} {{$proyecto->areaconocimiento->nombre == 'Otro' ? '(' . $proyecto->otro_areaconocimiento .')' : ''}}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            TRL que se pretende realizar
                        </span>
                        <p>
                            {{$proyecto->trl_esperado == 0 ? 'TRL 6' : 'TRL 7 - TRL 8'}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Recibido a través de fábrica de productividad?
                        </span>
                        <p>
                            {{$proyecto->fabrica_productividad == 0 ? 'NO' : 'SI'}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Recibido a través del área de emprendimiento SENA?
                        </span>
                        <p>
                            {{$proyecto->reci_ar_emp == 0 ? 'NO' : 'SI'}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿El proyecto pertenece a la economía naranja?
                        </span>
                        <p>
                            {{$proyecto->economia_naranja == 0 ? 'NO' : 'SI'}} {{$proyecto->economia_naranja == 1 ? '(' . $proyecto->tipo_economianaranja .')' : ''}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿El proyecto está dirigido a discapacitados?
                        </span>
                        <p>
                            {{$proyecto->dirigido_discapacitados == 0 ? 'NO' : 'SI'}} {{$proyecto->dirigido_discapacitados == 1 ? '(' . $proyecto->tipo_discapacitados .')' : ''}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Articulado con CT+i?
                        </span>
                        <p>
                            {{$proyecto->art_cti == 0 ? 'NO' : 'SI'}} {{$proyecto->art_cti == 1 ? '(' . $proyecto->nom_act_cti .')' : ''}}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Alcance del Proyecto
                        </span>
                        <p>
                            {{$proyecto->alcance_proyecto}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo General del Proyecto
                        </span>
                        <p>
                            {{$proyecto->articulacion_proyecto->actividad->objetivo_general}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Primer objetivo específico
                        </span>
                        <p>
                            @if (isset($proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo))
                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo}}
                            @endif
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Segundo objetivo específico
                        </span>
                        <p>
                            @if (isset($proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo))
                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo}}
                            @endif
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tercer objetivo específico
                        </span>
                        <p>
                            @if (isset($proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo))
                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo}}
                            @endif
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Cuarto objetivo específico
                        </span>
                        <p>
                            @if (isset($proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo))
                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo}}
                            @endif
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
        Talentos que participan en el proyecto y dueño(s) de la propiedad intelectual.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m3 l3">
        <div class="card-panel blue lighten-5">
            <h5 class="center">Talentos que participan en el proyecto</h5>
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">Talento Interlocutor</th>
                        <th style="width: 90%">Talento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proyecto->articulacion_proyecto->talentos as $key => $value)
                        <tr>
                        <td>{{$value->pivot->talento_lider == 1 ? 'SI' : 'NO'}}</td>
                        <td>{{$value->user()->withTrashed()->first()->documento}} - {{$value->user()->withTrashed()->first()->nombres}} {{$value->user()->withTrashed()->first()->apellidos}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-panel green lighten-5 col s12 m9 l9">
        <h5 class="center">Dueño(s) de la propiedad intelectual</h5>
        <div class="col s12 m4 l4">
            <div class="card-panel">
                <ul class="collection with-header">
                    <li class="collection-header"><h5>Empresas</h5></li>
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
        <div class="col s12 m4 l4">
            <div class="card-panel">
                <ul class="collection with-header">
                    <li class="collection-header"><h5>Personas (Talentos)</h5></li>
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
        <div class="col s12 m4 l4">
            <div class="card-panel">
                <ul class="collection with-header">
                    <li class="collection-header"><h5>Grupos de Investigación</h5></li>
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
    <span class="mailbox-title orange-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de inicio.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s6 m3 l3">
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
            <input type="checkbox" disabled {{ $proyecto->articulacion_proyecto->actividad->formulario_inicio == 1 ? 'checked' : '' }} id="txtformulario_inicio" name="txtformulario_inicio" value="1">
            <label for="txtformulario_inicio">Acta de Inicio.</label>
        </p>
    </div>
</div>
<div class="row">
    @include('proyectos.archivos_table_fase', ['fase' => 'inicio'])
</div>