<table>
    <thead>
    <tr>
        <th>Código de la Edt</th>
        <th>Nombre</th>
        <th>Tipo de Edt</th>
        <th>Área de Conocimiento</th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Cierre</th>
        <th>Experto</th>
        <th>Observaciones</th>
        <th>Empleados</th>
        <th>Instructores</th>
        <th>Aprendices</th>
        <th>Público</th>
        <th>Fotografías</th>
        <th>Listado de Asistencia</th>
        <th>Informe Final</th>
    </tr>
    </thead>
    <tbody>
        @foreach($edts as $value)
        <tr>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->nombre_tipoedt }}</td>
            <td>{{ $value->nombre_areaconocimiento }}</td>
            <td>{{ $value->fecha_inicio }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->observaciones }}</td>
            <td>{{ $value->empleados }}</td>
            <td>{{ $value->instructores }}</td>
            <td>{{ $value->aprendices }}</td>
            <td>{{ $value->publico }}</td>
            <td>{{ $value->fotografias == 1 ? 'Si' : 'No' }}</td>
            <td>{{ $value->listado_asistencia == 1 ? 'Si' : 'No' }}</td>
            <td>{{ $value->informe_final == 1 ? 'Si' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
