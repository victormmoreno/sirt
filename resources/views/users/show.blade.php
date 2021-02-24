@extends('layouts.app')

@section('meta-title', 'Usuario | ' . $user->present()->userFullName())

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
                            Usuario | {{$user->present()->userFullName()}}
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
                                                                {{$user->present()->userDinamizadorNombreNodo()}}
                                                                <small>
                                                                    <b>
                                                                        Dirección:
                                                                    </b>
                                                                    {{$user->present()->userDinamizadorDireccionNodo()}}
                                                                </small>
                                                                
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if(isset($user->gestor) && (collect($user->getRoleNames())->contains(App\User::IsGestor()) || collect($user->getRoleNames())->contains(App\User::IsArticulador())))
                                            <div class="right zurich-bt-fonts green-complement-text">
                                                <small>
                                                    @if(collect($user->getRoleNames())->contains(App\User::IsGestor())))
                                                        Información {{App\User::IsGestor()}}
                                                    @else
                                                        Información {{App\User::IsArticulador()}}
                                                    @endif
                                                    
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m12 l12 ">
                                                    <ul class="collection">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle teal darken-2">assignment_ind</i>
                                                            <span class="title">
                                                                <b class="teal-text darken-2">Nodo:</b> {{$user->present()->userGestorNombreNodo()}}
                                                                <br/>
                                                                @if(collect($user->getRoleNames())->contains(App\User::IsGestor())))
                                                                <b class="teal-text darken-2">Linea</b> {{$user->present()->userGestorNombreLinea()}}
                                                                @endif
                                                                <b class="teal-text darken-2">Honorario: </b> {{ $user->present()->userGestorHonorarios()}}
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
                                                                {{$user->present()->userInfocenterNombreNodo()}}
                                                                <br/>
                                                                <b class="teal-text darken-2">
                                                                    Extensión del {{App\User::IsInfocenter()}}:
                                                                </b>
                                                                {{$user->present()->userInfocenterExtension()}}   
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
                                                                        {!!$user->present()->userEditLink()!!}
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
                                                    {{$user->present()->userGenero()}}
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
                                                                    {{$user->present()->userTipoDocuento() }}
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
                                                                    {{$user->present()->userLugarExpedicionDocumento() }} -
                                                                    
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
                                                                    {{$user->present()->userFechaNacimiento()}}
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
                                                                        {{$user->present()->userEps()}}
                                                                    </p>
                                                                </div>
                                                                @if($user->eps->nombre == App\Models\Eps::OTRA_EPS)
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                        {{$user->present()->userOtraEps()}}
                                                                    </p>
                                                                </div>
                                                                @endif
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    map
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    Etnia
                                                                </span>
                                                                <p>
                                                                    {{$user->present()->userEtnia()}}
                                                                </p>
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
                                                                        <br/>
                                                                        {{$user->present()->userGradoDiscapacidad()}}
                                                                        
                                                                    </p>
                                                                </div>
                                                                @if($user->grado_discapacidad == 1)
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Discapacidad
                                                                    </span>
                                                                    <p>
                                                                        {{$user->present()->userDescripcionGradoDiscapacidad()}}
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
                                                                    {{$user->present()->userEmail()}}
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
                                                                    {{$user->present()->userDocumento()}}
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
                                                                    {{$user->present()->userGrupoSanguineo()}}
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
                                                                    {{$user->present()->userEstrato()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    account_balance_wallet
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    ¿Madre Cabeza de familia?
                                                                </span>
                                                                <p>
                                                                    {{$user->present()->userMujerCabezaFamilia()}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    account_balance_wallet
                                                                </i>
                                                                <span class="title green-complement-text">
                                                                    ¿Desplazado(a) por violencia?
                                                                </span>
                                                                <p>
                                                                    {{$user->present()->userDesplazadoPorViolencia()}}
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
                                                                        {{$user->present()->userDireccion()}}
                                                                    </p>
                                                                    <p>
                                                                        {{$user->present()->userLugarResidencia()}}
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Barrio
                                                                    </span>
                                                                    <p>
                                                                        {{$user->present()->userBarrio()}}
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
                                                                        <br/>
                                                                        {{$user->present()->userTelefono()}}
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title green-complement-text">
                                                                        Celular
                                                                    </span>
                                                                    <p>
                                                                        {{$user->present()->userCelular()}}
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
                                                                    {{$user->present()->userOcupacionesNames()}}
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
                                                                        {{$user->present()->userInstitucion()}}
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
                                                                        {{$user->present()->userGradoEscolaridad()}}
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
                                                                        {{$user->present()->userFechaTerminacion()}}
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
                                                                        <p>{{$user->present()->userNombreTipoTalento()}}</p>
                                                                    </div>
                                                                    <div class="col s12 m6 l6">
                                                                        <p>{{$user->present()->userTipoTalento()}}</p>
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
