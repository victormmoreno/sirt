<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Tipo Documento</th>
        <th>Ciudad de Expedición Documento</th>
        <th>Número de Documento</th>
        <th>Nombre Completo</th>
        <th>Fecha de Nacimiento</th>
        <th>Correo Electrónico</th>
        <th>Celular</th>
        <th>Género</th>
        <th>Grupo sanguineo</th>
        <th>Estrato Social</th>
        <th>Dirección</th>
        <th>Lugar de residencia</th>
        <th>Etnia a la que pertenece</th>
        <th>¿Tiene algún grado de discapacidad?</th>
        <th>¿Cuál es el grado de discapacidad?</th>
        <th>Eps</th>
        <th>Otra eps</th>
        <th>Grado de escolaridad</th>
        <th>Institución</th>
        <th>Título obtenido</th>
        <th>Fecha de terminación</th>
        <th>Ocupaciones</th>
        <th>Roles</th>
        <th>Acceso sistema</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
            <td>
                {{isset($user->dinamizador->nodo->entidad)? $user->dinamizador->nodo->entidad->nombre : 'No registra'}}
            </td>
            <td>
                {{isset($user->tipodocumento)? $user->tipodocumento->nombre : 'No registra'}}
            </td>
            <td>
                {{!empty($user->ciudadexpedicion) ? "{$user->ciudadexpedicion->nombre} ({$user->ciudadexpedicion->departamento->nombre})" : 'No registra'}}
            </td>
            <td>
                {{isset($user->documento) ? $user->documento : 'No registra'}}
            </td>
            <td>
                {{isset($user->nombres) && isset($user->apellidos)   ? "{$user->nombres} {$user->apellidos}": 'No Registra'}}
            </td>
            <td>
                {{isset($user->fechanacimiento) ?  $user->fechanacimiento->isoFormat('LL'): 'No registra'}} 
            </td>
            <td>
                {{isset($user->email)? $user->email: 'No registra'}}
            </td>
            <td>
                {{isset($user->celular) ? $user->celular : isset($user->telefono) ? $user->telefono : 'No registra'}}
            </td>
            <td>
                {{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}
            </td>
            <td>
                {{!empty($user->grupoSanguineo) ? $user->grupoSanguineo->nombre : 'No registra'}}
            </td>
            <td>
                {{!empty($user->estrato) ? $user->estrato : 'No registra'}}
            </td>
            <td>
                {{!empty($user->direccion) ? $user->direccion : 'No registra'}}
            </td>
            <td>
                {{!empty($user->ciudad) ? "{$user->ciudad->nombre} ({$user->ciudad->departamento->nombre})" : 'No registra'}}
            </td>
            <td>
                {{!empty($user->etnia) ? $user->etnia->nombre : 'No registra'}}
            </td>
            <td>
                {{isset($user->grado_discapacidad)  && $user->grado_discapacidad == 1 ? 'SI' : 'No '}}
            </td>
            <td>
                {{isset($user->descripcion_grado_discapacidad) && $user->grado_discapacidad == 1 ? $user->descripcion_grado_discapacidad : 'No registra'}}
            </td>
            <td>
                {{isset($user->eps) ? $user->eps->nombre : 'No registra'}}
            </td>
            <td>
                {{!empty($user->otra_eps) ? $user->otra_eps : 'No Aplica'}}
            </td>
            <td>
                {{isset($user->gradoEscolaridad) ? $user->gradoEscolaridad->nombre : 'No registra'}}
            </td>
            <td>
                {{!empty($user->institucion) ? $user->institucion : 'No registra'}}
            </td>
            <td>
                {{!empty($user->titulo_obtenido) ? $user->titulo_obtenido : 'No registra'}}
            </td>
            <td>
                {{!empty($user->fecha_terminacion) ? $user->fecha_terminacion->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{$user->getOcupacionesNames()->implode(', ') ? : 'No registra'}}
            </td>
            <td>
                {{ $user->getRoleNames()->implode(', ')}}
            </td>
            <td>
                {{ $user->estado == App\User::IsActive() && $user->deleted_at == null ? 'Habilitado' : 'Inhabilitado'}}
            </td>
            {{-- <td>
                {{!empty($user->tipotalento) ? $user->tipotalento : 'No registra'}}
            </td> --}}
        </tr>
    @empty
            No se encontraron resultados
        
      @endforelse
    </tbody>
</table>
