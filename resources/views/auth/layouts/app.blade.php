<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}} | @yield('meta-tittle',   config('app.name') )</title>

        <link href="{{config('app.url')}}" rel="canonical"/>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/web.png') }}">
        <link href="{{ asset('css/libs.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">


       <meta name="title" content="@yield('meta-title',   config('app.name') )" />
        <meta name="abstract" content="@yield('meta-title',   config('app.name') )" />
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" /> <!-- maximo 160 caracteres -->
        <meta name="author" content="SENA" />
        <meta name="copyright" content="© {{date("Y") }} redtecnoparquecolombia" />
        <meta http-equiv="Content-Language" content="{{config('app.locale')}}"/>
        <meta name="distribution" content="global"/>
        <meta name="robots" content="index"/>
        <meta name="Keywords" content="@yield('meta-keywords', 'Tecnoparque, SENA, Innovacion, desarrollo' )"/>
        <meta content="{{ csrf_token()}}" name="csrf-token"/>

        <meta property="og:locale" content="es_ES" />
        <meta property="og:title" content="{{config('app.name')}}" />
        <meta property="og:description" content="@yield('meta-content', 'Tecnoparque Red Colombia')" />
        <meta property="og:url" content="{{config('app.url')}}" />
        <meta property="og:site_name" content="{{config('app.name')}}" />

    </head>
    <body class="signin-page">
        @if(session()->has('info'))
            <div class="card teal lighten-4">
                <div class="row">
                    <div class="col s12 m10">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons left">info_outline</i>
                                {{session('info')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @yield('content-auth')
        <script>
            const host_url = "{{config('app.url')}}";
        </script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/libs.js') }}" defer></script>
    </body>
</html>
