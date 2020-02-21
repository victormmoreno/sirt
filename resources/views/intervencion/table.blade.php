<table id="intervencionesNodo_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de la Articulación</th>
      <th>Nombre</th>
      <th>Gestor a cargo</th>
      <th>Estado</th>
      <th>Revisado Final</th>
      <th>Detalles</th>
      <th>Entregables</th>
      @if ( \Session::get('login_role') != App\User::IsAdministrador() )
        <th>Editar</th>
      @endif
      @if ( \Session::get('login_role') == App\User::IsDinamizador() )
        <th>Eliminar</th>
      @endif
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th><input type="text" name="email" class="codigo_articulacion" placeholder="Buscar por código de articulación"></th>
      <th><input type="text" name="nombre" class="nombre" placeholder="Buscar por nombre"></th>
      <th><input type="text" name="nombre_completo_gestor" class="nombre_completo_gestor" placeholder="Buscar por Gestor"></th>
      <th><input type="text" name="estado" class="estado" placeholder="Buscar por Estado"></th>
      <th></th>
      <th></th>
      <th></th>
      @if ( \Session::get('login_role') != App\User::IsAdministrador() )
        <th></th>
      @endif
      @if ( \Session::get('login_role') == App\User::IsDinamizador() )
        <th></th>
      @endif
    </tr>
  </tfoot>
</table>
