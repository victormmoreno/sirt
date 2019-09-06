<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>{{config('app.name')}} | @yield('title', config('app.name'))</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        
        
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/web.png') }}">
        

        
    </head>
    <body class="antialiased font-sans">
        <div class="md:flex min-h-screen">
            <center>
                <p class="z-depth-3">
                  <img src="http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C" class="img-responsive" width="342" height="89">
                </p>
              </center>
            

                
                        @yield('icon', __('error'))

                    
                        @yield('code', __('Oh no'))
                    

                    
                        @yield('message')
                    

                    
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

            

            
        </div>
    </body>
    
</html>
