@if (\Session::get('login_role') == App\User::IsGestor())
    <a href="{{route('pdf.proyecto.inicio', $proyecto->id)}}" target="_blank" class="collection-item">
        <i class="material-icons left">file_download</i>Generar acta de inicio.
    </a>
    <a href="{{route('pdf.proyecto.acta.inicio', $proyecto->id)}}" target="_blank" class="collection-item">
        <i class="material-icons left">file_download</i>
        Generar acta de categorización.
    </a>
    <a href="{{route('proyecto.entregables.inicio', $proyecto->id)}}" class="collection-item">
        <i class="material-icons left">library_books</i>
        Adjuntar entregables de la fase de inicio.
    </a>
    <a href="{{route('proyecto.form.inicio', $proyecto->id)}}" class="collection-item">
        <i class="material-icons left">edit</i>
        Cambiar información de la fase de inicio.
    </a>
    @if ($proyecto->present()->proyectoFase() == App\Models\Proyecto::IsInicio())
    <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, 'Inicio'])}}" class="collection-item">
        <i class="material-icons left">notifications</i>
        Enviar solicitud de aprobación al talento interlocutor.
    </a>
    @endif
@endif

{{-- <div class="col s12 m4 l4 center">
    @if ($proyecto->present()->proyectoFase() == 'Inicio')
    @if ($ultimo_movimiento == null || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsCambiar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsReversar())
        <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, 'Inicio'])}}">
        <div class="card-panel yellow accent-1 black-text">
            Enviar solicitud de aprobación al talento interlocutor.
        </div>
        </a>
    @else
        @if ($ultimo_movimiento->movimiento == App\Models\Movimiento::IsSolicitarTalento())
        <a disabled>
            <div class="card-panel yellow accent-1 black-text">
            Se envió la solicitud de aprobación al talento interlocutor.
            </div>
        </a>
        @endif
        @if($ultimo_movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->rol == App\User::IsTalento())
        <a disabled>
            <div class="card-panel yellow accent-1 black-text">
            El talento interlocutor aprobó la fase de Inicio, aún falta la aprobación del dinamizador.
            </div>
        </a>
        @endif
    @endif
    @else
    <a disabled>
        <div class="card-panel yellow accent-1 black-text">
        Este proyecto no se encuentra en fase de inicio.
        </div>
    </a>
    @endif
    </div> --}}