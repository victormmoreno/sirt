<div class="row">
    {{-- @canany([],
        $articulation) --}}
        <div class="collection with-header col s12 m4 l3">
            <h5 href="!#" class="collection-header">Opciones</h5>
            @can('showButtonAprobacion', [$articulation, 'Finalizado'])
                @include('articulation.form.approval-articulation-form')
            @endcan
            @can('requestApproval', $articulation)
                <a href="{{ route('articulation.request-approval', $articulation) }}" class="collection-item yellow lighten-3">
                    <i class="material-icons left">notifications</i>
                    @if ($rol_destinatario == \App\User::IsDinamizador())
                        Enviar solicitud de aprobación al {{ \App\User::IsDinamizador() }}
                        para finalizar
                    @else
                        @if (isset($ult_traceability->movimiento) && $ult_traceability->rol == \App\User::IsDinamizador())
                            Enviar solicitud de aprobación al {{ \App\User::IsDinamizador() }}
                            para finalizar
                        @else
                            El dinamizador ya dio la aprobación
                        @endif
                    @endif
                </a>
            @endcan
            @include('articulation.options.articulation-options-menu-left')
        </div>
    {{-- @endcanany --}}
    <div
        class="col s12 m8 l9">
        <div class="row">
            <div class="col s12 m12 l6">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text">
                            {{ __('Name ArticulationStage') }}
                        </span>
                        <p>
                            {{ $articulation->articulationStage->present()->articulationStageCode() }} -
                            {{ $articulation->articulationStage->present()->articulationStageName() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Articulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationCode() }} -
                            {{ $articulation->present()->articulationName() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            {{ __('Project') }}
                        </span>
                        <p>
                            {!! $articulation->articulationStage->present()->articulationStageableLink() !!}
                        </p>
                    </li>

                    <li class="collection-item">
                        <span class="title black-text">
                            Fecha Incio de la Articulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationStartDate() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Fecha esperada de finalización de la Articulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationExpectedEndDate() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Alcance Articulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationScope() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Objetivo de la articulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationObjetive() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            {{ __('Interlocutory talent') }}
                        </span>
                        <p>
                            {{ $articulation->articulationStage->present()->articulationStageInterlocutorTalent() }}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m12 l6">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text">
                            Entidad con la que se realiza la articulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationEntity() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Nombre de contacto
                        </span>
                        <p>
                            {{ $articulation->present()->articulationContactName() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Mail institucional de contacto de la organización
                        </span>
                        <p>
                            {{ $articulation->present()->articulationEmailEntity() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Tipo articulación / tipo subarticulación
                        </span>
                        <p>
                            {{ $articulation->present()->articulationSubtype() }}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Se realizo la postulación al convenio, convocatoria y/o instrumento
                        </span>
                        <p>
                            {{ $articulation->postulation == 0 ? 'NO' : 'SI' }}
                        </p>
                    </li>
                    @if ($articulation->postulation == 0)
                        <li class="collection-item">
                            <span class="title black-text">
                                PDF justificativo firmado por el Talento
                            </span>
                            <p>
                                {{ $articulation->justified_report == 0 ? 'NO' : 'SI' }}
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title black-text">
                                Justificación
                            </span>
                            <p>
                                {{ isset($articulation->justification) ? $articulation->justification : 'No registra' }}
                            </p>
                        </li>
                    @else
                        <li class="collection-item">
                            <span class="title black-text">
                                Aprobación
                            </span>
                            <p>
                                {{ $articulation->approval == 1 ? 'Aprobado' : 'No aprobado' }}
                            </p>
                        </li>
                        @if ($articulation->approval == 1)
                            <li class="collection-item">
                                <span class="title black-text">
                                    Qué recibirá
                                </span>
                                <p>
                                    {{ isset($articulation->receive) ? $articulation->receive : '' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text">
                                    Cuando
                                </span>
                                <p>
                                    {{ isset($articulation) ? optional($articulation->received_date)->format('Y-m-d') : '' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text">
                                    PDF de aprobación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->approval_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text">
                                    PDF de documentos de postulación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->postulation_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                        @else
                            <li class="collection-item">
                                <span class="title black-text">
                                    Informe
                                </span>
                                <p>
                                    {{ isset($articulation) ? $articulation->report : '' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text">
                                    PDF de no aprobación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->non_approval_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                            <li class="collection-item">
                                <span class="title black-text">
                                    PDF de documentos de postulación
                                </span>
                                <p>
                                    {{ isset($articulation) && $articulation->postulation_document == 1 ? 'SI' : 'NO' }}
                                </p>
                            </li>
                        @endif
                    @endif
                    <li class="collection-item">
                        <span class="title black-text">
                            Lecciones aprendidas
                        </span>
                        <p>
                            {{ isset($articulation) ? $articulation->learned_lessons : '' }}
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
