<!DOCTYPE doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>
            {{config('app.name')}} | @yield('meta-tittle',   config('app.name') )
        </title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ mix('css/libs.css') }}" rel="stylesheet">
                        <!-- CSRF Token -->
        <meta content="{{ csrf_token() }}" name="csrf-token">
        <meta content="@yield('meta-content', 'Tecnoparque Red Colombia')" name="description">
        <script defer="" src="{{ mix('js/app.js') }}"></script>
        <script defer="" src="{{ mix('js/libs.js') }}"></script>
    </head>
    <body class="white">
        <div id="app">
            <div class="loader-bg">
            </div>
            <div class="loader">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue">
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
                    <div class="spinner-layer spinner-red">
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
                    <div class="spinner-layer spinner-yellow">
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
                    <div class="spinner-layer spinner-green">
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
            </div>
            <div class="mn-content">
                @include('spa.layouts.nav')

                 @yield('content-spa')

                 @include('spa.layouts.footer')
                <div class="left-sidebar-hover">
                </div>
            </div>
        </div>
    </body>
</html>
