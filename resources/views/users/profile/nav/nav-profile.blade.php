<div class="col s12 m12 l12">
    <div class="mailbox-list">
        <ul>
            <li>
                <a href="{{{route('perfil.index')}}}">
                    <h4 class="mail-title">
                        Información Personal
                    </h4>
                    <p align="justify" class="hide-on-small-and-down mail-text">
                        En este apartado podrás ver y actualizar tu información personal.
                    </p>
                </a>
            </li>
            <li>
                <a href="{{{route('perfil.roles')}}}">
                    <h4 class="mail-title">
                        Roles
                    </h4>
                    <p align="justify" class="hide-on-small-and-down mail-text">
                        En este apartado podrás ver los roles asignados.
                    </p>
                </a>
            </li>
            <li>
                <a href="{{{route('perfil.cuenta')}}}">
                    <h4 class="mail-title">
                        Cambiar Contraseña
                    </h4>
                    <p align="justify" class="hide-on-small-and-down mail-text">
                        En este apartado podrás ver los permisos cambiar tu contraseña de ingreso a la plataforma {{config('app.name')}}
                    </p>
                </a>
            </li>
            @if(\Session::get('login_role') == App\User::IsTalento() || \Session::get('login_role') == App\User::IsGestor())
            <li>
                <a href="{{{route('perfil.actividades')}}}">
                    <h4 class="mail-title">
                        Mis Actividades
                    </h4>
                    <p align="justify" class="hide-on-small-and-down mail-text">
                        En este apartado podrás ver los proyectos y articulaciones trabajados en la {{config('app.name')}}
                    </p>
                </a>
            </li>
            @endif
        </ul>

    </div>
</div>


