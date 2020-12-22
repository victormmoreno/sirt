<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivosDeUnaArticulacion">
    <thead>
        <tr>
            <th>Archivo</th>
            <th style="width: 10%">Descargar</th>
            @if ( \Session::get('login_role') == App\User::IsGestor() )
            @if ($articulacion->fase->nombre == 'Inicio')
            <th style="width: 10%">Eliminar</th>
            @elseif ($articulacion->fase->nombre == 'Planeación')
            <th style="width: 10%">Eliminar</th>
            @elseif ($articulacion->fase->nombre == 'Ejecución')
            <th style="width: 10%">Eliminar</th>
            @elseif ($articulacion->fase->nombre == 'Suspendido')
            <th style="width: 10%">Eliminar</th>
            @endif
            @endif
        </tr>
    </thead>
</table>