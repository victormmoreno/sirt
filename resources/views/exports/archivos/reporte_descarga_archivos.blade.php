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
            @php
                $color = null;
                if ($item['cantidad_archivos'] == 0) {
                    $color = '#da9694';
                } else if ($item['cantidad_archivos'] == 1) {
                    $color = '';
                } else {
                    $color = '#ffca28';
                }
            @endphp
            <td style="background-color: {{$color}}">{{ $item['nodo'] }}</td>
            <td style="background-color: {{$color}}">{{ $item['linea'] }}</td>
            <td style="background-color: {{$color}}">{{ $item['codigo'] }}</td>
            <td style="background-color: {{$color}}">{{ $item['cantidad_archivos'] }}</td>
            <td style="background-color: {{$color}}">{{ $item['nombre_archivos'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
