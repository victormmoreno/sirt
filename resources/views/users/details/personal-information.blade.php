<div class="mailbox-text">
    <div class="card-content">
        <span
            class="card-title primary-text center">Información básica</span>
        {!!$user->present()->userAcceso()!!}
        <div class="server-load row">
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->tipodocumento }}</p>
                <span>Tipo Documento</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->documento   }}</p>
                <span>Documento</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->nombres}}</p>
                <span>Nombres</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->apellidos}}</p>
                <span>Apellidos</span>
            </div>
            <div class="server-stat col s6 m8 l6">
                <p>{{"{$user->ciudad_expedicion} - {$user->departamento_expedicion}"}}</p>
                <span>Lugar Expedición documento </span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->present()->userFechaNacimiento()}} </p>
                <span>Fecha Nacimiento</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->gruposanguineo}}</p>
                <span>Grupo Sanguineo</span>
            </div>
            <div class="server-stat col s6 m8 l6">
                <p>{{$user->email}}</p>
                <span>Correo Electrónico </span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->estrato}} </p>
                <span>Estrato Social</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->etnia}}</p>
                <span>Etnia</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->telefono}} </p>
                <span>Telefóno</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->celular}}</p>
                <span>Celular</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->eps}}</p>
                <span>Eps</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                @if($user->eps == App\Models\Eps::OTRA_EPS)
                    <p>{{$user->otra_eps}}</p>
                @else
                    <p>No Aplica</p>
                @endif
                <span>Otra Eps</span>
            </div>
            <div class="server-stat col s6 m8 l6">
                <p>{{"{$user->ciudad_residencia} - {$user->departamento_residencia}"}}</p>
                <span>Lugar de Residencia</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->grado_discapacidad}}</p>
                <span>Algún grado de discapacidad</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                @if($user->grado_discapacidad == "SI")
                    <p>{{$user->descripcion_grado_discapacidad}}</p>
                @else
                    <p>No Aplica</p>
                @endif
                <span>¿Cúal grado de discapacidad?</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->barrio}}</p>
                <span>Barrio</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->direccion}}</p>
                <span>Dirección</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->mujer_cabeza_familia}}</p>
                <span>¿Madre Cabeza de familia?</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->desplazado_violencia}}</p>
                <span>¿Desplazado(a) por violencia?</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->present()->userGenero()}}</p>
                <span>Genero</span>
            </div>
        </div>
        <span class="card-title primary-text center">Último estudio y ocupaciones</span>
        <div class="server-load row">
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->present()->userInstitucion() }}</p>
                <span>Institución</span>
            </div>
            <div class="server-stat col s6 m4 l3">
                <p>{{$user->gradoescolaridad}}</p>
                <span>Grado Escolaridad</span>
            </div>
            <div class="server-stat col s6 m8 l6">
                <p>{{$user->ocupacions}}</p>
                <span>Ocupaciones</span>
            </div>
            <div class="server-stat col s6 m8 l6">
                <p>{{$user->present()->userTituloObtenido()}}</p>
                <span>Titulo Obtenido</span>
            </div>
            <div class="server-stat col s6 m8 l6">
                <p>{{$user->present()->userFechaTerminacion()}}</p>
                <span>Fecha Teminación</span>
            </div>
        </div>
        <span class="card-title primary-text center">Otros datos</span>
        <br>
        {!!$user->getInformationTalentBuilder()!!}
        {{-- {{var_dump($user->informacion_user)}} --}}
        {{-- @if($user->isUserDinamizador())
            <span class="primary-text">Información Dinamizador</span>
            <div class="server-load row">
                <div class="server-stat col s12 m6 l6">
                    <p></p>
                    <span>Nodo</span>
                </div>
            </div>
        @endif --}}

        {{-- @if($user->isUserExperto() || $user->isUserArticulador())
            @if($user->isUserExperto())
                <span
                    class="secondary-text">Información {{App\User::IsExperto()}}</span>
            @else
                <span
                    class="secondary-text">Información {{App\User::IsArticulador()}}</span>
            @endif
            <div class="server-load row">
                @if($user->isUserExperto())
                    <div class="server-stat col s12 m4 l4">
                        <p></p>
                        <span>Linea</span>
                    </div>

                    <div class="server-stat col s12 m4 l4">
                        <p></p>
                        <span>Honorario</span>
                    </div>
                @else
                    <div class="server-stat col s12 m4 l4">
                        <p></p>
                        <span>Nodo</span>
                    </div>
                @endif
            </div>
        @endif
        @if($user->isUserInfocenter())

            <span
                class="secondary-text">Información {{App\User::IsInfocenter()}}</span>
            <div class="server-load row">
                <div class="server-stat col s12 m6 l6">
                    <p></p>
                    <span>Nodo</span>
                </div>
                <div class="server-stat col s12 m6 l6">
                    <p></p>
                    <span>Extensión</span>
                </div>
            </div>
        @endif
        @if($user->isUserIngreso())
            <span
                class="secondary-text">Información {{App\User::IsIngreso()}}</span>
            <div class="server-load row">
                <div class="server-stat col s12 m6 l6">
                    <p></p>
                    <span>Nodo</span>
                </div>
            </div>
        @endif --}}

    </div>

</div>
