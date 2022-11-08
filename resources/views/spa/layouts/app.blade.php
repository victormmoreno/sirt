<!DOCTYPE doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title>
            {{config('app.name')}} | @yield('meta-title',   config('app.name') )
        </title>
        <meta content="@yield('meta-content', 'Tecnoparque Red Colombia')" name="description"/>
        <meta content="{{ csrf_token()}}" name="csrf-token"/>

        <link href="{{ asset('css/libs.css') }}" rel="stylesheet"/>
        <link href="{{ asset('sweetalert2/sweetalert2.css') }}" rel="stylesheet"/>
        <link href="{{ asset('img/web.svg') }}" rel="shortcut icon" type="image/x-icon"/>
        @stack('style')
        <meta name="title" content="@yield('meta-title',   config('app.name') )" />
        <meta name="abstract" content="@yield('meta-title',   config('app.name') )" />
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" /> <!-- maximo 160 caracteres -->
        <meta name="author" content="SENA" />
        <meta name="copyright" content="© {{date("Y") }} redtecnoparquecolombia" />
        <meta http-equiv="Content-Language" content="{{config('app.locale')}}"/>
        <meta name="distribution" content="global"/>
        <meta name="robots" content="index"/>
        <meta name="Keywords" content="@yield('meta-keywords', 'Tecnoparque, SENA, Innovacion, Tecnologia, desarrollo, emprendimiento' )"/>
        <meta content="{{ csrf_token()}}" name="csrf-token"/>

        <meta property="og:locale" content="es_ES" />
        <meta property="og:title" content="{{config('app.name')}}" />
        <meta property="og:description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" />
        <meta property="og:url" content="{{config('app.url')}}" />
        <meta property="og:site_name" content="{{config('app.name')}}" />


    </head>
    <body class="white">
        <div id="app">

            <div class="mn-content">
                @include('spa.layouts.nav')
                @yield('content-spa')
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
                @include('spa.layouts.footer')
                <div class="left-sidebar-hover"></div>
            </div>

        </div>

        <script src="{{ asset('js/app.js') }}">
        </script>
        <script src="{{ asset('js/libs.js') }}">
        </script>
        <script src="{{ asset('js/web.js') }}">
        </script>
        @include('sweetalert::alert')
        <script>
            const host_url = "{{config('app.url')}}";
        </script>
        @stack('script')
    </body>
</html>
