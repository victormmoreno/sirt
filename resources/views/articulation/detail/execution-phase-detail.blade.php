<div class="row">
    @include('articulation.options.articulation-options-menu-left')
    <div class="@canany(['showButtonAprobacion', 'requestApproval', 'showStart', 'showExecution', 'showClosing', 'changeTalents', 'changePhase'], $articulation)col s12 m8 l9 @else col s12 m12 l12  @endcanany">
        <div class="row">
            <div class="col s12 m12 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text">
                            {{__('Name ArticulationStage')}}
                        </span>
                        <p>
                            {{$articulation->articulationStage->present()->articulationStageCode()}} - {{$articulation->articulationStage->present()->articulationStageName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            {{__('Project')}}
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
                            {{$articulation->present()->articulationStartDate()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Fecha esperada de finalización de la Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationExpectedEndDate()}}
                        </p>
                    </li>

                </ul>
            </div>
            <div class="col s12 m12 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text">
                            Alcance Articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationScope()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Objetivo de la articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationObjetive()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            {{ __('Interlocutory talent') }}
                        </span>
                        <p>
                            {{$articulation->articulationStage->present()->articulationStageInterlocutorTalent()}}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col s12 m12 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text">
                            Entidad con la que se realiza la articulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationEntity()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Nombre de contacto
                        </span>
                        <p>
                            {{$articulation->present()->articulationContactName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Mail institucional de contacto de la organización
                        </span>
                        <p>
                            {{$articulation->present()->articulationEmailEntity()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text">
                            Tipo articulación / tipo subarticulación
                        </span>
                        <p>
                            {{$articulation->present()->articulationSubtype()}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @include('articulation.table-archive-phase', ['fase' => 'Execution'])
</div>


