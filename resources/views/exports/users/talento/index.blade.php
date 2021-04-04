<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Número de Documento del Talento</th>
        <th>Nombres del Talento</th>
        <th>Apellidos del Talento</th>
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
        @foreach($talentos as $value)
        <tr>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->documento }}</td>
            <td>{{ $value->nombres }}</td>
            <td>{{ $value->apellidos }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->contactos }}</td>
            <td>{{ $value->genero }}</td>
            <td>{{ $value->tipo_sangre }}</td>
            <td>{{ $value->estrato }}</td>
            <td>{{ $value->ciudad_residencia }}</td>
            <td>{{ $value->direccion }}</td>
            <td>{{ $value->barrio }}</td>
            <td>{{ $value->fechanacimiento }}</td>
            <td>{{ $value->nombre_eps }}</td>
            <td>{{ $value->otra_eps }}</td>
            <td>{{ $value->nombre_etnia }}</td>
            <td>{{ $value->grado_discapacidad }}</td>
            <td>{{ $value->descripcion_grado_discapacidad }}</td>
            <td>{{ $value->nombre_gradoescolaridad }}</td>
            <td>{{ $value->institucion }}</td>
            <td>{{ $value->titulo_obtenido }}</td>
            <td>{{ $value->fecha_terminacion }}</td>
            <td>{{ $value->nombre_tipotalento }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
