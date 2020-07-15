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
            <th>
                Roles
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                {{$user->tipodocumento->nombre}}
            </td>
            <td>
                {{isset($user->documento) ? $user->documento : 'No registra'}}
            </td>
            <td>
                {{$user->ciudadexpedicion->nombre}} ({{$user->ciudadexpedicion->departamento->nombre}})
            </td>
            <td>
                {{$user->nombres}} {{$user->apellidos}}
            </td>
            <td>
                {{isset($user->fechanacimiento) ? $user->fechanacimiento->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
            {{isset($user->fechanacimiento->age) ? $user->fechanacimiento->age: 'No registra'}} {{isset($user->fechanacimiento) ? "años" : ""}}
            </td>
            <td>
                {{isset($user->email)? $user->email: 'No registra'}}
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
                {{isset($user->fecha_terminacion) ? $user->fecha_terminacion->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{$user->getOcupacionesNames()->implode(', ') ? : 'No registra'}}
            </td>
            <td>
                {{!empty($user->otra_ocupacion) ? $user->otra_ocupacion : 'No registra'}}
            </td>
            <td>
                {{$user->getRoleNames()->implode(', ') ? : 'No registra'}}
            </td>
            <td>
                @if(isset($user->dinamizador))
                Tecnoparque Nodo {{$user->dinamizador->nodo->entidad->nombre}}
                @elseif(isset($user->gestor))
                Tecnoparque Nodo {{$user->gestor->nodo->entidad->nombre}}
                @elseif(isset($user->infocenter))
                Tecnoparque Nodo {{$user->infocenter->nodo->entidad->nombre}}
                @elseif(isset($user->ingreso))
                Tecnoparque Nodo {{$user->ingreso->nodo->entidad->nombre}}
                @else
                    No aplica
                @endif
                
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
