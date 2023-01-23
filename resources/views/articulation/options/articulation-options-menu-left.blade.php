<div class="collection with-header col s12 m4 l3">
    <h5 href="!#" class="collection-header">Opciones</h5>
    @can('showButtonAprobacion', $articulation)
        @include('articulation.form.approval-articulation-form')
    @endcan
    @if($articulation->phase_id == 4)
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
    @endif
    @if($articulation->phase_id == 1)
    @can('showStart', $articulation)
        <a href="{{route('articulations.show.phase', [$articulation, 'inicio'])}}"
            class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de inicio
        </a>
    @endcan
    @endif
    @if($articulation->phase_id == 3)
    @can('showExecution', $articulation)
        <a href="{{route('articulations.show.phase', [$articulation, 'ejecucion'])}}"
            class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de ejecución
        </a>
    @endcan
    @endif
    @if($articulation->phase_id == 4)
    @can('showClosing', $articulation)
        <a href="{{route('articulations.show.phase', [$articulation, 'cierre'])}}"
            class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de cierre
        </a>
    @endcan
    @endif
    @can('changeTalents', $articulation)
        <a href="{{ route('articulations.changetalents', $articulation) }}"
            class="collection-item">
            <i class="material-icons left">group</i>
            Cambiar participantes
        </a>
    @endcan
</div>
