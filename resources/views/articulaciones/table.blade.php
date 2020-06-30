@if (Session::get('login_role') == App\User::IsGestor())
  <table id="articulacionesGestor_table" class="display responsive-table datatable-example dataTable">
    <thead>
      <tr>
        <th>Código de la Articulación</th>
        <th>Nombre</th>
        <th>Fase</th>
        <th>Información</th>
        <th>Proceso</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th><input type="text" name="codigo_articulacion_GestorTable" id="codigo_articulacion_GestorTable" placeholder="Buscar por código de articulación"></th>
        <th><input type="text" name="nombre_GestorTable" id="nombre_GestorTable" placeholder="Buscar por nombre"></th>
        <th><input type="text" name="fase_GestorTable" id="fase_GestorTable" placeholder="Buscar por fase"></th>
        <th></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
@endif
@if (Session::get('login_role') == App\User::IsDinamizador())
  <table id="articulacionesNodo_table" class="display responsive-table datatable-example dataTable">
    <thead>
      <tr>
        <th>Código de la Articulación</th>
        <th>Gestor</th>
        <th>Nombre</th>
        <th>Fase</th>
        <th>Información</th>
        <th>Proceso</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th><input type="text" name="codigo_articulacion_DinamizadorTable" id="codigo_articulacion_DinamizadorTable" placeholder="Buscar por código de articulación"></th>
        <th><input type="text" name="nombre_GestorDinamizadorTable" id="nombre_GestorDinamizadorTable" placeholder="Buscar por gestor"></th>
        <th><input type="text" name="nombre_DinamizadorTable" id="nombre_DinamizadorTable" placeholder="Buscar por nombre"></th>
        <th><input type="text" name="fase_DinamizadorTable" id="fase_DinamizadorTable" placeholder="Buscar por fase"></th>
        <th></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
@endif
@if (Session::get('login_role') == App\User::IsAdministrador())
  <table id="articulacionesNodo_table" class="display responsive-table datatable-example dataTable">
    <thead>
      <tr>
        <th>Código de la Articulación</th>
        <th>Nodo</th>
        <th>Gestor</th>
        <th>Nombre</th>
        <th>Fase</th>
        <th>Información</th>
        <th>Proceso</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th><input type="text" name="codigo_articulacion_AdministradorTable" id="codigo_articulacion_AdministradorTable" placeholder="Buscar por código de articulación"></th>
        <th><input type="text" name="nombre_nodoAdministradorTable" id="nombre_nodoAdministradorTable" placeholder="Buscar por nodo"></th>
        <th><input type="text" name="nombre_GestorAdministradorTable" id="nombre_GestorAdministradorTable" placeholder="Buscar por gestor"></th>
        <th><input type="text" name="nombre_AdministradorTable" id="nombre_AdministradorTable" placeholder="Buscar por nombre"></th>
        <th><input type="text" name="fase_AdministradorTable" id="fase_AdministradorTable" placeholder="Buscar por fase"></th>
        <th></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
@endif
