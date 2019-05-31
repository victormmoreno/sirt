<header class="mn-header navbar-fixed">
  <nav class="cyan darken-1">
    <div class="nav-wrapper row">
      <section class="material-design-hamburger navigation-toggle">
        <a class="button-collapse show-on-large material-design-hamburger__icon" data-activates="slide-out" href="#">
          <span class="material-design-hamburger__layer">
          </span>
        </a>
      </section>
      <div class="header-title col s2 m3 l3">
        <a href="">
          <img class="chapter-title responsive-img" height="50px" src="{{ asset('img/logonacional_Blanco.png') }}" width="200px"/>
        </a>
      </div>
      <ul class="right col s6 m6 nav-right-menu">

        <notifications></notifications>

        <li >
          <a class="dropdown-button dropdown-right" data-activates="dropdown2" href="javascript:void(0)">
            @guest
            @else
            {{ auth()->user()->nombre_completo}}

            @endguest
          </a>
        </li>


        <li class="hide-on-med-and-down show-on-large">
          <clock>
          </clock>
        </li>
      </ul>
      <ul class="dropdown-content notifications-dropdown" id="dropdown2">
        <li class="notificatoins-dropdown-container">
          <ul>
            <li class="notification-drop-title">
              <center>
                Lista de opciones
                <br>
                @guest
                @else
                <b>
                  Último login:
                </b>
                {{ optional(auth()->user()->ultimo_login)->isoFormat('LLLL') }}
                <br>
                <b>
                  Edad:
                </b>
                {{ auth()->user()->fechanacimiento->age }}
                @endguest
              </br>
            </br>
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
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

</div>
</nav>
</header>
<aside class="side-nav white fixed" id="slide-out">
  <div class="side-nav-wrapper">
    <div class="sidebar-profile">
      <div class="sidebar-profile-info">
        <a class="account-settings-link" href="javascript:void(0);">
          <p>
            @guest

            @else
            {{ auth()->user()->nombre_completo}}
            @endguest
          </p>
          <span>
            @guest
            @else

            {{ auth()->user()->rol->nombre }}
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
    @switch( auth()->user()->rol->nombre )
    @case('Infocenter')
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}">
          <i class="material-icons">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="no-padding {{setActiveRoute('lineas.index')}}">
        <a href="{{route('idea.ideas')}}">
          <i class="material-icons">
            linear_scale
          </i>
          Ideas
        </a>
      </li>
      <li class="no-padding {{setActiveRoute('lineas.index')}}">
        <a href="{{route('lineas.index')}}">
          <i class="material-icons">
            linear_scale
          </i>
          Lineas
        </a>
      </li>
      <li class="no-padding {{setActiveRoute('lineas.index')}}">
        <a href="{{route('lineas.index')}}">
          <i class="material-icons">
            linear_scale
          </i>
          Sublineas
        </a>
      </li>
    </ul>
    @break

    @case('Administrador')
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}">
          <i class="material-icons">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="no-padding ">
        <a class="collapsible-header waves-effect waves-grey ">
          <i class="material-icons">supervised_user_circle</i>Usuarios
          <i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="{{route('usuario.administrador.index')}}">
                Administrador
              </a>
            </li>
            <li>
              <a href="">Dinamizador
              </a>
            </li>
            <li>
              <a href="">Gestores
              </a>
            </li>
            <li>
              <a href="">Infocenter
              </a>
            </li>
            <li>
              <a href="">Talentos
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="no-padding {{setActiveRoute('lineas.index')}}">
        <a href="{{route('lineas.index')}}">
          <i class="material-icons">
            linear_scale
          </i>
          Nodos
        </a>
      </li>
      <li class="no-padding {{setActiveRoute('lineas.index')}}">
        <a href="{{route('lineas.index')}}">
          <i class="material-icons">
            linear_scale
          </i>
          Lineas
        </a>
      </li>
      <li class="no-padding {{setActiveRoute('lineas.index')}}">
        <a href="{{route('lineas.index')}}">
          <i class="material-icons">
            linear_scale
          </i>
          Sublineas
        </a>
      </li>
    </ul>
    @break

    @default

    @endswitch

    <div class="footer">
      <p class="copyright">
        Steelcoders ©
      </p>
      <a href="#!">
        Privacy
      </a>
      &
      <a href="#!">
        Terms
      </a>
    </div>
  </div>
</aside>
