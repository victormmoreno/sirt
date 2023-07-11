<table>
    <thead>
    <tr>
        <th>Nodo del proyecto</th>
        <th>Código de Proyecto</th>
        <th>Nombre de Proyecto</th>
        <th>Experto a cargo</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Idea de Proyecto</th>
        <th>Área de Conocimiento</th>
        <th>Otro área de conocimiento</th>
        <th>Fecha de Inicio de Proyecto</th>
        <th>Fase actual del proyecto</th>
        <th>Fecha de Cierre de Proyecto</th>
        <th>Año de cierre</th>
        <th>Mes de cierre</th>
        <th>TRL esperado</th>
        <th>TRL obtenido</th>
        <th>¿Recibido a través de fábrica de productividad?</th>
        <th>¿Recibido a través del área de emprendimiento SENA?</th>
        <th>¿El proyecto pertenece a la economía naranja?</th>
        <th>¿Qué tipo de proyecto de economía naranja?</th>
        <th>¿El proyecto está dirigido a discapacitados?</th>
        <th>¿A que tipo de personas en condición de discapacidad?</th>
        <th>¿Articulado con CT+i?</th>
        <th>¿Nombre del actor CT+i?</th>
        <th>¿Dirigido a área de emprendimiento SENA?</th>

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
        <th>¿Es madre cabeza de familia?</th>
        <th>Grado de escolaridad</th>
        <th>Institución</th>
        <th>Título obtenido</th>
        <th>Fecha de terminación</th>
    </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->nombre_nodo }}</td>
            <td>{{ $user->codigo_proyecto }}</td>
            <td>{{ $user->nombre_proyecto }}</td>
            <td>{{ $user->experto }}</td>
            <td>{{ $user->nombre_linea }}</td>
            <td>{{ $user->nombre_sublinea }}</td>
            <td>{{ $user->codigo_idea }} - {{ $user->nombre_idea }}</td>
            <td>{{ $user->nombre_area_conocimiento }}</td>
            <td>{{ $user->nombre_area_conocimiento == 'Otro' ? $user->otro_areaconocimiento : 'No aplica' }}</td>
            <td>{{ $user->fecha_inicio }}</td>
            <td>{{ $user->nombre_fase }}</td>
            <td>{{ $user->fecha_cierre }}</td>

            @if ($user->nombre_fase == 'Finalizado' || $user->nombre_fase == 'Cancelado')
                <td>{{ $user->anho }}</td>
            @else
                <td>El proyecto no se ha cerrado</td>
            @endif

            @if ($user->nombre_fase == 'Finalizado' || $user->nombre_fase == 'Cancelado')
                <td>{{ $user->mes }}</td>
            @else
                <td>El proyecto no se ha cerrado</td>
            @endif

            <td>{{ $user->trl_esperado }}</td>
            <td>{{ $user->trl_obtenido }}</td>
            <td>{{ $user->fabrica_productividad }}</td>
            <td>{{ $user->reci_ar_emp }}</td>
            <td>{{ $user->economia_naranja }}</td>
            <td>{{ $user->tipo_economianaranja }}</td>
            <td>{{ $user->dirigido_discapacitados }}</td>
            <td>{{ $user->tipo_discapacitados }}</td>
            <td>{{ $user->art_cti }}</td>
            <td>{{ $user->nom_act_cti }}</td>
            <td>{{ $user->diri_ar_emp }}</td>

            <td>{{ $user->documento }}</td>
            <td>{{ $user->nombres }}</td>
            <td>{{ $user->apellidos }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->celular }} / {{ $user->telefono }}</td>
            <td>{{ $user->genero }}</td>
            <td>{{ $user->nombre_gruposanguineo }}</td>
            <td>{{ $user->estrato }}</td>
            <td>{{ $user->ciudad_residencia }}</td>
            <td>{{ $user->direccion }}</td>
            <td>{{ $user->barrio }}</td>
            <td>{{ $user->fechanacimiento }}</td>
            <td>{{ $user->nombre_eps }}</td>
            <td>{{ $user->otra_eps }}</td>
            <td>{{ $user->etnia }}</td>
            <td>{{ $user->grado_discapacidad }}</td>
            <td>{{ $user->descripcion_grado_discapacidad }}</td>
            <td>{{ $user->mujerCabezaFamilia }}</td>
            <td>{{ $user->desplazadoPorViolencia }}</td>
            <td>{{ $user->institucion }}</td>
            <td>{{ $user->titulo_obtenido }}</td>
            <td>{{ $user->fecha_terminacion }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
