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
@can('downloadCertificateEnd', $articulation)
    <a target="_blank"
        href="{{ route('articulations.download-certificate', [ 'cierre',$articulation]) }}"
        class="collection-item">
        <i class="material-icons left">cloud_download</i>
        Descargar acta cierre
    </a>
@endcan
@can('downloadCertificateStart', $articulation)
    <a target="_blank"
        href="{{ route('articulations.download-certificate', ['inicio',$articulation]) }}"
        class="collection-item">
        <i class="material-icons left">cloud_download</i>
        Descargar acta inicio
    </a>
@endcan
@can('uploadEvidences', [$articulation, 'Inicio'])
    <a href="{{ route('articulations.evidences', [$articulation]) }}"
        class="collection-item">
        <i class="material-icons left">cloud_upload</i>
        Cargar evidencias
    </a>
@endcan
@can('uploadEvidences', [$articulation, 'Cierre'])
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
        Eliminar {{__('articulation')}}
    </a>
@endcan
