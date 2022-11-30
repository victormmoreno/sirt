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
    @forelse($users as $user)
        <tr>
            <td>
                {{isset($user->tipodocumento) ? $user->tipodocumento : __('No register')}}
            </td>
            <td>
                {{isset($user->expedicion) ? $user->expedicion : __('No register')}}
            </td>
            <td>
                {{isset($user->documento) ? $user->documento : __('No register')}}
            </td>
            <td>
                {{isset($user->usuario) ? $user->usuario : __('No register')}}
            </td>
            <td>
                {{isset($user->fechanacimiento) ? $user->fechanacimiento : __('No register')}}

            </td>
            <td>
                {{isset($user->email) ? $user->email : __('No register')}}
            </td>
            <td>
                {{isset($user->celular) ? $user->celular : (isset($user->telefono) ? $user->telefono : 'No registra')}}
            </td>
            <td>
                {{isset($user->genero) ? $user->genero : __('No register')}}
            </td>
            <td>
                {{isset($user->grupo_sanguineo) ? $user->grupo_sanguineo : __('No register')}}
            </td>
            <td>
                {{isset($user->estrato) ? $user->estrato : __('No register')}}
            </td>
            <td>
                {{isset($user->direccion) ? $user->direccion : __('No register')}}
            </td>
            <td>
                {{isset($user->residencia) ? $user->residencia : __('No register')}}
            </td>
            <td>
                {{isset($user->etnia) ? $user->etnia : __('No register')}}
            </td>
            <td>
                {{isset($user->grado_discapacidad) ? $user->grado_discapacidad : __('No register')}}
            </td>
            <td>
                {{isset($user->descripcion_grado_discapacidad) ? $user->descripcion_grado_discapacidad : __('No register')}}
            </td>
            <td>
                {{isset($user->eps) ? $user->eps : __('No register')}}
            </td>
            <td>
                {{isset($user->eps) ? $user->eps : __('No register')}}
            </td>
            <td>
                {{isset($user->otra_eps) ? $user->otra_eps : __('No register')}}
            </td>
            <td>
                {{isset($user->institucion) ? $user->institucion : __('No register')}}
            </td>
            <td>
                {{isset($user->titulo_obtenido) ? $user->titulo_obtenido : __('No register')}}
            </td>
            <td>
                {{isset($user->fecha_terminacion) ? $user->fecha_terminacion : __('No register')}}
            </td>
            <td>
                {{isset($user->ocupaciones) ? $user->ocupaciones : __('No register')}}
            </td>
            <td>
                {{isset($user->roles) ? $user->roles : __('No register')}}
            </td>
            <td>
                {{$user->estado == \App\User::IsActive() && $user->deleted_at == null ? 'Habilitado' : 'Inhabilitado desde:'. optional($user->deleted_at)->isoFormat('DD/MM/YYYY')}}
            </td>
        </tr>
    @empty
        No se encontraron resultados
    @endforelse
    </tbody>
</table>
