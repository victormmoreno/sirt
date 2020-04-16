@extends('layouts.app')

@section('meta-title', 'Usuario |' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Usuario | {{$user->nombres}} {{$user->apellidos}}
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m5 l3">

                                        <div class="row">
                                            @if(isset($user->dinamizador) && collect($user->getRoleNames())->contains(App\User::IsDinamizador()))
                                            <div class="right zurich-bt-fonts green-complement-text">
                                                <small>
                                                    Información Dinamizador
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m12 l12 ">
                                                    <ul class="collection">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle teal darken-2">
                                                                assignment_ind
                                                            </i>
                                                            <span class="title">
                                                                Nodo del Dinamizador
                                                            </span>
                                                            <p>
                                                                Tecnoparque Nodo {{$user->dinamizador->nodo->entidad->nombre ? : 'No registra'}}
                                                                <br>
                                                                    <small>
                                                                        <b>
                                                                            Dirección:
                                                                        </b>
                                                                        {{$user->dinamizador->nodo->direccion ? : 'No registra'}}
                                                                    </small>
                                                                </br>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if(isset($user->gestor) && collect($user->getRoleNames())->contains(App\User::IsGestor()))
                                            <div class="right zurich-bt-fonts green-complement-text">
                                                <small>
                                                    Información {{App\User::IsGestor()}}
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m12 l12 ">
                                                    <ul class="collection">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle teal darken-2">
                                                                assignment_ind
                                                            </i>
                                                            <span class="title">
                                                                <b class="teal-text darken-2">
                                                                    Nodo del {{App\User::IsGestor()}}:
                                                                </b>
                                                                Tecnoparque Nodo {{$user->gestor->nodo->entidad->nombre}}
                                                                <br>
                                                                    <b class="teal-text darken-2">
                                                                        Linea del {{App\User::IsGestor()}}:
                                                                    </b>
                                                                    {{$user->gestor->lineatecnologica->nombre}}
                                                                    <br>
                                                                        <b class="teal-text darken-2">
                                                                            Honorario del {{App\User::IsGestor()}}:
                                                                        </b>
                                                                        ${{ number_format($user->gestor->honorarios,0) ? : 'No registra'}}
                                                                    </br>
                                                                </br>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if(isset($user->infocenter) && collect($user->getRoleNames())->contains(App\User::IsInfocenter()))
                                            <div class="right zurich-bt-fonts green-complement-text">
                                                <small><b>
                                                    Información {{App\User::IsInfocenter()}}
                                                </b>
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m12 l12 ">
                                                    <ul class="collection">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle teal darken-2">
                                                                assignment_ind
                                                            </i>
                                                            <span class="title">
                                                                <b class="teal-text darken-2">
                                                                    Nodo del {{App\User::IsInfocenter()}}:
                                                                </b>
                                                                Tecnoparque Nodo {{$user->infocenter->nodo->entidad->nombre ? : 'No registra'}}
                                                                <br>
                                                                    <b class="teal-text darken-2">
                                                                        Extensión del {{App\User::IsInfocenter()}}:
                                                                    </b>
                                                                    {{$user->infocenter->extension ? : 'No registra'}}
                                                                    <br>
                                                                    </br>
                                                                </br>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col s12 m7 l9">
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                @include('users.settings.nav.header')
                                                @if(isset($user)  && auth()->user()->id != $user->id && session()->has('login_role') && session()->get('login_role') != App\User::IsInfocenter())
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">
                                                            Información Personal
                                                            <div class="right">
                                                                <a class="waves-effect waves-light btn m-t-xs dropdown-button " data-activates="actifiad" href="#">
                                                                    <i class="material-icons right">
                                                                        more_vert
                                                                    </i>
                                                                    Más Información
                                                                </a>
                                                                <!-- Dropdown Structure -->
                                                                <ul class="dropdown-content" id="actifiad">
                                                                    <li>
                                                                        <a href="{{route('usuario.usuarios.edit', $user->documento)}}">
                                                                            Cambiar Información
                                                                        </a>
                                                                    </li>
                                                                    @if(isset($user)  && $user->hasAnyRole([App\User::IsAdministrador(), App\User::IsDinamizador(),App\User::IsTalento()]) && session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())

                                                                    @elseif(isset($user)  && $user->hasAnyRole([App\User::IsAdministrador(), App\User::IsDinamizador(), App\User::IsGestor(),App\User::IsInfocenter(), App\User::IsIngreso() ]) && session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())

                                                                    @else

                                                                    <li>
                                                                        <a href="{{route('usuario.usuarios.acceso', $user->documento)}}">
                                                                            Acceso a plataforma
                                                                        </a>
                                                                    </li>
                                                                    @endif


                                                                </ul>
                                                            </div>
                                                        </p>
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="right">
                                                <small>
                                                    {{{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}}
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    credit_card
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Tipo Documento
                                                                </span>
                                                                <p>
                                                                    {{$user->tipodocumento->nombre ? : 'No se encontraron resultados' }}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Lugar Expedición documento
                                                                </span>
                                                                <p>
                                                                    {{$user->ciudadexpedicion->nombre ? : 'No se encontraron resultados' }} -
                                                                    {{$user->ciudadexpedicion->departamento->nombre ? : 'No se encontraron resultados' }}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    calendar_today
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Fecha de Nacimiento
                                                                </span>
                                                                <p>
                                                                    @if(isset($user->fechanacimiento))
                                                                    {{optional($user->fechanacimiento)->isoFormat('LL')}}
                                                                    @else
                                                                        No registra
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    account_balance_wallet
                                                                </i>
                                                                <div class="left">
                                                                    <span class="title green-complement-text">
                                                                        Eps
                                                                    </span>
                                                                    <p>
                                                                        {{$user->eps->nombre ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                                @if($user->eps->nombre == App\Models\Eps::OTRA_EPS)
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                        {{$user->otra_eps ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </li>
                                                            <li class="collection-item avatar">

                                                                <div class="left">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        contact_phone
                                                                    </i>
                                                                    <p>
                                                                        <span class="title green-complement-text">
                                                                            Grado Discapaciadad
                                                                        </span>
                                                                        <br>
                                                                            {{$user->grado_discapacidad == 1 ? 'Si' : 'No'}}
                                                                        </br>
                                                                    </p>
                                                                </div>
                                                                @if($user->grado_discapacidad == 1)
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                        {{$user->descripcion_grado_discapacidad ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </li>

                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    mail_outline
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Correo Electrónico
                                                                </span>
                                                                <p>
                                                                    {{$user->email ?: 'No registra'}}
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    contacts
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Documento
                                                                </span>
                                                                <p>
                                                                    {{$user->documento ? : 'No registra'}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    details
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Grupo Sanguineo
                                                                </span>
                                                                <p>
                                                                    {{$user->grupoSanguineo->nombre ? : 'No registra'}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    insert_chart
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Estrato Social
                                                                </span>
                                                                <p>
                                                                    {{$user->estrato ? : 'No registra'}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Etnia
                                                                </span>
                                                                <p>
                                                                    @if(isset($user->etnia))
                                                                    {{$user->etnia->nombre ? : 'No registra'}}
                                                                    @else
                                                                        No Registra
                                                                    @endif
                                                                </p>
                                                            </li>

                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    my_location
                                                                </i>


                                                                <div class="left">
                                                                    <span class="title green-complement-text">
                                                                        Lugar de Residencia
                                                                    </span>

                                                                    <p>
                                                                        {{$user->direccion ? : 'No registra'}}
                                                                    </p>
                                                                    <p>
                                                                        {{$user->ciudad->nombre ? : 'No registra'}} - {{$user->ciudad->departamento->nombre ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Barrio
                                                                    </span>
                                                                    <p>
                                                                        {{$user->barrio ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <div class="center">
                                                                    <span class="title green-complement-text">
                                                                        Datos contacto
                                                                    </span>
                                                                </div>
                                                                <div class="left">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        contact_phone
                                                                    </i>
                                                                    <p>
                                                                        <span class="title green-complement-text">
                                                                            Teléfono
                                                                        </span>
                                                                        <br>
                                                                            {{$user->telefono ? $user->telefono : 'No registra'}}
                                                                        </br>
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Celular
                                                                    </span>
                                                                    <p>
                                                                        {{$user->celular ? $user->celular : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m12 l12">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    format_list_bulleted
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Ocupaciones
                                                                </span>
                                                                <p>
                                                                    {{$user->getOcupacionesNames()->implode(', ') ? : 'No registra'}}
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                 <div class="right">
                                                    <small>
                                                        Información Último Estudio
                                                    </small>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="mailbox-text">
                                                    <div class="row">
                                                        <div class="col s12 m6 l6">
                                                            <ul class="collection">
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        cast_for_education
                                                                    </i>
                                                                    <span class="title green-complement-text">
                                                                        Institución
                                                                    </span>
                                                                    <p>
                                                                        {{$user->institucion ? : 'No registra'}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        card_membership
                                                                    </i>
                                                                    <span class="title green-complement-text">
                                                                        Titulo obtenido
                                                                    </span>
                                                                    <p>
                                                                        {{$user->titulo_obtenido ? : 'No registra'}}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col s12 m6 l6">
                                                            <ul class="collection">
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        filter_list
                                                                    </i>
                                                                    <span class="title green-complement-text">
                                                                        Grado de escolaridad
                                                                    </span>
                                                                    <p>
                                                                        {{$user->gradoescolaridad->nombre ? : 'No registra'}}
                                                                    </p>
                                                                </li>
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        date_range
                                                                    </i>
                                                                    <span class="title green-complement-text">
                                                                        <b class="teal-text green-complement-text">
                                                                        Fecha de terminación
                                                                        </b>
                                                                    </span>
                                                                    <p>
                                                                        {{optional($user->fecha_terminacion)->isoFormat('LL') ? : 'No registra'}}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(isset($user->talento) && collect($user->getRoleNames())->contains(App\User::IsTalento()))
                                                <div class="right">
                                                    <small>
                                                        Información {{App\User::IsTalento()}}
                                                    </small>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m12 l12 ">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <div class="row">
                                                                    <div class="col s12 m6 l6">
                                                                        <i class="material-icons circle teal darken-2">
                                                                            assignment_ind
                                                                        </i>
                                                                        <span>
                                                                            <b class="teal-text green-complement-text">
                                                                                Tipo {{App\User::IsTalento()}}:
                                                                            </b>
                                                                        </span>
                                                                        <p>{{$user->talento->tipotalento->nombre ? : 'Información no disponible'}}</p>

                                                                    </div>
                                                                    <div class="col s12 m6 l6">

                                                                        @isset($user->talento->tipotalento)

                                                                        @if($user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO ||
                                                                            $user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)
                                                                               <p><span><b class="teal-text darken-2">REGIONAL:</b></span> {{optional($user->talento->entidad->centro)->regional ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">CENTRO DE FORMACIÓN:</b></span> {{$user->talento->entidad->nombre ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">PROGRAMA DE FORMACION:</b></span> {{$user->talento->programa_formacion ?: 'No registra'}}</p>

                                                                        @elseif($user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_EGRESADO_SENA)
                                                                               <p><span><b class="teal-text darken-2">REGIONAL:</b></span> {{$user->talento->entidad->centro->regional->nombre ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">CENTRO DE FORMACIÓN:</b></span> {{$user->talento->entidad->nombre ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">PROGRAMA DE FORMACION:</b></span> {{$user->talento->programa_formacion ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">TIPO FORMACIÓN:</b></span> {{$user->talento->tipoformacion->nombre ?: 'No registra'}}</p>

                                                                        @elseif($user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_FUNCIONARIO_SENA)
                                                                               <p><span><b class="teal-text darken-2">REGIONAL:</b></span> {{$user->talento->entidad->centro->regional->nombre ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">CENTRO DE FORMACIÓN:</b></span> {{$user->talento->entidad->nombre ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">DEPENDENCIA:</b></span> {{$user->talento->dependencia ?: 'No registra'}}</p>

                                                                        @elseif($user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_INSTRUCTOR_SENA)
                                                                               <p><span><b class="teal-text darken-2">REGIONAL:</b></span> {{$user->talento->entidad->centro->regional->nombre ?: 'No registra'}}</p>
                                                                               <p><span><b class="teal-text darken-2">CENTRO DE FORMACIÓN:</b></span> {{$user->talento->entidad->nombre ?: 'No registra'}}</p>

                                                                        @elseif($user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)
                                                                        <p><span><b class="teal-text darken-2">TIPO ESTUDIO: </b></span> {{$user->talento->tipoestudio->nombre ?: 'No registra'}}</p>
                                                                        <p><span><b class="teal-text darken-2">UNIVERSIDAD: </b></span> {{$user->talento->universidad ?: 'No registra'}}</p>
                                                                        <p><span><b class="teal-text darken-2">CARRERA: </b></span> {{$user->talento->carrera_univeritaria ?: 'No registra'}}</p>

                                                                        @elseif($user->talento->tipotalento->nombre == App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA)
                                                                        <p><span><b class="teal-text darken-2">EMPRESA:</b></span> {{$user->talento->empresa ?: 'No registra'}}</p>

                                                                        @endif

                                                                        @endisset

                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="divider mailbox-divider">
                                                </div>
                                                @if(auth()->user()->id != $user->id && session()->has('login_role') && session()->get('login_role') != App\User::IsInfocenter())
                                                <div class="right">
                                                    <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs" href="{{route('usuario.usuarios.edit', $user->documento)}}">
                                                        Cambiar Información Personal
                                                    </a>
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
    </div>
</main>
@endsection
