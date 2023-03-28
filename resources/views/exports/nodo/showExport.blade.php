<table>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th>{{ $user->nodo }}</th>
            <th>{{ $user->role }} / {{ $user->linea }}</th>
            <th>{{ $user->documento }}</th>
            <th>{{ $user->nombres }} {{ $user->apellidos }}</th>
            <th>{{ $user->email }}</th>
            <th>{{ $user->telefono }}</th>
            <th>{{ $user->celular }}</th>
        </tr>
        @endforeach
    </tbody>
</table>


