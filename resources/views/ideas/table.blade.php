@if(\Session::get('login_role') == App\User::IsTalento())
<table id="tbl_IdeasDelTalento" class="display responsive-table datatable-example dataTable" style="width: 100%">
    <thead>
      <tr>
        <th>Código de la Idea</th>
        <th>Fecha de Registro</th>
        <th>Nombre de la Idea</th>
        <th>Estado</th>
        <th>Detalles</th>
        {{-- <th>Inhabilitar</th> --}}
      </tr>
    </thead>
    <tbody>

    </tbody>
</table>
@endif