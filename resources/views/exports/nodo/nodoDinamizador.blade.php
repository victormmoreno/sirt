<table>
    <thead>
        <tr>
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
        @forelse($dinamizadores as $dinamizador)
        <tr>
            <td>
                {{$dinamizador->user->present()->userTipoDocuento()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userLugarExpedicionDocumento()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userDocumento()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userFullName()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userFechaNacimiento()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userEmail()}}
            </td>
            <td>
                {{isset($dinamizador->user->celular) ? $dinamizador->user->celular : isset($dinamizador->user->telefono) ? $dinamizador->user->telefono : 'No registra'}}
            </td>
            <td>
                {{$dinamizador->user->present()->userGenero()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userGrupoSanguineo()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userEstrato()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userDireccion()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userLugarResidencia()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userEtnia()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userGradoDiscapacidad()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userDescripcionGradoDiscapacidad()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userEps()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userEps()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userOtraEps()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userInstitucion()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userTituloObtenido()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userFechaTerminacion()}}
            </td>
            <td>
                {{$dinamizador->user->present()->userOcupacionesNames()}}
            </td>
            <td>
                {{ $dinamizador->user->present()->userRolesNames()}}
            </td>
            <td>
                {{ $dinamizador->user->present()->userAcceso()}}
            </td>
        </tr>
        @empty
            No se encontraron resultados
        @endforelse
    </tbody>
</table>
