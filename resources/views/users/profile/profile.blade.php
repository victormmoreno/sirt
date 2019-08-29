@extends('layouts.app')

@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios | Perfil
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
                                            @include('users.profile.nav.nav-profile')
                                        </div>
                                        <div class="row">
                                            @if(isset($user->dinamizador) && collect($user->getRoleNames())->contains(App\User::IsDinamizador()))
                                            <div class="right">
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
                                            <div class="right">
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
                                            <div class="right">
                                                <small>
                                                    Información {{App\User::IsInfocenter()}}
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
                                        @include('users.profile.nav.navbar')
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                @include('users.profile.nav.header')
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
                                                                        <a href="{{route('perfil.edit')}}">
                                                                            Cambiar Información
                                                                        </a>
                                                                    </li>
                                                                    {{--
                                                                    <li>
                                                                        <a href="#!">
                                                                            Mis Notificaciónes
                                                                        </a>
                                                                    </li>
                                                                    --}}
                                                                    @if(collect($user->getRoleNames())->contains(App\User::IsTalento()))
                                                                    <li class="divider">
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{route('certificado')}}" target="_blank">
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
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    credit_card
                                                                </i>
                                                                <span class="title">
                                                                    Tipo Documento
                                                                </span>
                                                                <p>
                                                                    {{$user->tipodocumento->nombre ? : 'No se encontraron resultados' }}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    calendar_today
                                                                </i>
                                                                <span class="title">
                                                                    Fecha de Nacimiento
                                                                </span>
                                                                <p>
                                                                    {{$user->fechanacimiento->isoFormat('LL')}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    account_balance_wallet
                                                                </i>
                                                                <div class="left">
                                                                    <span class="title">
                                                                        Eps
                                                                    </span>
                                                                    <p>
                                                                        {{$user->eps->nombre}}
                                                                    </p>
                                                                </div>
                                                                @if($user->eps->nombre == App\Models\Eps::OTRA_EPS)
                                                                <div class="right">
                                                                    <span class="title">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                        {{$user->otra_eps ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    my_location
                                                                </i>
                                                                <div class="left">
                                                                    <span class="title">
                                                                        Dirección
                                                                    </span>
                                                                    <p>
                                                                        {{$user->direccion ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                        Barrio
                                                                    </span>
                                                                    <p>
                                                                        {{$user->barrio ? : 'No registra'}}
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    mail_outline
                                                                </i>
                                                                <span class="title">
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
                                                                <span class="title">
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
                                                                <span class="title">
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
                                                                <span class="title">
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
                                                                <span class="title">
                                                                    Lugar de Residencia
                                                                </span>
                                                                <p>
                                                                    {{$user->ciudad->nombre ? : 'No registra'}} - {{$user->ciudad->departamento->nombre ? : 'No registra'}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <div class="center">
                                                                    <span class="title">
                                                                        Datos contacto
                                                                    </span>
                                                                </div>
                                                                <div class="left">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        contact_phone
                                                                    </i>
                                                                    <p>
                                                                        Telefono
                                                                        <br>
                                                                            {{$user->telefono ? $user->telefono : 'No registra'}}
                                                                        </br>
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
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
                                                                <span class="title">
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
                                                                    <span class="title">
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
                                                                    <span class="title">
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
                                                                    <span class="title">
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
                                                                    <span class="title">
                                                                        Fecha de terminación
                                                                    </span>
                                                                    <p>
                                                                        {{$user->fecha_terminacion->isoFormat('LL') ? : 'No registra'}}
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
                                                                            <b class="teal-text darken-2">
                                                                                Tipo {{App\User::IsTalento()}}:
                                                                            </b>
                                                                        </span>
                                                                        <p>{{$user->talento->perfil->nombre ? : 'Información no disponible'}}</p>
                                                                        
                                                                    </div>
                                                                    <div class="col s12 m6 l6">
                                                                        
                                                                        <span>
                                                                            <b class="teal-text darken-2">
                                                                                Entidad Asociada
                                                                            </b>
                                                                        </span>
                                                                        @if($user->talento->perfil->nombre == App\Models\Perfil::IsEgresadoSena() || $user->talento->perfil->nombre == App\Models\Perfil::IsAprendizSenaConApoyo() || $user->talento->perfil->nombre == App\Models\Perfil::IsAprendizSenaSinApoyo())                    
                                                                         <p>{{$user->talento->perfil->nombre == App\Models\Perfil::IsEgresadoSena() || $user->talento->perfil->nombre == App\Models\Perfil::IsAprendizSenaConApoyo() || $user->talento->perfil->nombre == App\Models\Perfil::IsAprendizSenaSinApoyo() ? 'Regional: '. $user->talento->entidad->centro->regional->nombre . ', Centro de formación: ' .$user->talento->entidad->nombre . ', Programa de formación: ' . $user->talento->programa_formacion : 'No registra' }}</p>
                                                                        @endif
                                                                        @if($user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioEmpresaPublica() || $user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioMicroempresa() || $user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioMedianaEmpresa() || $user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioMedianaEmpresa())
                                                                                <p>
                                                                            {{$user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioEmpresaPublica() || $user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioMicroempresa() || $user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioMedianaEmpresa() || $user->talento->perfil->nombre == App\Models\Perfil::IsFuncionarioMedianaEmpresa() ? $user->talento->empresa : 'No registra'}}</p>

                                                                        @endif
                                                                        @if($user->talento->perfil->nombre == App\Models\Perfil::IsEmprendedorIndependiente())
                                                                            <p>No registra</p>

                                                                        @endif
                                                                        @if($user->talento->perfil->nombre == App\Models\Perfil::IsEstudianteUniversitarioPregrado() || $user->talento->perfil->nombre == App\Models\Perfil::IsEstudianteUniversitarioPostgrado())
                                                                            <p>{{$user->talento->perfil->nombre == App\Models\Perfil::IsEstudianteUniversitarioPregrado() || $user->talento->perfil->nombre == App\Models\Perfil::IsEstudianteUniversitarioPostgrado() ? 'Universidad: '. $user->talento->universidad. ', Carrera universitaria: '. $user->talento->carrera_universitaria : 'No registra'}}</p>

                                                                        @endif
                                                                        @if($user->talento->perfil->nombre == App\Models\Perfil::IsInvestigador())
                                                                            <p>{{$user->talento->perfil->nombre == App\Models\Perfil::IsInvestigador() ? 'Grupo de investigación: ' . $user->talento->entidad->nombre : 'No registra'}}</p>

                                                                        @endif
                                                                        @if($user->talento->perfil->nombre == App\Models\Perfil::IsOtro())
                                                                            <p>{{$user->talento->perfil->nombre == App\Models\Perfil::IsOtro() ?  $user->talento->otro_tipo_talento : 'No registra'}}</p>

                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="right">
                                                    <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs" href="{{route('perfil.edit')}}">
                                                        Cambiar Información Personal
                                                    </a>
                                                    {{-- <a class="waves-effect waves-red btn-flat m-t-xs">
                                                        Eliminar Usuario
                                                    </a> --}}
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
