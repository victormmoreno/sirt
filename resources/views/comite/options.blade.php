<div class="collection with-header">
    <h5 href="!#" class="collection-header">Opciones</h5>
    <a href="{{route('csibt.evidencias', $comite->id)}}" class="collection-item">
        <i class="material-icons left">library_books</i>Evidencias del comité.
    </a>
    <a href="{{route('csibt.edit', $comite->id)}}" class="collection-item">
        <i class="material-icons left">edit</i>Cambiar información.
    </a>
    <a href="{{route('csibt.realizar', $comite->id)}}" class="collection-item">
        <i class="material-icons left">check</i>Calificar comité.
    </a>
    {{-- <h5 href="!#" class="collection-header">Opciones</h5> --}}
    @can('notificar_comite', [$comite, $comite->ideas()->first()])
        <h5 class="collection-header">
            <i class="material-icons left">notifications</i>Notificar comité
            <a class="modal-trigger" href="#modalInfoNotificacionComite"><i class="material-icons right">help</i></a>
        </h5>
        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, -1,'gestores'])}}" class="collection-item">
            <i class="material-icons left">notifications</i>Enviar citación a expertos.
        </a>
        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, -1,'talentos'])}}" class="collection-item">
            <i class="material-icons left">notifications</i>Enviar citación a talentos.
        </a>
        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, -1, 'todos'])}}" class="collection-item">
            <i class="material-icons left">notifications</i>Enviar citación a todos los participantes.
        </a>
    @endcan
</div>
