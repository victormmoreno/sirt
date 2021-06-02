<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Nodo del proyecto</th>
        <th>Nombre de Proyecto</th>
        <th>Gestor a cargo</th>
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
            <td>{{ $value->nodo_nombre }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->nombre_linea }}</td>
            <td>{{ $value->nombre_sublinea }}</td>
            <td>{{ $value->nombre_idea }}</td>
            <td>{{ $value->nombre_areaconocimiento }}</td>
            <td>{{ $value->otro_areaconocimiento }}</td>
            <td>{{ $value->fecha_inicio }}</td>
            <td>{{ $value->nombre_fase }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            @if ($value->nombre_fase == 'Finalizado' || $value->nombre_fase == 'Suspendido')
            <td>{{ $value->anho }}</td>
            @else
            <td>El proyecto no se ha cerrado</td>
            @endif
            @if ($value->nombre_fase == 'Finalizado' || $value->nombre_fase == 'Suspendido')
            <td>{{ $value->mes }}</td>
            @else
            <td>El proyecto no se ha cerrado</td>
            @endif
            <td>{{ $value->trl_esperado }}</td>
            <td>{{ $value->trl_obtenido }}</td>
            <td>{{ $value->fabrica_productividad }}</td>
            <td>{{ $value->reci_ar_emp }}</td>
            <td>{{ $value->economia_naranja }}</td>
            <td>{{ $value->tipo_economianaranja }}</td>
            <td>{{ $value->dirigido_discapacitados }}</td>
            <td>{{ $value->tipo_discapacitados }}</td>
            <td>{{ $value->art_cti }}</td>
            <td>{{ $value->nom_act_cti }}</td>
            <td>{{ $value->diri_ar_emp }}</td>

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
