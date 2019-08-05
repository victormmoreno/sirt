<table id="charlasInformativasNodo_table" width="100%" class="display responsive-table datatable-example dataTable">
  <thead>
    <tr>
      <th>Código de la Charla</th>
      <th>Fecha</th>
      <th>Nodo</th>
      <th>Encargado</th>
      <th>Número de Asistentes</th>
      <th>Detalles</th>
      @if ( \Session::get('login_role') == App\User::IsInfocenter() )
        <th>Editar</th>
        <th>Inhabilitar</th>
      @endif
      <th>Evidencias</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>
