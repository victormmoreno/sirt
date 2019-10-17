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
        <link href="{{ asset('css/libs.css') }}" rel="stylesheet"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>

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
        <script  src="{{ asset('js/app.js') }}"></script>
        <script  src="{{ asset('js/libs.js') }}"></script>
        @include('sweetalert::alert')
    </body>
</html>
