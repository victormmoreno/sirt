<div class="row">
    <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s12 m4 l4">
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
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿TRL obtenido?
                        </span>
                        <p>
                            @if (isset($proyecto->trl_obtenido) && $proyecto->trl_obtenido == 0)
                                TRL 6
                            @elseif (isset($proyecto->trl_obtenido) && $proyecto->trl_obtenido == 1)
                                TRL 7
                            @elseif (isset($proyecto->trl_obtenido) && $proyecto->trl_obtenido == 2)
                                TRL 8
                            @else
                                No Registra
                            @endif
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            ¿Dirigido a área de emprendimiento SENA?
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoDirigidoAreaEmprendimiento()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Aporte estimado de Tecnoparque al proyecto
                        </span>
                        <p>
                            $ {{$costo->getData()->costosTotales}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Conclusiones y siguiente paso del proyecto
                        </span>
                        <p>
                            {{$proyecto->present()->proyectoConclusiones()}}
                        </p>
                    </li>

                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Primer objetivo específico
                        </span>
                        @if (isset($proyecto->objetivos_especificos[0]->objetivo))
                        <p>
                            {{$proyecto->present()->proyectoPrimerObjetivo()}}
                        </p>
                        <span class="title black-text text-darken-3">
                            ¿Se cumplió?
                        </span>
                        <p>
                            {{$proyecto->present()->isProyectoCumplioPrimerObjetivo()}}
                        </p>
                        @else
                        <p>
                            No hay registros de los objetivos específicos
                        </p>
                        @endif
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Segundo objetivo específico
                        </span>
                        @if (isset($proyecto->objetivos_especificos[1]->objetivo))
                        <p>
                            {{$proyecto->present()->proyectoSegundoObjetivo()}}
                        </p>
                        <span class="title black-text text-darken-3">
                            ¿Se cumplió?
                        </span>
                        <p>
                            {{$proyecto->present()->isProyectoCumplioSegundoObjetivo()}}
                        </p>
                        @else
                        <p>
                            No hay registros de los objetivos específicos
                        </p>
                        @endif
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tercer objetivo específico
                        </span>
                        @if (isset($proyecto->objetivos_especificos[2]->objetivo))
                        <p>
                            {{$proyecto->present()->proyectoTercerObjetivo()}}
                        </p>
                        <span class="title black-text text-darken-3">
                            ¿Se cumplió?
                        </span>
                        <p>
                            {{$proyecto->present()->isProyectoCumplioTercerObjetivo()}}
                        </p>
                        @else
                        <p>
                            No hay registros de los objetivos específicos
                        </p>
                        @endif
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Cuarto objetivo específico
                        </span>
                        @if (isset($proyecto->objetivos_especificos[3]->objetivo))
                        <p>
                            {{$proyecto->present()->proyectoCuartoObjetivo()}}
                        </p>
                        <span class="title black-text text-darken-3">
                            ¿Se cumplió?
                        </span>
                        <p>
                            {{$proyecto->present()->isProyectoCumplioCuartoObjetivo()}}
                        </p>
                        @else
                        <p>
                            No hay registros de los objetivos específicos
                        </p>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <ul class="collection">
            <li class="collection-item">
                <span class="title black-text text-darken-3">
                    Evidencias Prototipo producto
                </span>
                <p>
                    {{$proyecto->present()->proyectoTrlPrototipo()}}
                </p>
            </li>
            <li class="collection-item">
                <span class="title black-text text-darken-3">
                    Evidencias Pruebas documentadas
                </span>
                <p>
                    {{$proyecto->present()->proyectoEvidenciasPruebasDocumentadas()}}
                </p>
            </li>
        </ul>
    </div>
    <div class="col s12 m6 l6">
        <ul class="collection">
            <li class="collection-item">
                <span class="title black-text text-darken-3">
                    Evidencias Modelo de negocio
                </span>
                <p>
                    {{$proyecto->present()->proyectoEvidenciasModeloNegocio()}}
                </p>
            </li>
            <li class="collection-item">
                <span class="title black-text text-darken-3">
                    Evidencias Normatividad
                </span>
                <p>
                    {{$proyecto->present()->proyectoEvidenciasNormatividad()}}
                </p>
            </li>
        </ul>
    </div>
</div>
<div class="center">
    <span class="mailbox-title primary-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de cierre.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->present()->proyectoEvidenciaTrl() == 1 ? 'checked' : '' }} id="txtevidencia_trl" name="txtevidencia_trl" value="1">
            <label for="txtevidencia_trl">Evidencias según el trl.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->formulario_final == 1 ? 'checked' : '' }} id="txtformulario_final" name="txtformulario_final" value="1">
            <label for="txtformulario_final">Acta de Cierre.</label>
        </p>
    </div>
</div>
<div class="row">
    @include('proyectos.archivos_table_fase', ['fase' => 'cierre'])
</div>
