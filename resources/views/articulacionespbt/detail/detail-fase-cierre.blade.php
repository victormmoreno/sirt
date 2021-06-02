<div class="row">
    <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Idea
                        </span>
                        <p>
                            <a class="orange-text text-darken-1" onclick="detallesIdeaPorId({{$actividad->articulacionpbt->present()->articulacionPbtIdIdeaProyecto()}})">{{$actividad->articulacionpbt->present()->articulacionPbtCodeIdeaProyecto()}} - {{$actividad->articulacionpbt->present()->articulacionPbtNameIdeaProyecto()}}</a>
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Proyecto
                        </span>
                        <p>
                            <a class="orange-text text-darken-1" target="_blank" href="{{route('proyecto.detalle', $actividad->articulacionpbt->present()->articulacionPbtIdProyecto())}}">{{$actividad->articulacionpbt->present()->articulacionPbtCodeProyecto()}} - {{$actividad->articulacionpbt->present()->articulacionPbtNameProyecto()}}</a>
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Articulación
                        </span>
                        <p>
                           {{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha Incio de la Articulación
                        </span>
                        <p>
                            {{$actividad->present()->startDate()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha esperada de finalización de la Articulación
                        </span>
                        <p>
                           {{$actividad->articulacionpbt->present()->articulacionPbtFechaFinalizacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tipo Articulación
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreTipoArticulacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Alcance Articulación
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreAlcanceArticulacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de convocatoria 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreConvocatoria()}}
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
                            {{$actividad->articulacionpbt->present()->articulacionPbtEntidad()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de contacto 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreContacto()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Mail institucional de contacto de la organización 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtEmail()}}
                        </p>
                    </li>
                    
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo de la articulación 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtObjetivo()}}
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
                            @if ($actividad->articulacionpbt->present()->articulacionPbtPostulacion() == 1)
                                SI
                            @else
                                NO
                            @endif
                        </p>
                    </li>
                    @if ($actividad->articulacionpbt->present()->articulacionPbtPostulacion() == 0)
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                PDF justificativo firmado por el Talento
                            </span>
                            <p>
                                @if ($actividad->articulacionpbt->present()->articulacionPbtInformeJustificado() == 1)
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
                                {{$actividad->articulacionpbt->present()->articulacionPbtJustificacion()}}
                            </p>
                        </li>
                    @else
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Aprobación
                            </span>
                            <p>
                                @if ($actividad->articulacionpbt->present()->articulacionPbtAprobacion() == 1)
                                    Aprobado
                                @else
                                    No Aprobado
                                @endif
                            </p>
                        </li>
                        @if ($actividad->articulacionpbt->present()->articulacionPbtAprobacion() == 1)
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Qué recibirá
                                </span>
                                <p>
                                    {{$actividad->articulacionpbt->present()->articulacionPbtRecibira()}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Cuando
                                </span>
                                <p>
                                    {{$actividad->articulacionpbt->present()->articulacionPbtFechaCuando()}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de aprobación
                                </span>
                                <p>
                                    @if ($actividad->articulacionpbt->present()->articulacionPbtPdfAprobacion() == 1)
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
                                    @if ($actividad->articulacionpbt->present()->articulacionPbtPostulacion() == 1)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </p>
                            </li>
                        @else
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Informe de no aprobado
                                </span>
                                <p>
                                    @if ($actividad->articulacionpbt->present()->articulacionPbtInformeNoAprobado() == 1)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de no aprobación
                                </span>
                                <p>
                                    @if ($actividad->articulacionpbt->present()->articulacionPbtNoPdfAprobacion() == 1)
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
                                    @if ($actividad->articulacionpbt->present()->articulacionPbtDocumentoPostualcion() == 1)
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
                            {{$actividad->articulacionpbt->present()->articulacionPbtLeccionesAprendidas()}}     
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