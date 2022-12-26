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
                            Empresa
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
                            Fecha Incio de la Articulación
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

                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo de la articulación
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtObjetivo()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Costo Aproximado de la articulación
                        </span>
                        <p>
                            $ 0
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Se realizo la postulación al convenio, convocatoria y/o instrumento
                        </span>
                        <p>
                            @if ($articulacion->present()->articulacionPbtPostulacion() == 1)
                                SI
                            @else
                                NO
                            @endif
                        </p>
                    </li>
                    @if ($articulacion->present()->articulacionPbtPostulacion() == 0)
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                PDF justificativo firmado por el Talento
                            </span>
                            <p>
                                @if ($articulacion->present()->articulacionPbtInformeJustificado() == 1)
                                    SI
                                @else
                                    NO
                                @endif
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Justificación
                            </span>
                            <p>
                                {{$articulacion->present()->articulacionPbtJustificacion()}}
                            </p>
                        </li>
                    @else
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Aprobación
                            </span>
                            <p>
                                @if ($articulacion->present()->articulacionPbtAprobacion() == 1)
                                    Aprobado
                                @else
                                    No Aprobado
                                @endif
                            </p>
                        </li>
                        @if ($articulacion->present()->articulacionPbtAprobacion() == 1)
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Qué recibirá
                                </span>
                                <p>
                                    {{$articulacion->present()->articulacionPbtRecibira()}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Cuando
                                </span>
                                <p>
                                    {{$articulacion->present()->articulacionPbtFechaCuando()}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de aprobación
                                </span>
                                <p>
                                    @if ($articulacion->present()->articulacionPbtPdfAprobacion() == 1)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de documentos de postulación
                                </span>
                                <p>
                                    @if ($articulacion->present()->articulacionPbtPostulacion() == 1)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </p>
                            </li>
                        @else
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Informe
                                </span>
                                <p>
                                    {{$articulacion->present()->articulacionPbtInforme()}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de no aprobación
                                </span>
                                <p>
                                    @if ($articulacion->present()->articulacionPbtNoPdfAprobacion() == 1)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de documentos de postulación
                                </span>
                                <p>
                                    @if ($articulacion->present()->articulacionPbtDocumentoPostualcion() == 1)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </p>
                            </li>
                        @endif
                    @endif
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Lecciones aprendidas
                        </span>
                        <p>
                            {{$articulacion->present()->articulacionPbtLeccionesAprendidas()}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="center">
    <span class="mailbox-title orange-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de Cierre.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    @include('articulacionespbt.table-archive-fase', ['fase' => 'cierre'])
</div>
