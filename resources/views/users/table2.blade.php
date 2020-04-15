@if(\Session::get('login_role') == App\User::IsDinamizador() || \Session::get('login_role') == App\User::IsInfocenter())
    <table id="{{$id}}" class="display responsive-table datatable-example dataTable" style="width: 100%">
@elseif(\Session::get('login_role') == App\User::IsAdministrador())
    <table id="talentoByAdministrador_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
@endif
  <thead>
    <tr>
        <th>Tipo Documento</th>
        <th>Docuemento</th>
        <th>Usuario</th>
        <th>Correo</th>
        <th>Celular</th>
        <th>Detalles</th>
    </tr>
  </thead>

</table>
