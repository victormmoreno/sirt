<table>
    <thead>
    <tr>
        <th>Código de la Articulación</th>
        <th>Nombre</th>
        <th>Tipo de Articulación</th>
        <th>Articulación con: </th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Cierre</th>
        <th>Experto</th>
        <th>Formato de Confidencialida y Compromiso</th>
        <th>Acta de Cierre</th>
        <th>Informe Final de la Asesoria</th>
    </tr>
    </thead>
    <tbody>
    @foreach($articulacion as $value)
        <tr>
            <td>{{ $value->codigo_articulacion }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->tipoarticulacion }}</td>
            <td>{{ $value->tipo_articulacion }}</td>
            <td>{{ $value->fecha_inicio->toDateString() }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            <td>{{ $value->nombre_completo_gestor }}</td>
            <td>{{ $value->acc }}</td>
            <td>{{ $value->acta_cierre }}</td>
            <td>{{ $value->informe_final }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
