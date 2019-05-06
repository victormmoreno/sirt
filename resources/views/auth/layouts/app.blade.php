<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}} | @yield('meta-tittle',   config('app.name') )</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">   
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/libs.css') }}" rel="stylesheet"> --}}

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('css/libs.css') }}" rel="stylesheet">
        {{-- <style type="text/css">
          .router-link-exact-active{
            color: red;
          }
        </style> --}}

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')">

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/libs.js') }}" defer></script>

       
    </head>
    <body class="white">
        <div id="app">
          <div class="mn-content">
         
         @include('auth.layouts.nav')

       @yield('content-auth')

       @include('auth.layouts.footer')

  
      
    <div class="left-sidebar-hover"></div>
    </div>
          
  
    </div> 
    </body>
</html>
