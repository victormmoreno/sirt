

<header class="mn-header navbar-fixed">
          <nav class="cyan darken-1 bs-n">
            <div class="nav-wrapper row">
              <section class="material-design-hamburger navigation-toggle ">
                <a href="javascript:void(0)" data-activates="slide-out" class="button-collapse show-on-medium-and-down material-design-hamburger__icon">
                  <span class="material-design-hamburger__layer"></span>
                </a>
              </section>
              <div class="col s2 m3 l3 ">
                <a href="" class="hide-on-med-and-down">
                  <img class="hide-on-med-and-down"  width="200px" height="50px" src="{{ asset('img/logonacional_Blanco.png') }}" ></img>
                </a>
              </div>
              <ul class=" col s8 m8 l7 ">
                <li class="hide-on-med-and-down">
                  <a href="{{route('/')}}">INICIO</a>
                </li>
                <li class="hide-on-med-and-down">
                  <a href="{{ route('ideas.index') }}"  class="hide-on-med-and-down">IDEAS DE PROYECTOS</a>
                </li>
                
                
                <li class="hide-on-med-and-down"><a href="#objetivos">OBJETIVOS</a></li>
                <li class="hide-on-med-and-down"><a href="#tecnoparque">¿QUÉ ES TECNOPARQUE? </a></li>
                <li class="hide-on-med-and-down"><a href="" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Descarga TECNOPARQUE RA"> TECNOPARQUE RA</a></li>
              </ul>
              <ul class="col s2 m1 l2 nav-right-menu">
                <li class="hide-on-med-and-down"><a href="{{ route('login') }}"  class="waves-effect waves-light btn">{{ __('Login') }}</a></li>
              </ul>

            </div>
          </nav>
        </header>
        <aside id="slide-out" class="side-nav white hide-on-large-only">
          <div class="side-nav-wrapper">
            <div class="sidebar-profile">
              <div class="sidebar-profile-info">
                <a href="">
                  <img  width="160px" height="40px" src="{{ asset('img/logonacional_Negro.png') }}" class="show-on-small chapter-title"></img>
                </a>

              </div>
            </div>
            <div class="sidebar-account-settings">
              <ul>

              </li>
            </ul>
            <a href="">
              <img  width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}" class="chapter-title"></img>
            </a>
          </div>
          <ul class="sidebar-menu collapsible collapsible-accordion " data-collapsible="accordion">

            <li class="hide-on-large-only"><a class="waves-effect waves-grey" href=""><i class="material-icons">ac_unit</i> IDEAS DE PROYECTOS</a></li>
            <li class="hide-on-large-only"><a class="waves-effect waves-grey" href=""><i class="material-icons">info_outline</i>OBJETIVOS</a></li>
            <li class="hide-on-large-only"><a class="waves-effect waves-grey" href=""><i class="material-icons">info_outline</i>¿QUÉ ES TECNOPARQUE?</a></li>
            <li class="hide-on-large-only"><a href="" class="waves-effect waves-grey" ><i class="material-icons">cloud_download</i> TECNOPARQUE RA</a></li>

            <li class="hide-on-large-only"><a href="" class="waves-effect waves-light btn"><i class="material-icons left">fingerprint</i> Iniciar Sesión</a></li>


          </ul>
          <div class="footer">
            <p class="copyright">Tecnoparque <?php echo date("Y"); ?> ©</p>
            <a href="#!">Privacidad</a> &amp; <a href="#!">Terminos</a>
          </div>
        </div>
      </aside>
      
