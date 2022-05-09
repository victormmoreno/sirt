@if (Session::get('login_role') == App\User::IsGestor() || Session::get('login_role') == App\User::IsDinamizador())
    <a href="{{route('proyecto.suspender', $proyecto->id)}}" class="collection-item">
        <i class="material-icons left">priority_high</i>
        Suspender proyecto.
    </a>
    @if (Session::get('login_role') == App\User::IsDinamizador())
        <a href="{{route('proyecto.cambiar', $proyecto->id)}}" class="collection-item">
            <i class="material-icons left">group</i>
            Cambiar el experto del proyecto.
        </a>
        <a type="submit" onclick="preguntaReversar(event)" value="send" class="collection-item">
            <form action="{{route('proyecto.reversar', [$proyecto->id, 'Inicio'])}}" method="POST" name="frmReversarFase">
            {!! method_field('PUT')!!}
            @csrf
                <i class="material-icons left">settings_backup_restore</i>
                Reversar proyecto a fase de inicio.
            </form>
        </a>
    @endif
    @if (Session::get('login_role') == App\User::IsGestor())
        <a href="{{route('proyecto.cambiar.talentos', $proyecto->id)}}" class="collection-item">
            <i class="material-icons left">group</i>
            Cambiar talentos que desarrollan el proyecto.
        </a>
        <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, -1])}}" class="collection-item">
            <i class="material-icons left">notifications</i>
            @if ($rol_destinatario == 'Talento')
                Enviar solicitud de aprobación de la fase de {{$proyecto->fase->nombre}} al talento.
            @else
                El talento interlocutor ya aprobó el cambio de fase, enviar solicitud de aprobación al dinamizador.
            @endif
        </a>
    @endif
@endif