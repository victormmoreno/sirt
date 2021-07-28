<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivosDeUnProyecto">
    <thead>
        <tr>
            <th>Archivo</th>
            <th style="width: 10%">Descargar</th>
            @if ( \Session::get('login_role') == App\User::IsGestor() )
                @if ($proyecto->present()->proyectoFase() == 'Inicio')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($proyecto->present()->proyectoFase() == 'Planeación')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($proyecto->present()->proyectoFase() == 'Ejecución')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($proyecto->present()->proyectoFase() == 'Suspendido')
                    <th style="width: 10%">Eliminar</th>
                @elseif ($proyecto->present()->proyectoFase() == 'Cierre')
                    <th style="width: 10%">Eliminar</th>
                @endif
            @endif
        </tr>
    </thead>
</table>
