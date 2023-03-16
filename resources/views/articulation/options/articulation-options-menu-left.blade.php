@canany(['showButtonAprobacion', 'requestApproval', 'showStart', 'showExecution', 'showClosing', 'changeTalents'], $articulation)
<div class="collection with-header col s12 m4 l3">
    <h5 href="!#" class="collection-header">Opciones</h5>
    @can('showButtonAprobacion', $articulation)
        @include('articulation.form.approval-articulation-form')
    @endcan
    @can('requestApproval', $articulation)
            <a href="{{route('articulation.request-approval', $articulation)}}"
                class="collection-item yellow lighten-3">
                <i class="material-icons left">notifications</i>
                @if($rol_destinatario == \App\User::IsDinamizador())
                    Enviar solicitud de aval al {{\App\User::IsDinamizador()}}
                    para finalizar
                @else
                    @if(isset($ult_traceability->movimiento)  && $ult_traceability->rol == \App\User::IsDinamizador())
                        Enviar solicitud de aval al {{\App\User::IsDinamizador()}}
                        para finalizar
                    @else
                        El dinamizador ya dio el aval
                    @endif
                @endif
            </a>
    @endcan
    @can('showStart', $articulation)
        <a href="{{route('articulations.show.phase', [$articulation, 'inicio'])}}"
            class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de inicio
        </a>
    @endcan
    @can('showExecution', $articulation)
        <a href="{{route('articulations.show.phase', [$articulation, 'ejecucion'])}}"
            class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de ejecución
        </a>
    @endcan
    @can('showClosing', $articulation)
        <a href="{{route('articulations.show.phase', [$articulation, 'cierre'])}}"
            class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de cierre
        </a>
    @endcan
    @can('changeTalents', $articulation)
        <a href="{{ route('articulations.changetalents', $articulation) }}"
            class="collection-item">
            <i class="material-icons left">group</i>
            Cambiar participantes
        </a>
    @endcan
    @can('uploadEvidences', [$articulation, 'Inicio'])
            <a href="{{ route('articulations.evidences', [$articulation]) }}"
               class="collection-item">
                <i class="material-icons left">cloud_upload</i>
                Cargar evidencias
            </a>
    @endcan
    @can('delete', $articulation)
        <a href="javascript:void(0)" class="collection-item"
            onclick="filter_articulations.destroyArticulation('{{$articulation->id}}')">
            <i class="material-icons left">delete_forever</i>
            Eliminar {{__('articulation-stage')}}
        </a>
    @endcan
</div>
@endcanany
