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
        @foreach($ingresos as  $ingreso)
        <tr>
            <td>
                {{$ingreso->user->present()->userTipoDocuento()}}
            </td>
            <td>
                {{$ingreso->user->present()->userLugarExpedicionDocumento()}}
            </td>
            <td>
                {{$ingreso->user->present()->userLugarExpedicionDocumento()}}
            </td>
            <td>
                {{$ingreso->user->present()->userDocumento()}}
            </td>
            <td>
                {{$ingreso->user->present()->userFullName()}}
            </td>
            <td>
                {{$ingreso->user->present()->userFechaNacimiento()}}
            </td>
            <td>
                {{$ingreso->user->present()->userEmail()}}
            </td>
            <td>
                {{isset($ingreso->user->celular) ? $ingreso->user->celular : isset($ingreso->user->telefono) ? $ingreso->user->telefono : 'No registra'}}
            </td>
            <td>
                {{$ingreso->user->present()->userGenero()}}
            </td>
            <td>
                {{$ingreso->user->present()->userGrupoSanguineo()}}
            </td>
            <td>
                {{$ingreso->user->present()->userEstrato()}}
            </td>
            <td>
                {{$ingreso->user->present()->userDireccion()}}
            </td>
            <td>
                {{$ingreso->user->present()->userLugarResidencia()}}
            </td>
            <td>
                {{$ingreso->user->present()->userEtnia()}}
            </td>
            <td>
                {{$ingreso->user->present()->userGradoDiscapacidad()}}
            </td>
            <td>
                {{$ingreso->user->present()->userDescripcionGradoDiscapacidad()}}
            </td>
            <td>
                {{$ingreso->user->present()->userEps()}}
            </td>
            <td>
                {{$ingreso->user->present()->userEps()}}
            </td>
            <td>
                {{$ingreso->user->present()->userOtraEps()}}
            </td>
            <td>
                {{$ingreso->user->present()->userInstitucion()}}
            </td>
            <td>
                {{$ingreso->user->present()->userTituloObtenido()}}
            </td>
            <td>
                {{$ingreso->user->present()->userFechaTerminacion()}}
            </td>
            <td>
                {{$ingreso->user->present()->userOcupacionesNames()}}
            </td>
            <td>
                {{ $ingreso->user->present()->userRolesNames()}}
            </td>
            <td>
                {{ $ingreso->user->present()->userAcceso()}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
