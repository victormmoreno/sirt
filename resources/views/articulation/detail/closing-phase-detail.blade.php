<div class="row">
    @include('articulation.options.articulation-options-menu-left')
    <div class="@canany(['showButtonAprobacion', 'requestApproval', 'showStart', 'showExecution', 'showClosing', 'changeTalents'], $articulation)col s12 m8 l9 @elsecanany(['create'], App\Models\Articulation::class) col s12 m8 l9 @else col s12 m12 l12  @endcanany">
        <div class="row">
            <div class="col s12 m6 l6">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            {{__('Name ArticulationStage')}}
                        </span>
                        <p>
                            {{$articulation->articulationStage->present()->articulationStageCode()}} - {{$articulation->articulationStage->present()->articulationStageName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            {{__('Project')}}
                        </span>
                        <p>
                            {!! $articulation->articulationStage->present()->articulationStageableLink() !!}
                        </p>
                    </li>

                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha Incio de la Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationStartDate()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha esperada de finalización de la Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationExpectedEndDate()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Alcance Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationScope()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo de la articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationObjetive()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            {{ __('Interlocutory talent') }}
                        </span>
                        <p>
                            {{$articulation->articulationStage->present()->articulationStageInterlocutorTalent()}}
                        </p>
                    </li>
                </ul>
            </div>

            <div class="col s12 m6 l6">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Entidad con la que se realiza la articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationEntity()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de contacto
                        </span>
                        <p>
                            {{$articulation->present()->articulationContactName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Mail institucional de contacto de la organización
                        </span>
                        <p>
                            {{$articulation->present()->articulationEmailEntity()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tipo articulación / tipo subarticulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationSubtype()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Se realizo la postulación al convenio, convocatoria y/o instrumento
                        </span>
                        <p>
                            {{$articulation->postulation == 0 ? 'NO': 'SI' }}
                        </p>
                    </li>
                    @if ($articulation->postulation == 0)
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                PDF justificativo firmado por el Talento
                            </span>
                            <p>
                                {{$articulation->justified_report == 0 ? 'NO': 'SI' }}
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Justificación
                            </span>
                            <p>
                                {{ isset($articulation->justification) ? $articulation->justification : 'No registra'}}
                            </p>
                        </li>
                    @else
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Aprobación
                            </span>
                            <p>
                                {{$articulation->approval == 1 ? 'Aprobado': 'No aprobado' }}
                            </p>
                        </li>
                        @if ($articulation->approval == 1)
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Qué recibirá
                                </span>
                                <p>
                                    {{isset($articulation->receive) ? $articulation->receive : ''}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Cuando
                                </span>
                                <p>
                                    {{isset($articulation) ? optional($articulation->received_date)->format('Y-m-d') : ''}}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de aprobación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->approval_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de documentos de postulación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->postulation_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                        @else
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    Informe
                                </span>
                                <p>
                                    {{isset($articulation) ? $articulation->report: '' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de no aprobación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->non_approval_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text text-darken-3">
                                    PDF de documentos de postulación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->postulation_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                        @endif
                    @endif
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Lecciones aprendidas
                        </span>
                        <p>
                            {{isset($articulation) ? $articulation->learned_lessons : '' }}
                        </p>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @include('articulation.table-archive-phase', ['fase' => 'Closing'])
</div>


