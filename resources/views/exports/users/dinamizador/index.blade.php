<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table>
    <thead>
        <tr>
            <th>
                Tecnoparque
            </th>
            <th>
                Tipo Documento
            </th>
            <th>
                Documento
            </th>
            <th>
                Lugar Expedición Documento
            </th>
            <th>
                Nombre Completo
            </th>
            <th>
                Fecha de Nacimiento
            </th>
            <th>
                Edad
            </th>
            <th>
                Correo Electrónico
            </th>
            <th>
                Telefono
            </th>
            <th>
                Celular
            </th>
            <th>
                Dirección
            </th>
            <th>
                Lugar de residencia
            </th>
            <th>
                Genero
            </th>
            <th>
                Grupo Sanguineo
            </th>
            <th>
                Eps
            </th>
            <th>
                Otra Eps
            </th>
            <th>
                Grado Escolaridad
            </th>
            <th>
                Institución
            </th>
            <th>
                Titulo Obtenido
            </th>
            <th>
                Fecha Terminacion
            </th>
            <th>
                Ocupaciones
            </th>
            <th>
                Otra Ocupación
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                Tecnoparque Nodo {{$user->dinamizador->nodo->entidad->nombre}}
            </td>
            <td>
                {{$user->tipodocumento->nombre}}
            </td>
            <td>
                {{$user->documento}}
            </td>
            <td>
                {{$user->ciudadexpedicion->nombre}} ({{$user->ciudadexpedicion->departamento->nombre}})
            </td>
            <td>
                {{$user->nombres}} {{$user->apellidos}}
            </td>
            <td>
                {{$user->fechanacimiento->isoFormat('LL')}}
            </td>
            <td>
                {{$user->fechanacimiento->age}} años
            </td>
            <td>
                {{$user->email}}
            </td>
            <td>
                {{!empty($user->telefono) ? $user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($user->celular) ? $user->celular : 'No registra'}}
            </td>
            <td>
                {{!empty($user->direccion) ? $user->direccion : 'No registra'}}
            </td>
            <td>
                {{$user->ciudad->nombre}} ({{$user->ciudad->departamento->nombre}})
            </td>
            <td>
                {{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}
            </td>
            <td>
                {{$user->gruposanguineo->nombre}}
            </td>
            <td>
                {{$user->eps->nombre}}
            </td>
            <td>
                {{!empty($user->otra_eps) ? $user->otra_eps : 'No registra'}}
            </td>
            <td>
                {{$user->gradoescolaridad->nombre}}
            </td>
            <td>
                {{!empty($user->institucion) ? $user->institucion : 'No registra'}}
            </td>
            <td>
                {{!empty($user->titulo_obtenido) ? $user->titulo_obtenido : 'No registra'}}
            </td>
            <td>
                {{$user->fecha_terminacion->isoFormat('LL')}}
            </td>
            <td>
                {{$user->getOcupacionesNames()->implode(', ') ? : 'No registra'}}
            </td>
            <td>
                {{!empty($user->otra_ocupacion) ? $user->otra_ocupacion : 'No registra'}}
            </td>
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
