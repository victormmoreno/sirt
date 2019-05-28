<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}} | @yield('meta-tittle',   config('app.name') )</title>
        {{-- <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    --}}
        <link rel="stylesheet" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
        <link href="{{ mix('css/libs.css') }}" rel="stylesheet">
        

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')">

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/libs.js') }}" defer></script>
        
</head>
<body>
        <div class="mn-content fixed-sidebar" id="app">

            @include('layouts.nav')
            
            @yield('content')
        
            @include('layouts.footer')
        </div>
        <div class="left-sidebar-hover"></div>
       
    
</body>
</html>
