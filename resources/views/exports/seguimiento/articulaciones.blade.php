<table>
    <thead>
    <tr>
        <th>Código de la Articulación</th>
        <th>Nombre de la Articulación</th>
        <th>Tipo de Articulación</th>
        <th>Articulación con: </th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Cierre</th>
        <th>Experto</th>
        <th>Observaciones</th>
        <th>Formato de Confidencialida y Compromiso</th>
        <th>Acta de Cierre</th>
        <th>Informe Final de la Asesoria</th>
        <th>Encuenta de Satisfacción (Pantallazo)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($articulaciones as $value)
        <tr>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->nombre_tipoarticulacion }}</td>
            <td>{{ $value->tipo_articulacion }}</td>
            <td>{{ $value->fecha_inicio }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->observaciones }}</td>
            <td>{{ $value->acc == 1 ? 'Si' : 'No' }}</td>
            <td>{{ $value->acta_cierre == 1 ? 'Si' : 'No' }}</td>
            <td>{{ $value->informe_final == 1 ? 'Si' : 'No' }}</td>
            <td>{{ $value->pantallazo == 1 ? 'Si' : 'No' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
