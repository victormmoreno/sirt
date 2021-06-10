<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Nodo del Proyecto</th>
        <th>Código del Grupo de Investigación</th>
        <th>Nombre del Grupo de Investigación</th>
        <th>Tipo de Grupo de Investigación</th>
        <th>Institucion que lo avala</th>
        <th>Clasificación de Colciencias</th>
        <th>Email del Grupo de Investigación</th>
        <th>Ciudad</th>
    </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $proyecto)
            @foreach ($proyecto->gruposinvestigacion as $grupo)
                <tr>
                    <td>{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</td>
                    <td>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</td>
                    <td>{{ $grupo->codigo_grupo }}</td>
                    <td>{{ $grupo->entidad->nombre }}</td>
                    <td>{{ $grupo->present()->grupoTipo() }}</td>
                    <td>{{ $grupo->institucion }}</td>
                    <td>{{ $grupo->clasificacioncolciencias->nombre }}</td>
                    <td>{{ $grupo->entidad->email_entidad }}</td>
                    <td>{{ $grupo->entidad->ciudad->nombre }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
