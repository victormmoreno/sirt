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
  <tfoot>
    <tr>
      <th><input type="text" name="email" class="codigo_articulacion" placeholder="Buscar por código de articulación"></th>
      <th><input type="text" name="nombre" class="nombre" placeholder="Buscar por nombre"></th>
      <th><input type="text" name="tipo_articulacion" class="tipo_articulacion" placeholder="Buscar por Tipo de Articulación"></th>
      <th><input type="text" name="nombre_completo_gestor" class="nombre_completo_gestor" placeholder="Buscar por Gestor"></th>
      <th><input type="text" name="estado" class="estado" placeholder="Buscar por Estado"></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
</table>
