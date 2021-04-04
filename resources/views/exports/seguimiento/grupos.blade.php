
<table>
    <thead>
    <tr>
        <th>Código de Proyecto/Articulacion</th>
        <th>Código del Grupo de Investigación</th>
        <th>Nombre del Grupo de Investigación</th>
        <th>Institucion que avala</th>
    </tr>
    </thead>
    <tbody>
        @foreach($grupos as $value)
            <tr>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->codigo_grupo }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->institucion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
