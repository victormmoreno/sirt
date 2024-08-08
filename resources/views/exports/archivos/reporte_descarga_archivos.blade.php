<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Línea Tecnológica</th>
        <th>Nodo</th>
        <th>Archivos descargados</th>
        <th>Nombre de los archivos</th>
    </tr>
    </thead>
    <tbody>
        @foreach($reporte as $key => $item)
        <tr>
            <td>{{ $item['nodo'] }}</td>
            <td>{{ $item['linea'] }}</td>
            <td>{{ $item['codigo'] }}</td>
            <td>{{ $item['cantidad_archivos'] }}</td>
            <td>{{ $item['nombre_archivos'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
