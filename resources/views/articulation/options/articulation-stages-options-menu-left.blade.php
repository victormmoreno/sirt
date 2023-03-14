@canany(['showButtonAprobacion', 'requestApproval', 'changeTalent', 'update', 'downloadCertificateEnd', 'downloadCertificateStart', 'uploadEvidences', 'delete'], $articulationStage)
<div class="collection with-header  col s12 m4 l3">
    <h5 href="!#" class="collection-header primary-text">Opciones</h5>
    @if (Route::currentRouteName() == 'articulation-stage.show')
        @can('showButtonAprobacion', $articulationStage)
            @include('articulation.form.endorsement-form')
        @endcan
        @can('create', App\Models\Articulation::class)
            @if($articulationStage->status == \App\Models\ArticulationStage::STATUS_OPEN)
                <a href="{{ route('articulations.create', $articulationStage) }}"
                    class="collection-item">
                    <i class="material-icons left">autorenew</i>
                    {{ __('New Articulation') }}
                </a>
            @endif
        @endcan
        @can('requestApproval', $articulationStage)
            @if($articulationStage->status == \App\Models\ArticulationStage::STATUS_CLOSE)
                <a href="{{route('articulation-stage.request-approval', [$articulationStage->id , 'abrir' ])}}"
                    class="collection-item yellow lighten-3">
                    <i class="material-icons left">notifications</i>
                    @if($rol_destinatario == \App\User::IsTalento())
                        Enviar solicitud de aval al {{\App\User::IsTalento()}}
                        para {{$articulationStage->present()->articulationStageEndorsementApproval()}}
                    @else
                        @if(isset($ult_traceability->movimiento) && $ult_traceability->movimiento == \App\Models\Movimiento::IsAprobar() && $ult_traceability->rol == \App\User::IsDinamizador())
                            Enviar solicitud de aval al {{\App\User::IsTalento()}}
                            para {{$articulationStage->present()->articulationStageEndorsementApproval()}}
                        @else
                            El talento interlocutor dió el aval, enviar
                            solicitud de aval al dinamizador
                            para {{$articulationStage->present()->articulationStageEndorsementApproval()}}.
                        @endif
                    @endif
                </a>
            @elseif($articulationStage->status == \App\Models\ArticulationStage::STATUS_OPEN)
                <a href="{{route('articulation-stage.request-approval', [$articulationStage->id , 'cerrar' ])}}"
                    class="collection-item yellow lighten-3">
                    <i class="material-icons left">notifications</i>
                    @if($rol_destinatario == \App\User::IsTalento())
                        Enviar solicitud de aval al talento
                        para {{$articulationStage->present()->articulationStageEndorsementApproval()}}
                        esta {{__('articulation-stage')}}.
                    @else
                        @if(isset($ult_traceability->movimiento) && $ult_traceability->movimiento == \App\Models\Movimiento::IsAprobar() && $ult_traceability->rol == \App\User::IsDinamizador())
                            Enviar solicitud de aval al {{\App\User::IsTalento()}}
                            para {{$articulationStage->present()->articulationStageEndorsementApproval()}}
                        @else
                            El talento interlocutor dió el aval, enviar
                            solicitud de aval al dinamizador
                            para {{$articulationStage->present()->articulationStageEndorsementApproval()}}.
                        @endif
                    @endif
                </a>
            @endif
        @endcan
        @can('changeTalent', $articulationStage)
            <a href="{{ route('articulation-stage.changeinterlocutor', $articulationStage) }}"
               class="collection-item">
                <i class="material-icons left">group</i>
                Cambiar {{__('Interlocutory talent')}}
            </a>
        @endcan
        @can('update', $articulationStage)
            <a href="{{ route('articulation-stage.edit',$articulationStage) }}"
                class="collection-item">
                <i class="material-icons left">edit</i>
                Editar {{__('articulation-stage')}}
            </a>
        @endcan
        @can('changeState', $articulationStage)
        <a href="javascript:void(0)" class="collection-item"
            onclick="articulationStage.changeStateArticulationStage('{{$articulationStage->code}}')">
            <i class="material-icons left">autorenew</i>
            Cambiar estado
        </a>
        @endcan
        @can('downloadCertificateEnd', $articulationStage)
            <a target="_blank"
                href="{{ route('articulation-stage.download-certificate', [ 'cierre',$articulationStage]) }}"
                class="collection-item">
                <i class="material-icons left">cloud_download</i>
                Descargar resumen {{ __('articulation-stage') }}
            </a>
        @endcan
        @can('downloadCertificateStart', $articulationStage)
            <a target="_blank"
               href="{{ route('articulation-stage.download-certificate', ['inicio',$articulationStage]) }}"
               class="collection-item">
                <i class="material-icons left">cloud_download</i>
                Descargar acta inicio
            </a>
        @endcan
        @can('uploadEvidences', $articulationStage)
            <a href="{{ route('articulation-stage.evidences', [$articulationStage]) }}"
               class="collection-item">
                <i class="material-icons left">cloud_upload</i>
                Cargar evidencias
            </a>
        @endcan
        @can('delete', $articulationStage)
            <a href="javascript:void(0)" class="collection-item"
                onclick="articulationStage.destroyArticulationStage('{{$articulationStage->id}}')">
                <i class="material-icons left">delete_forever</i>
                Eliminar {{__('articulation-stage')}}
            </a>
        @endcan

    @endif
</div>
@endcanany

