    
<!DOCTYPE html>
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
        

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta-content', 'Tecnoparque Red Colombia')">

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/libs.js') }}" defer></script>
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
        
    </body>
</html>