@if (session()->get('login_role') != App\User::IsTalento())
    <table id="ideas_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
        <thead>
        <tr>
            <th>Nodo de registro</th>
            <th>Código de la Idea</th>
            <th>Fecha de Registro</th>
            <th>Persona</th>
            <th>Correo</th>
            <th>Contacto</th>
            <th>Nombre de la Idea</th>
            <th>Estado</th>
            <th>Detalles</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@else
    <table id="ideas_talento" class="display responsive-table datatable-example dataTable" style="width: 100%">
        <thead>
        <tr>
            <th>Código de la Idea</th>
            <th>Nodo donde se presenta</th>
            <th>Nombre de la Idea</th>
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