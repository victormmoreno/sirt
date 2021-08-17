<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Experto a cargo</th>
        <th>Línea Tecnológica</th>
        <th>Código de la actividad</th>
        <th>Nombre</th>
        <th>Grupo de Investigación</th>
        <th>Fecha de inicio de la articulación</th>
        <th>Fase actual de la articulación</th>
        <th>Fecha de cierre de la articulación</th>
        <th>Productos a alcanzar</th>
    </tr>
    </thead>
    <tbody>
        @foreach($articulaciones as $value)
            <tr>
            <td>{{ $value->nodo }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->nombre_linea }}</td>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->grupo }}</td>
            <td>{{ $value->fecha_inicio }}</td>
            <td>{{ $value->nombre_fase }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            <td>{{ $value->producto_a_alcanzar == null ? 'No hay información disponible' : $value->producto_a_alcanzar }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
