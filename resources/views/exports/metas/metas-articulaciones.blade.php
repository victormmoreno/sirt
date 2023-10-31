<table>
    <thead>
    <tr>
        <th>Tecnoparque</th>
        <th>Meta de Articulaciones generadas</th>
        <th>Total de Articulaciones en Inicio</th>
        <th>Total de Articulaciones en Ejecución</th>
        <th>Total de Articulaciones en Cerradas</th>
        <th>Total de Articulaciones Canceladas del nodo</th>
    </tr>
    </thead>
    <tbody>
        <tr></tr>
        @foreach($metas as $key => $meta)
        <tr>
            <td>{{ $meta->nodo }}</td>
            <td>{{ $meta->articulaciones }}</td>
            <td>{{ $meta->count_articulation_start }}</td>
            <td>{{ $meta->count_articulation_execution }}</td>
            <td>{{ $meta->count_articulation_closing }}</td>
            <td>{{ $meta->count_articulation_canceled }}</td>
        
            @foreach ($meta->month_articulation_finish as $item)
                <td>{{ array_values($item)[0] }}</td>
            @endforeach
            <td>{{$meta->progreso_total}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
