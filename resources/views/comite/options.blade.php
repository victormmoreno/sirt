<div class="row">
    <div class="col s12 m12 l12 center">
        <a href="{{route('csibt.evidencias', $comite->id)}}">
            <div class="card-panel blue-grey white-text">
            <i class="material-icons left">library_books</i>Evidencias del comité.
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <a href="{{route('csibt.edit', $comite->id)}}">
            <div class="card-panel yellow lighten-3 black-text center">
                <i class="material-icons left">edit</i>Cambiar información.
            </div>
        </a>
    </div>
    <div class="col s12 m6 l6">
        <a href="{{route('csibt.realizar', $comite->id)}}">
            <div class="card-panel green lighten-3 black-text center">
                <i class="material-icons left">check</i>Calificar comité.
            </div>
        </a>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m4 l4 offset-l4">
        <h5 class="center">
            <i class="material-icons left">notifications</i>Notificar comité
            <a class="modal-trigger" href="#modalInfoNotificacionComite"><i class="material-icons right">help</i></a>
        </h5>

    </div>
</div>
<div class="row">
    <div class="col s12 m4 l4">
        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, -1,'gestores'])}}">
            <div class="card-panel blue-grey lighten-3 black-text center">
                <i class="material-icons left">notifications</i>Enviar citación a expertos.
            </div>
        </a>
    </div>
    <div class="col s12 m4 l4">
        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, -1,'talentos'])}}">
            <div class="card-panel blue-grey lighten-3 black-text center">
                <i class="material-icons left">notifications</i>Enviar citación a talentos.
            </div>
        </a>
    </div>
    <div class="col s12 m4 l4">
        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, -1, 'todos'])}}">
            <div class="card-panel blue-grey lighten-3 black-text center">
                <i class="material-icons left">notifications</i>Enviar citación a todos los participantes.
            </div>
        </a>
    </div>
</div>