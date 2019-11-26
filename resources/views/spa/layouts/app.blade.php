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
        <link href="{{config('app.url')}}" rel="canonical"/>
        <link href="{{ asset('css/libs.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>

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

                 @include('spa.layouts.footer')
                <div class="left-sidebar-hover">
                </div>
            </div>

        </div>
        <script  src="{{ asset('js/app.min.js') }}"></script>
        <script  src="{{ asset('js/libs.min.js') }}"></script>
        @include('sweetalert::alert')
    </body>
</html>
