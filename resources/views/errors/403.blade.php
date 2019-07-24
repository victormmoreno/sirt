<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name')}} | @yield('meta-title',   config('app.name') )</title>
  {{-- <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    --}}
  <!-- Fonts -->
  <link rel="stylesheet" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
  <link href="{{ asset('css/libs.css') }}" rel="stylesheet">
  <link href="{{ asset('sweetalert2/sweetalert2.css') }}" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/web.png') }}">
  @stack('style')
</head>
<body class="error-page page-403">
  <div class="mn-content">
    <main class="mn-inner">
      <div class="valign-wrapper center">
        <h1>
          <span>403</span>
        </h1>
        <span class="text-white">No tienes permisos para hacer esto</span><br>
      </div>
    </main>
  </div>
</body>
