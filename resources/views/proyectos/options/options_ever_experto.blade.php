<a href="{{route('proyecto.cambiar.talentos', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">group</i>
    Cambiar talentos que desarrollan el proyecto.
</a>
@can('showNotificationButton', $proyecto)
    <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, -1])}}" class="collection-item yellow lighten-3">
        <i class="material-icons left">notifications</i>
        @if ($rol_destinatario == 'Talento')
            Enviar solicitud de aprobación de la fase de {{$proyecto->fase->nombre}} al talento.
        @else
            El talento interlocutor ya aprobó el cambio de fase, enviar solicitud de aprobación al dinamizador.
        @endif
    </a>
@endcan