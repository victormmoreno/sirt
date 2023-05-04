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
        @foreach($grupos as $grupo)
        <tr>
            <td>{{ $grupo->codigo_proyecto }}</td>
            <td>{{ $grupo->nombre_nodo }}</td>
            <td>{{ $grupo->codigo_grupo }}</td>
            <td>{{ $grupo->nombre_grupo }}</td>
            <td>{{ $grupo->tipogrupo }}</td>
            <td>{{ $grupo->institucion_grupo }}</td>
            <td>{{ $grupo->nombre_clasificacion }}</td>
            <td>{{ $grupo->email_grupo }}</td>
            <td>{{ $grupo->ciudad_grupo }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
