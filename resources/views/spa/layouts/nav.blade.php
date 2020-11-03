<header class="mn-header navbar-fixed">
    <nav class="cyan darken-1 bs-n">
      <div class="nav-wrapper row">
        <section class="material-design-hamburger navigation-toggle ">
          <a href="javascript:void(0)" data-activates="slide-out" class="button-collapse show-on-medium-and-down material-design-hamburger__icon">
            <span class="material-design-hamburger__layer"></span>
          </a>
        </section>
        <div class="col s2 m3 l3 ">
          <a href="{{route('/')}}" rel="canonical" class="hide-on-med-and-down">
            <img class="hide-on-med-and-down"  width="200px" height="50px" src="{{ asset('img/logonacional_Blanco.png') }}" alt="{{config('app.name')}}" title="{{config('app.name')}}"></img>
          </a>
        </div>
        <ul>
        <!--<ul class=" col s8 m8 l7 ">-->
          <li class="hide-on-med-and-down">
            <a href="{{route('/')}}" rel="canonical" title="Haz clic aquí para ir a la página principal">INICIO</a>
          </li>
          <li class="hide-on-med-and-down">
            <a href="{{ route('idea.create') }}" rel="canonical"  title="Haz clic aquí para inscribir una idea de proyecto" class="hide-on-med-and-down">IDEAS DE PROYECTOS</a>
          </li>


          <li class="hide-on-med-and-down"><a href="#objetivos" title="Haz clic aquí para ver los objetivos">OBJETIVOS</a></li>
          <li class="hide-on-med-and-down"><a href="#tecnoparque" title="Haz clic aquí para ver que es tecnnoparque">¿QUÉ ES TECNOPARQUE? </a></li>
          {{-- <li class="hide-on-med-and-down"><a href="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Descarga TECNOPARQUE RA"> TECNOPARQUE RA</a></li> --}}
          <li class="hide-on-med-and-down"><a href="{{route('creditos')}}" rel="canonical" title="Haz clic aquí para ver los créditos"> CRÉDITOS</a></li>
        </ul>
        <ul>
          <li class="hide-on-med-and-down"><a href="{{ route('login') }}" rel="canonical" title="Haz clic aquí para iniciar sesión" class="waves-effect waves-light btn">{{ __('Login') }}</a></li>
          <li class="hide-on-med-and-down"><a href="{{ route('persona.create') }}" rel="canonical" title="Haz clic aquí para registrarse" class="waves-effect waves-light btn">REGISTRARSE</a></li>
        </ul>

      </div>
    </nav>
</header>
<aside id="slide-out" class="side-nav white hide-on-large-only">
  <div class="side-nav-wrapper">
    <div class="sidebar-profile">
      <div class="sidebar-profile-info">
        <a href="{{route('/')}}" rel="canonical" >
          <img  width="160px" height="40px" src="{{ asset('img/logonacional_Negro.png') }}" alt="{{config('app.name')}}" title="{{config('app.name')}}" class="show-on-small chapter-title"></img>
        </a>

      </div>
    </div>
    <div class="sidebar-account-settings">
      <ul>

      </li>
    </ul>
    <a href="{{route('/')}}" rel="canonical" >
      <img  width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}" alt="{{config('app.name')}}" title="{{config('app.name')}}" class="chapter-title"></img>
    </a>
  </div>
  <ul class="sidebar-menu collapsible collapsible-accordion " data-collapsible="accordion">

    <li class="hide-on-large-only"><a class="waves-effect waves-grey" href="{{ route('idea.create') }}" rel="canonical"><i class="material-icons">ac_unit</i> IDEAS DE PROYECTOS</a></li>
    <li class="hide-on-large-only"><a class="waves-effect waves-grey" href="#objetivos"><i class="material-icons">info_outline</i>OBJETIVOS</a></li>
    <li class="hide-on-large-only"><a class="waves-effect waves-grey" href="#tecnoparque"><i class="material-icons">info_outline</i>¿QUÉ ES TECNOPARQUE?</a></li>
    {{-- <li class="hide-on-large-only"><a href="" class="waves-effect waves-grey" ><i class="material-icons">cloud_download</i> TECNOPARQUE RA</a></li> --}}
  <li class="hide-on-large-only"><a href="{{route('creditos')}}" class="waves-effect waves-grey" ><i class="material-icons">help</i> CRÉDITOS</a></li>

    <li class="hide-on-large-only"><a href="{{ route('login') }}" rel="canonical"  class="waves-effect waves-light btn"><i class="material-icons left">fingerprint</i> Iniciar Sesión</a></li>


  </ul>
  <div class="footer">
    <p class="copyright">Tecnoparque <?php echo date("Y"); ?> ©</p>
    <a href="#!">Privacidad</a> &amp; <a href="#!">Terminos</a>
  </div>
</div>
</aside>

