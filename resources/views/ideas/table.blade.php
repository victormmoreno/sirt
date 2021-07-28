@if(\Session::get('login_role') == App\User::IsTalento())
<table id="tbl_IdeasDelTalento" class="display responsive-table datatable-example dataTable" style="width: 100%">
    <thead>
        <tr>
            <th>Código de la idea</th>
            <th>Nodo donde se presenta</th>
            <th>Nombre de la idea</th>
            <th>Estado</th>
            <th>Detalles</th>
            <th>Postular</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
@endif
@if(\Session::get('login_role') == App\User::IsArticulador())
<table id="tbl_IdeasEnviadasDelNodo" class="display responsive-table datatable-example dataTable" style="width: 100%">
    <thead>
        <tr>
            <th>Código de la idea</th>
            <th>Nombre de la idea</th>
            <th>Talento</th>
            <th>Estado</th>
            <th>Detalles</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endif
