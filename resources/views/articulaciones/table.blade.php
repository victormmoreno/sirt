@if (Session::get('login_role') == App\User::IsGestor())
  <table id="articulacionesGestor_table" class="display responsive-table datatable-example dataTable">
    <thead>
      <tr>
        <th>Código de la Articulación</th>
        <th>Nombre</th>
        <th>Fase</th>
        <th>Detalles</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th><input type="text" name="codigo_articulacion_GestorTable" id="codigo_articulacion_GestorTable" placeholder="Buscar por código de articulación"></th>
        <th><input type="text" name="nombre_GestorTable" id="nombre_GestorTable" placeholder="Buscar por nombre"></th>
        <th><input type="text" name="fase_GestorTable" id="fase_GestorTable" placeholder="Buscar por fase"></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
@endif
