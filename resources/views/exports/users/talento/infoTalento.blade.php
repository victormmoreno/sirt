<table>
    <thead>
        <tr>
            <th>Tipo Documento</th>
            <th>Número de Documento</th>
            <th>Nombre Completo</th>
            <th>Fecha de Nacimiento</th>
            <th>Correo Electrónico</th>
            <th>Celular</th>
            <th>Género</th>
            <th>Grupo sanguineo</th>
            <th>Estrato Social</th>
            <th>Dirección</th>
            <th>Ciudad de residencia</th>
            <th>Etnia a la que pertenece</th>
            <th>¿Tiene algún grado de discapacidad?</th>
            <th>¿Cuál es el grado de discapacidad?</th>
            <th>Eps</th>
            <th>Otra eps</th>
            <th>Grado de escolaridad</th>
            <th>Institución</th>
            <th>Título obtenido</th>
            <th>Fecha de terminación</th>
            <th>Tipo de talento</th>
        </tr>
    </thead>
    <tbody>
        @forelse($talentos as $user)
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
                {{isset($user->fechanacimiento) ?  $user->fechanacimiento->isoFormat('LL'): 'No registra'}}
            </td>
            <td>
                {{isset($user->email)? $user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($user->celular) ? $user->celular : 'No registra'}}
            </td>
            <td>
                {{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}
            </td>
            <td>
                {{!empty($user->grupo_sanguineo) ? $user->grupo_sanguineo : 'No registra'}}
            </td>
            <td>
                {{!empty($user->estrato) ? $user->estrato : 'No registra'}}
            </td>
            <td>
                {{!empty($user->direccion) ? $user->direccion : 'No registra'}}
            </td>
            <td>
                {{!empty($user->residencia) ? $user->residencia : 'No registra'}}
            </td>
            <td>
                {{!empty($user->etnia) ? $user->etnia : 'No registra'}}
            </td>
            <td>
                {{!empty($user->grado_discapacidad) ? $user->grado_discapacidad : 'No registra'}}
            </td>
            <td>
                {{!empty($user->descripcion_grado_discapacidad) ? $user->descripcion_grado_discapacidad : 'No registra'}}
            </td>
            <td>
                {{!empty($user->eps) ? $user->eps : 'No registra'}}
            </td>
            <td>
                {{!empty($user->otra_eps) ? $user->otra_eps : 'No registra'}}
            </td>
            <td>
                {{!empty($user->grado_escolaridad) ? $user->grado_escolaridad : 'No registra'}}
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
                {{!empty($user->tipotalento) ? $user->tipotalento : 'No registra'}}
            </td>
        </tr>
        @empty
            No se encontraron resultados
        @endforelse
    </tbody>
</table>
