<!DOCTYPE html>
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
        <link href="{{ asset('sweetalert2/sweetalert2.css') }}" rel="stylesheet"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>
        <style>
        .tabs .tab .active {
          color:#26a69a;
          /*Custom Text Color While Active*/
          background-color: rgba(89, 181, 72, 0.2);
          /*Custom Background Color While Active*/
        }
        </style>
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
        <script src="{{ asset('js/app.js') }}">
        </script>
        <script src="{{ asset('js/libs.js') }}">
        </script>
        <script src="{{ asset('js/app2.js') }}">
        </script>
        @stack('script')
    @include('sweetalert::alert')
    </body>
</html>
