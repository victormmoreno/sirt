<table>
    <thead>
        <tr>
            <th>Nodo</th>
            <th>Línea Tecnológica</th>
            <th>Codigo</th>
            <th>Archivos descargados</th>
            <th>Nombre de los archivos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reporte as $key => $item)
            <tr>
                @php
                    $color = null;
                    if ($item['cantidad_archivos'] == 0) {
                        $color = '#da9694';
                    } elseif ($item['cantidad_archivos'] == 1) {
                        $color = '';
                    } else {
                        $color = '#ffca28';
                    }
                @endphp
                <td style="background-color: {{ $color }}">{{ $item['nodo'] }}</td>
                @if (isset($item['linea']))
                    <td style="background-color: {{ $color }}">{{ $item['linea'] }}</td>
                @else
                    <td style="background-color: {{ $color }}">No Aplica</td>
                @endif
                <td style="background-color: {{ $color }}">{{ $item['codigo'] }}</td>
                <td style="background-color: {{ $color }}">{{ $item['cantidad_archivos'] }}</td>
                <td style="background-color: {{ $color }}">{{ $item['nombre_archivos'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>