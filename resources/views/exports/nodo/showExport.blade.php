<table>
    <thead>
        <tr>
            <th>Nodo</th>
            <th>Rol / Linea</th>
            <th>Número de documento</th>
            <th>Consultor / Experto</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Celular</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->nodo }}</td>
                <td>{{ $user->role }} / {{ $user->linea }}</td>
                <td>{{ $user->documento }}</td>
                <td>{{ $user->nombres }} {{ $user->apellidos }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telefono }}</td>
                <td>{{ $user->celular }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


