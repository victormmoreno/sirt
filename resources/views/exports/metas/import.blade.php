<table>
    <thead>
        <tr>
            <th>Tecnoparque</th>
            <th>Articulaciones</th>
            <th>Meta de trl6</th>
            <th>Meta de trl7 y trl8</th>
            <th>Metas PBTs finalizados</th>
        </tr>
    </thead>
    <tbody>
        @forelse($metas as $meta)
        <tr>
            <td>
                {{$meta->nodo}}
            </td>
            <td>
                {{$meta->articulaciones}}
            </td>
            <td>
                {{$meta->trl6}}
            </td>
            <td>
                {{$meta->trl7_trl8}}
            </td>
            <td>
                {{$meta->metas_pbts_finalizados}}
            </td>
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
