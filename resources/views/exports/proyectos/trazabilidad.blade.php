<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Experto/a a cargo</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Código del Proyecto</th>
        <th>Nombre</th>
        <th>¿Rol?</th>
        <th>¿Quien?</th>
        <th>¿Qué?</th>
        <th>¿Fase?</th>
        <th>¿Cuando?</th>
    </tr>
    </thead>
    <tbody>
        @for ($i=0; $i < count($historial) ; $i++)
        <tr>
            <td>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</td>
            <td>{{ $proyecto->articulacion_proyecto->actividad->gestor->user->present()->userFullName() }}</td>
            <td>{{ $proyecto->sublinea->linea->nombre }}</td>
            <td>{{ $proyecto->sublinea->nombre }}</td>
            <td>{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</td>
            <td>{{ $proyecto->articulacion_proyecto->actividad->nombre }}</td>
            <td>{{ $historial[$i]->rol }}</td>
            <td>{{ $historial[$i]->usuario }}</td>
            <td>{{ $historial[$i]->movimiento }}</td>
            <td>{{ $historial[$i]->fase }}</td>
            <td>{{ $historial[$i]->created_at }}</td>
          </tr>        
        @endfor
    </tbody>
</table>
