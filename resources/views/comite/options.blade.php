<div class="collection with-header">
    <h5 href="!#" class="collection-header">Opciones</h5>
    @can('cargar_evidencias', $comite)
        <a href="{{route('csibt.evidencias', $comite->id)}}" class="collection-item">
            <i class="material-icons left">library_books</i>Cargar evidencias del comité.
        </a>
    @endcan
    @can('edit', $comite)
        <a href="{{route('csibt.edit', $comite->id)}}" class="collection-item">
            <i class="material-icons left">edit</i>Cambiar información.
        </a>
    @endcan
    @can('calificar', $comite)
        <a href="{{route('csibt.realizar', $comite->id)}}" class="collection-item">
            <i class="material-icons left">check</i>{{ $comite->estado->nombre == $comite->estado->IsProgramado() ? 'Calificar comité.' : 'Cambiar información'}}
        </a>
    @endcan
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
    @can('notificar_dinamizador', $comite)
    <a href="{{route('csibt.notificar.realizado', $comite->id)}}" class="collection-item">
        <i class="material-icons left">notifications</i>Notificar al dinamizador.
    </a>
    @endcan
    @can('asignar_ideas', $comite)
        <a href="{{route('csibt.asignar', $comite->id)}}" class="collection-item">
            <i class="material-icons left">edit</i>Asignar expertos a las ideas de proyecto.
        </a>
    @endcan
</div>
