<div class="col s12 m3 l3">
    <ul class="collection with-header">
        <li class="collection-header"><h5>Opciones</h5></li>
        <li class="collection-item">
            <a href="{{ route('empresa.edit', $empresa->id) }}">
            <div class="card-panel teal lighten-2 black-text center">
                Cambiar información de la empresa.
            </div>
            </a>
        </li>
        <li class="collection-item">
            <a href="{{ route('empresa.responsable', $empresa->id) }}">
            <div class="card-panel cyan lighten-2 black-text center">
                Cambiar responsable de la empresa.
            </div>
            </a>
        </li>
        <li class="collection-item">
            <a href="{{ route('empresa.add.sede', $empresa->id) }}">
            <div class="card-panel blue lighten-2 black-text center">
                Agregar una nueva sede para el empresa.
            </div>
            </a>
        </li>
    </ul>
</div>