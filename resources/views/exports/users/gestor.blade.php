<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Linea Tecnologica</th>
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
        <th>Honorarios mensuales</th>
        <th>Roles</th>
        <th>Acceso sistema</th>
    </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                {{isset($user->gestor->nodo->entidad)? $user->gestor->nodo->entidad->nombre : 'No registra'}}
            </td>
            <td>
                {{$gestor->user->present()->userTipoDocuento()}}
            </td>
            <td>
                {{$gestor->user->present()->userLugarExpedicionDocumento()}}
            </td>
            <td>
                {{$gestor->user->present()->userDocumento()}}
            </td>
            <td>
                {{$gestor->user->present()->userFullName()}}
            </td>
            <td>
                {{$gestor->user->present()->userFechaNacimiento()}}
            </td>
            <td>
                {{$gestor->user->present()->userEmail()}}
            </td>
            <td>
                {{isset($gestor->user->celular) ? $gestor->user->celular : isset($gestor->user->telefono) ? $gestor->user->telefono : 'No registra'}}
            </td>
            <td>
                {{$gestor->user->present()->userGenero()}}
            </td>
            <td>
                {{$gestor->user->present()->userGrupoSanguineo()}}
            </td>
            <td>
                {{$gestor->user->present()->userEstrato()}}
            </td>
            <td>
                {{$gestor->user->present()->userDireccion()}}
            </td>
            <td>
                {{$gestor->user->present()->userLugarResidencia()}}
            </td>
            <td>
                {{$gestor->user->present()->userEtnia()}}
            </td>
            <td>
                {{$gestor->user->present()->userGradoDiscapacidad()}}
            </td>
            <td>
                {{$gestor->user->present()->userDescripcionGradoDiscapacidad()}}
            </td>
            <td>
                {{$gestor->user->present()->userEps()}}
            </td>
            <td>
                {{$gestor->user->present()->userEps()}}
            </td>
            <td>
                {{$gestor->user->present()->userOtraEps()}}
            </td>
            <td>
                {{$gestor->user->present()->userInstitucion()}}
            </td>
            <td>
                {{$gestor->user->present()->userTituloObtenido()}}
            </td>
            <td>
                {{$gestor->user->present()->userFechaTerminacion()}}
            </td>
            <td>
                {{$gestor->user->present()->userOcupacionesNames()}}
            </td>
            <td>{{ isset($gestor) ? $gestor->lineatecnologica->abreviatura : ''}} - {{ isset($gestor) ? $gestor->lineatecnologica->nombre : 'No registra'}}</td>
            <td>$ {{isset($gestor->honorarios) ? number_format($gestor->honorarios) : 0}}</td>
            <td>
                {{ $gestor->user->present()->userRolesNames()}}
            </td>
            <td>
                {{ $gestor->user->present()->userAcceso()}}
            </td>
        </tr>
        @empty
            No se encontraron resultados
        @endforelse
    </tbody>
</table>
