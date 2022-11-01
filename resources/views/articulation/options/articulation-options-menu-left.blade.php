<div class="collection with-header col s12 m4 l3">
    <h5 href="!#" class="collection-header">Opciones</h5>
        @if($articulation->phase->nombre == \App\Models\Articulation::IsInicio())
            <a href="{{route('articulations.show.phase', [$articulation, 'inicio'])}}"
               class="collection-item">
                <i class="material-icons left">edit</i>
                Editar fase de inicio
            </a>
        @endif
        @if($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion())
        <a href="{{route('articulations.show.phase', [$articulation, 'ejecucion'])}}"
           class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de ejecución
        </a>
        @endif
        @if($articulation->phase->nombre == \App\Models\Articulation::IsCierre())
        <a href="{{route('articulations.show.phase', [$articulation, 'cierre'])}}"
           class="collection-item">
            <i class="material-icons left">edit</i>
            Editar fase de cierre
        </a>
        @endif
        @can('changeTalent', $articulation)
            <a href="{{ route('articulation-stage.changeinterlocutor', $articulation) }}"
               class="collection-item">
                <i class="material-icons left">group</i>
                Cambiar {{__('Interlocutory talent')}}
            </a>
        @endcan
        @can('update', $articulation)
            <a href="{{ route('articulation-stage.edit',$articulation) }}"
               class="collection-item">
                <i class="material-icons left">edit</i>
                Editar {{__('articulation-stage')}}
            </a>
        @endcan
        @can('uploadEvidences', $articulation)
            <a href="{{ route('articulation-stage.evidences', [$articulation]) }}"
               class="collection-item">
                <i class="material-icons left">cloud_upload</i>
                Cargar evidencias
            </a>
        @endcan
</div>
