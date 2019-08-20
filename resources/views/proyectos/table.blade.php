@if(\Session::get('login_role') == App\User::IsGestor())
<table id="tblproyectosGestorPorAnho" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de Proyecto</th>
      <th>Nombre</th>
      <th>Sublínea</th>
      <th>Estado</th>
      <th>Revisado Final</th>
      <th>Talentos</th>
      <th>Detalles</th>
      <th>Editar</th>
      <th>Entregables</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>
        <input type="text" name="codigo_proyecto" class="codigo_proyecto" placeholder="Buscar por Código de Proyecto">
      </th>
      <th>
        <input type="text" name="nombre" class="nombre" placeholder="Buscar por Nombre">
      </th>
      <th>
        <input type="text" name="sublinea_nombre" class="sublinea_nombre" placeholder="Buscar por Sublinea">
      </th>
      <th>
        <input type="text" name="estado_nombre" class="estado_nombre" placeholder="Buscar por Estado">
      </th>
      <th>
        <input type="text" name="revisado_final" class="revisado_final" placeholder="Buscar por Revisado Final">
      </th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  <tbody>

  </tbody>
</table>
@endif

@if(\Session::get('login_role') == App\User::IsDinamizador())
<table id="tblproyectosDelNodoPorAnho" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de Proyecto</th>
      <th>Gestor</th>
      <th>Nombre</th>
      <th>Sublínea</th>
      <th>Estado</th>
      <th>Revisado Final</th>
      <th>Talentos</th>
      <th>Detalles</th>
      <th>Editar</th>
      <th>Entregables</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>
        <input type="text" name="codigo_proyecto" id="codigo_proyecto_tblProyectosDelNodoPorAnho" placeholder="Buscar por Código de Proyecto">
      </th>
      <th>
        <input type="text" name="gestor" id="gestor_tblProyectosDelNodoPorAnho" placeholder="Buscar por Gestor">
      </th>
      <th>
        <input type="text" name="nombre" id="nombre_tblProyectosDelNodoPorAnho" placeholder="Buscar por Nombre">
      </th>
      <th>
        <input type="text" name="sublinea_nombre" id="sublinea_nombre_tblProyectosDelNodoPorAnho" placeholder="Buscar por Sublinea">
      </th>
      <th>
        <input type="text" name="estado_nombre" id="estado_nombre_tblProyectosDelNodoPorAnho" placeholder="Buscar por Estado">
      </th>
      <th>
        <input type="text" name="revisado_final" id="revisado_final_tblProyectosDelNodoPorAnho" placeholder="Buscar por Revisado Final">
      </th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  <tbody>

  </tbody>
</table>
@endif

@if(\Session::get('login_role') == App\User::IsAdministrador())
<table id="tblproyectosDelNodoPorAnho_Administrador" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de Proyecto</th>
      <th>Gestor</th>
      <th>Nombre</th>
      <th>Sublínea</th>
      <th>Estado</th>
      <th>Revisado Final</th>
      <th>Talentos</th>
      <th>Detalles</th>
      <th>Entregables</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>
        <input type="text" name="codigo_proyecto" id="codigo_proyecto_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por Código de Proyecto">
      </th>
      <th>
        <input type="text" name="gestor" id="gestor_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por Gestor">
      </th>
      <th>
        <input type="text" name="nombre" id="nombre_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por Nombre">
      </th>
      <th>
        <input type="text" name="sublinea_nombre" id="sublinea_nombre_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por Sublinea">
      </th>
      <th>
        <input type="text" name="estado_nombre" id="estado_nombre_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por Estado">
      </th>
      <th>
        <input type="text" name="revisado_final" id="revisado_final_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por Revisado Final">
      </th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  <tbody>

  </tbody>
</table>
@endif
