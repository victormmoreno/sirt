<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name')}} | @yield('meta-title',   config('app.name') )</title>

        <link href="{{ asset('css/libs.css') }}" rel="stylesheet">
        <link href="{{ asset('sweetalert2/sweetalert2.css') }}" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/web.png') }}">


        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')">
        <style>
        .tabs .tab .active {
          color:#26a69a;
          /*Custom Text Color While Active*/
          background-color: rgba(89, 181, 72, 0.2);
          /*Custom Background Color While Active*/
        }
        </style>
        @stack('style')
</head>
<body>
    <div class="mn-content fixed-sidebar" id="app">
        @include('layouts.nav')
        @yield('content')
        <div class="modal valign-wrapper" id="loadingModal" style="width: 20%">
          <div class="modal-content">
            <center>
                <div class="preloader-wrapper big active">
                  <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>
            </center>
          </div>
        </div>

        @include('layouts.footer')
    </div>
    <div class="left-sidebar-hover"></div>
    @include('sweetalert::alert')
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/libs.js') }}" ></script>
    <script src="{{ asset('js/app2.js') }}"></script>
    @stack('script')
    @include('sweetalert::alert')
</body>
</html>
