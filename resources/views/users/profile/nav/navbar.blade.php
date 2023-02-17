<div class="mailbox-options">
    <ul>
        <li>
            <a href="{{{route('perfil.index')}}}">
                Información Personal
            </a>
        </li>
        <li>
            <a href="{{{route('perfil.roles')}}}">
                Roles
            </a>
        </li>
        <li>
            <a href="{{{route('perfil.cuenta')}}}">
                Cambiar Contraseña
            </a>
        </li>
        @if(\Session::get('login_role') == App\User::IsTalento() || \Session::get('login_role') == App\User::IsExperto())
        <li>
            <a href="{{{route('perfil.actividades')}}}">
                Mis Actividades
            </a>
        </li>
        @endif
    </ul>
</div>
