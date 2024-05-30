<a href="{{route('proyecto.cambiar.talentos', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">group</i>
    Cambiar talentos que desarrollan el proyecto.
</a>
@can('notificar_aprobacion', $proyecto)
    <a href="" class="collection-item orange-text" onclick="sendNotification('{{route('proyecto.solicitar.aprobacion', [$proyecto->id, -1])}}', '{{$proyecto->fase->nombre}}', {{$proyecto->prorrogas()->count()}}, event)">
        <i class="material-icons left">notifications</i>
        @if ($rol_destinatario == 'Talento')
            Enviar solicitud de aprobación de la fase de {{$proyecto->fase->nombre}} al talento.
        @else
            El talento interlocutor ya aprobó el cambio de fase, enviar solicitud de aprobación al dinamizador.
        @endif
    </a>
@elsecan('enviarEncuesta', [App\Models\EncuestaToken::class, $proyecto])
    <a href="" class="collection-item orange-text" onclick="sendTokenEncuesta('{{route('encuesta.link', ['proyecto', $proyecto->id])}}', '{{$proyecto->fase->nombre}}', event)">
        <i class="material-icons left">list</i>
        Enviar encuesta de percepción.
    </a>
@endcan