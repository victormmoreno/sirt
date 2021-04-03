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
            <th>Extensión</th>
            <th>Roles</th>
            <th>Acceso sistema</th>
        </tr>
    </thead>
    <tbody>
        @foreach($infocenters as  $infocenter)
        <tr>
            <td>
                {{$infocenter->user->present()->userTipoDocuento()}}
            </td>
            <td>
                {{$infocenter->user->present()->userLugarExpedicionDocumento()}}
            </td>
            <td>
                {{$infocenter->user->present()->userDocumento()}}
            </td>
            <td>
                {{$infocenter->user->present()->userFullName()}}
            </td>
            <td>
                {{$infocenter->user->present()->userFechaNacimiento()}}
            </td>
            <td>
                {{$infocenter->user->present()->userEmail()}}
            </td>
            <td>
                {{isset($infocenter->user->celular) ? $infocenter->user->celular : isset($infocenter->user->telefono) ? $infocenter->user->telefono : 'No registra'}}
            </td>
            <td>
                {{$infocenter->user->present()->userGenero()}}
            </td>
            <td>
                {{$infocenter->user->present()->userGrupoSanguineo()}}
            </td>
            <td>
                {{$infocenter->user->present()->userEstrato()}}
            </td>
            <td>
                {{$infocenter->user->present()->userDireccion()}}
            </td>
            <td>
                {{$infocenter->user->present()->userLugarResidencia()}}
            </td>
            <td>
                {{$infocenter->user->present()->userEtnia()}}
            </td>
            <td>
                {{$infocenter->user->present()->userGradoDiscapacidad()}}
            </td>
            <td>
                {{$infocenter->user->present()->userDescripcionGradoDiscapacidad()}}
            </td>
            <td>
                {{$infocenter->user->present()->userEps()}}
            </td>
            <td>
                {{$infocenter->user->present()->userEps()}}
            </td>
            <td>
                {{$infocenter->user->present()->userOtraEps()}}
            </td>
            <td>
                {{$infocenter->user->present()->userInstitucion()}}
            </td>
            <td>
                {{$infocenter->user->present()->userTituloObtenido()}}
            </td>
            <td>
                {{$infocenter->user->present()->userFechaTerminacion()}}
            </td>
            <td>
                {{$infocenter->user->present()->userOcupacionesNames()}}
            </td>
            <td>{{isset($infocenter->user->infocenter)? $infocenter->user->infocenter->extension : 'No registra'}}</td>
            <td>
                {{ $infocenter->user->present()->userRolesNames()}}
            </td>
            <td>
                {{ $infocenter->user->present()->userAcceso()}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
