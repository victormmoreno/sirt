<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivosArticulacion">
    <thead>
      <tr>
        <th>Archivo</th>
        <th style="width: 10%">Descargar</th>
        @if ( \Session::get('login_role') == App\User::IsArticulador() )
          @if ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Inicio')
            <th style="width: 10%">Eliminar</th>

          @elseif ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Ejecución')
            <th style="width: 10%">Eliminar</th>
          @elseif ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Suspendido')
            <th style="width: 10%">Eliminar</th>
          @elseif ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Cierre')
            <th style="width: 10%">Eliminar</th>
          @endif
        @endif
        @if(isset($actividad))
          @if(request()->is(route('articulacion.miembros', $actividad->articulacionpbt->id))))
            <th style="width: 10%">Eliminar</th>
          @endif
        @endif
      </tr>
    </thead>
</table>