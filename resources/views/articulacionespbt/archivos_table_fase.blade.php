<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivosArticulacion">
    <thead>
        <tr>
            <th>Archivo</th>
            <th style="width: 10%">Descargar</th>
            @if ( \Session::get('login_role') == App\User::IsArticulador() )
                @if ($articulacion->present()->articulacionPbtNameFase() == 'Inicio')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($articulacion->present()->articulacionPbtNameFase() == 'Ejecución')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($articulacion->present()->articulacionPbtNameFase() == 'Suspendido')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($articulacion->present()->articulacionPbtNameFase() == 'Cierre')
                    <th style="width: 10%">Eliminar</th>
                @endif
            @endif
        </tr>
    </thead>
</table>
