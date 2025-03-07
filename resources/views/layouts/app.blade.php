<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title>
            {{config('app.name')}} | @yield('meta-title',   config('app.name') )
        </title>
        <link href="{{ asset('css/libs.css') }}" rel="stylesheet"/>
        <link href="{{ asset('sweetalert2/sweetalert2.css') }}" rel="stylesheet"/>
        <link href="{{ asset('scss/darkmode.scss') }}" rel="stylesheet"/>
        <link href="{{ asset('img/web.svg') }}" rel="shortcut icon" type="image/x-icon"/>
        <meta name="theme-color" content="#39A900" />
        <meta name="title" content="@yield('meta-title',   config('app.name') )" />
        <meta name="abstract" content="@yield('meta-title',   config('app.name') )" />
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" /> <!-- maximo 160 caracteres -->
        <meta name="author" content="SENA" />
        <meta name="copyright" content="© 2019 redtecnoparquecolombia" />
        <meta http-equiv="Content-Language" content="{{config('app.locale')}}"/>
        <meta name="distribution" content="global"/>
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta name="robots" content="index"/>
        <meta name="Keywords" content="@yield('meta-keywords', 'Tecnoparque, SENA, Innovacion, Tecnologia, desarrollo, emprendimiento' )"/>
        <meta content="{{ csrf_token()}}" name="csrf-token"/>

        <meta property="og:locale" content="es_ES" />
        <meta property="og:title" content="{{config('app.name')}}" />
        <meta property="og:description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" />
        <meta property="og:url" content="{{config('app.url')}}" />
        <meta property="og:site_name" content="{{config('app.name')}}" />
        @stack('style')
    </head>
    <body class="loaded">
        <div class="mn-content fixed-sidebar" id="app">
            @include('layouts.nav')
            @yield('content')
            <div class="modal valign-wrapper" id="loadingModal" style="width: 20%">
                <div class="modal-content">
                    <center>
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle">
                                    </div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle">
                                    </div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
            @include('layouts.footer')
        </div>
        <div class="left-sidebar-hover">
        </div>
        @include('sweetalert::alert')
        <script>
            const host_url = "{{config('app.url')}}";
        </script>
        <script src="{{ asset('js/app.js') }}">
        </script>
        <script src="{{ asset('js/libs.js') }}">
        </script>
        <script src="{{ asset('js/app2.js?v=1') }}">
        </script>
        @stack('script')
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129874326-1"></script>
        <script>
            // SIDENAV
            $(document).ready(function(){
                // applyDarkMode();
                // $('.sidebar-menu').sidenav();
                
                // SWAP ICON ON CLICK
                // Source: https://stackoverflow.com/a/34254979/751570
                // $('#darkModeBtn').on('click',function(){
                //     if ($(this).find('i').text() == 'brightness_4'){
                //             $(this).find('i').text('brightness_high');
                //     } else {
                //             $(this).find('i').text('brightness_4');
                //     }
                // });
                
                
            });
            // window.dataLayer = window.dataLayer || [];
            // function gtag(){dataLayer.push(arguments);}
            // gtag('js', new Date());

            // gtag('config', 'UA-129874326-1');
        </script>
    </body>
</html>
