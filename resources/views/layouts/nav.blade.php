<header class="mn-header navbar-fixed">
    <nav class="cyan darken-1">
        <div class="nav-wrapper row">
            <section class="material-design-hamburger navigation-toggle">
                <a class="button-collapse show-on-large material-design-hamburger__icon" data-activates="slide-out" href="javascript:void(0)">
                    <span class="material-design-hamburger__layer">
                    </span>
                </a>
            </section>
            <div class="header-title col s2 m3 l3">
                <a href="">
                    <img class="chapter-title responsive-img" height="50px" src="{{ asset('img/logonacional_Blanco.png') }}" width="200px"/>
                </a>
            </div>
            {{-- <div class="show-on-large hide-on-med-and-down">
                <ul class="center col s10 m5 l5 nav-center-menu">
                    <li>
                        <clock>
                        </clock>
                    </li>
                </ul>
            </div> --}}
            {{--
            <div class="show-on-large hide-on-med-and-down">
                --}}
                <ul class="right col s10 m4 l4 nav-right-menu">
                    <li class="hide-on-small-and-down">
                        <a class="dropdown-button dropdown-right show-on-large" href="">
                            <i class="material-icons">
                                live_help
                            </i>
                        </a>
                    </li>
                    <li class="hide-on-small-and-down show-on-large">
                        <a class="dropdown-button dropdown-right" data-activates="dropdown2" href="javascript:void(0)">
                            @guest
        @else
            {{ auth()->user()->nombre_completo }} 
         @endguest
                        </a>
                    </li>
                    <li class="hide-on-small-and-down">
                        <a class="dropdown-button dropdown-right show-on-large" data-activates="dropdown1" href="javascript:void(0)">
                            <i class="material-icons">
                                notifications_none
                            </i>
                            <span class="badge">
                                4
                            </span>
                        </a>
                    </li>
                    <li class="hide-on-med-and-up">
                        <a class="search-toggle" href="javascript:void(0)">
                            <i class="material-icons">
                                search
                            </i>
                        </a>
                    </li>
                    <li class="hide-on-small-and-down show-on-large">
                        <clock>
                        </clock>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
{{--
--}}
<ul class="dropdown-content notifications-dropdown" id="dropdown2">
    <li class="notificatoins-dropdown-container">
        <ul>
            <li class="notification-drop-title">
                <center>
                    Lista de opciones
                </center>
            </li>
            <li>
                <a href="">
                    <div class="notification">
                        <div class="notification-icon circle teal lighten-4">
                            <i class="material-icons">
                                perm_contact_calendar
                            </i>
                        </div>
                        <div class="notification-text">
                            <b>
                                Mi perfil
                            </b>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <div class="notification">
                        <div class="notification-icon circle teal lighten-2">
                            <i class="material-icons">
                                power_settings_new
                            </i>
                        </div>
                        <div class="notification-text">
                            <b>
                                {{ __('Logout') }}
                            </b>
                            <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </li>
</ul>
<aside class="side-nav white fixed" id="slide-out">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-info">
                <a class="account-settings-link" href="javascript:void(0);">
                    <p>
                        @guest
                       @else
                        {{ auth()->user()->nombre_completo }} 
                       @endguest
                    </p>
                    <span>
                         @guest
                       @else
                        {{auth()->user()->roles->first()->name}}
                        <i class="material-icons right">
                            arrow_drop_down
                        </i>
                        @endguest
                    </span>
                </a>
            </div>
        </div>
        <div class="sidebar-account-settings">
            <ul>
                <li class="no-padding ">
                    <a class="waves-effect waves-grey ">
                        <i class="material-icons">
                            perm_contact_calendar
                        </i>
                        Mi Perfil
                    </a>
                </li>
                <li class="divider">
                </li>
                <li class="no-padding">
                    <a class="waves-effect waves-grey" href="">
                        <i class="material-icons">
                            power_settings_new
                        </i>
                        Salir
                    </a>
                </li>
            </ul>
        </div>
        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding >">
                <a href="">
                    <i class="material-icons">
                        home
                    </i>
                    Inicio
                </a>
            </li>
        </ul>
    </div>
    <div class="footer">
        <p class="copyright">
            Tecnoparque
            <?php echo date("Y"); ?>
            ©
        </p>
        <a href="#!">
            Privacidad
        </a>
        &
        <a href="#!">
            Terminos
        </a>
    </div>
</aside>
