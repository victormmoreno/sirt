@extends('layouts.app')
@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">supervised_user_circle</i>Usuarios | Perfil
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Perfil</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card mailbox-content">
                                <div class="card-content">
                                    <div class="row no-m-t no-m-b">
                                        <div class="col s12 m5 l3">
                                            <div class="row">
                                                @include('users.profile.nav.nav-profile')
                                            </div>

                                        </div>
                                        <div class="col s12 m7 l9">
                                            @include('users.profile.nav.navbar')
                                            <div class="mailbox-view">
                                                <div class="mailbox-view-header">
                                                    @include('users.profile.nav.header')
                                                    <div class="right mailbox-buttons">
                                                    <span class="mailbox-title primary-text">
                                                        <p class="center">
                                                            Información Personal
                                                            <div class="right">
                                                                <a class="waves-effect waves-light btn bg-secondary m-t-xs dropdown-button "
                                                                   data-activates="actifiad" href="#">
                                                                    <i class="material-icons right">
                                                                        more_vert
                                                                    </i>
                                                                    Más Información
                                                                </a>
                                                                <!-- Dropdown Structure -->
                                                                <ul class="dropdown-content" id="actifiad">
                                                                    <li>
                                                                        <a href="{{route('perfil.edit')}}">
                                                                            Cambiar Información
                                                                        </a>
                                                                    </li>

                                                                    @if(collect($user->getRoleNames())->contains(App\User::IsTalento()))
                                                                        <li class="divider">
                                                                    </li>
                                                                        <li>
                                                                        <a href="{{route('certificado')}}"
                                                                           target="_blank">
                                                                            Obtener certificado de registro en el sistema
                                                                        </a>
                                                                    </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </p>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <small>
                                                        {{{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}}
                                                    </small>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="mailbox-text">
                                                    <div class="card-content">
                                                        <span
                                                            class="card-title primary-text center">Información básica</span>
                                                        <span
                                                            class="badge green lighten-1 white-text">{{$user->present()->userAcceso()}}</span>
                                                        <div class="server-load row">
                                                            <div class="server-stat col s6 m4 l3">
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
                                                            <span class="primary-text">Información Dinamizador</span>
                                                            <div class="server-load row">
                                                                <div class="server-stat col s12 m6 l6">
                                                                    <p>{{$user->present()->userDinamizadorNombreNodo()}}</p>
                                                                    <span>Nodo</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($user->isUserExperto() || $user->isUserArticulador())
                                                            @if($user->isUserExperto())
                                                                <span
                                                                    class="secondary-text">Información {{App\User::IsGestor()}}</span>
                                                            @else
                                                                <span
                                                                    class="secondary-text">Información {{App\User::IsArticulador()}}</span>
                                                            @endif
                                                            <div class="server-load row">
                                                                @if($user->isUserExperto())
                                                                    <div class="server-stat col s12 m4 l4">
                                                                        <p>{{$user->present()->userGestorNombreLinea()}}</p>
                                                                        <span>Linea</span>
                                                                    </div>

                                                                    <div class="server-stat col s12 m4 l4">
                                                                        <p>{{$user->present()->userGestorHonorarios()}}</p>
                                                                        <span>Honorario</span>
                                                                    </div>
                                                                @else
                                                                    <div class="server-stat col s12 m4 l4">
                                                                        <p>{{$user->present()->userArticuladorName()}}</p>
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
                                                            <span
                                                                class="secondary-text">Información {{App\User::IsIngreso()}}</span>
                                                            <div class="server-load row">
                                                                <div class="server-stat col s12 m6 l6">
                                                                    <p>{{$user->present()->userIngresoNombreNodo()}}</p>
                                                                    <span>Nodo</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($user->isUserTalento())
                                                            <span
                                                                class="secondary-text">Información {{App\User::IsTalento()}}</span>
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
                                                    </div>
                                                    <div class="divider mailbox-divider">
                                                    </div>
                                                    <div class="right">
                                                        <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs"
                                                           href="{{route('perfil.edit')}}">
                                                            Cambiar Información Personal
                                                        </a>
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
            </div>
        </div>
    </main>
@endsection
