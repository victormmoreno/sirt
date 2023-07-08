<table>
    <thead>
    <tr>
        <th>Tecnoparque</th>
        <th>Meta de PBTs finalizados</th>
        <th>Articulaciones</th>
        <th>Meta de TRL6</th>
        <th>Meta de TRL7 y TRL8</th>
        <th>Proyectos activos del nodo (Inicio, Planeación, Ejecución y Cierre)</th>
    </tr>
    </thead>
    <tbody>
        <tr></tr>
        @foreach($metas as $key => $meta)
        <tr>
            <td>{{ $meta->nodo }}</td>
            <td>{{ $meta->trl6 + $meta->trl7_trl8 }}</td>
            <td>{{ $meta->articulaciones }}</td>
            <td>{{ $meta->trl6 }}</td>
            <td>{{ $meta->trl7_trl8 }}</td>
            <td>{{ $meta->activos }}</td>
            @foreach ($meta->meses_trl6 as $item)
                <td>{{ array_values($item)[0] }}</td>
            @endforeach
            @foreach ($meta->meses_trl7_trl8 as $item)
                <td>{{ array_values($item)[0] }}</td>
                @endforeach
            <td>=SUM(G{{$key+3}}:AD{{$key+3}})</td>
        </tr>
        @endforeach
    </tbody>
</table>
