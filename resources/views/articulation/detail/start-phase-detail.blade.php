<div class="row">
    @include('articulation.options.articulation-options-menu-left')
    <div class="@canany(['showButtonAprobacion', 'requestApproval', 'showStart', 'showExecution', 'showClosing', 'changeTalents'], $articulation)col s12 m8 l9 @elsecanany(['create'], App\Models\Articulation::class) col s12 m8 l9 @else col s12 m12 l12  @endcanany">
        <div class="row">
            <div class="col s12 m4 l4">
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
                            {{__('Start Date')}}
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
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
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
            <div class="col s12 m4 l4">
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
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="center">
    <span class="mailbox-title primary-text">
        <i class="material-icons">group</i>
        Talentos que participan en la articulación.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card card-transparent">
            <div class="row card-talent">
            @forelse ($articulation->users as $user)
                <div class="col s12 m12 l4">
                    <div class="card bs-dark ">
                        <div class="card-content">
                            <span class="card-title p-h-lg"> {{$user->present()->userDocumento()}} - {{$user->present()->userFullName()}}</span>
                            <div class=" p-h-lg mail-date hide-on-med-and-down">  Acceso al sistema: {!!$user->present()->userAcceso()!!}</div>

                            <p class="hide-on-med-and-down p-h-lg"> Miembro desde {{$user->present()->userCreatedAtFormat()}}</p>
                        </div>
                        @can('show',$user)
                        <div class="card-action">
                            <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs primary-text" href="{{route('usuario.usuarios.show',$user->documento)}}"><i class="material-icons left"> link</i>Ver más</a>
                        </div>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="row talent-empty">
                    <div class="col s12 m12 l12">
                        <div class="card card-transparent">
                            <div class="card-content">
                                <div class="search-result">
                                    <p class="search-result-description">Aún no se han agregado talentos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
            </div>
        </div>
    </div>
</div>

