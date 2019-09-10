<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
                <title>
                    {{config('app.name')}} | @yield('title', config('app.name'))
                </title>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
                {{--
                <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
                --}}
                <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon">
                </link>
            </meta>
        </meta>
        <style type="text/css">
            html {
               line-height: 1.5;
                  font-family: Roboto,  BlinkMacSystemFont, "Segoe UI", Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                  font-weight: normal;
                  color: rgba(0, 0, 0, 0.87);
              /* 2 */
            }

            body {
                font-family: Calibri;
                box-shadow: 5px 5px;

            }
            
            .antialiased {
                margin: 45px, 25px;
                padding: 3px 10px;
                  border: PowderBlue 5px double;
                  border-top-left-radius: 20px;
                  border-bottom-right-radius: 20px;
                margin-bottom: 20px;
                position: absolute;
                  
            }

            .center,
            .center-align {
                text-align: center;
            }

            .left {
              float: left !important;
            }

            .right {
              float: right !important;
            }

            img{
                margin: 20px, 25px;
                border-style: none;
            }
            p {
                margin: 20px, 25px;
            }

            .red {
              background-color: #F44336 !important;
            }

            .red-text {
              color: #F44336 !important;
            }

            .red.lighten-5 {
              background-color: #FFEBEE !important;
            }

            

            img {
              width: 342;
              height: 89;
            }

            small {
              font-size: 80%;
            }
        </style>
    </head>
    <body>
        <div class="antialiased">
            @yield('image-header')
                @yield('message')
                @yield('image-footer')
        </div>
    </body>
</html>
