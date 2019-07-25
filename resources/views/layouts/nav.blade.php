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
            {{auth()->user()->nombres}} {{ auth()->user()->apellidos}}
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
                {{ auth()->user()->fechanacimiento->age }} años
                @endguest
              </br>
            </br>
          </center>
        </li>
        <li>
          <a href="{{ route('perfil.index')}}">
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
            {{ auth()->user()->nombres}} {{auth()->user()->apellidos}}
            @endguest
          </p>
          <span>
            @guest
            @else
              {{-- @if(auth()->user()->hasRole(App\User::IsAdministrador()) || auth()->user()->hasRole(App\User::IsTalento())) --}}
              @if( \Session::get('login_role') != App\User::IsTalento() && \Session::get('login_role') != App\User::IsAdministrador() )

                {{ \NodoHelper::returnNodoUsuario() }}
                {{-- {{collect(auth()->user()->roles)->firstWhere('name', App\User::IsAdministrador())->name}} Red Tecnoparque --}}
                {{-- {{collect(auth()->user()->roles)->firstWhere('name', App\User::IsTalento())->name}} --}}
              @else
                @if (\Session::get('login_role') == App\User::IsTalento())
                  Talento de Tecnoparque
                @else
                  Administrador de Tecnoparque
                @endif
                {{-- {{ auth()->user()->rol->nombre }} nodo {{ \NodoHelper::returnNodoUsuario() }} --}}
                {{-- {{ auth()->user()->roles->first()->name }} Tecnoparques --}}
              @endif

              {{-- @hasrole('Administrador')
                  {{ auth()->user()->getRoleNames()-> }} Tecnoparques

                  @endhasrol --}}

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
        <li class="no-padding">
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

      <div class="row">
          <div class="input-field col s12 m12 offset-m0">

            <select name="change-role" id="change-role" onchange="roleUserSession.setRoleSession(this)">
                @forelse(auth()->user()->getRoleNames() as  $name)
                  <option value="{{$name}}" {{\Session::get('login_role') == $name ? 'selected':''}}>{{$name}}</option>
                @empty
                  <p>No tienes roles asignados</p>
                @endforelse
            </select>
            {{-- <small>Seleccione Su rol</small> --}}
          </div>
        </div>
      <li class="no-padding {{setActiveRoute('home')}}">
        <a href="{{route('home')}}" class="{{setActiveRouteActivePage('home')}}">
          <i class="large material-icons {{setActiveRouteActiveIcon('home')}}">
            home
          </i>
          Inicio
        </a>
      </li>




    @switch( \Session::get('login_role'))
    @case(App\User::IsInfocenter())

    @include('layouts.navrole.infocenter')

    @break

    @case(App\User::IsGestor())

    @include('layouts.navrole.gestor')

    @break

    @case('Talento')

      <li class="no-padding">
        <a href="">
          <i class="material-icons">domain</i>Uso de Infraestructura
        </a>
      </li>

    @break

    @case(App\User::IsIngreso())
      @include('layouts.navrole.ingreso')
    @break

    @case('Dinamizador')

      @if(\Session::has('login_role') && \Session::get('login_role') == 'Dinamizador')

          @include('layouts.navrole.dinamizador')


      @endif

    @break

    @case(App\User::IsAdministrador())

      @if(\Session::has('login_role') && \Session::get('login_role') == App\User::IsAdministrador())

          @include('layouts.navrole.admin')


      @endif
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
