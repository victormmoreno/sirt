<table id="articulacionesNodo_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de la Articulación</th>
      <th>Nombre</th>
      <th>Tipo de Articulación</th>
      <th>Gestor a cargo</th>
      <th>Estado</th>
      <th>Revisado Final</th>
      <th>Detalles</th>
      <th>Entregables</th>
      @if ( \Session::get('login_role') == App\User::IsGestor() )
        <th>Editar</th>
      @endif
    </tr>
  </thead>
</table>
