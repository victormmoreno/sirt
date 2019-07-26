<table id="visitantesRedTecnoparque_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
  <thead>
    <th>Documento de Identidad</th>
    <th>Tipo de Documento</th>
    <th>Tipo de Persona</th>
    <th>Nombre</th>
    <th>Correo Electrónico</th>
    <th>Contacto</th>
    @if ( \Session::get('login_role') == App\User::IsIngreso() )
      <th>Editar</th>
    @endif
  </thead>
  <tbody>

  </tbody>
</table>
