<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Tipo Documento</th>
        <th>Número de Documento</th>
        <th>Nombre Completo</th>
        <th>Correo Electrónico</th>
        <th>Contacto</th>
        <th>Género</th>
        <th>Grupo sanguineo</th>
        <th>Estrato Social</th>
        <th>Ciudad de residencia</th>
        <th>Dirección</th>
        <th>Barrio</th>
        <th>Fecha de Nacimiento</th>
        <th>Eps</th>
        <th>Otra eps</th>
        <th>Etnia a la que pertenece</th>
        <th>¿Tiene algún grado de discapacidad?</th>
        <th>¿Cuál es el grado de discapacidad?</th>
        <th>Grado de escolaridad</th>
        <th>Institución</th>
        <th>Título obtenido</th>
        <th>Fecha de terminación</th>
        <th>Tipo de talento</th>
      </tr>
    </thead>
    <tbody>
      @foreach($talentos as $user)
        <tr>
            <td>
                {{isset($user->tipodocumento)? $user->tipodocumento : 'No registra'}}
            </td>
            <td>
                {{isset($user->documento) ? $user->documento : 'No registra'}}
            </td>
            <td>
                {{isset($user->nombre) ? $user->nombre: 'No Registra'}}
            </td>
            <td>
                {{isset($user->email)? $user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($user->contacto) ? $user->contacto : 'No registra'}}
            </td>
            <td>
                {{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}
            </td>
            
            <td>
            {{isset($user->fechanacimiento) ? $user->fechanacimiento: 'No registra'}} {{isset($user->fechanacimiento) ? "años" : ""}}
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
                {{isset($user->ciudad->nombre)?$user->ciudad->nombre:''}} ({{isset($user->ciudad->departamento->nombre)?$user->ciudad->departamento->nombre:'No registra'}})
            </td>
            
            <td>
                {{isset($user->gruposanguineo->nombre)? $user->gruposanguineo->nombre: 'No Registra'}}
            </td>
            <td>
                {{isset($user->eps->nombre)?$user->eps->nombre:'No registra'}}
            </td>
            <td>
                {{!empty($user->otra_eps) ? $user->otra_eps : 'No registra'}}
            </td>
            <td>
                {{isset($user->gradoescolaridad->nombre)?$user->gradoescolaridad->nombre:'No registra'}}
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
          <td>{{ $user->talento->tipotalento->nombre }}</td>
        </tr>
      @endforeach
    </tbody>
</table>
