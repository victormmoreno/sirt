<header class="mn-header navbar-fixed">
    <nav class="bg-primary">
        <div class="nav-wrapper row">
            <section class="material-design-hamburger navigation-toggle">
                <a class="button-collapse show-on-large material-design-hamburger__icon" data-activates="slide-out" href="#">
                <span class="material-design-hamburger__layer">
                </span>
                </a>
            </section>
            <div class="header-title col s2 m2 l2">
                <a href="{{route('home')}}">
                    <img width="150px" class="chapter-title" src="{{ asset('img/logo-sirt-blanco.svg') }}" alt="{{config('app.name')}}">
                </a>
            </div>
            <ul class="right col s10 m10 l10 nav-right-menu">
                <li class="hide-on-med-and-down">
                    <a href="javascript:void(0)" data-activates="dropdown-help" class="dropdown-button dropdown-right show-on-large">
                        <i class="material-icons">help_outline</i>
                    </a>
                </li>
                <li class="hide-on-small-and-down">
                    <a href="javascript:void(0)" data-activates="dropdown-notification" class="dropdown-button dropdown-right show-on-large">
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <i class="material-icons">notifications_active</i>
                        @else
                            <i class="material-icons">notifications_none</i>
                        @endif
                        @if($count = auth()->user()->unreadNotifications->count())
                            @if($count <= 9)
                                <span class="badge">{{$count}}</span>
                            @else<span class="badge">9+</span>@endif
                        @endif
                    </a>
                </li>
                <li>
                    <a class="dropdown-button dropdown-right" data-activates="dropdown-logout" href="javascript:void(0)">
                        @auth
                        {{optional(auth()->user())->nombres}} {{ optional(auth()->user())->apellidos}}
                        @endauth
                    </a>
                </li>
                <li class="hide-on-med-and-down">
                    <clock>
                    </clock>
                </li>
            </ul>
            <ul class="dropdown-content notifications-dropdown" id="dropdown-logout">
                <li class="notificatoins-dropdown-container">
                    <ul>
                        <li class="notification-drop-title">
                            <center>
                                Lista de opciones
                                <br>
                                @guest
                                    @else
                                    <b>Último login:</b> {{ optional(auth()->user()->ultimo_login)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                    <br>
                                    @if(auth()->user()->fechanacimiento != null || isset(auth()->user()->fechanacimiento))
                                    <b>Edad:</b>{{ optional(auth()->user()->fechanacimiento)->age }} años
                                    @endif
                                @endguest
                            </center>
                        </li>
                        <li>
                            <a href="{{ route('perfil.index')}}" rel="canonical" title="Mi perfil">
                                <div class="notification">
                                    <div class="notification-icon circle bg-secondary"><i class="material-icons">perm_contact_calendar</i></div>
                                    <div class="notification-text"><b>Mi perfil</b></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" rel="canonical" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                <div class="notification">
                                    <div class="notification-icon circle bg-danger">
                                        <i class="material-icons">power_settings_new</i>
                                    </div>
                                    <div class="notification-text">
                                        <b>{{ __('Logout') }}</b>
                                        <form action="{{ route('logout') }}" id="logout-form-nav" method="POST" style="display: none;">@csrf</form>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul id="dropdown-notification" class="dropdown-content notifications-dropdown">
                <li class="notificatoins-dropdown-container">
                    <ul>
                        <li class="notification-drop-title center">
                        <div class="center">
                            Notificaciones
                        </div>
                        </li>
                        <li class="divider" tabindex="-1"></li>
                        @forelse (Auth::user()->unreadNotifications as $notification)
                            <li>
                            <a href="{{route('notifications.index')}}">
                                <div class="notification">
                                <div class="notification-icon circle {{ $notification->data['color'] }}">
                                    <i class="material-icons">{{ $notification->data["icon"] }}</i>
                                </div>
                                <div class="notification-text"><p> {{ $notification->data["text"] }}</p>
                                    <span>{{optional($notification->created_at)->diffForHumans()}}</span>
                                </div>
                                </div>
                            </a>
                            </li>
                        @empty
                            <li class="notification-drop-title">
                                <div class="center">
                                <i class="large material-icons primary-text center ">
                                        notifications_off
                                    </i>
                                    <p class="center-align">No tienes notificationes</p>
                                </div>
                            </li>
                        @endforelse
                        <li class="divider" tabindex="-1"></li>
                        <li class="notification-drop-title">
                            <a href="{{route('notifications.index')}}" rel="canonical">
                                <div class="notification">
                                <div class="notification-icon circle bg-secondary">
                                    <i class="material-icons">add_alert</i>
                                </div>
                                <div class="notification-text">
                                    <p> Ver más notificationes</p>
                                </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul id="dropdown-help" class="dropdown-content notifications-dropdown">
                <li class="notificatoins-dropdown-container">
                    <ul>
                        <li class="notification-drop-title center">
                        <div class="center">
                            Ayuda
                        </div>
                        </li>
                        <li class="divider" tabindex="-1"></li>
                        <li>
                            <a href="{{route('help.handbook')}}">
                                <div class="notification">
                                <div class="notification-icon circle bg-primary">
                                    <i class="material-icons">book</i>
                                </div>
                                <div class="notification-text"><p> Descargar Manual</p></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('support.send')}}">
                                <div class="notification">
                                <div class="notification-icon circle bg-primary">
                                    <i class="material-icons">sms</i>
                                </div>
                                <div class="notification-text"><p>{{config('app.technical_support.title')}}</p></div>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="side-nav white fixed" id="slide-out">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-info">
                <a class="account-settings-link" href="javascript:void(0);">
                    <p>@auth{{ auth()->user()->nombres}} {{auth()->user()->apellidos}}@endauth</p>
                    <span>
                        @guest
                        @else
                        @if( \Session::get('login_role') != App\User::IsTalento() && \Session::get('login_role') != App\User::IsActivador() && \Session::get('login_role') != App\User::IsDesarrollador() )
                            {{ \NodoHelper::returnNodoUsuario() }}
                        @else
                            @if (\Session::get('login_role') == App\User::IsTalento())
                                Talento de Tecnoparque
                            @elseif (\Session::get('login_role') == App\User::IsActivador())
                                Activador de Tecnoparque
                            @else
                                Desarrollador de Tecnoparque
                            @endif
                        @endif
                        <i class="material-icons right">arrow_drop_down</i>
                        @endguest
                    </span>
                </a>
            </div>
        </div>
        <div class="sidebar-account-settings ">
            <ul>
                <li class="no-padding">
                <a class="waves-effect waves-grey " href="{{ route('perfil.index')}}" rel="canonical" title="Mi Perfil">
                    <i class="material-icons">perm_contact_calendar</i>Mi Perfil
                </a>
                </li>
                <li class="divider"></li>
                <li class="no-padding">
                    <a class="waves-effect waves-grey" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" rel="canonical">
                        <i class="material-icons">power_settings_new</i>
                        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                            @csrf
                        </form>{{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </div>
        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <div class="row">
                <div class="input-field col s12 m12 offset-m0">
                    <select name="change-role" id="change-role" onchange="roleUserSession.setRoleSession(this)">
                        @forelse(auth()->user()->getRoleNames() as  $name)
                        <option value="{{$name}}" {{\Session::get('login_role') == $name ? 'selected':''}}>{{$name}}</option>
                        @empty
                        <p>No tienes roles asignados</p>
                        @endforelse
                    </select>
                </div>
                </div>
            <li class="no-padding {{setActiveRoute('home')}}">
                <a href="{{route('home')}}" class="{{setActiveRouteActivePage('home')}}" rel="canonical" title="Inicio">
                    <i class="large material-icons {{setActiveRouteActiveIcon('home')}}">home</i>Inicio
                </a>
            </li>
            @switch( \Session::get('login_role'))
                @case(App\User::IsInfocenter())
                    @include('layouts.navrole.infocenter')
                    @break
                @case(App\User::IsGestor())
                    @include('layouts.navrole.gestor')
                    @break
                @case(App\User::IsTalento())
                    @include('layouts.navrole.talento')
                    @break
                @case(App\User::IsIngreso())
                    @include('layouts.navrole.ingreso')
                    @break
                @case(App\User::IsDinamizador())
                    @if(\Session::has('login_role') && \Session::get('login_role') == 'Dinamizador')
                        @include('layouts.navrole.dinamizador')
                    @endif
                    @break
                @case(App\User::IsActivador())
                    @if(\Session::has('login_role') && \Session::get('login_role') == App\User::IsActivador())
                        @include('layouts.navrole.activador')
                    @endif
                    @break
                @case(App\User::IsAdministrador())
                    @if(\Session::has('login_role') && \Session::get('login_role') == App\User::IsAdministrador())
                        @include('layouts.navrole.admin')
                    @endif
                    @break
                @case(App\User::IsDesarrollador())

                    @include('layouts.navrole.desarrollador')
                    @break

                @case(App\User::IsArticulador())
                    @include('layouts.navrole.articulador')
                    @break
                @case(App\User::IsApoyoTecnico())
                    @include('layouts.navrole.apoyo-tecnico')
                    @break
                @default
            @endswitch
        </ul>
        <div class="footer">
            <p class="copyright">Tecnoparque <?php echo date("Y"); ?> © </p>
            <a href="#!">Privacidad</a> &amp; <a href="#!">Terminos</a>
        </div>
    </div>
</aside>
