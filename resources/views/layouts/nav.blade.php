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
        <a href="{{route('home')}}" class="{{setActiveRouteActivePage('home')}}">
          <i class="large material-icons {{setActiveRouteActiveIcon('home')}}">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey {{ setActiveRoutePadding('idea') }}">
          <i class="material-icons">lightbulb_outline</i>Ideas de Proyecto
          <i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="{{route('idea.ideas')}} " class="{{setActiveRouteActivePage('idea')}}">
                <i class="material-icons {{ setActiveRouteActiveIcon('idea') }} ">lightbulb</i>Ideas
              </a>
            </li>
            <li>
              <a href="{{route('idea.ideas')}}">
                <i class="material-icons">library_books</i>Entrenamientos
              </a>
            </li>
            <li>
              <a href="">
                <i class="material-icons">gavel</i>CSIBT's
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="no-padding">
        <a href="">
          <i class="material-icons">record_voice_over</i>Charlas Informativas
        </a>
      </li>
      <li class="no-padding">
        <a href="">
          <i class="material-icons">description</i>Reportes
        </a>
      </li>
    </ul>
    @break

    @case('Gestor')
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}">
          <i class="material-icons">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="teal lighten-2 no-padding">
        <a href="" class="waves-effect waves-grey">
          <i class="material-icons">library_books</i>Proyectos de Base Tecnológica (PBT)
        </a>
      </li>
      <li class="teal lighten-2 no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">toll</i>Articulaciones
        </a>
      </li>
      <li class="teal lighten-2 no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">record_voice_over</i>EDT's
        </a>
      </li>
      <li class="no-padding">
        <a href="" class="waves-effect waves-grey">
          <i class="material-icons">supervisor_account</i>Talentos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">domain</i>Uso de Infraestructura
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">business</i>Empresas
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">group_work</i>Grupos de Investigación
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">attach_money</i>Costos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey {{setActiveRouteActivePage('idea')}}" href="{{route('idea.ideas')}}">
          <i class="material-icons {{ setActiveRouteActiveIcon('idea') }}">lightbulb</i>Ideas
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">gavel</i>Comité
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">search</i>Seguimiento
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">description</i>Reportes
        </a>
      </li>
    </ul>
    @break

    @case('Talento')
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}">
          <i class="material-icons">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="no-padding">
        <a href="">
          <i class="material-icons">domain</i>Uso de Infraestructura
        </a>
      </li>
    </ul>
    @break

    @case('Ingreso')
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}">
          <i class="material-icons">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey ">
          <i class="material-icons">directions_walk</i>Ingresos
          <i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="">
                <i class="material-icons">transit_enterexit</i>Ingreso a Tecnoparque
              </a>
            </li>
            <li>
              <a href="">
                <i class="material-icons">accessibility</i>Visitantes
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="no-padding">
        <a href="" class="waves-effect waves-grey">
          <i class="material-icons">description</i>Reportes
        </a>
      </li>
    </ul>
    @break

    @case('Dinamizador')
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}">
          <i class="material-icons">
            home
          </i>
          Inicio
        </a>
      </li>
      <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey">
          <i class="material-icons">supervised_user_circle</i> Usuarios
          <i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="">
                Gestores
              </a>
            </li>
            <li>
              <a href="">
                Infocenter
              </a>
            </li>
            <li>
              <a href="">
                Talentos
              </a>
            </li>
            <li>
              <a href="">
                Ingreso
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="teal lighten-2 no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">library_books</i>Proyectos de Base Tecnológica (PBT)
        </a>
      </li>
      <li class="teal lighten-2 no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">toll</i>Articulaciones
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">settings_input_svideo</i>Costos Administrativos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">filter_center_focus</i>Focos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">lightbulb</i>Ideas de Proyecto
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">group_work</i>Grupos de Investigación
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">business</i>Empresas
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">local_drink</i>Laboratorios
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">trending_down</i>Depreciación
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">build</i>Mantenimiento
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">local_library</i>Materiales de Formación
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">attachment</i>Link's de Drive
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">attach_money</i>Costos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">show_chart</i>Indicadores
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">search</i>Seguimiento
        </a>
      </li>
      <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey">
          <i class="material-icons">description</i> Reportes<i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="">
                Infocenter
              </a>
            </li>
            <li>
              <a href="">
                Ingresos
              </a>
            </li>
            <li>
              <a href="">
                Gestor
              </a>
            </li>
            <li>
              <a href="">
                Dinamizador
              </a>
            </li>
          </ul>
        </div>
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
      <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey">
          <i class="material-icons">supervised_user_circle</i>Usuarios
          <i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="">
                Administrador
              </a>
            </li>
            <li>
              <a href="">
                Dinamizador
              </a>
            </li>
            <li>
              <a href="">
                Gestores
              </a>
            </li>
            <li>
              <a href="">
                Infocenter
              </a>
            </li>
            <li>
              <a href="">
                Talentos
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey">
          <i class="material-icons">location_city</i>Nodos
          <i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
        </a>
        <div class="collapsible-body">
          <ul>
            <li>
              <a href="{{route('nodo.index')}}">Nodos</a>
            </li>
            <li>
              <a href="">Mapa</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">linear_scale</i>Lineas
        </a>
      </li>
      <li class="no-padding">
        <a href="">
          <i class="material-icons">settings_input_svideo</i>Costos Administrativos
        </a>
      </li>
      <li class="no-padding">
        <a href="">
          <i class="material-icons">library_books</i>Proyectos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">filter_center_focus</i>Focos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">local_drink</i>Laboratorios
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">group_work</i>Grupos de Investigación
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">business</i>Empresas
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">local_library</i>Materiales de Formación
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">attachment</i>Link's de Drive
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">attach_money</i>Costos
        </a>
      </li>
      <li class="no-padding">
        <a class="waves-effect waves-grey" href="">
          <i class="material-icons">show_chart</i>Indicadores
        </a>
      </li>
    </ul>
    @break

    @default

    @endswitch

    <div class="footer">
      <p class="copyright">Tecnoparque <?php echo date("Y"); ?> © </p>
      <a href="#!">Privacidad</a> &amp; <a href="#!">Terminos</a>
    </div>
  </div>
</aside>
