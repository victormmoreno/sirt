<div class="col s12 m3 l3">
    <ul class="collection with-header">
        <h5 class="collection-header">Opciones</h5>
        @can('edit', $empresa)
            <a class="collection-item" href="{{ route('empresa.edit', $empresa->id) }}">
                <i class="material-icons left">edit</i>
                Cambiar información de la empresa.
            </a>
            <a class="collection-item" href="{{ route('empresa.responsable', $empresa->id) }}">
                <i class="material-icons left">edit</i>
                Cambiar responsable de la empresa.
            </a>
            <a class="collection-item" href="{{ route('empresa.add.sede', $empresa->id) }}">
                <i class="material-icons left">add</i>
                Agregar una nueva sede para el empresa.
            </a>
        @endcan
    </ul>
</div>