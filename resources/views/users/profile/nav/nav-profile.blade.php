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
                <a href="{{{route('perfil.permisos')}}}">
                    <h4 class="mail-title">
                        Permisos Adicionales
                    </h4>
                    <p align="justify" class="hide-on-small-and-down mail-text">
                        En este apartado podrás ver los permisos adicionales que se te han asignado.
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
        </ul>

    </div>
</div>


