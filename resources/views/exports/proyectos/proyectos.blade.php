<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Experto/a a cargo</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Idea de Proyecto</th>
        <th>Código del Proyecto</th>
        <th>Nombre</th>
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
        <th>Empresas dueñas de la propiedad intelectual</th>
        <th>Grupos de investigación dueños de la propiedad intelectual</th>
        <th>Personas dueñas de la propiedad intelectual</th>
    </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $proyecto)
        <tr>
            <td>{{ $proyecto->nombre_nodo }}</td>
            <td>{{ $proyecto->experto }}</td>
            <td>{{ $proyecto->nombre_linea }}</td>
            <td>{{ $proyecto->nombre_sublinea }}</td>
            <td>{{ $proyecto->codigo_idea }} - {{ $proyecto->nombre_idea }}</td>
            <td>{{ $proyecto->codigo_proyecto }}</td>
            <td>{{ $proyecto->nombre_proyecto }}</td>
            <td>{{ $proyecto->nombre_area_conocimiento }}</td>
            <td>{{ $proyecto->nombre_area_conocimiento == 'Otro' ? $proyecto->otro_areaconocimiento : 'No aplica' }}</td>
            <td>{{ $proyecto->fecha_inicio }}</td>
            <td>{{ $proyecto->nombre_fase }}</td>
            <td>{{ $proyecto->nombre_fase == 'Suspendido' || $proyecto->nombre_fase == 'Finalizado' ? $proyecto->fecha_cierre : 'El proyecto no se ha cerrado' }}</td>

            @if ($proyecto->nombre_fase == 'Finalizado' || $proyecto->nombre_fase == 'Suspendido')
                <td>{{ $proyecto->anho }}</td>
            @else
                <td>El proyecto no se ha cerrado</td>
            @endif

            @if ($proyecto->nombre_fase == 'Finalizado' || $proyecto->nombre_fase == 'Suspendido')
                <td>{{ $proyecto->mes }}</td>
            @else
                <td>El proyecto no se ha cerrado</td>
            @endif

            <td>{{ $proyecto->trl_esperado }}</td>
            <td>{{ $proyecto->trl_obtenido }}</td>
            <td>{{ $proyecto->fabrica_productividad }}</td>
            <td>{{ $proyecto->reci_ar_emp }}</td>
            <td>{{ $proyecto->economia_naranja }}</td>
            <td>{{ $proyecto->tipo_economianaranja }}</td>
            <td>{{ $proyecto->dirigido_discapacitados }}</td>
            <td>{{ $proyecto->tipo_discapacitados }}</td>
            <td>{{ $proyecto->art_cti }}</td>
            <td>{{ $proyecto->nom_act_cti }}</td>
            <td>{{ $proyecto->diri_ar_emp }}</td>
            <td>
                {{ $proyecto->empresas }}
            </td>
            <td>
                {{ $proyecto->grupos }}
            </td>
            <td>
                {{ $proyecto->personas }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
