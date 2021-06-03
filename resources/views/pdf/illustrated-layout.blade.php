<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title>
            {{config('app.name')}} | @yield('title-file',config('app.name'))
        </title>
        <meta content="@yield('meta-content', config('app.name'))" name="description"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/stylepdf.css')}}"/>
    </head>
    <body>

        <div class="header indigo lighten-5">
            <img alt="{{ config('app.name') }}" class="img-header" src="{{asset('img/logonacional_Negro.png')}}"/>
            <h1>
                @yield('title-file',config('app.name'))
            </h1>
        </div>
        <div class="footer">
            <p class="page">
                Página
            </p>
        </div>
        <div class="content">
            @yield('content-pdf')
        </div>
    </body>
</html>
