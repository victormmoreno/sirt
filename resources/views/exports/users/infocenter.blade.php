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
            <th>Extensión</th>
            <th>Roles</th>
            <th>Acceso sistema</th>>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                {{isset($user->infocenter->nodo->entidad)? $user->infocenter->nodo->entidad->nombre : 'No registra'}}
            </td>
            <td>
                {{$user->present()->userTipoDocuento()}}
            </td>
            <td>
                {{$user->present()->userLugarExpedicionDocumento()}}
            </td>
            <td>
                {{$user->present()->userDocumento()}}
            </td>
            <td>
                {{$user->present()->userFullName()}}
            </td>
            <td>
                {{$user->present()->userFechaNacimiento()}}
            </td>
            <td>
                {{$user->present()->userEmail()}}
            </td>
            <td>
                {{isset($user->celular) ? $user->celular : isset($user->telefono) ? $user->telefono : 'No registra'}}
            </td>
            <td>
                {{$user->present()->userGenero()}}
            </td>
            <td>
                {{$user->present()->userGrupoSanguineo()}}
            </td>
            <td>
                {{$user->present()->userEstrato()}}
            </td>
            <td>
                {{$user->present()->userDireccion()}}
            </td>
            <td>
                {{$user->present()->userLugarResidencia()}}
            </td>
            <td>
                {{$user->present()->userEtnia()}}
            </td>
            <td>
                {{$user->present()->userGradoDiscapacidad()}}
            </td>
            <td>
                {{$user->present()->userDescripcionGradoDiscapacidad()}}
            </td>
            <td>
                {{$user->present()->userEps()}}
            </td>
            <td>
                {{$user->present()->userEps()}}
            </td>
            <td>
                {{$user->present()->userOtraEps()}}
            </td>
            <td>
                {{$user->present()->userInstitucion()}}
            </td>
            <td>
                {{$user->present()->userTituloObtenido()}}
            </td>
            <td>
                {{$user->present()->userFechaTerminacion()}}
            </td>
            <td>
                {{$user->present()->userOcupacionesNames()}}
            </td>
            <td>{{isset($user->infocenter)? $user->extension : 'No registra'}}</td>
            <td>
                {{ $user->present()->userRolesNames()}}
            </td>
            <td>
                {{ $user->present()->userAcceso()}}
            </td>
        </tr>
        @empty
            No se encontraron resultados
        @endforelse
    </tbody>
</table>
