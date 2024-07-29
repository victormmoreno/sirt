<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title>
            @yield('title-file', config('app.name'))
        </title>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
        <meta content="@yield('meta-content', config('app.name'))" name="description"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>
        @yield('styles')
        <style>
        table, th, td {
            border: solid;
            border-width: 1px;
        }

        table {
            width: 100%;
            display: table;
            font-size: 12px;
            word-wrap: break-word;
        }

        thead {
            border-bottom: 1px solid #d0d0d0;
        }
        td, th {
            display: table-cell;
            text-align: left;
            vertical-align: middle;
            border-radius: 2px;
            overflow: hidden;
            white-space: pre-line;
        }
        td {
            padding: 5px;
            height: 5px;
        }
        body {
            margin-top: 1.5cm;
            /* margin-bottom: 0.5cm */
            /* margin-left: 2cm; */
            /* margin-right: 1cm; */
        }
        header {
            position: fixed;
        }
        footer {
            position: fixed;
            bottom: -1cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: white;
            color: black;
            text-align: center;
            line-height: 35px;
        }
        .centered {
            text-align: center;
        }
        .left {
            text-align: left;
        }
        .header-img {
            width: 62px;
            height: 58px;
            opacity: 0.5;
        }
        .title {
            text-transform: uppercase;
        }
        </style>
    </head>
    <body>
        <header>
            <div class="text-center">
                <img class="header-img" src="{{asset('img/web.png')}}">
            </div>
        </header>
        <footer>
            <p class="text-center mt-3p text-black-50" >
                GOR-F-084 V02
            </p>
        </footer>
        @yield('content-pdf')
    </body>
</html>
