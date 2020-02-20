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
                                            Información de Proyecto en la fase de cierre - {{$proyecto->articulacion_proyecto->actividad->nombre}} 
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
                                                            ¿TRL obtenido?
                                                        </span>
                                                        <p>
                                                            @if ($proyecto->trl_obtenido == 0)
                                                                TRL 6
                                                            @elseif ($proyecto->trl_obtenido == 1)
                                                                TRL 7
                                                            @else
                                                                TRL 8
                                                            @endif
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Dirigido a área de emprendimiento SENA?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->diri_ar_emp == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Costo Aproximado del Proyecto
                                                        </span>
                                                        <p>
                                                            $ {{$costo->getData()->costosTotales}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Conclusiones y siguiente paso del proyecto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->conclusiones}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Primer objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo}}
                                                        </p>
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Se cumplió?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->cumplido == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Segundo objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo}}
                                                        </p>
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Se cumplió?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->cumplido == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Tercer objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo}}
                                                        </p>
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Se cumplió?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->cumplido == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Cuarto objetivo específico
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo}}
                                                        </p>
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Se cumplió?
                                                        </span>
                                                        <p>
                                                            {{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->cumplido == 0 ? 'NO' : 'SI'}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12 m6 l6">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Evidencias Prototipo producto
                                                        </span>
                                                        <p>
                                                            {{$proyecto->trl_prototipo}}


                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Evidencias Pruebas documentadas
                                                        </span>
                                                        <p>
                                                            {{$proyecto->trl_pruebas}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m6 l6">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Evidencias Modelo de negocio
                                                        </span>
                                                        <p>
                                                            {{$proyecto->trl_modelo}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Evidencias Normatividad
                                                        </span>
                                                        <p>
                                                            {{$proyecto->trl_normatividad}}
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
                                        <i class="material-icons">attach_file</i>
                                        Evidencias de la fase de cierre.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    <div class="col s6 m3 l3">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $proyecto->evidencia_trl == 1 ? 'checked' : '' }} id="txtevidencia_trl" name="txtevidencia_trl" value="1">
                                            <label for="txtevidencia_trl">Evidencias según el trl.</label>
                                        </p>
                                    </div>
                                    <div class="col s6 m3 l3">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $proyecto->articulacion_proyecto->actividad->formulario_final == 1 ? 'checked' : '' }} id="txtformulario_final" name="txtformulario_final" value="1">
                                            <label for="txtformulario_final">Formularios con firmas del gestor y talentos.</label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('proyectos.archivos_table_fase', ['fase' => 'cierre'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>