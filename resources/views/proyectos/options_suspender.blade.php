@if (\Session::get('login_role') == App\User::IsGestor())
    <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, App\Models\Proyecto::IsSuspendido()])}}" class="collection-item">
        <i class="material-icons left">notifications</i>
        Solicitar suspensión del proyecto al dinamizador.
    </a>
@endif