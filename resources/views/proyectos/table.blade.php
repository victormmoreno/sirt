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
  <tbody>

  </tbody>
</table>
@endif
