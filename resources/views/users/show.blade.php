@extends('layouts.app')
@section('meta-title', 'Usuario | ' . $user->present()->userFullName())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('usuario.index')}}">
                        <i class="material-icons left">arrow_back</i>
                    </a>Usuarios
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                    <li class="active">Detalle</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-view">
                                    <div class="mailbox-view-header">
                                        <div class="left mailbox-buttons">
                                            {!!$user->present()->userProfileUserImage()!!}
                                        </div>
                                        <div class="left">
                                            <p class="m-t-lg flow-text secondary-text">{{$user->present()->userFullName()}}</p>
                                            <span class="mailbox-title">{{$user->present()->userYearOld()}}</span>
                                            @foreach($user->getRoleNames() as $value)
                                            <div class="chip m-t-sm blue-grey white-text"> {{$value}}</div>
                                            @endforeach
                                            <div class="position-top-right p f-12 mail-date show-on-large hide-on-med-and-down">Miembro desde {{$user->present()->userCreatedAtFormat()}}</div>
                                        </div>
                                        <div class="right mailbox-buttons">
                                            @if($user->documento != auth()->user()->documento)
                                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsAdministrador()))
                                                    <a href="{{route('usuario.usuarios.acceso', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar Acceso</a>
                                                    <a href="{{route('user.newpassword', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Generar nueva contraseña</a>

                                                    <a class='dropdown-button btn waves-effect secondary-text btn-flat m-t-xs' href='#' data-activates='dropdown-actions'>Cambiar información</a>

                                                    <ul id='dropdown-actions' class='dropdown-content'>
                                                        <li><a href="{{route('usuario.usuarios.edit', $user->present()->userDocumento())}}">Cambiar Información personal</a></li>
                                                        <li class="divider"></li>
                                                        <li><a  href="{{route('usuario.usuarios.changenode', $user->present()->userDocumento())}}">Cambiar Roles y Nodos</a></li>
                                                    </ul>
                                                @endif
                                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && !$user->hasAnyRole([App\User::IsDinamizador(), App\User::IsActivador() ]))
                                                    <a href="{{route('usuario.usuarios.acceso', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar Acceso</a>
                                                    <a href="{{route('user.newpassword', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Generar nueva contraseña</a>
                                                    <a class='dropdown-button btn waves-effect secondary-text btn-flat m-t-xs' href='#' data-activates='dropdown-actions'>Cambiar información</a>
                                                    <!-- Dropdown Structure -->
                                                    <ul id='dropdown-actions' class='dropdown-content'>
                                                        <li><a href="{{route('usuario.usuarios.edit', $user->present()->userDocumento())}}">Cambiar Información personal</a></li>
                                                        <li class="divider"></li>
                                                        <li><a  href="{{route('usuario.usuarios.changenode', $user->present()->userDocumento())}}">Cambiar Roles y Nodos</a></li>
                                                    </ul>
                                                @endif
                                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsArticulador()) && !$user->present()->userChangeAccess())
                                                    <a href="{{route('usuario.usuarios.acceso', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar Acceso</a>
                                                    <a href="{{route('user.newpassword', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Generar nueva contraseña</a>
                                                    <a href="{{route('usuario.usuarios.edit', $user->present()->userDocumento())}}" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar información</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        @if(session()->has('status') || session()->has('error'))
                                            <div class="center">
                                                <div class="card  {{session('status') ? 'green': ''}} {{session('error') ? 'red': ''}}  darken-1">
                                                    <div class="row">
                                                        <div class="col s12 m10">
                                                            <div class="card-content white-text">
                                                                <p>
                                                                    <i class="material-icons left">info_outline</i>
                                                                    {{session('status') ? : session('error')}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                        <div class="card-content">
                                            <span class="card-title primary-text center">Información básica</span>
                                            <span class="badge green lighten-1 white-text">{{$user->present()->userAcceso()}}</span>
                                            <div class="server-load row">
                                                <div class="server-stat col s12 m4 l3">
                                                    <p>{{$user->present()->userTipoDocuento() }}</p>
                                                    <span>Tipo Documento</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userDocumento()}}</p>
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
                                                    <p>{{$user->present()->userLugarExpedicionDocumento() }}</p>
                                                    <span>Lugar Expedición documento </span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userFechaNacimiento()}} </p>
                                                    <span>Fecha Nacimiento</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userGrupoSanguineo()}}</p>
                                                    <span>Grupo Sanguineo</span>
                                                </div>
                                                <div class="server-stat col s6 m8 l6">
                                                    <p>{{$user->present()->userEmail()}}</p>
                                                    <span>Correo Electrónico </span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userEstrato()}} </p>
                                                    <span>Estrato Social</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userEtnia()}}</p>
                                                    <span>Etnia</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userTelefono()}} </p>
                                                    <span>Telefóno</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userCelular()}}</p>
                                                    <span>Celular</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userEps()}}</p>
                                                    <span>Eps</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    @if($user->eps->nombre == App\Models\Eps::OTRA_EPS)
                                                        <p>{{$user->present()->userOtraEps()}}</p>
                                                    @else
                                                        <p>No Aplica</p>
                                                    @endif
                                                    <span>Otra Eps</span>
                                                </div>
                                                <div class="server-stat col s6 m8 l6">
                                                    <p>{{$user->present()->userLugarResidencia()}}</p>
                                                    <span>Lugar de Residencia</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userGradoDiscapacidad()}}</p>
                                                    <span>Algún grado de discapacidad</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    @if($user->grado_discapacidad == 1)
                                                        <p>{{$user->present()->userDescripcionGradoDiscapacidad()}}</p>
                                                    @else
                                                        <p>No Aplica</p>
                                                    @endif
                                                    <span>¿Cúal grado de discapacidad?</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userBarrio()}}</p>
                                                    <span>Barrio</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userDireccion()}}</p>
                                                    <span>Dirección</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userMujerCabezaFamilia()}}</p>
                                                    <span>¿Madre Cabeza de familia?</span>
                                                </div>
                                                <div class="server-stat col s6 m4 l3">
                                                    <p>{{$user->present()->userDesplazadoPorViolencia()}}</p>
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
                                                    <p>{{$user->present()->userGradoEscolaridad()}}</p>
                                                    <span>Grado Escolaridad</span>
                                                </div>
                                                <div class="server-stat col s6 m8 l6">
                                                    <p>{{$user->present()->userOcupacionesNames()}}</p>
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
                                            @if($user->isUserDinamizador())
                                                <span class="secondary-text">Información {{App\User::IsDinamizador()}}</span>
                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m6 l6">
                                                        <p>{{$user->present()->userDinamizadorNombreNodo()}}</p>
                                                        <span>Nodo</span>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($user->isUserExperto())
                                                <span class="secondary-text">Información {{App\User::IsExperto()}}</span>

                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userGestorNombreNodo()}}</p>
                                                        <span>Nodo</span>
                                                    </div>

                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userGestorNombreLinea()}}</p>
                                                        <span>Linea</span>
                                                    </div>

                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userGestorHonorarios()}}</p>
                                                        <span>Honorario</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->isUserInfocenter())

                                                <span class="secondary-text">Información {{App\User::IsInfocenter()}}</span>
                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m6 l6">
                                                        <p>{{$user->present()->userInfocenterNombreNodo()}}</p>
                                                        <span>Nodo</span>
                                                    </div>
                                                    <div class="server-stat col s12 m6 l6">
                                                        <p>{{$user->present()->userInfocenterExtension()}}</p>
                                                        <span>Extensión</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->isUserIngreso())
                                                <span class="secondary-text">Información {{App\User::IsIngreso()}}</span>
                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m6 l6">
                                                        <p>{{$user->present()->userIngresoNombreNodo()}}</p>
                                                        <span>Nodo</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->isUserTalento())
                                                <span class="secondary-text">Información {{App\User::IsTalento()}}</span>
                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m6 l6">
                                                        <p>{{$user->present()->userNombreTipoTalento()}}</p>
                                                        <span>Tipo {{App\User::IsTalento()}}</span>
                                                    </div>
                                                    <div class="server-stat col s12 m6 l6">
                                                        <p>{{$user->present()->userTipoTalento()}}</p>
                                                        <span>Otra información {{App\User::IsTalento()}}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->isUserApoyoTecnico())
                                            <span class="secondary-text">Información {{App\User::IsApoyoTecnico()}}</span>
                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userApoyoTecnicoNodoName()}}</p>
                                                        <span>Nodo</span>
                                                    </div>
                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userApoyoTecnicoHonorarios()}}</p>
                                                        <span>Honorario</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->isUserArticulador())
                                            <span class="orange-text">Información {{App\User::IsArticulador()}}</span>
                                                <div class="server-load row">
                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userArticuladorName()}}</p>
                                                        <span>Nodo</span>
                                                    </div>
                                                    <div class="server-stat col s12 m4 l4">
                                                        <p>{{$user->present()->userArticuladorHonorarios()}}</p>
                                                        <span>Honorario</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
