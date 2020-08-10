<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Código de la Articulación</th>
        <th>Nombre</th>
        <th>Tipo de Articulación</th>
        <th>Articulación con: </th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Cierre</th>
        <th>Nodo</th>
        <th>Gestor</th>
        <th>Formato de Confidencialida y Compromiso</th>
        <th>Acta de Cierre</th>
        <th>Informe Final de la Asesoria</th>
    </tr>
    </thead>
    <tbody>
    @foreach($articulaciones as $value)
        <tr>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->nombre_tipoarticulacion }}</td>
            <td>{{ $value->tipo_articulacion }}</td>
            <td>{{ $value->fecha_inicio->toDateString() }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            <td>{{ $value->nombre_nodo }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->acc }}</td>
            <td>{{ $value->acta_cierre }}</td>
            <td>{{ $value->informe_final }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
