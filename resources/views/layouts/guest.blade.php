<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        {{ config('app.name') }} | @yield('meta-title', config('app.name'))
    </title>
    <link href="{{ asset('css/libs.css') }}" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link href="{{ asset('img/web.svg') }}" rel="shortcut icon" type="image/x-icon" />
    <meta name="theme-color" content="#39A900" />
    <meta name="title" content="@yield('meta-title', config('app.name'))" />
    <meta name="abstract" content="@yield('meta-title', config('app.name'))" />
    <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" /> <!-- maximo 160 caracteres -->
    <meta name="author" content="SENA" />
    <meta name="copyright" content="© 2019 redtecnoparquecolombia" />
    <meta http-equiv="Content-Language" content="{{ config('app.locale') }}" />
    <meta name="distribution" content="global" />
    <meta name="robots" content="index" />
    <meta name="Keywords" content="@yield('meta-keywords', 'Tecnoparque, SENA, Innovacion, Tecnologia, desarrollo, emprendimiento')" />
    <meta content="{{ csrf_token() }}" name="csrf-token" />

    <meta property="og:locale" content="es_ES" />
    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    @stack('style')
</head>

<body>
    <div class="loader-bg"></div>
    <div class="loader" id="app">
        <div class="preloader-wrapper big active m-b-xxl m-b-xxl">
            <div class="spinner-layer">
                <svg height="45px" viewBox=".515 .76148307 73.922 72.10751693" width="45px"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="m37.73.767a7.967 7.967 0 0 0 -7.957 7.975 7.967 7.967 0 0 0 7.972 7.96 7.967 7.967 0 0 0 7.963-7.968v-.015a7.967 7.967 0 0 0 -7.979-7.952zm-26.284 18.403c-1.4.008-2.824.086-4.159.422-.88.223-1.731.59-2.284 1.16-.694.714-.783 1.683-.444 2.51.302.73 1.116 1.276 2.023 1.589 1.95.668 4.117.81 6.168 1.23.378.093.796.195 1.03.453.243.307.1.73-.299.923-.666.339-1.517.341-2.293.33-.708-.03-1.486-.089-2.05-.444-.414-.255-.487-.689-.394-1.062h-4.57c-.012.696.123 1.423.633 2.02.426.51 1.114.87 1.854 1.086 1.183.348 2.464.453 3.725.485 1.711.029 3.456-.022 5.1-.41.98-.239 1.942-.625 2.57-1.251 1.113-1.118.851-2.889-.63-3.758-.737-.43-1.62-.696-2.52-.868-1.317-.273-2.658-.473-3.992-.693-.469-.091-.964-.172-1.358-.393-.412-.221-.445-.743-.025-.97.543-.307 1.266-.305 1.916-.305.685.012 1.43.055 1.994.376a.855.855 0 0 1 .446.758l4.345-.01c-.017-.55-.119-1.123-.521-1.598-.467-.585-1.288-.954-2.133-1.17-1.325-.335-2.74-.404-4.131-.41zm9.426.328-.002 10.382h12.67v-2.263h-8.023v-2.015h7.155v-2.213h-7.155l-.001-1.652 7.734-.002-.005-2.237zm20.875.004-5.872.001-.001 10.382h4.448l-.002-6.986 6.093 6.981 6.105.006-.002-10.383-4.452.001.005 6.936zm18.702.017s-4.795 6.926-7.204 10.384h4.669l1.12-1.873h7.214l1.046 1.874 5.186-.001-6.873-10.382zm2.334 2.478 2.214 3.761-4.577.007zm-62.268 10.82.04 5.65 21.12-.074c1.077.231 1.702.933 1.482 2.526l-12.99 22.739 4.232 3.955 20.118-34.797zm40.3.048 19.784 34.649 4.372-3.93-13.14-22.679c-.22-1.599.405-2.308 1.483-2.54l21.123.075-.006-5.558zm-3.338 5.733-18.553 31.846 4.928 2.401 12.38-20.924c.427-.349.859-.534 1.29-.552.456-.017.917.151 1.379.512l12.351 20.988 5.083-2.652z"
                        fill="#39A900" />
                </svg>
            </div>
        </div>
        <h2 class="header-text center center-align  m-t-xxl  m-b-xxl">{{ config('app.name') }}</h2>
        <span class="center center-align">Cargando...</span>
    </div>
    <div class="modal valign-wrapper" id="loadingModal" style="width: 20%">
        <div class="modal-content">
            <center>
                <div class="preloader-wrapper big active">
                    <div class="preloader-wrapper big active m-b-xxl m-b-xxl">
                        <div class="spinner-layer">
                            <svg height="45px" viewBox=".515 .76148307 73.922 72.10751693" width="45px"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m37.73.767a7.967 7.967 0 0 0 -7.957 7.975 7.967 7.967 0 0 0 7.972 7.96 7.967 7.967 0 0 0 7.963-7.968v-.015a7.967 7.967 0 0 0 -7.979-7.952zm-26.284 18.403c-1.4.008-2.824.086-4.159.422-.88.223-1.731.59-2.284 1.16-.694.714-.783 1.683-.444 2.51.302.73 1.116 1.276 2.023 1.589 1.95.668 4.117.81 6.168 1.23.378.093.796.195 1.03.453.243.307.1.73-.299.923-.666.339-1.517.341-2.293.33-.708-.03-1.486-.089-2.05-.444-.414-.255-.487-.689-.394-1.062h-4.57c-.012.696.123 1.423.633 2.02.426.51 1.114.87 1.854 1.086 1.183.348 2.464.453 3.725.485 1.711.029 3.456-.022 5.1-.41.98-.239 1.942-.625 2.57-1.251 1.113-1.118.851-2.889-.63-3.758-.737-.43-1.62-.696-2.52-.868-1.317-.273-2.658-.473-3.992-.693-.469-.091-.964-.172-1.358-.393-.412-.221-.445-.743-.025-.97.543-.307 1.266-.305 1.916-.305.685.012 1.43.055 1.994.376a.855.855 0 0 1 .446.758l4.345-.01c-.017-.55-.119-1.123-.521-1.598-.467-.585-1.288-.954-2.133-1.17-1.325-.335-2.74-.404-4.131-.41zm9.426.328-.002 10.382h12.67v-2.263h-8.023v-2.015h7.155v-2.213h-7.155l-.001-1.652 7.734-.002-.005-2.237zm20.875.004-5.872.001-.001 10.382h4.448l-.002-6.986 6.093 6.981 6.105.006-.002-10.383-4.452.001.005 6.936zm18.702.017s-4.795 6.926-7.204 10.384h4.669l1.12-1.873h7.214l1.046 1.874 5.186-.001-6.873-10.382zm2.334 2.478 2.214 3.761-4.577.007zm-62.268 10.82.04 5.65 21.12-.074c1.077.231 1.702.933 1.482 2.526l-12.99 22.739 4.232 3.955 20.118-34.797zm40.3.048 19.784 34.649 4.372-3.93-13.14-22.679c-.22-1.599.405-2.308 1.483-2.54l21.123.075-.006-5.558zm-3.338 5.733-18.553 31.846 4.928 2.401 12.38-20.924c.427-.349.859-.534 1.29-.552.456-.017.917.151 1.379.512l12.351 20.988 5.083-2.652z"
                                    fill="#39A900" />
                            </svg>
                        </div>
                    </div>

                </div>
                <span class="center center-align">Cargando...</span>
            </center>
        </div>
    </div>
    <div class="mn-content">
        <header class="no-padding">
            <div class="navbar-fixed">
                <nav class="nav-wrapper bg-primary">
                    <div class="container nav-wrapper">
                        <section class="hide-on-med-and-up m-r-xxs container material-design-hamburger navigation-toggle">
                            <a href="#" data-activates="slide-out"
                                class="button-collapse show-on-large material-design-hamburger__icon">
                                <span class="material-design-hamburger__layer"></span>
                            </a>
                        </section>
                        <a href="" class="waves-effect waves-light">
                            <span class="">
                                <img src="{{ asset('img/web-white.svg') }}" alt="{{ config('app.name') }}" width="45"
                                    style="vertical-align: middle;margin-bottom:10px;margin-right:10px;"></span>
                            <span id="header-large" style="font-weight:400;font-size:2rem;">| SIRT</span>
                        </a>
                        <ul class="hide-on-med-and-down right">
                            <li class="menu-item">
                                <a href="{{route('/')}}" rel="canonical" title="Haz clic aquí para ir a la página principal">Inicio</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('creditos')}}" rel="canonical" title="Haz clic aquí para ver los créditos">Créditos</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('registro') }}" rel="canonical" title="Haz clic aquí para registrarte">Registrase</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('login') }}" rel="canonical" title="Haz clic aquí para iniciar sesión">Iniciar Sesión</a>
                            </li>
                        </ul>
                        <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi mdi-menu"></i></a>
                    </div>
                </nav>
            </div>
        </header>
        <aside id="slide-out" class="side-nav white hide-on-med-and-up  ">
            <div class="side-nav-wrapper">
                <div class="sidebar-profile"></div>
                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                    <li class="no-padding"><a class="waves-effect waves-grey" href="{{route('/')}}" rel="canonical" title="Haz clic aquí para ir a la página principal">Inicio</a></li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="{{route('creditos')}}" rel="canonical" title="Haz clic aquí para ver los créditos">Créditos</a></li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="{{ route('registro') }}" rel="canonical" title="Haz clic aquí para registrarte">Registrate</a></li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="{{ route('login') }}" rel="canonical" title="Haz clic aquí para iniciar sesión">Iniciar Sesión</a></li>
                </ul>
                <div class="footer">
                    <p class="copyright">SENA©</p>
                </div>
            </div>
        </aside>
        <main>
            @yield('content')
        </main>
    </div>
    <div class="left-sidebar-hover"></div>
    <script>
        const host_url = "{{ config('app.url') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/libs.js') }}"></script>
    <script src="{{ asset('js/web.js') }}"></script>
    
    {{-- @include('sweetalert::alert')       --}}
    @stack('script')
</body>

</html>
