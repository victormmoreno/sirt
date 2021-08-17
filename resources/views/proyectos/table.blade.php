@if(\Session::get('login_role') == App\User::IsGestor())
<table id="tblproyectosGestorPorAnho" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de Proyecto</th>
      <th>Nombre</th>
      <th>Fase</th>
      <th>Información</th>
      <th>Proceso</th>
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
        <input type="text" name="nombre_fase" class="sublinea_nombre" placeholder="Buscar por Fase">
      </th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  <tbody>

  </tbody>
</table>
@endif

@if(\Session::get('login_role') == App\User::IsDinamizador() || \Session::get('login_role') == App\User::IsInfocenter())
<table id="tblproyectosDelNodoPorAnho" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de Proyecto</th>
      <th>Experto</th>
      <th>Nombre</th>
      <th>Sublínea</th>
      <th>Fase</th>
      <th>Información</th>
      <th>Proceso</th>
      <th>Trazabilidad</th>
      <th>Horas de expertos</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>
        <input type="text" name="codigo_proyecto" id="codigo_proyecto_tblProyectosDelNodoPorAnho" placeholder="Buscar por código de proyecto">
      </th>
      <th>
        <input type="text" name="gestor" id="gestor_tblProyectosDelNodoPorAnho" placeholder="Buscar por experto">
      </th>
      <th>
        <input type="text" name="nombre" id="nombre_tblProyectosDelNodoPorAnho" placeholder="Buscar por nombre">
      </th>
      <th>
        <input type="text" name="sublinea_nombre" id="sublinea_nombre_tblProyectosDelNodoPorAnho" placeholder="Buscar por sublinea">
      </th>
      <th>
        <input type="text" name="nombre_fase" id="fase_nombre_tblProyectosDelNodoPorAnho" placeholder="Buscar por fase">
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
      <th>Experto</th>
      <th>Nombre</th>
      <th>Sublínea</th>
      <th>Fase</th>
      <th>Información</th>
      <th>Proceso</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>
        <input type="text" name="codigo_proyecto" id="codigo_proyecto_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por código de proyecto">
      </th>
      <th>
        <input type="text" name="gestor" id="gestor_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por experto">
      </th>
      <th>
        <input type="text" name="nombre" id="nombre_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por nombre">
      </th>
      <th>
        <input type="text" name="sublinea_nombre" id="sublinea_nombre_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por sublinea">
      </th>
      <th>
        <input type="text" name="nombre_fase" id="sublinea_nombre_tblproyectosDelNodoPorAnho_Administrador" placeholder="Buscar por fase">
      </th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  <tbody>

  </tbody>
</table>
@endif

@if (\Session::get('login_role') == App\User::IsTalento())
<table id="tblProyectoDelTalento" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <tr>
      <th>Código de Proyecto</th>
      <th>Experto</th>
      <th>Nombre</th>
      <th>Fase</th>
      <th>Información</th>
      <th>Proceso</th>
    </tr>
  </thead>
  <tbody>
  <tfoot>
    <tr>
      <th>
        <input type="text" name="codigo_proyecto" id="codigo_proyecto_tblproyectosDelTalento" placeholder="Buscar por código de proyecto">
      </th>
      <th>
        <input type="text" name="gestor" id="gestor_tblproyectosDelTalento" placeholder="Buscar por experto">
      </th>
      <th>
        <input type="text" name="nombre" id="nombre_tblproyectosDelTalento" placeholder="Buscar por nombre">
      </th>
      <th>
        <input type="text" name="Fase" id="sublinea_nombre_tblproyectosDelTalento" placeholder="Buscar por fase">
      </th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  </tbody>
</table>
@endif
