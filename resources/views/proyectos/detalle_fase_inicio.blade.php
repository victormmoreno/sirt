<div class="row">
    <div class="col s12 m12 l12">
        <div class="card mailbox-content">
            <div class="card-content">
                <div class="row no-m-t no-m-b">
                    <div class="col s12 m12 l12">
                        <div class="mailbox-view">
                            <div class="mailbox-view-header">
                                <div class="left">
                                    <div class="left">
                                        <i class="material-icons fas fa-building"></i>
                                    </div>
                                    <div class="left">
                                        <span class="mailbox-title">
                                            Tecnoparque nodo {{$proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre}}
                                        </span>
                                    </div>
                                </div>
                                <div class="right mailbox-buttons">
                                    <span class="mailbox-title">
                                        <p class="center">
                                            Información de Proyecto en la fase de inicio - {{$proyecto->articulacion_proyecto->actividad->nombre}} 
                                        </p>
                                        <br />
                                        <p class="center">Linea Tecnológica:
                                            {{$proyecto->sublinea->linea->abreviatura}} - {{$proyecto->sublinea->linea->nombre}}
                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="right">
                                <small>
                                    <b>Fecha de inicio del proyecto: </b>
                                    {{optional($proyecto->articulacion_proyecto->actividad->created_at)->isoFormat('LL')}}
                                </small>
                            </div>
                            <div class="divider mailbox-divider">
                            </div>
                            <div class="mailbox-text">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center">
                                            <span class="mailbox-title">
                                                <i class="material-icons">build</i>
                                                Información del Proyecto
                                                {{$proyecto->articulacion_proyecto->actividad->codigo_actividad}} - {{$proyecto->articulacion_proyecto->actividad->nombre}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="row">
                                            <div class="col s12 m4 l4">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Idea de Proyecto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->idea->codigo_idea}} - {{$proyecto->idea->nombre_proyecto}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Código del Proyecto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Nombre del Proyecto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->nombre}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Linea Tecnológica
                                                        </span>
                                                        <p>
                                                            {{$proyecto->sublinea->linea->nombre}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Sublínea
                                                        </span>
                                                        <p>
                                                            {{$proyecto->sublinea->nombre}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
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
                                                        <span class="title cyan-text text-darken-3">
                                                            TRL que se pretende realizar
                                                        </span>
                                                        <p>
                                                            {{$proyecto->trl_esperado == 0 ? 'TRL 6' : 'TRL 7 - TRL 8'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Recibido a través de fábrica de productividad?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->fabrica_productividad == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Recibido a través del área de emprendimiento SENA?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->reci_ar_emp == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿El proyecto pertenece a la economía naranja?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->economia_naranja == 0 ? 'NO' : 'SI'}} {{$proyecto->economia_naranja == 1 ? '(' . $proyecto->tipo_economianaranja .')' : ''}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿El proyecto está dirigido a discapacitados?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->dirigido_discapacitados == 0 ? 'NO' : 'SI'}} {{$proyecto->dirigido_discapacitados == 1 ? '(' . $proyecto->tipo_discapacitados .')' : ''}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
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
                                                        <span class="title cyan-text text-darken-3">
                                                            Alcance del Proyecto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->alcance_proyecto}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Objetivo General del Proyecto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivo_general}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Primer objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Segundo objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Tercer objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Cuarto objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="center">
                                    <span class="mailbox-title">
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
                                                        <td>{{$value->user->documento}} - {{$value->user->nombres}} {{$value->user->apellidos}}</td>
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
                                                    @if ($proyecto->empresas->count() > 0)
                                                    @foreach ($proyecto->empresas as $key => $value)
                                                    <li class="collection-item">
                                                        {{$value->nit}} - {{ $value->entidad->nombre }}
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
                                <div class="divider mailbox-divider"></div>
                                <div class="center">
                                    <span class="mailbox-title">
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
                                            <label for="txtformulario_inicio">Formularios con firmas del gestor y talentos.</label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('proyectos.archivos_table_fase')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>