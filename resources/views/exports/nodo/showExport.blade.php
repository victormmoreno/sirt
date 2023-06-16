<table>
    <thead>
        <tr>
            <th>Nodo</th>
            <th>Rol / Linea</th>
            <th>Número de documento</th>
            <th>Funcionario</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Celular</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->nodo }}</td>
                <td>{{ $user->roles }} / {{ $user->linea }}</td>
                <td>{{ $user->documento }}</td>
                <td>{{ $user->usuario }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telefono }}</td>
                <td>{{ $user->celular }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


