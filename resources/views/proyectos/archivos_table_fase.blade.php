<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivosDeUnProyecto">
    <thead>
      <tr>
        <th>Archivo</th>
        <th style="width: 10%">Descargar</th>
        @if ( \Session::get('login_role') == App\User::IsGestor() )
          @if ($proyecto->fase->nombre == 'Inicio')
            <th style="width: 10%">Eliminar</th>
          @elseif ($proyecto->fase->nombre == 'Planeación')
            <th style="width: 10%">Eliminar</th>
          @elseif ($proyecto->fase->nombre == 'Ejecución')
            <th style="width: 10%">Eliminar</th>
          @endif
        @endif
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>